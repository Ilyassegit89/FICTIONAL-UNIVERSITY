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

class FeaturedProfessor {
    
    function __construct() {
        add_action('init', array($this, 'adminAssets'));
    }

    function adminAssets() {
    wp_register_style('featureditcss', plugin_dir_url(__FILE__) . 'build/index.css');
    wp_register_script('blocktypefeatured', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
    register_block_type('ourplugin/featured-professor', array(
      'editor_script' => 'blocktypefeatured',
      'editor_style' => 'featureditcss',
      'render_callback' => array($this, 'theHTML')
    ));
  }

    function theHTML() {
    ob_start(); ?>
    <h3>Today the sky is !</h3>
    <?php return ob_get_clean();
  }
}

$featuredProfessor = new FeaturedProfessor();