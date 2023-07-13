<template>
  <div>
    <div style="margin-left: -5px; margin-right: -5px">
      <draggable v-model="editorData.items" group="buttons" @start="drag = true" @end="drag = false">
        <el-popover placement="top" trigger="hover" v-for="(button, index) in editorData.items"
                    :key="`v-button-${index}`"
                    popper-class="v-button__popover"
                    :open-delay=250>
          <div style="text-align: right; margin: 0">
            <el-button size="mini" icon="el-icon-delete" type="danger" plain @click="onRemove(index)">
            </el-button>
          </div>
          <el-button slot="reference" plain
                     @click="onOpenDialog(index)" :key="index"
                     style="margin: 5px"
          >
            {{button.text}}
          </el-button>
        </el-popover>
      </draggable>
    </div>

    <el-button type="primary" plain @click="onOpenDialog()">
      Добавить кнопку
    </el-button>

    <el-dialog title="Настройки кнопки" :visible.sync="dialogVisible" width="30%" append-to-body>
        <v-button :button="button"
                  @update:button="onSave($event)"
                  :key="btnIndex"
                  :onParentSave="onCloseDialog"
                  :onParentCancel="onCloseDialog">
        </v-button>
    </el-dialog>

  </div>
</template>

<script>
import vButton from "./vbutton.vue"
import draggable from 'vuedraggable';
export default {
  name: "vbuttons",
  components: { vButton, draggable },
  props: {
    value: {
      type: Object,
      default: function () {
        return {};
      }
    }
  },
  computed: { },
  async created() {
    if (Object.values(this.value).length) {
      this.editorData = this.value;
    }
  },
  data() {
    return {
      editorData: {
        items: []
      },
      button: {},
      isNewButton: false,
      btnIndex: -1,
      dialogVisible: false,
    };
  },
  methods: {
    onSave: function (button) {
      this.button = button;
      if (this.isNewButton) {
        this.editorData.items.push(button);
        this.btnIndex = this.editorData.items.length - 1;
      }
    },
    onRemove: function (index) {
      this.editorData.items.splice(index, 1);
    },
    onOpenDialog: function (btnIndex = -1) {
      this.dialogVisible = true;
      this.isNewButton = btnIndex < 0;
      this.btnIndex = btnIndex;
      if (!this.isNewButton) {
        this.button = this.editorData.items[btnIndex];
      } else {
        this.button = {}
      }
    },
    onCloseDialog: function () {
      this.dialogVisible = false;
    }
  },
}
</script>

<style>
.v-button__popover {
  min-width: 40px;
  width: 40px;
}
</style>