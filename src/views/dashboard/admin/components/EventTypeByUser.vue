<template>
  <div :class="className" :style="{height:height,width:width}" />
</template>

<script>
import echarts from 'echarts'

require('echarts/theme/macarons') // echarts theme
import resize from './mixins/resize'

const animationDuration = 6000

export default {
  mixins: [resize],
  props: {
    className: {
      type: String,
      default: 'chart'
    },
    width: {
      type: String,
      default: '100%'
    },
    height: {
      type: String,
      default: '340px'
    }
  },
  data() {
    return {
      chart: null
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.initChart()
    })
  },
  beforeDestroy() {
    if (!this.chart) {
      return
    }
    this.chart.dispose()
    this.chart = null
  },
  methods: {
    initChart() {
      this.chart = echarts.init(this.$el, 'macarons')

      this.chart.setOption({
        title: {
          text: 'Типы событий по пользователям',
          subtext: 'Событие'
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'shadow'
          }
        },
        legend: {
          selectedMode: 'single',
          padding: 33,
          data: ['Вход', 'Выход', 'Экспорт', 'Вызов'],
          selected: {
            'Выход': false,
            'Экспорт': false,
            'Вызов': false
          }
        },
        toolbox: {
          show: true,
          right: 17,
          itemGap: 12,
          feature: {
            dataView: { title: 'Таблица', show: true, readOnly: false, lang: ['Типы событий по пользователям', 'закрыть', 'перестроить'] },
            saveAsImage: { title: 'Сохранить', show: true }
          }
        },
        grid: {
          top: 70,
          left: 0,
          right: 0,
          bottom: 0,
          containLabel: true
        },
        xAxis: [{
          show: false,
          type: 'category',
          data: ['Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов'],
          axisTick: {
            alignWithLabel: true
          }
        }],
        yAxis: [{
          type: 'value',
          axisTick: {
            show: false
          }
        }],
        series: [{
          name: 'Вход',
          type: 'bar',
          stack: 'vistors',
          barWidth: '60%',
          data: [10, 12, 1, 5, 7, 8, 14, 2, 1, 5, 10, 12, 1, 5, 7, 8, 14, 2, 1, 5]
        }, {
          name: 'Выход',
          type: 'bar',
          stack: 'vistors',
          barWidth: '60%',
          data: [3, 5, 8, 12, 2, 4, 7, 15, 1, 0, 10, 12, 1, 5, 7, 8, 14, 2, 1, 5]
        }, {
          name: 'Экспорт',
          type: 'bar',
          stack: 'vistors',
          barWidth: '60%',
          data: [8, 5, 7, 9, 3, 2, 4, 12, 2, 12, 8, 5, 7, 9, 3, 2, 4, 12, 2, 12]
        }, {
          name: 'Вызов',
          type: 'bar',
          stack: 'vistors',
          barWidth: '60%',
          data: [10, 12, 1, 5, 7, 8, 14, 2, 0, 5, 8, 5, 7, 9, 3, 2, 4, 12, 2, 12]
        }
        ]
      })
    }
  }
}
</script>
