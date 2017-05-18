$(document).ready(function() // HTMLが全て読み込まれたあと実行
{
  /**
   * 送信ボタンクリック
   */
  $('button.friend').click(function() // inputタグがクリックされたら実行
  {
    var user_id = $(this).attr('id'); // クリックされたタグのuser_idの値を取得
    console.log(user_id);
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
        url: "send/send_friend.php",
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
      console.log(task_data['id']);
      if (task_data['state'] == 'request') {
        // 友達リクエスト中の表示
        console.log('ok');
        input_tag.className = "btn btn-primary btn-color-likes";
        input_tag.innerText = '友達リクエスト中'
      // } else {
      //   // 申請取り消しボタンの表示
      //   console.log('unok');
      //   input_tag.className = "btn icon-btn btn-primary btn-color-likes";
      //   input_tag.value = "友達リクエスト取消"
      }
      
    /**
     * Ajax通信が失敗した場合に呼び出されるメソッド
     */
    }).fail(function(data) {
        alert('error!!!' + data);
    });
  });
});

