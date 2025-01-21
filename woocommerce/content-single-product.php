<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
// do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div class="page_wrapper">
	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	woocommerce_template_single_title();
	?>
	<div class="product_galery_summary_wrapper">

	<?
	woocommerce_show_product_images();
	// do_action( 'woocommerce_before_single_product_summary' );

	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		// do_action( 'woocommerce_single_product_summary' );
		$cats = $product->get_category_ids();
		echo '<div class="prod_collections_n_creator_wrapper">';
		foreach($cats as $cat) {
			echo get_term($cat)->parent === 63 ? '<div><span class="summary_pale_tags top_attrs">Коллекция: </span><span class="top_attrs"><a href="'.get_term_link($cat).'">'.get_term($cat)->name.'</a></span></div>': "" ;
			$package_to_sell_raw = get_term_meta($cat, 'package_type', true);
			if($package_to_sell_raw !== '' && strlen($package_to_sell_raw) > 3){
			    $package_to_sell = trim($package_to_sell_raw);
			}
			$for_package_counter = empty($package_to_sell) ? '' : explode(',', $package_to_sell)[1];
		}
		$attrs = $product->get_attributes();
		if (isset($attrs['pa_creator'])){
			echo $attrs['pa_creator']->get_terms()[0]->name != '' ? '<div><span class="summary_pale_tags top_attrs">Производитель: </span><span class="top_attrs">'.$attrs['pa_creator']->get_terms()[0]->name.'</span></div>': "" ;
		}
		echo '</div>';

		?>
		<div class="price_n_stock_wrapper">
			<div class="price_wrapper">
			<?php
				$is_single = get_post_meta( $product->get_id(), 'single_prod', true );
				if($product->is_type('variable')){
					$sale_price = floatval($product->get_variation_sale_price( 'min', true ));
					$reg_price = floatval($product->get_variation_regular_price( 'min', true ));
					$sale_price = $reg_price <= $sale_price ? '' : $sale_price;
				} else {
					$sale_price = floatval($product->get_sale_price());
					$reg_price = floatval($product->get_regular_price());
					$sale_price = $sale_price > 0 ? $sale_price : '';
					$sale_price = $reg_price <= $sale_price ? '' : $sale_price;
				}
				if (isset($sale_price) && $sale_price !== ''){

					$sale_price = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1 ", $sale_price);
					$sale_price = preg_replace("/\./i", ",", $sale_price);
					echo '<span class="single_prod_sale_price">';
					echo $is_single == 'yes' ? '<span id="prod_price_sale" data-d="nd">'.$sale_price.'</span> &#8381;' : 'От <span id="prod_price_sale" data-d="d">'.$sale_price.'</span> &#8381; / м2';
					echo '</span>';
				}
				if (isset($sale_price) && $sale_price !== ''){
					echo '<span class="single_prod_price single_prod_price_saled">';
				} else {
					echo '<span class="single_prod_price">';
				}
				if(isset($reg_price) && !empty($reg_price)){
					$reg_price = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1 ", $reg_price);
					$reg_price = preg_replace("/\./i", ",", $reg_price);
				echo $is_single == 'yes' ? '<span id="prod_price" data-d="nd">'.$reg_price.'</span>'. '&#8381;' : 'От <span id="prod_price" data-d="d">'.$reg_price.'</span> &#8381; / м2';
				echo '</span>';
				}
			?>
			</div>
			<div class="stok_wrapper">
				<?php 
				$pred_request = get_post_meta($product->get_id(), 'pred_request', true);
				if($pred_request != ''){
					$span = '<span class="prod_in_order_pred">'.$pred_request.'</span>';
				} else {
					$span = '<span class="prod_in_order">Предзаказ</span>';
				}
				if($pred_request == ''){
					switch ($product->get_stock_status()) {
						case 'onbackorder': echo $span; break;
						case 'instock': echo '<span class="prod_in_stok">В наличии</span>'; break;
						case 'outofstock': echo '<span class="prod_not_in_stok">Нет в наличии</span>'; break;
					}
				} else {
					echo $span;
				}
				?>
			</div>
		</div>
