<template>
    <div class="engine-detail">
        <el-card shadow="never">
            <el-row :gutter="24">
                <el-col :span="24">
                    <div class="engine__label">Короткое название:</div>
                    <el-input placeholder="Короткое название" v-model="editorData.shortName" size="small"></el-input>
                </el-col>
            </el-row>
            <el-row :gutter="24">
                <el-col :span="24">
                    <div class="engine__label">Полное название:</div>
                    <el-input placeholder="Полное название" v-model="editorData.fullName" size="small"></el-input>
                </el-col>
            </el-row>
            <el-row :gutter="24">
                <el-col :span="24">
                    <div class="engine__label">Описание:</div>
                    <el-input placeholder="Описание" v-model="editorData.description" type="textarea"
                              :rows="2"></el-input>
                </el-col>
            </el-row>
            <el-row :gutter="24">
                <el-col :span="24">
                    <div class="engine__label">Характеристики:</div>
                    <vFeatures :value="editorData.chars" @change="setChars"></vFeatures>
                </el-col>
            </el-row>
            <el-row :gutter="24">
                <el-col :span="24">
                    <div class="engine__label">Изображение:</div>
                    <vImage :value="editorData.image" @change="setImage"></vImage>
                </el-col>
            </el-row>
            <el-row :gutter="24" style="padding-top: 12px;">
                <el-col :span="24">
                    <el-button type="primary" @click="onChange()">Сохранить</el-button>
                </el-col>
            </el-row>
        </el-card>
    </div>
</template>

<script>
import IconSelect from '../vicon-list/vicon-list.vue';
import vImage from "../_complex-blocks/vimage.vue";
import vFeatures from "../features/features.vue";

export default {
    name: "engine-detail",
    components: {IconSelect, vImage, vFeatures},
    props: ['value'],
    created: function () {
        this.editorData = this.value ?? {};
    },
    data() {
        return {
            editorData: {
                shortName: '',
                fullName: '',
                description: '',
                chars: [],
                image: {}
            }
        }
    },
    computed: {},
    methods: {
        onChange: function () {
            this.$emit('change', this.editorData)
        },
        setImage: function (data) {
            this.$set(this.editorData, 'image', data);
        },
        setChars: function (data) {
            this.$set(this.editorData, 'chars', data)
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

.engine-detail {
    padding-bottom: 20px;
}

.engine-detail .engine__label {
    padding: 10px 0 5px 0;
    font-size: 14px;
    font-weight: 600;
}
</style>