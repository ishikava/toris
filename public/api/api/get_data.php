<?php

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

$offset = isset($_GET['page']) ? intval($_GET['page']) * $limit - $limit : 0;

if ($offset < 0) {
  $offset = 0;
}

$q = '';

if (isset($_GET['systems']) && $_GET['systems'] != "") {
  $systems = explode(',', $_GET['systems']);
  $sys = [];
  foreach ($systems as $system){
    $sys[] = "'".$system."'";
  }
  $q .= " AND systems IN (" . implode(',', $sys) . ") ";
}

if (isset($_GET['iogvs']) && $_GET['iogvs'] != "") {
  $iogvs = explode(',', $_GET['iogvs']);
  $iog = [];
  foreach ($iogvs as $iogv){
    $iog[] = "'".$iogv."'";
  }
  $q .= " AND iogv IN (" . implode(',', $iog) . ") ";
}

if (isset($_GET['events']) && $_GET['events'] != "") {
  $events = explode(',', $_GET['events']);
  $eve = [];
  foreach ($events as $event){
    $eve[] = "'".$event."'";
  }
  $q .= " AND events IN (" . implode(',', $eve) . ") ";
}

if (isset($_GET['search']) && $_GET['search'] != "") {
  $q .= " AND (fio ILIKE '%".$_GET['search']."%' OR login ILIKE '%".$_GET['search']."%') ";
}

if (isset($_GET['start_date']) && $_GET['start_date'] != "" && isset($_GET['end_date']) && $_GET['end_date'] != "") {
  $start = date('Y-m-d H:i:s', strtotime($_GET['start_date']));
  $end = date('Y-m-d H:i:s', strtotime($_GET['end_date']));
  $q .= " AND dates >= '".$_GET['start_date']."' AND dates < '".$_GET['end_date']."'";
}

if (isset($_GET['sort']) && $_GET['sort'] != "") {
  if (substr($_GET['sort'],0,1) == '-'){
    $sort = "ORDER BY ".substr($_GET['sort'],1,strlen($_GET['sort']))." DESC";
  } else {
    $sort = "ORDER BY ".substr($_GET['sort'],1,strlen($_GET['sort']));
  }
} else {
  $sort = "ORDER BY dates DESC";
}

$total = pg_query($postgres, "SELECT COUNT (id) FROM events WHERE id > 0 $q");

$result['total'] = pg_fetch_object($total);

//echo "SELECT * FROM events WHERE id > 0 $q LIMIT $limit OFFSET $offset";
//exit();

$res = pg_query($postgres, "SELECT * FROM events WHERE id > 0 $q $sort LIMIT $limit OFFSET $offset");

while ($row = pg_fetch_assoc($res)) {

  $info = [];

  if($res2 = pg_query($postgres, "SELECT * FROM info WHERE event_id = ".$row['id'])) {
    while ($row2 = pg_fetch_assoc($res2)) {
      $info[$row2['name']] = $row2['value'];
    }
  }

  $result['items'][] = [
    'id' => $row['id'],
    'events' => $row['events'],
    'fio' => $row['fio'],
    'iogv' => $row['iogv'],
    'login' => $row['login'],
    'systems' => $row['systems'],
    'dates' => $row['dates'],
    'info' => implode(' : ', $info)
  ];
}

