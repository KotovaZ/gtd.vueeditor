<template>
  <div class="factoid-preview">
    <div class="factoid-preview__name">
      <span v-if="item.name">{{item.name}}</span>
      <vicon v-else :code="item.icon" width="30" height="30"></vicon>
    </div>
    <div class="factoid-preview__description">
      {{item.description}}
    </div>
  </div>
</template>

<script>
import vicon from "../vicon/vicon.vue";
export default {
  name: "factoid-preview",
  components: { vicon },
  props: {
    item: {
      type: Object,
      default: function () {
        return {
          label: '',
          description: '',
        }
      },
    }
  },
  computed: {
  },
  data: function() {
    return {}
  },
  methods: {
  },

}
</script>

<style>
.factoid-preview {
  width: 170px;
  padding: 10px;
  border: 1px solid black;
  border-radius: 15px;
  cursor: pointer;
  margin: 0 5px;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 100px;
}
.factoid-preview__name {
  padding-bottom: 10px;
  font-size: 24px;
}
</style>