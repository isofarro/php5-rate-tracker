<?php

require_once 'simplehtmldom/simple_html_dom.php';
require_once 'standard-rates.php';

$htmlDir = '/home/user/data/standard-rates/html-cache/';

$providers = array(
	'northern-rock' => array(
		'name' => 'Northern Rock',
		'url'  => 'http://www.northernrock.co.uk/mortgages/current-rates/residential/',
		'file' => 'northern-rock-residential.html'
	),
	'nationwide' => array(
		'name' => 'Nationwide',
		'url'  => 'http://www.nationwide.co.uk/mortgage/remortgage/productsandrates/variableinterest-rates.htm',
		'file' => 'nationwide-variableinterest-rates.html'
	),
	'lloydstsb' => array(
		'name' => 'Lloyds TSB',
		'url'  => 'http://www.lloydstsb.com/mortgage/2_year_fixed_rate_motgages_50k_to_999k.asp',
		'file' => 'lloydstsb-2_year_fixed_rate_motgages_50k_to_999k.html'
	),
	'woolwich' => array(
		'name' => 'Woolwich',
		'url'  => 'http://www.woolwich.co.uk/mortgages/compare-our-mortgages.html',
		'file' => 'woolwich-compare-our-mortgages.html'
	),
//	'cheltglos' => array(
//		'name' => 'Cheltenham & Gloucester',
//		'url'  => 'http://www.cheltglos.co.uk/mortgages/fixed-rates/index.html',
//		'file' => 'cheltenham-fixed-rate-index.html'
//	),
	'abbey' => array(
		'name' => 'Abbey',
		'url'  => 'http://www.abbey.com/csgs/Satellite?c=GSProducto&cid=1127562795758&pagename=Abbey/GSProducto/GS_Producto',
		'file' => 'abbey-fixed-rate-Satellite.html'
	),
	'hsbc' => array(
		'name' => 'HSBC',
		'url'  => 'http://www.hsbc.co.uk/1/2/personal/mortgages/remortgage/fixed-rate',
		'file' => 'hsbc-fixed-rate.html'
	),
	'aandl' => array(
		'name' => 'Alliance and Leicester',
		'url'  => 'http://www.alliance-leicester.com/mortgages/mortgage-rates.aspx',
		'file' => 'alliance-leicester-mortgage-rates.html'
	),
	'firstdirect' => array(
		'name' => 'First Direct',
		'url'  => 'http://www.firstdirect.com/mortgages/rates.shtml',
		'file' => 'firstdirect-fixed-rates.html'
	)
);

/** Other providers:
	* Halifax
	* Chelsea Building Society
	* RBS/Natwest
**/

echo "Standard variable mortgage rate\n";
echo "===============================\n";

$helper   = new MortgageRates();
$rates    = array();

foreach($providers as $key=>$provider) {
	$htmlFile    = $htmlDir . $provider['file'];
	$rate        = $helper->getRate($provider['url'], $htmlFile);
	$rates[$key] = $rate;
	echo $rate, "\t - ", $provider['name'], "\n";
}

print_r($rates);


?>
