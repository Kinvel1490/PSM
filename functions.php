<?php
/**
 * recapcha v2
 * site-key 6Lc5cwspAAAAANGfOLA3ajvJUua2VmhGFYVz3agp
 * secret-key 6Lc5cwspAAAAAIRAK82GCaG-J3sUmVqn3zeYXBy3
 */
	add_action( 'wp_enqueue_scripts', 'enqueue_psm_scripts' );
	add_action( 'after_setup_theme', 'enqueue_features' );
	add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 4 );
	add_action( 'pre_get_posts', 'function_name' );
	add_action( 'admin_enqueue_scripts', 'enqueue_psm_admin_scripts' );
	add_action( 'wp_ajax_change_compare', 'psm_change_compare');
	add_action( 'wp_ajax_nopriv_change_compare', 'psm_change_compare');
	add_action( 'wp_ajax_delete_compare', 'psm_delete_compare');
	add_action( 'wp_ajax_nopriv_delete_compare', 'psm_delete_compare');
	add_action( 'wp_ajax_psm_woocommerce_ajax_add_to_cart', 'psm_woocommerce_ajax_add_to_cart');
	add_action( 'wp_ajax_nopriv_psm_woocommerce_ajax_add_to_cart', 'psm_woocommerce_ajax_add_to_cart');
	add_action( 'wp_ajax_make_offer', 'psm_woocommerce_make_offer');
	add_action( 'wp_ajax_nopriv_make_offer', 'psm_woocommerce_make_offer');
	add_action( 'wp_ajax_consult_request', 'psm_woocommerce_consult_request');
	add_action( 'wp_ajax_nopriv_consult_request', 'psm_woocommerce_consult_request');
	add_filter('woocommerce_quantity_input_args', 'fractional_amount', 10, 2);
	remove_filter( 'woocommerce_stock_amount', 'intval');
	add_filter(  'woocommerce_stock_amount', 'floatval' );

	function enqueue_psm_scripts () {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', get_template_directory_uri().'/assets/js/jquery-3.7.1.min.js', null, false, true );
		wp_register_script( 'jquery_cookie', get_template_directory_uri(  ).'/assets/js/jquery.cookie.js', ['jquery', 'swiper'], false, true  );
		wp_register_script( 'main_script', get_template_directory_uri(  ).'/assets/js/main.js', ['jquery', 'swiper'], false, true  );

		wp_enqueue_style( 'swiper-style', get_template_directory_uri(  ).'/assets/css/swiper-bundle.min.css');
		wp_enqueue_style( 'Roboto-font', get_template_directory_uri(  ).'/assets/fonts/Roboto.css');
		wp_enqueue_style( 'main_style', get_stylesheet_uri(  ));

		wp_enqueue_script('g-recaptcha', 'https://www.google.com/recaptcha/api.js', [], false, true);
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery_cookie' );
		wp_enqueue_script ('imask', get_template_directory_uri(  ).'/assets/js/imask.js', ['main_script'], false, true  );
		wp_enqueue_script ('swiper', get_template_directory_uri(  ).'/assets/js/swiper-bundle.min.js', [], false, true  );
		if(is_page_template( 'newpage.php' ) || is_page_template( 'photogalery.php' )){
			wp_enqueue_script ('phg_slide', get_template_directory_uri(  ).'/assets/js/phgslider.js', ['jquery', 'swiper'], false, true  );
			wp_enqueue_style( 'phg_galery', get_template_directory_uri(  ).'/assets/css/phggalery.css');
		}

		if (function_exists('is_product') && is_product()) {
			wp_enqueue_script('woocommerce-ajax-add-to-cart', get_template_directory_uri(  ). '/assets/js/ajax-add-to-cart.js', array('jquery'), '', true);
		}
		if(is_admin(  )){
			wp_enqueue_script( 'jquery' );
		}

		wp_enqueue_script( 'main_script' );

		wp_localize_script( 'main_script', 'images_oject', array(
			'close_menu' => CFS()->get('burger_close_img', 23),
			'open_menu' => CFS()->get('burger_img', 23),
			'ajax' => admin_url( 'admin-ajax.php' ),
			'star_empty' => CFS()->get('feed_back_page_star_empty', 287),
			'star_filled' => CFS()->get('feed_back_page_star_filled', 287),
			'ajaxurl' => admin_url('admin-ajax.php'),
        	'nonce' => wp_create_nonce('psm_site'),
			'heart' => CFS()->get('product_heart_no_sel', 23),
			'heart_red' => CFS()->get('product_heart_sel', 23),
		));
	}

	function enqueue_psm_admin_scripts (){
		wp_enqueue_script ('img_selector', get_template_directory_uri(  ).'/assets/js/admin_img_prod_cat.js', [], false, true  );
	}

	function enqueue_features () {
		add_theme_support( 'menu' );
		add_theme_support( 'custom-logo' );
		add_theme_support("woocommerce");
		add_theme_support("wc-product-gallery-zoom");     # Увеличение изображений
		add_theme_support("wc-product-gallery-lightbox"); # Модальные окна
		add_theme_support("wc-product-gallery-slider");   # Слайдер изображений
		add_theme_support( 'the_post_thumbnail', array( 'post' ) );
		register_nav_menu ('main_menu', 'Главное меню');

		add_theme_support( 'editor-font-sizes', [
			[
				'name'      => 'Малый (14)',
				'shortName' => 'S',
				'size'      => 14,
				'slug'      => 'small'
			],
			[
				'name'      => 'Обычный (16, 15)',
				'shortName' => 'M',
				'size'      => 16,
				'slug'      => 'regular'
			],
			[
				'name'      => 'Большой (25, 20, 18)',
				'shortName' => 'L',
				'size'      => 25,
				'slug'      => 'large'
			],
			[
				'name'      => 'Очень большой (40, 30, 20)',
				'shortName' => 'XL',
				'size'      => 40,
				'slug'      => 'larger'
			]
		] );

		add_theme_support( 'editor-color-palette', [
			[
				'name'  => 'Белый',
				'slug'  => 'white',
				'color' => '#ffffff',
			],
			[
				'name'  => 'Базовый для текста',
				'slug'  => 'base-text',
				'color' => '#101428',
			],
			[
				'name'  => 'Цвет хедера при скроле',
				'slug'  => 'header-csroll',
				'color' => '#454545',
			],
			[
				'name'  => 'Темно серый (#4E4E4E)',
				'slug'  => 'text-pale',
				'color' => '#4E4E4E',
			],
			[
				'name'  => 'Синий',
				'slug'  => 'psm-blue',
				'color' => '#233AB3',
			],
			[
				'name'  => 'Синий (hover)',
				'slug'  => 'psm-blue-hover',
				'color' => '#1D3093',
			],
			[
				'name'  => 'Бэкграунд футера',
				'slug'  => 'psm-gery-bg',
				'color' => '#f1f1f1',
			],
			[
				'name'  => 'Серый текст (#5E5E5E)',
				'slug'  => 'psm-gery-text',
				'color' => '#5E5E5E',
			],
			[
				'name'  => 'Серый текст (#838383)',
				'slug'  => 'psm-gery-text',
				'color' => '#5E5E5E',
			],
		] );
	}

	
	function special_nav_class($classes, $item, $args, $depth){
			if($depth === 0) {$classes = ["header_menu_item"];}
            if($depth === 1){$classes = ['header_menu_item_sub_menu_item'];}
			return $classes;
	}

	/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param string $sep  Разделитель. По умолчанию ' » '.
 * @param array  $l10n Для локализации. См. переменную `$default_l10n`.
 * @param array  $args Опции. Смотрите переменную `$def_args`.
 *
 * @return void Выводит на экран HTML код
 *
 * version 3.3.3
 */
