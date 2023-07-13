<template>
  <div>
    <el-form class="v-button__form" :rules="rules" ref="v-button__form" :model="editorData" label-position="top">
      <div style="display: flex; justify-content: space-between;">
        <div style="padding: 5px">
          <el-form-item label="Тип:" prop="type">
            <el-select v-model="editorData.type" placeholder="Тип">
              <el-option
                  v-for="type in types"
                  :key="type.value"
                  :label="type.name"
                  :value="type.value">
              </el-option>
            </el-select>
          </el-form-item>
        </div>
        <div style="padding: 5px">
          <el-form-item label="Размер:" prop="size">
            <el-select v-model="editorData.size" placeholder="Размер">
              <el-option
                  v-for="size in sizes"
                  :key="size.value"
                  :label="size.name"
                  :value="size.value">
              </el-option>
            </el-select>
          </el-form-item>
        </div>
      </div>

      <div>
        <div style="padding: 5px">
          <el-form-item label="Текст:" prop="text">
            <el-input placeholder="Текст:" v-model="editorData.text"></el-input>
          </el-form-item>
        </div>
        <div style="padding: 5px">
          <el-form-item label="Действие:" prop="action">
            <el-input placeholder="Действие:" v-model="editorData.action"></el-input>
          </el-form-item>
        </div>
      </div>

      <div style="display: flex;">
        <div style="padding: 5px">
          <el-form-item label="Открыть в:" prop="target">
            <el-select v-model="editorData.target" placeholder="Открыть в:">
              <el-option
                  v-for="target in targets"
                  :key="target.value"
                  :label="target.name"
                  :value="target.value">
              </el-option>
            </el-select>
          </el-form-item>
        </div>
        <div style="padding: 5px">
          <el-form-item label="Иконка (слева):" prop="beforeIcon">
            <viconList :checked="[editorData.beforeIcon.icon]" @change="editorData.beforeIcon = $event"></viconList>
          </el-form-item>
        </div>
        <div style="padding: 5px">
          <el-form-item label="Иконка (справа):" prop="afterIcon">
            <viconList :checked="[editorData.afterIcon.icon]" @change="editorData.afterIcon = $event"></viconList>
          </el-form-item>
        </div>
      </div>
      <el-form-item>
        <el-button type="primary" @click="onSave('v-button__form')">Сохранить</el-button>
        <el-button @click="onCancel('v-button__form')">Отмена</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import viconList from "../vicon-list/vicon-list.vue"
export default {
  name: "vbutton",
  components: { viconList },
  props: {
    button: Object,
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
    if (Object.values(this.button).length) {
      this.editorData = this.button;
    }
  },
  computed: { },
  data() {
    return {
      editorData: {
        type: "",
        size: "",
        text: "",
        action: "",
        target: "",
        beforeIcon: {},
        afterIcon: {}
      },

      types: [
        { value: 'filled', name: 'С заливкой' },
        { value: 'outline', name: 'С контуром' },
        { value: 'link', name: 'Ссылка' },
      ],
      sizes: [
        { value: 'xl', name: 'Большая (xl)' },
        { value: 'md', name: 'Средняя (md)' },
        { value: 'sm', name: 'Маленькая (sm)'},
        { value: 'xs', name: 'Очень маленькая (xs)'},
      ],
      targets: [
        { value: '_self', name: 'Текущем окне' },
        { value: '_blank', name: 'Новом окне' }
      ],
      rules: {
        type: [
          { required: true, message: 'Укажите тип', trigger: 'change' },
        ],
        size: [
          { required: true, message: 'Укажите размер', trigger: 'change' },
        ],
        text: [
          { required: true, message: 'Укажите текст', trigger: 'blur' }
        ],
        action: [
          { required: true, message: 'Укажите действие', trigger: 'blur' }
        ],
      }
    };
  },
  methods: {
    onSave: function (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.$emit('update:button', this.editorData);
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
.v-button__form .el-form-item__label {
  line-height: 0;
  padding-bottom: 5px;
}
</style>