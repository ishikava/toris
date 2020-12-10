<template>
  <div class="app-container">

    <div class="stats-filter-container">

      <div class="components-container-wrapper">
        <div class="components-container">
          <div class="block">
            <el-date-picker
              v-model="dates1"
              value-format="yyyy-MM-dd HH:mm:ss"
              type="datetimerange"
              :picker-options="pickerOptions1"
              range-separator="|"
              start-placeholder="Диапазон 1"
              end-placeholder="Дата"
              align="left"
              @change="getData"
            />
          </div>
        </div>
        <div class="clear_x el-icon-close" @click="clear_dates1" />
      </div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <div class="block">
            <el-date-picker
              v-model="dates2"
              value-format="yyyy-MM-dd HH:mm:ss"
              type="datetimerange"
              :picker-options="pickerOptions2"
              range-separator="|"
              start-placeholder="Диапазон 2"
              end-placeholder="Дата"
              align="left"
              @change="getData"
            />
          </div>
        </div>
        <div class="clear_x el-icon-close" @click="clear_dates2" />
      </div>

      <div class="components-container-wrapper">
        <div class="components-container">
          <div class="block">
            <el-date-picker
              v-model="dates3"
              value-format="yyyy-MM-dd HH:mm:ss"
              type="datetimerange"
              :picker-options="pickerOptions3"
              range-separator="|"
              start-placeholder="Диапазон 3"
              end-placeholder="Дата"
              align="left"
              @change="getData"
            />
          </div>
        </div>
        <div class="clear_x el-icon-close" @click="clear_dates3" />
      </div>

    </div>

    <div class="stats-filter-container">

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

    <div class="stats-filter-container">

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

    <el-table
      v-loading="listLoading"
      :data="data_list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
      :span-method="objectSpanMethod"
    >

      <el-table-column label="Система" show-overflow-tooltip min-width="180" prop="system_name">
        <template slot-scope="{row}">
          <span>{{ row.system_name }}</span>
        </template>
      </el-table-column>

      <el-table-column label="ИОГВ" show-overflow-tooltip min-width="180" prop="iogv_name">
        <template slot-scope="{row}">
          <span>{{ row.iogv_name }}</span>
        </template>
      </el-table-column>

      <el-table-column label="За все время">
        <el-table-column label="Действие" class-name="nopad" min-width="180" prop="event_name" show-overflow-tooltip>
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

      <el-table-column label="Период 1">
        <el-table-column label="Действие" class-name="nopad" min-width="180" prop="event_name1" show-overflow-tooltip>
          <template slot-scope="{row}">
            <span>{{ row.event_name1 }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="nopad" min-width="30" prop="amount1" align="center">
          <template slot-scope="{row}">
            <span>{{ row.amount1 }}</span>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="Период 2">
        <el-table-column label="Действие" class-name="nopad" min-width="180" prop="event_name2" show-overflow-tooltip>
          <template slot-scope="{row}">
            <span>{{ row.event_name2 }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="nopad" min-width="30" prop="amount2" align="center">
          <template slot-scope="{row}">
            <span>{{ row.amount2 }}</span>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="Период 3">
        <el-table-column label="Действие" class-name="nopad" min-width="180" prop="event_name3" show-overflow-tooltip>
          <template slot-scope="{row}">
            <span>{{ row.event_name3 }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="nopad" min-width="30" prop="amount3" align="center">
          <template slot-scope="{row}">
            <span>{{ row.amount3 }}</span>
          </template>
        </el-table-column>
      </el-table-column>

    </el-table>

    <br><br><br>

  </div>
</template>

<script>
import ElDragSelect from '@/components/DragSelect'
import { getEvents, getGroupedData, getIogvs, getSystems } from '@/api/remote-search2'
import { parseTime } from '@/utils'

export default {
  name: 'Stats',
  components: { ElDragSelect },

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
      dates1: [],
      dates2: [],
      dates3: [],
      data_list: null,
      listLoading: true,
      listQuery: {
        system_name: null,
        iogv_name: null,
        event_name: null,
        dates1: null,
        dates2: null,
        dates3: null
      },
      rowSpan: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],

      pickerOptions1: {
        shortcuts: [
          {
            text: 'За 24 часа',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24)
              picker.$emit('pick', [start, end])
            }
          },
          {
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
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 91)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'За полгода',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 182)
              picker.$emit('pick', [start, end])
            }
          },
          {
            text: 'За год',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 365)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Текущий год',
            onClick(picker) {
              const end = new Date()
              const start = new Date(new Date().getFullYear(), 0, 1)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Предыдущий',
            onClick(picker) {
              const end = new Date(new Date().getFullYear(), 0, 1)
              const start = new Date(new Date().getFullYear() - 1, 0, 1)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Позапрошлый',
            onClick(picker) {
              const end = new Date(new Date().getFullYear() - 1, 0, 1)
              const start = new Date(new Date().getFullYear() - 2, 0, 1)
              picker.$emit('pick', [start, end])
            }
          }]
      },
      pickerOptions2: {
        shortcuts: [
          {
            text: 'За 24 часа',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24)
              picker.$emit('pick', [start, end])
            }
          },
          {
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
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 91)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'За полгода',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 182)
              picker.$emit('pick', [start, end])
            }
          },
          {
            text: 'За год',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 365)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Текущий год',
            onClick(picker) {
              const end = new Date()
              const start = new Date(new Date().getFullYear(), 0, 1)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Предыдущий',
            onClick(picker) {
              const end = new Date(new Date().getFullYear(), 0, 1)
              const start = new Date(new Date().getFullYear() - 1, 0, 1)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Позапрошлый',
            onClick(picker) {
              const end = new Date(new Date().getFullYear() - 1, 0, 1)
              const start = new Date(new Date().getFullYear() - 2, 0, 1)
              picker.$emit('pick', [start, end])
            }
          }]
      },
      pickerOptions3: {
        shortcuts: [
          {
            text: 'За 24 часа',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24)
              picker.$emit('pick', [start, end])
            }
          },
          {
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
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 91)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'За полгода',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 182)
              picker.$emit('pick', [start, end])
            }
          },
          {
            text: 'За год',
            onClick(picker) {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 365)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Текущий год',
            onClick(picker) {
              const end = new Date()
              const start = new Date(new Date().getFullYear(), 0, 1)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Предыдущий',
            onClick(picker) {
              const end = new Date(new Date().getFullYear(), 0, 1)
              const start = new Date(new Date().getFullYear() - 1, 0, 1)
              picker.$emit('pick', [start, end])
            }
          }, {
            text: 'Позапрошлый',
            onClick(picker) {
              const end = new Date(new Date().getFullYear() - 1, 0, 1)
              const start = new Date(new Date().getFullYear() - 2, 0, 1)
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
      this.listLoading = true
      this.listQuery.system_name = this.choose_systems_value.toString()
      this.listQuery.iogv_name = this.choose_iogvs_value.toString()
      this.listQuery.event_name = this.choose_events_value.toString()
      this.listQuery.dates1 = this.dates1
      this.listQuery.dates2 = this.dates2
      this.listQuery.dates3 = this.dates3

      getGroupedData(this.listQuery).then(response => {
        this.data_list = response.data.items
        this.listLoading = false
        response.data.event_count = 14
        this.rowSpan[0] = (response.data.iogv_count * response.data.event_count) / response.data.system_count
        this.rowSpan[1] = response.data.event_count
      })
    },
    clear_systems() {
      this.choose_systems_value = []
      this.getData()
    },
    clear_iogvs() {
      this.choose_iogvs_value = []
      this.getData()
    },
    clear_events() {
      this.choose_events_value = []
      this.getData()
    },
    clear_dates1() {
      this.dates1 = []
      this.getData()
    },
    clear_dates2() {
      this.dates2 = []
      this.getData()
    },
    clear_dates3() {
      this.dates3 = []
      this.getData()
    },
    clear_all() {
      this.choose_systems_value = []
      this.choose_iogvs_value = []
      this.choose_events_value = []
      this.dates1 = []
      this.dates2 = []
      this.dates3 = []
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
    handleDownload() {
      this.downloadLoading = true

      getGroupedData({ ...this.listQuery, limit: 1000, page: 1 }).then(response => {
        this.data_list_no_limit = response.data.items

        import('@/vendor/Export2Excel').then(excel => {
          const tHeader = ['id', 'Название Системы', 'ИОГВ', 'Ф.И.О.', 'login', 'Дата', 'Действие']
          const filterVal = ['id', 'system_name', 'iogv_name', 'fullname', 'login', 'date', 'event_name']

          const filterVal2 = []
          const tHeader2 = []

          if (this.showId) {
            tHeader2.push(tHeader[0])
            filterVal2.push(filterVal[0])
          }
          if (this.showSystem) {
            tHeader2.push(tHeader[1])
            filterVal2.push(filterVal[1])
          }
          if (this.showIogv) {
            tHeader2.push(tHeader[2])
            filterVal2.push(filterVal[2])
          }
          if (this.showFio) {
            tHeader2.push(tHeader[3])
            filterVal2.push(filterVal[3])
          }
          if (this.showLogin) {
            tHeader2.push(tHeader[4])
            filterVal2.push(filterVal[4])
          }
          if (this.showDate) {
            tHeader2.push(tHeader[5])
            filterVal2.push(filterVal[5])
          }
          if (this.showEvent) {
            tHeader2.push(tHeader[6])
            filterVal2.push(filterVal[6])
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
    width: 100%;
    text-align: center;
    position: relative;
  }

  .stats-filter-container {
    float: left;
    width: 33.3%;
    position: relative;
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
