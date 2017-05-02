$(document).ready(function() // HTMLが全て読み込まれたあと実行
{
  /**
   * 送信ボタンクリック
   */
  $('input.friend').click(function() // inputタグがクリックされたら実行
  {
    var user_id = $(this).attr('id'); // クリックされたタグのuser_idの値を取得
    //POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
    var data = {user_id : user_id}; // JSで連想配列を定義
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
        url: "send_friend.php",
        data: data,
    /**
     * Ajax通信が成功した場合に呼び出されるメソッド
     */
    }).done(function(data) {
      // Ajax通信が成功した場合に呼び出される
      // PHPから返ってきたデータの表示
      // jsonデータをJSの配列にパース（変換）する
      var task_data = JSON.parse(data);
      var input_tag = document.getElementById(task_data['id']);
      console.log(task_data['state']);
      if (task_data['state'] == 'undone') {
        // 友達申請ボタンの表示
        console.log('ok');
        input_tag.className = "btn btn-primary btn-xs";
        input_tag.value = "友達申請"
        $('#undone_msg').css('display', '');
        $('#done_msg').css('display', 'none');
      } else {
        // 申請取り消しボタンの表示
        console.log('unok');
        input_tag.className = "btn btn-danger btn-xs";
        input_tag.value = "申請取り消し";
        $('#undone_msg').css('display', 'none');
        $('#done_msg').css('display', '');
      }
      
    /**
     * Ajax通信が失敗した場合に呼び出されるメソッド
     */
    }).fail(function(data) {
        alert('error!!!' + data);
    });
  });
});

