<?php

$res = pg_query($postgres, "SELECT DISTINCT events FROM events");

while ($row = pg_fetch_assoc($res)) {
  $result[] = $row['events'];
}




