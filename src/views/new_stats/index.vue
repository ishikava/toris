<template>
  <div class="app-container">

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
          <el-drag-select v-model="choose_events_value" multiple placeholder="Событие" style="width: 100%;">
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

    <el-button class="filter-item search_btn" type="primary" icon="el-icon-search" @click="getData">
      Поиск
    </el-button>

    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="data_list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
    >

      <el-table-column label="id" min-width="90">
        <template slot-scope="{row}">
          <span>{{ row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showSystem" label="Система" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.systems }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showIogv" label="ИОГВ" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.iogv }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showFio" label="ФИО пользователя" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.fio }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showLogin" label="Логин" align="center" min-width="120">
        <template slot-scope="{row}">
          <span>{{ row.login }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showDate" label="Дата" align="center" min-width="120">
        <template slot-scope="{row}">
          <!--          <span>{{ row.timestamp | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>-->
          <span>{{ row.dates }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showEvent" label="Действие" align="center" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.events }}</span>
        </template>
      </el-table-column>

    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getData" />

  </div>
</template>

<script>
import ElDragSelect from '@/components/DragSelect'
import { getData, getEvents, getIogvs, getSystems } from '@/api/remote-search2'
import Pagination from '@/components/Pagination'

export default {
  name: 'Stats',
  components: { ElDragSelect, Pagination },

  data() {
    return {
      choose_systems: null,
      choose_iogvs: null,
      choose_events: null,
      choose_systems_value: [],
      choose_iogvs_value: [],
      choose_events_value: [],

      total: 0,
      data_list: null,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        systems: null,
        iogvs: null,
        events: null
      },
      showSystem: true,
      showIogv: true,
      showFio: true,
      showLogin: true,
      showDate: true,
      showEvent: true
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
    }
  }
}
</script>

<style>
  .components-container-wrapper {
    float: left;
    width: 33%;
    text-align: center;
    position: relative;
  }

  .components-container {
    width: 90%;
    margin: 0;
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
</style>
