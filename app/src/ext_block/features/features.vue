<template>
    <div class="features">
        <el-menu class="v-menu">
            <draggable v-model="editorData.list" group="features" @start="drag = true" @end="drag = false">
                <el-menu-item index="2" v-for="(link, i) in editorData.list" :key="`link-${i}`" v-on:click="editItem(i)"
                    class="menu-item">
                    <vlink :title="link.title" :icon="link.icon" />
                    <el-button size="small" type="text" icon="el-icon-close"
                        @click.stop.prevent="deleteItem(i)"></el-button>
                </el-menu-item>
            </draggable>
        </el-menu>

        <el-button class="new-link-btn" size="small" @click="dialogVisible = true">
            Добавить характеристику
        </el-button>

        <el-dialog title="Заполните форму" :visible.sync="dialogVisible" width="30%" v-if="dialogVisible"
            :before-close="closeForm">
            <featureform v-on:change="saveItem" :id="active" :data="activeData" v-on:close="closeForm" />
        </el-dialog>
    </div>
</template>
  
<script>
import featureform from './feature-form.vue';
import vicon from '../vicon/vicon.vue';
import vlink from '../menu-builder/vlink.vue';
import draggable from 'vuedraggable';

export default {
    name: "features",
    components: { featureform, vicon, draggable, vlink },
    props: {
        multiple: {
            type: Boolean,
            default() {
                return false;
            }
        },
        value: {
            type: Object,
            default() {
                return {};
            }
        }
    },
    created: function() {
        if (Object.values(this.value).length) {
            this.editorData = this.value;
        }
    },
    data() {
        return {
            editorData: {
                list: []
            },
            dialogVisible: false,
            active: null,
            icons: []
        };
    },
    computed: {
        activeData: function () {
            return this.active !== null ? this.editorData.list[this.active] : null;
        }
    },
    methods: {
        onChange: function () {
            this.$emit('change', this.editorData.list);
        },
        editItem(i) {
            this.active = i;
            this.dialogVisible = true;
        },
        saveItem(params) {
            if (params.id !== null) {
                this.editorData.list[params.id] = params.data;
            } else {
                this.editorData.list.push(params.data);
            }
            this.editorData.list = [...this.editorData.list];
            this.closeForm();
            this.$emit('change', this.editorData);
        },
        deleteItem(i) {
            this.editorData.list.splice(i, 1);
            this.$emit('change', this.editorData);
        },
        closeForm() {
            this.dialogVisible = false;
            this.active = null;
        }
    }
}
</script>
  
<style scoped>
.v-menu {
    border: 1px solid rgb(228 228 228);
    border-radius: 4px;
}

.v-menu .el-menu-item:not(:last-child) {
    border-bottom: 1px solid rgb(228 228 228);
}

.new-link-btn {
    margin-top: 10px;
}

.menu-item {
    display: flex;
    justify-content: space-between;
}
</style>