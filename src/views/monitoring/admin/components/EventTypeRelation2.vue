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
        tooltip : {
          trigger: 'axis'
        },
        legend: {
          left: 10,
          top: 5,
          data:['200 OK','404 Not Found', '50x error']
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
              lang: ['Ответы сервера', 'закрыть', 'перестроить']
            },
            saveAsImage: { title: 'Сохранить', show: true }
          }
        },
        calculable : true,
        xAxis : [
          {
            type : 'category',
            data : ['1 Месяц','2 Месяц','3 Месяц','4 Месяц','5 Месяц','6 Месяц','7 Месяц','8 Месяц','9 Месяц','10 Месяц','11 Месяц','12 Месяц']
          }
        ],
        yAxis : [
          {
            type : 'value'
          }
        ],
        series : [
          {
            name:'200 OK',
            type:'bar',
            data:[200, 400, 700, 2300, 2500, 760, 1350, 1620, 3200, 2000, 600, 300],

            markLine : {
              data : [
                {type : 'max', name: 'Average Value'}
              ]
            }
          },
          {
            name:'404 Not Found',
            type:'bar',
            data:[2, 5, 9, 26, 28, 70, 175, 182, 48, 18, 6, 2],

            markLine : {
              color: '#90979c',
              data : [
                {type : 'max', name : 'Average Value'}
              ]
            }
          },
          {
            name:'50x error',
            type:'bar',
            data:[2, 4, 7, 23, 25, 76, 135, 162, 32, 20, 6, 3],

            markLine : {
              color: '#90979c',
              data : [
                {type : 'max', name : 'Average Value'}
              ]
            }
          }
        ]
      })
    }
  }
}
</script>
