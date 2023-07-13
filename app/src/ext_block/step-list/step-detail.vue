<template>
  <div class="step-detail">
    <el-form class="step-detail__form" :rules="rules" :validate-on-rule-change="false" ref="step-detail__form" :model="editorData" label-position="top">
      <el-form-item label="Заголовок:" prop="name">
        <el-input placeholder="Заголовок" v-model="editorData.name"></el-input>
      </el-form-item>
      <el-form-item label="Описание:" prop="description">
        <el-input placeholder="Описание" v-model="editorData.description"></el-input>
      </el-form-item>
      <el-form-item label="Изображение:" prop="image">
        <vImage :value="editorData.image" @change="setImage"></vImage>
      </el-form-item>
      <el-card shadow="never">
        <div slot="header">
          <span>Подробное описание</span>
          <el-switch v-model="isShowDetailDescription" @change="onChangeShowDetailDescription($event)" :validate-event="false"></el-switch>
        </div>

        <div v-if="isShowDetailDescription">
          <el-form-item label="Текст кнопки:" prop="detailDescription:buttonText">
            <el-input placeholder="Текст кнопки" v-model="editorData.detailDescription.buttonText"></el-input>
          </el-form-item>
          <el-form-item label="Заголовок:" prop="detailDescription:name">
            <el-input placeholder="Заголовок" v-model="editorData.detailDescription.name"></el-input>
          </el-form-item>
          <el-form-item label="Описание:" prop="detailDescription:description">
            <vDescription v-model="editorData.detailDescription.description" :settings-toolbar="settingsToolBarEditor"></vDescription>
          </el-form-item>
        </div>
      </el-card>
      <div style="padding-top: 15px">
      <el-form-item>
        <el-button type="primary" @click="onSubmit">Сохранить</el-button>
      </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>
import vImage from "../_complex-blocks/vimage.vue";
import vDescription from "../_complex-blocks/vtext.vue";

export default {
  name: "step-detail",
  components: { vImage, vDescription },
  props: {
    value: Object
  },
  created: function () {
    if (Object.values(this.value).length) {
      this.editorData = {...this.value};
    }
    this.isShowDetailDescription = this.isFilledDetailDescription
  },
  data() {
    return {
      editorData: {
        name: '',
        description: ''
      },
      isShowDetailDescription: false,
      settingsToolBarEditor: [
        ["bold", "italic", "underline", "link"],
        [{ list: "ordered" }, { list: "bullet" }],
      ],
    }
  },
  computed: {
    isFilledDetailDescription: function () {
      return !!(this.editorData?.detailDescription?.name || this.editorData?.detailDescription?.description);
    },
    rules: function() {
      let rules = {
        name: [
          { required: true, message: 'Укажите заголовок', trigger: 'blur' },
        ],
        description: [
          { required: true, message: 'Укажите описание', trigger: 'blur' },
        ]
      };

      if (this.isShowDetailDescription) {
        Object.assign(rules, {
          "detailDescription:name": [
            { required: true, message: 'Укажите заголовок', trigger: 'blur' }
          ],
          "detailDescription:description": [
            { required: true, message: 'Укажите описание', trigger: 'blur' },
          ]
        });
      }

      return rules
    }
  },
  methods: {
    onSubmit() {
      this.$refs['step-detail__form'].validate((valid) => {
        if (valid) {
          this.$emit('save', this.editorData);
        } else {
          return false;
        }
      });
    },
    onChangeShowDetailDescription: function (value) {
      if (value) {
        this.$set(this.editorData, 'detailDescription', {name: '', description: '', buttonText: ''})
      } else {
        this.$delete(this.editorData, 'detailDescription');
      }
    },
    setImage: function (data) {
      this.$set(this.editorData, 'image', data);
    }
  }
}
</script>

<style>
.block-image {
  background-size: cover;
  background-position: center;
  border-radius: 4px;
  width: 100%;
  height: 180px;
}

.step-detail__form .el-form-item__label {
  line-height: 16px;
  padding-bottom: 5px;
  font-weight: bold;
}
</style>