function kama_breadcrumbs( $sep = ' » ', $l10n = array(), $args = array() ){
	$kb = new Kama_Breadcrumbs;
	echo $kb->get_crumbs( $sep, $l10n, $args );
}

class Kama_Breadcrumbs {

	public $arg;

	// Локализация
	static $l10n = [
		'home'       => 'Главная',
		'paged'      => 'Страница %d',
		'_404'       => 'Ошибка 404',
		'search'     => 'Результаты поиска по запросу - <b>%s</b>',
		'author'     => 'Архив автора: <b>%s</b>',
		'year'       => 'Архив за <b>%d</b> год',
		'month'      => 'Архив за: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Медиа: %s',
		'tag'        => 'Записи по метке: <b>%s</b>',
		'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
		// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
		// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
	];

	// Параметры по умолчанию
	static $args = [
		// выводить крошки на главной странице
		'on_front_page'   => false,
		// показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'show_post_title' => true,
		// показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
		'show_term_title' => true,
		// шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
		'title_patt'      => '<span class="kb_title">%s</span>',
		// показывать последний разделитель, когда заголовок в конце не отображается
		'last_sep'        => true,
		// 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
		// или можно указать свой массив разметки:
		// array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
		'markup'          => 'schema.org',
		// приоритетные таксономии, нужно когда запись в нескольких таксах
		'priority_tax'    => [ 'cours' ],
		// 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
		// Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
		// 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
		// порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
		'priority_terms'  => [],
		// добавлять rel=nofollow к ссылкам?
		'nofollow'        => false,

		// служебные
		'sep'             => '',
		'linkpatt'        => '',
		'pg_end'          => '',
	];

	function get_crumbs( $sep, $l10n, $args ){
		global $post, $wp_post_types;

		self::$args['sep'] = $sep;

		// Фильтрует дефолты и сливает
		$loc = (object) array_merge( apply_filters( 'kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
		$arg = (object) array_merge( apply_filters( 'kama_breadcrumbs_default_args', self::$args ), $args );

		$arg->sep = '<span class="kb_sep slash">' . $arg->sep . '</span>'; // дополним

		// упростим
		$sep = & $arg->sep;
		$this->arg = & $arg;

		// микроразметка ---
		if(1){
			$mark = & $arg->markup;

			// Разметка по умолчанию
			if( ! $mark ){
				$mark = [
					'wrappatt'  => '<div class="kama_breadcrumbs">%s</div>',
					'linkpatt'  => '<a href="%s">%s</a>',
					'sep_after' => '',
				];
			}
			// rdf
			elseif( $mark === 'rdf.data-vocabulary.org' ){
				$mark = [
					'wrappatt'  => '<div class="kama_breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
					'linkpatt'  => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
					'sep_after' => '</span>', // закрываем span после разделителя!
				];
			}
			// schema.org
			elseif( $mark === 'schema.org' ){
				$mark = [
					'wrappatt'  => '<div class="kama_breadcrumbs bread-cumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
					'linkpatt'  => '<span class="bread-cumbs__main" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name" class="bread-cumbs__main">%s</span></a></span>',
					'sep_after' => '',
				];
			}

			elseif( ! is_array( $mark ) ){
				die( __CLASS__ . ': "markup" parameter must be array...' );
			}

			$wrappatt = $mark['wrappatt'];
			$arg->linkpatt = $arg->nofollow ? str_replace( '<a ', '<a rel="nofollow"', $mark['linkpatt'] ) : $mark['linkpatt'];
			$arg->sep .= $mark['sep_after'] . "\n";
		}

		$linkpatt = $arg->linkpatt; // упростим

		$q_obj = get_queried_object();

		// может это архив пустой таксы
		$ptype = null;
		if( ! $post ){
			if( isset( $q_obj->taxonomy ) ){
				$ptype = $wp_post_types[ get_taxonomy( $q_obj->taxonomy )->object_type[0] ];
			}
		}
		else{
			$ptype = $wp_post_types[ $post->post_type ];
		}

		// paged
		$arg->pg_end = '';
		$paged_num = get_query_var( 'paged' ) ?: get_query_var( 'page' );
		if( $paged_num ){
			$arg->pg_end = $sep . sprintf( $loc->paged, (int) $paged_num );
		}

		$pg_end = $arg->pg_end; // упростим

		$out = '';

		if( is_front_page() ){
			return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf( $linkpatt, get_home_url(), $loc->home ) . $pg_end : $loc->home ) ) : '';
		}
		// страница записей, когда для главной установлена отдельная страница.
		elseif( is_home() ){
			$out = $paged_num ? ( sprintf( $linkpatt, get_permalink( $q_obj ), esc_html( $q_obj->post_title ) ) . $pg_end ) : esc_html( $q_obj->post_title );
		}
		elseif( is_404() ){
			$out = $loc->_404;
		}
		elseif( is_search() ){
			$out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
		}
		elseif( is_author() ){
			$tit = sprintf( $loc->author, esc_html( $q_obj->display_name ) );
			$out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
		}
		elseif( is_year() || is_month() || is_day() ){
			$y_url = get_year_link( $year = get_the_time( 'Y' ) );

			if( is_year() ){
				$tit = sprintf( $loc->year, $year );
				$out = ( $paged_num ? sprintf( $linkpatt, $y_url, $tit ) . $pg_end : $tit );
			}
			// month day
			else{
				$y_link = sprintf( $linkpatt, $y_url, $year );
				$m_url = get_month_link( $year, get_the_time( 'm' ) );

				if( is_month() ){
					$tit = sprintf( $loc->month, get_the_time( 'F' ) );
					$out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
				}
				elseif( is_day() ){
					$m_link = sprintf( $linkpatt, $m_url, get_the_time( 'F' ) );
					$out = $y_link . $sep . $m_link . $sep . get_the_time( 'l' );
				}
			}
		}
		// Древовидные записи
		elseif( is_singular() && $ptype->hierarchical ){
			$out = $this->_add_title( $this->_page_crumbs( $post ), $post );
		}
		// Таксы, плоские записи и вложения
		else {
			$term = $q_obj; // таксономии

			// определяем термин для записей (включая вложения attachments)
			if( is_singular() ){
				// изменим $post, чтобы определить термин родителя вложения
				if( is_attachment() && $post->post_parent ){
					$save_post = $post; // сохраним
					$post = get_post( $post->post_parent );
				}

				// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
				$taxonomies = get_object_taxonomies( $post->post_type );
				// оставим только древовидные и публичные, мало ли...
				$taxonomies = array_intersect( $taxonomies, get_taxonomies( [
					'hierarchical' => true,
					'public'       => true,
				] ) );

				if( $taxonomies ){
					// сортируем по приоритету
					if( ! empty( $arg->priority_tax ) ){

						usort( $taxonomies, static function( $a, $b ) use ( $arg ) {
							$a_index = array_search( $a, $arg->priority_tax );
							if( $a_index === false ){
								$a_index = 9999999;
							}

							$b_index = array_search( $b, $arg->priority_tax );
							if( $b_index === false ){
								$b_index = 9999999;
							}

							return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
						} );
					}

					// пробуем получить термины, в порядке приоритета такс
					foreach( $taxonomies as $taxname ){

						if( $terms = get_the_terms( $post->ID, $taxname ) ){
							// проверим приоритетные термины для таксы
							$prior_terms = &$arg->priority_terms[ $taxname ];

							if( $prior_terms && count( $terms ) > 2 ){

								foreach( (array) $prior_terms as $term_id ){
									$filter_field = is_numeric( $term_id ) ? 'term_id' : 'slug';
									$_terms = wp_list_filter( $terms, [ $filter_field => $term_id ] );

									if( $_terms ){
										$term = array_shift( $_terms );
										break;
									}
								}
							}
							else{
								$term = array_shift( $terms );
							}

							break;
						}
					}
				}

				// вернем обратно (для вложений)
				if( isset( $save_post ) ){
					$post = $save_post;
				}
			}

			// вывод

			// все виды записей с терминами или термины
			if( $term && isset( $term->term_id ) ){
				$term = apply_filters( 'kama_breadcrumbs_term', $term );

				// attachment
				if( is_attachment() ){
					if( ! $post->post_parent ){
						$out = sprintf( $loc->attachment, esc_html( $post->post_title ) );
					}
					else{
						if( ! $out = apply_filters( 'attachment_tax_crumbs', '', $term, $this ) ){
							$_crumbs = $this->_tax_crumbs( $term, 'self' );
							$parent_tit = sprintf( $linkpatt, get_permalink( $post->post_parent ), get_the_title( $post->post_parent ) );
							$_out = implode( $sep, [ $_crumbs, $parent_tit ] );
							$out = $this->_add_title( $_out, $post );
						}
					}
				}
				// single
				elseif( is_single() ){
					if( ! $out = apply_filters( 'post_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'self' );
						$out = $this->_add_title( $_crumbs, $post );
					}
				}
				// не древовидная такса (метки)
				elseif( ! is_taxonomy_hierarchical( $term->taxonomy ) ){
					// метка
					if( is_tag() ){
						$out = $this->_add_title( '', $term, sprintf( $loc->tag, esc_html( $term->name ) ) );
					}
					// такса
					elseif( is_tax() ){
						$post_label = $ptype->labels->name;
						$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
						$out = $this->_add_title( '', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html( $term->name ) ) );
					}
				}
				// древовидная такса (рибрики)
				elseif( ! $out = apply_filters( 'term_tax_crumbs', '', $term, $this ) ){
					$_crumbs = $this->_tax_crumbs( $term, 'parent' );
					$out = $this->_add_title( $_crumbs, $term, esc_html( $term->name ) );
				}
			}
			// влоежния от записи без терминов
			elseif( is_attachment() ){
				$parent = get_post( $post->post_parent );
				$parent_link = sprintf( $linkpatt, get_permalink( $parent ), esc_html( $parent->post_title ) );
				$_out = $parent_link;

				// вложение от записи древовидного типа записи
				if( is_post_type_hierarchical( $parent->post_type ) ){
					$parent_crumbs = $this->_page_crumbs( $parent );
					$_out = implode( $sep, [ $parent_crumbs, $parent_link ] );
				}

				$out = $this->_add_title( $_out, $post );
			}
			// записи без терминов
			elseif( is_singular() ){
				$out = $this->_add_title( '', $post );
			}
		}

		// замена ссылки на архивную страницу для типа записи
		// $home_after = apply_filters( 'kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );
		$home_after = null;

		if( '' === $home_after ){
			// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
			if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, [ 'post', 'page', 'attachment' ] )
				&& ( is_post_type_archive() || is_singular() || ( is_tax() && in_array( $term->taxonomy, $ptype->taxonomies ) ) )
			){
				$pt_title = $ptype->labels->name;

				// первая страница архива типа записи
				if( is_post_type_archive() && ! $paged_num ){
					$home_after = sprintf( $this->arg->title_patt, $pt_title );
				}
				// singular, paged post_type_archive, tax
				else{
					$home_after = sprintf( $linkpatt, get_post_type_archive_link( $ptype->name ), $pt_title );

					$home_after .= ( ( $paged_num && ! is_tax() ) ? $pg_end : $sep ); // пагинация
				}
			}
		}

		$before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep . $home_after : ( $out ? $sep : '' ) );

		$out = apply_filters( 'kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

		$out = sprintf( $wrappatt, $before_out . $out );

		return apply_filters( 'kama_breadcrumbs', $out, $sep, $loc, $arg );
	}

	function _page_crumbs( $post ) {
		$parent = $post->post_parent;

		$crumbs = [];
		while( $parent ){
			$page = get_post( $parent );
			$crumbs[] = sprintf( $this->arg->linkpatt, get_permalink( $page ), esc_html( $page->post_title ) );
			$parent = $page->post_parent;
		}

		return implode( $this->arg->sep, array_reverse( $crumbs ) );
	}

	function _tax_crumbs( $term, $start_from = 'self' ) {
		$termlinks = [];
		$term_id = ( $start_from === 'parent' ) ? $term->parent : $term->term_id;
		while( $term_id ){
			$term = get_term( $term_id, $term->taxonomy );
			$termlinks[] = sprintf( $this->arg->linkpatt, get_term_link( $term ), esc_html( $term->name ) );
			$term_id = $term->parent;
		}

		if( $termlinks ){
			return implode( $this->arg->sep, array_reverse( $termlinks ) );
		}

		return '';
	}

	// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
	function _add_title( $add_to, $obj, $term_title = '' ) {

		// упростим...
		$arg = &$this->arg;
		// $term_title чиститься отдельно, теги моугт быть...
		$title = $term_title ?: esc_html( $obj->post_title );
		$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

		// пагинация
		if( $arg->pg_end ){
			$link = $term_title ? get_term_link( $obj ) : get_permalink( $obj );
			$add_to .= ( $add_to ? $arg->sep : '' ) . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
		}
		// дополняем - ставим sep
		elseif( $add_to ){
			if( $show_title ){
				$add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
			}
			elseif( $arg->last_sep ){
				$add_to .= $arg->sep;
			}
		}
		// sep будет потом...
		elseif( $show_title ){
			$add_to = sprintf( $arg->title_patt, $title );
		}

		return $add_to;
	}

}
//Конец хлебных крошек

