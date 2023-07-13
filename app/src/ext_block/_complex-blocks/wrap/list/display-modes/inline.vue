<template>
  <div>
      <div v-if="contentVisible">
        <slot name="content"></slot>
      </div>
      <el-button type="primary" plain @click="startEdit(); $emit('startedit', { isNew: true })">
          Добавить элемент
      </el-button>
  </div>
</template>

<script>

export const MODE_INLINE = 'inline';

export default {
  components: { },
  name: "mode-inline",
  props: {},
  computed: {

  },
  data(){
    return {
        contentVisible: false,
    }
  },
  methods: {
    startEdit: function () {
        this.contentVisible = true;
    },
    endEdit: function () {
        this.contentVisible = false;
    }
  }
}
</script>

