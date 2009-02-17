<?php

require_once 'simplehtmldom/simple_html_dom.php';
require_once 'MortgageRates.php';

// Directory to look for pre-saved HTML documents for offline use
// Comment out to retrieve the actual URL.
//$htmlDir = '/home/user/data/standard-rates/html-cache/';

// Directory to save the daily serialised object.
$dataDir = '/home/user/data/standard-rates/track/';

// Error log file
$errorFile = '/home/user/data/standard-rates/errorLog.ser';

// List of mortgage providers
include_once 'provider-list.php';

// Or bring in just one provider:
/********
$providers = array(
	'rbs' => array(
		'name' => 'Royal Bank of Scotland',
		'url'  => 'http://www.rbs.co.uk/personal/mortgages/g2/fixed-rate.ashx',
		'file' => 'rbs-fixed-rate.html'
	),
	'natwest' => array(
		'name' => 'Natwest',
		'url'  => 'http://www.natwest.com/personal/mortgages/g3/fixed-rate.ashx',
		'file' => 'natwest-fixed-rate.html'
	)
);
//file_put_contents('tmp.html', file_get_contents($providers['abbey']['url'])); exit;
********/


echo "Daily Update: Standard variable mortgage rate.\n";

// Get the Daily mortgage rates
$helper   = new MortgageRates();
$helper->setProviders($providers);
$rates    = $helper->getDailyRates();
//print_r($rates);

//exit;

// Create the file to write daily rates to
$rateFile = 'daily-' . $rates->date . '.ser';
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
