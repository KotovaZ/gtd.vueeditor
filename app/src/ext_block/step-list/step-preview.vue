<template>
  <div class="step-preview">
    <div>
      <div class="step-preview__name">
        {{item.name}}
      </div>
      <div class="step-preview__description">
        {{item.description}}
      </div>
    </div>
    <div>
      <div v-if="item.detailDescription">
        Подробное описание
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "step-preview",
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
.step-preview {
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
.step-preview__name {
  padding-bottom: 10px;
  font-size: 24px;
}
</style>