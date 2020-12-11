<template>
  <div class="dashboard-editor-container">

    <el-row :gutter="32">

      <el-col :xs="24" :sm="24" :lg="16">

        <el-col :xs="24" :sm="24" :lg="12">
          <div class="chart-wrapper">
            <event-type-relation />
          </div>
        </el-col>

        <el-col :xs="24" :sm="24" :lg="12">
          <transaction-table />
        </el-col>

        <el-col :xs="24" :sm="24" :lg="12">
          <div class="chart-wrapper">
            <event-type-by-user />
          </div>
        </el-col>
        <el-col :xs="24" :sm="24" :lg="12">
          <div class="chart-wrapper">
            <event-count-by-user />
          </div>
        </el-col>

      </el-col>

      <el-col :xs="24" :sm="24" :lg="8">
        <transaction-table2 />
      </el-col>

    </el-row>

  </div>
</template>

<script>
import TransactionTable from './components/TransactionTable'
import TransactionTable2 from './components/TransactionTable2'
import EventTypeRelation from './components/EventTypeRelation'
import EventTypeByUser from './components/EventTypeByUser'
import EventCountByUser from './components/EventCountByUser'

const lineChartData = {
  newVisitis: {
    expectedData: [100, 120, 161, 134, 105, 160, 165],
    actualData: [120, 82, 91, 154, 162, 140, 145]
  },
  messages: {
    expectedData: [200, 192, 120, 144, 160, 130, 140],
    actualData: [180, 160, 151, 106, 145, 150, 130]
  },
  purchases: {
    expectedData: [80, 100, 121, 104, 105, 90, 100],
    actualData: [120, 90, 100, 138, 142, 130, 130]
  },
  shoppings: {
    expectedData: [130, 140, 141, 142, 145, 150, 160],
    actualData: [120, 82, 91, 154, 162, 140, 130]
  }
}

export default {
  name: 'DashboardAdmin',
  components: {
    TransactionTable,
    TransactionTable2,
    EventTypeRelation,
    EventTypeByUser,
    EventCountByUser
  },
  data() {
    return {
      lineChartData: lineChartData.newVisitis
    }
  },
  methods: {
    handleSetLineChartData(type) {
      this.lineChartData = lineChartData[type]
    }
  }
}
</script>

<style lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  position: relative;

  .github-corner {
    position: absolute;
    top: 0px;
    border: 0;
    right: 0;
  }

  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }

}

@media (max-width: 1024px) {
  .chart-wrapper {
    padding: 8px;
  }
}
</style>
