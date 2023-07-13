<template>
    <div>
        <el-row :gutter="20">
            <el-col :span="20">
                <el-input placeholder="Заголовок" v-model="value.label" size="small"></el-input>
            </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="20">
            <el-input placeholder="Описание" v-model="value.description" size="small"></el-input>
          </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="10">
                <IconSelect :checked="[this.value.icon]" :multiple="false" v-on:change="setIcon" />
            </el-col>
            <el-col :span="10">
                <el-select v-model="value.type" placeholder="Укажите тип" size="small" default-first-option>
                    <el-option v-for="item in types" :key="item.value" :label="item.label" :value="item.value">
                    </el-option>
                </el-select>
            </el-col>
        </el-row>
    </div>
</template>
  
<script>
import IconSelect from '../vicon-list/vicon-list.vue';

export default {
    name: "vtag-detail",
    components: { IconSelect },
    props: ['value'],
    data() {
        return {
            types: [
                { value: 'default', label: 'По умолчанию' },
                { value: 'turquoise-bullet', label: '● Бирюзовый'}
            ]
        }
    },
    computed: {
    },
    methods: {
        setIcon: function (data, i) {
            this.value.icon = data.icon;
            this.$emit('input', this.value)
            console.log(this.value);
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