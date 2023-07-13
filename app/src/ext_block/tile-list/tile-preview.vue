<template>
  <div class="tile-preview">
    <div>
      <div class="tile-preview__name">
        {{item.name}}
      </div>
      <div class="tile-preview__description">
        {{item.description}}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "tile-preview",
  components: { },
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
.tile-preview {
  width: 150px;
  padding: 10px;
  border: 1px solid black;
  border-radius: 15px;
  cursor: pointer;
  margin: 0 5px 5px 0;
  position: relative;
  min-height: 200px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.tile-preview__name {
  padding-bottom: 10px;
  font-size: 24px;
}
</style>