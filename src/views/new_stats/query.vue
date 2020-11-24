<template>
  <div class="app-container">
    <el-table :data="list">
      <el-table-column label="Система" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.system | substrFilter }}</span>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { statsList } from '@/api/remote-search'
export default {
  name: 'ComplexTable',
  data() {
    return {
      list: null,
      total: 0,
      listQuery: {
        page: 1,
        limit: 20
      }
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      statsList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data.total
      })
    }
  }
}
</script>
