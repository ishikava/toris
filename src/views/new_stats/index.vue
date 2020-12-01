<template>
  <div class="app-container">

    <div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <el-input v-model="listQuery.search" placeholder="Поиск по Логину или ФИО" class="filter-item" @keyup.enter.native="getData" />
        </div>
        <div class="clear_x el-icon-close" @click="clear_search" />
      </div>
      <div class="components-container-wrapper">
        <div class="components-container">
          <div class="block">
            <el-date-picker
              v-model="dates"
              value-format="yyyy-MM-dd HH:mm:ss"
              type="datetimerange"
              :picker-options="pickerOptions"
              range-separator="|"
              start-placeholder="Дата"
              end-placeholder="Дата"
              align="right"
            />
          </div>
        </div>
        <div class="clear_x el-icon-close" @click="clear_dates" />
      </div>
      <div class="components-container-wrapper">
        <div class="components-container">
          <el-button class="filter-item search_btn" type="primary" icon="el-icon-search" @click="getData">Сформировать отчет</el-button>

          <el-button :loading="downloadLoading" class="filter-item download_btn" type="primary" icon="el-icon-download" @click="handleDownload">Скачать отчет .xlsx</el-button>
        </div>
      </div>

    </div>
    <div class="clearfix" />

    <div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <el-drag-select v-model="choose_systems_value" multiple placeholder="Система" style="width: 100%;">
            <el-option v-for="item in choose_systems" :key="item" :label="item" :value="item" />
          </el-drag-select>

          <div>
            <el-tag v-for="item of choose_systems_value" :key="item" style="margin-top: 10px; margin-right: 5px;">
              {{ item }}
            </el-tag>
          </div>
        </div>
        <div class="clear_x el-icon-close" @click="clear_systems" />
      </div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <el-drag-select v-model="choose_iogvs_value" multiple placeholder="ИОГВ" style="width: 100%;">
            <el-option v-for="item in choose_iogvs" :key="item" :label="item" :value="item" />
          </el-drag-select>

          <div>
            <el-tag v-for="item of choose_iogvs_value" :key="item" style="margin-top: 10px; margin-right: 5px;">
              {{ item }}
            </el-tag>
          </div>
        </div>
        <div class="clear_x el-icon-close" @click="clear_iogvs" />
      </div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <el-drag-select v-model="choose_events_value" multiple placeholder="Действие" style="width: 100%;">
            <el-option v-for="item in choose_events" :key="item" :label="item" :value="item" />
          </el-drag-select>

          <div>
            <el-tag v-for="item of choose_events_value" :key="item" style="margin-top: 10px; margin-right: 5px;">
              {{ item }}
            </el-tag>
          </div>
        </div>
        <div class="clear_x el-icon-close" @click="clear_events" />
      </div>

    </div>
    <div class="clearfix" />

    <el-table
      v-loading="listLoading"
      :data="data_list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
      @sort-change="sortChange"
    >

      <el-table-column v-if="showId" label="ID" align="center" min-width="50" sortable="custom" prop="id" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showSystem" label="Система" min-width="180" sortable="custom" prop="systems" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.systems }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showIogv" label="ИОГВ" min-width="180" sortable="custom" prop="iogv" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.iogv }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showFio" label="ФИО пользователя" min-width="180" sortable="custom" prop="fio" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.fio }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showLogin" label="Логин" align="center" min-width="120" sortable="custom" prop="login" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.login }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showDate" label="Дата" align="center" min-width="120" sortable="custom" prop="dates" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.dates }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showEvent" label="Действие" align="center" min-width="180" sortable="custom" prop="events" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <el-tooltip placement="top">
            <div slot="content">{{ row.info }}</div>
            <el-button class="info">info</el-button>
          </el-tooltip>

          <span>{{ row.events }}</span>
        </template>
      </el-table-column>

    </el-table>

    <div>
      <div class="components-container-wrapper2">
        <div class="components-container2">
          <el-checkbox v-model="showId" class="filter-item">
            ID
          </el-checkbox>
          <el-checkbox v-model="showSystem" class="filter-item">
            Система
          </el-checkbox>
          <el-checkbox v-model="showIogv" class="filter-item">
            ИОГВ
          </el-checkbox>
          <el-checkbox v-model="showFio" class="filter-item">
            ФИО
          </el-checkbox>
          <el-checkbox v-model="showLogin" class="filter-item">
            Логин
          </el-checkbox>
          <el-checkbox v-model="showDate" class="filter-item">
            Дата
          </el-checkbox>
          <el-checkbox v-model="showEvent" class="filter-item">
            Действие
          </el-checkbox>
        </div>
      </div>

      <div class="components-container-wrapper2">
        <div class="components-container2" />
      </div>

    </div>
    <div class="clearfix" />

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getData" />

  </div>
</template>

<script>
import ElDragSelect from '@/components/DragSelect'
import { getData, getEvents, getIogvs, getSystems } from '@/api/remote-search2'
import Pagination from '@/components/Pagination'
import { parseTime } from '@/utils'

