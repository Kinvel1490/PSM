<?php
/**
 * Template Name: Фотогалерея
 */
get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
?>
<div class="photo_galery_wrapper">
    <div class="photo_galery_content">
        <h2 class="header photo_galery_header"><?php the_title(); ?></h2>
        <?php the_content(); ?>
    </div>
</div>
<div class="galery_swiper_full_screen_wrapper">
	    <div class="galery_swiper_cover"></div>
	    <img class="close_galery_swiper_overlay" src="<?= CFS()->get('burger_close_img', 23) ?>" alt="">
	    <div class="galery_swiper_full_screen_overlay">
    	    <div class="galery_swiper_full_screen">
    		<div class="galery_swiper_full_screen_prev disabled" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
            <div class="galery_swiper_full_screen_next" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
    		<div class="galery_swiper_wrapper">
    		    <img class="galery_swiper_slide_img" src="" alt="">
    		</div>
		</div>
    </div>
</div>
<?php

get_footer();
?>