function function_name( $query ){
	$terms = [17,18,19,20,21,22,64,65];
	if(!is_admin() && $query->is_main_query()){
		if(get_queried_object() === null){return;}
		if (in_array(get_queried_object()->term_id, $terms) || in_array(get_queried_object()->parent, $terms)){
			if(isset($_GET['collections']) && $_GET['collections'] == 1){
			} elseif (isset($_GET['sales']) && $_GET['sales'] == 1) {
				$prodcat = '65, '.get_queried_object_id();
				$query->set( 'post_type', [ 'post', 'product' ] );
				$query->set( 'posts_per_page', 9 );
				$query->set( 'tax_query', [
					'relation' => 'AND',
					[
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => array( 'sales' ),
					],
					[
						'taxonomy' => 'product_cat',
						'field'    => 'id',
						'terms'    => array( get_queried_object_id(  ) ),
					]
				]);
			} else {
				$query->set( 'post_type', [ 'post', 'product' ] );
				$query->set( 'posts_per_page', 9 );
			}
		}
	}
}

add_filter( 'excerpt_length', function(){
	return 13;
} );
add_filter( 'excerpt_more', function( $more ) {
	return '...';
} );


add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );
function extend_comment_add_meta_box(){
	add_meta_box( 'title', __( 'Comment Metadata - Extend Comment' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
}

// Отображаем наши поля
function extend_comment_meta_box( $comment ){
	$rating = get_comment_meta( $comment->comment_ID, 'raiting', true );

	wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
	?>
	<p>
		<label for="rating"><?php _e( 'Rating: ' ); ?></label>
		<span class="commentratingbox">
		<?php
		for( $i=1; $i <= 5; $i++ ){
		  echo '
		  <span class="commentrating">
			<input type="radio" name="rating" id="rating" value="'. $i .'" '. checked( $i, $rating, 0 ) .'/>
		  </span>';
		}
		?>
		</span>
	</p>
	<?php
}

function psm_change_compare () {
	if(isset($_POST['nonce'])){
	if(!wp_verify_nonce( $_POST['nonce'], 'psm_site' )){wp_die();}
		get_compare_products (($_POST['id']));
	}
	wp_die();
}

function psm_delete_compare () {
	if(isset($_POST['nonce']) && isset($_POST['id']) && $_POST['id'] > 0){
		if(!wp_verify_nonce( $_POST['nonce'], 'psm_site' )){wp_die();}

		if(isset($_COOKIE['compare']) && $_COOKIE['compare'] !== ''){
			$c = explode(',', $_COOKIE['compare']);
		} else { $c = []; }
		if (count($c) > 0){
		$args = [
			'post_type' => 'product',
			'post__in' => $c,
			'posts_per_page' => -1,
		];
		$Q = new WP_Query($args);}
		if( $Q->have_posts() ) : 
			while( $Q->have_posts() ) : $Q->the_post();
				global $product;
				$prodcats = $product->category_ids;
				foreach($prodcats as $prodcat) {
					$term_id = get_term($prodcat)->term_id;
					if ($term_id == $_POST['id']){
						$prod_to_del[] = $product->get_id();
					}
				}
			endwhile;
		endif;
		print_r(json_encode( $prod_to_del));
		wp_die();
	}
}


function get_compare_products ($cat_to_show = 0){
	if(isset($_COOKIE['compare']) && $_COOKIE['compare'] !== ''){
		$c = explode(',', $_COOKIE['compare']);
	} else { $c = []; }
	if (count($c) > 0){
	$args = [
		'post_type' => 'product',
		'post__in' => $c,
		'posts_per_page' => -1,
	];
	$Q = new WP_Query($args);}
	if (!isset($Q)) {echo '<h2 class="has-large-font-size">Вы пока ничего не выбрали для сравнения</h2>'; } else {
	if( $Q->have_posts() ) : 
			$comp_products = [];
			$prod_all_attrs = [];
			// затем запускаем цикл
			while( $Q->have_posts() ) : $Q->the_post();
				global $post;
				global $product;
				$prodcats = $product->category_ids;
				foreach($prodcats as $prodcat) {
					$term_id = get_term($prodcat)->term_id;
					$comp_products[$term_id][$product->get_id()]['cat'] = get_term($prodcat)->name;
					$comp_products[$term_id][$product->get_id()]['name'] = $product->name;
					$comp_products[$term_id][$product->get_id()]['price'] = $product->get_price() != ''? $product->get_price()." &#8381;" : '';
					$comp_products[$term_id][$product->get_id()]['img'] = get_the_post_thumbnail_url();
					$comp_products[$term_id][$product->get_id()]['link'] = get_the_permalink( );
					$comp_products[$term_id][$product->get_id()]['prod'] = $product;
					$attrs = $product->get_attributes();
					foreach($attrs as $key=>$value){
						if(!empty($value) && $value->get_terms() != null){
							foreach ( $value->get_terms() as $pa ) { // Выборка значения заданного атрибута
								$comp_products[$term_id][$product->get_id()]['attributes'][wc_attribute_label( $value['name'])][] = $pa->name;
								if(array_key_exists($term_id, $prod_all_attrs)){
								if(!in_array(wc_attribute_label( $value['name']), $prod_all_attrs[$term_id])){
									$prod_all_attrs[$term_id][] = wc_attribute_label( $value['name']) ;
								}} else {
									$prod_all_attrs[$term_id][] = wc_attribute_label( $value['name']) ;
								}
						}
					}
					}
				}
				?>
		<?php
			endwhile;
			
			?>		
		
			<div class="cats_chooser_wrapper">
			<?php
			foreach($comp_products as $key=>$comp_product){
				if($cat_to_show > 0){
					$class = $key == $cat_to_show ? 'select_btn active' : 'select_btn';
				} else {
					$class = array_key_first($comp_products) == $key ? 'select_btn active' : 'select_btn';
				}
				echo '<div class="select_btn_wrapper">';
				echo '<div id="'.$key.'" class="'.$class.'"><span>'.get_term($key)->name.' </span><span class="product_count">'.count($comp_products[$key]).'</span></div>';
				echo '<img src="'.CFS()->get('product_catalog_filter_close',23).'" alt="">';
				echo '</div>';
			}	
				if ($cat_to_show > 0){
					$cp = array_key_exists($cat_to_show,$comp_products) ? $comp_products[$cat_to_show] : $cp=current($comp_products);
				} else {
					$cp=current($comp_products);
				}
			?>
			
			</div>
			<div class="compare_slider">
		
			<div class="compare_main_content_wrapper">
				<div class="swiper product_card_wrapper">
				<div class="phg_controls_wrapper">
					<div class="phg_swiper_prev" style="background-image:url(<?= CFS()->get('prod_cats_swiper_btn_icon', 23) ?>)"></div>
					<div class="phg_swiper_next" style="background-image:url(<?= CFS()->get('prod_cats_swiper_btn_icon', 23) ?>)"></div>
				</div>
					<div class="swiper-wrapper">

				<?php 
					
					foreach($cp as $key=>$tovar){
		
						$img_src = CFS()->get('product_heart_no_sel', 23);
						?>
					<div class="swiper-slide product_card data-container" data-prod=<?= $key ?>>
					    
					    <?php
                        $pred_request = get_post_meta($tovar['prod']->get_id(), 'pred_request', true);
							if($pred_request != ''){
								$span = '<span class="prod_in_order_pred">'.$pred_request.'</span>';
							} else {
								$span = '<span class="prod_in_order">Предзаказ</span>';
							}
							switch ($tovar['prod']->get_stock_status()) {
								case 'onbackorder': echo $span; break;
								case 'instock': echo '<span class="prod_in_stok">В наличии</span>'; break;
								case 'outofstock': echo '<span class="prod_not_in_stok">Нет в наличии</span>'; break;
							}
                        
                        ?>
                        <div style="position:relative; margin-top:55px">
					    
					    
					    
						<img src=<?= $img_src ?> alt="" class="product_sel_heart">
						<a href=<?= $tovar['link'] ?>>
							<img src=<?= $tovar['img'] ?> class='product_img'>
						    <p class='product_title'><?= $tovar['name'] ?></p>					    
                        </a>
                        </div>
						
						<div class="pice_wrapper">
                <?php
                    $is_single = get_post_meta( $tovar['prod']->get_id(), 'single_prod', true );
                    $sale_price = $tovar['prod']->get_sale_price();
                    $reg_price = $tovar['prod']->get_regular_price();
                    if (isset($sale_price) && $sale_price !== ''){
                        echo '<span class="product_price single_prod_sale_price">';
                        echo $is_single == 'yes' ? $sale_price.' &#8381;' : 'От '.$sale_price.' &#8381; / м2';
                        echo '</span>';
                    }
                    if (isset($sale_price) && $sale_price !== ''){
                        echo '<span class="product_price single_prod_price_saled">';
                    } else {
                        echo '<span class="product_price">';
                    }
                    if($reg_price !== '') {
                    echo $is_single == 'yes' ? '<span id="prod_price">'.$reg_price.'</span>'. '&#8381;' : 'От <span id="prod_price">'.
                    number_format(
                        $reg_price,
                        0,
                        ",",
                        " "
                    )
                    .'</span> &#8381; / м2';
                    echo '</span>';
                    } ?>
                    </div>
						
						<div class="product_btns_wrapper">
							<a href=<?= $tovar['link'] ?>><div class="product_btn_more">Подробнее</div></a>
							<img src=<?= CFS()->get('product_catalog_compare', 23) ?> alt="Сравнить" class="product_btn_compare">
						</div>
					</div>
					<?php 
					}?>
					</div>
					</div>

				<div class="compare_attrs_wrapper">
			<?php
			if ($cat_to_show > 0){
				$cc = array_key_exists($cat_to_show,$prod_all_attrs) ? $cat_to_show : key($comp_products);
			} else {
				$cc=key($comp_products);
			}
		foreach ($prod_all_attrs[$cc] as $prod_attr){
			echo '<div class="compare_prod_attr">';
			echo '<div class="swiper compare_prod_attr_swiper">';
			echo '<div class="swiper-wrapper">';
			foreach ($cp as $k=>$i){
				if(array_key_first($cp) === $k){
					echo '<span class="compare_prod_attr_name">'.$prod_attr.'</span>';
				}
				if(isset($i['attributes']) && !empty($i['attributes'])){
				if(array_key_exists($prod_attr, $i['attributes'])){
					if(count($i['attributes'][$prod_attr]) === 1){
						echo '<span class="swiper-slide compare_prod_attr_value">'.$i['attributes'][$prod_attr][0].'</span>';
					} else {
						echo '<span class="swiper-slide compare_prod_attr_value">';
						foreach ($i['attributes'][$prod_attr] as $v=>$to_print_attr){
							echo array_key_last($i['attributes'][$prod_attr]) == $v ? $to_print_attr : $to_print_attr.', ';
						}
						echo '</span>';
					}
				} else { echo '<span class="swiper-slide compare_prod_attr_value">&mdash;</span>'; }
			}else { echo '<span class="swiper-slide compare_prod_attr_value">&mdash;</span>'; }}
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
		?>	
				</div>
			</div>
			</div>
		
		<?php
	endif;}
}

## Создание пользовательского поля в товарах (раздел основное)
add_action( 'woocommerce_product_options_general_product_data', 'wpcrft_add_step_qty_woo_cf' );
function wpcrft_add_step_qty_woo_cf() {
	echo '<div class="options_group">';// Группировка полей
	// Числовое поле
	woocommerce_wp_text_input( array(
	   'id'                => '_qty_field_product',
	   'label'             => 'Количество товара в 1-й упаковке (м2)/длинна намотки для линолеума (м)',
	   'placeholder'       => '0',
		'desc_tip'          => 'true',
	   'description'       => 'Могут быть дробные числа, используется для подсчета м2 в корзине',
	   'type'              => 'number',
	   'custom_attributes' => array(
	      'step' => '0.001',
		  'min'  => '0',
	   ),
	) );
	
	echo '</div>';


	echo '<div class="options_group">';// Группировка полей
	woocommerce_wp_checkbox( array(
	   'id'                => '_full_package_sales',
	   'label'             => 'Продается только целыми упаковками',
	   'value'             => get_post_meta(get_the_ID(), 'full_package_sales', true),
	   'desc_tip'          => true,
	   'description'       => 'Для товаров, продающихся в м2, но без деления упаковки',
	   'cbvalue'           => 'yes', 
	) );
	echo '</div>';

	echo '<div class="options_group">';
	woocommerce_wp_checkbox(
		array(
			'id'      => 'spr',
			'value'   => get_post_meta( get_the_ID(), 'single_prod', true ),
			'label'   => 'Товар продается поштучно',
			'desc_tip' => true,
			'description' => 'Если товар продается не в м2',
			'cbvalue' => 'yes',
		)
	);
	echo '</div>';
	echo '<script>
		document.querySelector("#spr").addEventListener("change", (e)=>{
			if(e.target.checked) {
				document.querySelector("#_qty_field_product").setAttribute("disabled", "")
				document.querySelector("#_qty_field_product").value = "";
				document.querySelector("#_full_package_sales").setAttribute("disabled", "")
				document.querySelector("#_full_package_sales").checked = false;
			} else {
				document.querySelector("#_qty_field_product").removeAttribute("disabled");
				document.querySelector("#_full_package_sales").removeAttribute("disabled");
			}
		});
		if(document.querySelector("#spr").checked == true){
			document.querySelector("#_qty_field_product").setAttribute("disabled", "");
			document.querySelector("#_full_package_sales").setAttribute("disabled", "");
		}
	</script>';

	echo '<div class="options_group">';// Группировка полей
	woocommerce_wp_textarea_input( array(
	   'id'                => 'single_prod_notice',
	   'label'             => 'Примечание',
		'desc_tip'          => 'true',
	   'description'       => "Выводится в блоке примечание на странице товара",
	) );
	
	echo '</div>';

	$docs = get_post_meta(get_the_ID(), 'document_attrs', true);
	echo '<div class="options_group" style="position: relative; padding-bottom: 10px;">';// Группировка полей ?>
		<?php if(!empty($docs)){ 
			$docs = array_slice($docs, 0);
			echo '<div class="document_attrs_fields_wrapper">';
			for ($i = 0; $i < count($docs); $i++){
			?>
			<div class="document_attrs_fields" id="document_attrs_fields_<?= $i ?>" style="margin: 10px 0">
				<div class="form-field document_attrs[<?= $i ?>][img]_product_field">
				<div id="document_image_<?= $i ?>" class="document_image" style="float:left; margin-right: 10px"><img src="<?= $docs[$i]['img'] ? wp_get_attachment_thumb_url($docs[$i]['img']) : '' ?>" width="60px" height="60px" /></div>
				<div style="line-height: 30px;">
					<input type="hidden" class="document_attrs_image_id" id="document_attrs_image_id_<?= $i ?>" name="document_attrs[<?= $i ?>][img]" value="<?php echo $docs[$i]['img']? esc_attr(  $docs[$i]['img'] ) : 0; ?>" />
					<button type="button" id="upload_document_image_<?= $i ?>" class="upload_document_image button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" id="remove_document_image_<?= $i ?>" class="remove_document_image button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				</div>
				<div class="form-field document_attrs[<?= $i ?>][file]_product_field">
				<div style="line-height: 30px;">
					<input type="hidden" id="document_attrs_filename_<?= $i ?>" name="document_attrs[<?= $i ?>][filename]" value="" />
					<input type="hidden" class="document_attrs_file_id" id="document_attrs_file_id_<?= $i ?>" name="document_attrs[<?= $i ?>][file]" value="<?= $docs[$i]['file'] ? $docs[$i]['file']: '0' ?>" />
					<input type="hidden" class="document_attrs_filesize" id="document_attrs_filesize_<?= $i ?>" name="document_attrs[<?= $i ?>][filesize]" value="<?= $docs[$i]['filesize'] !== '' ? $docs[$i]['filesize']: '0' ?>" />
					<a href="<?= wp_get_attachment_thumb_url($docs[$i]['file']) ?>" class='document_link' id='document_link_<?= $i ?>' download><?= $docs[$i]['file'] != "" ? $docs[$i]['filename'] : ''?></a>
					<button type="button" id="upload_document_file_<?= $i ?>" class="upload_document_file button">Загрузить/добавить файл</button>
					<button type="button" id="remove_document_file_<?= $i ?>" class="remove_document_file button">Удалить файл</button>
				</div>
				</div>
				<p class="form-field document_attrs[<?= $i ?>][descr]_product_field">
					<label for="document_description" class="document_description_label">Название файла</label>
					<input id="document_description_<?= $i ?>" class='document_description short' type="text" name="document_attrs[<?= $i ?>][descr]" id="document_attrs_descr_id_<?= $i ?>" style="float: unset" value="<?= $docs[$i]['descr']?>">
				</p>
				<button type="button" class="remove_doc_block button is_destructive" id="remove_doc_block" class="button">Удалить документ</button>
			</div>
		

		<?php
		} echo '</div>'; } else { ?>
			<div class="document_attrs_fields_wrapper" style="margin: 10px 0">
			</div>
		<?php
		}
		?>

		<button type="button" id="add_new_doc" class="button">Добавить документ</button>

<?php
	echo '</div>';
}


	add_action( 'woocommerce_variation_options_dimensions', 'psm_add_pred_request_variable', 10, 3 );
	add_action( 'woocommerce_product_options_inventory_product_data', 'psm_add_pred_request' );

	function psm_add_pred_request_variable ($loop, $variation_data, $variation) {
		$product = wc_get_product(get_the_ID());
		if($product->is_type('variable')){
			$stock_status = $variation_data['_stock_status'][0];
			$predrequest_variant = get_post_meta($variation->ID, '_pred_request', true);
			$disabler = $stock_status === 'onbackorder' ? '' : ' disabled ';
			if($predrequest_variant === '2-3 дня'){
				$predrequest_variant = '';
				$inputdisabler = $disabler == ' disabled ' ? '' : ' disabled ';
				$checkerfixed = ' checked ';
				$checkermanual = '';
			} else {
				$predrequest_variant = empty($predrequest_variant) ? '' : $predrequest_variant;
				$checkermanual = empty($predrequest_variant) ? '' : ' checked ';
				$checkerfixed = '';
			}			
			echo '<p class="form-field variable_pred_request_field form-row">
				 <span class="variable_pred_request_label">Время прибытия предзаказа</span>
				<span class="variable_pred_request_radio_wrapper">
					<label for="variable_pred_request_radio_fixed'.$variation->ID.'">2-3 дня</label>
					<input type="radio" name="variable_pred_request_radio['.$variation->ID.']" id="variable_pred_request_radio_fixed'.$variation->ID.'" value="2-3 дня" class="variable_pred_request_radio"'.$disabler.$checkerfixed.'>
					<label for="variable_pred_request_radio_manual'.$variation->ID.'">Указать вручную</label>
					<input type="radio" name="variable_pred_request_radio['.$variation->ID.']" id="variable_pred_request_radio_manual'.$variation->ID.'" value="manual" class="variable_pred_request_radio"'.$disabler.$checkermanual.'>
					<input type="text" name="variable_pred_request_manual_value['.$variation->ID.']" id="variable_pred_request_manual_value'.$variation->ID.'" placeholder="5-6 дней" value="'.$predrequest_variant.'"'.$disabler.$inputdisabler.'>
				</span>
			</p>';
		}
	}

	add_action( 'woocommerce_save_product_variation', 'psm_save_variation_settings_fields', 10, 2 );
	function psm_save_variation_settings_fields( $post_id ) {
		if(isset ($_POST['variable_pred_request_manual_value'][$post_id]) && !empty($_POST['variable_pred_request_manual_value'][$post_id])){
			$predrequest_variant = $_POST['variable_pred_request_manual_value'][$post_id];
		} elseif (isset ($_POST['variable_pred_request_radio'][$post_id]) && !empty($_POST['variable_pred_request_radio'][$post_id]) && $_POST['variable_pred_request_radio'][$post_id] === "2-3 дня"){
			$predrequest_variant = $_POST['variable_pred_request_radio'][$post_id];
		}
		update_post_meta( $post_id, '_pred_request', esc_attr( $predrequest_variant ) );
	}


function psm_add_pred_request () {
	$product = wc_get_product(get_the_ID());
	if(!$product->is_type('variable')){
		wp_enqueue_script('pred_request', get_template_directory_uri(  ).'/assets/js/pred_request.js', ['jquery'], false, true  );
		$variable_parent_diasbler = ' disabled ';
	} else {
		wp_enqueue_script('pred_request_variable', get_template_directory_uri(  ).'/assets/js/pred_request_variable.js', ['jquery'], false, true  );
		$variable_parent_diasbler = '';
	}
		$pred_request = get_post_meta( get_the_ID(), 'pred_request', true );
		$pred_request_checked = 0;
		if($pred_request == '2-3 дня'){
			$pred_request_checked = 1;
			$pred_request = '';
			$pred_request = '';
		} elseif ($pred_request != '2-3 дня' && $pred_request != ''){
			$pred_request_checked = 2;
		}

		echo '<div class="options_group" style="min-height: 90px;">';// Группировка полей
		echo '
		<div class="form-field pred_request_field" style="padding: 5px 20px 5px 162px !important;">
			<label>Время прибытия предзаказа</label>
			<div style="margin: 0 0 20px 0;">
				<label for="pred_request_radio_preset" style="float: unset; margin: 0 10px 0 0;">2-3 дня</label>';
				if($pred_request_checked === 1){
					echo '<input type="radio" id="pred_request_radio_preset" value="2-3 дня" checked name="pred_request_radio_preset" style="margin: 0 20px 0 0">';
				} else {
					echo '<input type="radio" id="pred_request_radio_preset" value="2-3 дня" name="pred_request_radio_preset" style="margin: 0 20px 0 0">';
				}
				echo '<label for="pred_request_radio_manual" style="float: unset; margin: 0 10px 0 0;">Указать в ручную</label>';
				if($pred_request_checked === 2){
					echo '<input type="radio" id="pred_request_radio_manual" value="manual" checked name="pred_request_radio_preset" style="margin: 0 20px 0 0">';
				} else {
					echo '<input type="radio" id="pred_request_radio_manual" value="manual" name="pred_request_radio_preset" style="margin: 0 20px 0 0">';
				}
			echo '</div>';
			if($pred_request_checked === 2){
				echo '<input type="text" name="pred_request" id="pred_request" placeholder="5-10 дней" value="'.$pred_request.'">';
			} else {
				echo '<input type="text" name="pred_request" id="pred_request"'.$variable_parent_diasbler.'placeholder="5-10 дней" value="">';
			}
		echo '</div>';
		
		echo '</div>';
}


// print_r($_POST);
/*
 * Сохраняем значение полей
 */
function wpcrft_save_step_qty_woo_cf( $post_id ) {
	// Вызываем объект класса
	$product = wc_get_product( $post_id );
	// Сохранение цифрового поля
	$number_field = isset( $_POST['_qty_field_product'] ) ? sanitize_text_field( $_POST['_qty_field_product'] ) : '';
	$product->update_meta_data( '_qty_field_product', $number_field );

	$full_package_sales = isset( $_POST['_full_package_sales'] ) ? sanitize_text_field( $_POST['_full_package_sales'] ) : '';
	$product->update_meta_data( 'full_package_sales', $full_package_sales );	

	$single_prod = isset( $_POST['spr'] ) ? sanitize_text_field( $_POST['spr'] ) : '';
	$product->update_meta_data( 'single_prod', $single_prod );
	// Сохраняем все значения

	if(isset( $_POST['pred_request_radio_preset'] )){
		if(isset( $_POST['pred_request']) && $_POST['pred_request'] != ''){
			$pred_request = sanitize_text_field( $_POST['pred_request'] );
		} else {
			$pred_request = $_POST['pred_request_radio_preset'];
		}
	} else {
		$pred_request = '';
	}
	// $pred_request = isset( $_POST['pred_request'] ) ? sanitize_text_field( $_POST['pred_request'] ) : '';
	$product->update_meta_data( 'pred_request', $pred_request );


	$single_prod_notice = isset( $_POST['single_prod_notice'] ) ? sanitize_text_field( $_POST['single_prod_notice'] ) : '';
	$product->update_meta_data( 'single_prod_notice', $single_prod_notice );

	$document_attrs = isset( $_POST['document_attrs'] ) ? sanitize_text_field( $_POST['document_attrs'] ) : '';
	$product->update_meta_data( 'document_attrs', $document_attrs );

	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'wpcrft_save_step_qty_woo_cf', 10 );
 
## end Создание пользовательского поля

function psm_woocommerce_ajax_add_to_cart () {
	if(isset($_POST['nonce'])){
		if(!wp_verify_nonce( $_POST['nonce'], 'psm_site' )){wp_die();}
		$to_add_product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
		$to_add_quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
		$to_add_product_status = get_post_status($to_add_product_id);
		if(!empty($_POST['prod_width'])){
		    $to_add_product_width = sanitize_text_field($_POST['prod_width']);
		}
		$variation_id = 0;
		if(isset($_POST['variation']) && intval($_POST['variation']) > 0){
			$variation_id = $_POST['variation'];
		}

		if(!empty($to_add_product_width)){
			if(gettype($to_add_product_width) == "integer"){
				$to_add_prod_meta["item_width"] = $to_add_product_width;
			}
			if(gettype($to_add_product_width) == "string"){
				$to_add_prod_meta["item_width"] = $to_add_product_width;
			}
			if(gettype($to_add_product_width) == 'array'){
				$to_add_product_width = $to_add_product_width[array_key_first($to_add_product_width)];
				$to_add_prod_meta["item_width"] = $to_add_product_width;
			}
		}
		if(isset ($_POST['full'])){
			$to_add_prod_meta['full'] = $_POST['full'];
		}
		if(isset($_POST['width'])){
			$to_add_prod_meta['width'] = $_POST['width'];
		}
		$passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $to_add_product_id, $to_add_quantity);
		if ($passed_validation && WC()->cart->add_to_cart($to_add_product_id, $to_add_quantity, $variation_id, array(), $to_add_prod_meta) && 'publish' === $to_add_product_status) {

			do_action('woocommerce_ajax_added_to_cart', $to_add_product_id);

			if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
				wc_add_to_cart_message(array($to_add_product_id => $to_add_quantity), true);
			}
			$stubtotal = WC()->cart->cart_contents_total;
			$data = [
				'img' => CFS()->get('single_prod_cart_icon', 23),
				'prod_count' => get_psm_cart(),
			];
			print_r (json_encode( $data ));
		} else {
			$data = array(
				'error' => true,
				'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($to_add_product_id), $to_add_product_id),
			);
			echo wp_send_json($data);
		}
	} 
	wp_die();
}

require('prod_cats_options.php');

function is_product_in_cart($id = 0) {
    foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
        $cart_product = $values['data'];
		if ($id === 0 ){
			$id = get_the_ID();
		}
        if( $id == $cart_product->id ) {
            return true;
        }
    }

    return false;
}



