<template>
  <vue-editor v-model="editorData" :editorToolbar="customToolbar" :editor-options="editorSettings"></vue-editor>
</template>

<script>
    import { VueEditor } from "vue2-editor";

    export default {
      components:{VueEditor},
      name: "vtext",
      data(){
        return {
          editorData:"",
          customToolbar: [["bold", "italic", "underline", "link"]],
          editorSettings: {
            modules: {
              cleanTags: {
                allowedAttributes: ["link", "list"],
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

