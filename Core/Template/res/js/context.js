// コンテキストメニューの表示
// jquery => コマンドでインクルードすること
// グローバルオブジェクト popup_menu_function が定義されているときだけ処理
// popup_menu_function にはコンテキストメニューの処理関数を登録しておく
if (typeof popup_menu_function == "object") {
    var selector = $(".context-menu");
    selector.each(function () {
        var self = $(this); // jQueryオブジェクトを変数に代入しておく
//        var self_id = self.attr("id");
        var ref_id = self.attr("data-element");  // 紐付けるID
        if (ref_id != "") {
            ref = $('#' + ref_id);
            self.find('li').each(function (index) {
                var func = $(this).attr('id');
                // メニュー関数が定義されているものだけ
                if (func && (typeof popup_menu_function[func] == "function")) {
//                    console.log(func);
                    $("#"+func).mousedown(function(e){ 
                        self.hide(); 
                        popup_menu_function[func]($(ref));
                    });
                } else {
                    $(this).addClass('disable');
                }
            });
            ref.bind("contextmenu", function(e){
                // イベント発生位置(クリック位置)を基準にメニューを表示
                self.css({'left': e.pageX + 'px','top': e.pageY + 'px'}).show();
                // 画面クリックでメニュー非表示
                $(document).mousedown(function() { self.hide(); });
                // ブラウザのコンテキストメニューを起動しない。
                return false;
            });
        };
    });
};