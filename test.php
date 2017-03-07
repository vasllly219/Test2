<?php
  require_once 'function.php';
  $list = getData();
  $test = findTest($list);
  $title = getTitle($test);
  $errors = [];
  $inputData = getInputValuesTest([]);
  if(isPOST()) {
    $inputData = getInputValuesTest(getParam('Data'));
    $errors = validateData($inputData);
    if (empty($errors) && validAnswer($inputData, $test['answer'])) {
      echo '<img src="certificate.php">';
      die;
    } else {
      if (empty($errors)) {
        $errors[] = 'Не верно';
      }
    }
  }
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Тест</title>
</head>
<body>
  <h1><?= $title ?></h1>
  <p><?= $test['question'] ?></p>
  <form method="POST">
    <label for="answer">Ответ: </label>
    <input name="Data[answer]" value="<?= $inputData['answer'] ?>" id="answer"><br />

    <label for="name">Ваше имя: </label>
    <input name="Data[name]" value="<?= $inputData['name'] ?>" id="name"><br />

    <button type="submit" >Отправить</button>
  </form>
  </br>
  <ul>
    <?php foreach ($errors as $field => $error): ?>
      <li><?= getLabel($field) . $error ?></li>
    <?php endforeach; ?>
  </ul>
</body>
</html>
