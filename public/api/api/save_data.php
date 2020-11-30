<?php

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

