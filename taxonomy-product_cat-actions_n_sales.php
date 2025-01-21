<?php
get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
?>
<div class="actions_n_sales_wrapper page_wrapper">
<?php
$terms = get_terms(array(
    'taxonomy' => 'product_cat',
    'parent' => intval(get_queried_object_id(  )),
) );
?>

    <h2 class="header actions_n_sales_header"><?= get_queried_object(  )->name ?></h2>
    <div class="actions_n_sales_swiper swiper">
        <div class="actions_n_sales_swiper_controls_wrapper">
            <div class="actions_n_sales_swiper_prev" style="background-image:url(<?= CFS()->get('prod_cats_swiper_btn_icon', 23) ?>)"></div>
            <div class="actions_n_sales_swiper_next" style="background-image:url(<?= CFS()->get('prod_cats_swiper_btn_icon', 23) ?>)"></div>
        </div>
        <div class="actions_n_sales_swiper_wrapper swiper-wrapper">
            <?php
                foreach($terms as $term){
            ?>
            <div class="actions_n_sales_swiper_slide swiper-slide">
                    <div class="actions_n_sales_card_wrapper">
                        <?php
                        $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                        ?>
                        <div class="actions_n_sales_card_img_wrapper">
                            <a href="<?= get_term_link( $term->term_id ) ?>">
                                <img src="<?= wp_get_attachment_url( $thumbnail_id ) ?>" alt="" class="actions_n_sales_card_img">
                            </a>
                            <div class="actions_n_sales_cover_wrapper">
                            <div class="actions_n_sales_cover"></div>
                                <a href="<?= get_term_link( $term->term_id ) ?>" class="actions_n_sales_link">Перейти в раздел</a>
                            </div>
                        </div>
                        <a href="<?= get_term_link( $term->term_id ) ?>">
                            <p class="actions_n_sales_name"><?= $term->name ?></p>
                        </a>
                    </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="actions_n_sales_products_wrapper section">
        <h2 class="header actions_n_sales_header">Акционные товары</h2>
        <div class="product_cards_wrapper actions_n_sales_product_cards_wrapper">
        <?php
if ( woocommerce_product_loop() ) {
    // do_action( 'woocommerce_before_shop_loop' );

    if ( wc_get_loop_prop( 'total' ) ) {
        while ( have_posts() ) {
            the_post();

            do_action( 'woocommerce_shop_loop' );
            global $product;
            get_product_card($product); 
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
        ?>
    </div>
    </div>
</div>

<?php
get_footer();