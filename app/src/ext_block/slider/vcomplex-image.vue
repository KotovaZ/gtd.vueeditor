<template>
    <div>
        <el-row :gutter="24">
            <el-col :span="8" v-for="(title, format) in variants" :key="format" class="complex-image">
                <label>{{ title }}</label>
                <el-upload class="avatar-uploader" action="/local/modules/gtd.vueeditor/service/upload_image.php"
                    :show-file-list="false" :on-success="(res) => handleAvatarSuccess(res, format)">
                    <img v-if="editorData.hasOwnProperty(format) && !!editorData[format].src" :src="editorData[format].src"
                        class="complex-image-avatar">
                    <i v-else class="el-icon-plus complex-image-icon"></i>
                </el-upload>
            </el-col>
        </el-row>
    </div>
</template>
  
<script>
import draggable from 'vuedraggable'
export default {
    props: ['value'],
    name: "vimage",
    components: { draggable },
    data() {
        return {
            editorData: {
            },
            variants: { xl: 'Компьютер', md: 'Планшет', sm: 'Телефон' }
        };
    },
    methods: {
        handleAvatarSuccess(res, format) {
            this.editorData[format] = {
                id: res.id,
                src: res.src
            };
            this.$emit('change', { ...this.editorData })
        }
    },
    async created() {
        this.editorData = this.value ?? { ...basicComplexImage };
    }

}

export const basicComplexImage = {
    xl: {
        id: 0,
        src: ""
    },
    md: {
        id: 0,
        src: ""
    },
    sm: {
        id: 0,
        src: ""
    }
}
</script>
  
<style>
.complex-image .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.complex-image .el-upload:hover {
    border-color: #409EFF;
}

.complex-image label {
    margin: 7px 0px;
    display: block;
}

.complex-image-icon {
    font-size: 28px;
    color: #8c939d;
    width: 100px;
    height: 100px;
    line-height: 100px;
    text-align: center;
}

.complex-image-avatar {
    width: 100px;
    display: block;
}
</style>