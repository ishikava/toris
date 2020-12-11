<template>
  <el-table
    :data="list"
    border
    fit
    highlight-current-row
    style="width: 100%;"
    height="400"
  >
    <el-table-column label="Количество активных пользователей" align="center">
      <el-table-column show-overflow-tooltip label="Пользователь">
        <template slot-scope="{row}">
          {{ row.fullname }}
        </template>
      </el-table-column>
      <el-table-column label="Логин" show-overflow-tooltip width="120" align="center">
        <template slot-scope="{row}">
          {{ row.login }}
        </template>
      </el-table-column>
      <el-table-column label="Статус" width="80" align="center">
        <template slot-scope="{row}">
          <span class="status">{{ row.status | statusFilter }}</span>
        </template>
      </el-table-column>
    </el-table-column>
  </el-table>
</template>

<script>
import { activeUsers } from '@/api/remote-search2'

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
      activeUsers().then(response => {
        this.list = response.data.items
      })
    }
  }
}
</script>

<style>
  .status {
    color: #1890ff;
  }
  .el-table__body td{
    padding: 5px 0;
  }
  .el-table__header th{
    padding: 5px 0;
  }
</style>
