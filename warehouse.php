<?php
/**
 * Template Name: Остатки на складе
 */
get_header();
?>
<div class="page_wrapper warehouse_page_wrapper">
    <?php 
        if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
    ?>
    <div class="warehouse_page_coontent">
        <?php the_content(  ); ?>
    </div>
</div>
<?php
get_footer();
?>