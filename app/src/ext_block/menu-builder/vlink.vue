<template>
    <div class="menu-link">
        <i v-if="!!icon" class="menu-link-icon">
            <vicon :code="icon" width="30px" height="30px" />
        </i>
        <div class="menu-link-title">{{ title }}</div>
        <el-tag v-if="!!tag">{{ tag }}</el-tag>
    </div>
</template>
  
<script>
import vicon from '../vicon/vicon.vue';
export default {
    components: { vicon },
    name: "vlink",
    props: {
        title: String,
        icon: String,
        tag: String
    },
    computed: {
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
.menu-link {
    display: flex;
    justify-content: flex-start;
    flex-wrap: nowrap;
    flex-direction: row;
    align-items: center;
    flex-grow: 1
}

.menu-link-title {
    flex-grow: 1;
}

.menu-link-icon {
    margin-right: 5px;
}
</style>