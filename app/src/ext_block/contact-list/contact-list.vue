<template>
  <div class="v-video-list">
    <div>
      <wrap-list v-model="editorData.items" :validateItem="validate" @openPreview="$refs['edit-component'].startEdit()">
        <template #preview="{ item }">
          <el-card shadow="hover">
            {{ item.label }}<br>
            <small>{{ item.value }}</small>
          </el-card>
        </template>

        <template #edit-content="{ item, indexItem, onUpdateItem, onAppendIntoList }">
          <vDialog ref="edit-component"
            @endedit="onAppendIntoList(); $refs['edit-component'].endEdit()">
            <template #content>
              <contact :value="item" :key="indexItem"
                @change="(value) => { onAppendIntoList(value); $refs['edit-component'].endEdit(); }">
              </contact>
            </template>
          </vDialog>
        </template>
      </wrap-list>
    </div>
  </div>
</template>
  
<script>

import wrapList from "../_complex-blocks/wrap/list/list.vue";
import contact from "./contact.vue";
import vDialog from '../_complex-blocks/wrap/list/display-modes/dialog.vue';

export default {
  name: "contact-list",
  components: { wrapList, contact, vDialog },
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

  computed: {},
  data() {
    return {
      editorData: {
        items: []
      }
    };
  },
  methods: {
    validate(data) {
      return !!data.label && !!data.value && !!data.type;
    }
  }
}
</script>
  
<style>
.contact-list__list {
  display: flex;
}
</style>