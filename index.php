<?php
/**
 * Template Name: Главная
 */

get_header(); ?>


<?php the_content(); ?>
<div class="categories_wrapper section">
    <h3 class='header'>Категории</h3>
    <div class="categories_content">
            <?php $terms = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'pad_counts'=> true,
            'orderby' => 'ID',
            'parent' => 0
        ) );
        // print_r($terms);
        foreach($terms as $term){
            if(!in_array($term->slug, ['misc', 'collections', 'actions_n_sales', 'sales'])){
            $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
            ?>
        <div class="categories_card swiper-slide">
            <a href=<?= get_term_link($term->term_id) ?> class="categories_card_link">
                <div class="categories_card_img" style=<?php echo '"background-image: url('.wp_get_attachment_url( $thumbnail_id ).')"' ?>></div>
                <p class="categories_name"><?= $term->name ?></p>
            </a>
        </div>
        <?php
        }}
        ?>
    </div>
</div>


<div class="advantages_wrapper section">
    <h3 class="header">Преимущества</h3>
    <div class="advantages_content">
        <?php $cards = CFS()->get('main_page_adv_cycle', $post->id);
        foreach($cards as $card){?>
            <div class="advantages_card">
                <img class="advantages_img" src=<?= $card['main_page_adv_img'] ?> alt=""></img>
                <div class="advantages_text_wrapper">
                    <p class="advantages_text_header"><?= $card['main_page_adv_header'] ?></p>
                    <p class="advantages_text"><?= $card['main_page_adv_text'] ?></p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<div class="feedback_wrapper section">
    <div class="feedback_content">
        <p class="feedback_question">Не знаете какое покрытие выбрать?</p>
        <h3 class="feedback_header">Проконсультируйтесь у профессионалов</h3>
        <form action="" class="feedback_form">
            <div class="feedback_input_wrapper">
                <div class="input_wrapper"><input type="text" class="feedback_input" name="name" placeholder="Имя"></div>
                <div class="input_wrapper"><input type="text" class="feedback_input" name="phone" placeholder="Телефон"></div>
                <div class="input_wrapper"><input type="text" class="feedback_input" name="email" placeholder="E-mail"></div>
            </div>
            <div class="input_wrapper"><textarea name="comment" id="comment" placeholder="Комментарий" class="feedback_input"></textarea></div>
            <div class="checkbox_wrapper">
                <input type="checkbox" id="agree" name="agree">
                <label class="checkbox_label" for="agree">Согласен(а) на обработку моих персональных данных</label>
            </div>
            <input type="submit" name="submit" value="Отправить" class="feedback_input_submit" disabled>
        </form>
    </div>
    <div class="cart_cheout_wrapper">
	<div class="cart_cover"></div>
	<div class="cart_cheout">
		<img class="cart_offer_form_img" src="<?= CFS()->get('product_catalog_filter_close',23) ?>" alt="">
		<img class="cart_cheout_img" src="<?= CFS()->get('cart_cheout_ok',23)?>" alt="">
		<p class="cart_cheout_text"><?= CFS()->get('index_request_text', $post->ID)?></p>
	</div>
</div>
</div>

<?php
get_footer();
?>