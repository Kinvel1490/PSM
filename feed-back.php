<?php
/**
 * Template Name: Отзывы
 */

if(isset($_POST['feedback_page_name']) && isset($_POST['feedback_page_raiting'])){

    $recaptcha = $_POST['g-recaptcha-response'];
 
    if(!empty($recaptcha)) {
        $recaptcha = $_REQUEST['g-recaptcha-response'];
        $secret = '6Lc5cwspAAAAAIRAK82GCaG-J3sUmVqn3zeYXBy3';
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret ."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];
    
        //Инициализация и настройка запроса
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        //Выполняем запрос и получается ответ от сервера гугл
        $curlData = curl_exec($curl);
    
        curl_close($curl); 
        //Ответ приходит в виде json строки, декодируем ее
        $curlData = json_decode($curlData, true);
        print_r($curlData);
        //Смотрим на результат
        if($curlData['success']) {
            $commentdata = [
                'comment_post_ID'      => $post->ID,
                'comment_author_email' => null,
                'comment_author_url'   => null,
                'comment_author'       => $_POST['feedback_page_name'],
                'comment_content'      => $_POST['feedback_page_raiting_textarea_value'],
                'comment_meta'         => [
                    'raiting'          => $_POST['feedback_page_raiting']
                ],
            ];
            wp_new_comment( $commentdata, true );
        } else {
            //Капча не пройдена, сообщаем пользователю, все закрываем стираем и так далее
        }
    }
    else {
        //Капча не введена, сообщаем пользователю, все закрываем стираем и так далее
    }

    
}

get_header();
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
?>
    <div class="feedback_page_wrapper">
        <h2 class="header feedback_page_header"><?php the_title(); ?></h2>
        <div class="swiper feedback_page_cards">
            <div class='feedback_page_controls_wrapper'>
                <div class="feedback_page_swiper_prev" style=<?='"background-image: url('.CFS()->get('feed_back_page_swiper_btn', $post->ID).'")'?>></div>
                <div class="feedback_page_swiper_next" style=<?='"background-image: url('.CFS()->get('feed_back_page_swiper_btn', $post->ID).'")'?>></div>
            </div>
            <div class='swiper-wrapper'>
            <?php
                $cs = get_comments( [
                    'post_id'             => $post->ID,
                    'order'               => 'DESC',
                    'status'              => 'approve',
                ] );
                foreach($cs as $c){
                    $raiting = get_comment_meta( $c->comment_ID, 'raiting' )[0];
                    ?>
                    <div class="swiper-slide feedback_page_card">
                        <p class="feedback_page_card_name"><?= $c->comment_author ?></p>
                        <div class="feedback_page_card_raiting">
                            <?php
                                $i = 0;
                                while($i < 5 ){
                                    $i++;
                                    echo $i <= $raiting ? '<span class="feedback_page_card_star" style="background-image: url('.CFS()->get('feed_back_page_star_filled', $post->ID).'")></span>' : '<span class="feedback_page_card_star" style="background-image: url('.CFS()->get('feed_back_page_star_empty', $post->ID).'")></span>';
                                }
                            ?>
                        </div>
                        <p class='feedback_page_card_fbtext'><?= $c->comment_content ?></p>
                    </div>
            <?php
            $i = 0;
                }
            ?>
            </div>
        </div>
        <div class="feedback_page_form_wrapper section">
            <h2 class="header feedback_page_form_header">Оставить отзыв</h2>
            <form action="" method="POST" class="feedback_page_form">
                <div class="feedback_page_form_name_wrapper">
                    <input type="text" class="feedback_page_form_name feedback_page_input" name='feedback_page_name' id='feedback_page_name' placeholder='Имя'>
                </div>
                <p class='feedback_page_rating_header'>Оценка</p>
                <div class="feedback_page_rating_wrapper">
                    <div class="feedback_page_raiting_star_wrapper">
                        <input type="radio" class="feedback_page_raiting" value='1' id='raiting_1' name='feedback_page_raiting'>
                        <label for='raiting_1' class='feedback_page_raiting_label' id='label_raiting_1'></label>
                    </div>
                    <div class="feedback_page_raiting_star_wrapper">
                        <input type="radio" class="feedback_page_raiting" value='2' id='raiting_2' name='feedback_page_raiting'>
                        <label for='raiting_2' class='feedback_page_raiting_label' id='label_raiting_2'></label>
                    </div>
                    <div class="feedback_page_raiting_star_wrapper">
                        <input type="radio" class="feedback_page_raiting" value='3' id='raiting_3' name='feedback_page_raiting'>
                        <label for='raiting_3' class='feedback_page_raiting_label' id='label_raiting_3'></label>
                    </div>
                    <div class="feedback_page_raiting_star_wrapper">
                        <input type="radio" class="feedback_page_raiting" value='4' id='raiting_4' name='feedback_page_raiting'>
                        <label for='raiting_4' class='feedback_page_raiting_label' id='label_raiting_4'></label>
                    </div>
                    <div class="feedback_page_raiting_star_wrapper">
                        <input type="radio" class="feedback_page_raiting" value='5' id='raiting_5' name='feedback_page_raiting'>
                        <label for='raiting_5' class='feedback_page_raiting_label' id='label_raiting_5'></label>
                    </div>
                </div>
                <input type="hidden" name='feedback_page_raiting_textarea_value'>
                <div class="feedback_page_raiting_textarea_wrapper">
                    <textarea id='feedback_page_raiting_textarea_id' class='feedback_page_raiting_textarea' placeholder='Отзыв' data-callback="rcalert"></textarea>
                </div>
                <span class='feedback_page_raiting_textarea_restrictions'>0 из 1000 символов (Минимум 25 символов)</span>
                <div class="g-recaptcha" data-sitekey="6Lc5cwspAAAAANGfOLA3ajvJUua2VmhGFYVz3agp" style="position: relative"></div>
                <input class='feedback_page_form_submit' type="submit" value='Сохранить'>
            </form>
        </div>
    </div>
<?php
get_footer();
?>