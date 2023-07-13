<template>
    <div>
        <el-form label-position="top" class="link-detail-form">
            <el-form-item>
                <label>Заголовок</label>
                <el-input v-model="editorData.title" @input="titleUpdateHandler"></el-input>
            </el-form-item>
            <el-form-item>
                <label>Ссылка</label>
                <el-input v-model="editorData.link"></el-input>
            </el-form-item>
            <el-form-item>
                <label>Транслит</label>
                <el-input v-model="editorData.slug"></el-input>
            </el-form-item>
            <el-form-item>
                <label>Иконка</label>
                <IconSelect :checked="linkIcons" :multiple="false" v-on:change="setIcons" />
            </el-form-item>
            <el-form-item>
                <label>Тег</label>
                <el-input v-model="editorData.tag"></el-input>
            </el-form-item>
            <el-form-item>
                <label>Вариант открытия</label>
                <el-select v-model="editorData.target" placeholder="Вариант открытия">
                    <el-option label="В том же окне" value=""></el-option>
                    <el-option label="В новом окне" value="__blank"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item inline-message class="inline">
                <label>Внешняя ссылка</label>
                <el-checkbox v-model="editorData.isExternal"></el-checkbox>
            </el-form-item>
            <el-row class="actions">
                <el-button v-on:click="close">Отмена</el-button>
                <el-button type="primary" v-on:click="submit">Применить</el-button>
            </el-row>
        </el-form>
    </div>
</template>
  
<script>
import IconSelect from '../vicon-list/vicon-list.vue';

export default {
    name: "link-detail",
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
                title: '',
                link: '',
                slug: '',
                icon: null,
                tag: '',
                target: '',
                isExternal: false
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
        },
        titleUpdateHandler: function (title) {
            this.editorData.slug = translite(title);
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

export function translite(str) {
    str = str ?? '';

    const chars = {
        ' ': '_', 'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'shch', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya', 'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'YO', 'Ж': 'ZH', 'З': 'Z', 'И': 'I', 'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C', 'Ч': 'CH', 'Ш': 'SH', 'Щ': 'SHCH', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'YU', 'Я': 'YA'
    };

    for (var i in chars) {
        str = str.replace(new RegExp(i, 'g'), chars[i]);
    }

    return str.toLowerCase();
};
</script>
  
<style scoped>
.link-detail-form label {
    line-height: 2;
    display: block;
}

.el-dialog__body {
    padding: 20px !important;
}

.el-form--label-top .el-form-item__label {
    line-height: 1;
}

.el-form-item {
    margin-bottom: 10px;
}

.link-detail-form .el-checkbox {
    margin-right: 10px;
}

.link-detail-form .actions {
    margin-top: 20px;
}
</style>