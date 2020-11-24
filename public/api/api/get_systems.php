<?php

$res = pg_query($postgres, "SELECT DISTINCT systems FROM events");

while ($row = pg_fetch_assoc($res)) {
  $result[] = $row['systems'];
}




