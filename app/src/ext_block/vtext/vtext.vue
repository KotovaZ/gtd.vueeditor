<template>
  <vText v-model="editorData"></vText>
</template>

<script>
import vText from "../_complex-blocks/vtext.vue";
export default {
  components:{ vText },
  name: "v-text-editor",
  data(){
    return {
      editorData: "",
      customToolbar: [
          ["bold", "italic", "underline", "link"],
          [{ list: "ordered" }, { list: "bullet" }]
      ]
    }
  }
}
</script>

