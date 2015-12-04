<script>
    jQuery(document).ready(function() {
        jQuery('#news_post').appendTo('.textwidget');
    });
</script>
<style>
    #news_post{
        height: 600px;
        overflow-y: scroll;
    }
</style>
<div id="news_post">
    <?php 

        $type = 'post';
        $args=array(
          'post_type' => $type,
          'post_status' => 'publish',
          'posts_per_page' => -1,
          'caller_get_posts'=> 1
        );

        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
          while ($my_query->have_posts()) : $my_query->the_post(); 
            $media = get_attached_media( 'image' ); ?>
                    
            <h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
            <?php
            foreach($media as &$valor){?>
                <img class="alignnone" src="<?php echo $valor->guid ?>" alt="<?php echo $valor->post_title ?>" width="70" height="70"/>
            <?php } ?>
            
            <span class="content_news"><?php the_excerpt()?></span>
            <hr>
            <?php endwhile;
        }
        wp_reset_query();  // Restore global post data stomped by the_post().

    ?>
</div>