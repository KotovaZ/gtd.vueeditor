<template>
    <div style="display: flex;">
       <color v-model="editorData.color"></color>
       <vInput v-model="editorData.text"></vInput>
    </div>
</template>
  
<script>
import color from "../color/color.vue"
import vInput from "../vinput/vinput.vue"
export default {
    name: "vLegend",
    components: {color, vInput},
    props: ["value", "predefineColors"],
    created() {
        if (this.value && Object.values(this.value).length) {
            this.editorData = this.value;
        }
    },
    computed: {
    },
    data() {
        return {
            editorData: {
                color: "",
                text: ""
            }
        }
    },
    methods: {
    },

}
</script>
  
<style scoped>
</style>