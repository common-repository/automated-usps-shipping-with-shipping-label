<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! class_exists( 'A2Z_USPS' ) ) {
    class A2Z_USPS extends WC_Shipping_Method {
        /**
         * Constructor for your shipping class
         *
         * @access public
         * @return void
         */
        public function __construct() {
            $this->id                 = 'a2z_usps';
			$this->method_title       = __( 'Configure USPS Express' );  // Title shown in admin
			$this->title       = __( 'USPS Shipping' );
            $this->method_description = __( 'Real Time Rates with Multivendor Support' ); // 
            $this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
            $this->init();
        }

        /**
         * Init your settings
         *
         * @access public
         * @return void
         */
        function init() {
            // Load the settings API
            $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
            $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

            // Save settings in admin if you have any defined
            add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
			
        }
        
        /**
         * calculate_shipping function.
         *
         * @access public
         * @param mixed $package
         * @return void
         */
        public function calculate_shipping( $package = array() ) {
        	// $Curr = get_option('woocommerce_currency');
   //      	global $WOOCS;
   //      	if ($WOOCS->default_currency) {
			// $Curr = $WOOCS->default_currency;
   //      	print_r($Curr);
   //      	}else{
   //      		print_r("No");
   //      	}
   //      	die();

			$pack_aft_hook = apply_filters('a2z_usps_rate_packages', $package);
			
			if(empty($pack_aft_hook)){
				return;
			}

			$general_settings = get_option('a2z_usps_main_settings');
			$general_settings = empty($general_settings) ? array() : $general_settings;
			
			if(!is_array($general_settings)){
				return;
			}

			if (!isset($general_settings['a2z_usps_rates']) || $general_settings['a2z_usps_rates'] != "yes") {
				return;
			}
			
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

			$custom_settings = array();
			$custom_settings['default'] = array(
												'a2z_usps_site_id' => $general_settings['a2z_usps_site_id'],
												'a2z_usps_site_pwd' => $general_settings['a2z_usps_site_pwd'],
												'a2z_usps_shipper_name' => $general_settings['a2z_usps_shipper_name'],
												'a2z_usps_company' => $general_settings['a2z_usps_company'],
												'a2z_usps_mob_num' => $general_settings['a2z_usps_mob_num'],
												'a2z_usps_email' => $general_settings['a2z_usps_email'],
												'a2z_usps_address1' => $general_settings['a2z_usps_address1'],
												'a2z_usps_address2' => $general_settings['a2z_usps_address2'],
												'a2z_usps_city' => $general_settings['a2z_usps_city'],
												'a2z_usps_state' => $general_settings['a2z_usps_state'],
												'a2z_usps_zip' => $general_settings['a2z_usps_zip'],
												'a2z_usps_country' => $general_settings['a2z_usps_country'],
												'a2z_usps_con_rate' => $general_settings['a2z_usps_con_rate'],
											);
			$vendor_settings = array();

			if(isset($general_settings['a2z_usps_v_enable']) && $general_settings['a2z_usps_v_enable'] == 'yes' && isset($general_settings['a2z_usps_v_rates']) && $general_settings['a2z_usps_v_rates'] == 'yes'){
				// Multi Vendor Enabled
				foreach ($pack_aft_hook['contents'] as $key => $value) {
					$product_id = $value['product_id'];
					$usps_account = get_post_meta($product_id,'usps_address', true);
					if(empty($usps_account) || $usps_account == 'default'){
						$usps_account = 'default';
						if (!isset($vendor_settings[$usps_account])) {
							$vendor_settings[$usps_account] = $custom_settings['default'];
						}
						$vendor_settings[$usps_account]['products'][] = $value;
					}

					if($usps_account != 'default'){
						$user_account = get_post_meta($usps_account,'a2z_usps_vendor_settings', true);
						$user_account = empty($user_account) ? array() : $user_account;
						if(!empty($user_account)){
							if(!isset($vendor_settings[$usps_account])){

								$vendor_settings[$usps_account] = $custom_settings['default'];
								
									if($user_account['a2z_usps_site_id'] != '' && $user_account['a2z_usps_site_pwd'] != ''){
										
										$vendor_settings[$usps_account]['a2z_usps_site_id'] = $user_account['a2z_usps_site_id'];

										if($user_account['a2z_usps_site_pwd'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_site_pwd'] = $user_account['a2z_usps_site_pwd'];
										}
									}

									if ($user_account['a2z_usps_address1'] != '' && $user_account['a2z_usps_city'] != '' && $user_account['a2z_usps_state'] != '' && $user_account['a2z_usps_zip'] != '' && $user_account['a2z_usps_country'] != '' && $user_account['a2z_usps_shipper_name'] != '') {
										
										if($user_account['a2z_usps_shipper_name'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_shipper_name'] = $user_account['a2z_usps_shipper_name'];
										}

										if($user_account['a2z_usps_company'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_company'] = $user_account['a2z_usps_company'];
										}

										if($user_account['a2z_usps_mob_num'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_mob_num'] = $user_account['a2z_usps_mob_num'];
										}

										if($user_account['a2z_usps_email'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_email'] = $user_account['a2z_usps_email'];
										}

										if ($user_account['a2z_usps_address1'] != '') {
											$vendor_settings[$usps_account]['a2z_usps_address1'] = $user_account['a2z_usps_address1'];
										}

										$vendor_settings[$usps_account]['a2z_usps_address2'] = $user_account['a2z_usps_address2'];
										
										if($user_account['a2z_usps_city'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_city'] = $user_account['a2z_usps_city'];
										}

										if($user_account['a2z_usps_state'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_state'] = $user_account['a2z_usps_state'];
										}

										if($user_account['a2z_usps_zip'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_zip'] = $user_account['a2z_usps_zip'];
										}

										if($user_account['a2z_usps_country'] != ''){
											$vendor_settings[$usps_account]['a2z_usps_country'] = $user_account['a2z_usps_country'];
										}

										$vendor_settings[$usps_account]['a2z_usps_con_rate'] = $user_account['a2z_usps_con_rate'];
									}
							}

							$vendor_settings[$usps_account]['products'][] = $value;
						}
					}

				}

			}

			if(empty($vendor_settings)){
				$custom_settings['default']['products'] = $pack_aft_hook['contents'];
			}else{
				$custom_settings = $vendor_settings;
			}

			$mesage_time = date('c');
			$message_date = date('Y-m-d');
			$weight_unit = $dim_unit = '';
			if(!empty($general_settings['a2z_usps_weight_unit']) && $general_settings['a2z_usps_weight_unit'] == 'KG_CM') {
				$weight_unit = 'KG';
				$dim_unit = 'CM';
			} else {
				$weight_unit = 'LB';
				$dim_unit = 'IN';
			}

			if(!isset($general_settings['a2z_usps_packing_type'])){
				return;
			}

			$woo_weight_unit = get_option('woocommerce_weight_unit');
			$woo_dimension_unit = get_option('woocommerce_dimension_unit');

			$usps_mod_weight_unit = 'lbs';
			$usps_mod_dim_unit = 'in';

			$shipping_rates = array();
			if(isset($general_settings['a2z_usps_developer_rate']) && $general_settings['a2z_usps_developer_rate'] == 'yes'){
				echo "<pre>";
			}

			foreach ($custom_settings as $usr_key => $value) {
				$shipping_rates[$usr_key] = array();
				$usps_id = isset($value['a2z_usps_site_id']) ? $value['a2z_usps_site_id'] : '';
				$orgin_postcode = isset($value['a2z_usps_zip']) ? $value['a2z_usps_zip'] : '';
				$destination_postcode = isset($pack_aft_hook['destination']['postcode']) ? $pack_aft_hook['destination']['postcode'] : '';
				$destination_country = isset($pack_aft_hook['destination']['country']) ? $countires[ $pack_aft_hook['destination']['country'] ] : '';
				$general_settings['a2z_usps_currency'] = isset($usps_core[(isset($value['a2z_usps_country']) ? $value['a2z_usps_country'] : 'A2Z')]) ? $usps_core[$value['a2z_usps_country']]['currency'] : '';
				if (empty($orgin_postcode) || empty($destination_postcode) || empty($destination_country || empty($usps_id))) {
					return;
				}
				$products = array();

				foreach ($value['products'] as $val) {
					$product['product_id'] = $val['product_id'];
					$product['variation_id'] = $val['variation_id'];
					$product['variation'] = $val['variation'];
					$product['quantity'] = $val['quantity'];

					$product_data = $val['data']->get_data();
					$product['name'] = $product_data['name'];
					$product['slug'] = $product_data['slug'];
					$product['price'] = $product_data['price'];
					$product['regular_price'] = $product_data['regular_price'];
					$product['sale_price'] = $product_data['sale_price'];

					$product_val = $val['data'];
					$get_prod = wc_get_product( $val['product_id'] );
					$parent_prod_data = [];
					$product_weight = 0;

					if ($get_prod->is_type( 'variable' )) {
						$parent_prod_data = $product_val->get_parent_data();
					}

					if($product_data['weight']){
						$product_weight = round($product_data['weight'] > 0.001 ? $product_data['weight'] : 0.001, 3);
					}else{
						$product_weight = $parent_prod_data['weight'] ? (round($parent_prod_data['weight'] > 0.001 ? $parent_prod_data['weight'] : 0.001, 3)) : 0.001;
					}
// echo"<pre>";print_r($parent_prod_data);continue;
					if (!empty($product_weight) && ($woo_weight_unit != $usps_mod_weight_unit)) {
						$product['weight'] = round(wc_get_weight( $product_weight, $usps_mod_weight_unit, $woo_weight_unit ), 3);
					}else {
						$product['weight'] = $product_weight > 0.001 ? $product_weight : 0.001;
					}
					
					if (!empty($product_data['length']) && !empty($product_data['width']) && !empty($product_data['height']) && ($woo_dimension_unit != $usps_mod_dim_unit)) {
						$product['length'] = round(wc_get_dimension( $product_data['length'], $usps_mod_dim_unit, $woo_dimension_unit ), 2);
						$product['width'] = round(wc_get_dimension( $product_data['width'], $usps_mod_dim_unit, $woo_dimension_unit ), 2);
						$product['height'] = round(wc_get_dimension( $product_data['height'], $usps_mod_dim_unit, $woo_dimension_unit ), 2);
					}elseif (!empty($parent_prod_data['length']) && !empty($parent_prod_data['width']) && !empty($parent_prod_data['height']) && ($woo_dimension_unit != $usps_mod_dim_unit)) {
						$product['length'] = round(wc_get_dimension( $parent_prod_data['length'], $usps_mod_dim_unit, $woo_dimension_unit ), 2);
						$product['width'] = round(wc_get_dimension( $parent_prod_data['width'], $usps_mod_dim_unit, $woo_dimension_unit ), 2);
						$product['height'] = round(wc_get_dimension( $parent_prod_data['height'], $usps_mod_dim_unit, $woo_dimension_unit ), 2);
					} else {
						$product['length'] = $product_data['length'];
						$product['width'] = $product_data['width'];
						$product['height'] = $product_data['height'];
					}

					$products[] = $product;
				}

				$usps_packs = $this->hit_get_usps_packages( $products,$general_settings,$general_settings['a2z_usps_currency'] );
				$xmlRequest = "";
				if ($usps_packs) {
					$all_pack_xml = "";

					// if ($general_settings['a2z_usps_currency'] != get_option('woocommerce_currency')) {
					// 	$exchange_rate = $value['a2z_usps_con_rate'];
						
					// 	if($exchange_rate && $exchange_rate > 0){
					// 		$total_amount *= $exchange_rate;
					// 	}
					// }

					if (isset($pack_aft_hook['destination']['country']) && $pack_aft_hook['destination']['country'] == "US") {
						$xmlRequest = file_get_contents(dirname(__FILE__).'/xml/rate.xml');
						foreach ($usps_packs as $key => $usps_pack) {
							$weight = 0;
							$pack_xml = '<Package ID="' . $key . '">
								  {service}
								  <ZipOrigination>{zip_sender}</ZipOrigination>
								  <ZipDestination>{zip_receiver}</ZipDestination>
								  <Pounds>{pound}</Pounds>
								  <Ounces>{ounce}</Ounces>
								  <Container></Container>
								  {dim}
								  {spl_services}
								  <Machinable>True</Machinable>
								  </Package>';

							$weight = ( isset($usps_pack['Weight']['Value']) && $usps_pack['Weight']['Value'] > 0 ) ? $usps_pack['Weight']['Value'] : 0.001;
							$ounce = ($weight > 0) ? ($weight * 16) : (0.001 * 16);

							if (isset($usps_pack['Dimensions'])) {
								$pack_width = ( !empty($usps_pack['Dimensions']['Width']) && $usps_pack['Dimensions']['Width'] > 0 ) ? $usps_pack['Dimensions']['Width'] : 1;
								$pack_length = ( !empty($usps_pack['Dimensions']['Length']) && $usps_pack['Dimensions']['Length'] > 0 ) ? $usps_pack['Dimensions']['Length'] : 1;
								$pack_height = ( !empty($usps_pack['Dimensions']['Height']) && $usps_pack['Dimensions']['Height'] > 0 ) ? $usps_pack['Dimensions']['Height'] : 1;
								
								$dim = "<Width>" . round($pack_width) . "</Width>
										<Length>" . round($pack_length) . "</Length>
										<Height>" . round($pack_height) . "</Height>";

								$pack_xml = str_replace('{dim}',$dim,$pack_xml);
							}else {
								$pack_xml = str_replace('{dim}', '' ,$pack_xml);
							}

							$pack_xml = str_replace('{pound}', round($weight, 4),$pack_xml);
							$pack_xml = str_replace('{ounce}',round($ounce, 4),$pack_xml);

							$all_pack_xml .= $pack_xml;
						}
						$service_type = isset($general_settings['a2z_usps_service_type']) ? str_replace('_', ' ', $general_settings['a2z_usps_service_type']) : 'PRIORITY';
						$first_type = isset($general_settings['a2z_usps_first_cls_type']) ? str_replace('_', ' ', $general_settings['a2z_usps_first_cls_type']) : 'FLAT';
						$service = '';
						$spl_service = '';

						if ($service_type == 'FIRST CLASS') {
							$service = '<Service>'.$service_type.'</Service>
									<FirstClassMailType>'.$first_type.'</FirstClassMailType>';
						}else{
							$service = '<Service>'.$service_type.'</Service>';
						}

						if ((isset($general_settings['a2z_usps_insure']) && $general_settings['a2z_usps_insure'] == 'yes') && (isset($general_settings['a2z_usps_cod']) && $general_settings['a2z_usps_cod'] == 'yes')) {

							if ($service_type  == 'PRIORITY EXPRESS') {
								$spl_service = '<SpecialServices>
										  <SpecialService>101</SpecialService>
										  <SpecialService>103</SpecialService>';	// 100, 101, 125 - insurance, 103 - COD
							}elseif($service_type  == 'PRIORITY' || $service_type  == 'PRIORITY MAIL CUBIC'){
								$spl_service = '<SpecialServices>
										  <SpecialService>125</SpecialService>
										  <SpecialService>103</SpecialService>';
							}else {
								$spl_service = '<SpecialServices>
										  <SpecialService>100</SpecialService>
										  <SpecialService>103</SpecialService>';
							}
							$spl_service .= '</SpecialServices>';
						}elseif (isset($general_settings['a2z_usps_insure']) && $general_settings['a2z_usps_insure'] == 'yes') {
							if ($service_type == 'PRIORITY EXPRESS') {
								$spl_service = '<SpecialServices>
										  <SpecialService>101</SpecialService>';
							}elseif($service_type  == 'PRIORITY' || $service_type  == 'PRIORITY MAIL CUBIC'){
								$spl_service = '<SpecialServices>
										  <SpecialService>125</SpecialService>';
							}else{
								$spl_service = '<SpecialServices>
										  <SpecialService>100</SpecialService>';
							}
							$spl_service .= '</SpecialServices>';
						}elseif (isset($general_settings['a2z_usps_cod']) && $general_settings['a2z_usps_cod'] == 'yes') {
							$spl_service = '<SpecialServices>
										  <SpecialService>103</SpecialService>
										  </SpecialServices>';
						}

						$all_pack_xml = str_replace('{service}',$service,$all_pack_xml);
						$all_pack_xml = str_replace('{spl_services}',$spl_service,$all_pack_xml);
					}else{
						$date_n_time = date('c');
						$mail_type = isset($general_settings['a2z_usps_mail_type']) ? str_replace('_', ' ', $general_settings['a2z_usps_mail_type']) : 'ALL';

						$xmlRequest =  file_get_contents(dirname(__FILE__).'/xml/rate_intl.xml');

						foreach ($usps_packs as $key => $usps_pack) {

								$pack_xml = '<Package ID=" ' . $key . ' ">
										  <Pounds>{pound}</Pounds>
										  <Ounces>{ounce}</Ounces>
										  <Machinable>True</Machinable>
										  <MailType>{mail_type}</MailType>
										  <ValueOfContents>{content_value}</ValueOfContents>
										  <Country>{dest_country}</Country>
										  {dim}
										  <OriginZip>{zip_sender}</OriginZip>
										  <CommercialFlag>N</CommercialFlag>
										  <AcceptanceDateTime>{date}</AcceptanceDateTime>
										  <DestinationPostalCode>{zip_receiver}</DestinationPostalCode>
										  </Package>';

							$weight = ( isset($usps_pack['Weight']['Value']) && $usps_pack['Weight']['Value'] > 0 ) ? $usps_pack['Weight']['Value'] : 0.001;
							$ounce = ($weight > 0) ? ($weight * 16) : (0.001 * 16);
							$total_amount = $usps_pack['InsuredValue']['Amount'];
							$pack_xml = str_replace('{content_value}',$total_amount,$pack_xml);

							if (isset($usps_pack['Dimensions'])) {
								$pack_width = ( !empty($usps_pack['Dimensions']['Width']) && $usps_pack['Dimensions']['Width'] > 0 ) ? $usps_pack['Dimensions']['Width'] : 1;
								$pack_length = ( !empty($usps_pack['Dimensions']['Length']) && $usps_pack['Dimensions']['Length'] > 0 ) ? $usps_pack['Dimensions']['Length'] : 1;
								$pack_height = ( !empty($usps_pack['Dimensions']['Height']) && $usps_pack['Dimensions']['Height'] > 0 ) ? $usps_pack['Dimensions']['Height'] : 1;
								
								$dim = "<Width>" . round($pack_width) . "</Width>
										<Length>" . round($pack_length) . "</Length>
										<Height>" . round($pack_height) . "</Height>";

								$pack_xml = str_replace('{dim}',$dim,$pack_xml);
							}else {
								$pack_xml = str_replace('{dim}', '' ,$pack_xml);
							}

							$pack_xml = str_replace('{pound}', round($weight, 4),$pack_xml);
							$pack_xml = str_replace('{ounce}',round($ounce, 4),$pack_xml);

							$all_pack_xml .= $pack_xml;

						}

						$all_pack_xml = str_replace('{mail_type}',$mail_type,$all_pack_xml);
						$all_pack_xml = str_replace('{date}',$date_n_time,$all_pack_xml);
						$all_pack_xml = str_replace('{dest_country}',$destination_country,$all_pack_xml);
						
					}

					$xmlRequest = str_replace('{packages}',$all_pack_xml,$xmlRequest);
					$xmlRequest = str_replace('{user_id}',$usps_id,$xmlRequest);
					$xmlRequest = str_replace('{zip_sender}',$orgin_postcode,$xmlRequest);
					$xmlRequest = str_replace('{zip_receiver}',$destination_postcode,$xmlRequest);
				}
// return;
// echo '<pre>';print_r(htmlspecialchars($xmlRequest));die();
				
				// $order_total = 0;
				// foreach ($pack_aft_hook['contents'] as $item_id => $values) {
				// 	$order_total += (float) $values['line_subtotal'];
				// }
				
				if (isset($pack_aft_hook['destination']['country']) && $pack_aft_hook['destination']['country'] == "US") {
					$request_url = (isset($general_settings['a2z_usps_test']) && $general_settings['a2z_usps_test'] != 'yes') ? 'https://secure.shippingapis.com/ShippingAPI.dll?API=RateV4&xml=' : 'http://production.shippingapis.com/ShippingApi.dll?API=RateV4&xml=';
				}else{
					$request_url = (isset($general_settings['a2z_usps_test']) && $general_settings['a2z_usps_test'] != 'yes') ? 'https://secure.shippingapis.com/ShippingAPI.dll?API=IntlRateV2&xml=':  'http://production.shippingapis.com/ShippingApi.dll?API=IntlRateV2&xml=';
				}
				
				$request_url .= rawurlencode($xmlRequest);
				$response = wp_remote_post($request_url, array(
	            'method' => 'GET',
	            'timeout' => 60,
	            'sslverify' => 0
	                )
				);
// echo '<pre>';print_r($response);die();
				
				if (!isset($response['body'])) {
					return;
				}
				
				$response = str_replace(array("&amp;lt;sup&amp;gt;&amp;#8482;&amp;lt;/sup&amp;gt;", "&amp;lt;sup&amp;gt;&amp;#174;&amp;lt;/sup&amp;gt;", " -"), "", $response['body']);
		        $result = '';
		        if (!empty($response)) {
		          $result = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
		        }
		        
		        $result = json_decode(json_encode($result), true);
				
				if(isset($general_settings['a2z_usps_developer_rate']) && $general_settings['a2z_usps_developer_rate'] == 'yes')
				{
					echo "<h1> Request </h1><br/>";
					print_r(htmlspecialchars($xmlRequest));
					echo "<br/><h1> Response </h1><br/>";
					print_r($result);
					continue;
				}

				if (!empty($result) && isset($result['Package'])) {
					if (!isset($result['Package'][0])) {
						$pack_mod = [];
						$pack_mod['Package'][] = $result['Package'];
						$result = $pack_mod;
					}

					$all_pack_quotes = [];
					$total_of_rate_quotes = [];
					foreach ($result['Package'] as $pack_key => $res_value) {
						$quotes = [];

						if ($res_value && isset($res_value['Service'])) {
							if ( isset($res_value['Service'][0]) ) {
								$quotes = $res_value['Service'];
							}else {
								$quotes[] = $res_value['Service'];
							}
						}elseif ($res_value && isset($res_value['Postage'])) {
							if ( isset($res_value['Postage'][0]) ) {
								$quotes = $res_value['Postage'];
							}else {
								$quotes[] = $res_value['Postage'];
							}
						}
// echo '<pre>';print_r($general_settings);echo '<br>';print_r($quotes);die();
						if (!empty($quotes)) {
							foreach ($quotes as $quote) {
								$spl_service_available = [];
								$rate_cost = 0;
								$rate_code = "";
								if (isset($quote['SvcDescription'])) {		//Intl
									$rate_code = $quote['SvcDescription'];
									$rate_code = str_replace(array(' ', '-'),'_',$rate_code);
									
									if (isset($general_settings['a2z_usps_carrier'])  && isset($general_settings['a2z_usps_carrier'][$rate_code]) && $general_settings['a2z_usps_carrier'][$rate_code] == "yes") {
										$rate_cost = $quote['Postage'];

										if ( isset($quote['ExtraServices']['ExtraService'][0]) ) {
											$spl_service_available = $quote['ExtraServices']['ExtraService'];
										}elseif ( isset($quote['ExtraServices']['ExtraService']) ) {
											$spl_service_available[] = $quote['ExtraServices']['ExtraService'];
										}

										if ( !empty($spl_service_available) && isset($general_settings['a2z_usps_insure']) && isset($general_settings['a2z_usps_cod']) ) {
											foreach ($spl_service_available as $spl_service) {
												if ( ($general_settings['a2z_usps_insure'] == "yes") && (strtolower($spl_service['ServiceName']) == "insurance") && (strtolower($spl_service['Available']) == "true") ) {
													$rate_cost = $rate_cost + $spl_service['Price'];
												}

												if ( ($general_settings['a2z_usps_cod'] == "yes") && (strtolower($spl_service['ServiceName']) == "collect on delivery") && (strtolower($spl_service['Available']) == "true") ) {
													$rate_cost = $rate_cost + $spl_service['Price'];
												}
											}
										}

										$all_pack_quotes[$pack_key] = array_merge( isset($all_pack_quotes[$pack_key]) ? $all_pack_quotes[$pack_key] : [], array($rate_code => $rate_cost) );
										
									}else {
										continue;
									}
								}elseif (isset($quote['MailService'])) {	//Dom
									$rate_code = (string)$quote['MailService'];
									$rate_code = str_replace(array(' ', '-'),'_',$rate_code);

									if (isset($general_settings['a2z_usps_carrier']) && isset($general_settings['a2z_usps_carrier'][$rate_code]) && $general_settings['a2z_usps_carrier'][$rate_code] == "yes") {
										$rate_cost = $quote['Rate'];

										if ( isset($quote['SpecialServices']['SpecialService'][0]) ) {
											$spl_service_available = $quote['SpecialServices']['SpecialService'];
										}elseif ( isset($quote['SpecialServices']['SpecialService']) ) {
											$spl_service_available[] = $quote['SpecialServices']['SpecialService'];
										}

										if ( !empty($spl_service_available) && isset($general_settings['a2z_usps_insure']) && isset($general_settings['a2z_usps_cod']) ) {
											foreach ($spl_service_available as $spl_service) {
												if ( ($general_settings['a2z_usps_insure'] == "yes") && (strtolower($spl_service['ServiceName']) == "insurance") && (strtolower($spl_service['Available']) == "true") ) {
													$rate_cost = $rate_cost + $spl_service['Price'];
												}

												if ( ($general_settings['a2z_usps_cod'] == "yes") && (strtolower($spl_service['ServiceName']) == "collect on delivery") && (strtolower($spl_service['Available']) == "true") ) {
													$rate_cost = $rate_cost + $spl_service['Price'];
												}
											}
										}

										$all_pack_quotes[$pack_key] = array_merge( isset($all_pack_quotes[$pack_key]) ? $all_pack_quotes[$pack_key] : [], array($rate_code => $rate_cost) );
										
									}else {
										continue;
									}
								}
							}
						}
// echo '<pre>';print_r($all_pack_quotes);die();
						if ( ($pack_key < 1) && isset($all_pack_quotes[$pack_key])) {
							$total_of_rate_quotes = $all_pack_quotes[$pack_key];
						}else {
							if (!empty($total_of_rate_quotes)) {
								foreach ($total_of_rate_quotes as $prev_rate_code => $prev_rate) {
									if (!isset($all_pack_quotes[$pack_key][$prev_rate_code])) {
										unset($total_of_rate_quotes[$prev_rate_code]);
									}else{
										$total_of_rate_quotes[$prev_rate_code] += $all_pack_quotes[$pack_key][$prev_rate_code];
									}
								}
							}
						}
					}

					if (get_option('woocommerce_currency') != "USD") {
						foreach ($total_of_rate_quotes as $temp_rate_code => $temp_rate_cost) {
							if (isset($general_settings['a2z_usps_auto_con_rate']) && $general_settings['a2z_usps_auto_con_rate'] == "yes") {
								$get_ex_rate = get_option('a2z_usps_ex_rate'.$key, '');
								$get_ex_rate = !empty($get_ex_rate) ? $get_ex_rate : array();
								$exchange_rate = ( !empty($get_ex_rate) && isset($get_ex_rate['ex_rate']) ) ? $get_ex_rate['ex_rate'] : 0;
							}else{
								$exchange_rate = $value['a2z_usps_con_rate'];
							}

							if ($exchange_rate && $exchange_rate > 0) {
								$total_of_rate_quotes[$temp_rate_code] *= $exchange_rate;
							}
						}
					}
					$shipping_rates[$usr_key] = $total_of_rate_quotes;
					// echo '<pre>';print_r($all_pack_quotes);print_R($total_of_rate_quotes);die();
				}

			}
			
			if(isset($general_settings['a2z_usps_developer_rate']) && $general_settings['a2z_usps_developer_rate'] == 'yes'){
				die();
			}
		
			// Rate Processing

			if(!empty($shipping_rates)){
				$i=0;
				$final_price = array();
				foreach ($shipping_rates as $mkey => $rate) {
					$cheap_p = 0;
					$cheap_s = '';
					foreach ($rate as $key => $cvalue) {
						if ($i > 0){

							if(!in_array($key, array('C','Q'))){
								if($cheap_p == 0 && $cheap_s == ''){
									$cheap_p = $cvalue;
									$cheap_s = $key;
									
								}else if ($cheap_p > $cvalue){
									$cheap_p = $cvalue;
									$cheap_s = $key;
								}
							}
						}else{
							$final_price[] = array('price' => $cvalue, 'code' => $key, 'multi_v' => $mkey.'_'. $key);
						}
					}

					if($cheap_p != 0 && $cheap_s != ''){
						foreach ($final_price as $key => $value) {
							$value['price'] = $value['price'] + $cheap_p;
							$value['multi_v'] = $value['multi_v'] . '|' . $mkey . '_' . $cheap_s;
							$final_price[$key] = $value;
						}
					}

					$i++;
					
				}
				
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

				foreach ($final_price as $key => $value) {
					
					$rate_cost = $value['price'];
					$rate_code = $value['code'];
					$multi_ven = $value['multi_v'];

					if (!empty($general_settings['a2z_usps_carrier_adj_percentage'][$rate_code])) {
						$rate_cost += $rate_cost * ($general_settings['a2z_usps_carrier_adj_percentage'][$rate_code] / 100);
					}
					if (!empty($general_settings['a2z_usps_carrier_adj'][$rate_code])) {
						$rate_cost += $general_settings['a2z_usps_carrier_adj'][$rate_code];
					}

					$rate_cost = round($rate_cost, 2);

					$carriers_available = isset($general_settings['a2z_usps_carrier']) && is_array($general_settings['a2z_usps_carrier']) ? $general_settings['a2z_usps_carrier'] : array();

					$carriers_name_available = isset($general_settings['a2z_usps_carrier_name']) && is_array($general_settings['a2z_usps_carrier']) ? $general_settings['a2z_usps_carrier_name'] : array();
					
					if(array_key_exists($rate_code,$carriers_available))
					{
						$name = isset($carriers_name_available[$rate_code]) && !empty($carriers_name_available[$rate_code]) ? $carriers_name_available[$rate_code] : $_usps_carriers[$rate_code];
						
						// $rate_cost = apply_filters('hitstacks_usps_rate_cost',$rate_cost,$rate_code,$order_total);
						if($rate_cost < 1){
							$name .= ' - Free';
						}

						if(!isset($general_settings['a2z_usps_v_rates']) || $general_settings['a2z_usps_v_rates'] != 'yes'){
							$multi_ven = '';
						}
					
						// This is where you'll add your rates
						$rate = array(
							'id'       => 'a2z'.$rate_code,
							'label'    => $name,
							'cost'     => apply_filters( "hitstacks_usps_shipping_cost_conversion", $rate_cost),
							'meta_data' => array('a2z_multi_ven' => $multi_ven,'a2z_usps_service' => $rate_code)
						);
						
						// Register the rate
						
						$this->add_rate( $rate );
					}

				}

			}
        }

        public function hit_get_usps_packages($package,$general_settings,$orderCurrency,$chk = false)
		{
			switch ($general_settings['a2z_usps_packing_type']) {
				case 'box' :
					return $this->box_shipping($package,$general_settings,$orderCurrency,$chk);
					break;
				case 'weight_based' :
					return $this->weight_based_shipping($package,$general_settings,$orderCurrency,$chk);
					break;
				case 'per_item' :
				default :
					return $this->per_item_shipping($package,$general_settings,$orderCurrency,$chk);
					break;
			}
		}
		private function weight_based_shipping($package,$general_settings,$orderCurrency,$chk = false)
		{
			// echo '<pre>';
			// print_r($package);
			// die();
			if ( ! class_exists( 'WeightPack' ) ) {
				include_once 'classes/weight_pack/class-hit-weight-packing.php';
			}
			$max_weight = isset($general_settings['a2z_usps_max_weight']) && $general_settings['a2z_usps_max_weight'] !=''  ? $general_settings['a2z_usps_max_weight'] : 10 ;
			$weight_pack=new WeightPack('pack_ascending');
			$weight_pack->set_max_weight($max_weight);

			$package_total_weight = 0;
			$insured_value = 0;

			$ctr = 0;
			foreach ($package as $item_id => $values) {
				$ctr++;

				$chk_qty = $chk ? $values['product_quantity'] : $values['quantity'];
				$values['weight'] = $values['weight'] ? $values['weight'] : 0.001;

				$weight_pack->add_item($values['weight'], $values, $chk_qty);
			}

			$pack   =   $weight_pack->pack_items();  
			$errors =   $pack->get_errors();
			if( !empty($errors) ){
				//do nothing
				return;
			} else {
				$boxes    =   $pack->get_packed_boxes();
				$unpacked_items =   $pack->get_unpacked_items();

				$insured_value        =   0;

				$packages      =   array_merge( $boxes, $unpacked_items ); // merge items if unpacked are allowed
				$package_count  =   sizeof($packages);
				// get all items to pass if item info in box is not distinguished
				$packable_items =   $weight_pack->get_packable_items();
				$all_items    =   array();
				if(is_array($packable_items)){
					foreach($packable_items as $packable_item){
						$all_items[]    =   $packable_item['data'];
					}
				}
				//pre($packable_items);
				$order_total = '';

				$to_ship  = array();
				$group_id = 1;
				foreach($packages as $package){
					$packed_products = array();
					$insured_value = 0;

					foreach ($package['items'] as $value) {
						$insured_value += $value['price'];
					}

					$packed_products = isset($package['items']) ? $package['items'] : $all_items;
					// Creating package request
					$package_total_weight   = $package['weight'];

					$insurance_array = array(
						'Amount' => $insured_value,
						'Currency' => $orderCurrency
					);

					$group = array(
						'GroupNumber' => $group_id,
						'GroupPackageCount' => 1,
						'Weight' => array(
						'Value' => round($package_total_weight, 3),
						'Units' => (isset($general_settings['a2z_usps_weight_unit']) && $general_settings['a2z_usps_weight_unit'] =='yes') ? 'KG' : 'LBS'
					),
						'packed_products' => $packed_products,
					);
					$group['InsuredValue'] = $insurance_array;
					$group['packtype'] = 'BOX';

					$to_ship[] = $group;
					$group_id++;
				}
			}
			return $to_ship;
		}
		private function box_shipping($package,$general_settings,$orderCurrency,$chk = false)
		{
			if (!class_exists('HIT_Boxpack')) {
				include_once 'classes/hit-box-packing.php';
			}
			$boxpack = new HIT_Boxpack();
			$boxes = Configuration::get('hit_usps_shipping_services_box');
			if(empty($boxes))
			{
				return false;
			}
			$boxes = unserialize($boxes);
			// Define boxes
			foreach ($boxes as $key => $box) {
				if (!$box['enabled']) {
					continue;
				}
				$box['pack_type'] = !empty($box['pack_type']) ? $box['pack_type'] : 'BOX' ;

				$newbox = $boxpack->add_box($box['length'], $box['width'], $box['height'], $box['box_weight'], $box['pack_type']);

				if (isset($box['id'])) {
					$newbox->set_id(current(explode(':', $box['id'])));
				}

				if ($box['max_weight']) {
					$newbox->set_max_weight($box['max_weight']);
				}
				if ($box['pack_type']) {
					$newbox->set_packtype($box['pack_type']);
				}
			}

			// Add items
			foreach ($package as $item_id => $values) {

				$skip_product = '';
				if($skip_product){
					continue;
				}

				if ( $values['width'] && $values['height'] && $values['depth'] && $values['weight'] ) {

					$dimensions = array( $values['depth'], $values['height'], $values['width']);
					$chk_qty = $chk ? $values['product_quantity'] : $values['cart_quantity'];
					for ($i = 0; $i < $chk_qty; $i ++) {
						$boxpack->add_item($dimensions[2], $dimensions[1], $dimensions[0], $values['weight'], $values['price'], array(
							'data' => $values
						)
										  );
					}
				} else {
					//    $this->debug(sprintf(__('Product #%s is missing dimensions. Aborting.', 'wf-shipping-dhl'), $item_id), 'error');
					return;
				}
			}

			// Pack it
			$boxpack->pack();
			$packages = $boxpack->get_packages();
			$to_ship = array();
			$group_id = 1;
			foreach ($packages as $package) {
				if ($package->unpacked === true) {
					//$this->debug('Unpacked Item');
				} else {
					//$this->debug('Packed ' . $package->id);
				}

				$dimensions = array($package->length, $package->width, $package->height);

				sort($dimensions);
				$insurance_array = array(
					'Amount' => round($package->value),
					'Currency' => $orderCurrency->iso_code
				);


				$group = array(
					'GroupNumber' => $group_id,
					'GroupPackageCount' => 1,
					'Weight' => array(
					'Value' => round($package->weight, 3),
					'Units' => (isset($general_settings['weg_dim']) && $general_settings['weg_dim'] ==='yes') ? 'KG' : 'LBS'
				),
					'Dimensions' => array(
					'Length' => max(1, round($dimensions[2], 3)),
					'Width' => max(1, round($dimensions[1], 3)),
					'Height' => max(1, round($dimensions[0], 3)),
					'Units' => (isset($general_settings['weg_dim']) && $general_settings['weg_dim'] ==='yes') ? 'CM' : 'IN'
				),
					'InsuredValue' => $insurance_array,
					'packed_products' => array(),
					'package_id' => $package->id,
					'packtype' => isset($package->packtype)?$package->packtype:'BOX'
				);

				if (!empty($package->packed) && is_array($package->packed)) {
					foreach ($package->packed as $packed) {
						$group['packed_products'][] = $packed->get_meta('data');
					}
				}

				$to_ship[] = $group;

				$group_id++;
			}

			return $to_ship;
		}
		private function per_item_shipping($package,$general_settings,$orderCurrency,$chk = false) {
			$to_ship = array();
			$group_id = 1;

			// Get weight of order
			foreach ($package as $item_id => $values) {
				$group = array();
				$insurance_array = array(
					'Amount' => round($values['price']),
					'Currency' => $orderCurrency
				);

				$usps_per_item_weight = round($values['weight'] > 0.001 ? $values['weight'] : 0.001, 3);

				$group = array(
					'GroupNumber' => $group_id,
					'GroupPackageCount' => 1,
					'Weight' => array(
					'Value' => $usps_per_item_weight,
					'Units' => (isset($general_settings['a2z_usps_weight_unit']) && $general_settings['a2z_usps_weight_unit'] == 'KG_CM') ? 'KG' : 'LBS'
				),
					'packed_products' => $values
				);

				if ($values['width'] && $values['height'] && $values['length']) {

					$group['Dimensions'] = array(
						'Length' => max(1, round($values['length'],3)),
						'Width' => max(1, round($values['width'],3)),
						'Height' => max(1, round($values['height'],3)),
						'Units' => (isset($general_settings['a2z_usps_weight_unit']) && $general_settings['a2z_usps_weight_unit'] == 'KG_CM') ? 'CM' : 'IN'
					);
				}

				$group['packtype'] = 'BOX';

				$group['InsuredValue'] = $insurance_array;

				$chk_qty = $chk ? $values['product_quantity'] : $values['quantity'];

				for ($i = 0; $i < $chk_qty; $i++)
					$to_ship[] = $group;

				$group_id++;
			}

			return $to_ship;
		}

		/**
		 * Initialise Gateway Settings Form Fields
		 */
		public function init_form_fields() {
			 $this->form_fields = array('a2z_usps' => array('type'=>'a2z_usps'));
		}
		 public function generate_a2z_usps_html() {
			include( 'views/a2z_usps_settings_view.php' );
		 }
    }
}