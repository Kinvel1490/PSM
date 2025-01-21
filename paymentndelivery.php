<?php
/**
 * Template Name: Оплата и доставка
 */
get_header();
?>
<div class="page_wrapper pnd_page_wrapper">
    <?php 
        if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
    ?>
    <h2 class="header pnd_page_header">
        <?php the_title(); ?>
    </h2>
    <div class="pnd_page_coontent">
        <?php the_content(  ); ?>
    </div>
</div>
<?php
get_footer();
?>