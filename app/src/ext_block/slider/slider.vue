<template>
    <div class="slider">
        <draggable v-model="editorData.slides" group="slider" @start="drag = true" @end="drag = false">
            <el-row v-for="(slide, i) in editorData.slides" :key="i">
                <vslide :value="slide" :slide="slide ? slide.type : 'image'" v-on:change="(data) => onChange(data, i)" />
            </el-row>
        </draggable>
        <el-row>
            <el-button icon="el-icon-plus" v-on:click="appendSlide">Добавить слайд</el-button>
        </el-row>
    </div>
</template>
  
<script>
import vslide from './vslide.vue';
import draggable from 'vuedraggable';

export default {
    components: { vslide, draggable },
    name: "slider",
    props: {
    },
    computed: {
    },
    data() {
        return {
            editorData: {
                slides: []
            }
        };
    },
    methods: {
        onChange: function (data, i) {
            this.editorData.slides[i] = data;
            this.editorData.slides = [...this.editorData.slides];
        },
        appendSlide: function () {
            this.editorData.slides.push({
                type: 'image',
                value: null
            });
        },
    }

}
</script>
  
<style scoped></style>