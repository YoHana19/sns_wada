$(document).ready(function() // HTMLが全て読み込まれたあと実行
{
  $('[name=search_col]').change(function() {
  // 選択されているvalue属性値を取り出す
  var col = $('[name=search_col]').val();
  console.log(col);

  var search_tag = col + '_tag';
  console.log(search_tag);

  $('#search option').filter(function(index){
  return $(this).text() === search_tag;
}).prop('selected', true);

  //POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
  var data = {search_col : col}; // JSで連想配列を定義
  // $data = array('hoge' => 'ほげ'); PHPの連想配列
  // ここで定義したkeyが受け取り側の$_POSTのkeyになる
  /**
   * Ajax通信メソッド
   * @param type  : HTTP通信の種類
   * @param url   : リクエスト送信先のURL
   * @param data  : サーバに送信する値
   */
  $.ajax({
      type: "POST",
      url: "send_search.php",
      data: data,

  }).done(function() {
      // Ajax通信が成功した場合に呼び出される
      // PHPから返ってきたデータの表示
      // var task_data = JSON.parse(data);
      // alert(data);
      // jsonデータをJSの配列にパース（変換）する
      
      console.log('success');
      
    /**
     * Ajax通信が失敗した場合に呼び出されるメソッド
     */
    }).fail(function() {
        alert('error!!!');
    });
  });
});