<?php
if (isset($_GET['search']) && $_GET['search'] != "") {

  $res = pg_query($postgres, "SELECT DISTINCT(fio) FROM events WHERE fio ILIKE '%" . $_GET['search'] . "%' ORDER BY fio  LIMIT 7 OFFSET 0");

  while ($row = pg_fetch_assoc($res)) {

    $result[] = ["value" => $row['fio']];

  }

  if (count($result) < 7) {

    $res = pg_query($postgres, "SELECT DISTINCT(login) FROM events WHERE login ILIKE '%" . $_GET['search'] . "%' ORDER BY login  LIMIT 7 OFFSET 0");

    while ($row = pg_fetch_assoc($res)) {

      $result[] = ["value" => $row['login']];

    }

  }

}
