<?php
if (isset($_GET['search']) && $_GET['search'] != "") {

  $res = pg_query($postgres, "SELECT * FROM public.user WHERE
  login ILIKE '%" . $_GET['search'] . "%'
  OR name ILIKE '%" . $_GET['search'] . "%'
  OR lastname ILIKE '%" . $_GET['search'] . "%'
  OR patronymic ILIKE '%" . $_GET['search'] . "%'
   ORDER BY login, name, lastname, patronymic  LIMIT 7 OFFSET 0");

  while ($row = pg_fetch_assoc($res)) {

    $result[] = ["value" => $row['lastname'] . ' ' .$row['name'] . ' ' .$row['patronymic'] . ' [ ' .$row['login'] . ' ]'];

  }

}
