<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
if ( have_posts() ) {
	?>
	<div class="page_wrapper search_page">
	<header class="page-header">
		<h1 class="page-title header">
			<?php
			printf(
				/* translators: %s: Search term. */
				'Результаты поиска по запросу - %s',
				esc_html( get_search_query() )
			);
			?>
		</h1>
	</header><!-- .page-header -->

	<?php
	// Start the Loop.
	$search_results = [];
	while ( have_posts() ) {
		the_post();
		$search_elem = get_product($post->ID);
// 		print_r($post->ID);
		if($search_elem){
		    $search_results['p'][] = $search_elem;
		} else {
		    $search_results['o'][] = $post;
		}

		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
	} // End the loop.
	if(isset($search_results['p'])){
	    if(isset($search_results['o'])){
	        echo '<h2 class="search_prods_header">Товары</h2>';
	    }
	    echo '<div class="product_cards_wrapper">';
        foreach ($search_results['p'] as $search_result_p) {
            get_product_card($search_result_p);
        }
        echo '</div>';
	}
	if(isset($search_results['o'])){
	    if (isset($search_results['p'])){
	        echo '<h2 class="search_other_header">Другое</h2>';
	    }?>
	    <ol class="styled_list search_other_list">
	        <?php foreach ($search_results['o'] as $search_resulto){
	        $oid = $search_resulto->ID;
	        ?>
	        
	        <li class="search_other_list_elem">
	            
	            <?= '<a href="'.get_the_permalink($oid).'">'.get_the_title($oid).'</a>'; ?>
	        </li>
	        <?php } ?>
	    </ol>
	<?php
	}
	// Previous/next page navigation.
	// twenty_twenty_one_the_posts_navigation();

	// If no content, include the "No posts found" template.
	echo '</div>';
} else {
    
} ?>
    </div>
<?php
get_footer();