<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    advance-neon-product-designer
 * @subpackage advance-neon-product-designer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    advance-neon-product-designer
 * @subpackage advance-neon-product-designer/public
 * @author     Your Name <email@example.com>
 */
class ANPD_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public $cart_items_labels = array(
		"anpd_font" => 'Font',
		"anpd_location" => 'Location',
		"anpd_text" => 'Text',
		"anpd_size" => 'Size',
		"anpd_color" => 'Color',
		"anpd_alignment" => 'Alignment',
		"anpd_tube" => 'Tube',
		"anpd_backing" => 'Backing',
	);
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_filter( 'woocommerce_get_item_data', array($this,'anpd_display_engraving_text_cart'), 10, 2 );
		add_action( 'woocommerce_before_calculate_totals', array($this,'add_custom_price') );

	}

	

	public	function add_custom_price( $cart_object ) {
		    foreach ( $cart_object->cart_contents as $key => $value ) {
		    	if (array_key_exists('anpd_price', $value ) && $value['anpd_price']) {
		    		$value['data']->set_price($value['anpd_price']) ;
		    	}
		    }
		}
	public function anpd_display_engraving_text_cart( $item_data, $cart_item ) {
		foreach ($this->cart_items_labels as $key => $value) {
			if ( empty( $cart_item[$key] ) ) {
				return $item_data;
			}
			$item_data[] = array(
				'key'     => __($value, 'advance-neon-product-designer'),
				'value'   => wc_clean( $cart_item[$key] ),
				'display' => '',
			);
			
		}
		return $item_data;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function anpd_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ANPD_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ANPD_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name.'-fancybox', plugin_dir_url( __FILE__ ) . 'css/jquery.fancybox.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advance-neon-product-designer-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function anpd_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ANPD_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ANPD_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name.'-jquery-ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'-fancybox-jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.fancybox.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advance-neon-product-designer-public.js', array( 'jquery' ), $this->version, true );

	}


	/**
	 * Register Custom Template For ANPD Products
	 *
	 * @since    1.0.0
	 */
	public function ANPD_Custom_product_template( $data ) {
    	global $product , $post;
        $configrator = get_post_meta( $post->ID, 'anpd_config_selector', true );
        if(is_singular('product') && !empty($configrator)) {
		  require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/woocommerce/anpd-single-product.php';
        }
	  return $data;
	}


	/**
	 * Remove woocommerce hooks For ANPD Products
	 *
	 * @since    1.0.0
	 */
	public function ANPD_remove_hooks_product_page(){
		global $product , $post;
        if(is_singular('product')) {
        	$configrator = get_post_meta( $post->ID, 'anpd_config_selector', true );
        	if (get_post_meta( $post->ID, 'anpd_config_selector', true )) {
	        	// remove title
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				// remove  rating  stars
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
				// remove product meta 
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
				// remove  description
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
				// remove images
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
				// remove related products
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
				// remove additional information tabs
				remove_action('woocommerce_after_single_product_summary ','woocommerce_output_product_data_tabs',10);
			}
        }
	}


	/**
	 * Ajax Price Calculation
	 *
	 * @since    1.0.0
	 */
	Public function ajax_anpd_price_cacl(){
		global $post, $product;
		// Form submitted data
		$product_id 		 = $_POST['product_id'];
		$anpd_configrator    = $_POST['config_id'];
		$selected_font       = $_POST['font'];
		$anpd_size           = $_POST['size'];
		$selected_location   = $_POST['location'];
		$selected_color      = $_POST['color'];
		$alignment           = $_POST['alignment'];
		$selected_anpd_bg    = $_POST['anpd-bg'];
		$anpd_tube           = $_POST['tube'];
		$selected_backing    = $_POST['backing'];
		$anpd_text           = $_POST['anpd_text'];
		
		// data for price Calculation
		$conf_data           = $this->get_configrator_data($anpd_configrator);
		$get_font_group      = $this->get_configrator_font_group($anpd_configrator,$selected_font);
		$get_font_prams      = $this->get_configrator_font_group_prams($anpd_configrator,$get_font_group);
		$get_font_size_prams = $this->get_configrator_font_size($anpd_configrator,$get_font_group,$anpd_size);
		$get_backing         = $this->get_price_exploded_arr('backing',$selected_backing);
		$get_location        = $this->get_price_exploded_arr('location',$selected_location);
		$location_price      = (float)$get_location[0]['location_price'];
		$location_title      = $get_location[0]['location'];
		$backing_price       = (float)$get_backing[0]['backing_price'];
		$backing_title       = $get_backing[0]['backing'];
		$z 					 = (float)$get_font_size_prams['z'];
		$y 					 = (float)$get_font_size_prams['y'];
		$m 					 = (float)$get_font_size_prams['m']/100;
		$r 					 = (float)$get_font_size_prams['r'];
		$x 					 = (float)$get_font_size_prams['x'];
		$w 					 = (float)$get_font_size_prams['w'];
		$h 					 = (float)$get_font_size_prams['h'];
		$k 					 = (float)$get_font_size_prams['k'];
		$p 					 = (float)$get_font_size_prams['p'];
		$n                   = strlen($anpd_text);
		$calculated_price    = $this->price_formula($n,$z,$y,$m,$r,$x,$w,$h,$k,$p);
		$calculated_price_total 	 = $calculated_price+$location_price+$backing_price;
		// add to cart product
		// $arr = [$n,$z,$y,$m,$r,$x,$w,$h,$k,$p];
		$cart_meta = array(
			'anpd_font' => $selected_font,
			'anpd_location' => $location_title,
			'anpd_text' => $anpd_text,
			'anpd_size' => str_replace('_', ' ', $anpd_size),
			'anpd_color' => $selected_color,
			'anpd_alignment' => $alignment,
			'anpd_tube' => $anpd_tube,
			'anpd_backing' => $backing_title ,
			'anpd_price' => $calculated_price,
		);
		if (isset($_POST['submitted'])) {
			WC()->cart->empty_cart();
			WC()->cart->add_to_cart( $product_id, 1, 0 , array() , $cart_meta );
			$arr = array(
				'redirect' => 1,
				'price' => wc_price($calculated_price_total),
			);
		}else{
			$arr = array(
				'redirect' => 0,
				'price' => wc_price($calculated_price_total),
			);
		}
		wp_send_json_success($arr);
	}

	private function anpd_ceiling($number, $significance = 1){
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
    }

	private function price_formula($n,$z,$y,$m,$r,$x,$w,$h,$k,$p){
			$price = round(($n*$x+$z+$y*(($this->anpd_ceiling(($n*$w+15)*($h+15)*8/5000,0.5))-0.5)/0.5)/($r*(1-$m*(pow(($p-$n)/$p,$k)))));
			return $price;
	}

	/**
	 * Get configrator data by configrator ID
	 *
	 * @since    1.0.0
	 */
	private function get_configrator_data($anpd_configrator){
		$colors      = get_post_meta( $anpd_configrator, 'anpd_color_group', true );
		$backings    = get_post_meta( $anpd_configrator, 'anpd_backing_group', true );
		$fonts       = get_post_meta( $anpd_configrator, 'anpd_font_group', true );
		$locations   = get_post_meta( $anpd_configrator, 'anpd_location_group', true );
		$backgrounds = get_post_meta( $anpd_configrator, 'anpd_background_group', true );
		$conf_data   = array(
			'anpd_colors'      => $colors,
			'anpd_backings'    => $backings,
			'anpd_fonts'       => $fonts,
			'anpd_locations'   => $locations, 
			'anpd_backgrounds' => $backgrounds
		);
		return $conf_data;
	}


	/**
	 * Get Configrator Font Group by Configrator ID and Font
	 *
	 * @since    1.0.0
	 */
	private function get_configrator_font_group($anpd_configrator,$selected_font){
		global $font_slug;
		$groups       = get_post_meta( $anpd_configrator, 'anpd_font_group', true );
		$i = 0;
		foreach ($groups as $key_group => $group) {
			foreach ($group['font'] as $font_key => $font) {
				$font_family = $this->anpd_get_font_name($font);
				if ( $i == 0 && $font_family == $selected_font) {
					return $key_group;
					$i++;
				}
			}
		}
	}

	/**
	 * Get Font Name
	 *
	 * @since    1.0.0
	 */
	private function anpd_get_font_name($value){
		$font_NU = urldecode($value);
		$font_expload = explode("_x_",$font_NU);
		global $font_slug,$font_family;
		for ($x=0; $x < count($font_expload) ; $x++) { 
			if ($x==0) {
				$font_family = $font_expload[$x];
			}elseif ($x==1) {
				$font_slug = $font_expload[$x];
			}
		}
		return $font_family;
	}

	/**
	 * Get Configrator Font Group Parameters by Configrator ID and Group
	 *
	 * @since    1.0.0
	 */
	private function get_configrator_font_group_prams($anpd_configrator,$anpd_group){
		$groups = get_post_meta( $anpd_configrator, 'anpd_font_group', true );
		foreach ($groups as $key_group => $group) {
			if ($key_group == $anpd_group) {
				return $group['prams'];
			}
		}
	}

	/**
	 * Get Configrator Font 
	 *
	 * @since    1.0.0
	 */
	private function get_configrator_font_size($anpd_configrator,$anpd_group,$anpd_size){
		$groups = get_post_meta( $anpd_configrator, 'anpd_font_group', true );
		foreach ($groups as $key_group => $group) {
			if ($key_group == $anpd_group) {
				foreach ($group['prams'] as $key => $size) {
					if ($key == $anpd_size) {
						return $size;
					}
				}
			}
		}
	}
	private function get_price_exploded_arr($name,$value){
		$value_expload = explode("_x_",$value);
		for ($x=0; $x < count($value_expload) ; $x++) { 
			if ($x==0) {
				$price = $value_expload[$x];
			}elseif ($x==1) {
				$name_ex = $value_expload[$x];
			}
		}
		$arr[] = array(
			$name => $name_ex,
			$name.'_price' =>  $price
		);
		return $arr;
	}

}
