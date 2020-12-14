<template>
  <div class="components-container">

    <!--
    <div style="margin-bottom: 20px;">Аудит действий пользователей ( данные не подключены )</div>

    <el-row :gutter="32">

      <el-col :xs="24" :sm="24" :lg="12">
        <el-select v-model="listQuery.system" placeholder="Выберите систему" clearable style="width:500px;"
                   class="filter-item">
          <el-option v-for="item in systemOptions" :key="item" :label="item" :value="item"/>
        </el-select>
      </el-col>

      <el-col :xs="32" :sm="32" :lg="12">
        <el-drag-select v-model="value" style="width:500px;" multiple placeholder="Выберите пользователя">
          <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"/>
        </el-drag-select>
        <div style="margin-top:20px; margin-bottom: 20px;">
          <el-tag v-for="item of value" :key="item" style="margin-right:15px;">
            {{ item }}
          </el-tag>
        </div>
      </el-col>

    </el-row>

-->

    <el-row :gutter="32">
      <graph />
    </el-row>

  </div>
</template>

<script>
// import ElDragSelect from '@/components/DragSelect' // base on element-ui
import Graph from './components/Grraph'

export default {
  name: 'DragSelect',
  components: { Graph },
  data() {
    return {
      listQuery: {
        system: undefined
      },
      systemOptions: ['Сиситема 1', 'Сиситема 2', 'Сиситема 3', 'Сиситема 4', 'Сиситема 5'],
      value: [],
      options: [{
        value: 'Иван Иванов1',
        label: 'Иван Иванов1'
      }, {
        value: 'Иван Иванов2',
        label: 'Иван Иванов2'
      }, {
        value: 'Иван Иванов3',
        label: 'Иван Иванов3'
      }, {
        value: 'Иван Иванов4',
        label: 'Иван Иванов4'
      }, {
        value: 'Иван Иванов5',
        label: 'Иван Иванов5'
      }]
    }
  }
}
</script>
