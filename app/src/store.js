import { reactive } from 'vue'

export const store = reactive({
    dragableObject: null,
    setDragable(object, type, extra = {}) {
        this.dragableObject = {
            target: object,
            type,
            extra
        }
    }
})

export const baseComponents = BLOCK.reduce((obj, block) => {
    return Object.assign(obj, { [block.componentName]: () => import(block.filePath + '.vue') })
}, {});