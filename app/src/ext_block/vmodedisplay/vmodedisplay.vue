<template>
  <div class="v-mode-display">
    <div v-for="(configMode, typeMode) in editorData.modes">
      <div style="padding-top: 5px; padding-bottom: 5px;">
        <el-checkbox v-model="configMode.checked" @change="onChangeMode(typeMode, $event)" :label="modeConfigs[typeMode].label"></el-checkbox>
        <el-card v-if="configMode.checked">
          <div style="padding: 5px">
            <div><span>Подпись:</span></div>
            <el-input placeholder="Подпись:" v-model="configMode.label"></el-input>
          </div>
          <div style="padding: 5px">
            <div>
              <div>Количество элементов на странице (0 - без ограничений):</div>
            </div>
            <el-input-number v-model="configMode.limitOnPage" controls-position="right" :min="0" :max="50"></el-input-number>
          </div>
        </el-card>
      </div>
    </div>

    <div style="padding-top: 5px; padding-bottom: 5px;">
      <div>
        Отображение по умолчанию:
      </div>
      <el-select v-model="editorData.defaultMode" placeholder="Выберите отображение по умолчанию:">
        <el-option
            v-for="modeCode in checkedModes"
            :key="modeCode"
            :label="modeConfigs[modeCode].label"
            :value="modeCode">
        </el-option>
      </el-select>
    </div>
  </div>
</template>

<script>

export default {
  components:{  },
  name: "vmodedisplay",
  props: {
    value: {
      type: Object,
    }
  },
  computed: {
    checkedModes: function () {
      let that = this;
      return Object.keys(this.editorData.modes).filter(function (typeMode) {
        return that.editorData.modes[typeMode].checked;
      })
    }
  },
  data(){
    return {
      editorData: {
        modes: {
          grouped: {
            checked:  false,
            label: '',
            limitOnPage: 0
          },
          all: {
            checked:  false,
            label: '',
            limitOnPage: 0
          }
        },
        defaultMode: ''
      },
      modeConfigs: {
        grouped: {
          label: 'Группировать'
        },
        all: {
          label: 'Все'
        }
      }
    }
  },
  methods: {
    onChangeMode: function (typeMode, value) {
      if (value) {
        if (Object.values(this.checkedModes).length === 1) {
          this.editorData.defaultMode = typeMode;
        }
      } else {
        this.editorData.modes[typeMode].label = '';
        this.editorData.modes[typeMode].limitOnPage = 0;
        if (this.editorData.defaultMode === typeMode) {
          this.editorData.defaultMode = this.checkedModes[0] ?? '';
        }
      }
    }
  }
}
</script>

