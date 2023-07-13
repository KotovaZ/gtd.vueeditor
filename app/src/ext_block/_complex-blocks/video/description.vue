<template>
  <div>
    <h2>Описание видео:</h2>
    <el-form class="v-video-description__form" :rules="rules" ref="v-video-description__form" :model="editorData" label-position="top">
      <el-form-item label="Заголовок:" prop="name">
        <el-input placeholder="Заголовок:" v-model="editorData.name"></el-input>
      </el-form-item>
      <el-form-item label="Описание:" prop="description">
        <el-input type="textarea" :rows="5" placeholder="Описание:" v-model="editorData.description"></el-input>
      </el-form-item>
      <el-form-item label="Дата:" prop="date">
        <el-date-picker
            v-model="editorData.date"
            type="date"
            placeholder="Выберите дату"
            class="el-date-picker"
            :picker-options="pickerOptions"
            format="dd.MM.yyyy"
        >
        </el-date-picker>
      </el-form-item>
    </el-form>

    <el-descriptions title="Информация о видео:">
      <el-descriptions-item label="Продолжительность">{{ editorData.duration }}</el-descriptions-item>
    </el-descriptions>
  </div>
</template>

<script>


export default {
  name: "v-video-description",
  components: { },
  props: {
    value: Object,
    videoDOM: [ Object, HTMLVideoElement ]
  },
  computed: {
    durationVideo: function () {
      return this.videoDOM.duration;
    }
  },
  watch: {
    durationVideo: function (value) {
      this.editorData.duration = this.formatDurationVideo(value);
    }
  },
  data() {
    return {
      editorData: {
        name: '',
        description: '',
        duration: '',
        date: ''
      },
      pickerOptions: {
        firstDayOfWeek: 1
      },
      rules: {
        name: [
          { required: true, message: 'Укажите заголовок', trigger: 'blur' },
        ]
      }
    };
  },
  methods: {
    formatDurationVideo(durationVideo) {
      function num(val){
        val = Math.floor(val);
        return val < 10 ? '0' + val : val;
      }

      let hours = durationVideo / 3600  % 24,
          minutes = durationVideo / 60 % 60,
          seconds = durationVideo % 60;

      let formattedDuration = num(minutes) + ":" + num(seconds);
      if (Math.floor(hours) > 0) {
        formattedDuration = num(hours) + ":" + formattedDuration;
      }

      return formattedDuration;
    }
  },
  async created() {
    if (this.value && Object.values(this.value).length) {
      this.editorData = this.value;
    }
  }
}
</script>
<style>
.v-video-description__form .el-form-item__label {
  line-height: 16px;
  padding-bottom: 5px;
}
.v-video-description__form .el-date-picker .el-input__inner {
  padding-left: 30px !important;
  padding-right: 30px !important;
}
</style>