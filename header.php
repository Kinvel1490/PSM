<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head lang="ru">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php
	if(is_page()){
        $page_title = CFS()->get('seo_title', $post->ID);
        $page_descr = CFS()->get('seo_descr', $post->ID);
        $page_kw = CFS()->get('seo_keywords', $post->ID);
        if ($page_title != ''){
            echo '<title>'.$page_title.'</title>';
        } else { 
            echo '<title>ПСМ</title>';
        }
        if ($page_descr != ''){
            echo '<meta name="description" content="'.$page_descr.'">';
        }
        if ($page_kw != ''){
            echo '<meta name="keywords" content="'.$page_kw.'">';
        }
	}
	if(is_tax('product_cat')){
    	$page_descr = get_term_meta(get_queried_object_id(), 'cats_descr', true);
    	$page_title = get_term_meta(get_queried_object_id(), 'cats_title', true);
    	$page_kw = get_term_meta(get_queried_object_id(), 'cats_kw', true);
        if ($page_title != ''){
            echo '<title>'.$page_title.'</title>';
        } else { 
            echo '<title>ПСМ</title>';
        }
        if ($page_descr != ''){
            echo '<meta name="description" content="'.$page_descr.'">';
        }
        if ($page_kw != ''){
            echo '<meta name="keywords" content="'.$page_kw.'">';
        }
	}
	if (is_product()){
        $p = get_product(get_queried_object_id());
        echo '<title>'.$p->name.'</title>';
        
        $single_prod_attrs = array_filter($p->get_attributes(), 'wc_attributes_array_filter_visible');
        $attributes_singles = $single_prod_attrs;



		$attributes_keys = array_keys($single_prod_attrs);

	    foreach ($attributes_keys as $index=>$attribute_key) {
		    if (substr($attribute_key, 0, 3) !== 'pa_') {
			    unset($attributes_keys[$index]);
		    }
	    }

	    if (!empty($attributes_keys)) {
		    $attributes_name = implode(',|', $attributes_keys);
		    $attributes_name = $attributes_name.',';
	    } else {
		    $attributes_name = '';
	    }

        if (!empty($attributes_name)) {
            //TODO: refactor to method
	        $query = $wpdb->prepare("SELECT term_id, children FROM $wpdb->term_taxonomy WHERE taxonomy = %s AND children rlike %s", array('wugrat_group', $attributes_name));
	        $attribute_groups = $wpdb->get_results($query);

	        $option_group_order = explode(',', get_option('wugrat_group_order'), -1);
        } else {
	        $attribute_groups = '';
        }

        // Organize groups and get attributes
        if (!empty($attribute_groups)) {
            foreach ($attribute_groups as $attribute_group) {
                $groupifier = rand(0, 9999);
                $attribute_group_term = get_term($attribute_group->term_id);

                $product_attribute_group = array();
                $child_attribute_names = explode(',', $attribute_group->children);
                foreach ($child_attribute_names as $child_attribute_name) {
                    if (array_key_exists($child_attribute_name, $single_prod_attrs)) {
                        $product_attribute_group[$child_attribute_name] = $single_prod_attrs[$child_attribute_name];
                        unset($attributes_singles[$child_attribute_name]);
                    }
                }

                foreach ($product_attribute_group as $attribute) {
                    $values = array();

                    if ($attribute->is_taxonomy()) {
                        $attribute_taxonomy = $attribute->get_taxonomy_object();
                        $attribute_values = wc_get_product_terms($p->get_id(), $attribute->get_name(), array('fields' => 'all'));

                        foreach ($attribute_values as $attribute_value) {
                            $value_name = esc_html($attribute_value->name);

                            if ($attribute_taxonomy->attribute_public) {
                                $values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
                            } else {
                                $values[] = $value_name;
                            }
                        }
                    } else {
                        $values = $attribute->get_options();

                        foreach ($values as &$value) {
                            $value = make_clickable(esc_html($value));
                        }
                    }
                    $product_attributes[] = array(
                        'label' => wc_attribute_label($attribute->get_name()),
                        'value' => apply_filters('woocommerce_attribute', wptexturize(implode(', ', $values)), $attribute, $values),
                        // 'value' => implode(', ', $values);
                    );
                }
            }
        }

        foreach($product_attributes as $key=>$product_attribute){
            $descr[] = $product_attribute['label'].': '.$product_attribute['value'];
        }
    	$descr = implode(', ', $descr);
    	if(!empty($descr)){
    	    echo '<meta name="description" content="'.$p->name.', '.$descr.'">';
    	}
	}
	if(is_single() && !is_product()){
	    $page_title = get_the_title($post->ID);
        $page_descr = CFS()->get('seo_single_descr', $post->ID);
        $page_kw = CFS()->get('seo_single_kw', $post->ID);
        if ($page_title != ''){
            echo '<title>'.$page_title.'</title>';
        } else { 
            echo '<title>ПСМ</title>';
        }
        if ($page_descr != ''){
            echo '<meta name="description" content="'.$page_descr.'">';
        }
        if ($page_kw != ''){
            echo '<meta name="keywords" content="'.$page_kw.'">';
        }
	}
	?>
	<?php wp_head(); ?>
