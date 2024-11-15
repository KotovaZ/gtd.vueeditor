<template>
  <el-card id="el-container" style="margin: auto">
    <el-row class="main-row">
      <el-col class="content-wrapper" :span="21">
        <input type="hidden" :value='formData' :name="inputName">
        <draggable :class="draggableClass" handle=".handle" :key="uniqueKey" v-model="result"
                   :group="{ name: 'block', pull: 'clone' }" @start="startDrag" @end="endDrag" @add="onAdd">
          <vcomponent :key="i" v-for="(block, i) in result" :block="block" :config="config(block)"
                      @handle-action="action => { handleBlockCommand(action, i) }" @on-delete="() => deleteBlock(i)"
                      @on-move="(d) => move(i, d)">
          </vcomponent>
        </draggable>
      </el-col>

      <el-col class="add-block-wrapper" :span="3">
        <div v-if="showPatterns">
          <div slot="reference" class="add-block-btn handle" @click="() => { drawer = !drawer; }">
            <span class="add-block-text"><b>Шаблоны</b></span>
          </div>
        </div>
        <draggable :class="draggableClass" @start="onStartDrag" handle=".handle"
                   :group="{ name: 'block', pull: 'clone' }"
                   :forceFallback="true">
          <div v-for="block in availableBlock">
            <el-popover v-if="block.about" :open-delay="1000" placement="right" width="400" trigger="hover">
              <el-image style="width: 400px; height: 400px" :src="block.about.img" fit="fill"></el-image>
              <div slot="reference" class="add-block-btn" @click="addBlock(block)">
                <span class="add-block-text">{{ block.label }}</span>
              </div>
            </el-popover>
            <div v-else slot="reference" class="add-block-btn handle" @click="addBlock(block)">
              <span class="add-block-text">{{ block.label }}</span>
            </div>
          </div>

        </draggable>
        <patterns v-if="showPatterns" :opened="drawer" @on-close="() => { drawer = false }"></patterns>
      </el-col>
    </el-row>
    <el-dialog v-loading="preset.loading" title="Выбор пресета" :visible.sync="preset.openDialog">
      <el-table @row-click="presetSelect" :data="preset.presetList">
        <el-table-column property="title" label="Заголовок"></el-table-column>
        <el-table-column property="created" label="Создана"></el-table-column>
        <el-table-column property="user" label="Создал"></el-table-column>
      </el-table>
    </el-dialog>
  </el-card>
</template>

<script>
import draggable from 'vuedraggable';
import patterns from './patterns.vue';
import vcomponent from './component/vcomponent.vue';
import axios from 'axios';
import { v4 as uuidv4 } from 'uuid';

import { store } from './store.js'


export const baseComponents = { draggable, patterns, vcomponent };

export default {
  name: "hello",
  components: baseComponents,
  data() {
    return {
      containerTop: 0,
      drag: false,
      uniqueKey: 100,
      preset: {
        loading: false,
        openDialog: false,
        currentIndex: 0,
        presetList: [],
      },
      selected: '',
      inputName: '',
      result: [],
      allowBlock: [],
      patterns: [],
      drawer: false,
    }
  },
  methods: {
    config(block) {
      let blockConfig = this.availableBlock.find((b) => {
        return b.value === block.type;
      })

      return blockConfig?.config
    },
    handleBlockCommand(a, i) {
      a.index = i;
      if (a.action == 'save') {
        this.savePreset(a.index);
      }
      if (a.action == 'load') {
        this.loadPresetList(a.index);
      }
    },
    loadPresetList(i) {
      this.preset.currentIndex = i;
      let block = this.result[i].type
      this.preset.loading = true;
      axios.get('/local/modules/gtd.vueeditor/service/preset.php?action=list&block=' + block)
        .then(res => {
          this.preset.presetList = res.data.result;
          this.preset.openDialog = true;
          this.preset.loading = false;
        })
    },
    presetSelect(r, c, e) {
      this.result[this.preset.currentIndex].data = r.data;
      this.forceRender();
      this.preset.openDialog = false;
    },
    forceRender() {
      this.uniqueKey = new Date().getMilliseconds();
    },
    savePreset(i) {
      this.$prompt('Введите название', 'Запись', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        inputErrorMessage: 'не верное название'
      }).then(({ value }) => {
        axios.post('/local/modules/gtd.vueeditor/service/preset.php?action=save', {
          'title': value,
          'block': this.result[i].type,
          'data': this.result[i].data
        }).then(res => {
          this.$message({
            type: 'success',
            message: 'Пресет записан:' + value
          });
        })
      });
    },
    deleteBlock(i) {
      this.result.splice(i, 1);
      this.forceRender();
    },
    addBlock(block) {
      let blueprint = {
        name: block.label,
        type: block.value,
        patternDisplay: '',
        code: '',
        data: {}
      }
      this.result.push(blueprint);
    },
    move(i, direction) {
      if (direction > 0 && i > 0) {
        this.moveUp(i);
      }

      if (direction < 0 && i < this.result.length - 1) {
        this.moveDown(i);
      }
    },
    moveUp(i) {
      const current = this.result[i];
      const next = this.result[i - 1];
      this.result[i - 1] = current;
      this.result[i] = next;
      this.forceRender();
      this.result.splice(i - 1, 1, current);
      this.result.splice(i, 1, next);
    },
    moveDown(i) {
      const current = this.result[i];
      const next = this.result[i + 1];
      this.result[i + 1] = current;
      this.result[i] = next;
      this.forceRender();
      this.result.splice(i + 1, 1, current);
      this.result.splice(i, 1, next);
    },
    startDrag() {
      this.drag = true;
    },
    endDrag(e) {
      this.drag = false;
      this.forceRender();
    },
    onAdd(event) {
      if (store.draggableObject.type === 'component') {
        const block = store.draggableObject.target;
        let blueprint = {
          name: block.config.name,
          type: block.componentName,
          patternDisplay: '',
          code: '',
          data: {}
        }
        this.addComponent(blueprint, event.newIndex)
      }

      if (store.draggableObject.type === 'pattern') {
        const pattern = store.draggableObject.target;
        pattern.constructor.forEach((block, i) => {
          block.pattern = {
            name: pattern.name,
            code: pattern.code
          }
          this.addComponent(block, event.newIndex + i)
        })
      }

      this.forceRender();
    },
    addComponent(blueprint, index) {
      if (!blueprint.hasOwnProperty('guid')) {
        blueprint.guid = uuidv4();
      }

      this.result.splice(index, 0, blueprint);
      this.drag = false;
    },
    onStartDrag(event) {
      const block = BLOCK.find(block => event.item.outerText === block.config.name);
      store.setDraggable(block, 'component');
    }
  },
  mounted() {
    this.result = this.$root.$data.val || [];
    this.allowBlock = this.$root.$data.allowBlocks;
    this.inputName = this.$root.$data.inputName;
    this.containerTop = this.$el.getBoundingClientRect().top;
  },
  watch: {
    result: {
      handler: function (value) {
        if (typeof this.$root.callback === "function") {
          this.$root.callback(this.result);
        }
      },
      deep: true
    }
  },
  computed: {
    showPatterns() {
      return this.$root.$data.showPatterns;
    },
    formData() {
      return JSON.stringify(this.result);
    },
    availableBlock() {
      let blocks = [];
      BLOCK.forEach(b => {
        if (this.allowBlock.includes(b.componentName))
          blocks.push({
            label: b.config.name,
            value: b.componentName,
            about: b.config.conf.about,
            config: b.config.conf
          })
      })
      return blocks;
    },
    draggableClass() {
      return {
        'drag-start': this.drag
      }
    }
  }
}
</script>
<style>
.block-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: -6px;
}

