import request from '@/utils/request'

export function searchUser(name) {
  return request({
    url: '/vue-element-admin/search/user',
    method: 'get',
    params: { name }
  })
}

export function activeUsers(query) {
  return request({
    url: '/active_users.json',
    method: 'get',
    params: query
  })
}

export function eventList(query) {
  return request({
    url: '/event_list.json',
    method: 'get',
    params: query
  })
}
