<template>
  <div class="factoid-detail">
    <el-row :gutter="20">
      <el-col :span="20">
        <div class="factoid__label">Заголовок:</div>
        <el-input placeholder="Заголовок" v-model="editorData.name" size="small"></el-input>
      </el-col>
    </el-row>
    <el-row :gutter="20">
      <el-col :span="20">
        <div class="factoid__label">Описание:</div>
        <el-input placeholder="Описание" v-model="editorData.description" size="small"></el-input>
      </el-col>
    </el-row>
    <el-row :gutter="20">
      <el-col :span="20">
        <div class="factoid__label">Иконка:</div>
        <IconSelect :checked="[editorData.icon]" :multiple="false" v-on:change="setIcon"/>
      </el-col>
      <el-col :span="20">
        <div class="factoid__label">Изображение:</div>
        <vImage :value="editorData.image" @change="setImage"></vImage>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import IconSelect from '../vicon-list/vicon-list.vue';
import vImage from "../_complex-blocks/vimage.vue";

export default {
  name: "factoid-detail",
  components: {IconSelect, vImage},
  props: ['value'],
  created: function () {
    this.editorData = this.value ?? {};
  },
  data() {
    return {
      editorData: {
        name: '',
        description: '',
        icon: '',
        image: {}
      }
    }
  },
  computed: {},
  methods: {
    setIcon: function (data, i) {
      if (data.icon) {
        this.$set(this.editorData, 'icon', data.icon);
      } else {
        this.$delete(this.editorData, 'icon');
      }
    },
    setImage: function (data) {
      this.$set(this.editorData, 'image', data);
    }
  }
}
</script>

<style scoped>
.collapse .el-row,
.collapse .el-collapse {
  margin-bottom: 10px;
}

.block-image {
  background-size: cover;
  background-position: center;
  border-radius: 4px;
  width: 100%;
  height: 180px;
}

.factoid-detail .factoid__label {
  padding: 10px 0 5px 0;
  font-size: 14px;
  font-weight: 600;
}
</style>