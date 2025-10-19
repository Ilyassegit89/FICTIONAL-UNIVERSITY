<?php

/*
  Plugin Name: Featured Professor
  Description: Give your readers a proffesor Insertion
  Version: 1.0
  Author: ilyas
  Author URI: https://www.udemy.com/user/bradschiff/
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
      register_meta('post', 'featuredProfessor', array(
        'show_in_rest' => true,
        'type' => 'number',
        'single' => false
      ));
    wp_register_style('featureditcss', plugin_dir_url(__FILE__) . 'build/index.css');
    wp_register_script('blocktypefeatured', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
    register_block_type('ourplugin/featured-professor', array(
      'editor_script' => 'blocktypefeatured',
      'editor_style' => 'featureditcss',
      'render_callback' => array($this, 'renderCallback')
    ));
  }
  function renderCallback($attributes){
    if($attributes['profId']){
      wp_enqueue_style('featureditcss');
      return generateProfessorHTML($attributes['profId']);
    }else{
      return NULL;
    }
  }

    /* function theHTML() {
    ob_start(); ?>
    <h3>Today the sky is !</h3>
    <?php return ob_get_clean();
  } */
}

$featuredProfessor = new FeaturedProfessor();