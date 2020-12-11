<?php

$res = pg_query($postgres, "SELECT * FROM public.user");

while ($row = pg_fetch_assoc($res)) {
  $result['items'][] = [
    'fullname' => $row['lastname'] . ' ' . $row['name'] . ' ' . $row['patronymic'],
    'login' => $row['login'],
    'status' => 'online',
  ];
}




