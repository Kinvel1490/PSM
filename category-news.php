<?php
get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');

?>
    <div class="news_content">
        <h1 class="news_header header"><?= get_queried_object()->name ?></h1>
        <div class="news_cards">
            <?php
                while(have_posts(  )) : the_post();
                $links = CFS()->get('news_post_links_cycle', $post->ID);
                ?>
                <div class="news_card">
                    <a class="news_post_link" href="<?= get_the_permalink(  ) ?>">
                        <img class="news_post_thumb" src="<?= get_the_post_thumbnail_url() ?>">
                        <p class="news_post_excerpt"><?= get_the_excerpt() ?></p> 
                    </a>
                    <?php if(!empty($links) && count($links)>0){ ?>
                    <div class="news_post_links_wrapper">
                        <?php foreach($links as $link){ ?>
                            <a href="<?= $link['news_post_links']['url'] ?>" target="<?= $link['news_post_links']['target'] ?>" rel="noopener nofollow"><?= $link['news_post_links']['text'] ?></a>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <p class="news_post_date"><?= get_the_date('d.m.Y', $post->ID) ?></p>
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

