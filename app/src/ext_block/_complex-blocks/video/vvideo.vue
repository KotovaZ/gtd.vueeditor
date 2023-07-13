<template>
  <div>
    <el-row :gutter="24" class="v-video__block-actions">
      <el-col :span="12">
        <el-upload action="/local/modules/gtd.vueeditor/service/upload_image.php" list-type="text"
                   :on-success="addPreview"
                   :on-remove="removePreview">
          <el-button size="small" plain icon="el-icon-plus">Загрузить превью</el-button>
        </el-upload>
      </el-col>
      <el-col :span="12">
        <el-upload action="/local/modules/gtd.vueeditor/service/upload_file.php" list-type="text"
                   :on-success="addVideo"
                   :on-remove="removeVideo">
          <el-button size="small" plain icon="el-icon-plus">Загрузить видео</el-button>
        </el-upload>
      </el-col>
    </el-row>

    <el-row v-if="isVideoLoaded">
      <el-col :gutter="20">
        <video :src="editorData.video.src" :poster="videoPreviewSrc" @loadedmetadata="onLoadedMetaData"
               width="100%" controls="controls" class="vvideo" ref="video">
        </video>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "v-video",
  components: {},
  props: ['value'],
  model: {
    prop: 'value',
    event: 'change'
  },
  computed: {
    isPreviewLoaded: function () {
      return this.editorData && this.editorData.preview !== null;
    },
    isVideoLoaded: function () {
      return this.editorData && this.editorData.video;
    },
    videoPreviewSrc: function () {
      return this.editorData && !!this.editorData.preview ? this.editorData.preview.src : '';
    },
  },
  data() {
    return {
      editorData: {
        preview: null,
        video: null
      }
    };
  },
  methods: {
    addPreview(res) {
      if (this.editorData.preview)
        this.deleteItem(this.editorData.preview.id);

      this.editorData = {
        ...this.editorData, preview: {
          id: res.id,
          src: res.src
        }
      };

      this.$emit('change', this.editorData);
    },
    addVideo(res) {
      if (this.editorData.video)
        this.deleteItem(this.editorData.video.id);

      this.editorData = {
        ...this.editorData, video: {
          id: res.id,
          src: res.src
        }
      };

      this.$emit('change', this.editorData);
    },
    removeVideo() {
      this.deleteItem(this.editorData.video.id);
      this.editorData = {
        ...this.editorData, video: null
      };
    },
    removePreview() {
      this.deleteItem(this.editorData.preview.id);
      this.editorData = {
        ...this.editorData, preview: null
      };
    },
    deleteItem(fileId) {
      axios.get('/local/modules/gtd.vueeditor/service/delete_file.php?id=' + fileId)
        .then(res => {})
    },
    onLoadedMetaData() {
      this.$emit('loadedmetadata', true);
    }
  },
  async created() {
    this.editorData = this.value ?? {
      preview: null,
      video: null
    };
  }

}
</script>

<style scoped>
.vvideo {
  border-radius: 4px;
}

.v-video__block-actions {
  display: flex;
  width: 100%;
  align-items: flex-start;
  margin-bottom: 10px;
  justify-content: flex-start;
}

.v-video__block-actions>div {
  margin-right: 10px;
}
</style>