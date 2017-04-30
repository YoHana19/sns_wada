$(document).ready(function() // HTMLが全て読み込まれたあと実行
{

  // クリックしたらコメント欄表示
  $('#posts').on('click', '.comment_button', function() {
    console.log('hoge1')
    var haiku_id = $(this).attr('id'); // クリックされたコメントボタンidの取得
    var com_id = haiku_id + '_content'
    console.log(com_id)
    $("#" + com_id).slideToggle();
    console.log('hoge2')
  });

  // コメントの送信
  $('.comment_content').keypress(function (e) {
    if (e.which == 13) {
      // ここに処理を記述
      var haiku_id = $(this).attr('id');
      console.log(haiku_id)
      var array = haiku_id.match(/[0-9]+\.?[0-9]*/g);
      var h_id = array[0];
      console.log(h_id)
      var comment = $(this).attr('value');
      console.log(comment);
      var data = {comment : comment,
                  haiku_id: h_id};

      $.ajax({
        type: "POST",
        url: "send_comment.php",
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
        var haiku_id = task_data['id'] + '_cont';
        console.log(haiku_id)
        var num_comment_tag = document.getElementById('num_comment_' + task_data['id']);
        var num_comment = num_comment_tag.value;
        // 新規コメントの追加
        $('#' + haiku_id).prepend('<div class="row"><div class="col-sm-1"><img src="assets/images/' + task_data['user_picture_path'] + '" width="45" height="45"></div><div class="col-sm-11"><p><span class="name"><a href="user.php?user_id=' + task_data['member_id'] + '">' + task_data['nick_name'] + '</a></span>' + task_data['comment'] + '</p></div></div>');


      /**
       * Ajax通信が失敗した場合に呼び出されるメソッド
       */
      }).fail(function(data) {
          alert('error!!!' + data);
      });
    }
  });
});