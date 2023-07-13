<template>
  <div class="v-link-blocks">
    <div style="padding-bottom: 10px; margin-left: -5px; margin-right: -5px;">
      <draggable v-model="editorData.items" group="link-blocks" @start="drag = true" @end="drag = false" style="display: flex">
        <div v-for="(item, index) in editorData.items" :key="index" @click="onOpenDialog(index)">
          <v-link-block-preview :item="item" @remove="onRemove"></v-link-block-preview>
        </div>
      </draggable>
    </div>

    <el-button type="primary" plain @click="onOpenDialog()">Добавить блок-ссылку</el-button>

    <el-dialog title="Настройки блока-ссылки" :visible.sync="dialogVisible" width="30%" append-to-body>
      <v-link-block :item="item"
                @update:item="onSave($event)"
                :key="itemIndex"
                :onParentSave="onCloseDialog"
                :onParentCancel="onCloseDialog">
      </v-link-block>
    </el-dialog>

  </div>
</template>

<script>
import vLinkBlock from "./link-block.vue"
import vLinkBlockPreview from "./link-block-preview.vue"
import draggable from 'vuedraggable';
export default {
  name: "v-link-blocks",
  components: { vLinkBlock, draggable, vLinkBlockPreview },
  props: {
    value: {
      type: Object,
      default: function () {
        return {};
      }
    }
  },
  computed: { },
  async created() {
    if (Object.values(this.value).length) {
      this.editorData = this.value;
    }
  },
  data() {
    return {
      editorData: {
        items: []
      },
      item: {},
      isNewItem: false,
      itemIndex: -1,
      dialogVisible: false,
    };
  },
  methods: {
    onSave: function (item) {
      this.item = item;
      if (this.isNewItem) {
        this.editorData.items.push(item);
        this.itemIndex = this.editorData.items.length - 1;
      }
    },
    onRemove: function (item) {
      let index = this.editorData.items.indexOf(item);
      this.editorData.items.splice(index, 1);
    },
    onOpenDialog: function (itemIndex = -1) {
      this.dialogVisible = true;
      this.isNewItem = itemIndex < 0;
      this.itemIndex = itemIndex;
      if (!this.isNewItem) {
        this.item = this.editorData.items[itemIndex];
      } else {
        this.item = {}
      }
    },
    onCloseDialog: function () {
      this.dialogVisible = false;
    }
  },
}
</script>

<style>

</style>