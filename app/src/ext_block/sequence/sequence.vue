<template>
    <div class="sequence">
      <div class="sequence-controls">
        <div class="color-change">
          <span>Укажите цвет:</span>
          <el-color-picker v-model="editorData.color" :predefine="predefineColors"></el-color-picker>
        </div>
        <el-upload drag action="/local/modules/gtd.vueeditor/service/upload_image.php" multiple :on-success="addItem"
                   :show-file-list="false">
          <i class="el-icon-upload"></i>
          <div class="el-upload__text">Перенесите файлы либо <em>нажмите для загрузки</em></div>
        </el-upload>
      </div>
      <el-radio-group v-model="preview" @change="onChangePreview">
        <draggable v-model="editorData.items" group="gallery" @start="drag = true" @end="drag = false" class="image-list">
          <div v-for="(item, i) in editorData.items">
            <el-card class="image-block" shadow="hover" style="position: relative">
              <div class="sequence-remove"><i @click="deleteItem(i)" class="el-icon-delete"></i></div>
              <el-image :src="item.src" fit="cover"></el-image>
              <div>
                <el-radio :label="item.id">Превью</el-radio>
              </div>
            </el-card>
          </div>
        </draggable>
      </el-radio-group>
    </div>
</template>
  
<script>
import axios from 'axios';
import draggable from 'vuedraggable';

export default {
    components: { draggable },
    name: "sequence",
    watch: {
        value() {
            this.editorData = this.value;
        }
    },
    props: ['value'],
    computed: {
    },
    created: function () {
        this.preview = this.editorData?.preview?.id;
    },
    data() {
        return {
            editorData: {
                color: '',
                preview: {},
                items: []
            },
            predefineColors: [
              '#cc1515',
              '#ffffff',
              '#c4c4c4',
              '#0468CA',
              '#06EEF9',
            ],
            preview: null
        };
    },
    methods: {
        addItem(res) {
            let item = {
                id: res.id,
                src: res.src
            };
            this.editorData.items.push(item);
        },
        deleteItem(i) {
            let fileId = this.editorData.items[i].id;
            axios.get('/local/modules/gtd.vueeditor/service/delete_file.php?id=' + fileId)
                .then(res => {
                    this.editorData.items.splice(i, 1);
                })
        },
        onChangePreview(value) {
          let preview = this.editorData.items.find(function (item) {
            return item.id === value;
          });
          this.$set(this.editorData, 'preview', preview);
        }
    }
}
</script>
  
<style>
.sequence .image-list {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.sequence .color-change {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}
.sequence .color-change > span {
  margin-right: 10px;
}
.sequence .sequence-controls {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}
@media screen and (max-width: 1400px) {
  .sequence .sequence-controls {
    flex-direction: column;
  }
}
.sequence .el-image {
  height: 50px;
}
.sequence .sequence-remove {
  position: absolute;
  top: 5px;
  right: 5px;
  cursor: pointer;
}
.sequence .el-radio-group {
  font-size: 13px;
}
.sequence .el-radio {
  margin-right: 0;
  margin-top: 5px;
}
.sequence .el-radio__label {
  font-size: 12px;
}
.sequence .el-upload-dragger {
  height: 100px;
}
.sequence .el-icon-upload {
  margin-top: 5px;
}
</style>