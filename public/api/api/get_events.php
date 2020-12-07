<?php

$res = pg_query($postgres, "SELECT event_name FROM event ORDER BY event_name");

while ($row = pg_fetch_assoc($res)) {
  $result[] = $row['event_name'];
}




