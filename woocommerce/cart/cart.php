<?php
/**
 * Cart Page
 * 
 * Template Name: Корзина
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
do_action( 'woocommerce_before_cart' ); ?>


<div class="page_wrapper">
	<h1 class="header">Оформление заказа</h1>
<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	
	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2" class="product-thumbnail">Наименование</th>
				<!-- <th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'Thumbnail image', 'woocommerce' ); ?></span></th> -->
				<th class="product-package">Упаковка</th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal">Стоимость</th>
				<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'woocommerce' ); ?></span></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				/**
				 * Filter the product name.
				 *
				 * @since 2.1.0
				 * @param string $product_name Name of the product in the cart.
				 * @param array $cart_item The product in the cart.
				 * @param string $cart_item_key Key for the product in the cart.
				 */
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					$is_single = get_post_meta( $product_id, 'single_prod', true );

					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td colspan="2" class="product-thumbnail" data-title="Наименование" >
							<div class="product-thumbnail_inner_wrapper">
						<?php
						$thumbnail = '<img src="'.wp_get_attachment_url( $_product->image_id ).'" alt="" class="product-thumbnail_img">';

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>
						<!-- </td> -->

						<!-- <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>"> -->
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( $product_name . '&nbsp;' );
						} else {
							/**
							 * This filter is documented above.
							 *
							 * @since 2.1.0
							 */
							$parent_id = $_product->parent_id;
							$product_name_to_cart = $parent_id > 0 ? wc_get_product($parent_id)->get_name() : $_product->get_name();
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="cart_prod_text__link">%s</a>', esc_url( $product_permalink ), $product_name_to_cart ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						// echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
						</div>
						</td>
						<?php
							$package_types = ['', ''];
							if ($_product->parent_id > 0){
								$prodcats = wc_get_product($_product->parent_id)->category_ids;
							} else {
								$prodcats = $_product->category_ids;
							}
							foreach ($prodcats as $prodcat) {
								$term_package_type = get_term_meta($prodcat, 'package_type', true);
								if($term_package_type !== ''){
									$package_type[] = $term_package_type;
									$package_types = explode(',', $package_type[0]);
								}
							}
						?>
						<td class="cart_package_type" data-title="Упаковка">
							<?php
							if(isset($cart_item['full']) && $cart_item['full'] == 'true'){
								if(isset($package_type)){
									echo $package_types[0];
								}
							} else {
								if(isset($_product->attribute_summary)){
									if(gettype($_product->attribute_summary) == 'array'){
										echo implode(',<br> ', $_product->attribute_summary);
									} elseif (gettype($_product->attribute_summary) == 'string'){
										$summary = explode(', ', $_product->attribute_summary);
										$summary = implode(',<br>', $summary);
										echo $summary;
									}
								} else {
									if(isset($package_type)){
										echo $package_types[0];
									}
								}
							}
							?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								if($is_single !== 'yes') { ?>
									<p class='product_price'><span class="cart_prod_price"><?= $_product->get_price().'</span> &#8381;'; ?>/м2</p>
								<?php	
								} else {?>
								<p class='product_price'><?= '<span class="cart_prod_price">'.$_product->get_price().'</span> &#8381;'; ?></p>
							<?php
								}								
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if(isset($cart_item['full']) && $cart_item['full'] == 'true'){
							$dis = 'disabled';
							$r = 'readonly';
						} else {
							$dis = '';
							$r = '';
						}
						if ( $_product->is_sold_individually() ) {
							$min_quantity = 1;
							$max_quantity = 1;
						} else {
							$min_quantity = 0;
							$max_quantity = $_product->get_max_purchase_quantity();
						}
						
						echo '<div class="quantity_wrapper">';
						$max_quantity = $max_quantity > 0 ? $max_quantity : "";
						if ($is_single !== 'yes') {
							echo '<div class="cart_meters_qty">';
							$qty_package = get_post_meta( $product_id, '_qty_field_product', true );
							$qty_package = empty($qty_package) ? 1 : $qty_package;
							if(isset($cart_item['width']) && floatval($cart_item['width'])>0){
								$qty_package = floatval($cart_item['width']) * floatval($qty_package);
							}
							$max_meters_qty = floatval($qty_package)*floatval($cart_item['quantity']);
							$max_meters_qty = $max_quantity > 0? 'max="'.$max_meters_qty.'"' : '';
							echo '<label for="cart_squares'.$cart_item_key.'" class="cart_squares_label">'.$package_types[1].':</label>';
							echo '<div class="cart_squares_wrapper">';
							echo '<button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); $(this.nextElementSibling).trigger(`input`);">-</button>';
							echo '<input class="cart_squares" id="cart_squares'.$cart_item_key.'" type="number" value="'.ceil(floatval($cart_item['quantity'])/floatval($qty_package)).'" min="0"'.$max_meters_qty.' step="1" data-maxMeters="'.$qty_package.'">';
							echo '<button class="number-plus" onclick="this.previousElementSibling.stepUp(); $(this.previousElementSibling).trigger(`input`);" type="button">+</button>';
							echo '</div></div>';
						}
						
							 if($is_single !== 'yes') {
								$step = '0.01';
								$prod_qty_label = '<label for="cart_qty">м2:</label>';
							 } else { 
								$step = '1';
								$prod_qty_label = '<label for="cart_qty">'.$package_types[1].'</label>';
							 } 

						$psm_prod_name = "cart[{$cart_item_key}][qty]";
						$product_quantity = '<div class="cart_qty_wrapper_super">'.$prod_qty_label.'<div class="cart_qty_wrapper">
						<button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown();" '.$dis.'>-</button>
						<input type="number" name="'.$psm_prod_name.'" value="'.$cart_item['quantity'].'" min="'.$min_quantity.'" max="'.$max_quantity.'" class="input-text qty text  '.$dis.'" size="4" step="'.$step.'" autocomplete="off" '.$r.'>
						<button class="number-plus" onclick="this.previousElementSibling.stepUp();" type="button" '.$dis.'>+</button></div></div>';

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						echo '</div>';
						
						if ($is_single == 'yes') {
							$qty_package = get_post_meta( $product_id, '_qty_field_product', true );
							if(!empty($qty_package)){
								echo '<div class="cart_meters_qty">';
								$max_meters_qty = intval($qty_package)*intval($max_quantity);
								$calced_qty = floatval($qty_package)*intval($cart_item['quantity']);
								$calced_qty = $calced_qty > 0? $calced_qty : '';
								$max_meters_qty = $max_quantity > 0? 'max="'.$max_meters_qty.'"' : '';
								echo '<label for="cart_prods_to_calc'.$cart_item_key.'" class="cart_squares_label">м2:</label>';
								echo '<input class="cart_prods_to_calc" id="cart_squares'.$cart_item_key.'" type="number" value="'.ceil($calced_qty).'" min="0"'.$max_meters_qty.' step="1" data-maxMeters="'.$qty_package.'">';
								echo '</div>';
							}
						}

						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
						<td class="product-remove">
							<?php
								$img_url = CFS()->get('product_catalog_filter_close', 23);
								$removelink = sprintf('<a href="%s" class="psm_remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><img src="'.$img_url.'" alt=""></a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							);
							echo $removelink;
							?>
						</td>
					</tr>
					
					<?php
				}
				$package_type = [];
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr class="cart_total_price_row">
				<td colspan="7" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>
					<div class="cart_offer_btn_wrapper">
						<button type="button" class="offer_cart">Оформить заказ</button>
						<div class="psm_cart_total_price">
							<p class="psm_cart_total_title">Итого</p>
							<p class="psm_cart_total_total"><?= 
							number_format(
								WC()->cart->cart_contents_total,
								0,
								",",
								" "
							)							 
							?> &#8381;</p>
						</div>
					</div>
					<button style="display: none" type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<div class="cart-collaterals_header">Вы недавно просматривали</div>
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		// do_action( 'woocommerce_cart_collaterals' );
		echo do_shortcode( '[recently_viewed_products]');
	?>
</div>

<div class="cart_offer_form_wrapper">
	<div class="cart_cover"></div>
	<div class="cart_offer_form_content">
		<img class="cart_offer_form_img" src="<?= $img_url ?>" alt="">
		<h3 class="cart_offer_form_header">Оформление заказа</h3>
		<p class="cart_offer_form_text">Чтобы оформить заказ, заполните форму. После оформления, с вами свяжется менеджер и уточнит детали заказа, а так же время доставки.</p>
		<form action="" class="cart_offer_form">
			<label for="cart_offer_form_name" class="cart_offer_form_namelabel cart_offer_form_label">Ф.И.О<span class="red">*</span></label>
			<div class="cart_offer_form_input_wrapper">
				<input type="text" class="cart_offer_form_name cart_offer_form_input" id="cart_offer_form_name" name="cart_offer_form_name" placeholder="Фамилия Имя Отчество">
			</div>
			
			<label for="cart_offer_form_phone" class="cart_offer_form_phonelabel cart_offer_form_label">Телефон<span class="red">*</span></label>
			<div class="cart_offer_form_input_wrapper">
				<input type="text" class="cart_offer_form_phone cart_offer_form_input" id="cart_offer_form_phone" value="+7("name="cart_offer_form_phone" placeholder="">
			</div>

			<label for="cart_offer_form_email" class="cart_offer_form_emaillabel cart_offer_form_label">Email<span class="red">*</span></label>
			<div class="cart_offer_form_input_wrapper">
				<input type="text" class="cart_offer_form_email cart_offer_form_input" id="cart_offer_form_email" name="cart_offer_form_email" placeholder="E-mail">
			</div>

			<p  class="cart_offer_form_shipping_text">Cпособ доставки:</p>
			<div class="cart_offer_form_shipping_wrapper">
				<div class="cart_offer_form_shipping_radio_wrapper">
					<input type="radio" class="cart_offer_form_shipping" value="self" id="cart_offer_form_shipping_self" name="cart_offer_form_shipping">
					<label for="cart_offer_form_shipping_self" class="cart_offer_form_shipping_label">Самовывоз</label>
				</div>
				<div class="cart_offer_form_shipping_radio_wrapper">
					<input type="radio" class="cart_offer_form_shipping" value="shipping" id="cart_offer_form_shipping_shipping" name="cart_offer_form_shipping">
					<label for="cart_offer_form_shipping_shipping" class="cart_offer_form_shipping_label">Доставка</label>
				</div>
			</div>

			<p class="cart_offer_form_shipping_adress_label">Адрес доставки:</p>
			<textarea name="cart_offer_form_shipping_adress" id="cart_offer_form_shipping_adress" placeholder="Адрес"></textarea>

			<div class="cart_offer_form_shipping_text">Cпособ оплаты:</div>
			<div class="cart_offer_form_payment_wrapper">
				<div class="cart_offer_form_shipping_radio_wrapper">
					<input type="radio" class="cart_offer_form_shipping" value="cash_card_office" id="cart_offer_form_payment_office" name="cart_offer_form_payment">
					<label for="cart_offer_form_payment_office" class="cart_offer_form_shipping_label">Карта или наличные в офисе</label>
				</div>
				<div class="cart_offer_form_shipping_radio_wrapper">
					<input type="radio" class="cart_offer_form_shipping" value="cash_recieve" id="cart_offer_form_payment_recieve" name="cart_offer_form_payment">
					<label for="cart_offer_form_payment_recieve" class="cart_offer_form_shipping_label">Наличными при получении</label>
				</div>
				<div class="cart_offer_form_shipping_radio_wrapper">
					<input type="radio" class="cart_offer_form_shipping" value="card_company" id="cart_offer_form_payment_company" name="cart_offer_form_payment">
					<label for="cart_offer_form_payment_company" class="cart_offer_form_shipping_label">Безнал. расчет как юр. лицо</label>
				</div>
			</div>

			<p class="cart_offer_form_comment_text">Комментарий:</p>
			<textarea name="cart_offer_form_comment" id="cart_offer_form_comment" placeholder="Комментарий к заказу"></textarea>

			<button class="cart_offer_form_button" disabled type="button">Оформить заказ</button>

			<div class="cart_offer_form_pd_wrapper">
				<input type="checkbox" class="cart_offer_form_checkbox" value="yes" name="cart_offer_form_checkbox" id="cart_offer_form_checkbox">
				<label for="cart_offer_form_checkbox" class="cart_offer_form_checkbox_label">Согласен(а) на обработку моих персональных данных</label>
			</div>
		</form>
	</div>
</div>

<div class="cart_cheout_wrapper">
	<div class="cart_cover"></div>
	<div class="cart_cheout">
		<img class="cart_offer_form_img" src="<?= $img_url ?>" alt="">
		<img class="cart_cheout_img" src="<?= CFS()->get('cart_cheout_ok',23)?>" alt="">
		<p class="cart_cheout_text"><?= CFS()->get('cart_options_check_text',23)?></p>
	</div>
</div>

</div>
<?php do_action( 'woocommerce_after_cart' ); ?>