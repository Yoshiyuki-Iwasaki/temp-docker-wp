<?php
	get_header();

	$cpSlug = esc_html(get_post_type_object(get_post_type())->name); // 投稿オブジェクトからスラッグを取得
	$cpLabel = esc_html(get_post_type_object(get_post_type())->label); // 投稿オブジェクトからラベルを取得

	$filename = get_stylesheet_directory().'inc/single/single__' . $cpSlug . '.php';
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