add_action( 'template_redirect', 'f123_recently_viewed_product_cookie', 20 );
 
function f123_recently_viewed_product_cookie() {
	if ( ! is_product() ) {
		return;
	}
	if ( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
	}
 
	if ( ! in_array( get_the_ID(), $viewed_products ) ) {
		$viewed_products[] = get_the_ID();
	}
 
	if ( sizeof( $viewed_products ) > 8 ) { // задаем количество товаров кот. будет храниться
		array_shift( $viewed_products ); 
	}
 
	wc_setcookie( 'woocommerce_recently_viewed_2', join( '|', $viewed_products ) );
}
 
add_shortcode( 'recently_viewed_products', 'f123_recently_viewed_products' );
 
function f123_recently_viewed_products() {
 
	if( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
	}
 
	if ( empty( $viewed_products ) ) {
		return;
	}
 
	$viewed_products = array_reverse( array_map( 'absint', $viewed_products ) );
	echo '<div class="product_cards_wrapper">';
	foreach($viewed_products as $viewed_product){ 
		$recent = wc_get_product($viewed_product);
		$is_single = get_post_meta( $recent->get_id(), 'single_prod', true );
		$img_src = CFS()->get('product_heart_no_sel', 23);
		?>

		<div class="product_card data-container" data-prod="<?= $recent->get_id() ?>">
		    <?php
            $pred_request = get_post_meta($recent->get_id(), 'pred_request', true);
				if($pred_request != ''){
					$span = '<span class="prod_in_order_pred">'.$pred_request.'</span>';
				} else {
					$span = '<span class="prod_in_order">Предзаказ</span>';
				}
				switch ($recent->get_stock_status()) {
					case 'onbackorder': echo $span; break;
					case 'instock': echo '<span class="prod_in_stok">В наличии</span>'; break;
					case 'outofstock': echo '<span class="prod_not_in_stok">Нет в наличии</span>'; break;
				}
            
            ?>
            <div style="position:relative; margin-top:55px">
    			<img src=<?= $img_src ?> alt="" class="product_sel_heart">
    			<a href=<?= get_the_permalink( $viewed_product ) ?>>
    			<img src=<?= get_the_post_thumbnail_url($viewed_product) ?> class='product_img'>
    			<p class='product_card_product_title'><?= get_the_title($viewed_product); ?></p>
    			</a>
    		</div>
    		<div class="pice_wrapper">
			<?php
                    $sale_price = $recent->get_sale_price();
                    $reg_price = $recent->get_regular_price();
                    if (isset($sale_price) && $sale_price !== ''){
                        echo '<span class="product_price single_prod_sale_price">';
                        echo $is_single == 'yes' ? $sale_price.' &#8381;' : 'От '.$sale_price.' &#8381; / м2';
                        echo '</span>';
                    }
                    if (isset($sale_price) && $sale_price !== ''){
                        echo '<span class="product_price single_prod_price_saled">';
                    } else {
                        echo '<span class="product_price">';
                    }
                    if($reg_price !== '') {
                    echo $is_single == 'yes' ? '<span id="prod_price">'.$reg_price.'</span>'. '&#8381;' : 'От <span id="prod_price">'.
                    number_format(
                        $reg_price,
                        0,
                        ",",
                        " "
                    )
                    .'</span> &#8381; / м2';
                    echo '</span>';
                    } ?>
			</div>
			<div class="product_btns_wrapper">
				<a href=<?= get_the_permalink( $viewed_product ) ?>><div class="product_btn_more">Подробнее</div></a>
				<img src=<?= CFS()->get('product_catalog_compare', 23) ?> alt="Сравнить" class="product_btn_compare">
			</div>
		</div>

	<?
	}
	echo '</div>';

}

