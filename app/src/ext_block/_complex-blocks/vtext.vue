<template>
  <vue-editor v-model="editorData"></vue-editor>
</template>

<script>
    import { VueEditor } from "vue2-editor";
    export default {
      components: { VueEditor },
      name: "vtext",
      model: {
        prop: 'value',
        event: 'input'
      },
      props: {
        value: {
          type: String
        },
        settingsToolbar: {
          type: Array,
          default: function () {
            return [["bold", "italic", "underline", "link"]];
          }
        }
      },
      async created() {
        this.editorData = this.value ?? '';
        this.customToolbar = this.settingsToolbar;
      },
      data(){
        return {
          editorData: "",
          customToolbar: []
        }
      },
      methods: { }
    }
</script>

