<?php

require get_theme_file_path('/inc/like-route.php');

require get_theme_file_path('/inc/search-route.php');

function university_custom_rest() {
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() {return get_the_author();}
  ));
  register_rest_field('note', 'userNoteCount', array(
    'get_callback' => function() {
      return count_user_posts(get_current_user_id(), 'note');
    }
  ));
}  
add_action( 'rest_api_init', 'university_custom_rest');

function pageBanner($args = NULL){ 
  if(!isset($args['title'])){
    $args['title'] = get_the_title();
  }
  if(!isset($args['subtitle'])){
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
  if(!isset($args['photo'])){
    if(get_field('page_banner_background_image')AND !is_archive() AND !is_home()){
          $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    }else{
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }
  ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php 

    echo $args['photo'];
    ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>  
  </div>

<?php }

function university_files() {
   
  wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
  wp_localize_script( 'main-university-js', 'universityData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size( "professorLandscapse", 400, 260, true);
  add_image_size( "professorPortrait", 480, 650, true);
  add_image_size( "pageBanner", 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');



function university_adjust_queries($query){
  if(!is_admin() AND is_post_type_archive('program') AND is_main_query(  )){
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }
}
add_action('pre_get_posts', 'university_adjust_queries');

add_action('add_meta_boxes', function () {
    add_meta_box(
        'leaflet_location',
        'Campus Location (Leaflet)',
        function ($post) {
            $lat = get_post_meta($post->ID, '_leaflet_lat', true) ?: 48.8566;
            $lng = get_post_meta($post->ID, '_leaflet_lng', true) ?: 2.3522;
            ?>
            <!-- Leaflet CSS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
            <!-- Leaflet Control Geocoder CSS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
            
            <div id="leaflet-map" style="height: 500px; width: 100%; max-width: 100%;"></div>
            <input type="hidden" id="leaflet_lat" name="leaflet_lat" value="<?= esc_attr($lat) ?>">
            <input type="hidden" id="leaflet_lng" name="leaflet_lng" value="<?= esc_attr($lng) ?>">

            <!-- Leaflet JS -->
            <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
            <!-- Leaflet Control Geocoder JS -->
            <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

            <script>
            document.addEventListener('DOMContentLoaded', function () {
                var map = L.map('leaflet-map').setView([<?= $lat ?>, <?= $lng ?>], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                var marker = L.marker([<?= $lat ?>, <?= $lng ?>], { draggable: true }).addTo(map);

                function updateCoords(lat, lng) {
                    document.getElementById('leaflet_lat').value = lat;
                    document.getElementById('leaflet_lng').value = lng;
                }

                marker.on('dragend', function () {
                    var pos = marker.getLatLng();
                    updateCoords(pos.lat, pos.lng);
                });

                map.on('click', function (e) {
                    marker.setLatLng(e.latlng);
                    updateCoords(e.latlng.lat, e.latlng.lng);
                });

                // Add the Leaflet Control Geocoder search box
                var geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false
                })
                .on('markgeocode', function(e) {
                    var latlng = e.geocode.center;
                    map.setView(latlng, 16);
                    marker.setLatLng(latlng);
                    updateCoords(latlng.lat, latlng.lng);
                })
                .addTo(map);

                // Fix sizing issues if any
                setTimeout(function () {
                    map.invalidateSize();
                }, 500);
            });
            </script>
            <?php
        },
        'campus', // Your CPT slug
        'normal',
        'default'
    );
});
function enqueue_leaflet_frontend() {
  if (is_post_type_archive('campus') || is_singular('campus')) {
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], null, true); 
  }
}
add_action('wp_enqueue_scripts', 'enqueue_leaflet_frontend');



add_action('admin_enqueue_scripts', function ($hook) {
    $screen = get_current_screen();
    if (in_array($hook, ['post-new.php', 'post.php']) && $screen->post_type === 'campus') {
        wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
        wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], null, true);
         // Leaflet Control Geocoder CSS & JS
    wp_enqueue_style( 'leaflet-control-geocoder-css', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css' );
    wp_enqueue_script( 'leaflet-control-geocoder-js', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js', array('leaflet-js'), null, true );

    // Your custom map JS (make sure it depends on leaflet-control-geocoder-js)
    wp_enqueue_script( 'my-admin-map-js', plugins_url('/js/admin-map.js', __FILE__), array('leaflet-js', 'leaflet-control-geocoder-js'), null, true );
    }
});

add_action('save_post_campus', function ($post_id) {
    if (isset($_POST['leaflet_lat']) && isset($_POST['leaflet_lng'])) {
        update_post_meta($post_id, '_leaflet_lat', sanitize_text_field($_POST['leaflet_lat']));
        update_post_meta($post_id, '_leaflet_lng', sanitize_text_field($_POST['leaflet_lng']));
    }
});

//Redirect Subscribtor to front page 
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
  }
}

add_action('wp_loaded', 'noSubsAdminBar');

//hide admin bar on subscibtor 
function noSubsAdminBar() {
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
} 

// Customize Login Screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl(){
  return esc_url(site_url());
}

function wayostudent_custom_login_logo() {
    echo '
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(' . get_stylesheet_directory_uri() . '/images/Funiverlogo.png);
            background-size: contain;
            width: 100%;
            height: 80px;
        }
    </style>';
}
add_action('login_enqueue_scripts', 'wayostudent_custom_login_logo'); 

// Change the login logo title (hover text)
function custom_login_logo_title() {
    return '';
}
add_filter('login_headertext', 'custom_login_logo_title');

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS(){
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}



add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);


function makeNotePrivate($data, $postarr){
  if($data['post_type'] == 'note'){
    if(count_user_posts(get_current_user_id(  ), 'note') > 4 AND !$postarr['ID']){
      die('you have reached your note limit');
    }
      $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_content']);
  }
  if($data['post_type'] == 'note' AND $data['post_status'] != 'trash'){
    $data['post_status'] = "private";
  }
  return $data;
}



