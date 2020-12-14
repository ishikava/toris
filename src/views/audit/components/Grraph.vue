<template>
  <div :class="className" :style="{height:height,width:width}" />
</template>

<script>
import echarts from 'echarts'
import resize from './mixins/resize'
import { getGraph } from '@/api/remote-search2'

require('echarts/theme/macarons') // echarts theme

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
      default: '800px'
    }
  },
  data() {
    return {
      chart: null
    }
  },
  mounted() {
    this.$nextTick(() => {
      getGraph().then(response => {
        // var graph = tools.gexf.parse(response.data.xml);
        // var categories = [];
        // for (var i = 0; i < 9; i++) {
        //   categories[i] = {
        //     name: 'Иван Иванов ' + i
        //   };
        // }
        // graph.nodes.forEach(function (node) {
        //   node.itemStyle = null;
        //   node.value = node.symbolSize;
        //   node.symbolSize /= 1.5;
        //   node.label = {
        //     show: node.symbolSize > 30
        //   };
        //   node.category = node.attributes.modularity_class;
        // });

        var option = {
          title: {
            text: 'Аудит действий пользователей'
          },
          tooltip: {},
          animationDurationUpdate: 1500,
          animationEasingUpdate: 'quinticInOut',
          series: [
            {
              type: 'graph',
              symbolSize: [120, 90],
              roam: true,
              color: '#314b6e',
              label: {
                show: true
              },
              edgeSymbol: ['circle', 'arrow'],
              edgeSymbolSize: [10, 15],
              edgeLabel: {
                fontSize: 15
              },
              lineStyle: {
                opacity: 0.9,
                width: 2,
                color: 'source',
                curveness: 0.3
              },
              focusNodeAdjacency: true,
              itemStyle: {
                borderColor: '#fff',
                borderWidth: 1,
                shadowBlur: 10,
                shadowColor: 'rgba(0, 0, 0, 0.3)'
              },
              emphasis: {
                lineStyle: {
                  width: 10
                }
              },
              data: [{
                name: 'Аутентификация пользователя',
                x: 0,
                y: 100,
                itemStyle: {
                  color: '#f0f'
                },
                symbolSize: 180
              }, {
                name: 'Вход в систему (визит)',
                x: 200,
                y: 100
              }, {
                name: 'Вызов внешнего сервиса',
                x: 400,
                y: 100,
                itemStyle: {
                  color: '#ffad1c'
                },
                symbolSize: 180
              }, {
                name: 'Завершение сессии пользователя',
                x: 600,
                y: 100
              }, {
                name: 'Изменение объекта',
                x: -100,
                y: 200
              }, {
                name: 'Импорт данных',
                x: 100,
                y: 200
              }, {
                name: 'Обращение к справочнику',
                x: 300,
                y: 200
              }, {
                name: 'Продление сессии пользователя',
                x: 500,
                y: 200
              }, {
                name: 'Просмотр объекта',
                x: 700,
                y: 200
              }, {
                name: 'Создание объекта',
                x: -100,
                y: 300
              }, {
                name: 'Удаление объекта',
                x: 100,
                y: 300
              }, {
                name: 'Формирование отчета',
                x: 300,
                y: 300
              }, {
                name: 'Формирование печатной формы',
                x: 500,
                y: 300,
                itemStyle: {
                  color: '#076aff'
                },
                symbolSize: 180
              }, {
                name: 'Экспорт данных',
                x: 700,
                y: 300
              }],

              // links: [],
              links: [{
                source: 0,
                target: 1,
                label: {
                  show: true,
                  formatter: '123'
                },
                lineStyle: {
                  width: 5,
                  curveness: 0.2,
                  color: '#f0f'
                }
              }, {
                source: 0,
                target: 2,
                label: {
                  show: true,
                  formatter: '2342'
                }
              }, {
                source: 1,
                target: 2,
                label: {
                  show: true,
                  formatter: '567'
                }
              }, {
                source: 3,
                target: 7,
                label: {
                  show: true,
                  formatter: '776'
                }
              }, {
                source: 8,
                target: 4,
                label: {
                  show: true,
                  formatter: '2344'
                }
              }, {
                source: 4,
                target: 7,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 2,
                target: 1,
                label: {
                  show: true,
                  formatter: '234'
                },
                lineStyle: {
                  width: 5,
                  curveness: 0.2,
                  color: '#ffad1c'
                }
              }, {
                source: 2,
                target: 3,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 7,
                target: 4,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 8,
                target: 1,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 2,
                target: 7,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 0,
                target: 3,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 2,
                target: 5,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 7,
                target: 2,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 1,
                target: 9,
                label: {
                  show: true,
                  formatter: '2324'
                }
              }, {
                source: 6,
                target: 5,
                label: {
                  show: true,
                  formatter: '234'
                }, lineStyle: {
                  width: 5,
                  curveness: 0.2,
                  color: '#f00'
                }
              }, {
                source: 6,
                target: 9,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 7,
                target: 2,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 0,
                target: 6,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 0,
                target: 1,
                label: {
                  show: true,
                  formatter: '123'
                }
              }, {
                source: 0,
                target: 2,
                label: {
                  show: true,
                  formatter: '2342'
                }
              }, {
                source: 1,
                target: 2,
                label: {
                  show: true,
                  formatter: '567'
                }
              }, {
                source: 3,
                target: 7,
                label: {
                  show: true,
                  formatter: '776'
                }
              }, {
                source: 8,
                target: 4,
                label: {
                  show: true,
                  formatter: '2344'
                }
              }, {
                source: 4,
                target: 7,
                label: {
                  show: true,
                  formatter: '1234'
                }
              }, {
                source: 2,
                target: 1,
                label: {
                  show: true,
                  formatter: '2934'
                }
              }, {
                source: 2,
                target: 3,
                label: {
                  show: true,
                  formatter: '2834'
                }
              }, {
                source: 7,
                target: 4,
                label: {
                  show: true,
                  formatter: '2734'
                }
              }, {
                source: 8,
                target: 1,
                label: {
                  show: true,
                  formatter: '2634'
                }
              }, {
                source: 13,
                target: 7,
                label: {
                  show: true,
                  formatter: '5234'
                }
              }, {
                source: 13,
                target: 3,
                label: {
                  show: true,
                  formatter: '2334'
                }
              }, {
                source: 7,
                target: 5,
                label: {
                  show: true,
                  formatter: '2314'
                }
              }, {
                source: 9,
                target: 2,
                label: {
                  show: true,
                  formatter: '2354'
                }
              }, {
                source: 8,
                target: 9,
                label: {
                  show: true,
                  formatter: '2324'
                }
              }, {
                source: 10,
                target: 5,
                label: {
                  show: true,
                  formatter: '234'
                }
              }, {
                source: 11,
                target: 9,
                label: {
                  show: true,
                  formatter: '2034'
                }
              }, {
                source: 11,
                target: 2,
                label: {
                  show: true,
                  formatter: '2304'
                }
              }, {
                source: 12,
                target: 6,
                label: {
                  show: true,
                  formatter: '2334'
                }
              }]
            }
          ]
        }

        this.chart = echarts.init(this.$el, 'macarons')

        this.chart.setOption(option)
      })
    })
  },
  beforeDestroy() {
    if (!this.chart) {
      return
    }
    this.chart.dispose()
    this.chart = null
  }
}
</script>
