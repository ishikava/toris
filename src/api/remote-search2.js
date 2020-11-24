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
