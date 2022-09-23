<?php
	function customBodyClass() {
		global $wp_query;
		global $template;
		$postType = get_post_type();
		$postType = 'is_post__' . $postType;

		if ( is_home() ) {
			echo 'is_home';
		}

		elseif ( is_front_page() ) {
			echo 'is_frontpage';
		}

		elseif ( is_page() ) {
			$page_id = $wp_query->get_queried_object_id();
			$post = get_post($page_id);
			if ( !is_page_template() ) {
				$tmpName = 'is_tmp__dealt';
			} else {
				$tmpName = basename($template);
			}
			$tmpName = str_replace('.php', '', $tmpName);
			$pageSlug = sanitize_html_class( str_replace( '.', '-', $post->post_name ) );

			echo 'is_page is_page__' . $pageSlug . ' ' . $tmpName . ' is__ID' . $page_id;
		}

		elseif ( is_preview() ) {
			echo 'is_previewMode';
		}

		elseif ( is_single() ) {
			global $post;
			$slug = $post->post_name;
			$slug = urldecode($slug);
			$id = $post->ID;
			$id = ' is_arti__' . $id;

			$taxonomy_names = get_post_taxonomies();

			echo 'is_page__single ' . $postType . $id;

			mb_regex_encoding("UTF-8");
			if ( !preg_match("/^[ぁ-んァ-ヶー一-龠０-９？！]+$/u", $slug) ) {
				echo ' is_arti__' . $slug;
			}

			if ( $taxonomy_names ) {
				foreach ($taxonomy_names as $key) {
					$terms = get_the_terms($post->ID, $key);

					if ( $terms ) {
						foreach ( $terms as $key ) {
							$termSlug = $key->slug;
							$termID = $key->term_taxonomy_id;
							$termSlug = urldecode($termSlug);
							mb_regex_encoding("UTF-8");
							if ( !preg_match("/^[ぁ-んァ-ヶー一-龠０-９？！]+$/u", $termSlug) ) {
								echo ' is_singleTerm__' . $termSlug;
							}

							echo ' is_singleTerm__' . $termID;
						}
					}
				}
			}
		}

		elseif ( is_archive() ) {
			$postType = get_post_type();
			echo 'is_post__' . $postType;

			if ( is_tax() ) {
				function keyTax() {
					$tax_slug = get_query_var('taxonomy');
					$term_slug = get_query_var('term');
					$term = get_term_by("slug",$term_slug,$tax_slug);
					$id = $term->term_id;
					return get_term($id,$tax_slug);
				}
				$term = keyTax();
				$term = $term->slug;
				$term = urldecode($term);

				echo ' is_page__taxonomy';

				mb_regex_encoding("UTF-8");
				if ( !preg_match("/^[ぁ-んァ-ヶー一-龠０-９？！]+$/u",$term) ) {
					echo ' is_term__' . $term;
				}
			} elseif ( is_year() ) {
				echo ' is_page__archive is_arc__year';
			} elseif ( is_month() ) {
				echo ' is_page__archive is_arc__month';
			} elseif ( is_date() ) {
				echo ' is_page__archive is_arc__date';
			} elseif ( is_search() ) {
				echo ' is_page__search';
			} else {
				echo ' is_page__archive';
			}
		}

		elseif ( is_404() ) {
			echo 'is_page__404';
		}

		elseif ( is_search() ) {
			echo 'is_page__search';
		}

		if ( !is_home() || !is_front_page() ) {
			echo ' is_page__lower';
		}
	}
?>
