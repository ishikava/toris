<?php

$res = pg_query($postgres, "SELECT * FROM events_data WHERE user_id = 1");

while ($row = pg_fetch_assoc($res)) {
  $result['items'][] = [
    'fullname' => $row['lastname'] . ' ' . $row['name'] . ' ' . $row['patronymic'],
    'login' => $row['login'],
    'status' => 'online',
  ];
}




