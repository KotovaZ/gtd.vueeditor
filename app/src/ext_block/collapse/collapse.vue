<template>
    <div class="collapse">
        <el-row>
            <el-select v-model="editorData.type" placeholder="Select">
                <el-option v-for="(name, code) in types" :key="code" :label="name" :value="code"
                    placeholder="Выберите компонент">
                </el-option>
            </el-select>
        </el-row>
        <el-collapse v-model="activeNames" accordion>
            <draggable v-model="editorData.items" group="blocks" @start="drag = true" @end="drag = false">
                <el-popover placement="right" width="40" trigger="hover" v-for="(item, i) in editorData.items"
                    :key="`collapse-item-${i}`">
                    <div style="text-align: right; margin: 0">
                        <el-button size="small" icon="el-icon-delete" v-on:click="() => deleteItem(i)">
                            Удалить запись</el-button>
                    </div>
                    <el-collapse-item class="collapse-content" :name="i" slot="reference">
                        <template slot="title">
                            <b>{{ item.title }}</b>
                        </template>
                        <CollapseContent v-model="editorData.items[i]" @change="(value) => changeItem(i, value)" />
                    </el-collapse-item>
                </el-popover>
            </draggable>
        </el-collapse>
        <el-row>
            <el-col class="actions">
                <el-button size="small" plain icon="el-icon-plus" v-on:click="appendItem">Добавить блок</el-button>
            </el-col>
        </el-row>
    </div>
</template>
  
<script>
import CollapseContent from './collapse-content.vue';
import draggable from 'vuedraggable';

export default {
    name: "collapse",
    components: { draggable, CollapseContent },
    computed: {},
    data() {
        return {
            editorData: {
                type: 'accordion',
                items: []
            },
            types: {
                accordion: 'Аккордеон',
                slider: 'Раскрывающийся слайдер'
            },
            activeNames: []
        }
    },
    methods: {
        appendItem() {
            const item = {
                title: `Блок №${this.editorData.items.length + 1}`,
                description: '',
                background: null
            };
            this.editorData.items.push(item);
        },
        deleteItem(i) {
            this.editorData.items.splice(i, 1);
        },
        changeItem(i, value) {
            this.editorData.items[i] = value;
            this.editorData.items = [...this.editorData.items];
        }
    }
}
</script>
  
<style>
.collapse .el-row,
.collapse .el-collapse {
    margin-bottom: 10px;
}

.collapse .el-collapse-item__header {
    font-weight: bold;
    line-height: 18px;
}

.collapse .actions {
    width: 100%;
}
</style>