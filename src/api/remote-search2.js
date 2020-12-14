import request from '@/utils/request2'

export function getSystems(query) {
  return request({
    url: '/api/get_systems',
    method: 'get',
    params: query
  })
}

export function getIogvs(query) {
  return request({
    url: '/api/get_iogvs',
    method: 'get',
    params: query
  })
}

export function getEvents(query) {
  return request({
    url: '/api/get_events',
    method: 'get',
    params: query
  })
}

export function getData(query) {
  return request({
    url: '/api/get_data',
    method: 'get',
    params: query
  })
}

export function getGroupedData(query) {
  return request({
    url: '/api/get_grouped_data',
    method: 'get',
    params: query
  })
}

export function getSuggest(query) {
  return request({
    url: '/api/get_suggest',
    method: 'get',
    params: query
  })
}

export function getTimer(query) {
  return request({
    url: '/api/get_timer',
    method: 'get',
    params: query
  })
}

export function eventList(query) {
  return request({
    url: '/api/get_event_list',
    method: 'get',
    params: query
  })
}

export function activeUsers(query) {
  return request({
    url: '/api/get_active_users',
    method: 'get',
    params: query
  })
}

export function getGraph(query) {
  return request({
    url: '/api/get_graph',
    method: 'get',
    params: query
  })
}

