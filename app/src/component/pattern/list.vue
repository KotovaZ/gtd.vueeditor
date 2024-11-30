<template>
  <div class="patterns-container">
    <draggable
      group="block"
      handle=".handle"
      :key="$vnode.key"
      :group="{ name: 'block', pull: 'clone', put: false }"
      :forceFallback="true"
      @start="onStartDrag"
      :disabled="disableDraggable"
    >
      <div
        v-for="pattern in patterns"
        :key="pattern.id"
        shadow="never"
        class="handle pattern"
        :group="$vnode.key"
        :pattern="pattern.id"
      >
        <span @click="() => onClick(pattern)">{{ pattern.name }}</span>
        <img
          v-if="showPreview && !!pattern.preview_picture"
          :src="pattern.preview_picture.src"
          style="width: 100%"
        />
      </div>
    </draggable>
  </div>
</template>

<script>
import draggable from "vuedraggable";

import { store } from "../../store.js";

export default {
  name: "patterns",
  components: { draggable },
  props: {
    patterns: {
      type: Array,
      default: [],
    },
    showPreview: {
      type: Boolean,
      default: true,
    },
    disableDraggable: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      input: "",
      groups: [],
    };
  },
  methods: {
    onStartDrag(event) {
      this.$emit("onStartDrag", event);
    },
    onClick(event) {
      this.$emit("onClick", event);
    },
  },
  mounted() {},
  watch: {},
  computed: {
    searchMode() {
      return !!this.input;
    },
    components() {
      console.log(this.patterns);
    },
  },
};
</script>

<style>
.patterns-container {
  overflow-y: auto;
  height: 100%;
}

.pattern {
    margin: 0px 0px 10px 0px;
    padding: 10px;
    background: #f0f4f4;
    border-radius: 5px;
    cursor: pointer;
    user-select: none;
}

.pattern span {
    color: #4d4d4d;
}

.pattern img {
    margin-top: 5px;
}
</style>
