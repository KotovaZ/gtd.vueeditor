<template>
  <div>
    <el-form class="v-link-block__form" :rules="rules" ref="v-link-block__form" :model="editorData" label-position="top">
      <div>
        <div style="padding: 5px">
          <el-form-item label="Наименование:" prop="name">
            <el-input placeholder="Наименование:" v-model="editorData.name"></el-input>
          </el-form-item>
        </div>
        <div style="padding: 5px">
          <el-form-item label="Ссылка:" prop="link">
            <el-input placeholder="Ссылка:" v-model="editorData.link"></el-input>
          </el-form-item>
        </div>
        <div style="padding: 5px">
          <el-form-item label="Описание:" prop="description">
            <el-input placeholder="Описание:" v-model="editorData.description"></el-input>
          </el-form-item>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <div style="padding: 5px">
            <el-form-item label="Цвет фона (при наведении):" prop="hoverBackgroundColor">
              <el-color-picker size="medium" v-model="editorData.hoverBackgroundColor" :predefine="predefineColors">
              </el-color-picker>
            </el-form-item>
          </div>
          <div style="padding: 5px">
            <el-form-item label="Цвет текста (при наведении):" prop="hoverColor">
              <el-color-picker size="medium" v-model="editorData.hoverColor">
              </el-color-picker>
            </el-form-item>
          </div>
        </div>
      </div>
      <el-form-item>
        <el-button type="primary" @click="onSave('v-link-block__form')">Сохранить</el-button>
        <el-button @click="onCancel('v-link-block__form')">Отмена</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>

export default {
  name: "v-link-block",
  components: { },
  props: {
    item: Object,
    onParentSave: {
      type: Function,
      default: function () {}
    },
    onParentCancel: {
      type: Function,
      default: function () {}
    }
  },
  created: function () {
    if (Object.values(this.item).length) {
      this.editorData = this.item;
    }
  },
  computed: { },
  data() {
    return {
      editorData: {
        name: "",
        description: "",
        link: "",
        hoverBackgroundColor: "",
        hoverColor: ""
      },
      predefineColors: [
        '#1C60F6',
        '#FFD007',
        '#B532A3'
      ],
      rules: {
        name: [
          { required: true, message: 'Укажите наименование', trigger: 'blur' },
        ],
        link: [
          { required: true, message: 'Укажите ссылку', trigger: 'blur' }
        ]
      }
    };
  },
  methods: {
    onSave: function (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.$emit('update:item', this.editorData);
          this.onParentSave();
        } else {
          return false;
        }
      });
    },
    onCancel: function (formName) {
      this.resetForm(formName);
      this.onParentCancel();
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    }
  },

}
</script>

<style>
.v-link-block__form .el-form-item__label {
  line-height: 16px;
  padding-bottom: 5px;
}
.v-link-block__form .el-form-item {
  margin-bottom: 5px;
}
</style>