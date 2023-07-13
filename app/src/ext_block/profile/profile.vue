<template>
  <div class="ve-profile">
    <div>
      <el-upload
          class="avatar-uploader"
          action="/local/modules/gtd.vueeditor/service/upload_image.php"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
      >
        <div v-if="editorData.avatar.src" class="avatar-wrap">
          <img :src="editorData.avatar.src" class="avatar">
          <i class="el-icon-delete avatar-uploader-icon avatar-remove" @click.stop="handleAvatarRemove"></i>
        </div>
        <i v-else slot="default" class="el-icon-plus avatar-uploader-icon"></i>
      </el-upload>
    </div>
    <div>
      <el-input class="ve-profile-field" placeholder="ФИО" v-model="editorData.name"></el-input>
      <el-input class="ve-profile-field" placeholder="Должность" v-model="editorData.position"></el-input>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "profile",
    components: { },
    props: { },
    computed: { },
    data() {
        return {
            editorData: {
              avatar: {
                id: '',
                src: ''
              },
              name: '',
              position: ''
            },

        };
    },
    methods: {
      handleAvatarRemove() {
        let fileId = this.editorData.avatar.id;
        axios.get('/local/modules/gtd.vueeditor/service/delete_file.php?id=' + fileId)
            .then(res => {
              this.editorData.avatar.id = '';
              this.editorData.avatar.src = '';
            })
      },
      handleAvatarSuccess(res) {
        this.editorData.avatar.id = res.id;
        this.editorData.avatar.src = res.src;
      },
    },

}
</script>

<style>
.ve-profile {
  display: flex;
  align-items: center;
}
.ve-profile .ve-profile-field {
  padding: 5px;
}
.ve-profile .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 40px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
.ve-profile .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
.ve-profile .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 80px;
    height: 80px;
    border-radius: 40px;
    line-height: 80px;
    text-align: center;
  }
.ve-profile .avatar {
    width: 80px;
    height: 80px;
    border-radius: 40px;
    display: block;
  }
.ve-profile .avatar-wrap {
    position: relative;
  }
.ve-profile .avatar-wrap .avatar-remove {
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgb(0,0,0,.5);
    opacity: 0;
    color: #fff;
  }
.ve-profile .avatar-wrap:hover .avatar-remove {
    opacity: 1;
  }
</style>