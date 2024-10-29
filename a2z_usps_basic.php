<?php
/**
 * Plugin Name: Automated USPS Shipping
 * Plugin URI: https://hitshipo.com/
 * Description: Realtime Shipping Rates.
 * Version: 1.0.3
 * Author: HITShipo
 * Author URI: https://hitshipo.com/
 * Developer: hitshipo
 * Developer URI: https://hitshipo.com/
 * Text Domain: a2z_usps
 * Domain Path: /i18n/languages/
 *
 * WC requires at least: 2.6
 * WC tested up to: 5.8
 *
 *
 * @package WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if ( ! defined( 'A2Z_USPS_PLUGIN_FILE' ) ) {
	define( 'A2Z_USPS_PLUGIN_FILE', __FILE__ );
}

// Include the main WooCommerce class.
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
	if( !class_exists('a2z_usps_parent') ){
		Class a2z_usps_parent
		{
			private $errror = '';
			public function __construct() {
				add_action( 'woocommerce_shipping_init', array($this,'a2z_usps_init') );
				add_action( 'init', array($this,'hit_order_status_update') );
				add_filter( 'woocommerce_shipping_methods', array($this,'a2z_usps_method') );
				add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'a2z_usps_plugin_action_links' ) );
				add_action( 'add_meta_boxes', array($this, 'create_usps_shipping_meta_box' ));
				add_action( 'save_post', array($this, 'hit_create_usps_shipping'), 10, 1 );
				add_action( 'admin_menu', array($this, 'hit_usps_menu_page' ));
				add_action( 'woocommerce_checkout_order_processed', array( $this, 'hit_wc_checkout_order_processed' ) );
				// add_action( 'woocommerce_thankyou', array( $this, 'hit_wc_checkout_order_processed' ) );
				// add_action('woocommerce_order_details_after_order_table', array( $this, 'usps_track' ) );
				$general_settings = get_option('a2z_usps_main_settings');
				$general_settings = empty($general_settings) ? array() : $general_settings;

				if(isset($general_settings['a2z_usps_v_enable']) && $general_settings['a2z_usps_v_enable'] == 'yes' ){
					add_action( 'woocommerce_product_options_shipping', array($this,'hit_choose_vendor_address' ));
					add_action( 'woocommerce_process_product_meta', array($this,'hit_save_product_meta' ));

					// Edit User Hooks
					add_action( 'edit_user_profile', array($this,'hit_define_usps_credentails') );
					add_action( 'edit_user_profile_update', array($this, 'save_user_fields' ));

				}
			
			}
			function hit_usps_menu_page() {
				$general_settings = get_option('a2z_usps_main_settings');
				if (isset($general_settings['a2z_usps_integration_key']) && !empty($general_settings['a2z_usps_integration_key'])) {
					add_menu_page(__( 'USPS Labels', 'a2z_usps' ), 'USPS Labels', 'manage_options', 'hit-usps-labels', array($this,'my_label_page_contents'), '', 6);
				}
			}
			function my_label_page_contents(){
				$general_settings = get_option('a2z_usps_main_settings');
				$url = site_url();
				if (isset($general_settings['a2z_usps_integration_key']) && !empty($general_settings['a2z_usps_integration_key'])) {
					echo "<iframe style='width: 100%;height: 100vh;' src='https://app.hitshipo.com/embed/label.php?shop=".$url."&key=".$general_settings['a2z_usps_integration_key']."&show=ship'></iframe>";
				}
            }
			public function usps_track($order){
				
			}
			public function save_user_fields($user_id){
				if(isset($_POST['a2z_usps_country'])){
					$general_settings['a2z_usps_site_id'] = sanitize_text_field(isset($_POST['a2z_usps_site_id']) ? $_POST['a2z_usps_site_id'] : '');
					$general_settings['a2z_usps_site_pwd'] = sanitize_text_field(isset($_POST['a2z_usps_site_pwd']) ? $_POST['a2z_usps_site_pwd'] : '');
					$general_settings['a2z_usps_shipper_name'] = sanitize_text_field(isset($_POST['a2z_usps_shipper_name']) ? $_POST['a2z_usps_shipper_name'] : '');
					$general_settings['a2z_usps_company'] = sanitize_text_field(isset($_POST['a2z_usps_company']) ? $_POST['a2z_usps_company'] : '');
					$general_settings['a2z_usps_mob_num'] = sanitize_text_field(isset($_POST['a2z_usps_mob_num']) ? $_POST['a2z_usps_mob_num'] : '');
					$general_settings['a2z_usps_email'] = sanitize_text_field(isset($_POST['a2z_usps_email']) ? $_POST['a2z_usps_email'] : '');
					$general_settings['a2z_usps_address1'] = sanitize_text_field(isset($_POST['a2z_usps_address1']) ? $_POST['a2z_usps_address1'] : '');
					$general_settings['a2z_usps_address2'] = sanitize_text_field(isset($_POST['a2z_usps_address2']) ? $_POST['a2z_usps_address2'] : '');
					$general_settings['a2z_usps_city'] = sanitize_text_field(isset($_POST['a2z_usps_city']) ? $_POST['a2z_usps_city'] : '');
					$general_settings['a2z_usps_state'] = sanitize_text_field(isset($_POST['a2z_usps_state']) ? $_POST['a2z_usps_state'] : '');
					$general_settings['a2z_usps_zip'] = sanitize_text_field(isset($_POST['a2z_usps_zip']) ? $_POST['a2z_usps_zip'] : '');
					$general_settings['a2z_usps_country'] = sanitize_text_field(isset($_POST['a2z_usps_country']) ? $_POST['a2z_usps_country'] : '');
					$general_settings['a2z_usps_con_rate'] = sanitize_text_field(isset($_POST['a2z_usps_con_rate']) ? $_POST['a2z_usps_con_rate'] : '');
					$general_settings['a2z_usps_def_dom'] = sanitize_text_field(isset($_POST['a2z_usps_def_dom']) ? $_POST['a2z_usps_def_dom'] : '');

					$general_settings['a2z_usps_def_inter'] = sanitize_text_field(isset($_POST['a2z_usps_def_inter']) ? $_POST['a2z_usps_def_inter'] : '');

					update_post_meta($user_id,'a2z_usps_vendor_settings',$general_settings);
				}

			}

			public function hit_define_usps_credentails( $user ){

				$main_settings = get_option('a2z_usps_main_settings');
				$main_settings = empty($main_settings) ? array() : $main_settings;
				$allow = false;
				
				if(!isset($main_settings['a2z_usps_v_roles'])){
					return;
				}else{
					foreach ($user->roles as $value) {
						if(in_array($value, $main_settings['a2z_usps_v_roles'])){
							$allow = true;
						}
					}
				}
				
				if(!$allow){
					return;
				}

				$general_settings = get_post_meta($user->ID,'a2z_usps_vendor_settings',true);
				$general_settings = empty($general_settings) ? array() : $general_settings;
				$countires =  array(
									'AF' => 'Afghanistan',
									'AL' => 'Albania',
									'DZ' => 'Algeria',
									'AS' => 'American Samoa',
									'AD' => 'Andorra',
									'AO' => 'Angola',
									'AI' => 'Anguilla',
									'AG' => 'Antigua and Barbuda',
									'AR' => 'Argentina',
									'AM' => 'Armenia',
									'AW' => 'Aruba',
									'AU' => 'Australia',
									'AT' => 'Austria',
									'AZ' => 'Azerbaijan',
									'BS' => 'Bahamas',
									'BH' => 'Bahrain',
									'BD' => 'Bangladesh',
									'BB' => 'Barbados',
									'BY' => 'Belarus',
									'BE' => 'Belgium',
									'BZ' => 'Belize',
									'BJ' => 'Benin',
									'BM' => 'Bermuda',
									'BT' => 'Bhutan',
									'BO' => 'Bolivia',
									'BA' => 'Bosnia and Herzegovina',
									'BW' => 'Botswana',
									'BR' => 'Brazil',
									'VG' => 'British Virgin Islands',
									'BN' => 'Brunei',
									'BG' => 'Bulgaria',
									'BF' => 'Burkina Faso',
									'BI' => 'Burundi',
									'KH' => 'Cambodia',
									'CM' => 'Cameroon',
									'CA' => 'Canada',
									'CV' => 'Cape Verde',
									'KY' => 'Cayman Islands',
									'CF' => 'Central African Republic',
									'TD' => 'Chad',
									'CL' => 'Chile',
									'CN' => 'China',
									'CO' => 'Colombia',
									'KM' => 'Comoros',
									'CK' => 'Cook Islands',
									'CR' => 'Costa Rica',
									'HR' => 'Croatia',
									'CU' => 'Cuba',
									'CY' => 'Cyprus',
									'CZ' => 'Czech Republic',
									'DK' => 'Denmark',
									'DJ' => 'Djibouti',
									'DM' => 'Dominica',
									'DO' => 'Dominican Republic',
									'TL' => 'East Timor',
									'EC' => 'Ecuador',
									'EG' => 'Egypt',
									'SV' => 'El Salvador',
									'GQ' => 'Equatorial Guinea',
									'ER' => 'Eritrea',
									'EE' => 'Estonia',
									'ET' => 'Ethiopia',
									'FK' => 'Falkland Islands',
									'FO' => 'Faroe Islands',
									'FJ' => 'Fiji',
									'FI' => 'Finland',
									'FR' => 'France',
									'GF' => 'French Guiana',
									'PF' => 'French Polynesia',
									'GA' => 'Gabon',
									'GM' => 'Gambia',
									'GE' => 'Georgia',
									'DE' => 'Germany',
									'GH' => 'Ghana',
									'GI' => 'Gibraltar',
									'GR' => 'Greece',
									'GL' => 'Greenland',
									'GD' => 'Grenada',
									'GP' => 'Guadeloupe',
									'GU' => 'Guam',
									'GT' => 'Guatemala',
									'GG' => 'Guernsey',
									'GN' => 'Guinea',
									'GW' => 'Guinea-Bissau',
									'GY' => 'Guyana',
									'HT' => 'Haiti',
									'HN' => 'Honduras',
									'HK' => 'Hong Kong',
									'HU' => 'Hungary',
									'IS' => 'Iceland',
									'IN' => 'India',
									'ID' => 'Indonesia',
									'IR' => 'Iran',
									'IQ' => 'Iraq',
									'IE' => 'Ireland',
									'IL' => 'Israel',
									'IT' => 'Italy',
									'CI' => 'Ivory Coast',
									'JM' => 'Jamaica',
									'JP' => 'Japan',
									'JE' => 'Jersey',
									'JO' => 'Jordan',
									'KZ' => 'Kazakhstan',
									'KE' => 'Kenya',
									'KI' => 'Kiribati',
									'KW' => 'Kuwait',
									'KG' => 'Kyrgyzstan',
									'LA' => 'Laos',
									'LV' => 'Latvia',
									'LB' => 'Lebanon',
									'LS' => 'Lesotho',
									'LR' => 'Liberia',
									'LY' => 'Libya',
									'LI' => 'Liechtenstein',
									'LT' => 'Lithuania',
									'LU' => 'Luxembourg',
									'MO' => 'Macao',
									'MK' => 'Macedonia',
									'MG' => 'Madagascar',
									'MW' => 'Malawi',
									'MY' => 'Malaysia',
									'MV' => 'Maldives',
									'ML' => 'Mali',
									'MT' => 'Malta',
									'MH' => 'Marshall Islands',
									'MQ' => 'Martinique',
									'MR' => 'Mauritania',
									'MU' => 'Mauritius',
									'YT' => 'Mayotte',
									'MX' => 'Mexico',
									'FM' => 'Micronesia',
									'MD' => 'Moldova',
									'MC' => 'Monaco',
									'MN' => 'Mongolia',
									'ME' => 'Montenegro',
									'MS' => 'Montserrat',
									'MA' => 'Morocco',
									'MZ' => 'Mozambique',
									'MM' => 'Myanmar',
									'NA' => 'Namibia',
									'NR' => 'Nauru',
									'NP' => 'Nepal',
									'NL' => 'Netherlands',
									'NC' => 'New Caledonia',
									'NZ' => 'New Zealand',
									'NI' => 'Nicaragua',
									'NE' => 'Niger',
									'NG' => 'Nigeria',
									'NU' => 'Niue',
									'KP' => 'North Korea',
									'MP' => 'Northern Mariana Islands',
									'NO' => 'Norway',
									'OM' => 'Oman',
									'PK' => 'Pakistan',
									'PW' => 'Palau',
									'PA' => 'Panama',
									'PG' => 'Papua New Guinea',
									'PY' => 'Paraguay',
									'PE' => 'Peru',
									'PH' => 'Philippines',
									'PL' => 'Poland',
									'PT' => 'Portugal',
									'PR' => 'Puerto Rico',
									'QA' => 'Qatar',
									'CG' => 'Republic of the Congo',
									'RE' => 'Reunion',
									'RO' => 'Romania',
									'RU' => 'Russia',
									'RW' => 'Rwanda',
									'SH' => 'Saint Helena',
									'KN' => 'Saint Kitts and Nevis',
									'LC' => 'Saint Lucia',
									'VC' => 'Saint Vincent and the Grenadines',
									'WS' => 'Samoa',
									'SM' => 'San Marino',
									'ST' => 'Sao Tome and Principe',
									'SA' => 'Saudi Arabia',
									'SN' => 'Senegal',
									'RS' => 'Serbia',
									'SC' => 'Seychelles',
									'SL' => 'Sierra Leone',
									'SG' => 'Singapore',
									'SK' => 'Slovakia',
									'SI' => 'Slovenia',
									'SB' => 'Solomon Islands',
									'SO' => 'Somalia',
									'ZA' => 'South Africa',
									'KR' => 'South Korea',
									'SS' => 'South Sudan',
									'ES' => 'Spain',
									'LK' => 'Sri Lanka',
									'SD' => 'Sudan',
									'SR' => 'Suriname',
									'SZ' => 'Swaziland',
									'SE' => 'Sweden',
									'CH' => 'Switzerland',
									'SY' => 'Syria',
									'TW' => 'Taiwan',
									'TJ' => 'Tajikistan',
									'TZ' => 'Tanzania',
									'TH' => 'Thailand',
									'TG' => 'Togo',
									'TO' => 'Tonga',
									'TT' => 'Trinidad and Tobago',
									'TN' => 'Tunisia',
									'TR' => 'Turkey',
									'TC' => 'Turks and Caicos Islands',
									'TV' => 'Tuvalu',
									'VI' => 'U.S. Virgin Islands',
									'UG' => 'Uganda',
									'UA' => 'Ukraine',
									'AE' => 'United Arab Emirates',
									'GB' => 'United Kingdom',
									'US' => 'United States',
									'UY' => 'Uruguay',
									'UZ' => 'Uzbekistan',
									'VU' => 'Vanuatu',
									'VE' => 'Venezuela',
									'VN' => 'Vietnam',
									'YE' => 'Yemen',
									'ZM' => 'Zambia',
									'ZW' => 'Zimbabwe',
								);
				 $_usps_carriers = array(
					//"Public carrier name" => "technical name",
					'Priority_Mail_1_Day'	=>	'Priority Mail 1-Day',
					'Priority_Mail_1_Day_Large_Flat_Rate_Box'	=>	'Priority Mail 1-Day - Large Flat Rate Box',
					'Priority_Mail_1_Day_Medium_Flat_Rate_Box'	=>	'Priority Mail 1-Day - Medium Flat Rate Box',
					'Priority_Mail_1_Day_Small_Flat_Rate_Box'	=>	'Priority Mail 1-Day - Small Flat Rate Box',
					'Priority_Mail_1_Day_Regional_Rate_Box_A'	=>	'Priority Mail 1-Day - Regional Rate Box A',
					'Priority_Mail_1_Day_Regional_Rate_Box_B'	=>	'Priority Mail 1-Day - Regional Rate Box B',
					'Priority_Mail_1_Day_Flat_Rate_Envelope'	=>	'Priority Mail 1-Day - Flat Rate Envelope',
					'Priority_Mail_1_Day_Legal_Flat_Rate_Envelope'	=>	'Priority Mail 1-Day - Legal Flat Rate Envelope',
					'Priority_Mail_1_Day_Padded_Flat_Rate_Envelope'	=>	'Priority Mail 1-Day - Padded Flat Rate Envelope',
					'Priority_Mail_1_Day_Gift_Card_Flat_Rate_Envelope'	=>	'Priority Mail 1-Day - Gift Card Flat Rate Envelope',
					'Priority_Mail_1_Day_Small_Flat_Rate_Envelope'	=>	'Priority Mail 1-Day - Small Flat Rate Envelope',
					'Priority_Mail_1_Day_Window_Flat_Rate_Envelope'	=>	'Priority Mail 1-Day - Window Flat Rate Envelope',
					'Priority_Mail_3_Day'	=>	'Priority Mail 3-Day',
					'Priority_Mail_3_Day_Large_Flat_Rate_Box'	=> 'Priority Mail 3-Day - Large Flat Rate Box',
					'Priority_Mail_3_Day_Medium_Flat_Rate_Box'	=> 'Priority Mail 3-Day - Medium Flat Rate Box',
					'Priority_Mail_3_Day_Small_Flat_Rate_Box'	=> 'Priority Mail 3-Day - Small Flat Rate Box',
					'Priority_Mail_3_Day_Flat_Rate_Envelope'	=> 'Priority Mail 3-Day - Flat Rate Envelope',
					'Priority_Mail_3_Day_Legal_Flat_Rate_Envelope'	=> 'Priority Mail 3-Day - Legal Flat Rate Envelope',
					'Priority_Mail_3_Day_Padded_Flat_Rate_Envelope'	=> 'Priority Mail 3-Day - Padded Flat Rate Envelope',
					'Priority_Mail_3_Day_Gift_Card_Flat_Rate_Envelope'	=> 'Priority Mail 3-Day - Gift Card Flat Rate Envelope',
					'Priority_Mail_3_Day_Small_Flat_Rate_Envelope'	=> 'Priority Mail 3-Day - Small Flat Rate Envelope',
					'Priority_Mail_3_Day_Window_Flat_Rate_Envelope'	=> 'Priority Mail 3-Day - Window Flat Rate Envelope',
					'Priority_Mail_3_Day_Regional_Rate_Box_A'	=>	'Priority Mail 3-Day - Regional Rate Box A',
					'Priority_Mail_3_Day_Regional_Rate_Box_B'	=>	'Priority Mail 3-Day - Regional Rate Box B',
					'Priority_Mail_Express_1_Day'	=>	'Priority Mail Express 1-Day',
					'Priority_Mail_Express_1_Day_Flat_Rate_Envelope'	=>	'Priority Mail Express 1-Day - Flat Rate Envelope',
					'Priority_Mail_Express_1_Day_Legal_Flat_Rate_Envelope'	=>	'Priority Mail Express 1-Day Legal Flat Rate Envelope',
					'Priority_Mail_Express_1_Day_Padded_Flat_Rate_Envelope'	=>	'Priority Mail Express 1-Day - Padded Flat Rate Envelope',
					'Priority_Mail_Express_2_Day'	=> 'Priority Mail Express 2-Day',
					'Priority_Mail_Express_2_Day_Flat_Rate_Envelope'	=> 'Priority Mail Express 2-Day - Flat Rate Envelope',
					'Priority_Mail_Express_2_Day_Legal_Flat_Rate_Envelope'	=>	'Priority Mail Express 2-Day - Legal Flat Rate Envelope',
					'Priority_Mail_Express_2_Day_Padded_Flat_Rate_Envelope'	=> 'Priority Mail Express 2-Day - Padded Flat Rate Envelope',
					'First_Class_Mail_Stamped_Letter'	 => 'First-Class Mail - Stamped Letter',
					'First_Class_Mail_Metered_Letter'	=> 'First-Class Mail - Metered Letter',
					'First_Class_Package_Service'	=>	'First-Class Package Service',
					'First_Class_Package_Service_Retail'	 => 'First-Class Package Service - Retail',
					'First_Class_Mail_Large_Envelope'	=> 'First-Class Mail - Large Envelope',
					'First_Class_Mail_Postcards'	=> 'First-Class Mail - Postcards',
					'First_Class_Mail_Large_Postcards'	=> 'First-Class Mail - Large Postcards',
					'Parcel_Select_Ground'	=>	'Parcel Select Ground',
					'Media_Mail_Parcel'	=> 'Media Mail Parcel',
					'Priority_Mail_1_Day_Cubic'	=>	'Priority Mail 1-Day - Cubic',		
					'Library_Mail_Parcel'	 => 'Library Mail Parcel',
					'USPS_GXG_Envelopes'	=>	'USPS GXG Envelopes (International)',
					'Priority_Mail_Express_International'	=>	'Priority Mail Express International',
					'Priority_Mail_International'	=>	'Priority Mail International',
					'Priority_Mail_International_Large_Flat_Rate_Box'	=>	'Priority Mail International Large Flat Rate Box',
					'Priority_Mail_International_Medium_Flat_Rate_Box'	=>	'Priority Mail International Medium Flat Rate Box'


					// 'Priority Mail 1-Day Hold For Pickup'	=>	'Priority Mail 1-Day - Hold For Pickup',
					// 'Priority Mail 1-Day Large Flat Rate Box Hold For Pickup'	=>	'Priority Mail 1-Day - Large Flat Rate Box Hold For Pickup',
					// 'Priority Mail 1-Day Medium Flat Rate Box Hold For Pickup'	=>	'Priority Mail 1-Day - Medium Flat Rate Box Hold For Pickup',
					// 'Priority Mail 1-Day Small Flat Rate Box Hold For Pickup'	=>	'Priority Mail 1-Day - Small Flat Rate Box Hold For Pickup',
					// 'Priority Mail 1-Day Regional Rate Box A Hold For Pickup'	=>	'Priority Mail 1-Day - Regional Rate Box A Hold For Pickup',
					// 'Priority Mail 1-Day Regional Rate Box B Hold For Pickup'	=>	'Priority Mail 1-Day - Regional Rate Box B Hold For Pickup',
					// 'Priority Mail 1-Day Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 1-Day - Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 1-Day Legal Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 1-Day - Legal Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 1-Day Padded Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 1-Day - Padded Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 1-Day Gift Card Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 1-Day - Gift Card Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 1-Day Small Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 1-Day - Small Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 1-Day Window Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 1-Day - Window Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 3-Day Hold For Pickup'	=>	'Priority Mail 3-Day - Hold For Pickup',
					// 'Priority Mail 3-Day Large Flat Rate Box Hold For Pickup'	=>	'Priority Mail 3-Day - Large Flat Rate Box Hold For Pickup',
					// 'Priority Mail 3-Day Medium Flat Rate Box Hold For Pickup'	=>	'Priority Mail 3-Day - Medium Flat Rate Box Hold For Pickup',
					// 'Priority Mail 3-Day Small Flat Rate Box Hold For Pickup'	=>	'Priority Mail 3-Day - Small Flat Rate Box Hold For Pickup',
					// 'Priority Mail 3-Day Regional Rate Box A Hold For Pickup'	=>	'Priority Mail 3-Day - Regional Rate Box A Hold For Pickup',
					// 'Priority Mail 3-Day Regional Rate Box B Hold For Pickup'	=>	'Priority Mail 3-Day - Regional Rate Box B Hold For Pickup',
					// 'Priority Mail 3-Day Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 3-Day - Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 3-Day Legal Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 3-Day - Legal Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 3-Day Padded Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 3-Day Padded Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 3-Day Gift Card Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 3-Day - Gift Card Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 3-Day Small Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 3-Day - Small Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail 3-Day Window Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail 3-Day - Window Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail Express 1-Day Hold For Pickup'	=>	'Priority Mail Express 1-Day - Hold For Pickup',
					// 'Priority Mail Express 1-Day Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail Express 1-Day - Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail Express 1-Day Legal Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail Express 1-Day - Legal Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail Express 1-Day Padded Flat Rate Envelope Hold For Pickup'	=>	'Priority Mail Express 1-Day - Padded Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail Express 2-Day Hold For Pickup'                    => 'Priority Mail Express 2-Day - Hold For Pickup',
					// 'Priority Mail Express 2-Day Flat Rate Envelope Hold For Pickup'                    => 'Priority Mail Express 2-Day - Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail Express 2-Day Legal Flat Rate Envelope Hold For Pickup'                    => 'Priority Mail Express 2-Day - Legal Flat Rate Envelope Hold For Pickup',
					// 'Priority Mail Express 2-Day Padded Flat Rate Envelope Hold For Pickup'                    => 'Priority Mail Express 2-Day - Padded Flat Rate Envelope Hold For Pickup',
					// 'First-Class Package Service Hold For Pickup'	=>	'First-Class Package Service - Hold For Pickup',
				);

			$usps_core = array();
			$usps_core['AD'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['AE'] = array('region' => 'AP', 'currency' =>'AED', 'weight' => 'KG_CM');
			$usps_core['AF'] = array('region' => 'AP', 'currency' =>'AFN', 'weight' => 'KG_CM');
			$usps_core['AG'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
			$usps_core['AI'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
			$usps_core['AL'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['AM'] = array('region' => 'AP', 'currency' =>'AMD', 'weight' => 'KG_CM');
			$usps_core['AN'] = array('region' => 'AM', 'currency' =>'ANG', 'weight' => 'KG_CM');
			$usps_core['AO'] = array('region' => 'AP', 'currency' =>'AOA', 'weight' => 'KG_CM');
			$usps_core['AR'] = array('region' => 'AM', 'currency' =>'ARS', 'weight' => 'KG_CM');
			$usps_core['AS'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['AT'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['AU'] = array('region' => 'AP', 'currency' =>'AUD', 'weight' => 'KG_CM');
			$usps_core['AW'] = array('region' => 'AM', 'currency' =>'AWG', 'weight' => 'LB_IN');
			$usps_core['AZ'] = array('region' => 'AM', 'currency' =>'AZN', 'weight' => 'KG_CM');
			$usps_core['AZ'] = array('region' => 'AM', 'currency' =>'AZN', 'weight' => 'KG_CM');
			$usps_core['GB'] = array('region' => 'EU', 'currency' =>'GBP', 'weight' => 'KG_CM');
			$usps_core['BA'] = array('region' => 'AP', 'currency' =>'BAM', 'weight' => 'KG_CM');
			$usps_core['BB'] = array('region' => 'AM', 'currency' =>'BBD', 'weight' => 'LB_IN');
			$usps_core['BD'] = array('region' => 'AP', 'currency' =>'BDT', 'weight' => 'KG_CM');
			$usps_core['BE'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['BF'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
			$usps_core['BG'] = array('region' => 'EU', 'currency' =>'BGN', 'weight' => 'KG_CM');
			$usps_core['BH'] = array('region' => 'AP', 'currency' =>'BHD', 'weight' => 'KG_CM');
			$usps_core['BI'] = array('region' => 'AP', 'currency' =>'BIF', 'weight' => 'KG_CM');
			$usps_core['BJ'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
			$usps_core['BM'] = array('region' => 'AM', 'currency' =>'BMD', 'weight' => 'LB_IN');
			$usps_core['BN'] = array('region' => 'AP', 'currency' =>'BND', 'weight' => 'KG_CM');
			$usps_core['BO'] = array('region' => 'AM', 'currency' =>'BOB', 'weight' => 'KG_CM');
			$usps_core['BR'] = array('region' => 'AM', 'currency' =>'BRL', 'weight' => 'KG_CM');
			$usps_core['BS'] = array('region' => 'AM', 'currency' =>'BSD', 'weight' => 'LB_IN');
			$usps_core['BT'] = array('region' => 'AP', 'currency' =>'BTN', 'weight' => 'KG_CM');
			$usps_core['BW'] = array('region' => 'AP', 'currency' =>'BWP', 'weight' => 'KG_CM');
			$usps_core['BY'] = array('region' => 'AP', 'currency' =>'BYR', 'weight' => 'KG_CM');
			$usps_core['BZ'] = array('region' => 'AM', 'currency' =>'BZD', 'weight' => 'KG_CM');
			$usps_core['CA'] = array('region' => 'AM', 'currency' =>'CAD', 'weight' => 'LB_IN');
			$usps_core['CF'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
			$usps_core['CG'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
			$usps_core['CH'] = array('region' => 'EU', 'currency' =>'CHF', 'weight' => 'KG_CM');
			$usps_core['CI'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
			$usps_core['CK'] = array('region' => 'AP', 'currency' =>'NZD', 'weight' => 'KG_CM');
			$usps_core['CL'] = array('region' => 'AM', 'currency' =>'CLP', 'weight' => 'KG_CM');
			$usps_core['CM'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
			$usps_core['CN'] = array('region' => 'AP', 'currency' =>'CNY', 'weight' => 'KG_CM');
			$usps_core['CO'] = array('region' => 'AM', 'currency' =>'COP', 'weight' => 'KG_CM');
			$usps_core['CR'] = array('region' => 'AM', 'currency' =>'CRC', 'weight' => 'KG_CM');
			$usps_core['CU'] = array('region' => 'AM', 'currency' =>'CUC', 'weight' => 'KG_CM');
			$usps_core['CV'] = array('region' => 'AP', 'currency' =>'CVE', 'weight' => 'KG_CM');
			$usps_core['CY'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['CZ'] = array('region' => 'EU', 'currency' =>'CZK', 'weight' => 'KG_CM');
			$usps_core['DE'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['DJ'] = array('region' => 'EU', 'currency' =>'DJF', 'weight' => 'KG_CM');
			$usps_core['DK'] = array('region' => 'AM', 'currency' =>'DKK', 'weight' => 'KG_CM');
			$usps_core['DM'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
			$usps_core['DO'] = array('region' => 'AP', 'currency' =>'DOP', 'weight' => 'LB_IN');
			$usps_core['DZ'] = array('region' => 'AM', 'currency' =>'DZD', 'weight' => 'KG_CM');
			$usps_core['EC'] = array('region' => 'EU', 'currency' =>'USD', 'weight' => 'KG_CM');
			$usps_core['EE'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['EG'] = array('region' => 'AP', 'currency' =>'EGP', 'weight' => 'KG_CM');
			$usps_core['ER'] = array('region' => 'EU', 'currency' =>'ERN', 'weight' => 'KG_CM');
			$usps_core['ES'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['ET'] = array('region' => 'AU', 'currency' =>'ETB', 'weight' => 'KG_CM');
			$usps_core['FI'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['FJ'] = array('region' => 'AP', 'currency' =>'FJD', 'weight' => 'KG_CM');
			$usps_core['FK'] = array('region' => 'AM', 'currency' =>'GBP', 'weight' => 'KG_CM');
			$usps_core['FM'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['FO'] = array('region' => 'AM', 'currency' =>'DKK', 'weight' => 'KG_CM');
			$usps_core['FR'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['GA'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
			$usps_core['GB'] = array('region' => 'EU', 'currency' =>'GBP', 'weight' => 'KG_CM');
			$usps_core['GD'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
			$usps_core['GE'] = array('region' => 'AM', 'currency' =>'GEL', 'weight' => 'KG_CM');
			$usps_core['GF'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['GG'] = array('region' => 'AM', 'currency' =>'GBP', 'weight' => 'KG_CM');
			$usps_core['GH'] = array('region' => 'AP', 'currency' =>'GHS', 'weight' => 'KG_CM');
			$usps_core['GI'] = array('region' => 'AM', 'currency' =>'GBP', 'weight' => 'KG_CM');
			$usps_core['GL'] = array('region' => 'AM', 'currency' =>'DKK', 'weight' => 'KG_CM');
			$usps_core['GM'] = array('region' => 'AP', 'currency' =>'GMD', 'weight' => 'KG_CM');
			$usps_core['GN'] = array('region' => 'AP', 'currency' =>'GNF', 'weight' => 'KG_CM');
			$usps_core['GP'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['GQ'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
			$usps_core['GR'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['GT'] = array('region' => 'AM', 'currency' =>'GTQ', 'weight' => 'KG_CM');
			$usps_core['GU'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['GW'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
			$usps_core['GY'] = array('region' => 'AP', 'currency' =>'GYD', 'weight' => 'LB_IN');
			$usps_core['HK'] = array('region' => 'AM', 'currency' =>'HKD', 'weight' => 'KG_CM');
			$usps_core['HN'] = array('region' => 'AM', 'currency' =>'HNL', 'weight' => 'KG_CM');
			$usps_core['HR'] = array('region' => 'AP', 'currency' =>'HRK', 'weight' => 'KG_CM');
			$usps_core['HT'] = array('region' => 'AM', 'currency' =>'HTG', 'weight' => 'LB_IN');
			$usps_core['HU'] = array('region' => 'EU', 'currency' =>'HUF', 'weight' => 'KG_CM');
			$usps_core['IC'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['ID'] = array('region' => 'AP', 'currency' =>'IDR', 'weight' => 'KG_CM');
			$usps_core['IE'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['IL'] = array('region' => 'AP', 'currency' =>'ILS', 'weight' => 'KG_CM');
			$usps_core['IN'] = array('region' => 'AP', 'currency' =>'INR', 'weight' => 'KG_CM');
			$usps_core['IQ'] = array('region' => 'AP', 'currency' =>'IQD', 'weight' => 'KG_CM');
			$usps_core['IR'] = array('region' => 'AP', 'currency' =>'IRR', 'weight' => 'KG_CM');
			$usps_core['IS'] = array('region' => 'EU', 'currency' =>'ISK', 'weight' => 'KG_CM');
			$usps_core['IT'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['JE'] = array('region' => 'AM', 'currency' =>'GBP', 'weight' => 'KG_CM');
			$usps_core['JM'] = array('region' => 'AM', 'currency' =>'JMD', 'weight' => 'KG_CM');
			$usps_core['JO'] = array('region' => 'AP', 'currency' =>'JOD', 'weight' => 'KG_CM');
			$usps_core['JP'] = array('region' => 'AP', 'currency' =>'JPY', 'weight' => 'KG_CM');
			$usps_core['KE'] = array('region' => 'AP', 'currency' =>'KES', 'weight' => 'KG_CM');
			$usps_core['KG'] = array('region' => 'AP', 'currency' =>'KGS', 'weight' => 'KG_CM');
			$usps_core['KH'] = array('region' => 'AP', 'currency' =>'KHR', 'weight' => 'KG_CM');
			$usps_core['KI'] = array('region' => 'AP', 'currency' =>'AUD', 'weight' => 'KG_CM');
			$usps_core['KM'] = array('region' => 'AP', 'currency' =>'KMF', 'weight' => 'KG_CM');
			$usps_core['KN'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
			$usps_core['KP'] = array('region' => 'AP', 'currency' =>'KPW', 'weight' => 'LB_IN');
			$usps_core['KR'] = array('region' => 'AP', 'currency' =>'KRW', 'weight' => 'KG_CM');
			$usps_core['KV'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['KW'] = array('region' => 'AP', 'currency' =>'KWD', 'weight' => 'KG_CM');
			$usps_core['KY'] = array('region' => 'AM', 'currency' =>'KYD', 'weight' => 'KG_CM');
			$usps_core['KZ'] = array('region' => 'AP', 'currency' =>'KZF', 'weight' => 'LB_IN');
			$usps_core['LA'] = array('region' => 'AP', 'currency' =>'LAK', 'weight' => 'KG_CM');
			$usps_core['LB'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
			$usps_core['LC'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'KG_CM');
			$usps_core['LI'] = array('region' => 'AM', 'currency' =>'CHF', 'weight' => 'LB_IN');
			$usps_core['LK'] = array('region' => 'AP', 'currency' =>'LKR', 'weight' => 'KG_CM');
			$usps_core['LR'] = array('region' => 'AP', 'currency' =>'LRD', 'weight' => 'KG_CM');
			$usps_core['LS'] = array('region' => 'AP', 'currency' =>'LSL', 'weight' => 'KG_CM');
			$usps_core['LT'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['LU'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['LV'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['LY'] = array('region' => 'AP', 'currency' =>'LYD', 'weight' => 'KG_CM');
			$usps_core['MA'] = array('region' => 'AP', 'currency' =>'MAD', 'weight' => 'KG_CM');
			$usps_core['MC'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['MD'] = array('region' => 'AP', 'currency' =>'MDL', 'weight' => 'KG_CM');
			$usps_core['ME'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['MG'] = array('region' => 'AP', 'currency' =>'MGA', 'weight' => 'KG_CM');
			$usps_core['MH'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['MK'] = array('region' => 'AP', 'currency' =>'MKD', 'weight' => 'KG_CM');
			$usps_core['ML'] = array('region' => 'AP', 'currency' =>'COF', 'weight' => 'KG_CM');
			$usps_core['MM'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
			$usps_core['MN'] = array('region' => 'AP', 'currency' =>'MNT', 'weight' => 'KG_CM');
			$usps_core['MO'] = array('region' => 'AP', 'currency' =>'MOP', 'weight' => 'KG_CM');
			$usps_core['MP'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['MQ'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['MR'] = array('region' => 'AP', 'currency' =>'MRO', 'weight' => 'KG_CM');
			$usps_core['MS'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
			$usps_core['MT'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['MU'] = array('region' => 'AP', 'currency' =>'MUR', 'weight' => 'KG_CM');
			$usps_core['MV'] = array('region' => 'AP', 'currency' =>'MVR', 'weight' => 'KG_CM');
			$usps_core['MW'] = array('region' => 'AP', 'currency' =>'MWK', 'weight' => 'KG_CM');
			$usps_core['MX'] = array('region' => 'AM', 'currency' =>'MXN', 'weight' => 'KG_CM');
			$usps_core['MY'] = array('region' => 'AP', 'currency' =>'MYR', 'weight' => 'KG_CM');
			$usps_core['MZ'] = array('region' => 'AP', 'currency' =>'MZN', 'weight' => 'KG_CM');
			$usps_core['NA'] = array('region' => 'AP', 'currency' =>'NAD', 'weight' => 'KG_CM');
			$usps_core['NC'] = array('region' => 'AP', 'currency' =>'XPF', 'weight' => 'KG_CM');
			$usps_core['NE'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
			$usps_core['NG'] = array('region' => 'AP', 'currency' =>'NGN', 'weight' => 'KG_CM');
			$usps_core['NI'] = array('region' => 'AM', 'currency' =>'NIO', 'weight' => 'KG_CM');
			$usps_core['NL'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['NO'] = array('region' => 'EU', 'currency' =>'NOK', 'weight' => 'KG_CM');
			$usps_core['NP'] = array('region' => 'AP', 'currency' =>'NPR', 'weight' => 'KG_CM');
			$usps_core['NR'] = array('region' => 'AP', 'currency' =>'AUD', 'weight' => 'KG_CM');
			$usps_core['NU'] = array('region' => 'AP', 'currency' =>'NZD', 'weight' => 'KG_CM');
			$usps_core['NZ'] = array('region' => 'AP', 'currency' =>'NZD', 'weight' => 'KG_CM');
			$usps_core['OM'] = array('region' => 'AP', 'currency' =>'OMR', 'weight' => 'KG_CM');
			$usps_core['PA'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'KG_CM');
			$usps_core['PE'] = array('region' => 'AM', 'currency' =>'PEN', 'weight' => 'KG_CM');
			$usps_core['PF'] = array('region' => 'AP', 'currency' =>'XPF', 'weight' => 'KG_CM');
			$usps_core['PG'] = array('region' => 'AP', 'currency' =>'PGK', 'weight' => 'KG_CM');
			$usps_core['PH'] = array('region' => 'AP', 'currency' =>'PHP', 'weight' => 'KG_CM');
			$usps_core['PK'] = array('region' => 'AP', 'currency' =>'PKR', 'weight' => 'KG_CM');
			$usps_core['PL'] = array('region' => 'EU', 'currency' =>'PLN', 'weight' => 'KG_CM');
			$usps_core['PR'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['PT'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['PW'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'KG_CM');
			$usps_core['PY'] = array('region' => 'AM', 'currency' =>'PYG', 'weight' => 'KG_CM');
			$usps_core['QA'] = array('region' => 'AP', 'currency' =>'QAR', 'weight' => 'KG_CM');
			$usps_core['RE'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['RO'] = array('region' => 'EU', 'currency' =>'RON', 'weight' => 'KG_CM');
			$usps_core['RS'] = array('region' => 'AP', 'currency' =>'RSD', 'weight' => 'KG_CM');
			$usps_core['RU'] = array('region' => 'AP', 'currency' =>'RUB', 'weight' => 'KG_CM');
			$usps_core['RW'] = array('region' => 'AP', 'currency' =>'RWF', 'weight' => 'KG_CM');
			$usps_core['SA'] = array('region' => 'AP', 'currency' =>'SAR', 'weight' => 'KG_CM');
			$usps_core['SB'] = array('region' => 'AP', 'currency' =>'SBD', 'weight' => 'KG_CM');
			$usps_core['SC'] = array('region' => 'AP', 'currency' =>'SCR', 'weight' => 'KG_CM');
			$usps_core['SD'] = array('region' => 'AP', 'currency' =>'SDG', 'weight' => 'KG_CM');
			$usps_core['SE'] = array('region' => 'EU', 'currency' =>'SEK', 'weight' => 'KG_CM');
			$usps_core['SG'] = array('region' => 'AP', 'currency' =>'SGD', 'weight' => 'KG_CM');
			$usps_core['SH'] = array('region' => 'AP', 'currency' =>'SHP', 'weight' => 'KG_CM');
			$usps_core['SI'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['SK'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['SL'] = array('region' => 'AP', 'currency' =>'SLL', 'weight' => 'KG_CM');
			$usps_core['SM'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['SN'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
			$usps_core['SO'] = array('region' => 'AM', 'currency' =>'SOS', 'weight' => 'KG_CM');
			$usps_core['SR'] = array('region' => 'AM', 'currency' =>'SRD', 'weight' => 'KG_CM');
			$usps_core['SS'] = array('region' => 'AP', 'currency' =>'SSP', 'weight' => 'KG_CM');
			$usps_core['ST'] = array('region' => 'AP', 'currency' =>'STD', 'weight' => 'KG_CM');
			$usps_core['SV'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'KG_CM');
			$usps_core['SY'] = array('region' => 'AP', 'currency' =>'SYP', 'weight' => 'KG_CM');
			$usps_core['SZ'] = array('region' => 'AP', 'currency' =>'SZL', 'weight' => 'KG_CM');
			$usps_core['TC'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['TD'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
			$usps_core['TG'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
			$usps_core['TH'] = array('region' => 'AP', 'currency' =>'THB', 'weight' => 'KG_CM');
			$usps_core['TJ'] = array('region' => 'AP', 'currency' =>'TJS', 'weight' => 'KG_CM');
			$usps_core['TL'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
			$usps_core['TN'] = array('region' => 'AP', 'currency' =>'TND', 'weight' => 'KG_CM');
			$usps_core['TO'] = array('region' => 'AP', 'currency' =>'TOP', 'weight' => 'KG_CM');
			$usps_core['TR'] = array('region' => 'AP', 'currency' =>'TRY', 'weight' => 'KG_CM');
			$usps_core['TT'] = array('region' => 'AM', 'currency' =>'TTD', 'weight' => 'LB_IN');
			$usps_core['TV'] = array('region' => 'AP', 'currency' =>'AUD', 'weight' => 'KG_CM');
			$usps_core['TW'] = array('region' => 'AP', 'currency' =>'TWD', 'weight' => 'KG_CM');
			$usps_core['TZ'] = array('region' => 'AP', 'currency' =>'TZS', 'weight' => 'KG_CM');
			$usps_core['UA'] = array('region' => 'AP', 'currency' =>'UAH', 'weight' => 'KG_CM');
			$usps_core['UG'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
			$usps_core['US'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['UY'] = array('region' => 'AM', 'currency' =>'UYU', 'weight' => 'KG_CM');
			$usps_core['UZ'] = array('region' => 'AP', 'currency' =>'UZS', 'weight' => 'KG_CM');
			$usps_core['VC'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
			$usps_core['VE'] = array('region' => 'AM', 'currency' =>'VEF', 'weight' => 'KG_CM');
			$usps_core['VG'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['VI'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
			$usps_core['VN'] = array('region' => 'AP', 'currency' =>'VND', 'weight' => 'KG_CM');
			$usps_core['VU'] = array('region' => 'AP', 'currency' =>'VUV', 'weight' => 'KG_CM');
			$usps_core['WS'] = array('region' => 'AP', 'currency' =>'WST', 'weight' => 'KG_CM');
			$usps_core['XB'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'LB_IN');
			$usps_core['XC'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'LB_IN');
			$usps_core['XE'] = array('region' => 'AM', 'currency' =>'ANG', 'weight' => 'LB_IN');
			$usps_core['XM'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'LB_IN');
			$usps_core['XN'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
			$usps_core['XS'] = array('region' => 'AP', 'currency' =>'SIS', 'weight' => 'KG_CM');
			$usps_core['XY'] = array('region' => 'AM', 'currency' =>'ANG', 'weight' => 'LB_IN');
			$usps_core['YE'] = array('region' => 'AP', 'currency' =>'YER', 'weight' => 'KG_CM');
			$usps_core['YT'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
			$usps_core['ZA'] = array('region' => 'AP', 'currency' =>'ZAR', 'weight' => 'KG_CM');
			$usps_core['ZM'] = array('region' => 'AP', 'currency' =>'ZMW', 'weight' => 'KG_CM');
			$usps_core['ZW'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');

				 echo '<hr><h3 class="heading">USPS - <a href="https://hitshipo.com/" target="_blank">HITShipo</a></h3>';
				    ?>
				    
				    <table class="form-table">
						<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('USPS Integration Team will give this details to you.','a2z_usps') ?>"></span>	<?php _e('USPS XML API Site ID','a2z_usps') ?></h4>
							<p> <?php _e('Leave this field as empty to use default account.','a2z_usps') ?> </p>
						</td>
						<td>
							<input type="text" name="a2z_usps_site_id" value="<?php echo (isset($general_settings['a2z_usps_site_id'])) ? $general_settings['a2z_usps_site_id'] : ''; ?>">
						</td>

					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('USPS Integration Team will give this details to you.','a2z_usps') ?>"></span>	<?php _e('USPS XML API Password','a2z_usps') ?></h4>
							<p> <?php _e('Leave this field as empty to use default account.','a2z_usps') ?> </p>
						</td>
						<td>
							<input type="text" name="a2z_usps_site_pwd" value="<?php echo (isset($general_settings['a2z_usps_site_pwd'])) ? $general_settings['a2z_usps_site_pwd'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Shipping Person Name','a2z_usps') ?>"></span>	<?php _e('Shipper Name','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_shipper_name" value="<?php echo (isset($general_settings['a2z_usps_shipper_name'])) ? $general_settings['a2z_usps_shipper_name'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Shipper Company Name.','a2z_usps') ?>"></span>	<?php _e('Company Name','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_company" value="<?php echo (isset($general_settings['a2z_usps_company'])) ? $general_settings['a2z_usps_company'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Shipper Mobile / Contact Number.','a2z_usps') ?>"></span>	<?php _e('Contact Number','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_mob_num" value="<?php echo (isset($general_settings['a2z_usps_mob_num'])) ? $general_settings['a2z_usps_mob_num'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Email Address of the Shipper.','a2z_usps') ?>"></span>	<?php _e('Email Address','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_email" value="<?php echo (isset($general_settings['a2z_usps_email'])) ? $general_settings['a2z_usps_email'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Address Line 1 of the Shipper from Address.','a2z_usps') ?>"></span>	<?php _e('Address Line 1','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_address1" value="<?php echo (isset($general_settings['a2z_usps_address1'])) ? $general_settings['a2z_usps_address1'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Address Line 2 of the Shipper from Address.','a2z_usps') ?>"></span>	<?php _e('Address Line 2','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_address2" value="<?php echo (isset($general_settings['a2z_usps_address2'])) ? $general_settings['a2z_usps_address2'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%;padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('City of the Shipper from address.','a2z_usps') ?>"></span>	<?php _e('City','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_city" value="<?php echo (isset($general_settings['a2z_usps_city'])) ? $general_settings['a2z_usps_city'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('State of the Shipper from address.','a2z_usps') ?>"></span>	<?php _e('State (Two Digit String)','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_state" value="<?php echo (isset($general_settings['a2z_usps_state'])) ? $general_settings['a2z_usps_state'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Postal/Zip Code.','a2z_usps') ?>"></span>	<?php _e('Postal/Zip Code','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_zip" value="<?php echo (isset($general_settings['a2z_usps_zip'])) ? $general_settings['a2z_usps_zip'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Country of the Shipper from Address.','a2z_usps') ?>"></span>	<?php _e('Country','a2z_usps') ?></h4>
						</td>
						<td>
							<select name="a2z_usps_country" class="wc-enhanced-select" style="width:210px;">
								<?php foreach($countires as $key => $value)
								{

									if(isset($general_settings['a2z_usps_country']) && ($general_settings['a2z_usps_country'] == $key))
									{
										echo "<option value=".$key." selected='true'>".$value." [". $usps_core[$key]['currency'] ."]</option>";
									}
									else
									{
										echo "<option value=".$key.">".$value." [". $usps_core[$key]['currency'] ."]</option>";
									}
								} ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Conversion Rate from Site Currency to USPS Currency.','a2z_usps') ?>"></span>	<?php _e('Conversion Rate from Site Currency to USPS Currency','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_con_rate" value="<?php echo (isset($general_settings['a2z_usps_con_rate'])) ? $general_settings['a2z_usps_con_rate'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Default Domestic Express Shipping.','a2z_usps') ?>"></span>	<?php _e('Default Domestic Service','a2z_usps') ?></h4>
							<p><?php _e('This will be used while shipping label generation.','a2z_usps') ?></p>
						</td>
						<td>
							<select name="a2z_usps_def_dom" class="wc-enhanced-select" style="width:210px;">
								<?php foreach($_usps_carriers as $key => $value)
								{
									if(isset($general_settings['a2z_usps_def_dom']) && ($general_settings['a2z_usps_def_dom'] == $key))
									{
										echo "<option value=".$key." selected='true'>".$value."</option>";
									}
									else
									{
										echo "<option value=".$key.">".$value."</option>";
									}
								} ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; padding: 5px; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Default International Shipping.','a2z_usps') ?>"></span>	<?php _e('Default International Service','a2z_usps') ?></h4>
							<p><?php _e('This will be used while shipping label generation.','a2z_usps') ?></p>
						</td>
						<td>
							<select name="a2z_usps_def_inter" class="wc-enhanced-select" style="width:210px;">
								<?php foreach($_usps_carriers as $key => $value)
								{
									if(isset($general_settings['a2z_usps_def_inter']) && ($general_settings['a2z_usps_def_inter'] == $key))
									{
										echo "<option value=".$key." selected='true'>".$value."</option>";
									}
									else
									{
										echo "<option value=".$key.">".$value."</option>";
									}
								} ?>
							</select>
						</td>
					</tr>
				    </table>
				    <hr>
				    <?php
			}
			public function hit_save_product_meta( $post_id ){
				if(isset( $_POST['usps_shipment'])){
					$usps_shipment = sanitize_text_field($_POST['usps_shipment']);
					if( !empty( $usps_shipment ) )
					update_post_meta( $post_id, 'usps_address', (string) esc_html( $usps_shipment ) );	
				}
							
			}
			public function hit_choose_vendor_address(){
				global $woocommerce, $post;
				$hit_multi_vendor = get_option('hit_multi_vendor');
				$hit_multi_vendor = empty($hit_multi_vendor) ? array() : $hit_multi_vendor;
				$selected_addr = get_post_meta( $post->ID, 'usps_address', true);

				$main_settings = get_option('a2z_usps_main_settings');
				$main_settings = empty($main_settings) ? array() : $main_settings;
				if(!isset($main_settings['a2z_usps_v_roles']) || empty($main_settings['a2z_usps_v_roles'])){
					return;
				}
				$v_users = get_users( [ 'role__in' => $main_settings['a2z_usps_v_roles'] ] );
				
				?>
				<div class="options_group">
				<p class="form-field usps_shipment">
					<label for="usps_shipment"><?php _e( 'USPS Account', 'woocommerce' ); ?></label>
					<select id="usps_shipment" style="width:240px;" name="usps_shipment" class="wc-enhanced-select" data-placeholder="<?php _e( 'Search for a product&hellip;', 'woocommerce' ); ?>">
						<option value="default" >Default Account</option>
						<?php
							if ( $v_users ) {
								foreach ( $v_users as $value ) {
									echo '<option value="' .  $value->data->ID  . '" '.($selected_addr == $value->data->ID ? 'selected="true"' : '').'>' . $value->data->display_name . '</option>';
								}
							}
						?>
					</select>
					</p>
				</div>
				<?php
			}

			public function a2z_usps_init()
			{
				include_once("controllors/a2z_usps_init.php");
			}
			public function hit_order_status_update(){
				
			}
			public function a2z_usps_method( $methods )
			{
				if (is_admin() && !is_ajax() || apply_filters('a2z_shipping_method_enabled', true)) {
					$methods['a2z_usps'] = 'a2z_usps'; 
				}

				return $methods;
			}
			
			public function a2z_usps_plugin_action_links($links)
			{
				$setting_value = version_compare(WC()->version, '2.1', '>=') ? "wc-settings" : "woocommerce_settings";
				$plugin_links = array(
					'<a href="' . admin_url( 'admin.php?page=' . $setting_value  . '&tab=shipping&section=a2z_usps' ) . '" style="color:green;">' . __( 'Configure', 'a2z_usps' ) . '</a>',
					'<a href="#" target="_blank" >' . __('Support', 'a2z_usps') . '</a>'
					);
				return array_merge( $plugin_links, $links );
			}
			public function create_usps_shipping_meta_box() {
	       		add_meta_box( 'hit_create_usps_shipping', __('USPS Shipping Label','a2z_usps'), array($this, 'create_usps_shipping_label_genetation'), 'shop_order', 'side', 'core' );
		    }
		    public function create_usps_shipping_label_genetation($post){
		    	echo "<p style='color:green;'>Currently label printing is not available. Contact <a href='https://app.hitshipo.com/support' target='_blank'>Hitshipo</a> with working label API access.</p>";
		    }

		    public function hit_wc_checkout_order_processed($order_id){
		    		
		    }

		    // Save the data of the Meta field
			public function hit_create_usps_shipping( $order_id ) {
				
		    	$post = get_post($order_id);
		    	if($post->post_type !='shop_order' ){
		    		return;
		    	}
		    	
		    	if (  isset( $_POST[ 'hit_usps_reset' ] ) ) {
		    		delete_option('hit_usps_values_'.$order_id);
		    	}

		    	if (  isset( $_POST['hit_usps_create_label']) ) {
		    		
		        }
		    }

		    // Save the data of the Meta field
		}
		
	}
	$a2z_usps = new a2z_usps_parent();
}
