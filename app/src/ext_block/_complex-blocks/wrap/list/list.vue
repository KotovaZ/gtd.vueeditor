<template>
  <div>
    <draggable v-model="items" group="wrap-list" @start="drag = true" @end="drag = false" :class="classNameList">
      <el-popover placement="top" trigger="hover" v-for="(item, index) in items" :key="`wrap-list-element-${index}`"
        popper-class="wrap-list__popover" :open-delay=250>
        <div style="text-align: right; margin: 0">
          <el-button size="mini" icon="el-icon-delete" type="danger" plain @click="onRemoveItem(index)"></el-button>
        </div>
        <div slot="reference" :key="index">
          <div @click="onOpenPreview(index)" class="wrap-list__preview" :class="{active: activeItem === item}">
            <slot name="preview" :item="item">
              {{ item }}
            </slot>
          </div>
        </div>
      </el-popover>
    </draggable>

    <div class="wrap-list__edit-content">
      <slot name="edit-content" :indexItem="activeItemIndex" :item="activeItem" :onUpdateItem="onUpdateItem"
        :onAppendIntoList="onAppendIntoList" :onResetActiveItem="resetActiveItem">
      </slot>
    </div>
  </div>
</template>

<script>

import draggable from 'vuedraggable';

export default {
  components: { draggable },
  name: "list-wrap",
  props: {
    value: {
      type: Array,
      default: function () {
        return []
      }
    },
    validateItem: {
      type: Function,
      default: function () {
        return true
      }
    },
    classNameList: {
      type: Array,
      default: function () {
        return []
      }
    }
  },
  computed: {
  },
  data() {
    return {
      items: this.value,
      activeItem: {},
      activeItemIndex: -1
    }
  },
  methods: {
    onUpdateItem: function (value) {
      this.activeItem = Object.assign(this.activeItem, value)
    },
    onAppendIntoList: function () {
      if (!this.items.includes(this.activeItem)) {
        if (this.validateItem(this.activeItem)) {
          this.$set(this.items, this.items.length, this.activeItem)
        }
      }

      this.resetActiveItem();
    },
    resetActiveItem: function () {
      this.activeItemIndex = this.items.length;
      this.activeItem = Object.assign({}, {});
    },
    onRemoveItem: function (index) {
      this.items.splice(index, 1);
      this.$emit('input', this.items)
      this.$emit('onRemove');
    },
    onOpenPreview: function (indexItem) {
      if (this.activeItem === this.items[indexItem]) {
        this.activeItem = Object.assign({}, {});
      } else {
        this.activeItem = this.items[indexItem];
      }
      this.activeItemIndex = indexItem;
      this.$emit('openPreview', { item: this.activeItem });
    },
  }
}
</script>

<style>
.wrap-list__popover {
  min-width: 40px;
  width: 40px;
}

.wrap-list__edit-content {
  padding: 10px 0;
}
.wrap-list__preview {
    cursor: pointer;
    margin: 0 5px 5px 0;
}
.wrap-list__preview.active {
    border-radius: 4px;
    border: 1px solid #b3d8ff;
    overflow: hidden;
    color: #303133;
    -webkit-transition: .3s;
    transition: .3s;
    box-shadow: 0 2px 12px 0 rgba(0,0,0,.1);
}
</style>
