<?php
  
  get_header();
  

  while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>

  <div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>
      <div class="generic-content"><?php the_content(); ?></div>
      <div id="all-campuses-map" style="height: 500px; margin-bottom: 2rem;">

  </div>

  <ul class="link-list min-list">
    <?php 
      
      $locations = []; 
      $lat = get_post_meta(get_the_ID(), '_leaflet_lat', true);
      $lng = get_post_meta(get_the_ID(), '_leaflet_lng', true);
     

      $locations[] = [
        'title' => get_the_title(),
        'lat' => $lat,
        'lng' => $lng,
        'link' => get_permalink(),
      ];
      
      ?>
      <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
      
  </ul>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var map = L.map('all-campuses-map').setView([31.0759049,-7.568194,7], 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);


  var bounds = [];
  const locations = <?php echo json_encode($locations); ?>;

  

  locations.forEach(function(loc){
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${loc.lat}&lon=${loc.lng}`)
  .then(response => response.json())
  .then(data => {
    var address = data.display_name;
    
    var marker = L.marker([loc.lat, loc.lng]).addTo(map)
      .bindPopup(
        '<strong>' + loc.title + '</strong><br>' + `${address}` +
          '<br>' +
        '<a href="' + loc.link + '">View Campus</a>'
      );
      bounds.push([loc.lat, loc.lng]);
  }).catch(error => {
    console.error('Geocoding error:', error);
});

    
  })

if (bounds.length > 0) {
    map.fitBounds(bounds, { padding: [30, 30] });
  }
  
});
</script>
<?php 
       /* Related Professors*/
       $relatedPrograms = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'program',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'related_campus', 
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));
          echo '<hr class="section-break">';
          
          if($relatedPrograms->have_posts()){
            echo '<h2 class="headline headline--medium">' .'Programs Available At this Campus</h2>';
            echo "<ul class='min-list link-list'>";
            while($relatedPrograms->have_posts()){
            $relatedPrograms->the_post(  );?>

            <li >
              <a href="<?php the_permalink() ; ?>">
                <?php the_title(); ?>
            </a>
          </li>
          <?php }
          echo "</ul>";
          }
          wp_reset_postdata(  );


        $today = date('Ymd');
          $homepageEvents = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'event',
            'order' => 'ASC',
            'orderby' => 'meta_value_num', 
            'meta_key' => 'event_date',
            'meta_query' => array(
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today, 
                'type' => 'numeric'
              ),
              array(
                'key' => 'related_programs', 
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));
          
          echo '<hr class="section-break">';
          
          if($homepageEvents->have_posts()){
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title(). ' Event</h2>';

            while($homepageEvents->have_posts()){
            $homepageEvents->the_post(  );?>

            <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                  <span class="event-summary__month"><?php 
                  $eventDate = new DateTime(get_field('event_date'));
                  echo $eventDate->format('M');
                  
                  ?></span>
                  <span class="event-summary__day">
                    <?php 
                  $eventDate = new DateTime(get_field('event_date'));
                  echo $eventDate->format('d');
                  
                  ?>
                  </span>  
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title();  ?></a></h5>
                  <p><?php if(has_excerpt()) {
                    echo get_the_excerpt(  );
                  } else{
                    echo wp_trim_words(get_the_content(), 18);
                  } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                </div>
            </div>
          <?php }
          }
          
        ?>

      </div>

    </div>
</div>


      
       
    
    
  <?php }

  get_footer();

?>