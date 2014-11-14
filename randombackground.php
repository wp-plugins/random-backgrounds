<?php

/*
Plugin Name: Random backgrounds
Plugin URI: http://www.evona.nl/plugins/random-background
Description: Inserts a random background and the CSS to display it on each page.
Version: 1.0
Author: Erik von Asmuth
Author URI: http://evona.nl/over-mij/ (Dutch)
License: GPLv2
Text Domain: evonarandombackgrounds
*/
//Selects a random background, then adds it
function EvonaRandomBackground() {
	$backgroundfile = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'evonapluginconfig'.DIRECTORY_SEPARATOR.'backgrounds.txt';
	$achtergronden = file($backgroundfile, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
	
	$count = count($achtergronden) - 1;
	$keuze = rand(0, $count);
	
	foreach($achtergronden as $nummer => $achtergrond){
		if($nummer == $keuze){
			echo $achtergrond;
		}
	}
}

add_action('wp_footer','EvonaRandomBackground', '1');
//Adds CSS to pages
function EvonaAddCss(){
	$cssurl = plugins_url('evonabackground.css',dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'evonapluginconfig'.DIRECTORY_SEPARATOR.'evonabackground.css');
	wp_enqueue_style('evonabackground', $cssurl, null, 'all');
}
add_action('wp_enqueue_scripts', 'EvonaAddCss');

//Installs plugin, creates default config files
function EvonaInitializeStep1(){
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'installdeinstall.php');
	EvonaInitializeStep2();	
}
register_activation_hook( __FILE__, 'EvonaInitializeStep1');
//Removes config files before uninstalling, removes config folder if empty
function EvonaUninstallStep1(){
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'installdeinstall.php');
	EvonaUninstallStep2();	
}
register_uninstall_hook( __FILE__, 'EvonaUninstallStep1');
//Load in the option page
function EvonaCreateMenu() {
	add_theme_page( 'Random Backgrounds', 'Random Backgrounds', 'manage_options', 'evona-random-backgrounds', 'EvonaBackgroundSettings' );
}

function EvonaBackgroundSettings(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'evonarandombackgrounds' ) );
	}
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'settings.php');
	EvonaBackgroundSettings2();
}

//Create the option menu, and load admin CSS to it
add_action( 'admin_menu', 'EvonaCreateMenu' );

//Loads Admin CSS if option page is selected
	function EvonaAdminCss(){
		if(isset($_GET['page']) && $_GET['page'] != 'evona-random-backgrounds' ) return;
		$admincssfile = plugin_dir_url(__FILE__).'evonaadmin.css';
		wp_enqueue_style('evonabackground', $admincssfile, null, 'all');
		wp_enqueue_media();
	}
	add_action('admin_enqueue_scripts', 'EvonaAdminCss');

?>
