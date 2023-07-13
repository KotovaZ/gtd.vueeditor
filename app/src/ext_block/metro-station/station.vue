<template>
  <div class="v-station">
    <div>
      <el-tooltip class="item" effect="dark" content="Название станции и цвет ветки" placement="top" :open-delay=250>
        <el-input placeholder="м. Красногвардейская" :value="name" @input="onChangeName">
          <el-color-picker
              size="mini"
              slot="prepend"
              :value="color"
              @active-change="onChangeColor"
              :predefine="predefineColors">
          </el-color-picker>
        </el-input>
      </el-tooltip>
    </div>
    <div>
      <el-tooltip class="item" effect="dark" content="Расстояние до станции" placement="top" :open-delay=250>
        <el-input
            placeholder="120 м"
            :value="distance"
            @input="onChangeDistance"
        ></el-input>
      </el-tooltip>
    </div>
  </div>
</template>

<script>
export default {
  name: "station",
  props: {
    name: String,
    color: String,
    distance: String
  },
  computed: {

  },
  data() {
    return {
      predefineColors: [
        '#EF161E',
        '#2DBE2C',
        '#0078BE',
        '#00BFFF',
        '#8D5B2D',
        '#ED9121',
        '#800080',
        '#FFD702',
        '#999999',
        '#99CC00',
        '#82C0C0',
        '#231F20',
        '#A1B3D4',
        '#9999FF',
        '#FFFFFF',
        '#DE64A1',
        '#DB896E',
        '#506CA5'
      ]
    };
  },
  methods: {
    onChangeName: function (value) {
      this.$emit('update:name', value);
    },
    onChangeColor: function (value) {
      this.$emit('update:color', value);
    },
    onChangeDistance: function (value) {
      this.$emit('update:distance', value);
    },
  }
}
</script>

<style scoped>
</style>