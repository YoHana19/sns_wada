$(document).ready(function() { // HTMLが全て読み込まれたあと実行

  // 背景画像にマウスオーバー時
  editImageMsg('edit-back-img', 'fb-image-lg', 'edit-back-img-msg', 'modal-overlay-back-img');

  // プロフ画像にマウスオーバー時
  editImageMsg('edit-profile-img', 'fb-image-profile', 'edit-profile-img-msg', 'modal-overlay-profile-img');

});


// 
// 関数定義
//

// マウスオーバーで画像編集表示
function editImageMsg(obj, parent_obj, content, overlay) {
  $("#" + obj).hover(
    function(){ // マウスオーバーした時
      $(this).blur() ;  //ボタンからフォーカスを外す
      if($("#" + overlay)[0]) return false ;

      //[#content]をフェードインさせる
      $("#" + content).fadeIn("slow");

      // オーバーレイ用のHTMLコードを、[<div class="fb-image-lg">]内の最後に生成する
      $("." + parent_obj).append('<div id="' +  overlay + '"></div>');
      //[#content]をフェードインさせる
      $("#" + overlay).fadeIn("slow");

    },
    function(){ // マウスアウトした時
      //オーバーレイ、画像編集メッセージ用のHTMLコードを、[<div class="fb-image-lg">]内のから取り除く
      $("#" + overlay + ", #" + content).fadeOut("slow",function() {
        //フェードアウト後、[#modal-overlay]をHTML(DOM)上から削除
        $("#" + overlay).remove();
      });
    }
  );
}