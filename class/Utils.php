<?php

class Utils {

	static function curl($url, $headers = "") {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if ($headers)
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	static function curlIntoFile($url, $filename, $headers = "") {
		$fp = fopen($filename, 'w+');
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if ($headers)
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}

	function download($file_source, $file_target) {
		$rh = fopen($file_source, 'rb');
		$wh = fopen($file_target, 'w+b');
		if (!$rh || !$wh) {
			return false;
		}

		while (!feof($rh)) {
			if (fwrite($wh, fread($rh, 4096)) === FALSE) {
				return false;
			}
//			echo ' ';
			flush();
		}
		fclose($rh);
		fclose($wh);
//		echo PHP_EOL;
		return true;
	}

	static function randomString($length = 6) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$randstring = '';
		for ($i = 0; $i < $length; $i++) {
			$randstring .= $characters[rand(0, strlen($characters))];
		}
		return $randstring;
	}

	static public function getUrlOfImage($html) {
		$dom = new DOMDocument;
		$dom->loadHTML($html);
		$el = $dom->getElementById('image');
		var_dump($el);
		exit;
		$xpath = new DOMXPath($dom);
		$els = $xpath->query('//img[@class="image"]');
		$el = $els->item(0);
		return $el->getAttribute('src');
	}

}
