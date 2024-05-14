console.log("aa");

$(document).ready(function(){
  //この中の記述はHTMLを読み込んだ後にこの中の処理を読み込みますという記述
  loadSort();
});

function loadSort() {
  //この中の記述はHTMLを読み込んだ後にこの中の処理を読み込みますという記述
    $('#pr-table').tablesorter();
};


$(function() {
  //この中の記述はHTMLを読み込んだ後にこの中の処理を読み込みますという記述
console.log("xx");


//検索の非同期処理
$('.btn-into').click(function(e){
  //↑btn-intoのボタンをclickしたらこの中の処理を行います
  console.log("vv");
  e.preventDefault()
  //↑これ以外のイベントを阻止しますよー、フォームタグの中の同期通信が動くから阻止して非同期にする
  
  
  let formData = $('#search-forms').serialize();//lists.bladeのformタグ内の検索情報を一括で取得してformDataの変数に詰めている

  $.ajax({
    //送信設定
    type:'get',//web.phpのRoute::"get"にところと合わせる
    url:'lists/',//web.phpのRoute::get('"/lists"'
    data: formData,//18行目で指定してる
    dataType: 'html'//コントローラーからどうゆうファイルがリターンされるのか
  }).done(function(data){
    //通信成功で実行される処理,ここにviewファイルが飛んでる
    console.log("kk");
    let newTable = $(data).find('#products-table');//テーブルの部分だけ抜き出す
    $('#products-table').replaceWith(newTable);//差し替えが必要、#products-table(現在のテーブル)→newTable(新しいテーブル)に差し替える。replaceWithはhtmlでもOK
    //Formタグの中にタイトル、検索フォームなど色々入っているけどテーブル部分だけ欲しい
    loadSort();
   }).fail(function(){
    //通信が失敗した時に実行される処理、失敗しましたっていうアラートを記述したり
    alert('失敗');
  })
})

//削除の非同期処理
    $('.delet-btn').on('click', function(e) {
      e.preventDefault()
      console.log("ee");
      var deleteConfirm = confirm('削除してよろしいでしょうか？');
      //上記確認ウィンドウ、下記それがOKだったらとか

      if(deleteConfirm == true) {
        var clickEle = $(this)
        // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。

        var userID = clickEle.data('delete-id');
  console.log(userID)
        //送信設定、コントローラーに送る時

        $.ajax({

          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
          //wed.phpの何処に飛ばすか
          url: 'delet/' + userID,
          //POSTかGETしか書けない、※本当はDELETEがいい時は下に書く
          type: 'POST',
          //controllerに送りたい情報
          data: {'id': userID,
                 '_method': 'DELETE'} // ※DELETE リクエストだよ！と教えてあげる。
        })

        
  
       .done(function() {
          // 通信（$.ajaxの処理）が成功した場合、クリックした要素の親要素の <tr> を削除
          clickEle.parents('tr').remove();
        })
  
       .fail(function() {
          alert('エラー');
        });
  
      } else {
        (function(e) {
          e.preventDefault()
        });
      };
    });
  });
  
//カッコの外にあるとHTMLに読み込まれる前にそれを読み込んでしまう、どれに紐付けつかわからなくなる