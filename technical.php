<?php
/**
 * Template Name: Техническая информация
 */
get_header();
?>
<div class="page_wrapper tech_page_wrapper">
    <?php 
        if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
    ?>
    <h2 class="header tech_page_header">
        <?php the_title(); ?>
    </h2>
    <div class="tech_page_coontent">
        <?php the_content(  ); ?>
    </div>
</div>
<?php
get_footer();
?>