<?php

$res = pg_query($postgres, "SELECT system_name, login, date, event_name FROM events_data
JOIN public.system ON (events_data.system_id = public.system.id )
JOIN public.event ON (events_data.event_id = public.event.id )
JOIN public.user ON (events_data.user_id = public.user.id )
ORDER BY date DESC LIMIT 100 OFFSET 0");

while ($row = pg_fetch_assoc($res)) {
  $result['items'][] = [
    'system_name' => $row['system_name'],
    'login' => $row['login'],
    'date' => date('Y-m-d H:i:s', $row['date']),
    'event_name' => $row['event_name']
  ];
}




