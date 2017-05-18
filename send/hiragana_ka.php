<?php
require('../function.php');

$sentence = $_POST['sentence'];
if (!empty($sentence)) {
  $convert_kana = hiraganaKa($sentence);
  $data = array('sentence' => $convert_kana);
} else {
  $data = array('sentence' => $sentence);
}


header("Content-type: text/plain; charset=UTF-8");
//ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
echo json_encode($data);
?>