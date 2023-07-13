<template>
    <div>
        <el-row>
            <el-input placeholder="Заголовок" v-model="editorData.title"></el-input>
        </el-row>
        <el-row>
            <IconSelect :checked="[editorData.icon]" :multiple="false" v-on:change="(data) => setIcon(data)" />
        </el-row>
        <el-row>
            <vue-editor v-model="editorData.description" :editorToolbar="customToolbar"></vue-editor>
        </el-row>
        <el-row>
            <div v-if="!!editorData.background" class="block-image"
                v-bind:style="{ backgroundImage: 'url(' + editorData.background.src + ')' }">
            </div>
        </el-row>
        <el-row>
            <el-upload action="/local/modules/gtd.vueeditor/service/upload_image.php" list-type="text"
                :on-success="(res) => setBackground(res, i)">
                <el-button size="small" plain icon="el-icon-plus">Загрузить фон</el-button>
            </el-upload>
        </el-row>
    </div>
</template>
  
<script>
import { VueEditor } from "vue2-editor";
import IconSelect from '../vicon-list/vicon-list.vue';

export default {
    name: "collapse-content",
    components: { VueEditor, IconSelect },
    computed: {},
    props: {
        value: {
            type: Object
        }
    },
    data() {
        return {
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }]
            ]
        }
    },
    async created() {
        this.editorData = this.value ?? {};
    },
    methods: {
        setBackground(res) {
            this.editorData.background = {
                id: res.id,
                src: res.src
            };
            this.$emit('change', this.editorData);
        },
        setIcon: function (data) {
            this.editorData.icon = data.icon;
            this.$emit('change', this.editorData);
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
</style>