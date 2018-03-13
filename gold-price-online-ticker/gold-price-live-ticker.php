<?php

if (!function_exists('add_action')) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define('GPLT_VERSION', '1.1.0');
define('GPLT__MINIMUM_WP_VERSION', '3.7');
define('GPLT__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GPLT__PLUGIN_FILE', 'gold-price-live-ticker.php');

register_activation_hook(__FILE__, array('Gplt', 'on_plugin_activation'));
register_deactivation_hook(__FILE__, array('Gplt', 'on_plugin_deactivation'));

require_once(GPLT__PLUGIN_DIR . 'class.gplt.php');
add_action('init', array('Gplt', 'init'));

if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
	require_once(GPLT__PLUGIN_DIR . 'class.gplt-admin.php');
	add_action('init', array('GpltAdmin', 'init'));
}