function psm_woocommerce_make_offer () {
	$client_name = sanitize_text_field($_POST['name']);
	$client_phone = sanitize_text_field($_POST['phone']);
	$client_email = sanitize_text_field($_POST['email']);
	if(isset($_POST['shipping'])){
	    switch ($_POST['shipping']){
	        case 'self': $client_shipping = 'Самовывоз'; break;
	        case 'shipping': $client_shipping = 'Доставка' ; break;
	        default: $client_shipping = '';
	    }
	}
	$client_adress = sanitize_text_field($_POST['adress']);
	if(isset($_POST['payment'])){
	    switch ($_POST['payment']){
	        case 'cash_card_office': $client_payment = 'Карта или наличные в офисе'; break;
	        case 'cash_recieve': $client_payment = 'Наличными при получении'; break;
	        case 'card_company': $client_payment = 'Безнал. расчет как юр. лицо'; break;
	        default: $client_payment = '';
	    }
	}
	$client_comment = sanitize_text_field($_POST['comment']);
	
	$msg = "ФИО: ".$client_name."<br>Телефон: ".$client_phone."<br>E-mail: ".$client_email;
	if(isset($client_shipping)){
	    $msg.="<br>Способ доставки: ".$client_shipping;
	}
	$msg.= $client_adress !== '' ? '<br>Адрес доставки: '.$client_adress : '';
	if(isset($client_payment)){
	    $msg.= '<br>Cпособ оплаты: '.$client_payment;
	}
	$msg.= $client_comment !== '' ? '<br>Комментарий: '.$client_comment : '';
	
	$msg .= '
	<style>
	    th,td{
	        padding: 5px;
	        border: 1px solid black;
	    }
	    table{
	        width: 100%;
	        border-spacing: 0;
	        border-collapse: collapse;
	    }
	</style>
	        <table>
	            <thead>
        			<tr>
        				<th>Наименование</th>
        				<th>Упаковка</th>
        				<th>Цена</th>
        				<th>Количество</th>
        				<th>Стоимость</th>
        			</tr>
        		</thead>
        		<tbody>';
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$package_types = '';
        $msg .= '<tr>';
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$parent_id = $_product->parent_id;
		$product_name_to_cart = $parent_id > 0 ? wc_get_product($parent_id)->get_name() : $_product->get_name();
		$product_name = apply_filters( 'woocommerce_cart_item_name', $product_name_to_cart, $cart_item, $cart_item_key );
		
		$is_single = get_post_meta( $product_id, 'single_prod', true );
		
		$msg .= '<td>'.$_product->get_name().'</td>';
		
		$prodcats = $_product->category_ids;
		foreach ($prodcats as $prodcat) {
			$term_package_type = get_term_meta($prodcat, 'package_type', true);
			if($term_package_type !== ''){
				$package_type[] = $term_package_type;
				$package_types = explode(',', $package_type[0]);
			}
		}
		// if(!empty($cart_item['item_width'])){

			if(isset($_product->attribute_summary)){
				if(gettype($_product->attribute_summary) == 'array'){
					$to_table_name = implode(', ', $_product->attribute_summary);
				} elseif (gettype($_product->attribute_summary) == 'string'){
					$to_table_name = $_product->attribute_summary;
				}
			} 
			if (!empty($to_table_name)){
				$msg .= '<td>'.$to_table_name.'</td>';
			}
		else {
			if(isset($package_type)){
				$msg .= '<td>'.$package_types[0].'</td>';
			}
		}
		if($is_single !== 'yes') {
		    $msg .= '<td>'.$_product->get_price().' &#8381;/м2</td>';
		} else {
		    $msg .= '<td>'.$_product->get_price().'&#8381;</td>';
		}
		if ( $_product->is_sold_individually() ) {
			$min_quantity = 1;
			$max_quantity = 1;
		} else {
			$min_quantity = 0;
			$max_quantity = $_product->get_max_purchase_quantity();
		}
		$msg .= '<td>';
		
		if ($is_single !== 'yes') {
		    $qty_package = get_post_meta( $product_id, '_qty_field_product', true );
		    $qty_package = empty($qty_package) ? 1 : $qty_package;
			$msg .= '<p>'.$package_types[1].': '.floatval($cart_item['quantity'])/floatval($qty_package).'</p>';
		}
		
		if($is_single !== 'yes') { 
			$msg .= '<p>м2: '.$cart_item['quantity'].'</p><p>В упаковке: '.get_post_meta( $product_id, '_qty_field_product', true ).'</p>';
		 } else { 
			$msg .= '<p>'.$package_types[1].': '.$cart_item['quantity'].'</p>';
		 }
		 $msg .= '</td>';
		 
		 $msg .= '<td>'.apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ).'</td>';
		
		$msg .= '</tr>';
    }
        		
        		
    $msg .= '</tbody></table>';
	
	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	if(wp_mail(CFS()->get('site_mail', 23), 'Пользователь оставил заявку на покупку', $msg, array(
		'From: PSM <no@reply.ru>'
	))){
		echo 'ok';
	} else {
		echo 'error';
	}
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
	
	
	wp_die();
}

