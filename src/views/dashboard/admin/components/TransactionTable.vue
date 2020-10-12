<template>
  <el-table :data="list" style="width: 100%; height: 316px; overflow: auto;">
    <el-table-column label="Имя" min-width="180">
      <template slot-scope="scope">
        {{ scope.row.user | orderNoFilter }}
      </template>
    </el-table-column>
    <el-table-column label="Роль" width="140" align="center">
      <template slot-scope="scope">
        {{ scope.row.role }}
      </template>
    </el-table-column>
    <el-table-column label="Статус" width="100" align="center">
      <template slot-scope="{row}">
        <el-tag :type="row.status | statusFilter">
          {{ row.status }}
        </el-tag>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
import { activeUsers } from '@/api/remote-search'

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
      return str.substring(0, 30)
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
      activeUsers().then(response => {
        this.list = response.data.items.slice(0, 20)
      })
    }
  }
}
</script>
