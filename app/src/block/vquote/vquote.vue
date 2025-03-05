<template>
  <vue-editor v-model="editorData" :editorToolbar="customToolbar" :editor-options="editorSettings"></vue-editor>
</template>

<script>
    import { VueEditor } from "vue2-editor";

    export default {
      components:{VueEditor},
      name: "vquote",
      data(){
        return {
          editorData:"",
          customToolbar: [["bold", "italic", "underline"]],
          editorSettings: {
            modules: {
              cleanTags: {
                allowedAttributes: ["italic", "bold", "underline"],
              },
              clipboard: {
                matchVisual: false
              }
            }
          }
        }
      }
    }
</script>

