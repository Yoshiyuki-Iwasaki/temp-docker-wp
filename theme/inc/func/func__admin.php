<?php
	/*--------------------------------------------------------------
		adminバー 表示 / 非表示
	--------------------------------------------------------------*/
	// show_admin_bar( false );



	/*==========================================================================
		管理画面
	==========================================================================*/
	/*--------------------------------------------------------------
		管理画面にファビコンを表示
	--------------------------------------------------------------*/
	function admin_favicon() {
		echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_template_directory_uri('template_url').'/images/_etc/favicon.ico" />';
	}
	add_action('admin_head', 'admin_favicon');


	/*--------------------------------------------------------------
		本体のアップデート通知を非表示
	--------------------------------------------------------------*/
	// add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );


	/*--------------------------------------------------------------
		プラグイン更新通知を非表示
	--------------------------------------------------------------*/
	// remove_action( 'load-update-core.php', 'wp_update_plugins' );
	// add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );


	/*--------------------------------------------------------------
		テーマ更新通知を非表示
	--------------------------------------------------------------*/
	// remove_action( 'load-update-core.php', 'wp_update_themes' );
	// add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );


	/*--------------------------------------------------------------
		管理画面 ダッシュボードにカスタム投稿タイプの投稿数を表示
	--------------------------------------------------------------*/
	function my_dashboard_glance_items( $elements ) {
		$args = array(
			'public' => true,
			'_builtin' => false
		);
		$post_types = get_post_types( $args );
		foreach ( $post_types as $post_type ) {
			$num_posts = wp_count_posts( $post_type );
			if ( $num_posts && $num_posts->publish ) {
				$text = number_format_i18n( $num_posts->publish ).' 件';
				$postTypeLabel = get_post_type_object( $post_type )->label;
				$elements[] = sprintf( '<a href="edit.php?post_type=%1$s" class="%1$s-count"><b>%3$s</b>：%2$s</a>', $post_type, $text, $postTypeLabel );
			}
		}
		return $elements;
	}
	add_filter( 'dashboard_glance_items', 'my_dashboard_glance_items' );

	// 管理画面 ダッシュボードにカスタム投稿タイプの投稿数 アイコン
	function my_dashboard_print_styles() {
		$args = array(
			'public' => true,
			'_builtin' => false
		);
		$post_types = get_post_types( $args );
		$br = "\n";
		echo '<style>' . $br;
			foreach ( $post_types as $post_type ) {
				echo '#dashboard_right_now .' . get_post_type_object( $post_type )->name . '-count:before { content: "\f109"; }' . $br;
			}
		echo '</style>'.PHP_EOL;
	}
	add_action( 'admin_print_styles', 'my_dashboard_print_styles' );


	/*--------------------------------------------------------------
		固定ページ編集画面でビジュアルエディタを表示しない
	--------------------------------------------------------------*/
	// function disable_visual_editor_in_page(){
	// 	global $typenow;
	// 	if( $typenow == 'page' ){
	// 		add_filter('user_can_richedit', 'disable_visual_editor_filter');
	// 	}
	// }
	// function disable_visual_editor_filter(){
	// 	return false;
	// }
	// add_action( 'load-post.php', 'disable_visual_editor_in_page' );
	// add_action( 'load-post-new.php', 'disable_visual_editor_in_page' );


	/*--------------------------------------------------------------
		アイキャッチを使用
	--------------------------------------------------------------*/
	add_theme_support( 'post-thumbnails' );

	// og画像
	add_image_size( '1200_630', 1200, 630, true);
	add_image_size( '600_315', 600, 315, true);
	add_image_size( '300_157', 300, 157, true);


	/*--------------------------------------------------------------
		管理画面メニュー非表示
	--------------------------------------------------------------*/
	function remove_menus () {
		global $menu;
	    global $submenu;
		unset($menu[5]);  // 投稿
		unset($menu[25]); // コメント
	    // var_dump($submenu);
	    unset($submenu['index.php'][10]); // ダッシュボード - 更新
	    unset($submenu['themes.php'][6]); // 外観 - カスタマイズ
	    unset($submenu['plugins.php'][15]); // プラグイン - プラグインの編集
	    unset($submenu['tools.php'][5]); // ツール - 利用可能なツール
	    unset($submenu['tools.php'][10]); // ツール - インポート
	    unset($submenu['tools.php'][15]); // ツール - エクスポート
	    unset($submenu['options-general.php'][15]); // 設定 - 投稿設定
	    unset($submenu['options-general.php'][30]); // 設定 - 投稿設定
	}
	add_action('admin_menu', 'remove_menus');


	function my_admin_css_common() { // 管理画面共通スタイル ?>
		<style>
			#wp-admin-bar-wp-logo, /* WP logo 非表示 */
			#wp-admin-bar-updates, /* バージョン更新ボタン 非表示 */
			.update-nag, /* 更新通知 非表示 */
			#menu-appearance ul li:nth-child(3), /* サイドバーのテーマの編集 非表示 */
			.update-plugins, /* サイドバーの更新カウント 非表示 */
			#contextual-help-link-wrap /* ヘルプボタン 非表示 */
				{ display: none !important; }
		</style>
	<?php
	}
	add_action('admin_print_styles', 'my_admin_css_common');


	function my_admin_css_option() { // 管理画面 設定 - 表示設定 不要パーツ ?>
		<style>
			.form-table tr:nth-child(1),
			/* .form-table tr:nth-child(2), */
			.form-table tr:nth-child(3),
			.form-table tr:nth-child(4) { display: none !important; }
		</style>
	<?php
	}
	add_action("admin_print_styles-options-reading.php", 'my_admin_css_option');


	function my_admin_css_index() { // 管理画面 ダッシュボード ?>
		<style>
			#welcome-panel, /* ようこそパネル 非表示 */
			#wp-version-message /* バージョン更新ボタン 非表示 */
				{ display: none !important; }
		</style>
	<?php
	}
	add_action("admin_print_styles-index.php", 'my_admin_css_index');


	function my_admin_css_plugins() { // 管理画面 プラグイン ?>
		<style>
			.plugin-update-tr, /* アップデート通知メッセージ 非表示 */
			.upgrade /* 利用可能な更新 非表示 */
				{ display: none !important; }
			.plugins .update th,
			.plugins .update td /* アップデート通知メッセージ 非表示によって消えてしまうボーダー追加 */
				{
					-webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,.1) !important;
					box-shadow: inset 0 -1px 0 rgba(0,0,0,.1) !important;
				}
		</style>
	<?php
	}
	add_action("admin_print_styles-plugins.php", 'my_admin_css_plugins');


	/*--------------------------------------------------------------
		管理バーから項目を削除する
	--------------------------------------------------------------*/
	function mytheme_remove_item( $wp_admin_bar ) {
		$wp_admin_bar->remove_node('wp-logo');
		$wp_admin_bar->remove_menu( 'updates' );
		$wp_admin_bar->remove_menu( 'customize' );
		$wp_admin_bar->remove_menu( 'search' );
	}
	add_action( 'admin_bar_menu', 'mytheme_remove_item', 1000 );


	/*--------------------------------------------------------------
		オプションページ
	--------------------------------------------------------------*/
	if( function_exists('acf_add_options_page') ) {
	    $option_page = acf_add_options_page(array(
	        'page_title' => 'トップページスライダー', // 設定ページで表示される名前
	        'menu_title' => 'トップページスライダー', // ナビに表示される名前
	        'menu_slug' => 'optionpage',
	        'capability' => 'edit_posts',
	        'redirect' => false
	    ));
	}




	/*==========================================================================
		プラグイン設定
	==========================================================================*/
	/*--------------------------------------------------------------
		tinyMCE フォントファミリー追加
	--------------------------------------------------------------*/
	add_filter('tiny_mce_before_init', function($settings){
		$settings['font_formats'] =
			"ＭＳ Ｐゴシック='ＭＳ Ｐゴシック','MS PGothic';".
			"ＭＳ ゴシック='ＭＳ ゴシック','MS Gothic';".
			"游ゴシック='游ゴシック','Yu Gothic';".
			"ヒラギノ角ゴ='ヒラギノ角ゴ Pro W3','Hiragino Kaku Gothic Pro','ヒラギノ角ゴ ProN W3','Hiragino Kaku Gothic ProN';".
			"ヒラギノ丸ゴ='ヒラギノ丸ゴ Pro W4','Hiragino Maru Gothic Pro','ヒラギノ丸ゴ ProN W4','Hiragino Maru Gothic ProN';".
			"ＭＳ Ｐ明朝='ＭＳ Ｐ明朝','MS PMincho';".
			"ＭＳ 明朝='ＭＳ 明朝','MS Mincho';".
			"游明朝='游明朝','Yu Mincho';".
			"ヒラギノ明朝='ヒラギノ明朝 Pro W3','Hiragino Mincho Pro',ヒラギノ明朝 ProN W3','Hiragino Mincho ProN';".
			"游明朝体='游明朝体','YuMincho';".
			"Century Gothic='Century Gothic';".
			"Franklin Gothic Medium='Franklin Gothic Medium';".
			"Gulim='Gulim';".
			"Impact='Impact';".
			"Verdana='Verdana';".
			"Georgia='Georgia','ヒラギノ角ゴ Pro W3','Hiragino Kaku Gothic Pro','メイリオ',Meiryo,'ＭＳ Ｐゴシック','MS PGothic';".
			"Times New Roman='Times New Roman';".
			"Courier New='Courier New';".
			"Comic Sans MS='Comic Sans MS';"
		;
		return $settings;
	});
?>
