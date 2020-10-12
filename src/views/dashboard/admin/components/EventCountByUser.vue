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
          text: 'Количество событий по пользователям',
          subtext: 'Событие'
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: { // 坐标轴指示器，坐标轴触发有效
            type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
          }
        },
        toolbox: {
          show: true,
          right: 17,
          itemGap: 12,
          feature: {
            dataView: {
              title: 'Таблица',
              show: true,
              readOnly: false,
              lang: ['Количество событий по пользователям', 'закрыть', 'перестроить']
            },
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
          data: ['Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов', 'Иван Иванов'],
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
          name: 'всего',
          type: 'bar',
          stack: 'vistors',
          barWidth: '60%',
          data: [10, 12, 1, 5, 7, 8, 14, 2, 0, 5, 8, 5, 7, 9, 3, 2, 4, 12, 2, 12, 10, 12, 1, 5, 7, 8, 14, 2, 0, 5, 8, 5, 7, 9, 3, 2, 4, 12, 2, 12]
        }]
      })
    }
  }
}
</script>
