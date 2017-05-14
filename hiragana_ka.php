<?php
/**
 * ルビ振りAPIへのリクエストサンプル（GET）
 *
 */
function hiraganaKa($sentence) {
  $api = 'http://jlp.yahooapis.jp/FuriganaService/V1/furigana';
  $appid = 'dj0zaiZpPURNeTFtMlVTbjUybSZzPWNvbnN1bWVyc2VjcmV0Jng9ZjQ-';
  $params = array(
      'sentence' => $sentence
  );
   
  $ch = curl_init($api.'?'.http_build_query($params));
  curl_setopt_array($ch, array(
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_USERAGENT      => "Yahoo AppID: $appid"
  ));
   
  $result = curl_exec($ch);
  curl_close($ch);

  $xml = simplexml_load_string($result);
  $furigana = '';
  foreach ($xml->Result->WordList as $WordList) {
      foreach ($WordList->Word as $Word) {
          if (isset($Word->Furigana)) {
              $furigana .= (string)$Word->Furigana;
          } else {
              $furigana .= (string)$Word->Surface;
          }
      }
  }
  return $furigana;
}

$sentence = $_POST['sentence'];
$convert_kana = hiraganaKa($sentence);


$data = array('sentence' => $convert_kana);

header("Content-type: text/plain; charset=UTF-8");
//ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
echo json_encode($data);
?>