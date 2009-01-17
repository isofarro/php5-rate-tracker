<?php

require_once 'simplehtmldom/simple_html_dom.php';
require_once 'MortgageRates.php';

// Directory to look for pre-saved HTML documents for offline use
// Comment out to retrieve the actual URL.
//$htmlDir = '/home/user/data/standard-rates/html-cache/';

// Bring in common list of providers
include_once 'provider-list.php';

echo "Standard variable mortgage rate\n";
echo "===============================\n";

$helper   = new MortgageRates();
$rates    = array();

foreach($providers as $key=>$provider) {
	if (empty($htmlDir)) {
		# Use the real URL	
		$rate        = $helper->getRate($provider['url']);
	} else {
		# Use the offline cache
		$htmlFile    = $htmlDir . $provider['file'];
		$rate        = $helper->getRate($provider['url'], $htmlFile);
	}
	$rates[$key] = $rate;
	echo $rate, "\t - ", $provider['name'], "\n";
}

print_r($rates);


?>
