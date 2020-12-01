<?php

$res = pg_query($postgres, "SELECT * FROM dashboard.groups ");

while ($row = pg_fetch_assoc($res)) {
    $res2 = pg_query($postgres, "SELECT * FROM dashboard.types WHERE  dashboard.types.group_id = " . $row['id']);
    while ($row2 = pg_fetch_assoc($res2)) {
        $row['types'][] = $row2;
    }
    $result[] = $row;
}