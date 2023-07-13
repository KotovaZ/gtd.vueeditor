<template>
    <div class="engine-preview">
        <el-card shadow="hover">
            <div class="engine-preview__description">
                <span v-if="value.shortName">{{ value.shortName }}</span>
                <span v-else>{{ value.fullName }}</span>
            </div>
        </el-card>
    </div>
</template>

<script>


export default {
    name: "engine-preview",
    components: {},
    props: {
        value: {
            type: Object,
            default: function () {
                return {
                    items: []
                }
            }
        }
    },
    data() {
        return {};
    },
    computed: {},
    methods: {}
}
</script>

<style>
.engine-preview {
}

.engine-preview .engine-preview__description {
    padding-top: 5px;
    width: 200px;
}
</style>