<?php

$start = microtime(true);

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

$offset = isset($_GET['page']) ? intval($_GET['page']) * $limit - $limit : 0;

if ($offset < 0) {
  $offset = 0;
}

$q = '';

if (isset($_GET['system_name']) && $_GET['system_name'] != "") {
  $systems = explode(',', $_GET['system_name']);
  $sys = [];
  foreach ($systems as $system) {
    $sys[] = "'" . $system . "'";
  }
  $system_ids = [];
  $res = pg_query($postgres, "SELECT id FROM system WHERE system_name IN (" . implode(',', $sys) . ")");
  while ($row = pg_fetch_assoc($res)) {
    $system_ids[] = $row['id'];
  }
  $q .= " AND system_id IN (" . implode(',', $system_ids) . ") ";
}

if (isset($_GET['iogv_name']) && $_GET['iogv_name'] != "") {
  $iogvs = explode(',', $_GET['iogv_name']);
  $iog = [];
  foreach ($iogvs as $iogv) {
    $iog[] = "'" . $iogv . "'";
  }
  $iogv_ids = [];
  $res = pg_query($postgres, "SELECT id FROM iogv WHERE iogv_name IN (" . implode(',', $iog) . ")");
  while ($row = pg_fetch_assoc($res)) {
    $iogv_ids[] = $row['id'];
  }
  $q .= " AND iogv_id IN (" . implode(',', $iogv_ids) . ") ";
}

if (isset($_GET['event_name']) && $_GET['event_name'] != "") {
  $events = explode(',', $_GET['event_name']);
  $eve = [];
  foreach ($events as $event) {
    $eve[] = "'" . $event . "'";
  }
  $event_ids = [];
  $res = pg_query($postgres, "SELECT id FROM event WHERE event_name IN (" . implode(',', $eve) . ")");
  while ($row = pg_fetch_assoc($res)) {
    $event_ids[] = $row['id'];
  }
  $q .= " AND event_id IN (" . implode(',', $event_ids) . ") ";
}

if (isset($_GET['search']) && $_GET['search'] != "") {

  if (strpos($_GET['search'], '[') === false) {
    $q2 = "SELECT id FROM public.user WHERE
  login ILIKE '" . $_GET['search'] . "%'
  OR name ILIKE '" . $_GET['search'] . "%'
  OR lastname ILIKE '" . $_GET['search'] . "%'
  OR patronymic ILIKE '" . $_GET['search'] . "%'";
  } else {
    $tmp = explode('[', $_GET['search']);
    $tmp2 = explode(']', $tmp[1]);
    $q2 = "SELECT id FROM public.user WHERE login = '" . trim($tmp2[0]) . "'";
  }

  $user_ids = [];
  $res = pg_query($postgres, $q2);
  while ($row = pg_fetch_assoc($res)) {
    $user_ids[] = $row['id'];
  }
  $q .= " AND user_id IN (" . implode(',', $user_ids) . ") ";
}

if (isset($_GET['start_date']) && $_GET['start_date'] != "" && isset($_GET['end_date']) && $_GET['end_date'] != "") {
  $start = date('Y-m-d H:i:s', strtotime($_GET['start_date']));
  $end = date('Y-m-d H:i:s', strtotime($_GET['end_date']));
  $q .= " AND date >= '" . strtotime($_GET['start_date']) . "' AND date < '" . strtotime($_GET['end_date']) . "'";
}

if (isset($_GET['sort']) && $_GET['sort'] != "") {
  if (substr($_GET['sort'], 0, 1) == '-') {
    $sort = "ORDER BY " . substr($_GET['sort'], 1, strlen($_GET['sort'])) . " DESC";
  } else {
    $sort = "ORDER BY " . substr($_GET['sort'], 1, strlen($_GET['sort'])) . " ASC";
  }
} else {
  $sort = "ORDER BY date DESC, uid ASC";
}

//группировка по системам
if (isset($_GET['groupby_system']) && $_GET['groupby_system'] != "") {

  //total
  $total = pg_query($postgres, "
SELECT COUNT(*) FROM (
SELECT system_name, iogv_name, event_name, COUNT(event_name) FROM events_data
JOIN system ON (system.id = events_data.system_id)
JOIN iogv ON (iogv.id = events_data.iogv_id)
JOIN event ON (event.id = events_data.event_id)
WHERE events_data.id > 0 $q
GROUP BY system_name, iogv_name, event_name) as cnt");

  $result['total'] = pg_fetch_object($total);

  //rowspan
  $rowspan = [];
  $res_event = pg_query($postgres, "SELECT COUNT(*) FROM (SELECT DISTINCT(iogv_name) FROM iogv) as cnt");
  $res_event = pg_fetch_object($res_event);
  $rowspan[] = intval($res_event->count);
  $res_event = pg_query($postgres, "SELECT COUNT(*) FROM (SELECT DISTINCT(event_name) FROM event) as cnt");
  $res_event = pg_fetch_object($res_event);
  $rowspan[] = intval($res_event->count);

  $result['rowspan'] = $rowspan;

  //data
  $res = pg_query($postgres, "SELECT system_name, iogv_name, event_name, COUNT(event_name) FROM events_data
JOIN system ON (system.id = events_data.system_id)
JOIN iogv ON (iogv.id = events_data.iogv_id)
JOIN event ON (event.id = events_data.event_id)
WHERE events_data.id > 0 $q
GROUP BY system_name, iogv_name, event_name ORDER BY system_name, iogv_name, event_name LIMIT $limit OFFSET $offset");

  while ($row = pg_fetch_assoc($res)) {
    $result['items'][] = [
      'system_name' => $row['system_name'],
      'iogv_name' => $row['iogv_name'],
      'event_name' => $row['event_name'],
      'amount' => $row['count']
    ];
  }

//запишем в базу время работы тяжелого запроса
$end = microtime(true);
$res = pg_query($postgres, "INSERT INTO public.timer(timer_query, timer_time)	VALUES ('" . serialize($_GET) . "', " . ($end - $start) . ");");

//без группировок
} else {

  $total = pg_query($postgres, "SELECT COUNT(events_data.id) FROM events_data
  JOIN system ON (events_data.system_id = system.id)
  JOIN iogv ON (events_data.iogv_id = iogv.id)
  JOIN event ON (events_data.event_id = event.id)
  JOIN public.user ON (events_data.user_id = public.user.id)
  WHERE events_data.id > 0 $q");

  $result['total'] = pg_fetch_object($total);

  $res = pg_query($postgres, "SELECT *, events_data.id as uid FROM events_data
  JOIN system ON (events_data.system_id = system.id)
  JOIN iogv ON (events_data.iogv_id = iogv.id)
  JOIN event ON (events_data.event_id = event.id)
  JOIN public.user ON (events_data.user_id = public.user.id)
  WHERE events_data.id > 0 $q $sort LIMIT $limit OFFSET $offset");

  while ($row = pg_fetch_assoc($res)) {

    $result['items'][] = [
      'id' => $row['uid'],
      'event_name' => $row['event_name'],
      'name' => $row['name'],
      'lastname' => $row['lastname'],
      'patronymic' => $row['patronymic'],
      'fullname' => $row['lastname'] . ' ' . $row['name'] . ' ' . $row['patronymic'],
      'iogv_name' => $row['iogv_name'],
      'login' => $row['login'],
      'system_name' => $row['system_name'],
      'date' => date('Y-m-d H:i:s', $row['date'])
      //   'info' => json_decode($row['info_value'], JSON_UNESCAPED_UNICODE)
    ];
  }

}



