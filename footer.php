	

<footer class="footer section">
        <div class="footer_content_wrapper">
            <div class="footer_first_line">
                <div class="footer_logo_wrapper">
                    <?php the_custom_logo(  ) ?>
                    <div class="footer_text_wrapper">
                        <h3>ПСМ</h3>
                        <p>Полимерстройматериалы</p>
                    </div>
                </div>
                <div class="footer_adress_wrapper">
                    <div class="footer_adress">
                        <img class='footer_adress_img' src=<?= CFS()->get('footer_adress_icon', 23) ?> alt="">
                        <p class="footer_adress_text"><?= CFS()->get('footer_adress', 23) ?></p>
                    </div>
                    <div class="footer_adress_work">
                        <img src="<?= CFS()->get('footer_work_icon', 23) ?>" alt="" class="footer_adress_work_img">
                        <p class="footer_adress_text"><?= CFS()->get('footer_work', 23) ?></p>
                    </div>
                </div>
                <div class="footer_phone_wrapper">
                    <img src="<?= CFS()->get('footer_phone_icon', 23) ?>" alt="" class="foter_phone_img">
                    <div class="footer_numbers">
                        <?php
                            $phones = CFS()->get('phone_numbers', 23);
                            if ($phones !== null){
                            foreach($phones as $phone) {
                        ?>
                        <a href=<?= '"tel:'.$phone['phone_number_link'].'"'?> class="footer_number"><?= $phone['phone_number'] ?></a>
                        <?php }} ?>
                    </div>
                </div>
                <div class="footer_mail_n_socials_wrapper">
                    <div class="footer_mail_wrapper">
                        <img src="<?= CFS()->get('footer_mail_icon', 23) ?>" alt="" class="footer_mail_img">
                        <a href="mailto:<?= CFS()->get('footer_e_mail', 23) ?>" class="footer_mail"><?= CFS()->get('footer_e_mail', 23) ?></a>
                    </div>
                    <div class="footer_socials_wrapper">
                        <?php 
                            $socials = CFS()->get('socials', 23);
                            if($socials !== null) {
                            foreach($socials as $social) {
                        ?>
                        <a href="<?= $social['socials_link']['url'] ?>" target="<?= $social['socials_link']['target'] ?>" class="footer_socialls_link"><img src="<?= $social['socials_img'] ?>" alt="<?= $social['socials_alt'] ?>"
                            class="footer_socialls_img"></a>
                        <?php }} ?>
                    </div>
                </div>
            </div>
            <div class="footer_menu_wrapper">
            <?php
                wp_nav_menu( [
                    'theme_location'  => 'main_menu',
                    'container'       => 'div',
                    'container_class' => 'header_menu',
                    'menu_class'      => 'header_menu_list',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'           => 0,
                ] );
            ?>
            </div>
            <div class="footer_privacy_wrapper">
                <a href="<?php echo get_page_link( 3 ) ?>" class="footer_privacy_policy_link"><p class="footer_privacy_policy">Политика конфиденциальности</p></a>
                <div class="footer_rights">Все права защищены 2001-<?= date('Y') ?></div>
            </div>
        </div>
    </footer>
    <?php wp_footer() ?>
</body>
</html>