<template>
    <div>
        <el-form label-position="top" class="feature-form">
            <el-form-item>
                <label>Иконка</label>
                <IconSelect :checked="linkIcons" :multiple="false" v-on:change="setIcons" />
            </el-form-item>
            <el-form-item>
                <label>Заголовок</label>
                <el-input v-model="editorData.title"></el-input>
            </el-form-item>
            <el-form-item>
                <label>Описание</label>
                <el-input v-model="editorData.description"></el-input>
            </el-form-item>
            <el-row>
                <el-button v-on:click="close">Отмена</el-button>
                <el-button type="primary" v-on:click="submit">Применить</el-button>
            </el-row>
        </el-form>
    </div>
</template>
  
<script>
import IconSelect from '../vicon-list/vicon-list.vue';
export default {
    name: "feature-form",
    components: { IconSelect },
    props: {
        id: Number,
        data: Object
    },
    computed: {
    },
    data() {
        return {
            editorData: {
                icon: null,
                title: '',
                description: ''
            }
        };
    },
    methods: {
        setIcons: function (data) {
            this.editorData.icon = data.icon;
        },
        submit: function () {
            const payload = { id: this.id, data: { ...this.editorData } };
            this.$emit('change', payload);
        },
        close: function () {
            this.$emit('close');
        }
    },
    created() {
        if (this.data) {
            this.editorData = { ...this.data };
        }
    },
    computed: {
        linkIcons: function () {
            return this.editorData.icon ? [this.editorData.icon] : [];
        }
    }
}
</script>
  
<style scoped>
.feature-form label {
    line-height: 2;
    display: block;
}
</style>