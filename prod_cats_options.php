<?php
add_action('product_cat_add_form_fields', 'wh_taxonomy_add_new_meta_field', 10, 1);
add_action('product_cat_edit_form_fields', 'wh_taxonomy_edit_meta_field', 10, 1);
//Product Cat Create page
function wh_taxonomy_add_new_meta_field() {
    ?>
    <div class="form-field">
        <label for="wh_meta_title1">Заголовок 1</label>
        <input type="text" name="wh_meta_title1" id="wh_meta_title1">
    </div>
    <div class="form-field">
        <label for="wh_meta_desc1">Описание 1</label>
        <textarea name="wh_meta_desc1" id="wh_meta_desc1"></textarea>
    </div>
	<div class="form-field">
        <label for="wh_meta_title2">Заголовок 2</label>
        <input type="text" name="wh_meta_title2" id="wh_meta_title2">
    </div>
    <div class="form-field">
        <label for="wh_meta_desc2">Описание 2</label>
        <textarea name="wh_meta_desc2" id="wh_meta_desc2"></textarea>
    </div>
	<div class="form-field">
        <label for="wh_meta_title3">Заголовок 3</label>
        <input type="text" name="wh_meta_title3" id="wh_meta_title3">
    </div>
    <div class="form-field">
        <label for="wh_meta_desc3">Описание 3</label>
        <textarea name="wh_meta_desc3" id="wh_meta_desc3"></textarea>
    </div>
	<div class="form-field">
        <label for="wh_meta_title4">Заголовок 4</label>
        <input type="text" name="wh_meta_title4" id="wh_meta_title4">
    </div>
    <div class="form-field">
        <label for="wh_meta_desc4">Описание 4</label>
        <textarea name="wh_meta_desc4" id="wh_meta_desc4"></textarea>
    </div>
	<div class="form-field">
        <label for="wh_meta_title5">Заголовок 5</label>
        <input type="text" name="wh_meta_title5" id="wh_meta_title5">
    </div>
    <div class="form-field">
        <label for="wh_meta_desc5">Описание 5</label>
        <textarea name="wh_meta_desc5" id="wh_meta_desc5"></textarea>
    </div>
    <h2>SEO</h2>
    <div class="form-field">
        <label for="cats_title">Заголовок страницаы</label>
        <input type="text" name="cats_title" id="cats_title">
    </div>
    <div class="form-field">
        <label for="cats_descr">Описание страницы</label>
        <textarea name="cats_descr" id="cats_descr"></textarea>
    </div>
    <div class="form-field">
        <label for="cats_kw">Ключевые слова страницы</label>
        <textarea name="cats_kw" id="cats_kw"></textarea>
    </div>
    <?php
}

