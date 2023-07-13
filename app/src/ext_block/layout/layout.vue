<template>
    <div class="layout">
        <el-row class="block-header">
            <div class="layout-actions" v-if="!predefined">
                <div class="layout-block-action">
                    <i :class="visibleBlock ? 'el-icon-arrow-up' : 'el-icon-arrow-down'"
                        @click="visibleBlock = !visibleBlock"></i>
                </div>
                <div class="layout-block-action">
                    <el-popover placement="bottom-end" trigger="click">
                        <span slot="default">
                            <div class="block-params-edit">
                                <div class="block-param-edit">
                                    <el-divider class="block-param-name" content-position="left">
                                        Настройки отображения
                                    </el-divider>
                                    <el-select v-model="editorData.palette" placeholder="Цветовая палитра">
                                        <el-option v-for="(color, code) in blockConfig.palette" :key="code"
                                            :label="color.label" :value="code">
                                        </el-option>
                                    </el-select>
                                    <el-select v-model="editorData.direction" placeholder="Направление контентая">
                                        <el-option v-for="(item, code) in blockConfig.direction" :key="code"
                                            :label="item.label" :value="code">
                                        </el-option>
                                    </el-select>
                                    <el-select v-model="editorData.pattern" placeholder="Шаблон компонента">
                                        <el-option v-for="(item, code) in blockConfig.patterns" :key="code"
                                            :label="item.label" :value="code">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </span>
                        <span slot="reference">
                            <i class="el-icon-s-operation"></i>
                        </span>
                    </el-popover>
                </div>
                <div class="layout-block-action">
                    <el-popover placement="bottom-end" trigger="click">
                        <span slot="default">
                            <div class="block-params-edit">
                                <div class="block-param-edit">
                                    <el-select v-model="newComponent" filterable allow-create default-first-option
                                        placeholder="Выберите компонент">
                                        <el-option v-for="item in components" :key="item.value + item.label"
                                            :label="item.label" :value="item.value">
                                        </el-option>
                                    </el-select>
                                    <el-button type="primary" icon="el-icon-plus" circle @click="addComponent"></el-button>
                                </div>
                            </div>
                        </span>
                        <span slot="reference">
                            <i class="el-icon-plus"></i>
                        </span>
                    </el-popover>
                </div>
            </div>
        </el-row>
        <draggable v-show="visibleBlock" :class="draggableClass" :key="uniqueKey" v-model="editorData.result"
            :group="draggableBlock" :forceFallback="true" @add="onAdd">
            <vcomponent :predefined="predefined" :key="i" v-for="(block, i) in editorData.result" :block="block"
                :config="config(block)" @on-delete="() => deleteBlock(i)" :movable="false" :presetsAvailable="false">
            </vcomponent>
        </draggable>
    </div>
</template>
  
<script>
import draggable from 'vuedraggable';
import { baseComponents } from '/src/hello.vue';

export default {
    components: baseComponents,
    props: {
        "predefined": {
            type: Boolean,
            default: () => false
        }
    },
    data() {
        return {
            drag: false,
            visibleBlock: true,
            uniqueKey: 100,
            newComponent: null,
            editorData: {
                palette: 'light',
                pattern: 'default',
                direction: 'vertical',
                result: []
            }
        }
    },
    computed: {
        draggableBlock() {
            if (!this.predefined) {
                return 'block';
            }

            return {
                name: `layout-${new Date().getMilliseconds()}`,
                pull: false,
                put: false
            }
        },
        draggableClass() {
            return {
                'drag-start': this.drag,
                'layout-inner': true,
                'inline': this.editorData.direction === 'horizontal'
            }
        },
        components() {
            return BLOCK.map(b => {
                return {
                    label: b.config.name,
                    value: b.componentName,
                }
            })
        }
    },
    created() {
        this.forceRender();
    },
    methods: {
        deleteBlock(i) {
            this.editorData.result.splice(i, 1);
            this.forceRender();
        },
        addComponent() {
            const block = BLOCK.find((b) => {
                return b.componentName === this.newComponent;
            });

            const blueprint = {
                name: block.config.name,
                type: block.componentName,
                patternDisplay: '',
                code: '',
                data: {}
            }

            this.editorData.result = [...this.editorData.result, blueprint];
            this.drag = false;
            this.forceRender();
        },
        config(block) {
            const blockData = BLOCK.find((b) => {
                return b.componentName === block.type;
            })
            return blockData.config.conf
        },
        forceRender() {
            this.uniqueKey = new Date().getMilliseconds();
        },
        onAdd(event) {
            const block = BLOCK.find(block => event.item.outerText === block.config.name);
            let blueprint = {
                name: block.config.name,
                type: block.componentName,
                patternDisplay: '',
                code: '',
                data: {}
            }
            this.editorData.result.splice(event.newIndex, 0, blueprint);
            this.drag = false;
            this.forceRender();
        }
    },
}
</script>

<style>
.layout-inner {
    width: 100%;
    min-width: 100px;
    min-height: 100px;
    display: block;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 25px 5px 5px 5px;
}

.layout {
    position: relative;
}

.layout:hover>.layout-inner {
    border-color: #b3d8ff;
}

.layout-actions {
    display: flex;
    background-color: #ccc;
    padding: 3px;
    border-radius: 5px;
    width: fit-content;
    position: absolute;
    z-index: 100;
    align-items: center;
}

.layout-block-action {
    margin: 0px 5px;
    cursor: pointer;
}

.inline {
    display: flex;
    overflow-x: scroll;
}

.inline>div {
    min-width: 300px;
}

.drag-start {
    border: 1px dashed #ccc;
}
</style>
  
  