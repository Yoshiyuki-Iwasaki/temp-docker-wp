<?php
    $postType = ($post->post_type); // 投稿タイプ
    $postSlug = $post->post_name; // 固定ページスラッグ
    $postID = ($post->ID); // 投稿ID

    include locate_template('inc/archive/archive__' . $postType . '.php');
?>
