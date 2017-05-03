$(document).ready(function() // HTMLが全て読み込まれたあと実行
{

  // クリックしたらコメント欄表示
  $(document).on('click', '#request_button', function() {
    $("#requests").slideToggle();
  });

  // 各リクエストがクリックされた時の処理
  $('.request').on('click', function() {
      var friend_id = $(this).attr('id');
      console.log(friend_id)
      var array = friend_id.match(/[0-9]+\.?[0-9]*/g);
      var f_id = array[0];
      console.log(f_id)
      if (friend_id.slice(-1) == 'a') {
        console.log('hoge1');
        var state = 'admit';
      } else {
        console.log('hoge2');
        var state = 'reject';
      }
      var data = {state : state,
                  friend_id: f_id};

      $.ajax({
        type: "POST",
        url: "send_request.php",
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
        friend_id = task_data['id'];
        console.log(friend_id)

        // 処理済みリクエストの削除
        $('#' + friend_id + '_a').remove();
        $('#' + friend_id + '_r').remove();

        // メッセージの表示
        if (task_data['state'] == 'admit') {
          $('#' + friend_id + '_cont').append('<span>友達申請を許可しました。</span>');
        } else {
          $('#' + friend_id + '_cont').append('<span>友達申請を削除しました。</span>');
        }

        // スタイルの調整
        $('#' + friend_id + '_cont').css('padding-right','0');
        

      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      }).fail(function(data) {
          alert('error!!!' + data);
      });
  });
});