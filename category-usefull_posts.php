<?php
get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');

?>
    <div class="news_content">
        <h1 class="news_header header">Новости</h1>
        <div class="news_cards">
            <?php
                while(have_posts(  )) : the_post();
                ?>
                <div class="news_card">
                    <a class="news_post_link" href="<?= get_the_permalink(  ) ?>">
                        <img class="news_post_thumb" src="<?= get_the_post_thumbnail_url() ?>">
                        <p class="news_post_excerpt"><?= get_the_excerpt() ?></p> 
                    </a>
                </div>
                <?php
                endwhile;
            ?>
        </div>
        <?php wp_pagenavi(); ?>
    </div>    
<?php
get_footer();
?>

