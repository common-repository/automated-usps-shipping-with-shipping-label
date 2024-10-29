<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$this->init_settings(); 
global $woocommerce, $wp_roles;

$_carriers = array(
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
$service_type_dom = array('PRIORITY' => 'PRIORITY', 'PRIORITY_MAIL_CUBIC' => 'PRIORITY MAIL CUBIC', 'PRIORITY_EXPRESS' => 'PRIORITY EXPRESS', 'FIRST_CLASS' => 'FIRST CLASS', 'MEDIA' => 'MEDIA');
$mail_type_intl = array('ALL' => 'All','PACKAGE' => 'Package','POSTCARDS' => 'Postcards','ENVELOPE' => 'Envelope','LETTER' => 'Letter','LARGEENVELOPE' => 'Large envelope','FLATRATE' => 'Flatrate');
$first_cls_type = array('LETTER' => 'Letter', 'FLAT' => 'Flat', 'PACKAGE_SERVICE_RETAIL' => 'Package Service Retail', 'POSTCARD' => 'Postcard', 'PACKAGE_SERVICE' => 'Package Service');

$print_size = array('8X4_A4_PDF'=>'8X4_A4_PDF','8X4_thermal'=>'8X4_thermal','8X4_A4_TC_PDF'=>'8X4_A4_TC_PDF','8X4_CI_PDF'=>'8X4_CI_PDF','8X4_CI_thermal'=>'8X4_CI_thermal','8X4_RU_A4_PDF'=>'8X4_RU_A4_PDF','8X4_PDF'=>'8X4_PDF','8X4_CustBarCode_PDF'=>'8X4_CustBarCode_PDF','8X4_CustBarCode_thermal'=>'8X4_CustBarCode_thermal','6X4_A4_PDF'=>'6X4_A4_PDF','6X4_thermal'=>'6X4_thermal','6X4_PDF'=>'6X4_PDF');
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
$duty_payment_type = array('S' =>'Shipper','R' =>'Recipient');
$pickup_loc_type = array('B' =>'B (Business)','R' =>'R (Residence)','C' =>'C (Business/Residence)');
$pickup_del_type = array('DD' => 'DD (DoorToDoor)','DA' => 'DA (DoorToAirport)','DC' => 'DC (DoorToDoor non-complaint)');
$pickup_type = array('S' => 'S-SameDayPickup','A' => 'A-AdvancedPickup');
		$value = array();
		$value['AD'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['AE'] = array('region' => 'AP', 'currency' =>'AED', 'weight' => 'KG_CM');
		$value['AF'] = array('region' => 'AP', 'currency' =>'AFN', 'weight' => 'KG_CM');
		$value['AG'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
		$value['AI'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
		$value['AL'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['AM'] = array('region' => 'AP', 'currency' =>'AMD', 'weight' => 'KG_CM');
		$value['AN'] = array('region' => 'AM', 'currency' =>'ANG', 'weight' => 'KG_CM');
		$value['AO'] = array('region' => 'AP', 'currency' =>'AOA', 'weight' => 'KG_CM');
		$value['AR'] = array('region' => 'AM', 'currency' =>'ARS', 'weight' => 'KG_CM');
		$value['AS'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['AT'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['AU'] = array('region' => 'AP', 'currency' =>'AUD', 'weight' => 'KG_CM');
		$value['AW'] = array('region' => 'AM', 'currency' =>'AWG', 'weight' => 'LB_IN');
		$value['AZ'] = array('region' => 'AM', 'currency' =>'AZN', 'weight' => 'KG_CM');
		$value['AZ'] = array('region' => 'AM', 'currency' =>'AZN', 'weight' => 'KG_CM');
		$value['GB'] = array('region' => 'EU', 'currency' =>'GBP', 'weight' => 'KG_CM');
		$value['BA'] = array('region' => 'AP', 'currency' =>'BAM', 'weight' => 'KG_CM');
		$value['BB'] = array('region' => 'AM', 'currency' =>'BBD', 'weight' => 'LB_IN');
		$value['BD'] = array('region' => 'AP', 'currency' =>'BDT', 'weight' => 'KG_CM');
		$value['BE'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['BF'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
		$value['BG'] = array('region' => 'EU', 'currency' =>'BGN', 'weight' => 'KG_CM');
		$value['BH'] = array('region' => 'AP', 'currency' =>'BHD', 'weight' => 'KG_CM');
		$value['BI'] = array('region' => 'AP', 'currency' =>'BIF', 'weight' => 'KG_CM');
		$value['BJ'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
		$value['BM'] = array('region' => 'AM', 'currency' =>'BMD', 'weight' => 'LB_IN');
		$value['BN'] = array('region' => 'AP', 'currency' =>'BND', 'weight' => 'KG_CM');
		$value['BO'] = array('region' => 'AM', 'currency' =>'BOB', 'weight' => 'KG_CM');
		$value['BR'] = array('region' => 'AM', 'currency' =>'BRL', 'weight' => 'KG_CM');
		$value['BS'] = array('region' => 'AM', 'currency' =>'BSD', 'weight' => 'LB_IN');
		$value['BT'] = array('region' => 'AP', 'currency' =>'BTN', 'weight' => 'KG_CM');
		$value['BW'] = array('region' => 'AP', 'currency' =>'BWP', 'weight' => 'KG_CM');
		$value['BY'] = array('region' => 'AP', 'currency' =>'BYR', 'weight' => 'KG_CM');
		$value['BZ'] = array('region' => 'AM', 'currency' =>'BZD', 'weight' => 'KG_CM');
		$value['CA'] = array('region' => 'AM', 'currency' =>'CAD', 'weight' => 'LB_IN');
		$value['CF'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
		$value['CG'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
		$value['CH'] = array('region' => 'EU', 'currency' =>'CHF', 'weight' => 'KG_CM');
		$value['CI'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
		$value['CK'] = array('region' => 'AP', 'currency' =>'NZD', 'weight' => 'KG_CM');
		$value['CL'] = array('region' => 'AM', 'currency' =>'CLP', 'weight' => 'KG_CM');
		$value['CM'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
		$value['CN'] = array('region' => 'AP', 'currency' =>'CNY', 'weight' => 'KG_CM');
		$value['CO'] = array('region' => 'AM', 'currency' =>'COP', 'weight' => 'KG_CM');
		$value['CR'] = array('region' => 'AM', 'currency' =>'CRC', 'weight' => 'KG_CM');
		$value['CU'] = array('region' => 'AM', 'currency' =>'CUC', 'weight' => 'KG_CM');
		$value['CV'] = array('region' => 'AP', 'currency' =>'CVE', 'weight' => 'KG_CM');
		$value['CY'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['CZ'] = array('region' => 'EU', 'currency' =>'CZF', 'weight' => 'KG_CM');
		$value['DE'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['DJ'] = array('region' => 'EU', 'currency' =>'DJF', 'weight' => 'KG_CM');
		$value['DK'] = array('region' => 'AM', 'currency' =>'DKK', 'weight' => 'KG_CM');
		$value['DM'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
		$value['DO'] = array('region' => 'AP', 'currency' =>'DOP', 'weight' => 'LB_IN');
		$value['DZ'] = array('region' => 'AM', 'currency' =>'DZD', 'weight' => 'KG_CM');
		$value['EC'] = array('region' => 'EU', 'currency' =>'USD', 'weight' => 'KG_CM');
		$value['EE'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['EG'] = array('region' => 'AP', 'currency' =>'EGP', 'weight' => 'KG_CM');
		$value['ER'] = array('region' => 'EU', 'currency' =>'ERN', 'weight' => 'KG_CM');
		$value['ES'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['ET'] = array('region' => 'AU', 'currency' =>'ETB', 'weight' => 'KG_CM');
		$value['FI'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['FJ'] = array('region' => 'AP', 'currency' =>'FJD', 'weight' => 'KG_CM');
		$value['FK'] = array('region' => 'AM', 'currency' =>'GBP', 'weight' => 'KG_CM');
		$value['FM'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['FO'] = array('region' => 'AM', 'currency' =>'DKK', 'weight' => 'KG_CM');
		$value['FR'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['GA'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
		$value['GB'] = array('region' => 'EU', 'currency' =>'GBP', 'weight' => 'KG_CM');
		$value['GD'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
		$value['GE'] = array('region' => 'AM', 'currency' =>'GEL', 'weight' => 'KG_CM');
		$value['GF'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['GG'] = array('region' => 'AM', 'currency' =>'GBP', 'weight' => 'KG_CM');
		$value['GH'] = array('region' => 'AP', 'currency' =>'GHS', 'weight' => 'KG_CM');
		$value['GI'] = array('region' => 'AM', 'currency' =>'GBP', 'weight' => 'KG_CM');
		$value['GL'] = array('region' => 'AM', 'currency' =>'DKK', 'weight' => 'KG_CM');
		$value['GM'] = array('region' => 'AP', 'currency' =>'GMD', 'weight' => 'KG_CM');
		$value['GN'] = array('region' => 'AP', 'currency' =>'GNF', 'weight' => 'KG_CM');
		$value['GP'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['GQ'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
		$value['GR'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['GT'] = array('region' => 'AM', 'currency' =>'GTQ', 'weight' => 'KG_CM');
		$value['GU'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['GW'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
		$value['GY'] = array('region' => 'AP', 'currency' =>'GYD', 'weight' => 'LB_IN');
		$value['HK'] = array('region' => 'AM', 'currency' =>'HKD', 'weight' => 'KG_CM');
		$value['HN'] = array('region' => 'AM', 'currency' =>'HNL', 'weight' => 'KG_CM');
		$value['HR'] = array('region' => 'AP', 'currency' =>'HRK', 'weight' => 'KG_CM');
		$value['HT'] = array('region' => 'AM', 'currency' =>'HTG', 'weight' => 'LB_IN');
		$value['HU'] = array('region' => 'EU', 'currency' =>'HUF', 'weight' => 'KG_CM');
		$value['IC'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['ID'] = array('region' => 'AP', 'currency' =>'IDR', 'weight' => 'KG_CM');
		$value['IE'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['IL'] = array('region' => 'AP', 'currency' =>'ILS', 'weight' => 'KG_CM');
		$value['IN'] = array('region' => 'AP', 'currency' =>'INR', 'weight' => 'KG_CM');
		$value['IQ'] = array('region' => 'AP', 'currency' =>'IQD', 'weight' => 'KG_CM');
		$value['IR'] = array('region' => 'AP', 'currency' =>'IRR', 'weight' => 'KG_CM');
		$value['IS'] = array('region' => 'EU', 'currency' =>'ISK', 'weight' => 'KG_CM');
		$value['IT'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['JE'] = array('region' => 'AM', 'currency' =>'GBP', 'weight' => 'KG_CM');
		$value['JM'] = array('region' => 'AM', 'currency' =>'JMD', 'weight' => 'KG_CM');
		$value['JO'] = array('region' => 'AP', 'currency' =>'JOD', 'weight' => 'KG_CM');
		$value['JP'] = array('region' => 'AP', 'currency' =>'JPY', 'weight' => 'KG_CM');
		$value['KE'] = array('region' => 'AP', 'currency' =>'KES', 'weight' => 'KG_CM');
		$value['KG'] = array('region' => 'AP', 'currency' =>'KGS', 'weight' => 'KG_CM');
		$value['KH'] = array('region' => 'AP', 'currency' =>'KHR', 'weight' => 'KG_CM');
		$value['KI'] = array('region' => 'AP', 'currency' =>'AUD', 'weight' => 'KG_CM');
		$value['KM'] = array('region' => 'AP', 'currency' =>'KMF', 'weight' => 'KG_CM');
		$value['KN'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
		$value['KP'] = array('region' => 'AP', 'currency' =>'KPW', 'weight' => 'LB_IN');
		$value['KR'] = array('region' => 'AP', 'currency' =>'KRW', 'weight' => 'KG_CM');
		$value['KV'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['KW'] = array('region' => 'AP', 'currency' =>'KWD', 'weight' => 'KG_CM');
		$value['KY'] = array('region' => 'AM', 'currency' =>'KYD', 'weight' => 'KG_CM');
		$value['KZ'] = array('region' => 'AP', 'currency' =>'KZF', 'weight' => 'LB_IN');
		$value['LA'] = array('region' => 'AP', 'currency' =>'LAK', 'weight' => 'KG_CM');
		$value['LB'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
		$value['LC'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'KG_CM');
		$value['LI'] = array('region' => 'AM', 'currency' =>'CHF', 'weight' => 'LB_IN');
		$value['LK'] = array('region' => 'AP', 'currency' =>'LKR', 'weight' => 'KG_CM');
		$value['LR'] = array('region' => 'AP', 'currency' =>'LRD', 'weight' => 'KG_CM');
		$value['LS'] = array('region' => 'AP', 'currency' =>'LSL', 'weight' => 'KG_CM');
		$value['LT'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['LU'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['LV'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['LY'] = array('region' => 'AP', 'currency' =>'LYD', 'weight' => 'KG_CM');
		$value['MA'] = array('region' => 'AP', 'currency' =>'MAD', 'weight' => 'KG_CM');
		$value['MC'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['MD'] = array('region' => 'AP', 'currency' =>'MDL', 'weight' => 'KG_CM');
		$value['ME'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['MG'] = array('region' => 'AP', 'currency' =>'MGA', 'weight' => 'KG_CM');
		$value['MH'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['MK'] = array('region' => 'AP', 'currency' =>'MKD', 'weight' => 'KG_CM');
		$value['ML'] = array('region' => 'AP', 'currency' =>'COF', 'weight' => 'KG_CM');
		$value['MM'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
		$value['MN'] = array('region' => 'AP', 'currency' =>'MNT', 'weight' => 'KG_CM');
		$value['MO'] = array('region' => 'AP', 'currency' =>'MOP', 'weight' => 'KG_CM');
		$value['MP'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['MQ'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['MR'] = array('region' => 'AP', 'currency' =>'MRO', 'weight' => 'KG_CM');
		$value['MS'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
		$value['MT'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['MU'] = array('region' => 'AP', 'currency' =>'MUR', 'weight' => 'KG_CM');
		$value['MV'] = array('region' => 'AP', 'currency' =>'MVR', 'weight' => 'KG_CM');
		$value['MW'] = array('region' => 'AP', 'currency' =>'MWK', 'weight' => 'KG_CM');
		$value['MX'] = array('region' => 'AM', 'currency' =>'MXN', 'weight' => 'KG_CM');
		$value['MY'] = array('region' => 'AP', 'currency' =>'MYR', 'weight' => 'KG_CM');
		$value['MZ'] = array('region' => 'AP', 'currency' =>'MZN', 'weight' => 'KG_CM');
		$value['NA'] = array('region' => 'AP', 'currency' =>'NAD', 'weight' => 'KG_CM');
		$value['NC'] = array('region' => 'AP', 'currency' =>'XPF', 'weight' => 'KG_CM');
		$value['NE'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
		$value['NG'] = array('region' => 'AP', 'currency' =>'NGN', 'weight' => 'KG_CM');
		$value['NI'] = array('region' => 'AM', 'currency' =>'NIO', 'weight' => 'KG_CM');
		$value['NL'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['NO'] = array('region' => 'EU', 'currency' =>'NOK', 'weight' => 'KG_CM');
		$value['NP'] = array('region' => 'AP', 'currency' =>'NPR', 'weight' => 'KG_CM');
		$value['NR'] = array('region' => 'AP', 'currency' =>'AUD', 'weight' => 'KG_CM');
		$value['NU'] = array('region' => 'AP', 'currency' =>'NZD', 'weight' => 'KG_CM');
		$value['NZ'] = array('region' => 'AP', 'currency' =>'NZD', 'weight' => 'KG_CM');
		$value['OM'] = array('region' => 'AP', 'currency' =>'OMR', 'weight' => 'KG_CM');
		$value['PA'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'KG_CM');
		$value['PE'] = array('region' => 'AM', 'currency' =>'PEN', 'weight' => 'KG_CM');
		$value['PF'] = array('region' => 'AP', 'currency' =>'XPF', 'weight' => 'KG_CM');
		$value['PG'] = array('region' => 'AP', 'currency' =>'PGK', 'weight' => 'KG_CM');
		$value['PH'] = array('region' => 'AP', 'currency' =>'PHP', 'weight' => 'KG_CM');
		$value['PK'] = array('region' => 'AP', 'currency' =>'PKR', 'weight' => 'KG_CM');
		$value['PL'] = array('region' => 'EU', 'currency' =>'PLN', 'weight' => 'KG_CM');
		$value['PR'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['PT'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['PW'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'KG_CM');
		$value['PY'] = array('region' => 'AM', 'currency' =>'PYG', 'weight' => 'KG_CM');
		$value['QA'] = array('region' => 'AP', 'currency' =>'QAR', 'weight' => 'KG_CM');
		$value['RE'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['RO'] = array('region' => 'EU', 'currency' =>'RON', 'weight' => 'KG_CM');
		$value['RS'] = array('region' => 'AP', 'currency' =>'RSD', 'weight' => 'KG_CM');
		$value['RU'] = array('region' => 'AP', 'currency' =>'RUB', 'weight' => 'KG_CM');
		$value['RW'] = array('region' => 'AP', 'currency' =>'RWF', 'weight' => 'KG_CM');
		$value['SA'] = array('region' => 'AP', 'currency' =>'SAR', 'weight' => 'KG_CM');
		$value['SB'] = array('region' => 'AP', 'currency' =>'SBD', 'weight' => 'KG_CM');
		$value['SC'] = array('region' => 'AP', 'currency' =>'SCR', 'weight' => 'KG_CM');
		$value['SD'] = array('region' => 'AP', 'currency' =>'SDG', 'weight' => 'KG_CM');
		$value['SE'] = array('region' => 'EU', 'currency' =>'SEK', 'weight' => 'KG_CM');
		$value['SG'] = array('region' => 'AP', 'currency' =>'SGD', 'weight' => 'KG_CM');
		$value['SH'] = array('region' => 'AP', 'currency' =>'SHP', 'weight' => 'KG_CM');
		$value['SI'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['SK'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['SL'] = array('region' => 'AP', 'currency' =>'SLL', 'weight' => 'KG_CM');
		$value['SM'] = array('region' => 'EU', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['SN'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
		$value['SO'] = array('region' => 'AM', 'currency' =>'SOS', 'weight' => 'KG_CM');
		$value['SR'] = array('region' => 'AM', 'currency' =>'SRD', 'weight' => 'KG_CM');
		$value['SS'] = array('region' => 'AP', 'currency' =>'SSP', 'weight' => 'KG_CM');
		$value['ST'] = array('region' => 'AP', 'currency' =>'STD', 'weight' => 'KG_CM');
		$value['SV'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'KG_CM');
		$value['SY'] = array('region' => 'AP', 'currency' =>'SYP', 'weight' => 'KG_CM');
		$value['SZ'] = array('region' => 'AP', 'currency' =>'SZL', 'weight' => 'KG_CM');
		$value['TC'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['TD'] = array('region' => 'AP', 'currency' =>'XAF', 'weight' => 'KG_CM');
		$value['TG'] = array('region' => 'AP', 'currency' =>'XOF', 'weight' => 'KG_CM');
		$value['TH'] = array('region' => 'AP', 'currency' =>'THB', 'weight' => 'KG_CM');
		$value['TJ'] = array('region' => 'AP', 'currency' =>'TJS', 'weight' => 'KG_CM');
		$value['TL'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
		$value['TN'] = array('region' => 'AP', 'currency' =>'TND', 'weight' => 'KG_CM');
		$value['TO'] = array('region' => 'AP', 'currency' =>'TOP', 'weight' => 'KG_CM');
		$value['TR'] = array('region' => 'AP', 'currency' =>'TRY', 'weight' => 'KG_CM');
		$value['TT'] = array('region' => 'AM', 'currency' =>'TTD', 'weight' => 'LB_IN');
		$value['TV'] = array('region' => 'AP', 'currency' =>'AUD', 'weight' => 'KG_CM');
		$value['TW'] = array('region' => 'AP', 'currency' =>'TWD', 'weight' => 'KG_CM');
		$value['TZ'] = array('region' => 'AP', 'currency' =>'TZS', 'weight' => 'KG_CM');
		$value['UA'] = array('region' => 'AP', 'currency' =>'UAH', 'weight' => 'KG_CM');
		$value['UG'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
		$value['US'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['UY'] = array('region' => 'AM', 'currency' =>'UYU', 'weight' => 'KG_CM');
		$value['UZ'] = array('region' => 'AP', 'currency' =>'UZS', 'weight' => 'KG_CM');
		$value['VC'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
		$value['VE'] = array('region' => 'AM', 'currency' =>'VEF', 'weight' => 'KG_CM');
		$value['VG'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['VI'] = array('region' => 'AM', 'currency' =>'USD', 'weight' => 'LB_IN');
		$value['VN'] = array('region' => 'AP', 'currency' =>'VND', 'weight' => 'KG_CM');
		$value['VU'] = array('region' => 'AP', 'currency' =>'VUV', 'weight' => 'KG_CM');
		$value['WS'] = array('region' => 'AP', 'currency' =>'WST', 'weight' => 'KG_CM');
		$value['XB'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'LB_IN');
		$value['XC'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'LB_IN');
		$value['XE'] = array('region' => 'AM', 'currency' =>'ANG', 'weight' => 'LB_IN');
		$value['XM'] = array('region' => 'AM', 'currency' =>'EUR', 'weight' => 'LB_IN');
		$value['XN'] = array('region' => 'AM', 'currency' =>'XCD', 'weight' => 'LB_IN');
		$value['XS'] = array('region' => 'AP', 'currency' =>'SIS', 'weight' => 'KG_CM');
		$value['XY'] = array('region' => 'AM', 'currency' =>'ANG', 'weight' => 'LB_IN');
		$value['YE'] = array('region' => 'AP', 'currency' =>'YER', 'weight' => 'KG_CM');
		$value['YT'] = array('region' => 'AP', 'currency' =>'EUR', 'weight' => 'KG_CM');
		$value['ZA'] = array('region' => 'AP', 'currency' =>'ZAR', 'weight' => 'KG_CM');
		$value['ZM'] = array('region' => 'AP', 'currency' =>'ZMW', 'weight' => 'KG_CM');
		$value['ZW'] = array('region' => 'AP', 'currency' =>'USD', 'weight' => 'KG_CM');
	$packing_type = array("per_item" => "Pack Items Induviually", "weight_based" => "Weight Based Packing");
	$weight_dim_unit = array("LB_IN" => "LB_IN");
	$general_settings = get_option('a2z_usps_main_settings');
	$general_settings = empty($general_settings) ? array() : $general_settings;
	if(isset($_POST['save']))
	{
		$general_settings['a2z_usps_site_id'] = sanitize_text_field(isset($_POST['a2z_usps_site_id']) ? $_POST['a2z_usps_site_id'] : '');
		$general_settings['a2z_usps_site_pwd'] = sanitize_text_field(isset($_POST['a2z_usps_site_pwd']) ? $_POST['a2z_usps_site_pwd'] : '');
		
		$general_settings['a2z_usps_test'] = sanitize_text_field(isset($_POST['a2z_usps_test']) ? 'yes' : 'no');
		$general_settings['a2z_usps_rates'] = sanitize_text_field(isset($_POST['a2z_usps_rates']) ? 'yes' : 'no');
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
		$general_settings['a2z_usps_carrier'] = !empty($_POST['a2z_usps_carrier']) ? sanitize_post($_POST['a2z_usps_carrier']) : array();
		$general_settings['a2z_usps_carrier_name'] = !empty($_POST['a2z_usps_carrier_name']) ? sanitize_post($_POST['a2z_usps_carrier_name']) : array();
		$general_settings['a2z_usps_carrier_adj'] = !empty($_POST['a2z_usps_carrier_adj']) ? sanitize_post($_POST['a2z_usps_carrier_adj']) : array();
		$general_settings['a2z_usps_carrier_adj_percentage'] = !empty($_POST['a2z_usps_carrier_adj_percentage']) ? sanitize_post($_POST['a2z_usps_carrier_adj_percentage']) : array();
		$general_settings['a2z_usps_account_rates'] = sanitize_text_field(isset($_POST['a2z_usps_account_rates']) ? 'yes' : 'no');
		$general_settings['a2z_usps_developer_rate'] = sanitize_text_field(isset($_POST['a2z_usps_developer_rate']) ? 'yes' :'no');
		$general_settings['a2z_usps_insure'] = sanitize_text_field(isset($_POST['a2z_usps_insure']) ? 'yes' :'no');

		$general_settings['a2z_usps_uostatus'] = sanitize_text_field(isset($_POST['a2z_usps_uostatus']) ? 'yes' :'no');
		$general_settings['a2z_usps_trk_status_cus'] = sanitize_text_field(isset($_POST['a2z_usps_trk_status_cus']) ? 'yes' :'no');
		$general_settings['a2z_usps_cod'] = sanitize_text_field(isset($_POST['a2z_usps_cod']) ? 'yes' :'no');
		$general_settings['a2z_usps_label_automation'] = sanitize_text_field(isset($_POST['a2z_usps_label_automation']) ? 'yes' :'no');

		$general_settings['a2z_usps_packing_type'] = sanitize_text_field(isset($_POST['a2z_usps_packing_type']) ? $_POST['a2z_usps_packing_type'] : 'per_item');
		$general_settings['a2z_usps_max_weight'] = sanitize_text_field(isset($_POST['a2z_usps_max_weight']) ? $_POST['a2z_usps_max_weight'] : '100');
		$general_settings['a2z_usps_integration_key'] = sanitize_text_field(isset($_POST['a2z_usps_integration_key']) ? $_POST['a2z_usps_integration_key'] : '');
		$general_settings['a2z_usps_label_email'] = sanitize_text_field(isset($_POST['a2z_usps_label_email']) ? $_POST['a2z_usps_label_email'] : '');
		$general_settings['a2z_usps_ship_content'] = sanitize_text_field(isset($_POST['a2z_usps_ship_content']) ? $_POST['a2z_usps_ship_content'] : 'No shipment content');
		$general_settings['a2z_usps_print_size'] = sanitize_text_field(isset($_POST['a2z_usps_print_size']) ? $_POST['a2z_usps_print_size'] : '6X4_PDF');
		$general_settings['a2z_usps_service_type'] = sanitize_text_field(isset($_POST['a2z_usps_service_type']) ? $_POST['a2z_usps_service_type'] : '');
		$general_settings['a2z_usps_first_cls_type'] = sanitize_text_field(isset($_POST['a2z_usps_first_cls_type']) ? $_POST['a2z_usps_first_cls_type'] : '');
		$general_settings['a2z_usps_mail_type'] = sanitize_text_field(isset($_POST['a2z_usps_mail_type']) ? $_POST['a2z_usps_mail_type'] : '');
		
		$general_settings['a2z_usps_weight_unit'] = sanitize_text_field(isset($_POST['a2z_usps_weight_unit']) ? $_POST['a2z_usps_weight_unit'] : 'KG_CM');
		$general_settings['a2z_usps_con_rate'] = sanitize_text_field(isset($_POST['a2z_usps_con_rate']) ? $_POST['a2z_usps_con_rate'] : '');

		// Multi Vendor Settings

		$general_settings['a2z_usps_v_enable'] = sanitize_text_field(isset($_POST['a2z_usps_v_enable']) ? 'yes' : 'no');
		$general_settings['a2z_usps_v_rates'] = sanitize_text_field(isset($_POST['a2z_usps_v_rates']) ? 'yes' : 'no');
		$general_settings['a2z_usps_v_labels'] = sanitize_text_field(isset($_POST['a2z_usps_v_labels']) ? 'yes' : 'no');
		$general_settings['a2z_usps_v_roles'] = !empty($_POST['a2z_usps_v_roles']) ? sanitize_post($_POST['a2z_usps_v_roles']) : array();
		$general_settings['a2z_usps_v_email'] = sanitize_text_field(isset($_POST['a2z_usps_v_email']) ? 'yes' : 'no');

		if (isset($general_settings['a2z_usps_v_roles']['ID'])) {
			unset($general_settings['a2z_usps_v_roles']['ID']);
		}
		if (isset($general_settings['a2z_usps_v_roles']['filter'])) {
			unset($general_settings['a2z_usps_v_roles']['filter']);
		}

		if (isset($general_settings['a2z_usps_carrier']['ID'])) {
			unset($general_settings['a2z_usps_carrier']['ID']);
		}
		if (isset($general_settings['a2z_usps_carrier']['filter'])) {
			unset($general_settings['a2z_usps_carrier']['filter']);
		}

		if (isset($general_settings['a2z_usps_carrier_name']['ID'])) {
			unset($general_settings['a2z_usps_carrier_name']['ID']);
		}
		if (isset($general_settings['a2z_usps_carrier_name']['filter'])) {
			unset($general_settings['a2z_usps_carrier_name']['filter']);
		}

		if (isset($general_settings['a2z_usps_carrier_adj']['ID'])) {
			unset($general_settings['a2z_usps_carrier_adj']['ID']);
		}
		if (isset($general_settings['a2z_usps_carrier_adj']['filter'])) {
			unset($general_settings['a2z_usps_carrier_adj']['filter']);
		}

		if (isset($general_settings['a2z_usps_carrier_adj_percentage']['ID'])) {
			unset($general_settings['a2z_usps_carrier_adj_percentage']['ID']);
		}
		if (isset($general_settings['a2z_usps_carrier_adj_percentage']['filter'])) {
			unset($general_settings['a2z_usps_carrier_adj_percentage']['filter']);
		}

		update_option('a2z_usps_main_settings', $general_settings);
		
	}
		$general_settings['a2z_usps_currency'] = isset($value[(isset($general_settings['a2z_usps_country']) ? $general_settings['a2z_usps_country'] : 'A2Z')]) ? $value[$general_settings['a2z_usps_country']]['currency'] : '';
		$general_settings['a2z_usps_woo_currency'] = get_option('woocommerce_currency');
		
?>
<style type="text/css">
	/*hit_tabs*/
.hit_tabs {
  max-width: 100%;
  min-width: 100%;
  margin-top: 20px;
  padding: 0 20px;
}
.hit_tabs input[type=radio] {
  display: none;
}
.hit_tabs label {
  display: inline-block;
  padding: 6px 0 6px 0;
  margin: 0 -2px;
  width: 11%; /* =100/hit_tabs number */
  border-bottom: 1px solid #dadada;
  text-align: center;
  font-weight:600;
}
.hit_tabs label:hover {
  cursor: pointer;
}
.hit_tabs input:checked + label {
  border: 1px solid #dadada;
  border-width: 1px 1px 0 1px;
}
.hit_tabs #tab1:checked ~ .content #content1,
.hit_tabs #tab2:checked ~ .content #content2,
.hit_tabs #tab3:checked ~ .content #content3,
.hit_tabs #tab4:checked ~ .content #content4,
.hit_tabs #tab5:checked ~ .content #content5,
.hit_tabs #tab6:checked ~ .content #content6,
.hit_tabs #tab7:checked ~ .content #content7,
.hit_tabs #tab8:checked ~ .content #content8,
.hit_tabs #tab9:checked ~ .content #content9 {
  display: block;
}
.hit_tabs .content > div {
  display: none;
  padding-top: 20px;
  text-align: left;
  min-height: 240px;
  overflow: auto;
}
.woocommerce-save-button{margin-left:27px !important;}
</style>
<?php
if(!isset($general_settings['a2z_usps_site_id']) || $general_settings['a2z_usps_site_id'] == ''){
	?>
	<p style="    /* display: inline-block; */
    line-height: 1.4;
    padding: 11px 15px;
    font-size: 14px;
    text-align: left;
    margin: 25px 20px 0 2px;
    background-color: #fff;
    border-left: 4px solid #ffba00;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}"><?php _e('Required: Save USPS Account Settings.','a2z_usps') ?></p>

	<?php
}else if(!isset($general_settings['a2z_usps_shipper_name']) || $general_settings['a2z_usps_shipper_name'] == ''){
	?>
	<p style="    /* display: inline-block; */
    line-height: 1.4;
    padding: 11px 15px;
    font-size: 14px;
    text-align: left;
    margin: 25px 20px 0 2px;
    background-color: #fff;
    border-left: 4px solid #ffba00;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}"><?php _e('Required: Save Shipper Address.','a2z_usps') ?></p>

	<?php
}else if(!isset($general_settings['a2z_usps_carrier']) || empty($general_settings['a2z_usps_carrier'])){
	?>
	<p style="    /* display: inline-block; */
    line-height: 1.4;
    padding: 11px 15px;
    font-size: 14px;
    text-align: left;
    margin: 25px 20px 0 2px;
    background-color: #fff;
    border-left: 4px solid #ffba00;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}"><?php _e('Required: Choose serivices to continue. All domestic & international services are available','a2z_usps') ?></p>

	<?php
}
	$logo_url = str_replace("controllors/", "usps.png", plugin_dir_url( __DIR__ ));
	echo '<img src="'.$logo_url.'" alt="" style="width:80px;float:right;margin-top: -100px;">';
?>
 
 <div class="hit_tabs">
   <input id="tab1" type="radio" name="hit_tabs" checked>
   <label for="tab1" >USPS Account</label>
   <input id="tab2" type="radio" name="hit_tabs">
   <label for="tab2">Address</label>
   <input id="tab3" type="radio" name="hit_tabs">
   <label for="tab3">Shipping Rates</label>
   <input id="tab4" type="radio" name="hit_tabs">
   <label for="tab4">Services</label>
   <input id="tab5" type="radio" name="hit_tabs">
   <label for="tab5">Packing</label>
   <!-- <input id="tab6" type="radio" name="hit_tabs">
   <label for="tab6">Shipping Label</label> -->
   <input id="tab7" type="radio" name="hit_tabs">
   <label for="tab7">Multi Vendor</label>
   <input id="tab8" type="radio" name="hit_tabs">
   <label for="tab8">Hooks</label>
   <div class="content">
      <div id="content1">
      	<h3><?php _e('USPS Account Informations','a2z_usps') ?></h3>
      		<div>
				<table style="width:100%;">

					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('USPS Integration Team will give this details to you.','a2z_usps') ?>"></span>	<?php _e('USPS XML API Username','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" class="input-text regular-input" name="a2z_usps_site_id" value="<?php echo (isset($general_settings['a2z_usps_site_id'])) ? $general_settings['a2z_usps_site_id'] : ''; ?>">
						</td>

					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('USPS Integration Team will give this details to you.','a2z_usps') ?>"></span>	<?php _e('USPS XML API Password','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_site_pwd" value="<?php echo (isset($general_settings['a2z_usps_site_pwd'])) ? $general_settings['a2z_usps_site_pwd'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Enable this to Run the plugin in Test Mode','a2z_usps') ?>"></span>	<?php _e('Is this Test Credentilas?','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_test" <?php echo (isset($general_settings['a2z_usps_test']) && $general_settings['a2z_usps_test'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('This will Update automatically.','a2z_usps') ?>"></span>	<?php _e('Woocommerce Currency','a2z_usps') ?><font style="color:red;">*</font></h4><p>You can change your Woocommerce currency <a href="admin.php?page=wc-settings">here</a>.</p>
						</td>
						<td>
							<h4><?php echo $general_settings['a2z_usps_woo_currency'];?></h4>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('This will automatically Update after Saving Settings.','a2z_usps') ?>"></span>	<?php _e('USPS Currency','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<h4><?php echo (isset($general_settings['a2z_usps_currency'])) ? $general_settings['a2z_usps_currency'] : '(Update After Save Action)'; ?></h4>
						</td>
					</tr>
					<tr class="con_rate">
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Enter conversion rate.','a2z_usps') ?>"></span>	<?php _e('Exchange Rate','a2z_usps') ?><font style="color:red;">*</font> <?php echo "( ".$general_settings['a2z_usps_woo_currency']."->".$general_settings['a2z_usps_currency']." )"; ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_con_rate" value="<?php echo (isset($general_settings['a2z_usps_con_rate'])) ? $general_settings['a2z_usps_con_rate'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('This will automatically Update after Saving Settings.','a2z_usps') ?>"></span>	<?php _e('USPS Weight Unit','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<select name="a2z_usps_weight_unit" class="wc-enhanced-select" style="width:153px;">
								<?php foreach($weight_dim_unit as $key => $value)
								{
									if(isset($general_settings['a2z_usps_weight_unit']) && ($general_settings['a2z_usps_weight_unit'] == $key))
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

			</div>
      </div>

      <div id="content2">
      	<h3><?php _e('Shipper Address','a2z_usps') ?></h3>
			<div>
				
				<table style="width:100%;">
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Shipping Person Name','a2z_usps') ?>"></span>	<?php _e('Shipper Name','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_shipper_name" value="<?php echo (isset($general_settings['a2z_usps_shipper_name'])) ? $general_settings['a2z_usps_shipper_name'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Shipper Company Name.','a2z_usps') ?>"></span>	<?php _e('Company Name','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_company" value="<?php echo (isset($general_settings['a2z_usps_company'])) ? $general_settings['a2z_usps_company'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Shipper Mobile / Contact Number.','a2z_usps') ?>"></span>	<?php _e('Contact Number','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_mob_num" value="<?php echo (isset($general_settings['a2z_usps_mob_num'])) ? $general_settings['a2z_usps_mob_num'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Email Address of the Shipper.','a2z_usps') ?>"></span>	<?php _e('Email Address','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_email" value="<?php echo (isset($general_settings['a2z_usps_email'])) ? $general_settings['a2z_usps_email'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Address Line 1 of the Shipper from Address.','a2z_usps') ?>"></span>	<?php _e('Address Line 1','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_address1" value="<?php echo (isset($general_settings['a2z_usps_address1'])) ? $general_settings['a2z_usps_address1'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Address Line 2 of the Shipper from Address.','a2z_usps') ?>"></span>	<?php _e('Address Line 2','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_address2" value="<?php echo (isset($general_settings['a2z_usps_address2'])) ? $general_settings['a2z_usps_address2'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('City of the Shipper from address.','a2z_usps') ?>"></span>	<?php _e('City','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_city" value="<?php echo (isset($general_settings['a2z_usps_city'])) ? $general_settings['a2z_usps_city'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('State of the Shipper from address.','a2z_usps') ?>"></span>	<?php _e('State (Two Digit String)','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_state" value="<?php echo (isset($general_settings['a2z_usps_state'])) ? $general_settings['a2z_usps_state'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Postal/Zip Code.','a2z_usps') ?>"></span>	<?php _e('Postal/Zip Code','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_zip" value="<?php echo (isset($general_settings['a2z_usps_zip'])) ? $general_settings['a2z_usps_zip'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Country of the Shipper from Address.','a2z_usps') ?>"></span>	<?php _e('Country','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<select name="a2z_usps_country" class="wc-enhanced-select" style="width:153px;">
								<?php foreach($countires as $key => $value)
								{
									if(isset($general_settings['a2z_usps_country']) && ($general_settings['a2z_usps_country'] == $key))
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
			</div>
      </div>

      <div id="content3">
      	<h3><?php _e('USPS Rate Section','a2z_usps') ?></h3>
			<div>
				
				<table style="width:100%">
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Enable Real time Rates to Show Rates in Checkout Page','a2z_usps') ?>"></span>	<?php _e('Can I Show Rates?','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_rates" <?php echo (isset($general_settings['a2z_usps_rates']) && $general_settings['a2z_usps_rates'] == 'yes') ? 'checked="true"' : (!isset($general_settings['a2z_usps_rates']) ? 'checked="true"' : '') ; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					
					<!-- <tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Enable this option to fetch the USPS account/negotiable rates','a2z_usps') ?>"></span>	<?php _e('USPS Account Rates','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_account_rates" <?php echo (isset($general_settings['a2z_usps_account_rates']) && $general_settings['a2z_usps_account_rates'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr> -->
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Enable this option to fetch the enable the insurance to the products','a2z_usps') ?>"></span>	<?php _e('USPS Insurance','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_insure" <?php echo (isset($general_settings['a2z_usps_insure']) && $general_settings['a2z_usps_insure'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('It enables COD for orders','a2z_usps') ?>"></span>	<?php _e('Cash on Delivery','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_cod" <?php echo (isset($general_settings['a2z_usps_cod']) && $general_settings['a2z_usps_cod'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('','a2z_usps') ?>"></span>	<?php _e('Service type (Domestic)','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<select name="a2z_usps_service_type" class="wc-enhanced-select" style="width:153px;">
								<?php foreach($service_type_dom as $key => $value)
								{
									if(isset($general_settings['a2z_usps_service_type']) && ($general_settings['a2z_usps_service_type'] == $key))
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
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('','a2z_usps') ?>"></span>	<?php _e('First class type (Domestic)','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<select name="a2z_usps_first_cls_type" class="wc-enhanced-select" style="width:153px;">
								<?php foreach($first_cls_type as $key => $value)
								{
									if(isset($general_settings['a2z_usps_first_cls_type']) && ($general_settings['a2z_usps_first_cls_type'] == $key))
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
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('','a2z_usps') ?>"></span>	<?php _e('Mail type (International)','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<select name="a2z_usps_mail_type" class="wc-enhanced-select" style="width:153px;">
								<?php foreach($mail_type_intl as $key => $value)
								{
									if(isset($general_settings['a2z_usps_mail_type']) && ($general_settings['a2z_usps_mail_type'] == $key))
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
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Enable this option to Check the Request and Response','a2z_usps') ?>"></span>	<?php _e('Plugin is not Working? (This option show the request and Response in cart / Checkout Page)','a2z_usps') ?></h4>
						</td>
						<td >
							<input type="checkbox" name="a2z_usps_developer_rate" <?php echo (isset($general_settings['a2z_usps_developer_rate']) && $general_settings['a2z_usps_developer_rate'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Mail to the following Email address for Quick Support.','a2z_usps') ?>"></span>	<?php _e('HITShipo Support Email','a2z_usps') ?></h4>
						</td>
						<td>
							<a href="#" target="_blank">contact@hitstacks.com</a>
						</td>
					</tr>
				</table>
			</div>
      </div>
     
      <div id="content4">
      	<h3><?php _e('USPS Services (Change Name of the Services As you want)','a2z_usps') ?></h3>
			<div>
				
				<table style="width:100%;">
				<tr>
					<td colspan="2" style=" width: 50%; ">
						<h4><?php _e('Why this?','a2z_usps') ?><br/><?php _e('1) Enable Checkbox to Get the Service in Checkout Page','a2z_usps') ?><br/><?php _e('2) Add New Name in the Textbox to Chnage the Core Service Name.','a2z_usps') ?></h4>
					</td>
				</tr>
				<tr">
					<td>
						<h3 style="font-size: 1.10em;"><?php _e('Carries','a2z_usps') ?></h3>
					</td>
					<td>
						<h3 style="font-size: 1.10em;"><?php _e('Alternate Name for Carrier','a2z_usps') ?></h3>
					</td>
					<td>
						<h3 style="font-size: 1.10em;"><?php _e('Price adjustment','a2z_usps') ?></h3>
					</td>
					<td>
						<h3 style="font-size: 1.10em;"><?php _e('Price adjustment (%)','a2z_usps') ?></h3>
					</td>
				</tr>
						<?php foreach($_carriers as $key => $value)
						{
							echo '	<tr>
									<td>
									<input type="checkbox" value="yes" class="usps_service" name="a2z_usps_carrier['.$key.']" '. ((isset($general_settings['a2z_usps_carrier'][$key]) && $general_settings['a2z_usps_carrier'][$key] == 'yes') ? 'checked="true"' : '') .' > <small>'.__($value,"a2z_usps").'</small>
									</td>
									<td>
										<input type="text" name="a2z_usps_carrier_name['.$key.']" value="'.((isset($general_settings['a2z_usps_carrier_name'][$key])) ? __($general_settings['a2z_usps_carrier_name'][$key],"a2z_usps") : '').'">
									</td>
									<td>
										<input type="number" name="a2z_usps_carrier_adj['.$key.']" value="'.((isset($general_settings['a2z_usps_carrier_adj'][$key])) ? $general_settings['a2z_usps_carrier_adj'][$key] : '').'">
									</td>
									<td>
										<input type="number" name="a2z_usps_carrier_adj_percentage['.$key.']" value="'.((isset($general_settings['a2z_usps_carrier_adj_percentage'][$key])) ? $general_settings['a2z_usps_carrier_adj_percentage'][$key] : '').'">
									</td>
									</tr>';
						} ?>

					<tr>
						<td colspan="2" style="text-align: left;">
							<button type="button" id="checkAll" class="button">Select All</button>
							<button style="margin-left: 15px" type="button" id="uncheckAll" class="button">Unselect All</button>
						</td>
					</tr>
				</table>
			</div>
      </div>
      <div id="content5">
      	<h3><?php _e('USPS Packing Section','a2z_usps') ?></h3>
			<div>
				
				<table style="width:100%">
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Integration key Created from HIT Shipo','a2z_usps') ?>"></span>	<?php _e('Select Package Type','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<select name="a2z_usps_packing_type" class="wc-enhanced-select" style="width:153px;">
								<?php foreach($packing_type as $key => $value)
								{
									if(isset($general_settings['a2z_usps_packing_type']) && ($general_settings['a2z_usps_packing_type'] == $key))
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
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('To email address, the shipping label, Commercial invoice will sent.') ?>"></span>	<?php _e('What is the Maximum weight to one package?','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="number" name="a2z_usps_max_weight" placeholder="" value="<?php echo (isset($general_settings['a2z_usps_max_weight'])) ? $general_settings['a2z_usps_max_weight'] : ''; ?>">
						</td>
					</tr>
				</table>
			</div>
      </div>
      <div id="content6">
      	<h3><?php _e('USPS Shipping Label Section','a2z_usps') ?></h3>
      	<p><?php _e('This is a premium service. <br/> USPS Shipping label will created by our hitshipo only. You can create shipping labels automatically. There is no manual work need. <br/>Please register in hitshipo to create a shipping labels. <small style="color:green;">Trail available.</small><br> Checkout HIShipo Product Page:','a2z_usps') ?> <a href="https://hitshipo.com/">https://hitshipo.com/</a></p>
			<div>
				
				<table style="width:100%">
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Integration key Created from HIT Shipo','a2z_usps') ?>"></span>	<?php _e('HIT-Shipo Integration Key','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_integration_key" placeholder="" value="<?php echo (isset($general_settings['a2z_usps_integration_key'])) ? $general_settings['a2z_usps_integration_key'] : ''; ?>"><br/>
							<a href="https://hitshipo.com/">Don't have a key? Signup for free</a>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('This will create a shipping label automatically, once the order is placed by USPS services.','a2z_usps') ?>"></span>	<?php _e('Create shipping label without any delay (Automated)','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_label_automation" <?php echo (isset($general_settings['a2z_usps_label_automation']) && $general_settings['a2z_usps_label_automation'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('To email address, the shipping label, Commercial invoice will sent.') ?>"></span>	<?php _e('To whom i want to sent the shipping label once created (email address).','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_label_email" placeholder="" value="<?php echo (isset($general_settings['a2z_usps_label_email'])) ? $general_settings['a2z_usps_label_email'] : ''; ?>">
						</td>
					</tr>
					
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('It changes your order status ( backoffice orders page) based on tracking','a2z_usps') ?>"></span>	<?php _e('update order status by tracking','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_uostatus" <?php echo (isset($general_settings['a2z_usps_uostatus']) && $general_settings['a2z_usps_uostatus'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('It shows USPS tracking details in your customer\'s order page after creating the shipment (Front office)','a2z_usps') ?>"></span>	<?php _e('Enable USPS tracking informations to Customers','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_trk_status_cus" <?php echo (isset($general_settings['a2z_usps_trk_status_cus']) && $general_settings['a2z_usps_trk_status_cus'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Integration key Created from HIT Shipo','a2z_usps') ?>"></span>	<?php _e('Shipment Content','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<input type="text" name="a2z_usps_ship_content" placeholder="" value="<?php echo (isset($general_settings['a2z_usps_ship_content'])) ? $general_settings['a2z_usps_ship_content'] : ''; ?>">
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Country of the Shipper from Address.','a2z_usps') ?>"></span>	<?php _e('Shipping Label Format','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<b>PDF</b>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Country of the Shipper from Address.','a2z_usps') ?>"></span>	<?php _e('Shipping Label Size','a2z_usps') ?><font style="color:red;">*</font></h4>
						</td>
						<td>
							<select name="a2z_usps_print_size" class="wc-enhanced-select" style="width:153px;">
								<?php foreach($print_size as $key => $value)
								{
									if(isset($general_settings['a2z_usps_print_size']) && ($general_settings['a2z_usps_print_size'] == $key))
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
			</div>
      </div>

      <div id="content7">
      	<h3><?php _e('Multi Vendor Support','a2z_usps') ?></h3>
      	<p></p>
			<div>
				<table style="width:100%">
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Enable multi vendor to create shipping label from diffrent address.','a2z_usps') ?>"></span>	<?php _e('Are you using Multi vendor?','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_v_enable" <?php echo (isset($general_settings['a2z_usps_v_enable']) && $general_settings['a2z_usps_v_enable'] == 'yes') ? 'checked="true"' : ''; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('The shipping rates calculates from this address only. Suppose 2 vendors products in same cart. Then We will calculate the each vendor shipping cost then update to customers.','a2z_usps') ?>"></span>	<?php _e('Do I wants to calculate the shipping rates based on vendor address?','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_v_rates" <?php echo (isset($general_settings['a2z_usps_v_rates']) && $general_settings['a2z_usps_v_rates'] == 'yes') ? 'checked="true"' : '' ; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr style="display: none;">
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('The shipping Label created from vendor address to customer address.','a2z_usps') ?>"></span>	<?php _e('Do I wants to create shipping labels based on vendor address?','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_v_labels" <?php echo (isset($general_settings['a2z_usps_v_labels']) && $general_settings['a2z_usps_v_labels'] == 'yes') ? 'checked="true"' : '' ; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
					<tr>
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('The shipping Label created from vendor address to customer address.','a2z_usps') ?>"></span>	<?php _e('What all are the user roles used for multi vendor?','a2z_usps') ?></h4>
						</td>
						<td>

							<select name="a2z_usps_v_roles[]" multiple="true" class="wc-enhanced-select" style="width: auto;">

								<?php foreach (get_editable_roles() as $role_name => $role_info){
									if(isset($general_settings['a2z_usps_v_roles']) && in_array($role_name, $general_settings['a2z_usps_v_roles'])){
										echo "<option value=".$role_name." selected='true'>".$role_info['name']."</option>";
									}else{
										echo "<option value=".$role_name.">".$role_info['name']."</option>";
									}
									
								}
							?>

							</select>
						</td>
					</tr>
					<tr style="display: none;">
						<td style=" width: 50%; ">
							<h4> <span class="woocommerce-help-tip" data-tip="<?php _e('Once shipping label is generated, Shipping Label will email to the vendor emails.','a2z_usps') ?>"></span>	<?php _e('Do i wants to sent created shipping label to the vendor email?','a2z_usps') ?></h4>
						</td>
						<td>
							<input type="checkbox" name="a2z_usps_v_email" <?php echo (isset($general_settings['a2z_usps_v_email']) && $general_settings['a2z_usps_v_email'] == 'yes') ? 'checked="true"' : '' ; ?> value="yes" > <?php _e('Yes','a2z_usps') ?>
						</td>
					</tr>
				</table>
			</div>
      </div>
   </div>
</div>


<?php wp_enqueue_script('jquery'); ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	var usps_curr = '<?php echo $general_settings['a2z_usps_currency']; ?>';
	var woo_curr = '<?php echo $general_settings['a2z_usps_woo_currency']; ?>';
	// console.log(usps_curr);
	// console.log(woo_curr);

	if (usps_curr != null && usps_curr == woo_curr) {
		jQuery('.con_rate').each(function(){
		jQuery('.con_rate').hide();
	    });
	}else{
		jQuery('.con_rate').each(function(){
		jQuery('.con_rate').show();
	    });
	}

	if('#checkAll'){
    	jQuery('#checkAll').on('click',function(){
            jQuery('.usps_service').each(function(){
                this.checked = true;
            });
    	});
    }
    if('#uncheckAll'){
    jQuery('#uncheckAll').on('click',function(){
            jQuery('.usps_service').each(function(){
                this.checked = false;
            });
    	});
	}
});
</script>
