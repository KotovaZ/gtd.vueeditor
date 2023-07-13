<template>
  <div class="factoid-list">
    <div v-if="showTitle" style="padding-bottom: 15px">
      <div class="tile__label">Заголовок:</div>
      <el-input placeholder="Заголовок" v-model="editorData.title" size="small"></el-input>
    </div>
    <div>
      <wrap-list v-model="editorData.items" :validateItem="validateItem" @openPreview="$refs['edit-component'].startEdit()"
                 :classNameList="['factoid-list__list']">
        <template #preview="{item}">
          <factoid-preview :item="item"></factoid-preview>
        </template>

        <template #edit-content="{item, indexItem, onUpdateItem, onAppendIntoList}">
          <vDialog ref="edit-component" :show-add-button="canAddElement"
                   @startedit="indexItem = -1"
                   @endedit="() => {
                       onAppendIntoList();
                       $refs['edit-component'].endEdit();
                       $emit('change', editorData)
                   }">
            <template #content>
              <factoid-detail :key="indexItem" :value="item"></factoid-detail>
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
import factoidDetail from "./factoid-detail.vue";
import factoidPreview from "./factoid-preview.vue";

export default {
  name: "factoid-list",
  components: { wrapList, vDialog, factoidDetail, factoidPreview },
  props: {
    value: {
      type: Object,
    },
    showTitle: {
      type: Boolean,
      default: true
    },
    multiple: {
      type: Boolean,
      default: true
    }
  },
  created: function () {
    if (Object.values(this.value).length) {
      this.editorData = this.value;
    }
  },

  computed: {
      canAddElement() {
          return this.multiple || this.editorData.items.length === 0;
      }
  },
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
      return item?.name || item?.description || item?.image || item?.icon;
    },
  }
}
</script>

<style>
.factoid-list__list {
  display: flex;
  flex-wrap: wrap;
}

</style>