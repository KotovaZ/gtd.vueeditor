<template>
    <div class="v-icon">
        <svg xmlns="http://www.w3.org/2000/svg" :width="width" :height="height">
            <use :href="url" :xlink:href="url">
            </use>
        </svg>
    </div>
</template>
  
<script>
export default {
    name: "vicon",
    props: {
        code: String,
        width: String,
        height: String
    },
    computed: {
        url: function () {
            return `/local/vueeditor/vicon-list/icons.svg#${this.code}`;
        }
    },
    data() {
        return {
            editorData: {
            }
        };
    },
    methods: {
    }

}
</script>
  
<style scoped>
</style>