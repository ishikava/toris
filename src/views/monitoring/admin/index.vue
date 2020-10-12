<template>
  <div class="dashboard-editor-container">

    <el-row :gutter="32">

      <el-col :xs="24" :sm="24" :lg="16">

        <el-col :xs="24" :sm="24" :lg="12">
          <div class="chart-wrapper">
            <event-type-by-user />
          </div>
        </el-col>

        <el-col :xs="24" :sm="24" :lg="12">
          <div class="chart-wrapper">
            <event-type-relation />
          </div>
        </el-col>

        <el-col :xs="24" :sm="24" :lg="24">
          <div class="chart-container">
            <chart height="100%" width="100%" />
          </div>
        </el-col>

      </el-col>

      <el-col :xs="24" :sm="24" :lg="8">
        <div class="chart-wrapper">
          <event-type-relation2 />
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :lg="8">
        <div class="chart-wrapper">
          <event-type-relation3 />
        </div>
      </el-col>

    </el-row>

  </div>
</template>

<script>
import GithubCorner from '@/components/GithubCorner'
import PanelGroup from './components/PanelGroup'
import LineChart from './components/LineChart'
import RaddarChart from './components/RaddarChart'
import PieChart from './components/PieChart'
import BarChart from './components/BarChart'
import TransactionTable from './components/TransactionTable'
import TransactionTable2 from './components/TransactionTable2'
import TodoList from './components/TodoList'
import BoxCard from './components/BoxCard'
import EventTypeRelation from './components/EventTypeRelation'
import EventTypeRelation2 from './components/EventTypeRelation2'
import EventTypeRelation3 from './components/EventTypeRelation3'
import EventTypeByUser from './components/EventTypeByUser'
import EventCountByUser from './components/EventCountByUser'
import Chart from '@/components/Charts/MixChart'

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
    GithubCorner,
    PanelGroup,
    LineChart,
    RaddarChart,
    PieChart,
    BarChart,
    TransactionTable,
    TransactionTable2,
    TodoList,
    BoxCard,
    EventTypeRelation,
    EventTypeRelation2,
    EventTypeRelation3,
    EventTypeByUser,
    EventCountByUser,
    Chart
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
  background-color: rgb(240, 242, 245);
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
.chart-container{
  position: relative;
  width: 100%;
  height: calc(50vh - 30px);
}
</style>