export default {
  name: 'Stats',
  components: { ElDragSelect, Pagination },

  data() {
    return {
      downloadLoading: false,

      choose_systems: null,
      choose_iogvs: null,
      choose_events: null,
      choose_systems_value: [],
      choose_iogvs_value: [],
      choose_events_value: [],
      dates: [],

      total: 0,
      data_list: null,
      data_list_no_limit: null,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        systems: null,
        iogvs: null,
        events: null,
        search: null,
        start_date: null,
        end_date: null,
        sort: null
      },
      listQueryNoLimit: {},
      showId: true,
      showSystem: true,
      showIogv: true,
      showFio: true,
      showLogin: true,
      showDate: true,
      showEvent: true,

      pickerOptions: {
        shortcuts: [{
          text: 'За 7 дней',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: 'За 1 месяц',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: 'За 3 месяца',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
            picker.$emit('pick', [start, end])
          }
        }]
      }
    }
  },
  created() {
    this.getSystems()
    this.getIogvs()
    this.getEvents()
    this.getData()
  },
  methods: {
    getSystems() {
      getSystems().then(response => {
        this.choose_systems = response.data
      })
    },
    getIogvs() {
      getIogvs().then(response => {
        this.choose_iogvs = response.data
      })
    },
    getEvents() {
      getEvents().then(response => {
        this.choose_events = response.data
      })
    },
    getData() {
      this.listLoading = true
      this.listQuery.systems = this.choose_systems_value.toString()
      this.listQuery.iogvs = this.choose_iogvs_value.toString()
      this.listQuery.events = this.choose_events_value.toString()
      this.listQuery.start_date = this.dates[0]
      this.listQuery.end_date = this.dates[1]
      getData(this.listQuery).then(response => {
        this.data_list = response.data.items
        this.total = parseInt(response.data.total.count)
        this.listLoading = false
      })
    },
    clear_systems() {
      this.choose_systems_value = []
    },
    clear_iogvs() {
      this.choose_iogvs_value = []
    },
    clear_events() {
      this.choose_events_value = []
    },
    clear_search() {
      this.listQuery.search = null
    },
    clear_dates() {
      this.dates = []
    },

    // download .xlsx
    formatJson(filterVal) {
      return this.data_list_no_limit.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    },
    sortChange(data) {
      const { prop, order } = data
      if (order === 'ascending') {
        this.listQuery.sort = '+' + prop
      } else {
        this.listQuery.sort = '-' + prop
      }
      this.listQuery.page = 1
      this.getData()
    },
    handleDownload() {
      this.downloadLoading = true

      getData({ ...this.listQuery, limit: 1000, page: 1 }).then(response => {
        this.data_list_no_limit = response.data.items

        import('@/vendor/Export2Excel').then(excel => {
          const tHeader = ['id', 'Название Системы', 'ИОГВ', 'Ф.И.О.', 'login', 'Дата', 'Действие']
          const filterVal = ['id', 'systems', 'iogv', 'fio', 'login', 'dates', 'events']

          const filterVal2 = []
          const tHeader2 = []

          if (this.showId) {
            filterVal2.push(filterVal[0])
          }
          if (this.showSystem) {
            filterVal2.push(filterVal[1])
          }
          if (this.showIogv) {
            filterVal2.push(filterVal[2])
          }
          if (this.showFio) {
            filterVal2.push(filterVal[3])
          }
          if (this.showLogin) {
            filterVal2.push(filterVal[4])
          }
          if (this.showDate) {
            filterVal2.push(filterVal[5])
          }
          if (this.showEvent) {
            filterVal2.push(filterVal[6])
          }

          if (this.showId) {
            tHeader2.push(tHeader[0])
          }
          if (this.showSystem) {
            tHeader2.push(tHeader[1])
          }
          if (this.showIogv) {
            tHeader2.push(tHeader[2])
          }
          if (this.showFio) {
            tHeader2.push(tHeader[3])
          }
          if (this.showLogin) {
            tHeader2.push(tHeader[4])
          }
          if (this.showDate) {
            tHeader2.push(tHeader[5])
          }
          if (this.showEvent) {
            tHeader2.push(tHeader[6])
          }

          const data = this.formatJson(filterVal2)
          excel.export_json_to_excel({
            header: tHeader2,
            data,
            filename: 'Отчет'
          })
          this.downloadLoading = false
        })
      })
    }
  }
}
</script>

<style>
  .info {
    padding: 7px 10px;
    border-radius: 5px;
  }

  .el-table th {
    text-align: center;
    font-weight: bold;
  }

  .search_btn {
    float: left;
  }

  .components-container-wrapper {
    float: left;
    width: 33%;
    text-align: center;
    position: relative;
  }

  .components-container-wrapper2 {
    float: left;
    width: 50%;
    position: relative;
  }

  .components-container2 {
    margin-top: 30px;
  }

  .components-container {
    width: 90%;
    margin-top: 0px;
    margin-bottom: 15px;
    margin-left: auto;
    margin-right: auto;
  }

  .clear_x {
    position: absolute;
    right: -3px;
    top: 8px;
    color: #ccc;
    border: 1px solid #ccc;
    padding: 2px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    font-size: 12px;
  }

  .el-date-editor--datetimerange.el-input, .el-date-editor--datetimerange.el-input__inner {
    width: 100%;
  }
</style>