function get_psm_cart () {
	$items = WC()->cart->get_cart_contents();
        $count = 0;
        foreach($items as $item => $values) {
            $is_cart_prod_single = get_post_meta( $values['product_id'], 'single_prod', true );
            if($is_cart_prod_single === 'yes'){
                $count += $values['quantity'];
            } else {
                $count += 1;
            }
        }
        return $count;
}

function psm_woocommerce_consult_request () {
	if(!wp_verify_nonce( $_POST['nonce'], 'psm_site' )){wp_die();}

	$name = sanitize_text_field( $_POST['name'] );
	$phone = sanitize_text_field( $_POST['phone'] );
	$email = sanitize_text_field( $_POST['email'] );
	$comment = sanitize_text_field( $_POST['comment'] );

//	$headers = [
//		'content-type = text/html; charset=utf-8'
//	];
	$admin_mail = CFS()->get('admin_e_mail', 23);
	$msg = 'Имя: '.$name.'<br>Телефон: '.$phone.'<br>e-mail: '.$email.'<br><br>Комментарий: '.$comment;
	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	if(wp_mail(CFS()->get('site_mail', 23), 'Пользователь оставил заявку на консультацию', $msg, array(
		'From: PSM <no@reply.ru>'
	))){
		echo 'ok';
	} else {
		echo 'error';
	}
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

	wp_die();
}

