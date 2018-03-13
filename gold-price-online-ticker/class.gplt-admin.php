<?php

class GpltAdmin {

	/** Indicates whether plugin is initiated or not */
	private static $initiated = false;

	/**
	 * Initializes WordPress
	 */
	public static function init() {
		if ( self::$initiated )
			return;
		
		self::$initiated = true;

		// Add WordPress hooks
		add_action('admin_init', array('GpltAdmin', 'on_admin_init'));
		add_action('admin_menu', array('GpltAdmin', 'on_admin_menu'), 5);

		add_filter('plugin_action_links', array('GpltAdmin', 'plugin_action_links'), 10, 2);
		add_filter('plugin_action_links_' . plugin_basename(plugin_dir_path(__FILE__) . GPLT__PLUGIN_FILE), array('GpltAdmin', 'plugin_settings_link'));
	}


	public static function on_admin_init() {
	}

	public static function on_admin_menu() {
		add_options_page(
			'Gold Price Live Ticker', 
			'Gold Price Live Ticker', 
			'manage_options', 
			'gplt_config', 
			array('GpltAdmin', 'load_config_page')
		);
	}

	public static function admin_head() {
		if (!current_user_can('manage_options'))
			return;
	}

	public static function plugin_action_links($links, $file) {
		if ($file == plugin_basename(plugin_dir_url(__FILE__) . GPLT__PLUGIN_FILE)) {
			$links[] = '<a href="' . esc_url(self::get_page_url()) . '">Settings</a>';
		}
		return $links;
	}

	public static function plugin_settings_link($links) { 
  		$settings_link = '<a href="' . esc_url(self::get_page_url()) . '">Settings</a>';
  		array_unshift($links, $settings_link); 
  		return $links; 
	}

	public static function load_config_page() {
		if (isset($_POST['price_feed_link'])) {
			update_option(Gplt::CNFKEY_PRICE_FEED_LINK,  $_POST['price_feed_link']);
			update_option(Gplt::CNFKEY_UPDATE_INTERVAL,  $_POST['update_interval']);
			update_option(Gplt::CNFKEY_PRICE_ADJUSTMENT, $_POST['price_adjustment']);
		}

		$price_feed_link  = get_option(Gplt::CNFKEY_PRICE_FEED_LINK,  Gplt::DEFAULT_PRICE_FEED_LINK);
		$update_interval  = get_option(Gplt::CNFKEY_UPDATE_INTERVAL,  Gplt::DEFAULT_UPDATE_INTERVAL);
		$price_adjustment = get_option(Gplt::CNFKEY_PRICE_ADJUSTMENT, Gplt::default_price_adjustment());

		Gplt::load_view('config', array(
			'price_feed_link'         => $price_feed_link,
			'update_interval'         => $update_interval,
			'update_interval_options' => Gplt::UPDATE_INTERVAL_OPTIONS,
			'purities'                => Gplt::PURITIES,
			'price_adjustment'        => $price_adjustment,
		));
	}

	public static function get_page_url() {
		$args = array('page' => 'gplt_config');
		$url  = add_query_arg($args, admin_url('options-general.php'));
		return $url;
	}
}