//Product Cat Edit page
function wh_taxonomy_edit_meta_field($term) {

    //getting term ID
    $term_id = $term->term_id;

    // retrieve the existing value(s) for this meta field.
    $wh_meta_title1 = get_term_meta($term_id, 'wh_meta_title1', true);
    $wh_meta_desc1 = get_term_meta($term_id, 'wh_meta_desc1', true);
    $wh_meta_title2 = get_term_meta($term_id, 'wh_meta_title2', true);
    $wh_meta_title3 = get_term_meta($term_id, 'wh_meta_title3', true);
    $wh_meta_title4 = get_term_meta($term_id, 'wh_meta_title4', true);
    $wh_meta_title5 = get_term_meta($term_id, 'wh_meta_title5', true);
    $wh_meta_desc2 = get_term_meta($term_id, 'wh_meta_desc2', true);
    $wh_meta_desc3 = get_term_meta($term_id, 'wh_meta_desc3', true);
    $wh_meta_desc4 = get_term_meta($term_id, 'wh_meta_desc4', true);
    $wh_meta_desc5 = get_term_meta($term_id, 'wh_meta_desc5', true);
    $package_type = get_term_meta($term_id, 'package_type', true);
	$wh_meta_img1 = get_term_meta($term_id, 'wh_meta_img1', true);
	$cats_descr = get_term_meta($term_id, 'cats_descr', true);
	$cats_title = get_term_meta($term_id, 'cats_title', true);
	$cats_kw = get_term_meta($term_id, 'cats_kw', true);
	
	$thumbnail1_id = absint( get_term_meta($term_id, 'thumbnail1_id', true ) );
    if ( $thumbnail1_id ) {
        $image1 = wp_get_attachment_thumb_url( $thumbnail1_id );
    } else {
        $image1 = wc_placeholder_img_src();
    }
    $thumbnail2_id = absint( get_term_meta($term_id, 'thumbnail2_id', true ) );
    if ( $thumbnail2_id ) {
        $image2 = wp_get_attachment_thumb_url( $thumbnail2_id );
    } else {
        $image2 = wc_placeholder_img_src();
    }
    $thumbnail3_id = absint( get_term_meta($term_id, 'thumbnail3_id', true ) );
    if ( $thumbnail3_id ) {
        $image3 = wp_get_attachment_thumb_url( $thumbnail3_id );
    } else {
        $image3 = wc_placeholder_img_src();
    }
    $thumbnail4_id = absint( get_term_meta($term_id, 'thumbnail4_id', true ) );
    if ( $thumbnail4_id ) {
        $image4 = wp_get_attachment_thumb_url( $thumbnail4_id );
    } else {
        $image4 = wc_placeholder_img_src();
    }
    $thumbnail5_id = absint( get_term_meta($term_id, 'thumbnail5_id', true ) );
    if ( $thumbnail5_id ) {
        $image5 = wp_get_attachment_thumb_url( $thumbnail5_id );
    } else {
        $image5 = wc_placeholder_img_src();
    }
    $thumbnail6_id = absint( get_term_meta($term_id, 'thumbnail6_id', true ) );
    if ( $thumbnail6_id ) {
        $image6 = wp_get_attachment_thumb_url( $thumbnail6_id );
    } else {
        $image6 = wc_placeholder_img_src();
    }
	if($term->parent === 0){
    ?>
	<tr class="form-field">
        <th scope="row" valign="top"><label for="package_type">Вид упаковки</label></th>
        <td>
            <input type="text" name="package_type" id="package_type" value='<?php echo esc_attr($package_type) ? esc_attr($package_type) : "" ?> '>
        </td>
    </tr>
	<?php } ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_title1">Заголовок 1</label></th>
        <td>
            <input type="text" name="wh_meta_title1" id="wh_meta_title1" value='<?php echo esc_attr($wh_meta_title1) ? esc_attr($wh_meta_title1) : "" ?> '>
        </td2>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_desc1">Описание 1</label></th>
        <td>
            <textarea name="wh_meta_desc1" id="wh_meta_desc1"><?php echo esc_attr($wh_meta_desc1) ? esc_attr($wh_meta_desc1) : "" ?></textarea>
        </td>
    </tr>
	<tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_title2">Заголовок 2</label></th>
        <td>
            <input type="text" name="wh_meta_title2" id="wh_meta_title2" value='<?php echo esc_attr($wh_meta_title2) ? esc_attr($wh_meta_title2) : "" ?> '>
        </td2>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_desc2">Описание 2</label></th>
        <td>
            <textarea name="wh_meta_desc2" id="wh_meta_desc2"><?php echo esc_attr($wh_meta_desc2) ? esc_attr($wh_meta_desc2) : "" ?></textarea>
        </td>
    </tr>
	<tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_title3">Заголовок 3</label></th>
        <td>
            <input type="text" name="wh_meta_title3" id="wh_meta_title3" value='<?php echo esc_attr($wh_meta_title3) ? esc_attr($wh_meta_title3) : "" ?> '>
        </td2>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_desc3">Описание 3</label></th>
        <td>
            <textarea name="wh_meta_desc3" id="wh_meta_desc3"><?php echo esc_attr($wh_meta_desc3) ? esc_attr($wh_meta_desc3) : "" ?></textarea>
        </td>
    </tr>
	<tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_title4">Заголовок 4</label></th>
        <td>
            <input type="text" name="wh_meta_title4" id="wh_meta_title4" value='<?php echo esc_attr($wh_meta_title4) ? esc_attr($wh_meta_title4) : "" ?> '>
        </td2>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_desc4">Описание 4</label></th>
        <td>
            <textarea name="wh_meta_desc4" id="wh_meta_desc4"><?php echo esc_attr($wh_meta_desc4) ? esc_attr($wh_meta_desc4) : "" ?></textarea>
        </td>
    </tr>
	<tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_title5">Заголовок 5</label></th>
        <td>
            <input type="text" name="wh_meta_title5" id="wh_meta_title5" value='<?php echo esc_attr($wh_meta_title5) ? esc_attr($wh_meta_title5) : "" ?> '>
        </td2>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_desc5">Описание 5</label></th>
        <td>
            <textarea name="wh_meta_desc5" id="wh_meta_desc5"><?php echo esc_attr($wh_meta_desc5) ? esc_attr($wh_meta_desc5) : "" ?></textarea>
        </td>
    </tr>
	<?php
	if($term->parent > 0) { 
	?>
	<tr class="form-field term-thumbnail-wrap">
			<th scope="row" valign="top"><label>Изображение для Siper</label></th>
			<td>
				<div id="product_cat_thumbnail1" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image1 ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_thumbnail1_id" name="product_cat_thumbnail1_id" value="<?php echo esc_attr( $thumbnail1_id ); ?>" />
					<button type="button" class="upload_image1_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="remove_image1_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#product_cat_thumbnail1_id' ).val() ) {
						jQuery( '.remove_image1_button' ).hide();
					}

					// Uploading files
					var file_frame1;

					jQuery( document ).on( 'click', '.upload_image1_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame1 ) {
							file_frame1.open();
							return;
						}

						// Create the media frame.
						file_frame1 = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame1.on( 'select', function() {
							var attachment           = file_frame1.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.full;
							console.log(attachment_thumbnail.url);

							jQuery( '#product_cat_thumbnail1_id' ).val( attachment.id );
							jQuery( '#product_cat_thumbnail1' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
							jQuery( '.remove_image1_button' ).show();
						});

						// Finally, open the modal.
						file_frame1.open();
					});

					jQuery( document ).on( 'click', '.remove_image1_button', function() {
						jQuery( '#product_cat_thumbnail1' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_thumbnail1_id' ).val( '' );
						jQuery( '.remove_image1_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>


        <tr class="form-field term-thumbnail-wrap">
			<th scope="row" valign="top"><label>Изображение для Siper</label></th>
			<td>
				<div id="product_cat_thumbnail2" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image2 ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_thumbnail2_id" name="product_cat_thumbnail2_id" value="<?php echo esc_attr( $thumbnail2_id ); ?>" />
					<button type="button" class="upload_image2_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="remove_image2_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#product_cat_thumbnail2_id' ).val() ) {
						jQuery( '.remove_image2_button' ).hide();
					}

					// Uploading files
					var file_frame2;

					jQuery( document ).on( 'click', '.upload_image2_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame2 ) {
							file_frame2.open();
							return;
						}

						// Create the media frame.
						file_frame2 = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame2.on( 'select', function() {
							var attachment           = file_frame2.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.full;

							jQuery( '#product_cat_thumbnail2_id' ).val( attachment.id );
							jQuery( '#product_cat_thumbnail2' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
							jQuery( '.remove_image2_button' ).show();
						});

						// Finally, open the modal.
						file_frame2.open();
					});

					jQuery( document ).on( 'click', '.remove_image2_button', function() {
						jQuery( '#product_cat_thumbnail2' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_thumbnail2_id' ).val( '' );
						jQuery( '.remove_image2_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>

        <tr class="form-field term-thumbnail-wrap">
			<th scope="row" valign="top"><label>Изображение для Siper</label></th>
			<td>
				<div id="product_cat_thumbnail3" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image3 ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_thumbnail3_id" name="product_cat_thumbnail3_id" value="<?php echo esc_attr( $thumbnail3_id ); ?>" />
					<button type="button" class="upload_image3_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="remove_image3_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#product_cat_thumbnail3_id' ).val() ) {
						jQuery( '.remove_image3_button' ).hide();
					}

					// Uploading files
					var file_frame3;

					jQuery( document ).on( 'click', '.upload_image3_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame3 ) {
							file_frame3.open();
							return;
						}

						// Create the media frame.
						file_frame3 = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame3.on( 'select', function() {
							var attachment           = file_frame3.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.full;

							jQuery( '#product_cat_thumbnail3_id' ).val( attachment.id );
							jQuery( '#product_cat_thumbnail3' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
							jQuery( '.remove_image3_button' ).show();
						});

						// Finally, open the modal.
						file_frame3.open();
					});

					jQuery( document ).on( 'click', '.remove_image3_button', function() {
						jQuery( '#product_cat_thumbnail3' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_thumbnail3_id' ).val( '' );
						jQuery( '.remove_image3_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>

        <tr class="form-field term-thumbnail-wrap">
			<th scope="row" valign="top"><label>Изображение для Siper</label></th>
			<td>
				<div id="product_cat_thumbnail4" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image4 ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_thumbnail4_id" name="product_cat_thumbnail4_id" value="<?php echo esc_attr( $thumbnail4_id ); ?>" />
					<button type="button" class="upload_image4_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="remove_image4_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#product_cat_thumbnail4_id' ).val() ) {
						jQuery( '.remove_image4_button' ).hide();
					}

					// Uploading files
					var file_frame4;

					jQuery( document ).on( 'click', '.upload_image4_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame4 ) {
							file_frame4.open();
							return;
						}

						// Create the media frame.
						file_frame4 = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame4.on( 'select', function() {
							var attachment           = file_frame4.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.full;

							jQuery( '#product_cat_thumbnail4_id' ).val( attachment.id );
							jQuery( '#product_cat_thumbnail4' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
							jQuery( '.remove_image4_button' ).show();
						});

						// Finally, open the modal.
						file_frame4.open();
					});

					jQuery( document ).on( 'click', '.remove_image4_button', function() {
						jQuery( '#product_cat_thumbnail4' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_thumbnail4_id' ).val( '' );
						jQuery( '.remove_image4_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>

        <tr class="form-field term-thumbnail-wrap">
			<th scope="row" valign="top"><label>Изображение для Siper</label></th>
			<td>
				<div id="product_cat_thumbnail5" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image5 ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_thumbnail5_id" name="product_cat_thumbnail5_id" value="<?php echo esc_attr( $thumbnail5_id ); ?>" />
					<button type="button" class="upload_image5_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="remove_image5_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#product_cat_thumbnail5_id' ).val() ) {
						jQuery( '.remove_image5_button' ).hide();
					}

					// Uploading files
					var file_frame5;

					jQuery( document ).on( 'click', '.upload_image5_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame5 ) {
							file_frame5.open();
							return;
						}

						// Create the media frame.
						file_frame5 = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame5.on( 'select', function() {
							var attachment           = file_frame5.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.full;

							jQuery( '#product_cat_thumbnail5_id' ).val( attachment.id );
							jQuery( '#product_cat_thumbnail5' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
							jQuery( '.remove_image5_button' ).show();
						});

						// Finally, open the modal.
						file_frame5.open();
					});

					jQuery( document ).on( 'click', '.remove_image5_button', function() {
						jQuery( '#product_cat_thumbnail5' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_thumbnail5_id' ).val( '' );
						jQuery( '.remove_image5_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>

        <tr class="form-field term-thumbnail-wrap">
			<th scope="row" valign="top"><label>Изображение для Siper</label></th>
			<td>
				<div id="product_cat_thumbnail6" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image6 ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_thumbnail6_id" name="product_cat_thumbnail6_id" value="<?php echo esc_attr( $thumbnail6_id ); ?>" />
					<button type="button" class="upload_image6_button button"><?php esc_html_e( 'Upload/Add image', 'woocommerce' ); ?></button>
					<button type="button" class="remove_image6_button button"><?php esc_html_e( 'Remove image', 'woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#product_cat_thumbnail6_id' ).val() ) {
						jQuery( '.remove_image6_button' ).hide();
					}

					// Uploading files
					var file_frame6;

					jQuery( document ).on( 'click', '.upload_image6_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame6 ) {
							file_frame6.open();
							return;
						}

						// Create the media frame.
						file_frame6 = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'woocommerce' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame6.on( 'select', function() {
							var attachment           = file_frame6.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.full;

							jQuery( '#product_cat_thumbnail6_id' ).val( attachment.id );
							jQuery( '#product_cat_thumbnail6' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
							jQuery( '.remove_image6_button' ).show();
						});

						// Finally, open the modal.
						file_frame6.open();
					});

					jQuery( document ).on( 'click', '.remove_image6_button', function() {
						jQuery( '#product_cat_thumbnail6' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_cat_thumbnail6_id' ).val( '' );
						jQuery( '.remove_image6_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>
    <?php
	} ?>
        <tr><td><h2>SEO</h2></td></tr>
	<tr class="form-field">
        <th scope="row" valign="top"><label for="cats_title">Заголовок страницы</label></th>
        <td>
            <input type="text" name="cats_title" id="cats_title" value='<?php echo esc_attr($cats_title) ? esc_attr($cats_title) : "" ?> '>
        </td2>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="cats_descr">Описание страницы</label></th>
        <td>
            <textarea name="cats_descr" id="cats_descr"><?php echo esc_attr($cats_descr) ? esc_attr($cats_descr) : "" ?></textarea>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="cats_kw">Ключевые слова страницы</label></th>
        <td>
            <textarea name="cats_kw" id="cats_kw"><?php echo esc_attr($cats_kw) ? esc_attr($cats_kw) : "" ?></textarea>
        </td>
    </tr>  
<?
}


add_action('edited_product_cat', 'wh_save_taxonomy_custom_meta', 10, 1);
add_action('create_product_cat', 'wh_save_taxonomy_custom_meta', 10, 1);
function wh_save_taxonomy_custom_meta($term_id) {
    $wh_meta_title1 = filter_input(INPUT_POST, 'wh_meta_title1');
    $wh_meta_title2 = filter_input(INPUT_POST, 'wh_meta_title2');
    $wh_meta_title3 = filter_input(INPUT_POST, 'wh_meta_title3');
    $wh_meta_title4 = filter_input(INPUT_POST, 'wh_meta_title4');
    $wh_meta_title5 = filter_input(INPUT_POST, 'wh_meta_title5');
    $wh_meta_desc1 = filter_input(INPUT_POST, 'wh_meta_desc1');
    $wh_meta_desc2 = filter_input(INPUT_POST, 'wh_meta_desc2');
    $wh_meta_desc3 = filter_input(INPUT_POST, 'wh_meta_desc3');
    $wh_meta_desc4 = filter_input(INPUT_POST, 'wh_meta_desc4');
    $wh_meta_desc5 = filter_input(INPUT_POST, 'wh_meta_desc5');
    $package_type = filter_input(INPUT_POST, 'package_type');
    $cats_title = filter_input(INPUT_POST, 'cats_title');
    $cats_descr = filter_input(INPUT_POST, 'cats_descr');
    $cats_kw = filter_input(INPUT_POST, 'cats_kw');

    update_term_meta($term_id, 'wh_meta_title1', $wh_meta_title1);
    update_term_meta($term_id, 'wh_meta_title2', $wh_meta_title2);
    update_term_meta($term_id, 'wh_meta_title3', $wh_meta_title3);
    update_term_meta($term_id, 'wh_meta_title4', $wh_meta_title4);
    update_term_meta($term_id, 'wh_meta_title5', $wh_meta_title5);
    update_term_meta($term_id, 'wh_meta_desc1', $wh_meta_desc1);
    update_term_meta($term_id, 'wh_meta_desc2', $wh_meta_desc2);
    update_term_meta($term_id, 'wh_meta_desc3', $wh_meta_desc3);
    update_term_meta($term_id, 'wh_meta_desc4', $wh_meta_desc4);
    update_term_meta($term_id, 'wh_meta_desc5', $wh_meta_desc5);
    update_term_meta($term_id, 'package_type', $package_type);
    update_term_meta($term_id, 'cats_title', $cats_title);
    update_term_meta($term_id, 'cats_descr', $cats_descr);
    update_term_meta($term_id, 'cats_kw', $cats_kw);

	if ( isset( $_POST['product_cat_thumbnail1_id'] )) { // WPCS: CSRF ok, input var ok.
		update_term_meta( $term_id, 'thumbnail1_id', absint( $_POST['product_cat_thumbnail1_id'] ) ); // WPCS: CSRF ok, input var ok.
	} else {
		update_term_meta( $term_id, 'thumbnail1_id', ''); // WPCS: CSRF ok, input var ok.
	}

    if ( isset( $_POST['product_cat_thumbnail2_id'] )) { // WPCS: CSRF ok, input var ok.
		update_term_meta( $term_id, 'thumbnail2_id', absint( $_POST['product_cat_thumbnail2_id'] ) ); // WPCS: CSRF ok, input var ok.
	} else {
		update_term_meta( $term_id, 'thumbnail2_id', ''); // WPCS: CSRF ok, input var ok.
	}

    if ( isset( $_POST['product_cat_thumbnail3_id'] )) { // WPCS: CSRF ok, input var ok.
		update_term_meta( $term_id, 'thumbnail3_id', absint( $_POST['product_cat_thumbnail3_id'] ) ); // WPCS: CSRF ok, input var ok.
	} else {
		update_term_meta( $term_id, 'thumbnail3_id', ''); // WPCS: CSRF ok, input var ok.
	}

    if ( isset( $_POST['product_cat_thumbnail4_id'] )) { // WPCS: CSRF ok, input var ok.
		update_term_meta( $term_id, 'thumbnail4_id', absint( $_POST['product_cat_thumbnail4_id'] ) ); // WPCS: CSRF ok, input var ok.
	} else {
		update_term_meta( $term_id, 'thumbnail4_id', ''); // WPCS: CSRF ok, input var ok.
	}

    if ( isset( $_POST['product_cat_thumbnail5_id'] )) { // WPCS: CSRF ok, input var ok.
		update_term_meta( $term_id, 'thumbnail5_id', absint( $_POST['product_cat_thumbnail5_id'] ) ); // WPCS: CSRF ok, input var ok.
	} else {
		update_term_meta( $term_id, 'thumbnail5_id', ''); // WPCS: CSRF ok, input var ok.
	}

    if ( isset( $_POST['product_cat_thumbnail6_id'] )) { // WPCS: CSRF ok, input var ok.
		update_term_meta( $term_id, 'thumbnail6_id', absint( $_POST['product_cat_thumbnail6_id'] ) ); // WPCS: CSRF ok, input var ok.
	} else {
		update_term_meta( $term_id, 'thumbnail6_id', ''); // WPCS: CSRF ok, input var ok.
	}
}