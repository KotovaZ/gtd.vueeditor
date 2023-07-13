<template>
    <div>
        <el-color-picker
            size="mini"
            slot="prepend"
            :value="editorData.color"
            @active-change="onChangeColor"
            :predefine="predefineColors">
        </el-color-picker>
    </div>
</template>
  
<script>

export default {
    name: "color",
    components: {},
    model: {
        prop: 'value',
        event: 'change'
    },
    props: ["value", "predefineColors"],
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
                color: ""
            }
        }
    },
    methods: {
        onChangeColor: function (value) {
            this.editorData.color = value;
            this.$emit('change', this.editorData);
        },
    },

}
</script>
  
<style scoped>
</style>