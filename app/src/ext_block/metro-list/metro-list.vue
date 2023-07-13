<template>
    <div>
      <div class="v-station-list">
        <div class="v-station-list-item" v-for="(station, index) in editorData.stations" :key="index">
          <div>
            <station
                :name="station.name" v-on:update:name="station.name = $event"
                :color="station.color" v-on:update:color="station.color = $event"
                :distance="station.distance" v-on:update:distance="station.distance = $event"
            >
            </station>
          </div>
          <div>
            <el-popconfirm
                title="Удалить станцию метро?"
                confirm-button-text='Да'
                cancel-button-text='Нет'
                hide-icon
                @confirm="onDeleteStation(index)"
            >
              <el-button plain type="danger" slot="reference" icon="el-icon-delete"></el-button>
            </el-popconfirm>

          </div>
        </div>
      </div>
        <el-button plain icon="el-icon-plus" class="v-station-append" @click="onAddStation">
            Добавить станцию метро
        </el-button>
    </div>
</template>
  
<script>
import station from '../metro-station/station.vue';

export default {
    name: "metro-list",
    components: { station },
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
        }
    },
    computed: {
    },
    data() {
        return {
            editorData: {
                stations: []
            }
        };
    },
    methods: {
        onAddStation: function () {
          const station = {
            name: '',
            distance: '',
            color: ''
          };
          this.editorData.stations.push(station);
        },
        onDeleteStation: function (index)
        {
          this.editorData.stations.splice(index, 1);
        }
    },

}
</script>
  
<style scoped>
.v-station-list {
  padding-bottom: 10px;
}
.v-station-list-item {
  padding: 5px 0;
  display: flex;
  justify-content: space-between;
}
.v-station {
  display: flex;
}
</style>