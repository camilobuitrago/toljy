<?php
/**
 * Template Name: Portfolio
 *
 *
 * The portfolio template showcases your portfolio items.
 * @package Epsilon WordPress Theme
 * @since 1.0
 * @author AJ Clarke : http://wpexplorer.com
 * @copyright Copyright (c) 2012, AJ Clarke
 * @link http://wpexplorer.com
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

get_header(); // Loads the header.php template

//start page loop
if (have_posts()) : while (have_posts()) : the_post();

//get portfolio cat option
if ( get_post_meta( $post->ID, 'wpex_portfolio_page_category', true ) !== '' ) {
	$wpex_portfolio_tax_query = array(
			array(
				  'taxonomy' => 'portfolio_cats',
				  'field' => 'id',
				  'terms' => get_post_meta($post->ID, 'wpex_portfolio_page_category', true )
				  )
			);
} else { $wpex_portfolio_tax_query = NULL; } ?>

<header id="page-heading">
	<h1><?php the_title(); ?></h1>
</header><!-- /page-heading -->

<?php
//show page content if not empty
if( !empty( $post->post_content ) ) { ?>
	<div id="portfolio-description" class="clearfix">
		<?php the_content(); ?>
	</div><!-- /portfolio-description -->
<?php } ?>

<div id="portfolio-template">    
    <div id="portfolio-wrap">
    	<div id="portfolio-filter-content" class="portfolio-content clearfix">
			<?php
            //get post type ==> portfolio
            query_posts(
				array(
					'post_type'=>'portfolio',
					'posts_per_page' => $data['portfolio_pagination'],
					'paged'=>$paged,
					'tax_query' => $wpex_portfolio_tax_query,
            	)
			);
			// If there are posts load the loop-portfolio.php file
			// which contains the layout for single portfolio posts for each post in the loop
            while (have_posts()) : the_post();
				get_template_part('content','portfolio');
			endwhile; ?>
		</div><!-- /portfolio-filter-content -->
        <?php wpex_pagination(); // Paginate your pages ?>
		<?php wp_reset_query(); // Rest the query to avoid any conflicts ?>
    </div><!-- /portfolio-wrap -->
</div><!-- /portfolio-template -->
<?php
endwhile;
endif;
get_footer(); // Loads the footer.php file ?>