<?php
$single_prod_attrs = array_filter($product->get_attributes(), 'wc_attributes_array_filter_visible');
$attributes_singles = $single_prod_attrs;

function cmp($a, $b)
{
	if ($a["position"] == $b["position"]) {
		return 0;
	}
	return ($a["position"] < $b["position"]) ? -1 : 1;
}

// $attributes_keys = array_keys($single_prod_attrs);

// foreach ($attributes_keys as $index=>$attribute_key) {
//     if (substr($attribute_key, 0, 3) !== 'pa_') {
// 	    unset($attributes_keys[$index]);
//     }
// }

// if (!empty($attributes_keys)) {
//     $attributes_name = implode(',|', $attributes_keys);
//     $attributes_name = $attributes_name.',';
// } else {
//     $attributes_name = '';
// }

// if (!empty($attributes_name)) {
//     //TODO: refactor to method
//     $query = $wpdb->prepare("SELECT term_id, children FROM $wpdb->term_taxonomy WHERE taxonomy = %s AND children rlike %s", array('wugrat_group', $attributes_name));
//     $attribute_groups = $wpdb->get_results($query);

//     $option_group_order = explode(',', get_option('wugrat_group_order'), -1);
// } else {
//     $attribute_groups = '';
// }

// Organize groups and get attributes
// if (!empty($attribute_groups)) {
//     foreach ($attribute_groups as $attribute_group) {
//         $groupifier = rand(0, 9999);
//         $attribute_group_term = get_term($attribute_group->term_id);

//         $product_attribute_group = array();
//         $child_attribute_names = explode(',', $attribute_group->children);
//         foreach ($child_attribute_names as $child_attribute_name) {
//             if (array_key_exists($child_attribute_name, $single_prod_attrs)) {
//                 $product_attribute_group[$child_attribute_name] = $single_prod_attrs[$child_attribute_name];
//                 unset($attributes_singles[$child_attribute_name]);
//             }
//         }
if(!empty($attributes_singles)){
		usort($attributes_singles, 'cmp');
		foreach ($attributes_singles as $attribute) {
			$values = array();

			if ($attribute->is_taxonomy()) {
				$attribute_taxonomy = $attribute->get_taxonomy_object();
				$attribute_values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));

				foreach ($attribute_values as $attribute_value) {
					$value_name = esc_html($attribute_value->name);

					if ($attribute_taxonomy->attribute_public) {
						$values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
					} else {
						$values[] = $value_name;
					}
				}
			} else {
				$values = $attribute->get_options();

				foreach ($values as &$value) {
					$value = make_clickable(esc_html($value));
				}
			}
			
			if(!empty($attribute->get_taxonomy_object())){
				if ($attribute->get_taxonomy_object()->attribute_name == 'namotka') {
					$namotka = '';
					print_r(implode(', ', $values));
				}
			}
			$product_attributes[] = array(
				'label' => wc_attribute_label($attribute->get_name()),
				'value' => apply_filters('woocommerce_attribute', wptexturize(implode(', ', $values)), $attribute, $values),
				// 'value' => implode(', ', $values);
			);
		}
	}
	// }
// }

