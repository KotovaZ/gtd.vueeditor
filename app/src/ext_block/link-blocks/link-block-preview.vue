<template>
  <div class="v-link-block-preview"
       @mouseover="onHover"
       @mouseout="onResetHover">
    <div class="v-link-block-preview__name">
      {{item.name}}
    </div>
    <div class="v-link-block-preview__description">
      {{item.description}}
    </div>
    <div class="v-link-block-remove"
         :class="classObjectBtnRemove"
         @click.stop="onRemove(item)"
         @mouseover="onHoverBtnRemove"
         @mouseout="onResetHoverBtnRemove">
      <i class="el-icon-close"></i>
    </div>
  </div>
</template>

<script>

export default {
  name: "v-link-block-preview",
  components: { },
  props: {
    item: {
      type: Object,
      default: function () {
        return {
          name: '',
          description: '',
          hoverBackgroundColor: '',
          hoverColor: ''
        }
      },
    }
  },
  computed: {
    classObjectBtnRemove: function () {
      return {
        'hover': this.isHoverBtnRemove
      }
    }
  },
  data: function() {
    return {
      isHoverBtnRemove: false
    }
  },
  methods: {
    onHover: function () {
      this.$el.style.background = this.item.hoverBackgroundColor;
      this.$el.style.color = this.item.hoverColor;
    },
    onResetHover: function () {
      this.$el.style.background = '#fff';
      this.$el.style.color = '#000';
    },
    onHoverBtnRemove: function () {
      this.isHoverBtnRemove = true;
    },
    onResetHoverBtnRemove: function () {
      this.isHoverBtnRemove = false;
    },
    onRemove: function (item) {
      this.$emit('remove', item)
    }
  },

}
</script>

<style>
.v-link-block-preview {
  width: 170px;
  padding: 10px;
  border: 1px solid black;
  border-radius: 15px;
  cursor: pointer;
  margin: 0 5px;
  position: relative;
}
.v-link-block-preview__name {
  padding-bottom: 10px;
}
.v-link-block-remove {
  position:absolute;
  top: 5px;
  right: 5px;
  padding: 3px;
}
.v-link-block-remove.hover {
  border-radius: 10px;
  border: 1px solid;
  padding: 2px;
}
</style>