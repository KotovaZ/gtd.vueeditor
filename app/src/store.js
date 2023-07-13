import { reactive } from 'vue'

export const store = reactive({
    draggableObject: null,
    setDraggable(object, type, extra = {}) {
        this.draggableObject = {
            target: object,
            type,
            extra
        }
    }
})

export const baseComponents = BLOCK.reduce((obj, block) => {
    return Object.assign(obj, { [block.componentName]: () => import(block.filePath + '.vue') })
}, {});