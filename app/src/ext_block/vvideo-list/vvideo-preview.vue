<template>
  <div class="v-video-preview">
    <el-card shadow="hover">
      <div class="v-video-preview__image">
        <img v-if=previewImageSrc :src="previewImageSrc" alt="">
        <div class="v-video-preview__empty-image" v-else>
          <svg width="50" height="50" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="96" height="96" rx="48" fill="#777777"/>
            <path d="M38 60.2939V35.7061C38 34.9421 38.822 34.4603 39.4886 34.8336L61.442 47.1275C62.1238 47.5093 62.1238 48.4907 61.4419 48.8725L39.4886 61.1664C38.822 61.5397 38 61.0579 38 60.2939Z" fill="white"/>
          </svg>
        </div>
      </div>
      <div class="v-video-preview__description" v-if="description">
        <div v-for="(value, name) in description">
          <b>{{ name }}:</b> {{ value }}
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>


export default {
  name: "vvideo-preview",
  components: { },
  props: {
    value: {
      type: Object,
      default: function () {
        return {
          items: []
        }
      }
    }
  },
  data() {
    return {};
  },
  computed: {
    previewImageSrc: function () {
      return this.value?.preview?.src
    },
    description: function () {
      let description = {};
      if (this.value.description) {
        if (this.value.description.name) {
          description['Наименование'] = this.value.description.name;
        }
      }

      return description;
    }
  },
  methods: {}
}
</script>

<style>
.v-video-preview {
  cursor: pointer;
}
.v-video-preview .v-video-preview__empty-image {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  color: rgba(89, 90, 94, 0.99);
}
.v-video-preview .v-video-preview__image {
  width: 200px;
  height: 200px;
  border: 1px solid rgba(0,0,0,.1);
  border-radius: 5px;
}
.v-video-preview .v-video-preview__image img {
  width: 100%;
  height: 100%;
}
.v-video-preview .v-video-preview__description {
  padding-top: 5px;
  width: 200px;
 }
</style>