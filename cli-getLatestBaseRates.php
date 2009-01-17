<?php

require_once 'simplehtmldom/simple_html_dom.php';
require_once 'MortgageRates.php';

// Directory to look for pre-saved HTML documents for offline use
// Comment out to retrieve the actual URL.
$htmlDir = '/home/user/data/standard-rates/html-cache/';

// Directory to save the daily serialised object.
$dataDir = '/home/user/data/standard-rates/track/';

// Error log file
$errorFile = '/home/user/data/standard-rates/errorLog.ser';

// List of base rate providers
$providers = array(
	'bank-of-england' => array(
		'name' => 'Bank of England',
		'url'  => 'http://www.bankofengland.co.uk/',
		'file' => 'bankofengland-base-rate.html'
	)
);

echo "Daily Update: Bank of England base rate.\n";

// Get the Daily mortgage rates
$helper   = new MortgageRates();

if ($htmlDir) {
	$htmlPage = $htmlDir . $providers['bank-of-england']['file'];
	$rates    = $helper->getBaseRate($providers['bank-of-england']['url'], $htmlPage);
} else {
	$rates    = $helper->getBaseRate($providers['bank-of-england']['url']);
}
print_r($rates);

/********
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
********/
?>
