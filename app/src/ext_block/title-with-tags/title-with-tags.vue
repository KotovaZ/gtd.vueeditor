<template>
  <div class="v-title-with-tags">
    <div>
      <vHeader :value="editorData.title.value"
               v-on:update:value="editorData.title.value = $event"
               :type="editorData.title.type"
               v-on:update:type="editorData.title.type = $event"
               :selectSize="false">
      </vHeader>
    </div>
    <div>
      <vText v-model="editorData.description.value" :settings-toolbar="settingsToolBarEditor"></vText>
    </div>
    <div>
      <vTagList v-model="editorData.tags"></vTagList>
    </div>
  </div>
</template>
  
<script>

import vHeader from "../_complex-blocks/vheader.vue";
import vText from "../_complex-blocks/vtext.vue";
import vTagList from "../tag-list/tag-list.vue";

export default {
    name: "title-with-tags",
    components: { vHeader, vText, vTagList },
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
                },
                tags: {}
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
.v-title-with-tags > div:not(:last-child) {
  padding-bottom: 16px;
}
</style>