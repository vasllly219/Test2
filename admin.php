<?php
  require_once 'function.php';
  $errors = [];
  $inputData = getInputValues([]);
  if(isPOST()) {
    $inputData = getInputValues(getParam('Data'));
    $errors = validateData($inputData);
    if (empty($errors) && setData($inputData)) {
      $url = $_SERVER['REQUEST_URI'];
      $url = str_replace('admin', 'list', $url);
      header('location: ' . $url);
    } else {
      if (empty($errors)) {
        $errors[] = 'При сохранении произошла ошибка';
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
  <title>Админка</title>
</head>
<body>
  <h1>Поле ввода тестов:</h1>
  <form method="POST">
    <label for="question">Вопрос: </label>
    <input name="Data[question]" value="<?= $inputData['question'] ?>" id="question"><br />

    <label for="answer">Ответ: </label>
    <input name="Data[answer]" value="<?= $inputData['answer'] ?>" id="answer">
    </br>
    <button type="submit" >Отправить</button>
  </form>
  </br>
  <ul>
    <?php foreach ($errors as $field => $error): ?>
      <li><?= getLabel($field) ?> - <?= $error ?></li>
    <?php endforeach; ?>
  </ul>
</body>
</html>
