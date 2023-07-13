<template>
  <div>
    <vVideo :value="editorData" @change="onChange" ref="video" @loadedmetadata="$emit('loadedmetadata', true)"></vVideo>
    <slot name="description" :descriptionData="editorData"></slot>
  </div>
</template>
  
<script>

import vVideo from '../_complex-blocks/video/vvideo.vue';

export default {
    name: "video-custom",
    components: { vVideo },
    props: {
      value: {
        type: Object,
        default: function () {
          return {
            preview: null,
            video: null
          }
        }
      }
    },
    computed: { },
    data() {
      return {
          editorData: {
              preview: null,
              video: null
          }
      };
    },
    methods: {
      onChange: function (value) {
        this.editorData = value;
        this.$emit('change', this.editorData)
      }
    },
    async created() {
      this.editorData = this.value;
      // if (Object.values(this.value).length) {
      //   this.editorData = this.value;
      // }
    }
}
</script>