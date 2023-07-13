<template>
  <div>
    <el-button v-if="showAddButton" type="primary" plain @click="startEdit(); $emit('startedit', { isNew: true })">
      Добавить элемент
    </el-button>
    <el-dialog title="Настройки элемента" :visible="dialogVisible" :before-close="onBeforeClose" width="30%" append-to-body>
      <slot name="content"></slot>
    </el-dialog>
  </div>
</template>

<script>

export const MODE_DIALOG = 'dialog';

export default {
  components: { },
  name: "mode-dialog",
  props: {
      showAddButton: {
          type: Boolean,
          default: true
      }
  },
  computed: {

  },
  data(){
    return {
      dialogVisible: false,
    }
  },
  methods: {
    startEdit: function () {
      this.dialogVisible = true;
    },
    endEdit: function () {
      this.dialogVisible = false;
    },
    onBeforeClose: function () {
      this.$emit('endedit', true)
    }
  }
}
</script>

