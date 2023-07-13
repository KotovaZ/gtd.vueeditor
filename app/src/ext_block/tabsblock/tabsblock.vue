<template>
    <div>
        <el-row :gutter="20" align="middle" style="display: flex; align-items: center;">
            <el-col :span="16">
                <el-input placeholder="Заголовок" v-model="editorData.title"></el-input>
            </el-col>
            <el-col :span="8">
                <el-radio-group v-model="editorData.viewType">
                    <el-radio v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                        {{ item.label }}
                    </el-radio>
                </el-radio-group>
            </el-col>
        </el-row>
        <el-row>
            <el-collapse v-model="activeTabs">
                <draggable v-model="editorData.tabs" group="gallery" @start="drag = true" @end="drag = false">
                    <el-collapse-item :title="item.title" :name="i" v-for="(item, i) in editorData.tabs">
                        <el-card class="image-block" shadow="hover">
                            <div class="image-hover">
                                <i @click="deleteItem(i)" class="el-icon-delete"></i>
                            </div>
                            <el-image :src="item.src" fit="cover">
                            </el-image>
                            <el-input placeholder="Заголовок" v-model="item.title"></el-input>
                            <el-input placeholder="Описание" style="margin-top: 10px;" type="textarea"
                                v-model="item.description"></el-input>
                        </el-card>
                    </el-collapse-item>
                </draggable>
            </el-collapse>
        </el-row>
        <el-row>
            <el-upload action="/local/modules/gtd.vueeditor/service/upload_image.php" list-type="text" :on-success="addItem"
                :show-file-list="false">
                <el-button size="small" type="primary">Добавить таб</el-button>
            </el-upload>
        </el-row>
    </div>
</template>
  
<script>
import axios from 'axios';
import draggable from 'vuedraggable'

export default {
    name: "tabsblock",
    components: { draggable },
    props: {
    },
    data() {
        return {
            editorData: {
                viewType: "",
                title: "",
                tabs: []
            },
            activeTabs: [],
            options: [
                {
                    label: '100%',
                    value: 'w100'
                },
                {
                    label: '50%',
                    value: 'w50'
                }
            ]
        };
    },
    methods: {
        addItem(res) {
            let item = {
                imageId: res.id,
                src: res.src,
                title: "Новый таб",
                description: ""
            };
            this.editorData.tabs.push(item);
        },
        deleteItem(i) {
            let fileId = this.editorData.tabs[i].imageId;
            axios.get('/local/modules/gtd.vueeditor/service/delete_file.php?id=' + fileId)
                .then(res => {
                    this.editorData.tabs.splice(i, 1);
                })
        }
    }

}
</script>
  
<style scoped>
.image-block {
    margin-bottom: 20px;
    position: relative;
}

.image-hover {
    position: absolute;
    right: 3px;
    top: 3px;
}

.el-row {
    margin-bottom: 20px;
}

.el-input,
.el-textarea {
    margin-top: 5px;
}
</style>