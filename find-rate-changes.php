<?php

require_once 'provider-list.php';

// Directory to save the daily serialised object.
$dataDir    = '/home/user/data/standard-rates/track/';

// Contains the actual rate changes, per provider.
$changeFile = 'changes.ser';

$changes  = NULL;
$isChange = false;

// Bring in the exisiting changes file
if (file_exists($dataDir . $changeFile)) {
	$ser = file_get_contents($dataDir . $changeFile);
	$changes = unserialize($ser);
} else {
	$changes = (object) NULL;
	$changes->lastUpdated = date('Y-m-d', 0);
	$changes->providers   = array();
	$changes->libor       = 0;
	
	$isChange = true;
}

// Find the list of data files that need updating
// TODO: sort order of files, oldest first
$files = array(
	'rates-2009-01-11.ser', 'rates-2009-01-12.ser'
);

// Read in each file and check for changes
foreach ($files as $dailyFile) {
	$ser        = file_get_contents($dataDir . $dailyFile);
	$dailyRates = unserialize($ser);
	
	echo "Processing $dailyRates->date: ";
	
	foreach($dailyRates->providers as $providerKey=>$dailyRate) {
		// Create an uptodate rate object
		$curRate = (object) NULL;
		$curRate->date = $dailyRates->date;
		$curRate->rate = $dailyRate;
		
		// Get last known change
		if (empty($changes->providers[$providerKey])) {
			// No key for the provider, so this is the first one
			$changes->providers[$providerKey] = array();
			array_push($changes->providers[$providerKey], $curRate);
			
			$changes->lastUpdated = $curRate->date;			
			$isChange = true;
			echo "$providerKey ";
		} else {
			// Get the last rate change and compare the rates
			$rateIdx = count($changes->providers[$providerKey]) - 1;
			$lastRate = $changes->providers[$providerKey][$rateIdx];
			
			if ($lastRate->rate != $curRate->rate) {
				// This is a new rate change
				array_push($changes->providers[$providerKey], $curRate);

				$changes->lastUpdated = $curRate->date;			
				$isChange = true;			
				echo "$providerKey ";
			}
		}
	} 
	echo "\n";
}

// Write the change file back if changed.
if ($isChange) {
	echo "Writing rate change file. (", $changes->lastUpdated, ")\n";
	$ser = serialize($changes);
	file_put_contents($dataDir . $changeFile, $ser);
} else {
	echo "No rate changes.\n";
}


?>