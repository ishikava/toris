<?php

$res = pg_query($postgres, "SELECT AVG(timer_time) FROM timer
UNION ALL
SELECT AVG(timer_time) FROM timer WHERE timer_query = '".serialize($_GET)."'");

while ($row = pg_fetch_assoc($res)) {

 if($row['avg']){ $result['timer'] = round(floatval($row['avg']) * 10);}

}

