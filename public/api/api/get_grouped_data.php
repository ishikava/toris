<?php

//total
//  $total = pg_query($postgres, "
//SELECT COUNT(*) FROM (
//SELECT system_name, iogv_name, event_name, COUNT(event_name) FROM events_data
//JOIN system ON (system.id = events_data.system_id)
//JOIN iogv ON (iogv.id = events_data.iogv_id)
//JOIN event ON (event.id = events_data.event_id)
//WHERE events_data.id > 0 $q
//GROUP BY system_name, iogv_name, event_name) as cnt");
//
//  $result['total'] = pg_fetch_object($total);
//
//
//
//  //rowspan
//  $rowspan = [];
//  $res_event = pg_query($postgres, "SELECT COUNT(*) FROM (SELECT DISTINCT(iogv_name) FROM iogv) as cnt");
//  $res_event = pg_fetch_object($res_event);
//  $rowspan[] = intval($res_event->count);
//  $res_event = pg_query($postgres, "SELECT COUNT(*) FROM (SELECT DISTINCT(event_name) FROM event) as cnt");
//  $res_event = pg_fetch_object($res_event);
//  $rowspan[] = intval($res_event->count);
//
//  $result['rowspan'] = $rowspan;

var_dump("SELECT system_name, iogv_name FROM events_data
LEFT JOIN system ON (system.id = events_data.system_id)
LEFT JOIN iogv ON (iogv.id = events_data.iogv_id)
WHERE events_data.id > 0 $q
GROUP BY system_name, iogv_name ORDER BY system_name, iogv_name");exit();

//data
$res = pg_query($postgres, "SELECT system_name, iogv_name FROM events_data
JOIN system ON (system.id = events_data.system_id)
JOIN iogv ON (iogv.id = events_data.iogv_id)
WHERE events_data.id > 0 $q
GROUP BY system_name, iogv_name ORDER BY system_name, iogv_name");

while ($row = pg_fetch_assoc($res)) {
  $result['items'][] = [
    'system_name' => $row['system_name'],
    'iogv_name' => $row['iogv_name'],
//      'event_name' => $row['event_name'],
//      'amount' => $row['count']
  ];
}

//запишем в базу время работы тяжелого запроса
$end = microtime(true);
$res = pg_query($postgres, "INSERT INTO public.timer(timer_query, timer_time)	VALUES ('" . serialize($_GET) . "', " . ($end - $start) . ");");
