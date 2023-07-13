<template>
    <div>
        <el-button plain class="v-icon-append" :filled="notEmpty" @click="dialogVisible = true">
            <vicon v-if="notEmpty" :code="editorData.icons[0]" width="30" height="30"></vicon>
            Выбрать иконку
        </el-button>

        <el-dialog title="Выберите иконку" :visible.sync="dialogVisible" width="35%" append-to-body>
            <el-input placeholder="Поиск по коду" v-model="input" class="icon-search-field"></el-input>
            <div class="v-icon-list">
                <div class="v-icon-list-item" v-for="(code, i) in iconsList" :key="code" v-on:click="onChange(code)"
                    :active="editorData.icons.includes(code)" :code="code">
                    <el-tooltip class="item" effect="dark" :content="code" placement="bottom-start">
                        <vicon :code="code" width="30" height="30"></vicon>
                    </el-tooltip>
                </div>
            </div>
        </el-dialog>
        <div class="v-icon-list" v-if="multiple">
            <div class="v-icon-list-item" v-for="(code, i) in editorData.icons" :key="code">
                <vicon :code="code" width="30" height="30"></vicon>
            </div>
        </div>
    </div>
</template>
  
<script>
import vicon from '../vicon/vicon.vue';

export default {
    name: "vicon-list",
    components: { vicon },
    props: {
        multiple: {
            type: Boolean,
            default() {
                return false;
            }
        },
        checked: {
            type: Array,
            default() {
                return []
            }
        },
        value: {
            type: Array,
            default() {
              return []
            }
        }
    },
    computed: {
        notEmpty: function () {
            return this.editorData.icons.length > 0;
        },
        iconsList: function () {
            if (!this.input)
                return this.icons;

            return this.icons.filter(icon => icon.includes(this.input));
        }
    },
    data() {
        return {
            editorData: {
                icons: []
            },
            input: '',
            dialogVisible: false,
            icons: []
        };
    },
    methods: {
        onChange: function (code) {
            if (this.editorData.icons.includes(code)) {
                this.editorData.icons = this.editorData.icons.filter(item => item !== code);
            } else {
              if (this.multiple) {
                this.editorData.icons.push(code);
              } else {
                this.editorData.icons = [code];
                this.dialogVisible = false;
              }
            }

            let result = {};
            if (this.multiple) {
                result.icon = this.editorData.icons;
            } else {
                result.icon = this.editorData.icons.length > 0 ? this.editorData.icons[0] : null;
            }

            this.$emit('change', result);
        },
        handleClose(done) {
            console.log(done);
        }
    },
    async created() {
        this.editorData = {
            icons: []
        };
        if (!this.checked.length && this.value?.icons) {
          this.checked = this.value.icons;
        }

        if (this.checked.length > 0) {
            this.editorData.icons = this.checked.filter(item => !!item);
        }

        fetch('/local/vueeditor/vicon-list/icons.svg')
            .then(res => res.blob())
            .then(blob => {
                blob.text().then(svgText => {
                    const icons = [];
                    const regex = /symbol\s+id="(.*?)"/gm;
                    let item;

                    while ((item = regex.exec(svgText)) !== null) {
                        icons.push(item[1])
                    }

                    this.icons = icons;
                });
            });
    }
}
</script>
  
<style scoped>
.icon-search-field {
    margin-bottom: 10px;
}
.v-icon-append {
    position: relative;
}

.v-icon-append[filled] {
    padding-left: 40px;
}

.v-icon-append .v-icon {
    position: absolute;
    left: 4px;
    top: 4px;
}

.v-icon-list {
    display: flex;
    flex-wrap: wrap;
    overflow: auto;
}

.v-icon-list-item {
    width: 30px;
    height: 30px;
    margin: 3px;
    padding: 3px;
    background: #ccc;
    border-radius: 5px;
}

.v-icon-list-item[active] {
    background: #77baed;
}
</style>