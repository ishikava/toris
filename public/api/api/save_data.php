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

    $res = pg_query_params($postgres, "INSERT INTO public.events( events, fio, iogv, login, systems, dates, info)
	VALUES ( $1, $2, $3, $4, $5, '" . date('Y-m-d H:i:s', time()) . "', $6)",
      array($request['event'], "Неавторизованный пользователь", $request['iogv'], "no login", $request['system'], json_encode($request['info'])));

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

