<?php
/**
 * @package Send_A_Wow
 * @version 0.2.4
 */
/*
Plugin Name: Send A Wow
Plugin URI: http://www.send-a-wow.org
Description: Shows a Button for cryptocoin donations e.g. Dogecoin under each article. Similar Facebooks Like-Button but for donations. If the user clicks on one of the button a popup with the coin-address and a QR-Link pops up. The user can easily donate some coins.
Author: shibyville
Version: 0.2.4
Author URI: undefinded
*/
//set version for reloading
$ver = "0.2.4";
// Take the template
function get_sendawow_template($content) {

    //get the template
    $template='<div class="wp-saw-button"></div>';

    //TODO: NEW OPTION 
    //if show only on full single pages true, than show it only there
    $options = get_option( "saw_options_general");
    
    if((boolean)$options['fullpageonly']) {
        //show it only on full pages
        if(is_single()) {
            $content = $content.$template;
        }
    } else { // if show it everywhere
        $content = $content.$template;
    }
    
    
	return $content;
    
}

/**
 * Add JS and CSS
 */
function add_js_and_css() {

        //load css file
        wp_enqueue_style( 'sendawow_defaultstyle', plugins_url( 'jquery.sendawow/sendawow.min.css' , __FILE__ ),false, $ver);

        //load qrcode generator first
        wp_enqueue_script( 'qrcode-generator', plugins_url( 'jquery.sendawow/lib/qrcode.min.js', __FILE__ ), false, $ver, true);
        
        //then load the send a wow plugin, but load qrgenerator and jquery first
        wp_enqueue_script( 'sendawow-plugin', plugins_url( 'jquery.sendawow/jquery.sendawow.min.js' , __FILE__ ), array('qrcode-generator','jquery') ,$ver,true);
        
        
        //at last load our javascript which creates the sendawow buttons
        //register it, but do not enqueue it yet - we have to modify it
        wp_register_script( 'sendawow-script', plugins_url( 'sendawow-wpscript.js' , __FILE__ ), 'sendawow-plugin' ,$ver,true);
        
        //give the script the configuration data
        $options = get_option( "saw_options_general");
        //add blogname
        $options["blogname"] = get_option("blogname");
        //give script the options
        wp_localize_script( 'sendawow-script', 'sawdata', $options );
        
        //enque script now
        wp_enqueue_script('sendawow-script');

}

add_action( 'wp_enqueue_scripts', 'add_js_and_css' ); //add all the needed js and css stuff

add_filter( 'the_content', 'get_sendawow_template');



//admin stuff
if ( is_admin() ){ // admin actions
    $mypath = plugin_dir_path(__file__);
    include($mypath."options.php");
}
?>
