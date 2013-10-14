<?php
/**
 * Template Name: Home
 *
 * @package WordPress
 * @subpackage Thunder WordPress Theme 
*/
?>
 
<?php get_header(); ?>

	<section id="primary" class="content-area full-width clr">
		<div id="content" class="site-content" role="main">

		<?php
		//get homepage module blocks
		global $smof_data;
		$home_blocks = $smof_data['homepage_blocks']['enabled'];
		
		if ($home_blocks) :
		
			foreach ($home_blocks as $key=>$value) :
				
				switch($key) {
					
					
       
					/***************************
					* Slider
					***************************/
					case 'home_slider': ?>
				
						<?php wpex_page_slider(); //see functions/page-slider.php  ?>
		
		
					<?php
					/***************************
					* Features
					***************************/
					break;
					case 'home_features': ?>
					
						<?php
						// Get cached query if query cache is enabled
						$home_features_query = ( wpex_get_data( 'cache_queries' ) == '1' ) ? get_transient ( 'home_features_query' ) : NULL;
							
						
						//Check for cached query, if there is none create it
						if ( !$home_features_query || isset( $_GET['clear-cache'] ) ) {
						
							// Get Features
							$home_features_query = new WP_Query(
								array(
									'post_type'		=> 'features',
									'showposts'		=> '-1',
									'order'			=> 'DESC',
									'no_found_rows'	=> true,
								)
							);
							
							// Cache query for 4 hours if  query cache is enabled - set transient
							if ( wpex_get_data( 'cache_queries' ) == '1' ) {
								set_transient( 'home_features_query', $home_features_query, 4*60*60 );
							}
						
						}
						
					   // Display features
					   if( $home_features_query->posts ) { ?>
							
							<section id="home-features-module" class="home-features clr style-<?php echo wpex_get_data( 'home_features_style' ); ?>">
								<div class="container clr">   
									<?php $wpex_count=0; ?>
									<?php foreach( $home_features_query->posts as $post ) : setup_postdata( $post ); ?>
									<?php $wpex_count++; ?>
										<article id="#post-<?php the_ID(); ?>" <?php post_class( 'feature-entry clr col '. wpex_grid_class( wpex_get_data( 'home_features_columns', '3' ) ) .' col-'. $wpex_count ); ?>>
                                        	<?php if ( get_post_meta( get_the_ID(), 'wpex_post_url', TRUE ) !== '' ) { ?>
                                            	<a href="<?php echo get_post_meta( get_the_ID(), 'wpex_post_url', TRUE ); ?>" title="" target="<?php echo get_post_meta( get_the_ID(), 'wpex_post_url_target', TRUE); ?>">
                                            <?php } ?>
											<div class="feature-entry-media clr <?php if ( has_post_thumbnail() ) echo 'with-thumb'; ?>">
												<?php if ( has_post_thumbnail() ) { ?>
													<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" alt="<?php echo the_title(); ?>" />
												<?php } ?>
												<?php if ( get_post_meta( get_the_ID(), 'wpex_feature_icon_font', true ) !== '' && get_post_meta( get_the_ID(), 'wpex_feature_icon_font', true ) !== 'None' ) { ?>
													<i class="feature-entry-icon icon-<?php echo get_post_meta( get_the_ID(), 'wpex_feature_icon_font', true );?>" <?php wpex_font_icon_color(); ?>></i>
												<?php } ?>
											</div><!-- .feature-entry-thumbnail -->
                                            <?php if ( get_post_meta( get_the_ID(), 'wpex_post_url', TRUE) !== '' ) echo '</a>'; ?>
											<div class="feature-entry-content clr">
                                            	<?php if ( get_post_meta( get_the_ID(), 'wpex_post_url', TRUE ) !== '' ) { ?>
                                            		<h2><a href="<?php echo get_post_meta( get_the_ID(), 'wpex_post_url', TRUE ); ?>" title="" target="<?php echo get_post_meta( get_the_ID(), 'wpex_post_url_target', TRUE); ?>"><?php the_title(); ?></a></h2>
                                            	<?php } else { ?>
                                            		<h2><?php the_title(); ?></h2>
												<?php } ?>
												<?php the_content(); ?>
											</div><!-- .feature-entry-content -->
										</article><!-- .feature-entry -->
										<?php if ( $wpex_count == wpex_get_data( 'home_features_columns', '3' ) ) { ?>
											<?php $wpex_count=0; ?>
										<?php } ?>
									<?php endforeach; ?>
								</div><!-- .recent-features -->  
							</section><!-- #home-features -->
								
						<?php } ?>
						
						<?php wp_reset_postdata(); ?>
					
					
					<?php
					/***************************
					* Portfolio
					***************************/
					break;
					case 'home_portfolio': ?>
					
						<?php
						// Get cached query if query cache is enabled
						$home_portfoliofolio_query = ( wpex_get_data( 'cache_queries' ) == '1' ) ? get_transient ( 'home_portfoliofolio_query' ) : NULL;
						
						//Check for cached query, if there is none create it
						if ( !$home_portfoliofolio_query || isset( $_GET['clear-cache'] ) ) {
							
							// Setup tax query if needed
							if ( wpex_get_data('home_portfolio_cat') !== '' && wpex_get_data('home_portfolio_cat') !== 'All' ) {
								$wpex_tax_query = array(
									array (
										'taxonomy'	=> 'portfolio_category',
										'field'		=> 'slug',
										'terms'		=> wpex_get_data('home_portfolio_cat')
									)
								);
							} else { $wpex_tax_query = NULL; }
						
							// Get Portfolio Posts
							$home_portfoliofolio_query = new WP_Query(
								array(
									'post_type'		=> 'portfolio',
									'showposts'		=> wpex_get_data( 'home_portfolio_count', '8' ),
									'order'				=> 'DESC',
									'no_found_rows'	=> true,
									'tax_query'		=> $wpex_tax_query
								)
							);
							
							// Cache query for 4 hours if  query cache is enabled - set transient
							if ( wpex_get_data( 'cache_queries' ) == '1' ) {
								set_transient( 'home_portfoliofolio_query', $home_portfoliofolio_query, 4*60*60 );
							}
							
						}
						
						if( $home_portfoliofolio_query->posts ) { ?>
								   
							<section id="home-portfolio-module" class="home-portfolio <?php if ( wpex_get_data( 'home_portfolio_fade' ,'1' ) == '1' ) { echo 'fade-in-section'; } ?> clr style-<?php echo wpex_get_data( 'home_portfolio_style' ); ?>">
								<div class="container clr">
									<?php
									// Display portfolio heading if enabled
                                    if ( wpex_get_data('home_portfolio_heading_enable','1') == '1' ) { ?>
										<h2 class="home-portfolio-heading">
											<span><?php echo wpex_get_data('home_portfolio_heading', __('Recent Work','wpex') ); ?></span>
											<?php
											// Display portfolio browse all button if set in the admin
                                            if ( wpex_get_data('home_portfolio_btn_url') !== '' ) { ?>
												<a href="<?php echo wpex_get_data('home_portfolio_btn_url'); ?>" title="<?php echo wpex_get_data( 'home_portfolio_btn_text', __( 'Browse All', 'wpex' ) ); ?>"><?php echo wpex_get_data( 'home_portfolio_btn_text', __( 'Browse All', 'wpex' ) ); ?></a>
											<?php } ?>
										</h2><!-- .home-portfolio-heading -->
									<?php } ?>
                                    <?php $wpex_portfolio_entry_details = false; ?>
									<?php $wpex_count=0; ?>
									<?php
									// Loop through the portfolio items
                                    foreach( $home_portfoliofolio_query->posts as $post ) : setup_postdata( $post ); ?>
										<?php $wpex_count++; ?>
										<?php
										// Get the portfolio entry content file
                                        get_template_part( 'content-portfolio', get_post_format() ); ?>
										<?php
										// Clear floats and reset post counter
                                        if( $wpex_count == wpex_get_data( 'portfolio_columns','4' ) ) { echo '<div class="clr"></div>'; $wpex_count=0; } ?>
									<?php endforeach; ?>
								</div><!-- .container -->  
							</section><!--.home-portfolio -->      
								
						<?php } ?>
						
						<?php wp_reset_postdata(); ?>
					
					
					<?php
					/***************************
					* Page Content
					***************************/
					break;
					case 'home_content': ?>
					
						<?php while ( have_posts() ) : the_post(); ?>
							<div id="home-content-module" class="home-page-content clr">
								<div class="container clr">
									<?php the_content(); ?>
								</div><!-- .container -->
							</div><!-- .home-page-content -->
						<?php endwhile; ?>
					
					
					<?php
					/***************************
					* Blog
					***************************/
					break;
					case 'home_blog': ?>
					
						<?php
						// Get cached query if query cache is enabled
						$home_blog_query = ( wpex_get_data( 'cache_queries' ) == '1' ) ? get_transient ( 'home_blog_query' ) : NULL;
						
						//Check for cached query, if there is none create it
						if ( !$home_blog_query || isset( $_GET['clear-cache'] ) ) {
							
							// Setup tax query if needed
							if ( wpex_get_data('home_blog_cat') !== '' && wpex_get_data('home_blog_cat') !== 'All' ) {
								$wpex_tax_query = array(
										'taxonomy'	=> 'category',
										'field'		=> 'slug',
										'terms'		=> wpex_get_data('home_blog_cat')
									);
							} else { $wpex_tax_query = NULL; }
						
							// Get Blog Posts
							$home_blog_query = new WP_Query(
								array(
									'post_type'		=> 'post',
									'showposts'		=> wpex_get_data( 'home_blog_count', '3' ),
									'order'			=> 'DESC',
									'no_found_rows'	=> true,
									'tax_query'		=> array (
										 'relation'	=> 'AND',
										 $wpex_tax_query,
										 array (
											 'taxonomy'	=> 'post_format',
											 'field' 	=> 'slug',
											 'terms' 	=> array( 'post-format-quote', 'post-format-link' ),
											 'operator'	=> 'NOT IN',
										),
									)
								)
							);
							
							// Cache query for 4 hours if  query cache is enabled - set transient
							if ( wpex_get_data( 'cache_queries' ) == '1' ) {
								set_transient( 'home_blog_query', $home_blog_query, 4*60*60 );
							}
							
						}
						
						if( $home_blog_query->posts ) { ?>
								   
							<section id="home-blog-module" class="home-blog clr style-<?php echo wpex_get_data( 'home_blog_style' ); ?>">
								<div class="container <?php if ( wpex_get_data( 'home_blog_fade' ,'1' ) == '1' ) { echo 'fade-in-section'; } ?> clr">
									<?php if ( wpex_get_data('home_blog_heading_enable','1') == '1' ) { ?>
										<h2 class="home-blog-heading">
											<span><?php echo wpex_get_data('home_blog_heading', __('Latest News','wpex') ); ?></span>
											<?php if ( wpex_get_data('home_blog_btn_url') !== '' ) { ?>
												<a href="<?php echo wpex_get_data('home_blog_btn_url'); ?>" title="<?php echo wpex_get_data( 'home_blog_btn_text', __( 'Browse All', 'wpex' ) ); ?>"><?php echo wpex_get_data( 'home_blog_btn_text', __( 'Browse All', 'wpex' ) ); ?></a>
											<?php } ?>
										</h2><!-- .home-blog-heading -->
									<?php } ?>
									<?php $wpex_count=0; ?>
									<?php foreach( $home_blog_query->posts as $post ) : setup_postdata( $post ); ?>
										<?php $wpex_count++; ?>
											<article id="post-<?php the_ID(); ?>" class="home-blog-entry clr span_1_of_3 col col-<?php echo $wpex_count; ?>">
												<?php if ( has_post_thumbnail() ) { ?>
													<div class="home-blog-entry-media">
														<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><img src="<?php echo aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), '316',  '159',  'true' ) ?>" alt="<?php echo the_title(); ?>" /></a>
													</div><!-- .home-blog-entry-media -->
												<?php } ?>
												<h3><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
												<?php wpex_excerpt( '20' ); ?>
											</article>
										<?php if( $wpex_count == '3' ) { echo '<div class="clr"></div>'; $wpex_count=0; } ?>
									<?php endforeach; ?>
								</div><!-- .container -->  
							</section><!-- .home-blog -->
								
						<?php } ?>
						
						<?php wp_reset_postdata(); ?>
					
					
					<?php
					/***************************
					* Testimonials
					***************************/
					break;
					case 'home_testimonials': ?>
					
						<?php
						// Get cached query if query cache is enabled
						$home_testimonials_query = ( wpex_get_data( 'cache_queries' ) == '1' ) ? get_transient ( 'home_testimonials_query' ) : NULL;
						
						//Check for cached query, if there is none create it
						if ( !$home_testimonials_query || isset( $_GET['clear-cache'] ) ) {
						
							// Get Features
							$home_testimonials_query = new WP_Query(
								array(
									'post_type'		=> 'testimonials',
									'showposts'		=> wpex_get_data( 'home_testimonials_count', '10' ),
									'order'				=> 'DESC',
									'no_found_rows'	=> true,
									'meta_query' 		=> array(
										array(
											'key' => '_thumbnail_id',
										)
									),
								)
							);
							
							// Cache query for 4 hours if  query cache is enabled - set transient
							if ( wpex_get_data( 'cache_queries' ) == '1' ) {
								set_transient( 'home_testimonials_query', $home_testimonials_query, 4*60*60 );
							}
							
						}
						
					   // Display features
					   if( $home_testimonials_query->posts ) { ?>
						
							<section id="home-testimonials-module" class="home-testimonials clr style-<?php echo wpex_get_data( 'home_testimonials_style' ); ?>">
                            	<?php if ( wpex_get_data( 'home_testimonials_heading_enable', '1' ) == '1' ) { ?>
                                    <header class="home-testimonials-header container clr">
                                        <h2 class="home-testimonials-heading">
                                            <?php echo wpex_get_data('home_testimonials_heading', __( 'Testimonials From Our Clients', 'wpex' ) ); ?>
                                        </h2>
                                        <div class="home-testimonials-subheading"><?php echo wpex_get_data( 'home_blog_subheading', __( 'See what people are saying about our work', 'wpex' ) ); ?></div>
                                    </header>
                                <?php } ?>
								<div class="testimonials-slider flexslider-container clr">
									<div class="flexslider clr">
										<ul class="slides">
											<?php foreach( $home_testimonials_query->posts as $post ) : setup_postdata( $post ); ?>
											<li data-thumb="<?php echo aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), '50', '50', true ); ?>">
												<article class="home-testimonial-entry container clr">
													<div class="home-testimonial-entry-content clr">
														<?php the_content(); ?>
													</div><!-- .home-testimonial-entry-content-->
													<?php if ( get_post_meta( get_the_ID(), 'wpex_testimonial_author', true ) !== '' ) { ?>
														<div class="home-testimonial-entry-author">
															<?php echo get_post_meta( get_the_ID(), 'wpex_testimonial_author', true ); ?>
														</div><!-- home-testimonial-entry-author -->
													<?php } ?>
												</article><!-- .home-testimonial-entry -->
											</li>    
											<?php endforeach; ?>                            
										</ul><!-- .slides -->
									</div><!-- .flexslider -->
								</div><!-- .testimonials-slider -->
							</section><!-- .home-testimonials -->
						
						<?php } ?>
						
						<?php wp_reset_postdata(); ?>
					
                    
                    
                    <?php
					/***************************
					* Clients
					***************************/
					break;
					case 'home_clients': ?>
					
						<?php
						// Get cached query if query cache is enabled
						$home_clients_query = ( wpex_get_data( 'cache_queries' ) == '1' ) ? get_transient ( 'home_clients_query' ) : NULL;
						
						//Check for cached query, if there is none create it
						if ( !$home_clients_query || isset( $_GET['clear-cache'] ) ) {
							
							// Setup tax query if needed
							if ( wpex_get_data('home_clients_cat') !== '' && wpex_get_data('home_clients_cat') !== 'All' ) {
								$wpex_tax_query = array( array(
										'taxonomy'	=> 'clients_category',
										'field'		=> 'slug',
										'terms'		=> wpex_get_data('home_clients_cat')
									),
								);
							} else { $wpex_tax_query = NULL; }
						
							// Get Features
							$home_clients_query = new WP_Query(
								array(
									'post_type'		=> 'clients',
									'showposts'		=> wpex_get_data( 'home_clients_count', '10' ),
									'order'			=> 'DESC',
									'no_found_rows'	=> true,
									'tax_query'		=> $wpex_tax_query,
									'meta_query' 	=> array(
										array(
											'key' => '_thumbnail_id',
										)
									),
								)
							);
							
							// Cache query for 4 hours if  query cache is enabled - set transient
							if ( wpex_get_data( 'cache_queries' ) == '1' ) {
								set_transient( 'home_clients_query', $home_clients_query, 4*60*60 );
							}
							
						}
						
					   // Display features
					   if( $home_clients_query->posts ) { ?>					
							<section id="home-clients-module" class="home-clients clr style-<?php echo wpex_get_data( 'home_clients_style' ); ?>">
                            	<?php if ( wpex_get_data( 'home_clients_heading_enable', '1' ) == '1' ) { ?>
                                    <header class="home-clients-header container clr">
                                        <h2 class="home-clients-heading">
                                            <span>Brands we carry</span>
                                        </h2>
                                    </header>
                                <?php } ?>
								<div class="home-clients-grid container <?php if ( wpex_get_data( 'home_clients_fade' ,'1' ) == '1' ) { echo 'fade-in-home-clients fade-in-down'; } ?> clr">
                                	<?php $wpex_count; ?>
									<?php foreach( $home_clients_query->posts as $post ) : setup_postdata( $post ); ?>
                                    	<?php $wpex_count++; ?>
                                    		<?php get_template_part( 'content', 'clients' ); ?>
                                        <?php if( $wpex_count == wpex_get_data( 'clients_columns', '5' ) ) $wpex_count=0; ?>
                                    <?php endforeach; ?>
								</div><!-- .home-clients-grid -->
							</section><!-- .home-clients -->						
						<?php } ?>					
					<?php wp_reset_postdata(); ?>
                                       
                    <?php
					/***************************
					* Products
					***************************/
					break;
					case 'home_products': ?>
					
						<?php
						// Get cached query if query cache is enabled
						$home_products_query = ( wpex_get_data( 'cache_queries' ) == '1' ) ? get_transient ( 'home_products_query' ) : NULL;
						
						//Check for cached query, if there is none create it
						if ( !$home_products_query || isset( $_GET['clear-cache'] ) ) {
							
							// Setup tax query if needed
							if ( wpex_get_data('home_products_cat') !== '' && wpex_get_data('home_products_cat') !== 'All' ) {
								$wpex_tax_query = array( array(
										'taxonomy'	=> 'product_cat',
										'field'		=> 'slug',
										'terms'		=> wpex_get_data('home_products_cat'),
									)
								);
							} else { $wpex_tax_query = NULL; }
						
							// Get Features
							$home_products_query = new WP_Query(
								array(
									'post_type'		=> 'product',
									'showposts'		=> wpex_get_data( 'home_products_count', '3' ),
									'order'			=> 'DESC',
									'no_found_rows'	=> true,
									'tax_query'		=> $wpex_tax_query,
								)
							);
							
							// Cache query for 4 hours if  query cache is enabled - set transient
							if ( wpex_get_data( 'cache_queries' ) == '1' ) {
								set_transient( 'home_products_query', $home_products_query, 4*60*60 );
							}
							
						}
						
					   // Display features
					   if( $home_products_query->posts ) { ?>					
							<section id="home-products-module" class="home-products clr style-<?php echo wpex_get_data( 'home_products_style' ); ?>">
                            	<?php if ( wpex_get_data( 'home_products_heading_enable', '1' ) == '1' ) { ?>
                                    <header class="home-products-header container clr">
                                        <h2 class="home-products-heading">
                                            <span><?php echo wpex_get_data('home_products_heading', __( 'Newest Products', 'wpex' ) ); ?></span>
                                        </h2>
                                    </header>
                                <?php } ?>
								<div class="home-products-grid container clr">
                                	<?php $wpex_count; ?>
									<?php foreach( $home_products_query->posts as $post ) : setup_postdata( $post ); ?>
                                    	<?php $wpex_count++; ?>
                                    		<article id="post-<?php the_ID(); ?>" class="home-product-entry <?php echo wpex_grid_class( wpex_get_data( 'products_columns','3' ) ); ?> col col-<?php echo $wpex_count; ?>">
												<?php if ( has_post_thumbnail() ) { ?>
                                                    <div class="home-product-entry-media">
                                                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><img src="<?php echo aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), wpex_img('product_entry_width'),  wpex_img('product_entry_height'),  wpex_img('product_entry_crop') ) ?>" alt="<?php echo the_title(); ?>" /></a>
                                                    </div><!-- .home-product-entry-media -->
                                                    <div class="home-product-entry-content clr">
                                                        <header>
                                                            <h3 class="home-product-entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                                        </header>
                                                        <?php global $product; ?>
                                                        <?php if ( $product->get_price_html() ) { ?>
                                                        	<div class="home-product-entry-price">
																<?php echo $product->get_price_html(); ?>
                                                            </div><!-- .home-product-entry-price -->
                                                        <?php } ?>
                                                    </div><!-- .home-product-entry-content -->
                                                <?php } ?>
                                            </article><!-- .home-product-entry -->
                                        <?php if( $wpex_count == wpex_get_data( 'home_products_columns','3' ) ) { echo '<div class="clr"></div>'; $wpex_count=0; } ?>
                                    <?php endforeach; ?>
								</div><!-- .home-products-grid -->
							</section><!-- .home-products -->						
						<?php } ?>					
					<?php wp_reset_postdata(); ?>
					
					
					<?php
					/***************************
					* Callout
					***************************/
					break;
					case 'home_callout': ?>
					
						<section id="home-callout-module" class="home-callout">
							<div class="container clr">
								<?php echo do_shortcode( wpex_get_data( 'home_callout' ) ); ?>
							</div><!-- .container -->
						</section><!-- .home-callout -->
                        
                        
                    <?php
					/***************************
					* Custom Modules
					***************************/
					break;
					case 'home_custom_one' :
					
						if ( wpex_get_data( 'custom_modules', '1' ) == '1' ) {
							$wpex_module_layout = ( wpex_get_data( 'home_custom_one_layout', 'centered' ) == 'centered' ) ? 'container' : NULL;
							echo '<section  class="home-custom-module-one clr '. $wpex_module_layout .' entry">';
								// custom module text option
								echo apply_filters( 'the_content', wpex_get_data( 'home_custom_one' ) );
								// custom module get page
								if ( wpex_get_data( 'home_custom_one_page', 'None' ) !== 'None' ) {
									wpex_display_page_content( $slug = wpex_get_data( 'home_custom_one_page' ) ); // see functions/commons.php
								}
							echo '</section>';
						}
					
					break;
					case 'home_custom_two' :
					
						if ( wpex_get_data( 'custom_modules', '1' ) == '1' ) {
							$wpex_module_layout = ( wpex_get_data( 'home_custom_two_layout', 'centered' ) == 'centered' ) ? 'container' : NULL;
							echo '<section  class="home-custom-module-two clr '. $wpex_module_layout .' entry">';
								// custom module text option
								echo apply_filters( 'the_content', wpex_get_data( 'home_custom_two' ) );
								// custom module get page
								if ( wpex_get_data( 'home_custom_two_page', 'Ntwo' ) !== 'Ntwo' ) {
									wpex_display_page_content( $slug = wpex_get_data( 'home_custom_two_page' ) ); // see functions/commons.php
								}
							echo '</section>';
						}
						
					
					break;	
					case 'home_custom_three' :
					
						if ( wpex_get_data( 'custom_modules', '1' ) == '1' ) {
							$wpex_module_layout = ( wpex_get_data( 'home_custom_three_layout', 'centered' ) == 'centered' ) ? 'container' : NULL;
							echo '<section  class="home-custom-module-three clr '. $wpex_module_layout .' entry">';
								// custom module text option
								echo apply_filters( 'the_content', wpex_get_data( 'home_custom_three' ) );
								// custom module get page
								if ( wpex_get_data( 'home_custom_three_page', 'Nthree' ) !== 'Nthree' ) {
									wpex_display_page_content( $slug = wpex_get_data( 'home_custom_three_page' ) ); // see functions/commons.php
								}
							echo '</section>';
						}
					
					break;	
					case 'home_custom_four' :
					
						if ( wpex_get_data( 'custom_modules', '1' ) == '1' ) {
							$wpex_module_layout = ( wpex_get_data( 'home_custom_four_layout', 'centered' ) == 'centered' ) ? 'container' : NULL;
							echo '<section  class="home-custom-module-four clr '. $wpex_module_layout .' entry">';
								// custom module text option
								echo apply_filters( 'the_content', wpex_get_data( 'home_custom_four' ) );
								// custom module get page
								if ( wpex_get_data( 'home_custom_four_page', 'Nfour' ) !== 'Nfour' ) {
									wpex_display_page_content( $slug = wpex_get_data( 'home_custom_four_page' ) ); // see functions/commons.php
								}
							echo '</section>';
						}
					
					break;	
					case 'home_custom_five' :
					
						if ( wpex_get_data( 'custom_modules', '1' ) == '1' ) {
							$wpex_module_layout = ( wpex_get_data( 'home_custom_five_layout', 'centered' ) == 'centered' ) ? 'container' : NULL;
							echo '<section  class="home-custom-module-five clr '. $wpex_module_layout .' entry">';
								// custom module text option
								echo apply_filters( 'the_content', wpex_get_data( 'home_custom_five' ) );
								// custom module get page
								if ( wpex_get_data( 'home_custom_five_page', 'Nfive' ) !== 'Nfive' ) {
									wpex_display_page_content( $slug = wpex_get_data( 'home_custom_five_page' ) ); // see functions/commons.php
								}
							echo '</section>';
						}
                        
					?>
                        
					<?php } // end switch($key) ?>
					
				<?php endforeach; ?>
            
            <?php endif; ?>
    
   		</div><!-- #content -->
	</section><!-- #primary -->
 
<?php get_footer(); ?>