<template>
  <div class="v-title-with-gallery">
    <div>
      <vHeader :value="editorData.title.value"
               v-on:update:value="editorData.title.value = $event"
               :type="editorData.title.type"
               v-on:update:type="editorData.title.type = $event"
               :selectSize="false">
      </vHeader>
    </div>
    <div>
      <vGallery v-model="editorData.gallery" :selectType="false"></vGallery>
    </div>
  </div>
</template>
  
<script>

import vHeader from "../_complex-blocks/vheader.vue";
import vGallery from "../_complex-blocks/gallery.vue";

export default {
    name: "title-with-gallery",
    components: { vHeader, vGallery },
    computed: {},
    data() {
        return {
            editorData: {
                title: {
                  value: '',
                  type: ''
                },
                gallery: {
                  viewType: "",
                  images: []
                }
            },
        }
    },
    methods: { }
}
</script>
  
<style scoped>
.v-title-with-gallery > div:not(:last-child) {
  padding-bottom: 16px;
}
</style>