<template>
  <div class="app-container">

    <div class="filter-container">
      <el-input v-model="listQuery.title" placeholder="Поиск по Логину и ФИО" style="width: 300px; float: left;" class="filter-item" @keyup.enter.native="handleFilter" />

      <el-button v-waves class="filter-item" style="margin-left: 5px; margin-right: 30px; float: left;" type="primary" icon="el-icon-search" @click="handleFilter">
        Поиск
      </el-button>

      <!--      <el-select v-model="listQuery.importance" placeholder="Imp" clearable style="width: 90px" class="filter-item">-->
      <!--        <el-option v-for="item in importanceOptions" :key="item" :label="item" :value="item" />-->
      <!--      </el-select>-->

      <el-select v-model="listQuery.event" placeholder="Тип события" clearable class="filter-item" style="width: 200px; margin-left: 10px; margin-right: 30px; float: left">
        <el-option v-for="item in calendarTypeOptions" :key="item.key" :label="item.display_name" :value="item.key" />
      </el-select>

      <div class="block" style="float: left;">
        <span class="demonstration">Дата </span>
        <el-date-picker
          v-model="value2"
          type="datetimerange"
          :picker-options="pickerOptions"
          range-separator="По"
          start-placeholder="Start date"
          end-placeholder="End date"
          align="right"
        />
      </div>

      <!--      <el-select v-model="listQuery.sort" style="width: 140px" class="filter-item" @change="handleFilter">-->
      <!--        <el-option v-for="item in sortOptions" :key="item.key" :label="item.label" :value="item.key" />-->
      <!--      </el-select>-->

      <!--      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleCreate">-->
      <!--        Add-->
      <!--      </el-button>-->
      <el-button v-waves :loading="downloadLoading" class="filter-item" style="float: right;" type="primary" icon="el-icon-download" @click="handleDownload">
        Скачать отчет .xlsx
      </el-button>
    </div>

    <div class="clearfix" />

    <div class="filter-container" style="margin-top: 7px;">
      <el-button class="filter-item" type="primary">
        Наксторить поля
      </el-button>
      <el-checkbox v-model="showSystem" class="filter-item" style="margin-left:15px;" @change="tableKey=tableKey+1">
        Система
      </el-checkbox>
      <el-checkbox v-model="showIogv" class="filter-item" style="margin-left:15px;" @change="tableKey=tableKey+1">
        ИОГВ
      </el-checkbox>
      <el-checkbox v-model="showFio" class="filter-item" style="margin-left:15px;" @change="tableKey=tableKey+1">
        ФИО
      </el-checkbox>
      <el-checkbox v-model="showLogin" class="filter-item" style="margin-left:15px;" @change="tableKey=tableKey+1">
        Логин
      </el-checkbox>
      <el-checkbox v-model="showDate" class="filter-item" style="margin-left:15px;" @change="tableKey=tableKey+1">
        Дата
      </el-checkbox>
      <el-checkbox v-model="showEvent" class="filter-item" style="margin-left:15px;" @change="tableKey=tableKey+1">
        Событие
      </el-checkbox>

      <a href="#/stats_group" class="link-type" style="float: right; margin-top: 10px;" icon="el-icon-upload">Сгруппировать отчет</a>

    </div>

    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
      @sort-change="sortChange"
    >

      <el-table-column v-if="showSystem" label="Система" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.system | substrFilter }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showIogv" label="ИОГВ" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.iogv | substrFilter }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showFio" label="ФИО пользователя" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.fio | substrFilter }}</span>
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
          <span>{{ row.date }}</span>
        </template>
      </el-table-column>

      <el-table-column v-if="showEvent" label="Действие" align="center" min-width="180">
        <template slot-scope="{row}">
          <span>{{ row.event | substrFilter }}</span>
        </template>
      </el-table-column>

      <!--
            <el-table-column label="ID" prop="id" sortable="custom" align="center" width="80" :class-name="getSortClass('id')">
              <template slot-scope="{row}">
                <span>{{ row.id }}</span>
              </template>
            </el-table-column>
      -->

      <!--      <el-table-column label="Author" width="110px" align="center">-->
      <!--        <template slot-scope="{row}">-->
      <!--          <span>{{ row.author }}</span>-->
      <!--        </template>-->
      <!--      </el-table-column>-->
      <!--      -->

      <!--      <el-table-column label="Status" class-name="status-col" width="100">-->
      <!--        <template slot-scope="{row}">-->
      <!--          <el-tag :type="row.status | statusFilter">-->
      <!--            {{ row.status }}-->
      <!--          </el-tag>-->
      <!--        </template>-->
      <!--      </el-table-column>-->
      <!--      <el-table-column label="Действия" align="center" width="230" class-name="small-padding fixed-width">

              <template slot-scope="{row,$index}">
                <el-button type="primary" size="mini" @click="handleUpdate(row)">
                  Ред.
                </el-button>
                <el-button v-if="row.status!='published'" size="mini" type="success" @click="handleModifyStatus(row,'published')">
                  Обраб.
                </el-button>
                <el-button v-if="row.status!='draft'" size="mini" @click="handleModifyStatus(row,'draft')">
                  Не обр.
                </el-button>
                <el-button v-if="row.status!='deleted'" size="mini" type="danger" @click="handleDelete(row,$index)">
                  Удал.
                </el-button>
              </template>
            </el-table-column>-->

    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="120px" style="width: 400px; margin-left:50px;">
        <el-form-item label="Тип события" prop="type">
          <el-select v-model="temp.type" class="filter-item" placeholder="Please select">
            <el-option v-for="item in calendarTypeOptions" :key="item.key" :label="item.display_name" :value="item.key" />
          </el-select>
        </el-form-item>
        <el-form-item label="Дата" prop="timestamp">
          <el-date-picker v-model="temp.timestamp" type="datetime" placeholder="Please pick a date" />
        </el-form-item>
        <!--        <el-form-item label="Title" prop="title">-->
        <!--          <el-input v-model="temp.title" />-->
        <!--        </el-form-item>-->
        <!--        <el-form-item label="Status">-->
        <!--          <el-select v-model="temp.status" class="filter-item" placeholder="Please select">-->
        <!--            <el-option v-for="item in statusOptions" :key="item" :label="item" :value="item" />-->
        <!--          </el-select>-->
        <!--        </el-form-item>-->
        <!--        <el-form-item label="Imp">-->
        <!--          <el-rate v-model="temp.importance" :colors="['#99A9BF', '#F7BA2A', '#FF9900']" :max="3" style="margin-top:8px;" />-->
        <!--        </el-form-item>-->
        <!--        <el-form-item label="Remark">-->
        <!--          <el-input v-model="temp.remark" :autosize="{ minRows: 2, maxRows: 4}" type="textarea" placeholder="Please input" />-->
        <!--        </el-form-item>-->
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">
          Отменить
        </el-button>
        <el-button type="primary" @click="dialogStatus==='create'?createData():updateData()">
          Подтвердить
        </el-button>
      </div>
    </el-dialog>

    <el-dialog :visible.sync="dialogPvVisible" title="Информация о пользователе">
      <el-table border fit highlight-current-row style="width: 100%">
        <el-table-column label="Имя" />
        <el-table-column label="Фамилия" />
        <el-table-column label="Отчество" />
      </el-table>
      <el-table border fit highlight-current-row style="width: 100%">
        <el-table-column label="Организация" />
        <el-table-column label="Должность" />
        <el-table-column label="Логин" />
      </el-table>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogPvVisible = false">Подтвердить</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { createArticle, fetchPv, updateArticle } from '@/api/article'
