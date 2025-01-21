<?php
get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');?>

<div class="actions_n_sales_wrapper page_wrapper">
<?php
$args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'product_cat' => 'sales',
];
$sales_query = new WP_Query($args);
global $product;
while ( $sales_query->have_posts() ) {
	$sales_query->the_post();
    foreach($product->category_ids as $cat_id){
        if(!in_array($cat_id, [64,65,63])){
            $test_term = get_term($cat_id);
            if(!in_array($test_term->parent,[64,65,63])){
                if(!isset($terms_to_print)) {
                    $terms_to_print[] = $test_term->term_id;
                }
                if(!in_array($test_term->term_id, $terms_to_print))
                $terms_to_print[] = $test_term->term_id;
            }
        }
    }
}

wp_reset_postdata();
?>
    
    <h2 class="header actions_n_sales_header"><?= get_queried_object(  )->name ?></h2>
    <p class="actions_n_sales_subheader">Категории распродаж</p>
    <div class="actions_n_sales_cats_wrapper">
        <?php 
        if($terms_to_print != null){
            foreach($terms_to_print as $term_to_print){
                $thumbnail_id = get_woocommerce_term_meta( $term_to_print, 'thumbnail_id', true );
                ?>
                <div class="actions_n_sales_cats_card">
                    <a href="<?= get_term_link($term_to_print).'/?sales=1' ?>">
                        <img src=<?= wp_get_attachment_url($thumbnail_id) ?> class='product_img'>
                        <p class="actions_n_sales_cats_card_text"><?= get_term($term_to_print)->name ?></p>
                    </a>
                </div>
        <?php
            }}
        ?>
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
?>