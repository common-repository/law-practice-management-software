<?php
/*
Plugin Name: Law Practice Management Software
Plugin URI: http://pushnifty.com/mojoomla/extend/wordpress/wplawyer/
Description: Law practice management software plugin for wordpress is ideal way to manage complete Lawyer's works. 
The system has different access rights for Admin, Attorney, Client, Staff Members and Accountant.
Version: 2.4.0
Author: Niftysol	
Author URI: https://www.niftysol.com/
Text Domain: lawyer_mgt
Domain Path: /languages/
License: GPLv2.1 or later
License URI: https://www.gnu.org/licenses/lgpl-2.1.html
Copyright 2017-2019  niftysol (email : sales@niftysol.com)
*/
if ( !function_exists( 'add_action' ) )
{
	esc_html_e('Hi there!  I\'m just a plugin, not much I can do when called directly.','lawyer_mgt');
	exit;
}
define( 'LAWMS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'LAWMS_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'LAWMS_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
define( 'LAWMS_CONTENT_URL',  content_url( '',__FILE__) );
define( 'LAWMS_HOME_URL',  home_url( '',__FILE__) );
require_once LAWMS_PLUGIN_DIR . '/settings.php';
?>