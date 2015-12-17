<?php


/*
Plugin Name: Bartender
Plugin URI:
Version: 0.3
Author: INFija
Description:
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
require_once dirname( __FILE__ ) . '/src/Main.php';

global $app;
$app = Main::initialize();

// register activation/desactivation methods
register_activation_hook( __FILE__, array( &$app, 'activate' ) );
register_deactivation_hook( __FILE__, array( &$app, 'deactivate' ) );
