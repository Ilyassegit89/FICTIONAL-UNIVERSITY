<?php 
/*
Plugin Name: Our Word Filter Plugin
Description: Replaces a list of words
Version: 1.0
Author: Ilyas
Author URI: https://www.udemy.com/user/
*/

if(!defined('ABSPATH')) exit; //Exit if accessed directly

class OurWordFilterPlugin{
    function __construct(){
        add_action('admin_menu', array($this, 'ourMenu'));
        if(get_option('plugin_words_to_filter')) add_action('the_content', array($this, 'filterLogic'));
    }
    function filterLogic($content){
        $badWords = explode(',', get_option('plugin_words_to_filter'));
        $badWordsTrimmed = array_map('trim', $badWords);
        return str_ireplace($badWordsTrimmed, '****' , $content);

    }

    function ourMenu(){

        $mainPageHook = add_menu_page('Words To Filter', 'Word Filter', 'manage_options', 'ourWordfilter', array($this, 'wordFilterPage'), 'data:image/svg+xml;base64, PHN2ZyBmaWxsPSIjZmZmZmZmIiB2aWV3Qm94PSIwIDAgMzIgMzIiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBzdHJva2U9IiNmZmZmZmYiPjxnIGlkPSJTVkdSZXBvX2JnQ2FycmllciIgc3Ryb2tlLXdpZHRoPSIwIj48L2c+PGcgaWQ9IlNWR1JlcG9fdHJhY2VyQ2FycmllciIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48L2c+PGcgaWQ9IlNWR1JlcG9faWNvbkNhcnJpZXIiPiA8dGl0bGU+YXJyb3ctZG93bi1hLXo8L3RpdGxlPiA8cGF0aCBkPSJNMTEuNDcgMjQuNDY5bC0zLjcyIDMuNzIxdi0yNi4xODljMC0wLjQxNC0wLjMzNi0wLjc1LTAuNzUtMC43NXMtMC43NSAwLjMzNi0wLjc1IDAuNzV2MCAyNi4xODhsLTMuNzItMy43MmMtMC4xMzYtMC4xMzQtMC4zMjItMC4yMTgtMC41MjgtMC4yMTgtMC40MTUgMC0wLjc1MSAwLjMzNi0wLjc1MSAwLjc1MSAwIDAuMjA3IDAuMDgzIDAuMzk0IDAuMjE4IDAuNTI5bDUgNWMwLjAyNiAwLjAyNiAwLjA2NSAwLjAxNyAwLjA5MyAwLjAzOCAwLjA1MiAwLjA0MCAwLjA4OCAwLjA5OCAwLjE1IDAuMTI0IDAuMDg1IDAuMDM1IDAuMTg0IDAuMDU2IDAuMjg3IDAuMDU3aDBjMC4yMDcgMCAwLjM5NC0wLjA4NCAwLjUzLTAuMjE5bDUtNWMwLjEzNS0wLjEzNiAwLjIxOC0wLjMyMyAwLjIxOC0wLjUyOSAwLTAuNDE1LTAuMzM2LTAuNzUxLTAuNzUxLTAuNzUxLTAuMjA2IDAtMC4zOTMgMC4wODMtMC41MjggMC4yMThsMC0wek0yMy41NTcgMS44NzJjLTAuMDQ5LTAuMTAyLTAuMTUyLTAuMTcyLTAuMjcxLTAuMTcyLTAgMC0wLjAwMSAwLTAuMDAxIDBoLTAuNTg0Yy0wIDAtMC4wMDEgMC0wLjAwMSAwLTAuMTE5IDAtMC4yMjIgMC4wNjktMC4yNyAwLjE3bC0wLjAwMSAwLjAwMi01LjY0IDEyYy0wLjAxOCAwLjAzNy0wLjAyOSAwLjA4MS0wLjAyOSAwLjEyOCAwIDAuMTY2IDAuMTM0IDAuMyAwLjMgMC4zIDAgMCAwIDAgMCAwaDAuNTMxYzAgMCAwIDAgMCAwIDAuMTE5IDAgMC4yMjItMC4wNzAgMC4yNzEtMC4xNzFsMC4wMDEtMC4wMDIgMS4zNDMtMi44NjFoNy41NTdsMS4zNTcgMi44NjNjMC4wNTAgMC4xMDIgMC4xNTMgMC4xNzEgMC4yNzEgMC4xNzFoMC41MzFjMCAwIDAuMDAxIDAgMC4wMDIgMCAwLjE2NSAwIDAuMjk5LTAuMTM0IDAuMjk5LTAuMjk5IDAtMC4wNDctMC4wMTEtMC4wOTEtMC4wMzAtMC4xM2wwLjAwMSAwLjAwMnpNMTkuNzExIDEwLjE2OWwzLjI4MS02Ljk1IDMuMjY0IDYuOTV6TTI3LjU4NCAxNy43MDRoLTguOTA4Yy0wIDAtMCAwLTAuMDAxIDAtMC4xNjYgMC0wLjMgMC4xMzQtMC4zIDAuM3YwIDAuNDk2YzAgMC4xNjYgMC4xMzUgMC4zMDEgMC4zMDEgMC4zMDFoNy42MTVsLTguMTI5IDEwLjYwNGMtMC4wMzkgMC4wNTAtMC4wNjIgMC4xMTMtMC4wNjMgMC4xODJ2MC40MWMwIDAuMTY2IDAuMTM1IDAuMzAxIDAuMzAxIDAuMzAxaDkuMTY2YzAuMTY2LTAgMC4zMDEtMC4xMzUgMC4zMDEtMC4zMDF2MC0wLjQ5NmMtMC0wLjE2Ni0wLjEzNS0wLjMwMS0wLjMwMS0wLjMwMWgtNy44NzNsOC4xMjktMTAuNjA0YzAuMDM5LTAuMDUwIDAuMDYyLTAuMTEzIDAuMDYzLTAuMTgydi0wLjQxYy0wLTAuMTY2LTAuMTM0LTAuMy0wLjMtMC4zLTAgMC0wLjAwMSAwLTAuMDAxIDBoMHoiPjwvcGF0aD4gPC9nPjwvc3ZnPg==', 100 );
        add_submenu_page('ourWordfilter', 'Words To Filter', 'Words List', 'manage_options', 'ourWordfilter', array($this, 'wordFilterPage'));
        add_submenu_page('ourWordfilter', 'word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionsSubPage'));
        add_action("load-{$mainPageHook}", array($this, 'mainPageAssets'));

    }
    function mainPageAssets(){
        wp_enqueue_style('filterAdminCss', plugin_dir_url(__FILE__) . 'styles.css');
    }
    function handleForm(){
        if(wp_verify_nonce($_POST['ourNonce'], 'saveFilterWords') AND current_user_can('manage_options')){

            update_option('plugin_words_to_filter', sanitize_text_field($_POST['plugin_words_to_filter'])) ; ?>
            <div class="updated">
                <p>Your filtered words were saved.</p>
            </div>
        <?php } else { ?>
            <div class="error">
                <p>Sorry , you don't have permission to peform that action</p>
            </div>
        <?php }
    }
    
    function wordFilterPage(){ ?>
        <div class="wrap">
            <h1>Word Filter</h1>
            <?php if(isset($_POST['justsubmitted']) == "true" ) $this->handleForm() ?>
            <form method="POST">
                <input type="hidden" name="justsubmitted" value="true">
                <?php wp_nonce_field('saveFilterWords', 'ourNonce')?>
                <label for="plugin_words_to_filter"><p>Enteer a <strong>comma-separated</strong> list of words to filter from your site's content</p> </label>
                <div class="word-filter__flex_container">
                    <textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="bad, mean, awful, horrible"><?php echo esc_textarea(get_option('plugin_words_to_filter')) ?></textarea>
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </form>
        </div>
    <?php }
    function optionsSubPage(){ ?>
        <div class="wrap">
            <h1>Word Filter Options</h1>
            <form action="options.php" method="POST">
                <?php 
                    submit_button();
                ?>
            </form>
        </div>
    <?php }
}

$ourWordFilterPlugin = new OurWordFilterPlugin();
