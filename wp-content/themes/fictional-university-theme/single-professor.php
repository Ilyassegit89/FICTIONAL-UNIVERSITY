<?php

  
  get_header();

  while(have_posts()) {
    the_post(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php 
    $pageBannerImage = get_field('page_banner_background_image');
    echo $pageBannerImage['sizes']['pageBanner'] ;
    ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p><?php the_field('page_banner_subtitle'); ?></p>
      </div>
    </div>  
</div>

  <div class="container container--narrow page-section">
  
      <div class="generic-content">
        <div class="row group">

          <div class="one-third">
            <?php the_post_thumbnail('professorPortrait') ?>
          </div>

          <div class="two-thirds">
            <?php 
            $likeCount = new WP_Query(
              array(
                'post_type' => 'like',
                'meta_query' => array(
                  array(
                    'key' => 'liked_professor_id',
                  'compare' => '=', 
                  'value' => get_the_ID()
                  )
                )
              )
                  );
            $existsStatus = 'No';
            if(is_user_logged_in()){
              $exitsQuery = new WP_Query(
              array(
                'post_type' => 'like',
                'meta_query' => array(
                  array(
                    'key' => 'liked_professor_id',
                  'compare' => '=', 
                  'value' => get_the_ID()
                  )
                )
              )
                  );
                  
            if($exitsQuery->found_posts){
              $existsStatus = 'yes';
            }
            }
            ?>
            <span class="like-box" data-like="<?php if (isset($existQuery->posts[0]->ID)) echo $existQuery->posts[0]->ID; ?>"

 data-professor="<?php echo get_the_ID(  ); ?>" data-exists="<?php echo $existsStatus ?>" >
              <i class="fa fa-heart-o" aria-hidden="true"></i>
              <i class="fa fa-heart" aria-hidden="true"></i>
              <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
            </span>
            <?php the_content(); ?>
          </div>

        </div>
      </div>

      <?php
      $relatedPrograms = get_field('related_programs');
      if($relatedPrograms){
        
      echo '<hr>';
      echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
      echo '<ul class="link-list min-list">';
      foreach($relatedPrograms as $program){
        ?> <li><a href="<?php echo get_the_permalink($program)?>"><?php echo get_the_title($program); ?></a></li>
      <?php }
      echo '</ul>';
      }
      
      ?>
  </div>
    
  <?php }

  get_footer();

?>