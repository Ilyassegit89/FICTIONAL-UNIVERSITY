<?php
/*
Plugin Name: Are You Paying Attention Quiz
Description: A quiz block for WordPress with React frontend
Version: 1.0
*/

if (!defined('ABSPATH')) {
    exit;
}

class PayingAttentionQuiz {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
    }

    function init() {
        // Register editor script and styles
        wp_register_script(
            'quiz-editor-script',
            plugin_dir_url(__FILE__) . 'build/index.js',
            array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-block-editor'),
            '1.0',
            true
        );

        wp_register_style(
            'quiz-editor-style',
            plugin_dir_url(__FILE__) . 'build/index.css',
            array('wp-edit-blocks'),
            '1.0'
        );

        // Register frontend script and styles
        wp_register_script(
            'quiz-frontend-script',
            plugin_dir_url(__FILE__) . 'build/frontend.js',
            array('wp-element'),
            '1.0',
            true
        );

        wp_register_style(
            'quiz-frontend-style',
            plugin_dir_url(__FILE__) . 'build/frontend.css',
            array(),
            '1.0'
        );

        // Register the block
        register_block_type('ourplugin/are-you-paying-attention', array(
            'editor_script' => 'quiz-editor-script',
            'editor_style' => 'quiz-editor-style',
            'script' => 'quiz-frontend-script',
            'style' => 'quiz-frontend-style',
            'render_callback' => array($this, 'theHTML')
        ));
    }

    function theHTML($attributes) {
        ob_start(); ?>
        <div class="paying-attention-update-me">
            <pre style="display:none;"><?php echo wp_json_encode($attributes)?></div></pre>
        </div>
        <?php return ob_get_clean();
    }
}

new PayingAttentionQuiz();