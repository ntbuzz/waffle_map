/* デバッグバー用のイベント処理 */
    $(".debugBar").mouseenter(function() {
        var mode = $('.debugBK').css('display');            // クローズ判定領域が有効になっているか
//        alert("over:"+mode);
        if(mode == "none") {
            $('.debugBK').css('display','block');           // クローズ判定領域を有効
            $('#debugMenu li').removeClass('select');       // select状態を解除
            $('.dbcontent li').css('display','none');       // コンテンツを一旦すべて非表示にする
            $('.debugBar').animate({'width':'600px'},800);
        };
    });
    // クリックしたときのファンクション
    $('#debugMenu li').click(function() {
        var sel = $(this).attr('class');
        if(sel == 'select') {
            $('.dbcontent li').css('display', 'none');            // コンテンツを非表示にする
            $(this).removeClass('select');                      // select状態を解除
        } else {
            var hh = $(window).height()*0.8;                    // ウィンドウの高さから計算
            $('.debug_srcollbox').css('height',hh+'px');        // メッセージ表示ボックスの高さを指定
            var index = $('#debugMenu li').index(this);         // index()関数を使いクリックされたタブが何番目かを取得する
            $('.dbcontent li')
                .css('display','none')                          // コンテンツを一旦すべて非表示にする
                .eq(index).css('display','block');              // クリックされたタブのコンテンツだけを表示
            $('#debugMenu li').removeClass('select');           // select状態を解除
            $(this).addClass('select');                         // クリックされたタブをselectする
        };
    });
    // ツールバーの外側をクリック
    $('.debugBK').click(function(){
        $('#debugMenu li').removeClass('select');           // select状態を解除
        $('.dbcontent li').css('display','none');           // コンテンツを一旦すべて非表示にする
        $('.debugBar').animate({'width':'1.0em'},180);
        $('.debugBK').css('display','none');                // クローズ判定領域を非表示
	});