<template>
  <div class="tile-detail">
    <el-form class="tile-detail__form" :rules="rules" :validate-on-rule-change="false" ref="tile-detail__form" :model="editorData" label-position="top">
      <el-form-item label="Заголовок:" prop="name">
        <el-input placeholder="Заголовок" v-model="editorData.name"></el-input>
      </el-form-item>
      <el-form-item label="Описание:" prop="description">
        <el-input placeholder="Описание" v-model="editorData.description"></el-input>
      </el-form-item>
      <div style="padding-top: 15px">
      <el-form-item>
        <el-button type="primary" @click="onSubmit">Сохранить</el-button>
      </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>

export default {
  name: "tile-detail",
  components: { },
  props: {
    value: Object
  },
  created: function () {
    if (Object.values(this.value).length) {
      this.editorData = {...this.value};
    }
  },
  data() {
    return {
      editorData: {
        name: '',
        description: ''
      },
    }
  },
  computed: {
    rules: function() {
      return {
        name: [
          { required: true, message: 'Укажите заголовок', trigger: 'blur' },
        ],
        description: [
          { required: true, message: 'Укажите описание', trigger: 'blur' },
        ]
      };
    }
  },
  methods: {
    onSubmit() {
      this.$refs['tile-detail__form'].validate((valid) => {
        if (valid) {
          this.$emit('save', this.editorData);
        } else {
          return false;
        }
      });
    },
  }
}
</script>

<style>
.tile-detail__form .el-form-item__label {
  line-height: 16px;
  padding-bottom: 5px;
  font-weight: bold;
}
</style>