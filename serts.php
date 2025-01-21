<?php
/**
 * Template Name: Сертификаты
 */
get_header();
?>
<div class="page_wrapper serts_page_wrapper">
    <?php 
        if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
    ?>
    <h2 class="header serts_page_header">
        <?php the_title(); ?>
    </h2>
    <div class="serts_page_coontent">
        <?php the_content(  ); ?>
    </div>
</div>
<?php
get_footer();
?>