<?php
/**
 * Template Name: Вопросы и ответы
 */
get_header();
?>
<div class="page_wrapper qna_page_wrapper">
    <?php 
        if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
    ?>
    <h2 class="header qna_page_header">
        <?php the_title(); ?>
    </h2>
    <div class="qna_page_coontent">
        <?php the_content(  ); ?>
    </div>
</div>
<?php
get_footer();
?>