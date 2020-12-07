<?php

$res = pg_query($postgres, "SELECT system_name FROM system ORDER BY system_name");

while ($row = pg_fetch_assoc($res)) {
  $result[] = $row['system_name'];
}




