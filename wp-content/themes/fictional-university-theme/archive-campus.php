<?php get_header(); ?>
<?php pageBanner(array(
  'title' => 'Our Campuses',
  'subtitle' => 'We have several conveniently located campuses',
)); ?>

<div class="container container--narrow page-section">
  <div id="all-campuses-map" style="height: 500px; margin-bottom: 2rem;">

  </div>

  <ul class="link-list min-list">
    <?php 
    $locations = [];
    while (have_posts()) {
      the_post();
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
      <?php
    }
    ?>
  </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var map = L.map('all-campuses-map').setView([31.0759049,-7.568194,7], 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  var bounds = [];

  const locations = <?= json_encode($locations); ?>;

  locations.forEach(function(loc) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${loc.lat}&lon=${loc.lng}`)
  .then(response => response.json())
  .then(data => {
    var address = data.display_name;

    var marker = L.marker([loc.lat, loc.lng]).addTo(map)
      .bindPopup(
        '<strong>' + loc.title + '</strong><br>' +
        address + '<br>' +
        '<a href="' + loc.link + '">View Campus</a>'
      );

    bounds.push([loc.lat, loc.lng]);
  })
  .catch(error => {
    console.error('Geocoding error:', error);
});

  });

  if (bounds.length > 0) {
    map.fitBounds(bounds, { padding: [30, 30] });
  }
});
</script>

<?php get_footer(); ?>
