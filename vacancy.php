<?php
/**
 * Template Name: Вакансии
 */
get_header();
?>
<div class="page_wrapper vacancy_page_wrapper">
    <?php 
        if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
    ?>
    <h2 class="header vacancy_page_header">
        <?php the_title(); ?>
    </h2>
    <div class="vacancy_page_coontent">
        <h3 class="vacancy_availible">Доступные вакансии</h3>
        <div class="vacancy_cards">
        <?php the_content(  ); ?>
        </div>
    </div>
</div>
<?php
get_footer();
?>