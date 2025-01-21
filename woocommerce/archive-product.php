<?php
/**
 * Template Name: Каталог
 */
get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
$queried_id = get_queried_object_id();
$quereid_obj = get_queried_object(  );
?>

<div class="content_cover"></div>
<?php
if(!in_array($quereid_obj->parent, [0,64,65]) ){
 $content_wrapper_style = '"grid-template-columns: 1fr"';
} else { $content_wrapper_style = '';}
?>
<div class="page_wrapper content_wrapper" style=<?= $content_wrapper_style; ?>>

    <?php    
    if($quereid_obj->parent === 0|| $quereid_obj->parent === 64 ||$quereid_obj->parent === 65){ ?>
    <div class="content_filter">
        <div class="content_filter_header">
            <p class="has-large-font-size"><strong><?= CFS()->get('product_catalog_filter_text', 23) ?></strong></p>
            <img src=<?= CFS()->get('product_catalog_filter_close', 23) ?> alt="">
        </div>
        <div class="content_filter_options">
            <div class="content_filter_option">
                    <?php
                        if($quereid_obj->parent > 0){
                            $link = get_term_link( $quereid_obj->parent );
                        } 
                        if ($queried_id === 63){
                            $link = get_term_link( $queried_id ).'/?collections=1';
                        }
                        else {
                            $link = get_term_link( $queried_id );
                        }
                    ?>
                    <a href=<?= $link ?>><span class=<?= isset($_GET['collections']) && $_GET['collections'] == 1 || $queried_id !==63 ? '"active_tab type_view_prod"' : '"type_view_prod"' ?>>Товары</span></a>
                    <a href=<?= get_term_link( 63 ) ?>><span class=<?= $queried_id === 63 && !isset($_GET['collections'])? '"active_tab type_view_coll"' : '"type_view_coll"' ?>>Коллекции</span></a>
            </div>
            <div class="product_attributes">
            <?php
             echo do_shortcode('[wpf-filters id=1]');
            ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="main_product_content_wrapper">
        
        <?php
        if($quereid_obj->parent > 0){
            $name = 'Коллекция '.$quereid_obj->name;
        } else {
            if($queried_id === 63 && !isset($_GET['collections'])){
                $name = "Популярные коллекции";
            } elseif ($queried_id === 63 && isset($_GET['collections'])) {
                $name = "Товары";
            } else {
            $name = $quereid_obj->name;
            }
        }?>
        <div class="main_product_content_header_wrapper">
            <h2 class="header"><?= $name ?></h2>
            <?php if($quereid_obj->parent === 0|| $quereid_obj->parent === 64 ||$quereid_obj->parent === 65){?>
            <div class="main_product_content_header_btn">
                <img src=<?= CFS()->get('product_catalog_filter', 23); ?> alt="" class="main_product_content_header_btn_img">
                <span class="main_product_content_header_btn_text"><?= CFS()->get('product_catalog_filter_text', 23) ?></span>
            </div>
            <?php } ?>
        </div>
        <?php
        if($quereid_obj->parent > 0 || $quereid_obj->parent !== 64 ||$quereid_obj->parent !== 65){
            $thumbnail1_id = get_term_meta($queried_id, 'thumbnail1_id', true ) ;
            $thumbnail2_id = get_term_meta($queried_id, 'thumbnail2_id', true ) ;
            $thumbnail3_id = get_term_meta($queried_id, 'thumbnail3_id', true ) ;
            $thumbnail4_id = get_term_meta($queried_id, 'thumbnail4_id', true ) ;
            $thumbnail5_id = get_term_meta($queried_id, 'thumbnail5_id', true ) ;
            $thumbnail6_id = get_term_meta($queried_id, 'thumbnail6_id', true ) ;
            if($thumbnail1_id>0 || $thumbnail2_id>0 || $thumbnail3_id>0 || $thumbnail4_id>0 || $thumbnail5_id>0 || $thumbnail6_id>0 ){?>
            <div class="product_cat_swipers_n_chars_wrapper">
                <div class="product_cat_swipers_wrapper">
                    <div class="swiper product_collection_swiper">
                        <div class="product_cats_swiper_prev" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).'")'?>></div>
                        <div class="product_cats_swiper_next" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).'")'?>></div>
                        <div class="swiper-wrapper">
                            <?php echo $thumbnail1_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail1_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail2_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail2_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail3_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail3_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail4_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail4_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail5_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail5_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail6_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail6_id).'" alt=""></div>' : ''; ?>
                        </div>
                    </div>
                    <div class="swiper product_collection_swiper_controller">
                        <div class="product_cats_swiper_prev" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).'")'?>></div>
                        <div class="product_cats_swiper_next" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).'")'?>></div>
                        <div class="swiper-wrapper">
                            <?php echo $thumbnail1_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail1_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail2_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail2_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail3_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail3_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail4_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail4_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail5_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail5_id).'" alt=""></div>' : ''; ?>
                            <?php echo $thumbnail6_id > 0 ? '<div class="swiper-slide"><img src="'.wp_get_attachment_url($thumbnail6_id).'" alt=""></div>' : ''; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
             } }
        ?>
    <div class="product_cards_wrapper">
        <?php
            if($queried_id === 63 && !isset($_GET['collections'])){
                $args = array(
                    'parent' => $queried_id,
                    'posts_per_page' => -1
                );
                $terms = get_terms( 'product_cat', $args );
                if ( $terms ) {
                        foreach ( $terms as $term ) {
                            echo '<div class="sub_category_card"><a href="' .  esc_url( get_term_link( $term ) ) . '">';
                                    // woocommerce_subcategory_thumbnail( $term );
                                    $img = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                                    $attach = $img > 0  ? wp_get_attachment_url($img) : wc_placeholder_img_src();
                                    echo '<img src="'.$attach.'" alt="">';
                                    echo '<p>';
                                        echo $term->name;
                                    echo '</p></a>';
                                echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . ' sub_category_card_link">Перейти в раздел</a>';
                            echo '</div>';
                    }
                    echo '</div>';
                }
            }
            elseif(isset($_GET['collections']) && $_GET['collections'] == 1){

            $terms = get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'pad_counts'=> true,
                'orderby' => 'ID',
                'parent' => 0
            ) );
            // print_r($terms);
            foreach($terms as $term){
                if(!in_array($term->slug, ['misc', 'collections', 'actions_n_sales', 'sales'])){
                    echo '<div class="sub_category_card"><a href="' .  esc_url( get_term_link( $term ) ) . '">';					
                            woocommerce_subcategory_thumbnail( $term );
                            echo '<p>';
                                echo $term->name;
                            echo '</p></a>';
                        echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . ' sub_category_card_link">Перейти в раздел</a>';
                    echo '</div>';
            }}
            echo '</div>';
            }
            elseif (isset($_GET['sales']) && $_GET['sales'] == 1 ){
                $args = [
                    'post_type' => 'product',
                    'posts_per_page' => 9,
                    'paged' => get_query_var('paged') ?: 1,
                    'tax_query' => [
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
                    ]
                ];
                $sales_query = new WP_Query($args);
                global $post;
                while ( $sales_query->have_posts() ) {
                    $sales_query->the_post();
                    $prod = wc_get_product($post->ID);
                    get_product_card ($prod);
                }
            }
            else {
        if ( woocommerce_product_loop() ) {
            // do_action( 'woocommerce_before_shop_loop' );

            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();
                    do_action( 'woocommerce_shop_loop' );
                    global $product;
                    get_product_card ($product);
                    ?>
                <?php    
                }
            }
        
            woocommerce_product_loop_end();
        ?>
            
        </div>

        <?php
            do_action( 'woocommerce_after_shop_loop' );
        } else {
            do_action( 'woocommerce_no_products_found' );
        }
        
    }?> 	
