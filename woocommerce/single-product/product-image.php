<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<?php if ( $post_thumbnail_id ) {
		$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
		$html = '';
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image swiper-slide" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}
	?>

	<div class="swiper single_product_swiper">
		<div class="single_product_swiper_prev" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
        <div class="single_product_swiper_next" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
		<div class="woocommerce-product-gallery__wrapper swiper-wrapper">
			<?php

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

			do_action( 'woocommerce_product_thumbnails' );
			?>
		</div>
	</div>
	<div class="swiper single_product_swiper_controler">
		<div class="single_product_swiper_controller_prev" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
		<div class="single_product_swiper_controller_next" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
		<div class="woocommerce-product-gallery__wrapper swiper-wrapper">
			<?php

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

			do_action( 'woocommerce_product_thumbnails' );
			?>
		</div>
	</div>
	<div class="single_product_swiper_full_screen_wrapper">
	    <div class="cover"></div>
	    <img class="close_single_product_swiper_full_screen_overlay" src="<?= CFS()->get('burger_close_img', 23) ?>" alt="">
	    <div class="single_product_swiper_full_screen_overlay">
    	    <div class="single_product_swiper_full_screen">
    		<div class="single_product_swiper_full_screen_prev disabled" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
            <div class="single_product_swiper_full_screen_next" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
    		<div class="woocommerce-product-gallery__wrapper">
    		    <img class="single_product_swiper_slide_img" src="" alt="">
    		</div>
		</div>
	</div>
	</div>
</div>