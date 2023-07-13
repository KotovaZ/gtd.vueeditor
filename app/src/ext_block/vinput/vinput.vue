<template>
    <div>
        <el-input placeholder="Введите текст" type="textarea" :rows="1" :value="editorData.value" @input="onInput"></el-input>
    </div>
</template>
  
<script>

export default {
    name: "vinput",
    components: {},
    props: ["value"],
    created() {
        if (this.value && Object.values(this.value).length) {
            this.editorData = this.value;
        }
    },
    computed: {
    },
    data() {
        return {
            editorData: {
                value: ""
            }
        }
    },
    methods: {
        onInput: function (value) {
            this.editorData.value = value;
            this.$emit('input', this.editorData)
        }
    },

}
</script>
  
<style scoped>
</style>