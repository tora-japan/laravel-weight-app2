/*
 * my_dlg.js
 *
 * Copyright (c) 2021 tora-japan (s.noda)
 *
 * Released under the MIT license.
 * see https://opensource.org/licenses/MIT
 *
 */

// 初期化時に登録するもの
function dlgInit()
{
  // リサイズ
  $(window).resize(dlgResize);
}

// ダイアログを開く
function dlgOpen(dlgID,width=400,height=230)
{
  // 対象となるダイアログフォームを表示する
  $('#dlg'+dlgID).show();
  // IDを書き込む
  $('#dlg_main').attr('dlgID',dlgID);

//  iwidth = parseInt($('#dlg'+dlgID).css('width'));
//  iheight = parseInt($('#dlg'+dlgID).css('height'));
//  console.log(iwidth,iheight);

  // 幅と高さを指定
//  $('#dlg_main').css( {'width': width + 'px','height': height + 'px' } );

  // 背景を追加
  $('body').append('<div id=\'dlg_bg\'></div>');
  // リサイズを設定
  dlgResize();
  // 背景とダイアログを表示
  $('#dlg_bg,#dlg_main').show();
  // 背景をクリックすると閉じる
  $('#dlg_bg').click(function(){dlgClose();});
}

// ダイアログを閉じる
function dlgClose()
{
  dlgID=$('#dlg_main').attr('dlgID');
  $('#dlg'+dlgID).hide();

  $('#dlg_main,#dlg_bg').hide();
  $('#dlg_bg').remove();
}

// ダイアログを中央に寄せる
function dlgResize(){
  var w = $(window).width();
  var h = $(window).height();

  var dlgID=$('#dlg_main').attr('dlgID');
  var cw = $('#dlg'+dlgID).outerWidth();
  var ch = $('#dlg'+dlgID).outerHeight();
  $('#dlg_main').css({
    'left': ((w - cw)/2) + 'px',
    'top': ((h - ch)/2) + 'px'
  });
}