function set_html_content_type() {
	return 'text/html';
}

function get_product_card ($product){
	$is_single = get_post_meta( $product->get_id(), 'single_prod', true );
			$img_src = CFS()->get('product_heart_no_sel', 23);
			?>

			<div class="product_card data-container" data-prod="<?= $product->get_id() ?>">
				<?php
				
				$pred_request = get_post_meta($product->get_id(), 'pred_request', true);
					if($pred_request != ''){
						$span = '<span class="prod_in_order_pred">'.$pred_request.'</span>';
					} else {
						$span = '<span class="prod_in_order">Предзаказ</span>';
					}
					if($pred_request == ''){
						switch ($product->get_stock_status()) {
							case 'onbackorder': echo $span; break;
							case 'instock': echo '<span class="prod_in_stok">В наличии</span>'; break;
							case 'outofstock': echo '<span class="prod_not_in_stok">Нет в наличии</span>'; break;
						}
					} else {
						echo $span;
					}
				
				?>
				<div style="position:relative; margin-top:55px">
					<img src=<?= $img_src ?> alt="" class="product_sel_heart">
					<a href=<?= get_the_permalink($product->get_id()) ?>>
					<img src=<?= get_the_post_thumbnail_url($product->get_id()) ?> class='product_img'>
					<p class='product_card_product_title'><?= get_the_title( $product->get_id() ) ?></p>
					</a>
				</div>
				<div class="pice_wrapper">
	<?php
		$is_single = get_post_meta( $product->get_id(), 'single_prod', true );
		if($product->is_type('variable')){
			$sale_price = $product->get_variation_sale_price( 'min', true );
			$reg_price = $product->get_variation_regular_price( 'min', true );
			$sale_price = $reg_price <= $sale_price ? '' : $sale_price;
		} else {
			$sale_price = $product->get_sale_price();
			$reg_price = $product->get_regular_price();
		}
		if (isset($sale_price) && $sale_price !== ''){
			echo '<span class="product_price single_prod_sale_price">';
			echo $is_single == 'yes' ? $sale_price.' &#8381;' : 'От '.$sale_price.' &#8381; / м2';
			echo '</span>';
		}
		if (isset($sale_price) && $sale_price !== ''){
			echo '<span class="product_price single_prod_price_saled">';
		} else {
			echo '<span class="product_price">';
		}
		if($reg_price !== '') {
		echo $is_single == 'yes' ? '<span id="prod_price">'.$reg_price.'</span>'. '&#8381;' : 'От <span id="prod_price">'.
		number_format(
			$reg_price,
			0,
			",",
			" "
		)
		.'</span> &#8381; / м2';
		echo '</span>';
		}
	?>
	</div>
	<div class="product_btns_wrapper">
		<a href=<? the_permalink(  ) ?>><div class="product_btn_more">Подробнее</div></a>
		<img src=<?= CFS()->get('product_catalog_compare', 23) ?> alt="Сравнить" class="product_btn_compare">
	</div>
	</div>

	<?php
}

function fractional_amount($args, $product) {
	
	if(!is_cart()) {
		
		$args['input_value'] = 1; // Стартовое значение для карточки товара
	
	}
	
	$args['min_value'] = 0; // Минимальное значение
	$args['step'] = 0.01; // Шаг
	
	return $args;

}


function fractional_amount_ajax($args, $product) {
	
	$args['quantity'] = 0.01; // Минимальное значение
	
	return $args;

}