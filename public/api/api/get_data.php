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

$total = pg_query($postgres, "SELECT COUNT (id) FROM events WHERE id > 0 $q");

$result['total'] = pg_fetch_object($total);

//echo "SELECT * FROM events WHERE id > 0 $q LIMIT $limit OFFSET $offset";
//exit();

$res = pg_query($postgres, "SELECT * FROM events WHERE id > 0 $q LIMIT $limit OFFSET $offset");

while ($row = pg_fetch_assoc($res)) {
  $result['items'][] = [
    'id' => $row['id'],
    'events' => $row['events'],
    'fio' => $row['fio'],
    'iogv' => $row['iogv'],
    'login' => $row['login'],
    'systems' => $row['systems'],
    'dates' => $row['dates']
  ];
}

