<form id="xml" action="" enctype="multipart/form-data" method="post">
  <br><br><br>
  <h1 align="center">Загрузка xml графов на сервер (аудит)</h1>
  <br><br><br>
  <div align="center"><input id="file" name="file" type="file" onchange="document.getElementById('xml').submit()"></input></div>
</form>

<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $target_file =  basename($_FILES["file"]["name"]);
  $file=$_FILES['file']['name'];
  $result = move_uploaded_file($_FILES['file']['tmp_name'],__DIR__."/test.xml");
  if ($result) {
    echo "file successfully uploaded";
  }
  else {
    echo "please select your file";
  }
}

exit();
