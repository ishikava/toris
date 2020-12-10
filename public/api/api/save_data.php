<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $result = [
    "Methods" => [
      "get_data" => [
        "url" => "http://194.67.109.37/api/save_data",
        "method" => "POST",
        "params" => [
          "system" => "required string",
          "iogv" => "required string",
          "event" => "required string",
          "info" => "required object"
        ],
        "description" => "Сохранить данные о событии в базу статистики",
        "example JSON" => "{\"system\" : \"Реестр спортивных сооружений\", \"iogv\" : \"Администрация КИРОВСКИЙ район\", \"event\" : \"Вход в систему (визит)\", \"info\" : {\"custom_data\": \"Дополнительная информация о событии\"}}"
      ]
    ]
  ];
} else {

  $request = json_decode(file_get_contents('php://input'), true, 512, JSON_UNESCAPED_UNICODE);

  if (!$request['system'] || $request['system'] == '' || !$request['iogv'] || $request['iogv'] == '' || !$request['event'] || $request['event'] == '') {
    $result = [
      "status" => 500,
      "message" => "Ошибка в JSON. Проверьте все обязательные поля"
    ];
  } else {

    //start transaction
    pg_query($postgres, "BEGIN");

    $event = $request['event'];
    $res = pg_query($postgres, "SELECT id FROM public.event WHERE event_name = '" . $event . "'");
    if ($row = pg_fetch_row($res)) {
      $event_id = $row[0];
    } else {
      $res = pg_query($postgres, "INSERT INTO public.event(event_name)	VALUES ('$event') RETURNING id");
      $row = pg_fetch_row($res);
      $event_id = $row[0];
    }

    $system = $request['system'];
    $res = pg_query($postgres, "SELECT id FROM public.system WHERE system_name = '" . $system . "'");
    if ($row = pg_fetch_row($res)) {
      $system_id = $row[0];
    } else {
      $res = pg_query($postgres, "INSERT INTO public.system(system_name)	VALUES ('$system') RETURNING id");
      $row = pg_fetch_row($res);
      $system_id = $row[0];
    }

    $iogv = $request['iogv'];
    $res = pg_query($postgres, "SELECT id FROM public.iogv WHERE iogv_name = '" . $iogv . "'");
    if ($row = pg_fetch_row($res)) {
      $iogv_id = $row[0];
    } else {
      $res = pg_query($postgres, "INSERT INTO public.iogv(iogv_name)	VALUES ('$iogv') RETURNING id");
      $row = pg_fetch_row($res);
      $iogv_id = $row[0];
    }

    $info = json_encode($request['info']);
    $res = pg_query($postgres, "SELECT id FROM public.info WHERE info_value::varchar = '" . $info . "'");
    if ($row = pg_fetch_row($res)) {
      $info_id = $row[0];
    } else {
      $res = pg_query($postgres, "INSERT INTO public.info(info_value)	VALUES ('$info') RETURNING id");
      $row = pg_fetch_row($res);
      $info_id = $row[0];
    }

    $res = pg_query($postgres, "SELECT id FROM public.user WHERE login = 'Test User'");
    if ($row = pg_fetch_row($res)) {
      $user_id = $row[0];
    } else {
      $res = pg_query($postgres, "INSERT INTO public.user(login, name, lastname, patronymic)	VALUES ('Test User', 'Иван', 'Иванов', 'Иванович') RETURNING id");
      $row = pg_fetch_row($res);
      $user_id = $row[0];
    }

    $res = pg_query($postgres, "INSERT INTO public.events_data(date, system_id, event_id, user_id, iogv_id, info_id)	VALUES (".time().", $system_id, $event_id, $user_id, $iogv_id, $info_id)");

    //end transaction
    pg_query($postgres, "COMMIT");

//$res = pg_query_params($postgres, "INSERT INTO public.events( events, fio, iogv, login, systems, dates, info)
//VALUES ( $1, $2, $3, $4, $5, '" . date('Y-m-d H:i:s', time()) . "', $6)",
//array($request['event'], "Неавторизованный пользователь", $request['iogv'], "no login", $request['system'], json_encode($request['info'])));

    if (pg_last_error() !== "") {
      $result = [
        "status" => 500,
        "message" => pg_last_error()
      ];
    } else {
      $result = [
        "status" => 200,
        "message" => "Событие успешно сохранено"
      ];
    }
  }

}

