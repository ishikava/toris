<template>
  <div class="app-container">

    <div class="components-container">
      <el-drag-select v-model="choose_system_value" multiple placeholder="Система" style="width: 33%;">
        <el-option v-for="item in choose_system_options" :key="item.value" :label="item.label" :value="item.value" />
      </el-drag-select>

      <div>
        <el-tag v-for="item of choose_system_value" :key="item" style="margin-top: 10px;">
          {{ item }}
        </el-tag>
      </div>
    </div>
  </div>
</template>

<script>
import ElDragSelect from '@/components/DragSelect'

export default {
  name: 'Stats',
  components: { ElDragSelect },

  data() {
    return {

      choose_system_value: [],
      choose_system_options: [{
        value: 'Apple',
        label: 'Apple'
      }, {
        value: 'Banana',
        label: 'Banana'
      }, {
        value: 'Orange',
        label: 'Orange'
      }, {
        value: 'Pear',
        label: 'Pear'
      }, {
        value: 'Strawberry',
        label: 'Strawberry'
      }]
    }
  }
}
</script>
