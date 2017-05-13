$(document).ready(function() { // HTMLが全て読み込まれたあと実行
  $('#edit-back-img').hover(
    function(){
      console.log('hoge001');
      //オーバーレイ用のHTMLコードを、[<div class="fb-image-lg">]内の最後に生成する
      $(".fb-image-lg").append('<div id="modal-overlay-back-img"></div>');
      console.log('hoge002');
      //[$modal-overlay]をフェードインさせる
      $("#modal-overlay-back-img").fadeIn("slow");
    },
    function(){
      console.log('hoge003');
      //オーバーレイ用のHTMLコードを、[<div class="fb-image-lg">]内のから取り除く
      $("#modal-overlay-back-img").fadeOut("slow",function() {
        console.log('hoge7');
        //フェードアウト後、[#modal-overlay]をHTML(DOM)上から削除
        $("modal-overlay-back-img").remove();
      });
    }
  );
});