import { statsList } from '@/api/remote-search'
import waves from '@/directive/waves' // waves directive
import { parseTime } from '@/utils'
// import Pagination from '@/components/Pagination' // secondary package based on el-pagination

const calendarTypeOptions = [
  { key: 'CN', display_name: 'Аутентификация пользователя' },
  { key: 'CN', display_name: 'Вход в систему (визит)' },
  { key: 'CN', display_name: 'Обращение к справочнику' },
  { key: 'CN', display_name: 'Просмотр объекта' },
  { key: 'CN', display_name: 'Изменение объекта' },
  { key: 'CN', display_name: 'Формирование печатной формы' },
  { key: 'CN', display_name: 'Формирование отчета' },
  { key: 'CN', display_name: 'Создание объекта' },
  { key: 'CN', display_name: 'Экспорт данных' },
  { key: 'CN', display_name: 'Импорт данных' },
  { key: 'CN', display_name: 'Удаление объекта' },
  { key: 'CN', display_name: 'Вызов внешнего сервиса' },
  { key: 'CN', display_name: 'Продление сессии пользователя' },
  { key: 'CN', display_name: 'Завершение сессии пользователя' }
]

// arr to obj, such as { CN : "China", US : "USA" }
const calendarTypeKeyValue = calendarTypeOptions.reduce((acc, cur) => {
  acc[cur.key] = cur.display_name
  return acc
}, {})

// TodayDate = new Date();

