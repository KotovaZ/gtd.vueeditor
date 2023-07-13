<template>
  <div class="v-title-description">
    <div>
      <vheader :value="editorData.title.value"
               v-on:update:value="editorData.title.value = $event"
               :type="editorData.title.type"
               v-on:update:type="editorData.title.type = $event">
      </vheader>
    </div>
    <div>
      <vtext v-model="editorData.description.value" :settings-toolbar="settingsToolBarEditor"></vtext>
    </div>
  </div>
</template>
  
<script>

import vheader from "../_complex-blocks/vheader.vue";
import vtext from "../_complex-blocks/vtext.vue";

export default {
    name: "title-description",
    components: { vheader, vtext },
    // props: {
    //   title: {
    //     type: Object,
    //     default: {
    //       value: '',
    //       type: ''
    //     }
    //   },
    //   description: {
    //     type: Object,
    //     default: {
    //       value: ''
    //     }
    //   }
    // },
    // created: function () {
    //   this.editorData.title = this.title;
    //   this.editorData.description = this.description;
    // },
    computed: {},
    data() {
        return {
            editorData: {
                title: {
                  value: '',
                  type: ''
                },
                description: {
                  value: ''
                }
            },
            settingsToolBarEditor: [
                ["bold", "italic", "underline", "link"],
                [{ list: "ordered" }, { list: "bullet" }],
            ]
        }
    },
    methods: { }
}
</script>
  
<style scoped>
.v-title-description > div:not(:last-child) {
  padding-bottom: 16px;
}
</style>