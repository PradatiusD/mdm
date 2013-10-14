<?php
/**
 * Used for your clients entries
 *
 * @package WordPress
 * @subpackage Thunder
 * @since Thunder 1.0
 */
?>

<?php global $wpex_count; ?>
<article id="post-<?php the_ID(); ?>" class="client-entry <?php echo wpex_grid_class( wpex_get_data( 'clients_columns','5' ) ); ?> col col-<?php echo $wpex_count-1; ?>">
	<?php
	// Display client item with link
	if ( get_post_meta( get_the_ID(), 'wpex_post_url', TRUE ) !== '' ) { ?>
		<a href="<?php echo get_post_meta( get_the_ID(), 'wpex_post_url', TRUE ); ?>" title="<?php the_title(); ?>" <?php if ( wpex_get_data( 'client_tooltip',' 1' ) == '1' ) echo 'class="wpex-tipsy-s"'; ?> target="_blank" rel="nofollow"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" alt="<?php echo the_title(); ?>" /></a>
	<?php } else {
		// No link display logo only ?>
		<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" alt="<?php echo the_title(); ?>" />
	<?php } ?>
</article><!-- client-entry -->