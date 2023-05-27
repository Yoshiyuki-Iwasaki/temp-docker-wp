<?php
	/*====================================================================
		カスタム投稿
	====================================================================*/
	add_action( 'init', 'create_post_type' );
	function create_post_type() {

		/*-----------------------------------------------
			カスタム投稿: カスタム投稿
		------------------------------------------------*/
		$post_name = 'カスタム投稿';
		$taxonomy = 'test';

		register_post_type( $taxonomy,
			array(
				'labels' => array(
					'name' => __( $post_name ),
					'singular_name' => __( $taxonomy )
				),
				'public' => true,
				'menu_position' => 5,
                'supports' => array('title','editor','thumbnail'),
				'has_archive' => true
			)
		);

		// タクソノミー: カテゴリー
		register_taxonomy(
			$taxonomy . '_cat',
			$taxonomy,
			array(
				'hierarchical' => true,
				'label' => 'カテゴリー',
				'singular_label' => 'カテゴリー',
				'show_ui' => true,
				'show_admin_column' => true,
				'rewrite' => array('slug' => 'categoru')
			)
		);
	}
?>
