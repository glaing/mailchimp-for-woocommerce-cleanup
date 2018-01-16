<?php
/*
Plugin Name: MailChimp Cleanup Tool
Plugin URI: http://pxhosting.co.uk
Description: Plugin creates a list of WooCommerce customers who didn't wish to be subscribed.
Author: George Laing
Version: 1.0.0
Author URI: http://pxadventures.co.uk
*/

defined( 'ABSPATH' ) or die( 'No Direct Access' );

function MailChimp_Cleanup_Tool()
{
    global $wpdb;
    include 'MailChimp_Cleanup_Tool-Admin.php';
}

function MailChimp_Cleanup_Tool_Admin_actions()
{
    add_management_page("MailChimp Cleanup", "MailChimp Cleanup", 1, "mailchimp-cleanup", "MailChimp_Cleanup_Tool");
}

add_action('admin_menu', 'MailChimp_Cleanup_Tool_Admin_actions');

?>
