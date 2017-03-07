<?php
define('FILE_DATA', __DIR__ . '/tests.json');
define('FILE_CERTIFICATES', __DIR__ . '/certificates.json');
date_default_timezone_set('UTC');

function getInputValues($inputData)
{
  $defaultInputData = [
    'number' => '0',
    'question' => '',
    'answer' => ''
  ];
  return array_merge($defaultInputData, $inputData);
}

function isPOST()
{
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function getParam($name, $defaultValue = null)
{
  return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $defaultValue;
}

function validateData($inputData)//fixme
{
  $errors = [];
  foreach ($inputData as $item => $value) {
    if($value === ''){
      $message = 'не должно быть пустым';
      $errors[$item] = $message;
    }
  }
return $errors;
}

function setData($inputData)
{
  $data = getData();
  $inputData['number'] = count($data) + 1;
  $data[] = $inputData;
  if(file_put_contents(FILE_DATA, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))) {
    return true;
  } else {
    return false;
  }
}

function getData($fileName = FILE_DATA)
{
  $data = [];
  if (file_exists($fileName)) {
    $data = json_decode(file_get_contents($fileName), true);
    if (!$data) {
      return [];
    }
  }
  return $data;
}

function getLabel($name)
{
  $labels =  [
    'question' => 'Вопрос - ',
    'answer' => 'Ответ - ',
    'name' => 'Ваше имя - ',
    '0' => ''
  ];
  return isset($labels[$name]) ? $labels[$name] : $name;
}

//функции к test.php

function getInputValuesTest($inputData)
{
  $defaultInputData = [
    'answer' => '',
    'name' => ''
  ];
  return array_merge($defaultInputData, $inputData);
}

function findTest($list){
  foreach ($list as $value) {
    if ((string)$value['number'] === $_GET['list']){
      return $value;
    }
  }
}

function getTitle($test){
  if (is_array($test)){
    return 'Тест №' . $test['number'];
  } else{
    header("HTTP/1.0 404 Not Found");
    echo '<h1>Тест не найден</h1><p>404 Not Found</p>';
    die;
  }
}

function getOutputs($post, $answer){
  $output = '';
  if ($post['answer'] !== '' && $post['name'] !== ''){
    $output = validAnswer($answer, $post);
  }
  return $output;
}

function validAnswer($post, $answerTest){
  $answerUser = $post['answer'];
  if ($answerTest === $answerUser){
    setCertificateName($post['name']);
    return true;
  }
  return false;
}

function setCertificateName($name){
  $data = getData(FILE_CERTIFICATES);
  $ip = getClientIp();
  $data[] = [
    $ip => $name
  ];
  file_put_contents(FILE_CERTIFICATES, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function getClientIp()
{
    return $_SERVER['REMOTE_ADDR'];
}

//функции к certificate.php

function getName(){
  $data = getData(FILE_CERTIFICATES);
  $ip = getClientIp();
  foreach ($data as $key => $value) {
    if (isset($value[$ip])){
      return $value[$ip];
    }
  }
}

function generateCertificate($name){
  $im = imagecreatetruecolor(1300, 920);
  // RGB
  $backColor = imagecolorallocate($im, 255, 224, 221);
  $textColor = imagecolorallocate($im, 129, 15, 90);
  $fontFile = __DIR__ . '/assets/FONT.TTF';
  $imBox = imagecreatefrompng(__DIR__ . '/assets/present.png');
  imagefill($im, 0, 0, $backColor);
  imagecopy($im, $imBox, 0, 0, 0, 0, 1300, 920);
  imagettftext($im, 25, 0, 600, 430, $textColor, $fontFile, $name);
  imagettftext($im, 25, 0, 230, 727, $textColor, $fontFile, date("F j, Y"));
  imagettftext($im, 25, 0, 1000, 727, $textColor, $fontFile, ';)');
  imagepng($im);
  imagedestroy($im);
}
