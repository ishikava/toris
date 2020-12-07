<?php

$res = pg_query($postgres, "SELECT iogv_name FROM iogv ORDER BY iogv_name");

while ($row = pg_fetch_assoc($res)) {
  $result[] = $row['iogv_name'];
}




