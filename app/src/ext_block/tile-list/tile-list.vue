<template>
  <div class="tile-list">
    <div v-if="showTitle" style="padding-bottom: 15px">
      <div class="tile__label">Заголовок:</div>
      <el-input placeholder="Заголовок" v-model="editorData.title" size="small"></el-input>
    </div>
    <div>
      <wrap-list v-model="editorData.items" :validateItem="validateItem" @openPreview="$refs['edit-component'].startEdit()"
                 :classNameList="['tile-list__list']">
        <template #preview="{item}">
          <preview :item="item"></preview>
        </template>

        <template #edit-content="{item, indexItem, onAppendIntoList, onResetActiveItem}">
          <vDialog ref="edit-component"
                   @startedit="indexItem = -1"
                   @endedit="onResetActiveItem(); $refs['edit-component'].endEdit()"
          >
            <template #content>
              <detail ref="detail-component" :key="indexItem" :value="item" @save="onSave($event, {item, indexItem, onAppendIntoList})"></detail>
            </template>
          </vDialog>
        </template>
      </wrap-list>
    </div>
  </div>
</template>

<script>

import wrapList from "../_complex-blocks/wrap/list/list.vue";
import vDialog from '../_complex-blocks/wrap/list/display-modes/dialog.vue'
import detail from "./tile-detail.vue";
import preview from "./tile-preview.vue";

export default {
  name: "tile-list",
  components: { wrapList, vDialog, detail, preview },
  props: {
    value: {
      type: Object,
    },
    showTitle: {
      type: Boolean,
      default: true
    }
  },
  created: function () {
    if (Object.values(this.value).length) {
      this.editorData = this.value;
    }
  },

  computed: {},
  data() {
    let editorData = {
      items: []
    }
    if (this.showTitle) {
      editorData.title = '';
    }
    return {
      editorData: editorData,
    };
  },
  methods: {
    validateItem: function (item) {
      return true;
    },
    onSave: function (value, params) {
      let that = this;
      Object.keys(params.item).forEach((fieldKey) => {
        that.$delete(params.item, fieldKey);
      })
      Object.assign(params.item, value);
      params.onAppendIntoList();
      this.$refs['edit-component'].endEdit();
    }
  }
}
</script>

<style>
.tile-list__list {
  display: flex;
  flex-wrap: wrap;
}

</style>