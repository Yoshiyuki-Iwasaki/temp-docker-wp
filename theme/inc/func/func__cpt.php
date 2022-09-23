<?php
	/*====================================================================
		カスタム投稿
	====================================================================*/
	add_action( 'init', 'create_post_type' );
	function create_post_type() {

		/*-----------------------------------------------
			カスタム投稿: 製品案内
		------------------------------------------------*/
		$post_name = '製品案内';
		$taxonomy = 'product';

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

		// タクソノミー: 製品メーカー
		register_taxonomy(
			$taxonomy . '_supplier',
			$taxonomy,
			array(
				'hierarchical' => true,
				'label' => '製品メーカー',
				'singular_label' => '製品メーカー',
				'show_ui' => true,
				'show_admin_column' => true,
				'rewrite' => array('slug' => 'supplier_list')
			)
		);


		/*-----------------------------------------------
			カスタム投稿: 最新情報
		------------------------------------------------*/
		$post_name = '最新情報';
		$taxonomy = 'info';

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
	}
?>