</div>
<?php if(isset($_GET['sales']) && $_GET['sales'] == 1 ) {
    wp_pagenavi();
    wp_reset_postdata(  );
}
?>
</div>
</div>

<div class="page_wrapper content_wrapper_text">
    <?php
        $term_id = $queried_id;

        $productCatMetaTitle1 = get_term_meta($term_id, 'wh_meta_title1', true);
        $productCatMetaTitle2 = get_term_meta($term_id, 'wh_meta_title2', true);
        $productCatMetaTitle3 = get_term_meta($term_id, 'wh_meta_title3', true);
        $productCatMetaTitle4 = get_term_meta($term_id, 'wh_meta_title4', true);
        $productCatMetaTitle5 = get_term_meta($term_id, 'wh_meta_title5', true);

        $productCatMetaDesc1 = get_term_meta($term_id, 'wh_meta_desc1', true);
        $productCatMetaDesc2 = get_term_meta($term_id, 'wh_meta_desc2', true);
        $productCatMetaDesc3 = get_term_meta($term_id, 'wh_meta_desc3', true);
        $productCatMetaDesc4 = get_term_meta($term_id, 'wh_meta_desc4', true);
        $productCatMetaDesc5 = get_term_meta($term_id, 'wh_meta_desc5', true);

        if($productCatMetaTitle1 !== '') {
            echo '<h2 class="header content_text_header">'.$productCatMetaTitle1.'</h2>';
        }
        if ($productCatMetaDesc1 !== '') {
            echo '<div class="content_text_text">'.$productCatMetaDesc1.'</div>';
        }
        if($productCatMetaTitle2 !== '') {
            echo '<h2 class="header content_text_header">'.$productCatMetaTitle2.'</h2>';
        }
        if ($productCatMetaDesc2 !== '') {
            echo '<div class="content_text_text">'.$productCatMetaDesc2.'</div>';
        }
        if($productCatMetaTitle3 !== '') {
            echo '<h2 class="header content_text_header">'.$productCatMetaTitle3.'</h2>';
        }
        if ($productCatMetaDesc3 !== '') {
            echo '<div class="content_text_text">'.$productCatMetaDesc3.'</div>';
        }
        if($productCatMetaTitle4 !== '') {
            echo '<h2 class="header content_text_header">'.$productCatMetaTitle4.'</h2>';
        }
        if ($productCatMetaDesc4 !== '') {
            echo '<div class="content_text_text">'.$productCatMetaDesc4.'</div>';
        }
        if($productCatMetaTitle5 !== '') {
            echo '<h2 class="header content_text_header">'.$productCatMetaTitle5.'</h2>';
        }
        if ($productCatMetaDesc5 !== '') {
            echo '<div class="content_text_text">'.$productCatMetaDesc5.'</div>';
        }
    ?>
</div>
<?php
get_footer();
?>