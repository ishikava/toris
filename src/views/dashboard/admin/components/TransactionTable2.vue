<template>
  <el-table
    :data="list"
    border
    fit
    highlight-current-row
    style="width: 100%;"
    height="800"
  >
    <el-table-column label="Лента событий" align="center">
      <el-table-column label="Система" show-overflow-tooltip min-width="150" prop="system_name">
        <template slot-scope="{row}">
          <span>{{ row.system_name }}</span>
        </template>
      </el-table-column>

      <el-table-column label="Логин" show-overflow-tooltip min-width="80" prop="login">
        <template slot-scope="{row}">
          <span>{{ row.login }}</span>
        </template>
      </el-table-column>

      <el-table-column label="Действие" show-overflow-tooltip min-width="120" prop="event_name" class-name="relative">
        <template slot-scope="{row}">
          <span class="eventspan">{{ row.event_name }}</span>
          <span class="datespan">{{ row.date }}</span>
        </template>
      </el-table-column>
    </el-table-column>

  </el-table>
</template>

<script>
import { eventList } from '@/api/remote-search2'

export default {
  data() {
    return {
      list: null
    }
  },
  created() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      eventList().then(response => {
        this.list = response.data.items
      })
    }
  }
}
</script>

<style>
  .relative {
    position: relative;
  }

  .datespan {
    position: absolute;
    bottom: -5px;
    left: 10px;
    color: #1890ff;
    font-size: 11px;
  }
  .eventspan {
    position: absolute;
    top: 0;
    left: 10px;
    font-size: 14px;
  }
</style>
