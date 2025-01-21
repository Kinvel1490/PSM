<?php
/**
 * Template Name: Избранное
 */
if(isset($_COOKIE['favorite']) && $_COOKIE['favorite'] !== ''){
    $f = explode(',', $_COOKIE['favorite']);
} else { $f = []; }
get_header();
if(count($f) > 0){
$args = [
    'post_type' => 'product',
    'post__in' => $f,
    'posts_per_page' => -1,
];
$Q = new WP_Query($args);}
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');

?>

<div class="page_wrapper page_favorite_wrapper">
    <h2 class="header"><?php the_title(); ?></h2>
<?php
if (!isset($Q)){echo '<h2 class="has-large-font-size">Вы пока ничего не добавили в избранное</h2>';} else {
if( $Q->have_posts() ) : ?>
    <div class="favorite_wrapper">
<?php
 
	// затем запускаем цикл
	while( $Q->have_posts() ) : $Q->the_post();
        global $post;
        get_product_card($product);

	endwhile; ?>
</div>
<?php
endif;}
?>
</div>
<?php
get_footer();