.block-action {
  cursor: pointer;
  margin-left: 12px;
  align-self: center;
}

.block-header {
  opacity: 1;
  transition: opacity 600ms;
}

.block-header-name {
  margin-top: 0px;
}

.block-wrapper:hover .block-header {
  opacity: 1;
}

.delete-btn {
  display: block;
  right: 8px;
  font-size: 16px;
  top: -5px;
}

.delete-btn:hover {
  color: red;
}

.block-wrapper {
  margin-bottom: 20px;
}

.add-block-wrapper {
  padding-left: 20px;
  padding-right: 0;
}

.content-wrapper {
  min-height: 200px;
  border-right: 1px solid #f3f3f3;
  padding-right: 36px;
}

.adm-workarea textarea.el-textarea__inner {
  box-shadow: none;
  font-size: inherit;
  color: #606266;
  background-color: #FFF;
  background-image: none;
  border: 1px solid #DCDFE6;
  border-radius: 4px;
  -webkit-transition: border-color .2s cubic-bezier(.645, .045, .355, 1);
  transition: border-color .2s cubic-bezier(.645, .045, .355, 1);
}

.adm-workarea .el-input__inner {
  -webkit-appearance: none !important;
  background-color: #FFF !important;
  background-image: none !important;
  border-radius: 4px !important;
  border: 1px solid #DCDFE6 !important;
  -webkit-box-sizing: border-box !important;
  box-sizing: border-box !important;
  color: #606266 !important;
  display: inline-block !important;
  font-size: inherit !important;
  height: 40px !important;
  line-height: 40px !important;
  outline: 0 !important;
  padding: 0 15px !important;
  -webkit-transition: border-color .2s cubic-bezier(.645, .045, .355, 1) !important;
  transition: border-color .2s cubic-bezier(.645, .045, .355, 1) !important;
  width: 100% !important;
  box-shadow: none !important;
  opacity: 1 !important;
}

adm-workarea .el-input--mini input.el-input__inner {
  height: 28px;
  line-height: 28px;
}

.main-row {
  width: 100%;
}

.add-block-btn {
  border: 1px solid #c9e7f9;
  border-radius: 3px;
  padding: 7px 10px;
  cursor: pointer;
  position: relative;
  margin-bottom: 8px;
  box-shadow: 0px 2px 3px 0px #efebeb6b;
  transition: transform 300ms ease-out 100ms;
}

.add-block-btn:hover {
  transform: translateX(-5px);
}

.add-block-btn:after {
  content: '+';
  position: absolute;
  right: 4px;
  top: calc(50% - 7px);
}

.add-block-text {
  word-break: break-word;
}

.el-upload .adm-input-file {
  display: none !important;
}

/*.drag-start .block-wrapper{*/
/*  height: 40px;*/
/*}*/
/*.drag-start .block-wrapper.sortable-chosen{*/
/*  height: 40px;*/
/*  background: #f8f8f8;*/
/*}*/

.block-params-edit {
  padding: 5px;
}

.block-params-edit .block-param-edit {
  padding: 8px 0;
}

.block-params-edit .block-param-name {
  margin: 0 0 10px 0;
}

.block-params-edit .block-param-name .el-divider__text {
  padding: 5px;
  font-size: 12px;
}

.block-params-edit .block-param-name .el-divider__text.is-left {
  left: 10px;
}
</style>
