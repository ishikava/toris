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
          data:['СМЭВ 2','СМЭВ 3']
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
              lang: ['СМЭВ', 'закрыть', 'перестроить']
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
            name:'СМЭВ 2',
            type:'bar',
            data:[2, 4, 7, 23, 25, 76, 135, 162, 32, 20, 6, 3],
            markPoint : {
              data : [
                {type : 'max', name: 'Max'},
                {type : 'min', name: 'Min'}
              ]
            },
            markLine : {
              data : [
                {type : 'max', name: 'Average Value'}
              ]
            }
          },
          {
            name:'СМЭВ 3',
            type:'bar',
            data:[2, 5, 9, 26, 28, 70, 175, 182, 48, 18, 6, 2],
            markPoint : {
              data : [
                {name : 'Annual Maximum', value : 182, xAxis: 7, yAxis: 183},
                {name : 'Minimum', value : 12, xAxis: 11, yAxis: 13}
              ]
            },
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
