<?php

interface MortgageRateParserInterface {
	//public function register();
	public function extractRate($dom);
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



class MortgageRates {


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
			default:
				echo "No parser for domain: $domain\n";
				break;
		}
		
		// TODO: Check that the class is an implementation
		// of MortgageRateParserInterface
		return $parser;
	}

}


?>
