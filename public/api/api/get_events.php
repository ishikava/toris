<?php

$res = pg_query($postgres, "SELECT DISTINCT events FROM events ORDER BY events");

while ($row = pg_fetch_assoc($res)) {
  $result[] = $row['events'];
}




