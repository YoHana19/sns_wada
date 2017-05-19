$(document).ready(function() // HTMLが全て読み込まれたあと実行
{
  /**
   * 送信ボタンクリック
   */
  $('button.dislike').click(function() // inputタグがクリックされたら実行
  {
    var h_id = $(this).attr('id'); // クリックされたタグのtweet_idの値を取得
    //POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
    var array = h_id.match(/[0-9]+\.?[0-9]*/g);
    var haiku_id = array[0];
    var data = {haiku_id : haiku_id}; // JSで連想配列を定義
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
        url: "send/send_dislike.php",
        data: data,
    /**
     * Ajax通信が成功した場合に呼び出されるメソッド
     */
    }).done(function(data) {
      // Ajax通信が成功した場合に呼び出される
      // PHPから返ってきたデータの表示
      // var task_data = JSON.parse(data);
      // alert(data);
      // jsonデータをJSの配列にパース（変換）する
      var task_data = JSON.parse(data);
      var input_tag = document.getElementById(task_data['id'] + '_dislike');
      var input_icon = document.getElementById(task_data['id'] + '_icon_dislike');
      
      if (task_data['state'] == 'undislike') {
        // あしボタンの表示
        input_tag.className = "like btn icon-btn btn-primary btn-color-un";
        input_icon.className = "glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-un";
      } else {
        // あし取り消しボタンの表示
        input_tag.className = "like btn icon-btn btn-primary btn-color-dislike";
        input_icon.className = "glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-dislike";
      }
      
      // いいね数の表示
      var num_dislike = 'num_dislike_' + task_data['id'];
      document.getElementById(num_dislike).innerHTML = '&thinsp;' + task_data['dislike_cnt'] + '人';
    /**
     * Ajax通信が失敗した場合に呼び出されるメソッド
     */
    }).fail(function(data) {
        alert('error!!!' + data);
    });
  });
});

