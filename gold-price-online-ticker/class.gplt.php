<?php

class Gplt {

	/**
	 * Definitions
	 */
	const CNFKEY_ACTIVATED          = 'gplt_activated';
	const CNFKEY_PRICE_FEED_LINK    = 'gplt_price_feed_link';
	const CNFKEY_UPDATE_INTERVAL    = 'gplt_update_interval';
	const CNFKEY_PRICE_ADJUSTMENT   = 'gplt_price_adjustment';
	const CNFKEY_LAST_UPDATED       = 'gplt_last_updated';
	const CNFKEY_LATEST_PRICE       = 'gplt_latest_price';

	const PURITIES  =  array(
		'gold'      => array( 999, 916, 900, 750, 585, 333 ),
		'silver'    => array( 999, 925, 900, 835, 800, 700, 625 ),
		'platinum'  => array( 999, 950, 750 ),
		'palladium' => array( 999, 950, 500 ),
	);

	const DEFAULT_PRICE_FEED_LINK   = 'https://gold-feed.com/paid/d7d6s6d66k4j4658e6d6cds638940e/xmlgold_eur.php';
	const DEFAULT_UPDATE_INTERVAL   = 60;

	/** Don't use this constant directly, instead use default_price_adjustment() function */
	const DEFAULT_PRICE_ADJUSTMENT  = array(
		'gold'      => array( 'way' => 'percent', 'percent' => 100, 'override' => 0 ),
		'silver'    => array( 'way' => 'percent', 'percent' => 100, 'override' => 0 ),
		'platinum'  => array( 'way' => 'percent', 'percent' => 100, 'override' => 0 ),
		'palladium' => array( 'way' => 'percent', 'percent' => 100, 'override' => 0 ),
	);

	const UPDATE_INTERVAL_OPTIONS   = array(
		10   => 'Every 10 seconds',
		15   => 'Every 15 seconds',
		30   => 'Every 30 seconds',
		60   => 'Every 1 minute',
		120  => 'Every 2 minutes',
		180  => 'Every 3 minutes',
		300  => 'Every 5 minutes',
		600  => 'Every 10 minutes',
		1800 => 'Every 30 minutes',
		3600 => 'Every 1 hour',
	);

	/** Indicates whether plugin is initiated or not */
	private static $initiated = false;

	/**
	 * Initializes WordPress
	 */
	public static function init() {
		if ( self::$initiated )
			return;
		
		self::$initiated = true;
		
		// Add short codes for plugin
		add_shortcode('gplt_gold', 'Gplt::on_gold_code');
		add_shortcode('gplt_calc', 'Gplt::on_calc_code');
		add_shortcode('gplt_xcalc', 'Gplt::on_xcalc_code');
		add_shortcode('gplt_ticker', 'Gplt::on_ticker_code');

		// Add hooks
		add_action('wp_head', array('Gplt', 'on_wp_head'));
		add_action('wp_enqueue_scripts', array('Gplt', 'on_enqueue_scripts'));
		add_action('wp_ajax_gplt_latest_price', array('Gplt', 'on_ajax_latest_price'));
		add_action('wp_ajax_nopriv_gplt_latest_price', array('Gplt', 'on_ajax_latest_price'));
	}

	/**
	 * Load block for gold price
	 */
	public static function on_gold_code($atts) {
		if (!self::is_activated())
			return;
		/*
		$args = shortcode_atts(array(
				'desc' => 'Aktuelle Ankaufspreise für Geschäftskunden',
				'unit' => '€/g',
			), $atts);
		*/
		$interval = intval(get_option(Gplt::CNFKEY_UPDATE_INTERVAL, Gplt::DEFAULT_UPDATE_INTERVAL));
		$price = self::get_current_price();
		
		ob_start();
		self::load_view('gold', array(
			'interval' => $interval,
			'price' => $price,
		));
		return ob_get_clean();
	}

