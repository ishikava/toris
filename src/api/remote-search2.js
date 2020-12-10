import request from '@/utils/request2'

export function getSystems(query) {
  return request({
    url: '/get_systems',
    method: 'get',
    params: query
  })
}

export function getIogvs(query) {
  return request({
    url: '/get_iogvs',
    method: 'get',
    params: query
  })
}

export function getEvents(query) {
  return request({
    url: '/get_events',
    method: 'get',
    params: query
  })
}

export function getData(query) {
  return request({
    url: '/get_data',
    method: 'get',
    params: query
  })
}

export function getGroupedData(query) {
  return request({
    url: '/get_grouped_data',
    method: 'get',
    params: query
  })
}

export function getSuggest(query) {
  return request({
    url: '/get_suggest',
    method: 'get',
    params: query
  })
}

export function getTimer(query) {
  return request({
    url: '/get_timer',
    method: 'get',
    params: query
  })
}

