<?php
/**
 * Template Name: Сравнение
 */
get_header();

if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');

?>

<div class="page_wrapper compare_wrapper">
    <h2 class="header"><?php the_title(); ?></h2>
    <div class="compare_slider_wrapper">
<?php

    get_compare_products();
?>
    </div>
</div>

<?php
get_footer();