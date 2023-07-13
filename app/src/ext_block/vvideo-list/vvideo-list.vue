<template>
  <div class="v-video-list">
    <div>
      <div>
        <el-checkbox v-model="useDescription" :disabled="editorData.items.length > 0">Видео с описанием</el-checkbox>
      </div>

      <wrap-list v-model="editorData.items" :validateItem="validateItem" @openPreview="$refs['edit-component'].startEdit()"
      :classNameList="['v-video-list__list']">
        <template #preview="{item}">
          <v-video-preview :value="item"></v-video-preview>
        </template>

        <template #edit-content="{item, indexItem, onUpdateItem, onAppendIntoList}">
          <vDialog ref="edit-component" @startedit="indexItem = -1" @endedit="onAppendIntoList(); $refs['edit-component'].endEdit()">
            <template #content>
              <v-video-with-description v-if="useDescription" :key="indexItem" :value="item" @change="onUpdateItem"></v-video-with-description>
              <v-video v-else :key="indexItem" :value="item" @change="onUpdateItem"></v-video>
            </template>
          </vDialog>
        </template>
      </wrap-list>
    </div>
  </div>
</template>

<script>

import wrapList from "../_complex-blocks/wrap/list/list.vue";
import vVideo from '../vvideo/vvideo.vue';
import vVideoWithDescription from '../vvideo-with-description/vvideo-with-description.vue';
import vVideoPreview from './vvideo-preview.vue';
import vDialog from '../_complex-blocks/wrap/list/display-modes/dialog.vue'

export default {
  name: "vvideo-list",
  components: { wrapList, vVideo, vVideoWithDescription, vVideoPreview, vDialog },
  props: {
    value: {
      type: Object,
    }
  },
  created: function () {
    if (Object.values(this.value).length) {
      this.editorData = this.value;
    }
    this.useDescription = !!this.editorData.items[0]?.description;
  },

  computed: {},
  data() {
    return {
      editorData: {
        items: []
      },
      video: {},
      useDescription: false
    };
  },
  methods: {
    validateItem: function (item) {
      let isValid = item?.video && Object.values(item.video).length;
      if (this.useDescription) {
        isValid = isValid && !!item?.description?.name;
      }

      return isValid;
    },
  }
}
</script>

<style>
.v-video-list__list {
  display: flex;
}

</style>