<?php

class Crawler {

	const CODE_LENGTH = 4;
	const IMAGE_TAG_ID = 'screenshot-image';
	const TARGET_URL = 'http://prntscr.com/92';
	const REMOVED_IMAGE_URL = 'http://i.imgur.com/8tdUI8N.png';
	
	private $headers = array(
			'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Host:prntscr.com',
			'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36',
		);

	public function run() {		
		for($i=0;$i<500;$i++){
			$html = $this->getWebResponse();
			while(!$this->isValidImage($html)){
				$html = $this->getWebResponse();
//				echo 'NOT FOUND' . PHP_EOL;
			}			
			$imgUrl = $this->getUrlImage($html);
			echo $imgUrl . PHP_EOL;
			$path = './screens/' . Utils::randomString() . '.jpg';
			Utils::download($imgUrl, $path);
			if(filesize($path) == 0)
				unlink($path);
		}
	}
	
	private function isValidImage($html) {
		if(strpos($html, self::REMOVED_IMAGE_URL) === false && strpos($html, 'http://i.imgur.com/') !== false){
			return true;
		}
		return false;
	}
	
	private function getWebResponse() {
		$code = Utils::randomString(self::CODE_LENGTH);
		return Utils::curl(self::TARGET_URL . $code, $this->headers);
		return Utils::curl('http://prntscr.com/92af12', $this->headers);
	}
	
	private function getUrlImage($html){
		$start = strpos($html, 'http://i.imgur.com/');
		$part = substr($html, $start);
		$end = strpos($part, '"');
		return substr($part, 0, $end);
	}

}
