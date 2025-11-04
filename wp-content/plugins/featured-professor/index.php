<?php

/*
  Plugin Name: Featured Professor
  Description: Give your readers a proffesor Insertion
  Version: 1.0
  Author: ilyas
  Author URI: https://www.udemy.com/user/ilyas
  Domain Path: /languages
*/


if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'inc/generateProfessorHTML.php';
require_once plugin_dir_path(__FILE__) . 'inc/relatedPostsHTML.php';


class FeaturedProfessor {
    
    function __construct() {
        add_action('init', array($this, 'adminAssets'));
        add_action('rest_api_init', [$this, 'profHTML']);
        add_filter('the_content', [$this, 'addRelatedPosts']);
    }
    function addRelatedPosts($content){
      if(is_singular('professor') && in_the_loop() && is_main_query()){
        return $content . relatedPostsHTML(get_the_id());
      }
      return $content;
    }

    function profHTML(){
      register_rest_route('featuredProfessor/v1', 'getHTML', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => [$this, 'getProfHTML']
      ));
    }
    function getProfHTML($data){ 
      return generateProfessorHTML($data['profId']);
    }

    function adminAssets() {
    load_plugin_textdomain('featured-professor', false, dirname(plugin_basename(__FILE__)) . '/languages');
    
    register_meta('post', 'featuredProfessor', array(
        'show_in_rest' => true,
        'type' => 'number',
        'single' => false
    ));
    
    wp_register_style('featureditcss', plugin_dir_url(__FILE__) . 'build/index.css');
    
    // Use text domain as script handle
    $script_handle = 'featured-professor'; // ← Changed this
    
    wp_register_script(
        $script_handle,
        plugin_dir_url(__FILE__) . 'build/index.js',
        array('wp-blocks','wp-element','wp-editor','wp-i18n'),
        filemtime(plugin_dir_path(__FILE__) . 'build/index.js')
    );
     wp_register_script(
            'featured-professor-front',
            plugin_dir_url(__FILE__) . 'build/frontend.js',
            array('wp-element'),
            '1.0',
            true
        );

    wp_register_style(
            'featured-professor-front-style',
            plugin_dir_url(__FILE__) . 'build/index.css',
            array(),
            '1.0'
        );
    
    wp_set_script_translations(
        $script_handle,
        'featured-professor',
        plugin_dir_path(__FILE__) . 'languages'
    );
    
    register_block_type('ourplugin/featured-professor', array(
        'editor_script' => $script_handle,
        'editor_style' => 'featureditcss',
        'script' => 'featured-professor-front',
        'style' => 'featured-professor-front-style',
        'render_callback' => array($this, 'renderCallback')
    ));
}

    function renderCallback($attributes) {
        ob_start(); ?>
        <div class="featured-professor-plugin">
            <pre style="display:none;"><?php echo wp_json_encode($attributes)?></div></pre>
        </div>
        <?php return ob_get_clean();
  }
}

$featuredProfessor = new FeaturedProfessor();