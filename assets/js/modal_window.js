// 
// 実行部
// 

// 1番最初のモーダルウィンドウ呼び出し
modalWindowOnFirst('modal-open');

// モーダルウィンドウの終了
modalWindowOff('modal-close', 'modal-content_1');

//リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
$(window).resize(centeringModalSyncer);




// 
// 以下、関数定義
// 

// 1番最初のモーダルウィンドウ呼び出し関数（引数：モーダルウィンドウ呼び出しボタンのid）
function modalWindowOnFirst(button) {
  console.log('hoge1');
  $("#" + button).click (
  function() {
    console.log('hoge2');
    //キーボード操作などにより、オーバーレイが多重起動するのを防止する
    $(this).blur() ;  //ボタンからフォーカスを外す
    if($("#modal-overlay")[0]) return false ;   //新しくモーダルウィンドウを起動しない [下とどちらか選択]
    // if($("#modal-overlay")[0]) $("#modal-overlay").remove() ;   //現在のモーダルウィンドウを削除して新しく起動する [上とどちらか選択]

    //[$modal-content_1]をフェードインさせる
    windowFadeIn('modal-content_1')

    //オーバーレイ用のHTMLコードを、[body]内の最後に生成する
    $("body").append('<div id="modal-overlay"></div>');

    //[$modal-overlay]をフェードインさせる
    $("#modal-overlay").fadeIn("slow");
  });
}

// 2回目以降のモーダルウィンドウ呼び出し関数（第１引数：次のモーダルウィンドウ呼び出しボタンのid、第２引数：遷移元のコンテンツのid、第３引数：遷移先のコンテンツのid）
function modalWindowOn(button, content_finish, content_start){
  console.log('hoge3');
  $("#" + button).unbind().click(function() {
    console.log('hoge4');
    //[#modal-content_1]をフェードアウトする
    $("#" + content_finish).fadeOut("slow",function() {

      //[$modal-content_2]をフェードインさせる
      windowFadeIn(content_start);

    });
  });
}

// モーダルウィンドウの終了関数（第１引数：モーダルウィンドウ終了ボタンのid、第２引数：終了するコンテンツのid）
function modalWindowOff(button, content_finish){
  console.log('hoge5');
  $("#modal-overlay, #" + button).unbind().click(function() {
    console.log('hoge6');
    //[#modal-overlay]と[content_finish]をフェードアウトする
    $("#modal-overlay, #" + content_finish).fadeOut("slow",function() {
      console.log('hoge7');
      //フェードアウト後、[#modal-overlay]をHTML(DOM)上から削除
      $("#modal-overlay").remove();
  
    });

  });
}

// モーダルウィンドウをフェードインする関数
function windowFadeIn(content) {
  //[cont]をフェードインさせる
  $("#" + content).fadeIn("slow");
  
  // [content]をセンタリング
  centeringModalSyncer();
}

//センタリングをする関数
function centeringModalSyncer(){

  //画面(ウィンドウ)の幅を取得し、変数[w]に格納
  var w = $(window).width();

  //画面(ウィンドウ)の高さを取得し、変数[h]に格納
  var h = $(window).height();

  //コンテンツ(.content)の幅を取得し、変数[cw]に格納
  var cw = $(".content").outerWidth(true);

  //コンテンツ(.content)の高さを取得し、変数[ch]に格納
  var ch = $(".content").outerHeight(true);

  //コンテンツ(.content)を真ん中に配置するのに、左端から何ピクセル離せばいいか？を計算して、変数[pxleft]に格納
  var pxleft = ((w - cw)/2);

  //コンテンツ(.content)を真ん中に配置するのに、上部から何ピクセル離せばいいか？を計算して、変数[pxtop]に格納
  var pxtop = ((h - ch)/2);

  //[.content]のCSSに[left]の値(pxleft)を設定
  $(".content").css({"left": pxleft + "px"});

  //[.content]のCSSに[top]の値(pxtop)を設定
  $(".content").css({"top": pxtop + "px"});

}

