<template>
    <el-card shadow="hover" class="block-wrapper">
        <el-row class="block-header">
            <el-col :span="19">
                <el-divider class="block-header-name" content-position="left">
                    <span v-if="isPattern"><b>Шаблон: {{ block.pattern.name }}</b></span>
                    <span v-else>{{block.name}}</span>

                    <span v-if="block.code">({{ block.code }})</span>
                    <span v-if="block.patternDisplay">({{ patternDisplay }})</span>
                </el-divider>
            </el-col>
            <el-col :span="5" class="block-actions" v-if="!predefined">
                <div class="block-action" v-if="movable">
                    <span @click="() => this.$emit('on-move', 1)"><i class="el-icon-sort-up"></i></span>
                </div>
                <div class="block-action" v-if="movable">
                    <span @click="() => this.$emit('on-move', -1)"><i class="el-icon-sort-down"></i></span>
                </div>
                <div class="block-action" v-if="movable">
                    <span class="handle"> <i class="el-icon-rank"></i></span>
                </div>
                <div class="block-action">
                    <el-popover placement="bottom-end" trigger="click">
                        <span slot="default">
                            <div class="block-params-edit">
                                <div class="block-param-edit">
                                    <el-divider class="block-param-name" content-position="left">Код блока</el-divider>
                                    <el-input size="mini" v-model="block.code"></el-input>
                                </div>
                                <div class="block-param-edit" v-if="config.patterns">
                                    <el-divider class="block-param-name" content-position="left">Шаблон
                                        отображения</el-divider>
                                    <el-select v-model="block.patternDisplay" placeholder="Шаблон отображения">
                                        <el-option v-for="(pattern, code) in config.patterns" :key="code"
                                            :label="pattern.label" :value="code">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </span>
                        <span slot="reference">
                            <i class="el-icon-edit"></i>
                        </span>
                    </el-popover>
                </div>
                <div class="block-action" v-if="presetsAvailable">
                    <el-dropdown @command="(command) => this.$emit('handle-action', command)">
                        <span class="el-dropdown-link"><i class="el-icon-setting el-icon--right"></i></span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item :command="{ 'action': 'save' }">Сохранить
                                пресет</el-dropdown-item>
                            <el-dropdown-item :command="{ 'action': 'load' }">Загрузить
                                пресет</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </div>
                <div class="block-action" v-if="removable">
                    <span class="delete-btn" @click="() => this.$emit('on-delete')"><i class="el-icon-delete"></i></span>
                </div>
            </el-col>
        </el-row>
        <component :predefined="isPattern" :movable="movable" :is="block.type" v-model="block.data" :blockValue="block.data" :blockConfig="config">
        </component>
    </el-card>
</template>
  
<script>
import draggable from 'vuedraggable';
import { baseComponents } from '../store';

export default {
    name: "vcomponent",
    components: { ...baseComponents, draggable },
    props: {
        "config": {
            type: Object,
            default: () => { return {} }
        },
        "block": {
            type: Object,
            default: () => { return {} }
        },
        "wrapped": {
            type: Boolean,
            default: () => false
        },
        "movable": {
            type: Boolean,
            default: () => true
        },
        "removable": {
            type: Boolean,
            default: () => true
        },
        "presetsAvailable": {
            type: Boolean,
            default: () => true
        },
        "predefined": {
            type: Boolean,
            default: () => false
        }
    },
    data() {
        return {
            groups: []
        }
    },
    methods: {
    },
    mounted() {
    },
    watch: {
    },
    computed: {
        patternDisplay() {
            let config = this.config(block);

            if (!this.config || !this.config.hasOwnProperty('patterns'))
                return '';

            return this.config.patterns[this.block.patternDisplay].label
        },
        isPattern() {
            return !!this.block.pattern;
        }
    }
} 
</script>
<style>
.patterns-drawer .el-drawer__wrapper {
    max-width: 600px !important;
}

.patterns {
    width: 100% !important;
}
</style>
  