<template>
  <vVideo :value="editorData" @change="onChange" @loadedmetadata="isLoadedMetaDataVideo = true" ref="video">
    <template #description v-if="editorData.video">
      <vVideoDescription v-model="editorData.description" :videoDOM="videoDOM"></vVideoDescription>
    </template>
  </vVideo>
</template>
  
<script>

import vVideo from '../vvideo/vvideo.vue';
import vVideoDescription from '../_complex-blocks/video/description.vue';

export default {
    name: "video-custom-with-description",
    components: { vVideo, vVideoDescription },
    props: {
      value: {
        type: Object
      }
    },
    computed: {
      videoDOM: function () {
        return this.isLoadedMetaDataVideo ? this.$refs.video.$refs.video.$refs.video : {}
      }
    },
    data() {
      return {
        editorData: {
          preview: null,
          video: null,
          description: null
        },
        isLoadedMetaDataVideo: false
      };
    },
    methods: {
      onChange: function (value) {
        this.editorData = value;
        this.$emit('change', this.editorData)
      }
    },
    async created() {
      this.editorData = this.value ?? {};
    }
}
</script>