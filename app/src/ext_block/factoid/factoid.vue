<template>
  <div class="factoid">
      <factoidList :value="listData" @change="onChange" :multiple="false" :show-title="false"></factoidList>

  </div>
</template>

<script>
import factoidList from "../factoid-list/factoid-list.vue";

export default {
  name: "factoid",
  components: { factoidList },
  props: {
    value: {
      type: Object,
    }
  },
  created: function () {
    if (Object.values(this.value).length) {
      this.editorData = this.value;
    }
  },

  computed: {
      listData() {
          return {
              title: '',
              items: [
                  this.editorData
              ]
          }
      }
  },
  data() {
    return {
      editorData: {},
    };
  },
  methods: {
      onChange: function (value) {
          if (value.items[0]) {
              this.editorData = value.items[0];
          }
      },
  }
}
</script>

<style>
</style>