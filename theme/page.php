<?php
	get_header();

	$pageName = $post->post_title; // 固定ページ名前
	$pageID = $post->ID; // 固定ページID
	$pageSlug = $post->post_name; // 固定ページスラッグ
	$pageSlugClassName = ucfirst(strtolower($pageSlug)); // 固定ページスラッグ(頭文字が大文字ver)

	$pageParentID = $post->post_parent; // 固定ページの親ページID
	$pageParentData = get_post($pageParentID); // 固定ページの親ページ配列
	$pageParentName = $pageParentData->post_title; // 固定ページの親ページ名前
	$pageParentSlug = $pageParentData->post_name; // 固定ページの親ページスラッグ
	$pageParentSlugClassName = ucfirst(strtolower($pageParentSlug)); // 固定ページの親ページスラッグ(頭文字が大文字ver)

	$args = array(
		'post_parent' => $pageID,
		'post_type' => 'page'
	);
	$pageChildDatas = get_children( $args ); // 固定ページの子ページ達の配列

	$pageTitle_en = get_field('pageTitle_en'); // cf: 固定ページの英語タイトル
	$pageTitle_jp = get_field('pageTitle_jp'); // cf: 固定ページの日本語タイトル
	$pageCatch = get_field('pageCatch'); // cf: 固定ページのキャッチ文
	$pageText = get_field('pageText'); // cf: 固定ページのテキスト

	$filename = get_stylesheet_directory().'inc/page/page__' . $pageSlug . '.php';
	if (file_exists($filename)) {
		include $filename;
	} else {
		if (have_posts()):
			while (have_posts()) : the_post();
				the_content();
			endwhile;
		else:
			echo '投稿がありません。';
		endif;
	}
	get_footer();
?>