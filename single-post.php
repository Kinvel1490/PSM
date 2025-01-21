<?php
get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
?>
    <div class="post_content_wrapper">
        <h3 class="header post_header">
            <?php the_title(); ?>
        </h3>
        <?php
        the_content()
        ?>
    </div>
<?php
get_footer();
?>