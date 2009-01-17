<?php

require_once 'provider-list.php';

// Data Directory of the daily serialised object.
$dataDir    = '/home/user/data/standard-rates/track/';

// Contains the actual rate changes, per provider.
$changeFile = 'changes.ser';

$changes  = NULL;

// Bring in the exisiting changes file
if (file_exists($dataDir . $changeFile)) {
	$ser = file_get_contents($dataDir . $changeFile);
	$changes = unserialize($ser);
} else {
	die("ERROR: Can't find the changes file {$dataDir}{$changeFile}\n");
}

//print_r($changes);

echo "Last change: ", $changes->lastUpdated, "\n";

foreach($changes->providers as $name=>$rates) {
	$provider = $providers[$name]['name'];
	$curRate  = NULL;
	
	if (count($rates)>0) {
		echo "$provider:\n";
		foreach($rates as $rateChange) {
			echo ' * ', $rateChange->date, ': ', $rateChange->rate, '%';
			if (!is_null($curRate)) {
				$diff = $rateChange->rate - $curRate;
				echo ' (', $diff, '%)';
			}
			$curRate = $rateChange->rate;
			echo "\n";
		}
		echo "\n";
	}	
}


?>