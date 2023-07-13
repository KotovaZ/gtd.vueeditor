<template>
    <div>
        <el-form :model="editorData" label-position="top" class="contact-form">
            <el-form-item label="Заголовок" prop="label">
                <el-input v-model="editorData.label" size="small"></el-input>
            </el-form-item>
            <el-form-item label="Значение" prop="value">
                <el-input v-model="editorData.value" size="small"></el-input>
            </el-form-item>
            <el-form-item label="Тип" prop="type">
                <el-select v-model="editorData.type" placeholder="Укажите тип" size="small" default-first-option>
                    <el-option v-for="item in types" :key="item.value" :label="item.label" :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onChange()">Сохранить</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
  
<script>

export default {
    name: "contact",
    props: {
        value: {
            type: Object
        }
    },
    data() {
        return {
            types: [
                { value: 'phone', label: 'Телефон' },
                { value: 'email', label: 'E-mail' },
                { value: 'address', label: 'Адрес' },
            ],
            editorData: {
                label: null,
                value: null,
                type: 'email'
            }
        }
    },
    computed: {
    },
    methods: {
        onChange: function () {
            this.$emit('change', this.editorData)
        }
    },
    async created() {
        this.editorData = this.value ?? {};
    }
}
</script>
  
<style>
.contact-form label {
    padding: 0px !important;
    line-height: 1 !important;
}
</style>