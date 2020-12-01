<?php

$res = pg_query($postgres, "SELECT DISTINCT iogv FROM events ORDER BY iogv");

while ($row = pg_fetch_assoc($res)) {
  $result[] = $row['iogv'];
}




