<?php
function getFileNameFromUri() {
  $uri_arr = explode('/', $_SERVER['REQUEST_URI']);
  $last = end($uri_arr);
  $file_name = explode('?', $last);
  $file_name = $file_name[0];
  return $file_name;
}

// 上記関数を基に引数に与えられたファイル名と$file_nameが一致するかどうかを判定しtrue or falseをreturnする関数isFileName()を作成しfooter.phpで実行する。
?>