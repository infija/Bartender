<?php
/**
 * @package Aldehyde
 */
?>
<script>
    jQuery(document).ready(function() {
        jQuery('.button-reserve-single').click(function(){
            if(jQuery('.reserve-form-single').css('display')==="none"){
                jQuery('.reserve-form-single').show();
            }else{
                jQuery('.reserve-form-single').hide();
            }
        });
    });
</script>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php aldehyde_posted_on(); ?>
                        <div class="btn btn-success button-reserve-single">Reservar Cupo</div>
		</div><!-- .entry-meta -->
                <div class="reserve-form-single">
                    <form name="reservation-form" method="post">
                        <input name="first_name" type="text" placeholder="Nombre" required/>
                        <input name="last_name" type="text" placeholder="Apellido" required/>
                        <input name="ci" type="number" placeholder="CI" required/>
                        <input name="phone" type="number" placeholder="Telefono" required/>
                        <input name="post_id" type="hidden" value="<?php the_ID(); ?>">
                        <input name="action" type="hidden" value="course_reservation">
                        <input type="submit" class="btn" value="Reservar"/>
                    </form>
                </div> 
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="featured-image-single">
			<?php if (has_post_thumbnail() )
				the_post_thumbnail();
				?>
		</div>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'aldehyde' ),
				'after'  => '</div>',
			) );
		?>
             
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'aldehyde' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'aldehyde' ) );

			if ( ! aldehyde_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'aldehyde' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'aldehyde' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'aldehyde' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'aldehyde' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'aldehyde' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