	/**
	 * Load block for calculator
	 */
	public static function on_calc_code() {
		if (!self::is_activated())
			return;

		$interval = intval(get_option(Gplt::CNFKEY_UPDATE_INTERVAL, Gplt::DEFAULT_UPDATE_INTERVAL));
		$price = self::get_current_price();
		
		ob_start();
		self::load_view('calc', array(
			'interval' => $interval,
			'price' => $price,
		));
		return ob_get_clean();
	}

	/**
	 * Load block for extended calculator shortcode
	 */
	public static function on_xcalc_code() {
		if (!self::is_activated())
			return;
		
		$interval = intval(get_option(Gplt::CNFKEY_UPDATE_INTERVAL, Gplt::DEFAULT_UPDATE_INTERVAL));
		$price = self::get_current_price();

		ob_start();
		self::load_view('xcalc', array(
			'interval' => $interval,
			'price' => $price,
		));
		return ob_get_clean();
	}

	/**
	 * Load block for live ticker
	 */
	public static function on_ticker_code() {
		if (!self::is_activated())
			return;
		
		$interval = intval(get_option(Gplt::CNFKEY_UPDATE_INTERVAL, Gplt::DEFAULT_UPDATE_INTERVAL));
		$price = self::get_current_price();

		ob_start();
		self::load_view('ticker', array(
			'interval' => $interval,
			'price' => $price,
		));
		return ob_get_clean();
	}

	/**
	 * Load a template of view
	 */
	public static function load_view($name, array $args = array()) {
		$args = apply_filters('akismet_view_arguments', $args, $name);
		
		foreach ($args as $key => $val) {
			$$key = $val;
		}
		
		load_plugin_textdomain('goldprice-liveticker');

		$file = GPLT__PLUGIN_DIR . 'views/'. $name . '.php';

		include($file);
	}

	public static function is_activated() {
		return get_option(Gplt::CNFKEY_ACTIVATED, false);
	}

	public static function on_plugin_activation() {
		add_option(Gplt::CNFKEY_ACTIVATED, true);
		add_option(Gplt::CNFKEY_PRICE_FEED_LINK, Gplt::DEFAULT_PRICE_FEED_LINK);
		add_option(Gplt::CNFKEY_UPDATE_INTERVAL, Gplt::DEFAULT_UPDATE_INTERVAL);
		add_option(Gplt::CNFKEY_PRICE_ADJUSTMENT, Gplt::default_price_adjustment());
		add_option(Gplt::CNFKEY_LAST_UPDATED, 0);
		add_option(Gplt::CNFKEY_LATEST_PRICE, '');
	}

	public static function on_plugin_deactivation() {
		delete_option(Gplt::CNFKEY_ACTIVATED);
	}

	public static function on_wp_head() {
		self::load_view('include');
	}

	public static function on_enqueue_scripts() {
		wp_enqueue_script('json2'); 
		wp_enqueue_script('jquery'); 
	}

	public static function on_ajax_latest_price() {
		$interval = intval(get_option(Gplt::CNFKEY_UPDATE_INTERVAL, Gplt::DEFAULT_UPDATE_INTERVAL));
		$price = self::get_current_price(true);
		echo json_encode(array(
			'success'  => true,
			'interval' => $interval,
			'price'    => $price,
		));
		die();
	}

	/**
	 * Get the current price
	 * This function is different with get_latest_price. It refers get_latest_price only as the base prices of metal,   
	 *  and adjust price for each purity of each metal with price adjustment options given in plugin configuration
	 * So the result format should be the same as below:
	 *  	array(
	 *			'gold'      => array( 999 => 35.92, 916 => 33.65, ... ),
	 *			'silver'    => array( 999 =>  0.48, ... ),
	 *			'platinum'  => array( 999 => 26.26, ... ),
	 *			'palladium' => array( 999 => 18.29, ... ),
	 *		)
	 */
	public static function get_current_price($live = false) {
		$base_price  = self::get_latest_price($live);
		$adjustments = get_option(Gplt::CNFKEY_PRICE_ADJUSTMENT, Gplt::default_price_adjustment());
		$adjusted    = array();
		foreach ($adjustments as $metal => $one) {
			foreach (Gplt::PURITIES[$metal] as $purity) {
				$adjusted[$metal][$purity] = $base_price[$metal] / 999.0 * $purity;
				if      ($one['way'] == 'percent' ) $adjusted[$metal][$purity] *= floatval($one['percent'][$purity]) / 100.0; 
				else if ($one['way'] == 'override') $adjusted[$metal][$purity]  = floatval($one['override'][$purity]);
			}
		}
		return $adjusted;
	}

