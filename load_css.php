<!-- CSSの読込 -->
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="header.css">

<!-- URIで判定する -->
<!-- http://ドメイン名（ホスト名）/パス -->
<!-- パス部分のみ = URI -->
<!-- URIのファイル部分を取得して、ページごとで処理をわける -->
<?php 
if (empty($_SERVER['HTTPS'])) {
  echo 'http://';
} else {
  echo 'https://';
}

echo '<br>';
echo $_SERVER['HTTP_HOST'];
echo '<br>';
echo $_SERVER['REQUEST_URI'];
// URIの最後にあるファイル
$uri_arr = explode('/', $_SERVER['REQUEST_URI']);
echo '<pre>';
var_dump($uri_arr);
echo '</pre>';
$last = end($uri_arr);
echo $last;
echo '<br>';

// パラメータが存在する場合
$file_name = explode('?', $last);
$file_name = $file_name[0];
echo $file_name;
echo '<br>';

// どこでも使用できるように関数化
?>

<?php if ($file_name == 'index.php'): ?>
  ほげ<br>
  <link rel="stylesheet" type="text/css" href="top.css">
<?php endif; ?>
