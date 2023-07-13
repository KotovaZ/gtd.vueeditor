<template>
    <div class="patterns-drawer">
        <el-drawer :show-close="true" :modal-append-to-body="false" title="Добавить блок" size="100%"
            :wrapperClosable="false" custom-class="patterns" direction="ltr" :visible="opened" :with-header="true"
            :modal="false" @close="() => this.$emit('on-close')">
            <el-tabs tab-position="left">
                <el-tab-pane v-for="group in groups" :key="group.id" :label="group.name">
                    <div class="patterns-container">
                        <draggable group="block" handle=".handle" :key="group.id"
                            :group="{ name: 'block', pull: 'clone', put: false }" :forceFallback="true"
                            @start="onStartDrag">
                            <div v-for="pattern in group.components" :key="pattern.id" shadow="never" class="handle pattern"
                                :group="group.id" :pattern="pattern.id">
                                <span>{{ pattern.name }}</span>
                                <img v-if="!!pattern.preview_picture" :src="pattern.preview_picture.src"
                                    style="width: 100%;">
                            </div>
                        </draggable>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </el-drawer>
    </div>
</template>
  
<script>
import draggable from 'vuedraggable';

import { store } from './store.js'

export default {
    name: "patterns",
    components: { draggable },
    props: {
        "opened": {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            groups: []
        }
    },
    methods: {
        onStartDrag(event) {
            const group = this.groups.find(group => group.id == event.item.getAttribute('group'));
            const pattern = group.components.find(pattern => pattern.id == event.item.getAttribute('pattern'));
            store.setDraggable(pattern, 'pattern', pattern);
        },
    },
    mounted() {
        this.groups = this.$root.$data.patterns;
    },
    watch: {
    },
    computed: {
    }
}
</script>

<style scoped>
.patterns-drawer {
    .el-drawer__wrapper {
        max-width: 600px !important;
        box-shadow: rgb(0 0 0 / 11%) 2px 4px 7px 0px;
    }

    .el-drawer__header {
        padding: 20px;
        background-color: #f0f4f4;
        font-size: 16px;
    }

    .patterns-container {
        margin-right: 10px;
        overflow-y: auto;
        height: 100%;
    }

    .el-tabs,
    .el-tabs__content {
        height: 100%;
    }

    .el-tabs__content {
        display: flex !important;
    }

    .patterns {
        width: 100% !important;
    }

    .pattern {
        margin: 0px 0px 10px 0px;
        padding: 10px;
        background: #f0f4f4;
        border-radius: 5px;
    }

    .pattern span {
        color: #4d4d4d;
    }

    .pattern img {
        margin-top: 5px;
    }
}
</style> 
  