import { reactive } from 'vue'
import _ from 'lodash';

export const store = reactive({
    draggableObject: null,
    setDraggable(object, type, extra = {}) {
        this.draggableObject = {
            target: _.cloneDeep(object),
            type,
            extra: _.cloneDeep(extra)
        }
    }
});

export const baseComponents = BLOCK.reduce((obj, block) => {
    return Object.assign(obj, { [block.componentName]: () => import(block.filePath + '.vue') })
}, {});