$display_dimensions = apply_filters('wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions());

if ($display_dimensions && $product->has_weight()) {
	$product_attributes['weight'] = array(
		'label' => __('Weight', 'woocommerce'),
		'value' => wc_format_weight($product->get_weight()),
	);
}

if ($display_dimensions && $product->has_dimensions()) {
	$product_attributes['dimensions'] = array(
		'label' => __('Dimensions', 'woocommerce'),
		'value' => wc_format_dimensions($product->get_dimensions(false)),
	);
}



if($product->is_type('variable')){
	$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
	$available_variations = $get_variations ? $product->get_available_variations() : false;
	$attributes           = $product->get_variation_attributes();
	$selected_attributes  = $product->get_default_attributes();
	$attribute_keys  = array_keys( $attributes );
	$available_variations_2;

	foreach($available_variations as $available_variation){
		$stokstatus = wc_get_product($available_variation['variation_id'])->get_stock_status();
		$pred_request = get_post_meta($available_variation['variation_id'], '_pred_request', true);
		if($pred_request != ''){
			$span = '<span class="prod_in_order_pred">'.$pred_request.'</span>';
		} else {
			$span = '<span class="prod_in_order">Предзаказ</span>';
		}
		switch ($stokstatus) {
			case 'onbackorder': $available_variation['pred_request'] = $span; break;
			case 'instock': $available_variation['pred_request'] = '<span class="prod_in_stok">В наличии</span>'; break;
			case 'outofstock': $available_variation['pred_request'] = '<span class="prod_not_in_stok">Нет в наличии</span>'; break;
		}
		$available_variations_2[] = $available_variation;
	}
}
?>
		<div class='prod_params'>
			<div class="params_wrapper single_variation_wrap">
				<?php
					$match = [];
					foreach ($attrs as $key=>$attr){
						preg_match('/\w*_to_fit\w*/', $key, $matches);
						if (!empty($matches)){
							$match = $matches;
						}
					}					
				?>
				<p class="prod_params_header">Параметры:</p>
					<?php			
						if (!empty($match)){
							if($is_single !== 'yes'){
						?>
						<div class="prod_params_cuts">
							<div class="prod_params_cut_tofit">
								<input class="prod_params_cuts_radio" type="radio" value="cut" name="prod_params_cuts_val" id="prod_params_cut_tofit_val">
								<label for="prod_params_cut_tofit_val" class="prod_params_cuts_label"><?= wc_attribute_label($attrs[$match[0]]['name']) ?></label>
							</div>
							<div class="prod_params_nocut">
								<input class="prod_params_cuts_radio" type="radio" value="full" name="prod_params_cuts_val" id="prod_params_nocut" checked>
								<?php
									if(isset($package_to_sell) && $package_to_sell !== ''){
										$package_to_sell = mb_strtolower($package_to_sell);
									    $package_to_sell =  explode(',', $package_to_sell );
										$male_package = explode(',', CFS()->get('male_package_types',23));
										$female_package = explode(',',CFS()->get('female_package_types', 23));
										$package_to_sell = $package_to_sell[0];
										if (in_array($package_to_sell, $male_package)){
											$package_to_sell = 'Целый '.$package_to_sell;
										}
										if(in_array($package_to_sell, $female_package)){
											$package_to_sell = 'Целая '.$package_to_sell;
										}
									} else {
										$package_to_sell = "Целая упаковка";
									}

								?>
								<label for="prod_params_nocut" checked class="prod_params_cuts_label"><?= $package_to_sell ?></label>
							</div>
						</div>
						<?php
							}
						}
					?>
				<div class="prod_params_cuts_width_n_squares">
					<?php
						
						?>
							<?php //if($is_single !== 'yes') { ?>
									<?php
									if($product->is_type('variable')){

									foreach ( $attributes as $attribute_name => $options ) :?>
									
									<div class="prod_params_cuts_width">
									<label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>" class="prod_params_cuts_width_label"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label>
									<div class="prod_params_cuts_width_select_wrapper">
									</div>
									</div>
									<?php

										endforeach;
									}
									?>
						<?php
							//}
						?>
						<div class="qty_wrapper">
							<?php if($is_single !== 'yes') { ?>
								<label for="qty">м2</label>
							<? } else { ?>
							<label for="qty">Количество</label>
							<?php } 
							$ps = get_post_meta( $product->get_id(), 'full_package_sales', true );
							if($ps == 'yes'){
								$qtystep = get_post_meta($product->get_id(), '_qty_field_product', true);
							} else {
								$qtystep = '1';
							}
							?>
							<div class="qty_input_wrapper" style="position:relative; width: fit-content;">
								<button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); $(this.nextElementSibling).trigger('input');">-</button>
								<input type="number" name="qty" id="qty" class="quantity" min="0" step="<?= $qtystep ?>">
								<button class="number-plus" onclick="this.previousElementSibling.stepUp(); $(this.previousElementSibling).trigger('input');" type="button">+</button>
							</div>
						</div>
						<?php if(!$is_single && $ps== ''){ ?>
							<div class="packages_counter_wrapper">
								<label for="packages_counter_input_linol" class="packages_counter_label"><?= $for_package_counter ?></label>
								<div style="position:relative; width: fit-content;">
								<button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); $(this.nextElementSibling).trigger('input');">-</button>
								<input type="number" class="packages_counter_input_linol" name="packages_counter_input_linol" id="packages_counter_input_linol" data-step="<?= get_post_meta($product->get_id(), '_qty_field_product', true) ?>">
								<button class="number-plus" onclick="this.previousElementSibling.stepUp(); $(this.previousElementSibling).trigger('input');" type="button">+</button>
							</div>
							</div>
						<?php } ?>

						<?php if ($ps == 'yes' && !$is_single){ ?>
						<div class="packages_counter_wrapper">
							<label for="packages_counter_input" class="packages_counter_label"><?= $for_package_counter ?></label>
							<div style="position:relative; width: fit-content;">
							<button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); $(this.nextElementSibling).trigger('input');">-</button>
							<input type="number" class="packages_counter_input" name="packages_counter_input" id="packages_counter_input" data-step="<?= get_post_meta($product->get_id(), '_qty_field_product', true) ?>">
							<button class="number-plus" onclick="this.previousElementSibling.stepUp(); $(this.previousElementSibling).trigger('input');" type="button">+</button>
							</div>
						</div>
						<?php } ?>
				</div>
			</div>
			<div class="subtotal_wrapper">
				<p class="subtotal_text">Итого:</p>
				<p class="subtotal">0 &#8381;</p>
			</div>
			<div class="prod_single_btns_wrapper data-container" data-prod="<?= $product->get_id() ?>">
				<?php 
					if($product->get_type() == "variable"){
						wp_enqueue_script( 'wc-add-to-cart-variation' );
						wc_get_template(
							'single-product/add-to-cart/variable.php',
							array(
								'available_variations' => empty($available_variations_2) ? '' : $available_variations_2,
								'attributes'           => $attributes,
								'selected_attributes'  => $selected_attributes,
								'data_nam'             => get_post_meta( $product->get_id(), '_qty_field_product', true ),
							)
						);



						}
						$single_prod_cart_icon = CFS()->get('single_prod_cart_icon', 23);
						if( is_product_in_cart() )  { ?>
						<button class="single_add_to_cart_button_vis single_add_to_cart_button_in_cart" value="<?= $product->get_id();?>" data-sku="<?= $product->get_sku() ?>">
						<?php
							echo !empty($single_prod_cart_icon) ? '<img src="'.$single_prod_cart_icon.'" alt="" class="single_add_to_cart_button_img">' : "";
						?>
						В корзине
						</button>
					<?php
					} else {?>
					<button class="single_add_to_cart_button_vis" value="<?= $product->get_id();?>" data-sku="<?= $product->get_sku() ?>">
					<?php
						echo !empty($single_prod_cart_icon) ? '<img src="'.$single_prod_cart_icon.'" alt="" class="single_add_to_cart_button_img">' : "";
					?>
					В корзину
					</button>
				<?php
					}
				?>

				
				<?php 
					$class = 'single_product_sel_heart';
                    if(isset($_COOKIE['favorite']) && $_COOKIE['favorite'] !== ''){
                        $f = explode(',', $_COOKIE['favorite']);
                        if(count($f) > 0){
                            foreach($f as $fs){
                                if(intval($fs) === intval($product->get_id())) {
                                    $class = 'single_product_sel_heart in_favorite';
                                }
                            } 
                        }
                    }
				?>
				<img src=<?= CFS()->get('product_heart_no_sel', 23) ?> alt="" class=<?= $class ?>>
				<img src=<?= CFS()->get('product_catalog_compare', 23) ?> alt="Сравнить" class="product_btn_compare">
			</div>
		</div>
	</div>
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	// do_action( 'woocommerce_after_single_product_summary' );

	
	echo '<h2 class="prod_attrs_cols_header">Характеристики</h2>';
	echo '<div class="prod_attrs_cols_wrapper">';
	foreach($product_attributes as $key=>$product_attribute){
		echo '<div class="prod_attrs_col">';
		echo '<p class="prod_label">'.$product_attribute['label'].'</p>';
		echo '<p class="prod_filler"></p>';
		echo '<p>'.$product_attribute['value'].'</p>';
		echo '</div>';
	}
	echo "<br><br>";
	echo '</div>';

	$single_prod_docs = get_post_meta( $product->get_id(), 'document_attrs', true );
	if(!empty($single_prod_docs)){ ?>

		<div class="single_prod_docs_wrapper">
			<h2 class="single_prod_docs_header">Документы</h2>
			<div class="single_prod_docs_content">
				<?php
					foreach($single_prod_docs as $single_prod_doc){
						if(!empty($single_prod_doc['file'])){
					?>
					<a href="<?= wp_get_attachment_url($single_prod_doc['file']) ?>" download class="single_prod_doc_card_link">
						<div class="single_prod_doc_card">
							<img src="<?= wp_get_attachment_thumb_url($single_prod_doc['img']) ?>" alt="" class="single_prod_doc_img">
							<div class="single_prod_doc_text_wrapper">
								<p class="single_prod_doc_text"><?= $single_prod_doc['descr'] ?></p>
								<p class="single_prod_doc_size"><?= $single_prod_doc['filesize'] ?></p>
							</div>
						</div>
					</a>
				<?php
						}
					}
				?>
			</div>
		</div>

	<?php
	}

	$notice = get_post_meta( $product->get_id(), 'single_prod_notice', true );
	if(isset ($notice) && $notice !== ''){
	?>

	

	<div class="single_prod_notice section">
		<img src="<?= CFS()->get('single_prod_params_notice_icon', 23) ?>" alt="" class="single_prod_notice_img">
		<div class="single_prod_params_notice_text_wrapper">
			<h3 class="single_prod_params_notice_header"><?= CFS()->get('single_prod_params_notice_header', 23) ?></h3>
			<p class="single_prod_params_notice_text"><?= $notice ?></p>
		</div>
	</div>
	<?php } ?>
	
	<div class="single_prod_adv_wrapper section">
		<?php
			$advs = CFS()->get('single_prod_params_notice_adv_cycle', 23);
			foreach($advs as $adv){ ?>
				<div class="single_prod_adv_card">
					<img src="<?= $adv['single_prod_params_notice_adv_icon'] ?>" alt="$adv['single_prod_params_notice_adv_header']" class="single_prod_adv_img">
					<div class="single_prod_adv_text_wrapper">
						<h3 class="single_prod_adv_header"><?= $adv['single_prod_params_notice_adv_header'] ?></h3>
						<p class="single_prod_adv_text"><?= $adv['single_prod_params_notice_adv_text'] ?></p>
					</div>
				</div>
		<?php
			}
		?>
	</div>


	<?php
	echo '<div class="single_prod_questions">';
	echo '<h2 class="header section">Часто задаваемые вопросы</h2>';
	echo get_post_field('post_content', 321);
	echo '</div>';
	echo '<script>
	document.addEventListener("DOMContentLoaded", ()=>{
		$(".qna_question_wrapper").on("click", (e)=>{
			$(e.target).closest(".qna_ques_n_ans_wrapper").children(".qna_answer").slideToggle(400);
			$(e.target).closest(".qna_ques_n_ans_wrapper").toggleClass("qna_answer_opened");
		})
	});
	</script>';
	?>
	<?php

	

	$cross_sels = $product->get_cross_sell_ids();
	if(isset($cross_sels) && count($cross_sels)>0 ){ ?>
		<div class="cross_sells_swiper swiper section">
			<h2 class="cross_sells_header header">С этим товаром покупают</h2>
			<div class="cross_sells_controls_wrapper">
				<div class="cross_sells_swiper_prev" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
				<div class="cross_sells_swiper_next" style=<?='"background-image: url('.CFS()->get('prod_cats_swiper_btn_icon', 23).')"'?>></div>
			</div>
			<div class="cross_sells_swiper_wrapper swiper-wrapper">
				<?php					
					foreach($cross_sels as $cross_sel) {
						$cross_prod = wc_get_product( $cross_sel );
						$is_single = get_post_meta( $cross_prod->get_id(), 'single_prod', true );
						?>

						<div class="product_card data-container swiper-slide" data-prod="<?= $cross_prod->get_id() ?>">
							<?php 
							$pred_request = get_post_meta($cross_sel, 'pred_request', true);
							if($pred_request != ''){
								$span = '<span class="prod_in_order_pred">'.$pred_request.'</span>';
							} else {
								$span = '<span class="prod_in_order">Предзаказ</span>';
							}
							switch ($cross_prod->get_stock_status()) {
								case 'onbackorder': echo $span; break;
								case 'instock': echo '<span class="prod_in_stok">В наличии</span>'; break;
								case 'outofstock': echo '<span class="prod_not_in_stok">Нет в наличии</span>'; break;
							}
							?>
							<a href="<?= get_the_permalink($cross_sel) ?>">
								<img src=<?= get_the_post_thumbnail_url($cross_sel) ?> class='product_img' alt="">
								<p class='product_title'><?= get_the_title($cross_sel); ?></p>
							</a>
							<?php if($is_single !== 'yes') { ?>
								<p class='product_price'>От <?= $cross_prod->get_price().' &#8381;'; ?>/м2</p>
							<?php
							} else { ?>
								<p class='product_price'><?= $cross_prod->get_price().' &#8381;'; ?></p>
							<?php } ?>
							<div class="product_btns_wrapper">
							<?php	
								if( is_product_in_cart($cross_sel) )  { ?>
									<button class="single_add_to_cart_button single_add_to_cart_button_in_cart" value="<?= $cross_prod->get_id();?>" data-sku="<?= $cross_prod->get_sku() ?>">
									<?php
										echo !empty($single_prod_cart_icon) ? '<img src="'.$single_prod_cart_icon.'" alt="" class="single_add_to_cart_button_img">' : "";
									?>
									В корзине
									</button>
								<?php
								} else {?>
								<button class="single_add_to_cart_button" value="<?= $cross_prod->get_id();?>" data-sku="<?= $cross_prod->get_sku() ?>">
									<?php
										echo !empty($single_prod_cart_icon) ? '<img src="'.$single_prod_cart_icon.'" alt="" class="single_add_to_cart_button_img">' : "";
									?>
									В корзину
								</button>
								
								<? } ?>
							</div>
						</div>

				<?php		
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="sucsess_wrapper">
		<div class="cover"></div>
		<div class="sucsess_wrapper_content">
			<img class="sucsess_wrappe_close" src=<?= CFS()->get('product_catalog_filter_close', 23) ?> alt="">
			<img class="sucsess_wrapper_img" src="<?= CFS()->get('cart_cheout_ok',23)?>" alt="">
			<p class="sucsess_wrapper_text">Товар успешно добавлен в корзину</p>
			<div class="sucsess_wrapper_btns">
				<button class="sucsess_wrapper_continue" type="button">Продолжить покупки</button>
				<a class="sucsess_wrapper_to_cart" href="<?= wc_get_cart_url() ?> ">Оформить заказ</a>
			</div>
		</div>
	</div>
</div>

<?php // do_action( 'woocommerce_after_single_product' ); ?>