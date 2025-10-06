<template>
  <div>
    <el-card  shadow="hover" v-for="(item, i) in editorData" :key="i" style="margin-bottom: 20px; position: relative">
      <span class="deleteFile" @click="deleteFile(i)"><i class="el-icon-close"></i></span>
      <el-row :gutter="20">
        <el-col :span="4" class="file-icon-wrapper">
          <div :class="fileIconClass(fileExt(item.file.originalName))">
            <div class="fi-content">{{fileExt(item.file.originalName)}}</div>
          </div>
        </el-col>
        <el-col :span="14">
          <el-row :gutter="20">
            <el-col>
              <span class="file-info">Файл: {{item.file.originalName}}</span>
              <span class="file-info">Размер: {{item.file.size}}</span>
            </el-col>
            <el-col style="margin-bottom: 20px">
              <el-input  placeholder="Название документа" v-model="editorData[i].name"></el-input>
            </el-col>
            <el-col>
              <el-input  placeholder="Описание документа" size="small" v-model="editorData[i].description"></el-input>
            </el-col>
          </el-row>
        </el-col>
      </el-row>
    </el-card>
    <el-upload
        class="upload-demo js-upload"
        action="/local/modules/gtd.vueeditor/service/upload_file.php"
        :before-upload="onBeforeUpload"
        :on-preview="handlePreview"
        :on-remove="handleRemove"
        :before-remove="beforeRemove"
        :on-success="onSuccess"
        multiple
        :show-file-list="true"
        :on-exceed="handleExceed"
    >
      <el-button size="small" type="primary">Загрузить файлы</el-button>
    </el-upload>
  </div>
</template>
<style>
@import url(~css-file-icons/build/css-file-icons.css);
.deleteFile{
  position: absolute;
  right: 10px;
  top: 10px;
  cursor:pointer;
  z-index: 10;
}
.file-info{
  display: block;
  color: #5f5f5f;
  font-size: 10px;
  margin-bottom: 7px;
}
.file-icon-wrapper{
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 42px;
}
</style>
<script>
import axios from "axios";

export default {
  name: "documents",
  data(){
    return {
      editorData:[],
      loadingImagesCount: 0,
    }
  },
  methods: {
    onBeforeUpload() {
      if (this.loadingImagesCount === 0) {
        document.querySelectorAll('.js-upload .el-upload-list.el-upload-list--text .el-upload-list__item').forEach(item => item.remove());
      }
      this.loadingImagesCount++;
    },
    deleteFile(i){
      let file = this.editorData[i].file;
      axios.get('/local/modules/gtd.vueeditor/service/delete_file.php?id=' + file.id)
          .then(res => {
            this.editorData.splice(i, 1);
          })
    },
    fileIconClass(ext){
      let classObj = {fi: true}
      classObj['fi-' + ext] = true;
      return classObj
    },
    fileExt(fileName){
      return fileName.split('.').pop();
    },
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handlePreview(file) {
      console.log(file);
    },
    handleExceed(files, fileList) {
      this.$message.warning(`The limit is 3, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
    },
    beforeRemove(file, fileList) {
      return this.$confirm(`Cancel the transfert of ${ file.name } ?`);
    },
    onSuccess(file){
      this.editorData.push({
        name : '',
        description: '',
        file: file
      });

      this.loadingImagesCount--;
    }
  }
}
</script>