export default {
  name: 'ComplexTable',
  // components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger'
      }
      return statusMap[status]
    },
    typeFilter(type) {
      return calendarTypeKeyValue[type]
    },
    substrFilter(system) {
      return system.substr(0, 30)
    }
  },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        importance: undefined,
        title: undefined,
        type: undefined,
        sort: '+id'
      },
      importanceOptions: [1, 2, 3],
      calendarTypeOptions,
      sortOptions: [{ label: 'ID Ascending', key: '+id' }, { label: 'ID Descending', key: '-id' }],
      statusOptions: ['Обработан', 'Не обраб.', 'Удалено'],
      showSystem: true,
      showIogv: true,
      showFio: true,
      showLogin: true,
      showDate: true,
      showEvent: true,
      temp: {
        id: undefined,
        importance: 1,
        remark: '',
        timestamp: new Date(),
        title: '',
        type: '',
        status: 'published'
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Редактировать',
        create: 'Создать'
      },
      dialogPvVisible: false,
      pvData: [],
      rules: {
        type: [{ required: true, message: 'type is required', trigger: 'change' }],
        timestamp: [{ type: 'date', required: true, message: 'timestamp is required', trigger: 'change' }],
        title: [{ required: true, message: 'title is required', trigger: 'blur' }]
      },
      downloadLoading: false
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      statsList(this.listQuery).then(response => {
        this.list = response.data.items
        this.total = response.data.total

        // Just to simulate the time of the request
        setTimeout(() => {
          this.listLoading = false
        }, 1.5 * 1000)
      })
    },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    handleModifyStatus(row, status) {
      this.$message({
        message: 'Успешно',
        type: 'success'
      })
      row.status = status
    },
    sortChange(data) {
      const { prop, order } = data
      if (prop === 'id') {
        this.sortByID(order)
      }
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id'
      } else {
        this.listQuery.sort = '-id'
      }
      this.handleFilter()
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        importance: 1,
        remark: '',
        timestamp: new Date(),
        title: '',
        status: 'published',
        type: ''
      }
    },
    handleCreate() {
      this.resetTemp()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.temp.id = parseInt(Math.random() * 100) + 1024 // mock a id
          this.temp.author = 'vue-element-admin'
          createArticle(this.temp).then(() => {
            this.list.unshift(this.temp)
            this.dialogFormVisible = false
            this.$notify({
              title: 'Success',
              message: 'Created Successfully',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
    handleUpdate(row) {
      this.temp = Object.assign({}, row) // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp)
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp)
          tempData.timestamp = +new Date(tempData.timestamp) // change Thu Nov 30 2017 16:41:05 GMT+0800 (CST) to 1512031311464
          updateArticle(tempData).then(() => {
            const index = this.list.findIndex(v => v.id === this.temp.id)
            this.list.splice(index, 1, this.temp)
            this.dialogFormVisible = false
            this.$notify({
              title: 'Успешно',
              message: 'Успешно обновлено',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
    handleDelete(row, index) {
      this.$notify({
        title: 'Успешно',
        message: 'Успешно удалено',
        type: 'success',
        duration: 2000
      })
      this.list.splice(index, 1)
    },
    handleFetchPv(pv) {
      fetchPv(pv).then(response => {
        this.pvData = response.data.pvData
        this.dialogPvVisible = true
      })
    },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['timestamp', 'title', 'type', 'importance', 'status']
        const filterVal = ['timestamp', 'title', 'type', 'importance', 'status']
        const data = this.formatJson(filterVal)
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'table-list'
        })
        this.downloadLoading = false
      })
    },
    formatJson(filterVal) {
      return this.list.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    },
    getSortClass: function(key) {
      const sort = this.listQuery.sort
      return sort === `+${key}` ? 'ascending' : 'descending'
    },

    pickerOptions: {
      shortcuts: [{
        text: 'Last week',
        onClick(picker) {
          const end = new Date()
          const start = new Date()
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
          picker.$emit('pick', [start, end])
        }
      }, {
        text: 'Last month',
        onClick(picker) {
          const end = new Date()
          const start = new Date()
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
          picker.$emit('pick', [start, end])
        }
      }, {
        text: 'Last 3 months',
        onClick(picker) {
          const end = new Date()
          const start = new Date()
          start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
          picker.$emit('pick', [start, end])
        }
      }]
    },
    // value1: [new Date(2000, 10, 10, 10, 10), new Date(TodayDate.getUTCFullYear(), TodayDate.getUTCMonth(), TodayDate.getUTCDay(), TodayDate.getUTCHours(), TodayDate.getUTCMinutes())]
    value1: [new Date(2000, 10, 10, 10, 10), new Date(2000, 10, 11, 10, 10)],
    value2: ''
  }
}
</script>
