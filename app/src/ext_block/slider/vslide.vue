<template>
    <div class="slide">
        <el-select v-model="type" placeholder="Select" v-on:change="changetype" class="slide-type">
            <el-option v-for="(name, code) in types" :key="code" :label="name" :value="code">
            </el-option>
        </el-select>
        <div class="slide-data">
            <ComplexImage v-if="type === 'image'" :value="editorData" v-on:change="onChange" />
            <Video v-if="type === 'video'" :value="editorData" v-on:change="onChange" />
        </div>
    </div>
</template>
  
<script>
import ComplexImage from './vcomplex-image.vue';
import Video from '../vvideo/vvideo.vue';
export default {
    components: { ComplexImage, Video },
    name: "vslide",
    props: ['value'],
    computed: {
    },
    data() {
        return {
            editorData: {},
            type: null,
            types: { 'image': 'Фото', 'video': 'Видео' }
        };
    },
    methods: {
        onChange: function (value) {
            const data = {
                type: this.type,
                value: { ...value }
            }

            this.$emit('change', data);
            this.editorData = value;
        },
        changetype: function (type) {
            this.editorData = null;
            this.type = type;
        }
    },
    async created() {
        this.editorData = this.value.value;
        this.type = this.value.type;
    }
}
</script>
  
<style scoped>
.slide {
    padding: 10px;
    border: 1px dashed #bcbcbc;
    border-radius: 4px;
    margin-bottom: 20px;
    background: #f9f6f5;
}

.slide-type,
.slide-data {
    margin-bottom: 10px;
}
</style>