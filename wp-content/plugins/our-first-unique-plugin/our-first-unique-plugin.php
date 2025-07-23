<?php 
/*
Plugin Name: Our Test Plugin
Description: A truly amazing plugin
Version: 1.0
Author: Ilyas
Author URI: https://www.udemy.com/user/

*/
class WordCountAndTimePlugin{
    function __construct(){
        add_action('admin_menu', array($this, 'adminPage'));
    }

    function adminPage(){
        add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page',  array($this, 'ourSettingsPageHTML'));
    }

    function ourSettingsPageHTML() { ?>
        <h1 class="wrap">
            Hello world from our new plugin
        </h1>
    <?php }
}
$WordCountAndTimePlugin = new WordCountAndTimePlugin();