	/**
	 * Get the latest price
	 *  - when $live is true, fetch price feed, save it into database, and return it
	 *  - when no latest price in database, force to fetch price feed, save it into database, and return it.
	 *  - otherwise, return last-updated price from the database
	 */
	private static function get_latest_price($live = false) {
		$price = get_option(Gplt::CNFKEY_LATEST_PRICE, null);
		$force = !is_array($price);
		if ($live || $force) {
			if (self::fetch_price_feed($force))
				$price = get_option(Gplt::CNFKEY_LATEST_PRICE);
		}
		return $price;
	}

	/**
	 * Fetch price feed with the link given in plugin configuration
	 *  and return true if succeeded or false otherwise
	 * The result format is in the following:
	 *  	array(
	 *			'gold'      => 37.09,	// from <gold>/<price>
	 *			'silver'    =>  0.53,	// from <silver>/<price>
	 *			'platinum'  => 27.79,	// from <platinum>/<price>
	 *			'palladium' => 18.57,	// from <palladium>/<price>
	 *		)
	 */
	const GRAM_PER_OUNCE = 31.1034768;
	private static function fetch_price_feed($force = false) {
		$feed_src  = get_option(Gplt::CNFKEY_PRICE_FEED_LINK);
		$interval  = get_option(Gplt::CNFKEY_UPDATE_INTERVAL, 0);  
		$last_time = get_option(Gplt::CNFKEY_LAST_UPDATED, 0);
		$cur_time  = time();

		if (empty($feed_src))
			return false;
		
		if (!$force && ($cur_time - $last_time < $interval))
			return false;
		
		// Fetch feed with subscription link
		$feed = file_get_contents($feed_src);
		if (!$feed)
			return false;
		
		$price = array(
			'gold'      => floatval(self::xml_get_element_value($feed, 'price', 'gold', 0)) / self::GRAM_PER_OUNCE,
			'silver'    => floatval(self::xml_get_element_value($feed, 'price', 'silver', 0)) / self::GRAM_PER_OUNCE,
			'platinum'  => floatval(self::xml_get_element_value($feed, 'price', 'platinum', 0)) / self::GRAM_PER_OUNCE,
			'palladium' => floatval(self::xml_get_element_value($feed, 'price', 'palladium', 0)) / self::GRAM_PER_OUNCE,
		);

		// Update last-updated time and latest price
		update_option(Gplt::CNFKEY_LATEST_PRICE, $price);
		update_option(Gplt::CNFKEY_LAST_UPDATED, time());

		return true;
	}

	private static function xml_get_element_value($xml, $element, $parent, $default = false) {
		$start = strpos($xml, '<' . $parent . '>');
		if ($start == false)
			return $default;
		
		$start += strlen($parent) + 2;
		$start = strpos($xml, '<' . $element . '>', $start);
		if ($start == false)
			return $default;

		$start += strlen($element) + 2;
		$end = strpos($xml, '</' . $element . '>', $start);
		if ($end == false)
			return $default;
		
		return substr($xml, $start, $end - $start);
	}

	public static function default_price_adjustment() {
		$default = array();
		foreach (Gplt::DEFAULT_PRICE_ADJUSTMENT as $metal => $value) {
			$default[$metal] = array(
				'way'      => $value['way'],
				'percent'  => array(),
				'override' => array(),
			);
			foreach (Gplt::PURITIES[$metal] as $purity) {
				$default[$metal]['percent'][$purity]  = 100;
				$default[$metal]['override'][$purity] = 0;
			}
		}
		return $default;
	}
}