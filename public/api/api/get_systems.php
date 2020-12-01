<?php

$res = pg_query($postgres, "SELECT DISTINCT systems FROM events ORDER BY systems");

while ($row = pg_fetch_assoc($res)) {
  $result[] = $row['systems'];
}




