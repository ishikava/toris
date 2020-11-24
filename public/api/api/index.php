<?php

$result = [
    "Methods" => [
        "index" => [
            "url" => "http://194.67.109.37/api",
            "method" => "GET/POST",
            "description" => "API для получения данных по колличеству заключенных договоров ОВИРУГ",
            "example JSON" => "{}"
        ],
        "get_groups" => [
            "url" => "http://194.67.109.37/api/get_groups",
            "method" => "GET/POST",
            "description" => "Получить список групп договоров",
            "example JSON" => "{}"
        ],
        "get_types_by_group" => [
            "url" => "http://194.67.109.37/api/get_types_by_group",
            "method" => "POST",
            "params" => [
                "group" => "required number"
            ],
            "description" => "Получить все типы договоров в группе",
            "example JSON" => "{\"group\" : 1}"
        ],
        "get_data" => [
            "url" => "http://194.67.109.37/api/get_data",
            "method" => "POST",
            "params" => [
                "group" => "required number",
                "start_month" => "required number",
                "start_year" => "required number",
                "interval" => "required number",
                "type" => "optional number",
                "district" => "optional number",
            ],
            "description" => "Получить данные за указанный период",
            "example JSON" => "{\"group\" : 1, \"start_month\" : 10, \"start_year\" : 2019, \"interval\" : 4, \"type\" : 1, \"district\" : 1}"
        ]
    ]
];