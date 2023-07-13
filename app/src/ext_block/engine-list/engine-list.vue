<template>
    <div class="v-engine-list">
        <div>
            <wrap-list v-model="editorData.items" :validateItem="validateItem" @openPreview="onOpenPreview" @onRemove="$refs['edit-component'].endEdit()"
                       :classNameList="['v-engine-list__list']">
                <template #preview="{item}">
                    <v-engine-preview :value="item"></v-engine-preview>
                </template>

                <template #edit-content="{item, indexItem, onUpdateItem, onAppendIntoList}">
                    <vInline ref="edit-component" @startedit="indexItem = -1"
                             @endedit="$refs['edit-component'].endEdit()">
                        <template #content>
                            <vEngineDetail :key="indexItem" :value="item"
                                           @change="(value) => { onAppendIntoList(value); $refs['edit-component'].endEdit(); }"></vEngineDetail>
                        </template>
                    </vInline>
                </template>
            </wrap-list>
        </div>
    </div>
</template>

<script>

import wrapList from "../_complex-blocks/wrap/list/list.vue";
import vEnginePreview from './engine-preview.vue';
import vEngineDetail from './engine-detail.vue';
import vDialog from '../_complex-blocks/wrap/list/display-modes/dialog.vue'
import vInline from '../_complex-blocks/wrap/list/display-modes/inline.vue'

export default {
    name: "engine-list",
    components: {wrapList, vEnginePreview, vEngineDetail, vDialog, vInline},
    props: {
        value: {
            type: Object,
        }
    },
    created: function () {
        if (Object.values(this.value).length) {
            this.editorData = this.value;
        }
    },

    computed: {},
    data() {
        return {
            editorData: {
                items: []
            },
            element: {},
        };
    },
    methods: {
        validateItem: function (item) {
            return true;
        },
        onOpenPreview: function (params) {
            if (Object.values(params.item).length) {
                this.$refs['edit-component'].startEdit();
            } else {
                this.$refs['edit-component'].endEdit();
            }
        }
    }
}
</script>

<style>
.v-engine-list__list {
    display: flex;
    flex-wrap: wrap;
}

</style>