</head>

<body>
<header class="<?= is_page_template('index.php')?'header_wrapper asb_header' : 'header_wrapper' ?>">
		<div class="header_content">
            <div class="header_content_inner">
                <div class="header_logo_wrapper">
                    <!-- <img src='./assets/images/logo_tdpsm.svg' alt='' class="header_logo"> -->
                    <div class="header_logo"><?php the_custom_logo(  ) ?></div>
                    <div class="header_logo_txt">
                        <h3>ПСМ</h3>
                        <p>Полимерстройматериалы</p>
                    </div>
                </div>
                <div class="header_center_wrapper">
                    <div class="header_firstline">
                        <div class="header_work_time">
                            <p class="header_work_time_title"><?= CFS()->get('work_reg', 23) ?></p>
                            <p class="header_work_time_werehouse"><?= CFS()->get('work_reg_1', 23) ?></p>
                            <p class="header_work_time_office"><?= CFS()->get('work_reg_2', 23) ?></p>
                        </div>
                        <div class="header_phone_numbers_wrapper">
                            <?php
                                $phones = CFS()->get('phone_numbers', 23);
                                if ($phones !== null){
                                foreach($phones as $phone) {
                            ?>
                            <a href=<?= '"tel:'.$phone['phone_number_link']?>" class="header_phone_number"><?= $phone['phone_number'] ?></a>
                            <?php }} ?>
                        </div>
                        <div class="header_search_n_socials">
                            <div class="header_search_n_socials_socials_wrapper">
                                <div class="header_search_n_socials_socials_img_wrapper">
                                    <?php 
                                        $socials = CFS()->get('socials', 23);
                                        if($socials !== null) {
                                        foreach($socials as $social) {
                                    ?>
                                    <a href="<?= $social['socials_link']['url'] ?>" target="<?= $social['socials_link']['target'] ?>" class="header_search_n_socials_socials_link"><img src="<?= $social['socials_img'] ?>" alt="<?= $social['socials_alt'] ?>" class="header_search_n_socials_socials"></a>

                                    <?php }} ?>
                                </div>
                                <div class="header_search_n_socials_socials_form_wrapper">
                                    <!-- <form action="" class="header_search_n_socials_form">
                                        <input type="text" placeholder="Поиск" class="header_search_n_socials_form_input">
                                    </form>
                                    <img src=<?= CFS()->get('search_img_dark', 23) ?> alt="" class="header_search_n_socials_form_img"> -->
                                    <?php echo do_shortcode( '[ivory-search id="422" title="AJAX Search Form for WooCommerce"]') ?>
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div class="header_menu_wrapper">
                        <div class='header_menu'>
                        <?php echo do_shortcode( '[ivory-search id="422" title="AJAX Search Form for WooCommerce"]') ?>
                        <?php
                            wp_nav_menu( [
                                'theme_location'  => 'main_menu',
                                'container'       => false,
                                'container_class' => '',
                                'menu_class'      => 'header_menu_list',
                                'menu_id'         => '',
                                'echo'            => true,
                                'fallback_cb'     => 'wp_page_menu',
                                'link_before'     => '',
                                'link_after'      => '',
                                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                'depth'           => 0,
                            ] );
                        ?>
                        
                            <div class="header_menu_footer_wrapper">
                                <div class="header_menu_footer_phones_wrapper">
                                    <p class="header_phone_number_header">Телефон</p>
                                    <div class="header_phone_number_wrapper">
                                        <?php
                                            $phones = CFS()->get('phone_numbers', 23);
                                            if ($phones !== null){
                                            foreach($phones as $phone) {
                                        ?>
                                        <a href=<?= '"tel:'.$phone['phone_number_link']?>" class="header_phone_number"><?= $phone['phone_number'] ?></a>
                                        <?php }} ?>
                                    </div>
                                </div>
                                <div class="header_menu_footer_work_wrapper">
                                    <p class="header_work_time_title"><?= CFS()->get('work_reg', 23) ?></p>
                                    <p class="header_work_time_werehouse"><?= CFS()->get('work_reg_1', 23) ?></p>
                                    <p class="header_work_time_office"><?= CFS()->get('work_reg_2', 23) ?></p>
                                </div>
                                <div class="header_menu_footer_socials_wrapper">
                                <?php 
                                        $socials = CFS()->get('socials', 23);
                                        if($socials !== null) {
                                        foreach($socials as $social) {
                                    ?>
                                    <a href="<?= $social['socials_link']['url'] ?>" target="<?= $social['socials_link']['target'] ?>" class="header_search_n_socials_socials_link"><img src="<?= $social['socials_img'] ?>" alt="<?= $social['socials_alt'] ?>"
                                     class="header_search_n_socials_socials"></a>

                                    <?php }} ?>
                                </div>
                            </div>
                        </div>
                        <div class="header_menu_cart_wrapper">
                            <div class="header_menu_cart_search_wrapper">
                                <img src=<?= CFS()->get('search_img', 23) ?> alt="Сранить" class="header_menu_cart_item" id="header_menu_cart_item_search">
                                <?php echo do_shortcode( '[ivory-search id="422" title="AJAX Search Form for WooCommerce"]') ?>
                            </div>
                            <a href=<?= get_page_link( 416 ) ?> class="header_menu_cart_item_link" id="compare_link">
                            <?php
                                    if(isset($_COOKIE['compare']) && $_COOKIE['compare'] !== ''){
                                        $f = explode(',', $_COOKIE['compare']);
                                        if(count($f) > 0){?>
                                            <span class="header_count" id="compare"><?= count($f) ?></span>
                                        <?php
                                        }
                                    }
                                ?>
                                <img src=<?= CFS()->get('compare_img', 23) ?> alt="Сранить" class="header_menu_cart_item">
                            </a> 
                            <a href=<?= get_page_link( 412 ) ?> class="header_menu_cart_item_link" id='favorite_link'>
                                <?php
                                    if(isset($_COOKIE['favorite']) && $_COOKIE['favorite'] !== ''){
                                        $f = explode(',', $_COOKIE['favorite']);
                                        if(count($f) > 0){?>
                                            <span class="header_count" id="favorite"><?= count($f) ?></span>
                                        <?php
                                        }
                                    }
                                ?>
                                <img src=<?= CFS()->get('favorite_img', 23) ?> alt="Избранное" class="header_menu_cart_item">
                            </a>
                            <?php $cart = get_psm_cart()?>
                            <a href=<?= wc_get_cart_url() ?> class="header_menu_cart_item_link" id="cart_count_link">
                                <img src=<?= CFS()->get('cart_img', 23) ?> alt="Корзина" class="header_menu_cart_item">
                                <?= $cart > 0 ? '<span class="header_count" id="cart_count">'.$cart.'</span>' : '' ?>
                            </a>
                            <img src=<?= CFS()->get('burger_img', 23) ?> alt="Сранить" id="header_menu_cart_item_burger">
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</header>