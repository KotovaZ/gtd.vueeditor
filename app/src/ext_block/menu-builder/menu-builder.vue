<template>
    <div class="menu-builder">
        <el-row>
            <el-input placeholder="Код меню" v-model="editorData.code" clearable>
                <el-select v-model="editorData.type" slot="prepend" placeholder="Тип меню" class="type-select">
                    <el-option label="→" value="horizontal"></el-option>
                    <el-option label="↓" value="vertical"></el-option>
                </el-select>
            </el-input>
        </el-row>
        <el-row>
            <el-col :span="16">
                <el-input placeholder="Заголовок" v-model="editorData.title" clearable></el-input>
            </el-col>
            <el-col :span="8">
                <el-input placeholder="ссылка" v-model="editorData.url" clearable></el-input>
            </el-col>
        </el-row>

        <el-menu class="v-menu">
            <draggable v-model="editorData.links" group="menu" @start="drag = true" @end="drag = false">
                <el-menu-item index="2" v-for="(link, i) in  editorData.links " :key="`link-${i}`" v-on:click="editLink(i)"
                    class="menu-item">
                    <vlink :title="link.title" :icon="link.icon" :tag="link.tag" />
                    <el-button size="small" type="text" icon="el-icon-close"
                        @click.stop.prevent="deleteItem(i)"></el-button>
                </el-menu-item>
            </draggable>
        </el-menu>

        <el-button class="new-link-btn" size="small" @click="dialogVisible = true">
            Добавить ссылку
        </el-button>

        <el-dialog title="Параметры ссылки" :visible.sync="dialogVisible" width="30%" v-if="dialogVisible"
            :before-close="closeLinkForm">
            <linkform v-on:change="saveLink" :id="activeLink" :data="activeLinkData" v-on:close="closeLinkForm" />
        </el-dialog>
    </div>
</template>
  
<script>
import linkform from './link-detail.vue';
import vicon from '../vicon/vicon.vue';
import vlink from './vlink.vue';
import draggable from 'vuedraggable';

export default {
    name: "menu-builder",
    components: { linkform, vicon, draggable, vlink },
    props: {
        multiple: {
            type: Boolean,
            default() {
                return false;
            }
        },
        checked: {
            type: Array,
            default() {
                return []
            }
        }
    },
    data() {
        return {
            editorData: {
                type: null,
                code: null,
                title: null,
                url: null,
                links: []
            },
            dialogVisible: false,
            activeLink: null,
            icons: []
        };
    },
    computed: {
        activeLinkData: function () {
            return this.activeLink !== null ? this.editorData.links[this.activeLink] : null;
        }
    },
    methods: {
        onChange: function (code) {
        },
        editLink(i) {
            this.activeLink = i;
            this.dialogVisible = true;
        },
        saveLink(params) {
            if (params.id !== null) {
                this.editorData.links[params.id] = params.data;
            } else {
                this.editorData.links.push(params.data);
            }
            this.editorData.links = [...this.editorData.links];
            this.closeLinkForm();
        },
        closeLinkForm() {
            this.dialogVisible = false;
            this.activeLink = null;
        },
        deleteItem(i) {
            this.editorData.links.splice(i, 1);
        }
    }
}
</script>
  
<style scoped>
.type-select {
    width: 55px;
}

.input-with-select .el-input-group__prepend {
    background-color: #fff;
}

.el-dialog__body {
    padding: 20px;
}

.v-menu .el-menu-item {
    height: 40px;
    line-height: 40px;
}

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

.menu-builder .el-row {
    margin-bottom: 10px;
}

.menu-item {
    display: flex;
    justify-content: space-between;
}

.menu-item button {
    margin-left: 5px;
}
</style>