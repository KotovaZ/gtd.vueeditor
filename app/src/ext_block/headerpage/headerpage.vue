<template>
  <div class="v-header-page">
    <div class="v-header-page__item">
      <div class="v-header-page__label">Заголовок:</div>
      <vTitle :value="editorData.title.value"
               v-on:update:value="editorData.title.value = $event"
               :type="editorData.title.type"
               v-on:update:type="editorData.title.type = $event">
      </vTitle>
    </div>
    <div class="v-header-page__item">
      <div class="v-header-page__label">Описание:</div>
      <vDescription v-model="editorData.description.value"></vDescription>
    </div>
    <div class="v-header-page__item">
      <div class="v-header-page__label">Теги:</div>
      <vTagList v-model="editorData.tags"></vTagList>
    </div>
    <div class="v-header-page__item">
      <div class="v-header-page__label">Шильдики:</div>
      <vGallery v-model="editorData.nameplate" :selectType="false" :showImageHeader="false"></vGallery>
    </div>
  </div>
</template>

<script>

import vDescription from "../_complex-blocks/vtext.vue"
import vTitle from "../_complex-blocks/vheader.vue"
import vTagList from "../tag-list/tag-list.vue"
import vGallery from "../_complex-blocks/gallery.vue";
export default {
  name: "headerpage",
  components: { vTitle, vDescription, vTagList, vGallery },
  props: { },
  computed: { },
  data() {
    return {
      editorData: {
        title: {
          value: '',
          type: ''
        },
        description: {
          value: ''
        },
        tags: {},
        nameplate: {
          viewType: "",
          images: []
        }
      },
    };
  },
  methods: {

  },
}
</script>

<style>
.v-header-page .avatar {
  width: auto;
}
.v-header-page .v-header-page__item {
  padding-bottom: 10px;
}
.v-header-page .v-header-page__label {
  padding: 10px 0 5px 0;
  font-size: 14px;
  font-weight: 600;
}
</style>