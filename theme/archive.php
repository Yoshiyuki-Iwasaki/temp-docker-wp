<?php
    $postType = $post->post_type; // 投稿タイプ
    $postSlug = $post->post_name; // 固定ページスラッグ
    $postID = $post->ID; // 投稿ID

    $filename = get_stylesheet_directory().'inc/archive/archive__' . $postType . '.php';
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
