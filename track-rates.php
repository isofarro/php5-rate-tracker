<?php

require_once 'simplehtmldom/simple_html_dom.php';
require_once 'standard-rates.php';

// Directory to look for pre-saved HTML documents for offline use
// Comment out to retrieve the actual URL.
$htmlDir = '/home/user/data/standard-rates/html-cache/';

// Directory to save the daily serialised object.
$dataDir = '/home/user/data/standard-rates/track/';

// Error log file
$errorFile = '/home/user/data/standard-rates/errorLog.ser';

// List of mortgage providers
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
//	//Commented out because of out of memory issues
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
	),
	'rbs' => array(
		'name' => 'Royal Bank of Scotland',
		'url'  => 'http://www.rbs.co.uk/personal/mortgages/g2/fixed-rate.ashx',
		'file' => 'rbs-fixed-rate.html'
	),
	'natwest' => array(
		'name' => 'Natwest',
		'url'  => 'http://www.natwest.com/personal/mortgages/g3/fixed-rate.ashx',
		'file' => 'natwest-fixed-rate.html'
	),
	'halifax' => array(
		'name' => 'Halifax',
		'url'  => 'http://www.halifax.co.uk/mortgages/2yearfixedswitch.asp',
		'file' => 'halifax-2yearfixedswitch.html'
	),
	'chelsea' => array(
		'name' => 'Chelsea',
		'url'  => 'http://www.thechelsea.co.uk/mortgages/nb_product_intro.html',
		'file' => 'chelsea-nb_product_intro.html'
	)
);

echo "Daily Update: Standard variable mortgage rate.\n";

// Get the Daily mortgage rates
$helper   = new MortgageRates();
$helper->setProviders($providers);
$rates    = $helper->getDailyRates();
//print_r($rates);

// Create the file to write daily rates to
$rateFile = $rates->date . '.ser';
$filePath = $dataDir . $rateFile;
echo "Filename: $filePath\n";

$isWriteable = true;

if (!empty($rates->isCachedData) && file_exists($filePath)) {
	// Don't write if we have cached data, and a file already exists
	// So we never overwrite live data
	$isWriteable = false;
} elseif (count($rates->providers)==0) {
	// Don't write if the providers list is empty
	$isWriteable = false;
}

if ($isWriteable) {
	echo "Writing rates for {$rates->date}\n";
	$ser = serialize($rates);
	file_put_contents($filePath, $ser);
} else {
	echo "Skipping writing rates file {$rateFile}\n";
}

// Write out error file
$helper->saveErrors($errorFile);

?>
