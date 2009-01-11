<?php

interface MortgageRateParserInterface {
	//public function register();
	public function extractRate($dom);
}

/****************************************************************************
*
* Domain specific Mortgage Rate parsers
*
****************************************************************************/

class AandLParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "AandL: extracting rate.\n";
		$row = $dom->find('div.mortgage-table table tr', 1);
		//echo $row->plaintext;
		$cell = $row->find('td', 2);
		//echo $cell->plaintext;
		if (preg_match('/^(\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class AbbeyParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "Abbey: extracting rate.\n";
		$row = $dom->find('table.wordContent tbody tr', 3);
		//echo $row->plaintext;
		$cell = $row->find('td', 1);
		//echo $cell->plaintext;
		if (preg_match('/(\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class ChelseaParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "Chelsea: extracting rate.\n";
		$row = $dom->find('div.standard_table table tr', 2);
		//echo $row->plaintext;
		$cell = $row->find('td', 1);
		//echo $cell->plaintext;
		if (preg_match('/currently (\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class CheltenhamParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "Cheltenham: extracting rate.\n";
		$row = $dom->find('td.svmr', 0);
		//echo $row->plaintext;
		if (preg_match('/^(\d*\.\d*)%/', $row->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class FirstDirectParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "FirstDirect: extracting rate.\n";
		$row = $dom->find('table.tableStyleOne tr', 1);
		//echo $row->plaintext;
		$cell = $row->find('td', 0);
		//echo $cell->plaintext;
		if (preg_match('/currently (\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class HalifaxParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "Halifax: extracting rate.\n";
		$row = $dom->find('div.main table tr', 2);
		//echo $row->plaintext;
		$cell = $row->find('td', 3);
		//echo $cell->plaintext;
		if (preg_match('/(\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class HsbcParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "HSBC: extracting rate.\n";
		$row = $dom->find('table.savingsDataNew tbody tr', 1);
		//echo $row->plaintext;
		$cell = $row->find('td', 4);
		//echo $cell->plaintext;
		if (preg_match('/Currently (\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class LloydsTsbParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "Lloyds TSB: extracting rate.\n";
		$row = $dom->find('div#datatable div.resultstable table.datatable tbody tr.light', 0);
		$cell = $row->find('td', 1);
		//echo $cell->plaintext;
		if (preg_match('/^(\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class NationwideParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "Nationwide: extracting rate.\n";
		$row = $dom->find('div#panel0 table.radioTbl tbody tr', 2);
		$cell = $row->find('td', 2);
		//echo $cell->plaintext;
		if (preg_match('/^(\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class NatwestParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "Natwest: extracting rate.\n";
		$row = $dom->find('table#sectionsection1 tr ', 2);
		//echo $row->plaintext;
		$cell = $row->find('td', 3);
		//echo $cell->plaintext;
		if (preg_match('/^(\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class NorthernRockParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "NorthernRock: extracting rate.\n";
		$row  = $dom->find('table.tblMortgage tbody tr td', 3);
		if (preg_match('/^(\d*\.\d*)% /', $row->plaintext, $matches)) {
			//echo "Rate: $matches[1]\n";
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class RbsParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "RBS: extracting rate.\n";
		$row = $dom->find('table.rates tr', 1);
		//echo $row->plaintext;
		$cell = $row->find('td', 2);
		//echo $cell->plaintext;
		if (preg_match('/(\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}

class WoolwichParser implements MortgageRateParserInterface {
	public function extractRate($dom) {
		//echo "Woolwich: extracting rate.\n";
		$row = $dom->find('div.three_column_container table.product_table tbody tr.lineone', 0);
		//echo $row->plaintext;
		$cell = $row->find('td', 2);
		//echo $cell->plaintext;
		if (preg_match('/currently (\d*\.\d*)%/', $cell->plaintext, $matches)) {
			if (is_numeric($matches[1])) {
				return $matches[1];
			}
		}
		return NULL;
	}
}


/****************************************************************************
*
* Wrapper class for site specific standard variable mortgage rate parser.
*
****************************************************************************/


class MortgageRates {
	public $providers;
	public $errorLog = array();
	
	public function setProviders($providers) {
		$this->providers = $providers;
	}
	
	public function getDailyRates() {
		global $htmlDir;
		
		$rates = (object) NULL;
		$rates->date = date('Y-m-d');
		if (!empty($htmlDir)) {
			$rates->isCachedData = 'true';
		}
		$rates->providers = array();

		foreach($this->providers as $key=>$provider) {
			if (empty($htmlDir)) {
				# Use the real URL	
				$rate        = $this->getRate($provider['url']);
			} else {
				# Use the offline cache
				$htmlFile    = $htmlDir . $provider['file'];
				$rate        = $this->getRate($provider['url'], $htmlFile);
			}
			
			if (is_null($rate)) {
				$this->logError('WARN', 
					'Null Rate for Provider ' . $key . 
					' at ' . $provider['url']
				);
			}
			
			$rates->providers[$key] = $rate;
			echo $rate, "\t - ", $provider['name'], "\n";
		}
		return $rates;
	}


	public function getRate($url, $data=false) {
		$rate = $this->extractRate($url, $data);
		return $rate;
	}

	public function getDomain($url) {
		//echo "Domain: $url\n";
		// Extract the domain name from the URL
		if (preg_match('/\:\/\/([^\/]+)\//', $url, $matches)) {
			//echo "Domain extracted: ", $matches[1], "\n";
			return $matches[1];
		}
		return NULL;
	}

	public function extractRate($url, $data=false) {
		$domain = $this->getDomain($url);
		
		if ($data) {
			$dom = file_get_html($data);
		} else {
			$dom = file_get_html($url);
		}
		
		$parser = $this->getParser($domain);
		
		if ($parser) {
			$rate   = $parser->extractRate($dom);
			return $rate;
		}
		return '-';
	}

	public function getParser($domain) {	
		// TODO: rework this to be a set of plugins
		// rather than hard coded parser class instantiations
		$parser = NULL;
		switch($domain) {
			case 'www.northernrock.co.uk':
				$parser = new NorthernRockParser();
				break;
			case 'www.nationwide.co.uk':
				$parser = new NationwideParser();
				break;
			case 'www.lloydstsb.com':
				$parser = new LloydsTsbParser();
				break;
			case 'www.woolwich.co.uk':
				$parser = new WoolwichParser();
				break;
			case 'www.cheltglos.co.uk':
				$parser = new CheltenhamParser();
				break;
			case 'www.abbey.com':
				$parser = new AbbeyParser();
				break;
			case 'www.hsbc.co.uk':
				$parser = new HsbcParser();
				break;
			case 'www.alliance-leicester.com':
				$parser = new AandLParser();
				break;
			case 'www.firstdirect.com':
				$parser = new FirstDirectParser();
				break;
			case 'www.rbs.co.uk':
				$parser = new RbsParser();
				break;
			case 'www.natwest.com':
				$parser = new NatwestParser();
				break;
			case 'www.halifax.co.uk':
				$parser = new HalifaxParser();
				break;
			case 'www.thechelsea.co.uk':
				$parser = new ChelseaParser();
				break;
			default:
				//echo "No parser for domain: $domain\n";
				$this->logError("WARN", "No parser for domain: $domain");
				break;
		}
		
		// TODO: Check that the class is an implementation
		// of MortgageRateParserInterface
		return $parser;
	}

	public function getErrors() {
		return $this->errorLog;
	}
	
	public function logError($level, $msg) {
		$error = (object) NULL;
		$error->timestamp = time();
		$error->level     = $level;
		$error->msg       = $msg;
		
		array_push($this->errorLog, $error);
	}
	
	public function saveErrors($filePath) {
		if (count($this->errorLog)>0) {
			$dateKey = date('Y-m-d');
			
			$errorLogs = array();
			
			// Read in the error file if it exists
			if (file_exists($filePath)) {
				$ser = file_get_contents($filePath);
				$errorLogs = unserialize($ser);
			}
			
			if (empty($errorLogs[$dateKey])) {
				// New error log for today
				$errorLogs[$dateKey] = $this->errorLog;
			} else {
				// Append to today's existing errors
				foreach($this->errorLog as $error) {
					array_push($errorLogs[$dateKey], $error);
				}
			}
			
			// Write the error file back
			$ser = serialize($errorLogs);
			file_put_contents($filePath, $ser);
			echo count($this->errorLog), " messages written to error log.\n";
		}
	}
}


?>
