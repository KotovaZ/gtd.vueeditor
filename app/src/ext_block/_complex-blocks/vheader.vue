<template>
    <el-row :gutter="20">
      <el-col :span="18">
        <el-input @input="onChangeValue" :value="value"></el-input>
      </el-col>
      <el-col :span="6" v-if="selectSize">
        <el-select @input="onChangeType" :value="type" placeholder="Select">
          <el-option
              v-for="type in headerType"
              :key="type"
              :label="type"
              :value="type">
          </el-option>
        </el-select>
      </el-col>
    </el-row>
</template>

<script>
    export default {
      name: "vheader",
      props: {
        selectSize: {
          type: Boolean,
          default: true
        },
        value: {
          type: String,
          default: ''
        },
        type: {
          type: String,
          default: ''
        },
        headerType: {
          type: Array,
          default: function () {
            return ['h1', 'h2', 'h3', 'h4', 'h5']
          }
        }
      },
      async created() {
        this.editorData = {
          value: this.value,
          type: this.type
        };
      },
      data(){
        return {
          editorData: {
            value: '',
            type: ''
          }
        }
      },
      methods: {
        onChangeValue: function (value) {
          this.$emit('update:value', value);
        },
        onChangeType: function (value) {
          this.$emit('update:type', value);
        },
      }
    }
</script>

<style scoped>

</style>