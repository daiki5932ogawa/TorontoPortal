<?php //子テーマで利用する関数を書く

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

// テーマのタグクラウドのパラメータ変更
function my_tag_cloud_filter($args) {
    $myargs = array(
        'smallest' => 12, // 最小文字サイズを指定する
        'largest' => 12, // 最大文字サイズを指定する
        'number' => 30,  // 一度に表示するタグの数を指定する（上限は45）
        'order' => 'RAND', // 表示順はランダムで
    );
    return $myargs;
}
add_filter('widget_tag_cloud_args', 'my_tag_cloud_filter');

/*
///////////////////////////////////////
// 投稿本文中ウィジェットの追加
///////////////////////////////////////
register_sidebars(1,
  array(
  'name'=>'投稿本文中',
  'id' => 'widget-in-article',
  'description' => '投稿本文中に表示されるウイジェット。文中最初のH2タグの手前に表示されます。',
  'before_widget' => '<div id="%1$s" class="widget-in-article %2$s">',
  'after_widget' => '</div>',
  'before_title' => '<div class="widget-in-article-title">',
  'after_title' => '</div>',
));

///////////////////////////////////////
//H2見出しを判別する正規表現を定数にする
///////////////////////////////////////
define('H2_REG', '/<h2.*?>/i');//H2見出しのパターン

///////////////////////////////////////
//本文中にH2見出しが最初に含まれている箇所を返す（含まれない場合はnullを返す）
//H3-H6しか使っていない場合は、h2部分を変更してください
///////////////////////////////////////
function get_h2_included_in_body( $the_content ){
  if ( preg_match( H2_REG, $the_content, $h2results )) {//H2見出しが本文中にあるかどうか
    return $h2results[0];
  }
}

///////////////////////////////////////
// 投稿本文中の最初のH2見出し手前にウィジェットを追加する処理
///////////////////////////////////////
function add_widget_before_1st_h2($the_content) {
  if ( is_single() && //投稿ページのとき、固定ページも表示する場合はis_singular()にする
       is_active_sidebar( 'widget-in-article' ) //ウィジェットが設定されているとき
  ) {
    //広告（AdSense）タグを記入
    ob_start();//バッファリング
    dynamic_sidebar( 'widget-in-article' );//本文中ウィジェットの表示
    $ad_template = ob_get_clean();
    $h2result = get_h2_included_in_body( $the_content );//本文にH2タグが含まれていれば取得
    if ( $h2result ) {//H2見出しが本文中にある場合のみ
      //最初のH2の手前に広告を挿入（最初のH2を置換）
      $count = 1;
      $the_content = preg_replace(H2_REG, $ad_template.$h2result, $the_content, 1);
    }
  }
  return $the_content;
}
add_filter('the_content','add_widget_before_1st_h2');

*/

function add_ads_before_1st_h2($the_content) {
  if (is_single()) {
    if (wp_is_mobile()) {
      $ads = <<< EOF
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
     <!-- Rectangle1 -->
     <ins class="adsbygoogle"
          style="display:inline-block;width:300px;height:250px"
          data-ad-client="ca-pub-6977538744407653"
          data-ad-slot="3247086123"></ins>
     <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
     </script>
EOF;
    } else {
      $ads = <<< EOF
★レクタングル大のコードを記述
EOF;
    }
    $h2 = '/<h2.*?>/i';//H2見出しのパターン
    if ( preg_match( $h2, $the_content, $h2s )) {//H2見出しが本文中にあるかどうか
      $the_content  = preg_replace($h2, $ads.$h2s[0], $the_content, 1);//最初のH2を置換
    }
  }
  return $the_content;
}
add_filter('the_content','add_ads_before_1st_h2');

?>
