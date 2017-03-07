<?php
  require_once 'function.php';

  $list = getData();
  if (count($list) === 0){
    echo '<h1>Тесты не найдены</h1>';
    die;
  }
  $url = $_SERVER['REQUEST_URI'];
  $url = str_replace('list', 'test', $url);
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Список тестов</title>
</head>
<body>
  <h1>Список тестов:</h1>
  <?php foreach ($list as $key => $value): ?>
    <p><a href="<?= $url . '?list=' . $value['number'] ?>" target="_blank"><?= $value['number'] . ') ' . $value['question'] ?></a></p>
  <?php endforeach; ?>
</body>
</html>
