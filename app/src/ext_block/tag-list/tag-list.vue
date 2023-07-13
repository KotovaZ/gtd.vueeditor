<template>
  <div class="tags">
    <el-row>
      <draggable class="tag-list" v-model="editorData.tags" group="menu" @start="drag = true" @end="drag = false">
        <el-tag :key="i" v-for="(tag, i) in editorData.tags" closable :disable-transitions="false"
                @close="handleClose(tag)" @click="setActiveTag(tag)">
          {{ tag.label }}
        </el-tag>
      </draggable>
    </el-row>
    <el-row v-if="activeTag !== null">
      <VTagDetail v-model="editorData.tags[activeTag]" :key="activeTag" />
    </el-row>
    <el-row>
      <el-col>
        <el-button class="button-new-tag" size="small" @click="appendTag">+ Добавить тег</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>

import VTagDetail from './vtag-detail.vue';
import VIcon from '../vicon/vicon.vue';
import draggable from 'vuedraggable';

export default {
  name: "tag-list",
  components: { VTagDetail, VIcon, draggable },
  props: {
    value: {
      type: Object,
      default: function () {
        return {
          tags: []
        }
      }
    }
  },
  created: function () {
    if (Object.values(this.value).length) {
      this.editorData = this.value;
    }
  },
  watch: {
    editorData: function (value) {
      this.$emit('input', value);
    }
  },
  data() {
    return {
      editorData: {
        tags: []
      },
      activeTag: null,
      inputVisible: false,
      inputValue: ''
    };
  },
  methods: {
    handleClose(tag) {
      const tagIndex = this.editorData.tags.indexOf(tag);
      this.editorData.tags.splice(tagIndex, 1);
      this.activeTag = null;
    },
    setActiveTag(tag) {
      this.activeTag = this.editorData.tags.indexOf(tag);
    },
    appendTag() {
      const newTag = {
        label: '',
        type: 'default',
        icon: null
      };

      this.editorData.tags.push(newTag);
      this.setActiveTag(newTag);
    }
  }
}
</script>

<style>
.tags .el-row {
  margin-bottom: 10px;
}
.tags .tag-list {
  margin-left: -5px;
  margin-right: -5px;
}
.tags .el-tag {
  margin: 5px;
}

.button-new-tag {
  height: 32px;
  line-height: 30px;
  padding-top: 0;
  padding-bottom: 0;
}
</style>