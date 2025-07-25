<?php get_header();
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world.',

));
?>

<div class="container container--narrow page-section">
   <?php 
          $homepageEvents = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'event'
          ));
          while($homepageEvents->have_posts()){
            $homepageEvents->the_post(  );?>
            

            <div class="event-summary">
                <a class="event-summary__date t-center" href="#">
                  <span class="event-summary__month"><?php 
                  $eventDate = new DateTime(get_field('event_date'));
                  echo $eventDate->format('M');
                  
                  ?></span>
                  <span class="event-summary__day"><?php 
                  $eventDate = new DateTime(get_field('event_date'));
                  echo $eventDate->format('d');
                  
                  ?></span>  
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                  <p><?php echo wp_trim_words(get_the_content(), 18)?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                </div>
            </div>
          <?php }
          
        ?>
   
</div>
<?php get_footer(); ?>