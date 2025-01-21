<?php
/**
 * Template Name: История
 */
get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');

?>
<div class="history_content_wrapper">
    <div class="history_content">
            <h2 class="header history_content_header"><?php the_title(); ?></h2>
            <?php the_content();
        ?>
    </div>
</div>
<?php
get_footer();
?>