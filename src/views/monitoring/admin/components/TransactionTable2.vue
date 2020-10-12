<template>
  <el-table :data="list" style="width: 100%;padding-top: 15px; height: 706px; overflow: auto;">
    <el-table-column label="Пользователь" min-width="95">
      <template slot-scope="scope">
        {{ scope.row.user | orderNoFilter }}
      </template>
    </el-table-column>
    <el-table-column label="Система" width="160" align="center">
      <template slot-scope="scope">
        {{ scope.row.system | orderNoFilter }}
      </template>
    </el-table-column>
    <el-table-column label="Действие" width="75" align="center">
      <template slot-scope="scope">
        {{ scope.row.event }}
      </template>
    </el-table-column>
    <el-table-column label="Дата" width="95" align="center">
      <template slot-scope="scope">
        {{ scope.row.date }}
      </template>
    </el-table-column>
    <el-table-column label="" width="15" align="center">
    </el-table-column>
  </el-table>
</template>

<script>
import { eventList } from '@/api/remote-search'

export default {
  filters: {
    statusFilter(status) {
      const statusMap = {
        success: 'success',
        pending: 'danger'
      }
      return statusMap[status]
    },
    orderNoFilter(str) {
      return str.substring(0, 35)
    }
  },
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
        this.list = response.data.items.slice(0, 20)
      })
    }
  }
}
</script>
