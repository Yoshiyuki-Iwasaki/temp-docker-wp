<?php
	/*==========================================================================
		初期設定
	==========================================================================*/
	/*--------------------------------------------------------------
		テンプレートパス取得
	--------------------------------------------------------------*/
	function theme_dir() {
		return get_template_directory_uri();
	}
	add_shortcode('theme_dir', 'theme_dir'); //ショートコード


	/*--------------------------------------------------------------
		titleタグ出力
	--------------------------------------------------------------*/
	function nendebcom_theme_slug_setup() {
	   add_theme_support( 'title-tag' );
	}
	add_action( 'after_setup_theme', 'nendebcom_theme_slug_setup' );


	//Wordpress4.4以上でのタイトルセパレーターの設定
	function change_title_separator( $sep ){
	    $sep = ' | ';
	    return $sep;
	}
	add_filter( 'document_title_separator', 'change_title_separator' );


	/*--------------------------------------------------------------
		wp_head 設定
	--------------------------------------------------------------*/
	// 必要ファイル読み込み
	function my_wp_head() {
		// スタイルシート
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/_assets/js/lib/swiper/swiper.min.css', '', '1.0' );
		wp_enqueue_style( 'reset', get_template_directory_uri() . '/_assets/css/reset.css', '', '1.0' );
		wp_enqueue_style( 'style', get_template_directory_uri() . '/_assets/css/style.css', '', '1.0' );
		wp_enqueue_style( 'sp', get_template_directory_uri() . '/_assets/css/sp.css', '', '1.0' );

		// スクリプト
		// wp_enqueue_script( 'jquery' ); // WP デフォルト jQuery
		wp_enqueue_script( 'jquery', get_template_directory_uri() . '/_assets/js/lib/jquery-1.11.1.min.js', '', '1.11.1' );
		wp_enqueue_script( 'swiper', get_template_directory_uri() . '/_assets/js/lib/swiper/swiper.min.js', '', '1.0' );
		wp_enqueue_script( 'wow', get_template_directory_uri() . '/_assets/js/lib/wow/wow.js', '', '1.0' );
		wp_enqueue_script( 'cookie', get_template_directory_uri() . '/_assets/js/lib/cookie/cookie.js', '', '1.0' );
		wp_enqueue_script( 'script', get_template_directory_uri() . '/_assets/js/script.js', '', '1.0' );
	}
	add_action( 'wp_enqueue_scripts', 'my_wp_head' );

	// feed追加
	add_theme_support( 'automatic-feed-links' );


	/*--------------------------------------------------------------
		不要なwp_headを削除
	--------------------------------------------------------------*/
	remove_action('wp_head', 'feed_links_extra',3);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link');
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');


	/*--------------------------------------------------------------
		絵文字の無効化
	--------------------------------------------------------------*/
	remove_action('wp_head', 'print_emoji_detection_script',7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');


	/*--------------------------------------------------------------
		一覧表示件数変更
	--------------------------------------------------------------*/
	// function change_posts_per_page($query) {
	// 	if ( is_admin() || ! $query->is_main_query() ) {
	// 		return;
	// 	}
	//
	// 	if ( is_post_type_archive('info') ) { // 各種インフォメーション一覧ページ
	// 		$query->set( 'posts_per_page', '1' );
	// 	}
	// }
	// add_action( 'pre_get_posts', 'change_posts_per_page' );


	/*--------------------------------------------------------------
		空検索の場合
	--------------------------------------------------------------*/
	function search_no_keywords() {
		if (isset($_GET['s']) && empty($_GET['s'])) {
				include(TEMPLATEPATH . '/search.php');
				exit;
			}
		}
	add_action('template_redirect', 'search_no_keywords');


	/*==========================================================================
		出力
	==========================================================================*/
	/*--------------------------------------------------------------
		投稿名 or 投稿スラッグ出力
		post_type('name or label')
		label : 投稿名
	--------------------------------------------------------------*/
	function post_type( $type ) {
		$postType = get_post_type_object(get_post_type());
		if ( $type == 'name' ) {
			return $postType->name;
		} else {
			return $postType->label;
		}
	}


	/*--------------------------------------------------------------
		--- return_title( get_the_title(), 10 ); ---
	--------------------------------------------------------------*/
	function return_title( $content,$length ) {
		global $post;
		$text_length = $length;

		$content = strip_tags($post->post_title);
		$content = strip_shortcodes($content);
		if(mb_strlen($content, "utf-8")>$text_length) {
			$title= mb_substr($content,0,$text_length, "utf-8");
			return $title. '...' ;
		} else {
			return $content;
		}
	}


	/*--------------------------------------------------------------
		--- echo_content( get_the_content(), 10 ); ---
	--------------------------------------------------------------*/
	function echo_content( $content,$length ) {
		global $post;
		$text_length = $length;

		$content =  preg_replace('/<!--more-->.+/is',"",$content); //moreタグ以降削除
		$content =  strip_shortcodes($content);//ショートコード削除
		$content =  strip_tags($content);//タグの除去
		$content =  str_replace("&nbsp;","",$content);//特殊文字の削除（今回はスペースのみ）
		$content = strip_tags($post->post_content);
		$content = strip_shortcodes($content);
		if(mb_strlen($content, "utf-8")>$text_length) {
			$title= mb_substr($content,0,$text_length, "utf-8");
			echo $title. '...' ;
		} else {
			echo $content;
		}
	}



	/*--------------------------------------------------------------
		the_content 自動生成<p>タグ除去
	--------------------------------------------------------------*/
	// add_filter('the_content', 'wpautop_filter', 9);
	// function wpautop_filter($content) {
	// 	global $post;
	//
	// 	$arr_types = array('page', 'works_project');
	// 	$post_type = get_post_type( $post->ID );
	//
	// 	if ($post_type !== 'info') { // 「各種インフォメーション」以外
	// 		remove_filter('the_content', 'wpautop');
	// 		remove_filter('the_excerpt', 'wpautop');
	// 	}
	//
	// 	return $content;
	// }


	/*--------------------------------------------------------------
		サムネイル出力
		$size = 出力したいサムネイルの種類名
		$num = 出力形式 '0'->url, '1'->width, '2'->height
	--------------------------------------------------------------*/
	function opt_thumb_data($size, $noimg, $num) {
		$thumbnail_id = get_post_thumbnail_id($post->ID);
		if ( $size == '' ) {
			$size = 'full';
		}
		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $size );
			if ( $num == '' ) {
				echo $image[0];
			} else {
				echo $image[num];
			}
		} else {
			if ( $noimg == '' ) {
				echo get_template_directory_uri() . '/_assets/images/_etc/noimage.jpg';
			} else {
				echo get_template_directory_uri() . '/_assets/images/_etc/' . $noimg;
			}
		}
	}


	/*--------------------------------------------------------------
		サムネイルのalt出力
	--------------------------------------------------------------*/
	function thumb_alt() {
		if ( has_post_thumbnail() ) {
			return the_title();
		} else {
			return 'noimage';
		}
	}


	/*--------------------------------------------------------------
		リンクを付けたい場合 : opt_has_term_list(true)
	--------------------------------------------------------------*/
	function opt_has_term_list($link) {
		$taxes = get_post_taxonomies();
		foreach ($taxes as $tax) {
			$terms = get_the_terms($post->ID, $tax);
			if ( $terms ) {
				echo '<p class="termList taxGroup_' . $tax . '">';
					foreach ($terms as $term) {
						if ( !preg_match("/^[ぁ-んァ-ヶー一-龠０-９？！]+$/u", urldecode($term->slug) ) ) {
							$termClass = 'term_' . $term->slug;
						} else {
							$termClass = '';
						}
						if ( $link == true ) {
							$tag1 = 'a href="' . get_term_link($term) . '"';
							$tag2 = 'a';
						} elseif ( $link == '' ) {
							$tag1 = 'span';
							$tag2 = 'span';
						}
						echo '<' . $tag1 . ' class="term_list__item ' . $termClass . '">';
							echo $term->name;
						echo '</' . $tag2 . '>';
					}
				echo '</p>';
			}
		}
	}



	/*--------------------------------------------------------------
		人気記事サイドバー
	--------------------------------------------------------------*/
	function getPostViews($postID) { // post_meta取得
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if ( $count=='' ) {
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0 View";
		}
		return $count.' Views';
	}
	function setPostViews($postID) { // post_metaに入れる
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if ( $count=='' ) {
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		} else {
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);



	/*--------------------------------------------------------------
		サイト内検索の範囲に、カテゴリー名、タグ名、を含める
	--------------------------------------------------------------*/
	function custom_search($search, $wp_query) {
		global $wpdb;

		//サーチページ以外だったら終了
		if (!$wp_query->is_search)
			return $search;

		if (!isset($wp_query->query_vars))
			return $search;

		// ユーザー名とか、タグ名・カテゴリ名も検索対象に
		$search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : '');
		if ( count($search_words) > 0 ) {
			$search = '';
			foreach ( $search_words as $word ) {
				if ( !empty($word) ) {
					$search_word = $wpdb->escape("%{$word}%");
					$search .= " AND (
						{$wpdb->posts}.post_title LIKE '{$search_word}'
						OR {$wpdb->posts}.post_content LIKE '{$search_word}'
						OR {$wpdb->posts}.post_author IN (
							SELECT distinct ID
							FROM {$wpdb->users}
							WHERE display_name LIKE '{$search_word}'
						)
						OR {$wpdb->posts}.ID IN (
							SELECT distinct r.object_id
							FROM {$wpdb->term_relationships} AS r
							INNER JOIN {$wpdb->term_taxonomy} AS tt ON r.term_taxonomy_id = tt.term_taxonomy_id
							INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
							WHERE t.name LIKE '{$search_word}'
							OR t.slug LIKE '{$search_word}'
							OR tt.description LIKE '{$search_word}'
						)
					) ";
				}
			}
		}

		return $search;
	}
	add_filter('posts_search','custom_search', 10, 2);


	/*-----------------------------------------------------------
		一覧ページのページャーhtmlカスタマイズ
	------------------------------------------------------------*/
	function custom_wp_pagenavi($html) {
		$out = '';

		$out = str_replace("<div class='wp-pagenavi'>", "", $html);
		$out = str_replace("</div>", "", $out);
		return '<div class="u-pager__list">'.$out.'</div>';
	}

	add_filter( 'wp_pagenavi', 'custom_wp_pagenavi' );

?>
