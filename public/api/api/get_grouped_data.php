<?php

$begin = microtime(true);

//system
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
  $system_q = "SELECT * FROM system WHERE id IN (" . implode(',', $system_ids) . ") ORDER BY system_name";
} else {
  $system_q = "SELECT * FROM system WHERE id = (SELECT MIN(id) FROM system)";
}


//iogv
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
  $iogv_q = "SELECT * FROM iogv WHERE id IN (" . implode(',', $iogv_ids) . ") ORDER BY iogv_name";
} else {
  $iogv_q = "SELECT DISTINCT ON (iogv_name) * FROM iogv ORDER BY iogv_name";
}

//$result['iogv_count'] = pg_fetch_object(pg_query($postgres, "SELECT COUNT(*) FROM ($iogv_q) as iogv"));

$system_count = 0;
$iogv_count = 0;

//data
$res = pg_query($postgres, $system_q);
while ($row = pg_fetch_assoc($res)) {
  $res2 = pg_query($postgres, $iogv_q);
  while ($row2 = pg_fetch_assoc($res2)) {

    $no_date = [];
    $date1 = [];
    $date2 = [];
    $date3 = [];

    //данные без даты за весь период
    $res3 = pg_query($postgres, "SELECT event_name, COUNT(event_id) FROM events_data JOIN event ON (events_data.event_id = event.id) WHERE system_id = " . $row['id'] . " AND iogv_id = " . $row2['id'] . " GROUP BY event_name ORDER BY event_name");
    while ($row3 = pg_fetch_assoc($res3)) {
      $no_date[] = [$row3['event_name'], $row3['count']];
    }

    //период 1
    if (isset($_GET['dates1']) && $_GET['dates1'] != "" && !empty($_GET['dates1'])) {
      $start = strtotime($_GET['dates1'][0]);
      $end = strtotime($_GET['dates1'][1]);
      $res3 = pg_query($postgres, "SELECT event_name, COUNT(event_id) FROM events_data JOIN event ON (events_data.event_id = event.id) WHERE system_id = " . $row['id'] . " AND iogv_id = " . $row2['id'] . " AND date >= $start AND date <= $end GROUP BY event_name ORDER BY event_name");
      while ($row3 = pg_fetch_assoc($res3)) {
        $date1[] = [$row3['event_name'], $row3['count']];
      }
    }

    //период 2
    if (isset($_GET['dates2']) && $_GET['dates2'] != "" && !empty($_GET['dates2'])) {
      $start = strtotime($_GET['dates2'][0]);
      $end = strtotime($_GET['dates2'][1]);
      $res3 = pg_query($postgres, "SELECT event_name, COUNT(event_id) FROM events_data JOIN event ON (events_data.event_id = event.id) WHERE system_id = " . $row['id'] . " AND iogv_id = " . $row2['id'] . " AND date >= $start AND date <= $end GROUP BY event_name ORDER BY event_name");
      while ($row3 = pg_fetch_assoc($res3)) {
        $date2[] = [$row3['event_name'], $row3['count']];
      }
    }

    //период 3
    if (isset($_GET['dates3']) && $_GET['dates3'] != "" && !empty($_GET['dates3'])) {
      $start = strtotime($_GET['dates3'][0]);
      $end = strtotime($_GET['dates3'][1]);
      $res3 = pg_query($postgres, "SELECT event_name, COUNT(event_id) FROM events_data JOIN event ON (events_data.event_id = event.id) WHERE system_id = " . $row['id'] . " AND iogv_id = " . $row2['id'] . " AND date >= $start AND date <= $end GROUP BY event_name ORDER BY event_name");
      while ($row3 = pg_fetch_assoc($res3)) {
        $date3[] = [$row3['event_name'], $row3['count']];
      }
    }

    for ($i = 0; $i < count($no_date); $i++) {
      $result['items'][] = [
        'system_name' => $row['system_name'],
        'iogv_name' => $row2['iogv_name'],
        'event_name' => $no_date[$i][0],
        'amount' => $no_date[$i][1],
        'event_name1' => $date1[$i][0] ?? '',
        'amount1' => $date1[$i][1] ?? 0,
        'event_name2' => $date2[$i][0] ?? '',
        'amount2' => $date2[$i][1] ?? 0,
        'event_name3' => $date3[$i][0] ?? '',
        'amount3' => $date3[$i][1] ?? 0
      ];
    }
    $iogv_count++;
  }
  $system_count++;
}

$result['system_count'] = $system_count;
$result['iogv_count'] = $iogv_count;

//запишем в базу время работы тяжелого запроса
$finish = microtime(true);
$res = pg_query($postgres, "INSERT INTO public.timer(timer_query, timer_time)	VALUES ('get_grouped_data', " . ($finish - $begin) . ");");
