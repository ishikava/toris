<template>
  <div class="app-container">

    <div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <el-autocomplete
            v-model="listQuery.search"
            placeholder="Поиск по Логину или ФИО"
            class="inline-input"
            style="width: 100%;"
            :fetch-suggestions="getSuggest"
            :trigger-on-focus="false"
            @keyup.enter.native="getData"
            @select="getData"
          />
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
              @change="getData"
            />
          </div>
        </div>
        <div class="clear_x el-icon-close" @click="clear_dates" />
      </div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <div class="btn_cont">
            <el-button class="filter-item btn_margin" type="default" icon="el-icon-close" @click="clear_all">Очистить</el-button>
          </div>

          <div class="btn_cont">
            <el-button class="filter-item btn_margin" type="primary" @click="getData">Отправить</el-button>
          </div>

          <div class="btn_cont">
            <el-button class="filter-item btn_margin" type="primary" icon="el-icon-download" :loading="downloadLoading" @click="handleDownload">Скачать .xlsx</el-button>
          </div>
        </div>
      </div>

    </div>
    <div class="clearfix" />

    <div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <el-drag-select v-model="choose_systems_value" multiple filterable placeholder="Система" style="width: 100%;" @change="getData">
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
          <el-drag-select v-model="choose_iogvs_value" multiple filterable placeholder="ИОГВ" style="width: 100%;" @change="getData">
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
          <el-drag-select v-model="choose_events_value" multiple filterable placeholder="Действие" style="width: 100%;" @change="getData">
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
          <br> <br>
          <el-checkbox v-model="showGroupbySystem" class="filter-item" style="margin-left:15px;" @change="groupbySystem">
            Сгруппировать по системам
          </el-checkbox>
        </div>
      </div>

      <div class="components-container-wrapper2">
        <div class="components-container2">
          <div class="btn_cont2">
            <el-button class="filter-item  btn_margin" type="primary" @click="saveFilter">Сохранить текущие настройки</el-button>
          </div>
        </div>
      </div>

    </div>
    <div class="clearfix" />

    <el-table
      v-loading="listLoading"
      :data="data_list"
      :span-method="objectSpanMethod"
      border
      fit
      highlight-current-row
      style="width: 100%;"
      @sort-change="sortChange"
    >

      <el-table-column v-if="showId" label="ID" align="center" min-width="50" sortable="custom" prop="uid" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showSystem" label="Система" show-overflow-tooltip min-width="180" sortable="custom" prop="system_name" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.system_name }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showIogv" label="ИОГВ" show-overflow-tooltip min-width="180" sortable="custom" prop="iogv_name" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.iogv_name }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showFio" label="ФИО пользователя" show-overflow-tooltip min-width="180" sortable="custom" prop="lastname" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.lastname + " " + row.name + " " + row.patronymic }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showLogin" label="Логин" show-overflow-tooltip align="center" min-width="120" sortable="custom" prop="login" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.login }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showDate" label="Дата" align="center" min-width="120" sortable="custom" prop="date" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <span>{{ row.date }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showEvent" label="Действие" show-overflow-tooltip min-width="180" align="center" sortable="custom" prop="event_name" :sort-orders="['ascending', 'descending']">
        <template slot-scope="{row}">
          <el-tooltip v-if="row.info" placement="top">
            <div slot="content">{{ row.info | infoFilter }}</div>
            <el-button class="info">info</el-button>
          </el-tooltip>
          <span>{{ row.event_name }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showRow1" label="Период 1">
        <el-table-column label="Действие" class-name="nopad" min-width="180" prop="event_name">
          <template slot-scope="{row}">
            <span>{{ row.event_name }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="nopad" min-width="30" prop="amount" align="center">
          <template slot-scope="{row}">
            <span>{{ row.amount }}</span>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column v-if="showRow2" label="Период 2">
        <el-table-column label="Действие" class-name="nopad" min-width="180" prop="event_name">
          <template slot-scope="{row}">
            <span>{{ row.event_name }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="nopad" min-width="30" prop="amount" align="center">
          <template slot-scope="{row}">
            <span>{{ row.amount }}</span>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column v-if="showRow3" label="Период 3">
        <el-table-column label="Действие" class-name="nopad" min-width="180" prop="event_name">
          <template slot-scope="{row}">
            <span>{{ row.event_name }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="nopad" min-width="30" prop="amount" align="center">
          <template slot-scope="{row}">
            <span>{{ row.amount }}</span>
          </template>
        </el-table-column>
      </el-table-column>

    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getData" />

  </div>
</template>

<script>
import ElDragSelect from '@/components/DragSelect'
import { getData, getEvents, getIogvs, getSuggest, getSystems, getTimer } from '@/api/remote-search2'
import Pagination from '@/components/Pagination'
import { parseTime } from '@/utils'

export default {
  name: 'Stats',
  components: { ElDragSelect, Pagination },

  filters: {
    infoFilter(str) {
      const result = Object.keys(str).map((key) => [key, str[key]])
      const arr = result.join('   |   ')
      return arr.replace(new RegExp(',', 'g'), ' : ')
    }
  },

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
        limit: 1000,
        system_name: null,
        iogv_name: null,
        event_name: null,
        search: null,
        start_date: null,
        end_date: null,
        sort: null,
        groupby_system: null
      },
      listQueryNoLimit: {},
      showId: true,
      showSystem: true,
      showIogv: true,
      showFio: true,
      showLogin: true,
      showDate: true,
      showEvent: true,
      showRow1: false,
      showRow2: false,
      showRow3: false,
      showGroupbySystem: false,

      rowSpan: [1, 1, 1, 1, 1, 1, 1, 1, 1],

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
    objectSpanMethod({ row, column, rowIndex, columnIndex }) {
      if (this.showGroupbySystem) {
        if (rowIndex % this.rowSpan[columnIndex] === 0) {
          return {
            rowspan: this.rowSpan[columnIndex],
            colspan: 1
          }
        } else {
          return {
            rowspan: 0,
            colspan: 0
          }
        }
      }
    },
    groupbySystem() {
      this.showId = false
      this.showFio = false
      this.showLogin = false
      this.showDate = false
      this.showEvent = false
      this.getData()
    },
    saveFilter() {
      this.getData()
    },
    getSuggest(queryString, cb) {
      const q = {}
      q.search = queryString
      getSuggest(q).then(response => {
        cb(response.data)
      })
    },
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
      // анимация для сгруппированных запросов
      if (this.showGroupbySystem) {
        var loading = this.$loading({
          lock: true,
          text: '0 %'
        })
        getTimer(this.listQuery).then(response => {
          let tick = parseInt(response.data.timer)
          if (tick < 12) {
            tick = 12
          }
          let counter = 0
          const timer = setInterval(() => {
            loading.text = counter + ' %'
            if (counter < 100) {
              counter++
            } else {
              clearInterval(timer)
            }
          }, tick)
        })
      }

      this.listLoading = true
      this.listQuery.system_name = this.choose_systems_value.toString()
      this.listQuery.iogv_name = this.choose_iogvs_value.toString()
      this.listQuery.event_name = this.choose_events_value.toString()
      this.listQuery.start_date = this.dates[0]
      this.listQuery.end_date = this.dates[1]
      if (this.showGroupbySystem) {
        this.listQuery.groupby_system = true
      }
      getData(this.listQuery).then(response => {
        this.data_list = response.data.items
        this.total = parseInt(response.data.total.count)
        this.listLoading = false
        if (this.showGroupbySystem) {
          this.rowSpan[0] = response.data.rowspan[0] * response.data.rowspan[1]
          this.rowSpan[1] = response.data.rowspan[1]
          this.showRow1 = true
          this.showRow2 = true
          this.showRow3 = true
          loading.close()
        }
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
    clear_all() {
      this.choose_systems_value = []
      this.choose_iogvs_value = []
      this.choose_events_value = []
      this.listQuery.search = null
      this.dates = []
      this.getData()
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
          const filterVal = ['id', 'system_name', 'iogv_name', 'fullname', 'login', 'date', 'event_name']

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
    float: left;
  }

  .el-table th {
    text-align: center;
    font-weight: bold;
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
    margin-bottom: 15px;
  }

  .components-container {
    width: 90%;
    float: left;
    margin-top: 0px;
    margin-bottom: 15px;
    margin-left: auto;
    margin-right: auto;
  }

  .clear_x {
    position: absolute;
    right: 22px;
    top: 8px;
    color: #ccc;
    border: 1px solid #ccc;
    padding: 2px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    font-size: 12px;
    cursor: pointer;
  }

  .el-date-editor--datetimerange.el-input, .el-date-editor--datetimerange.el-input__inner {
    width: 100%;
  }

  .btn_cont {
    float: left;
    width: 33.3%;
  }

  .btn_cont2 {
    float: right;
    width: 33.3%;
    margin-bottom: 15px;
  }

  .btn_margin {
    width: 90%;
    float: left;
  }

  .nopad {
    padding: 0 !important;
  }
</style>
