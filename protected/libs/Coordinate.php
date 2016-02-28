<?php
namespace app\libs;

class Coordinate{

	public $lat;

	public $lng;

	public $address;

	public function __construct($address){
		$this->address = $address;
		$this->getGeoCounty();
	}

	function getGeoCounty() {
		$url = 'http://maps.google.com/maps/api/geocode/json?address=' . urlencode($this->address) .'&sensor=false';
		$get     = file_get_contents($url);
		$geoData = json_decode($get);
		if(isset($geoData->results[0])) {
			$return = array();
			foreach($geoData->results[0]->geometry as $addressComponet) {
				if(isset($addressComponet->lat)){
					$this->lat = $addressComponet->lat;
				}
				if(isset($addressComponet->lng)){
					$this->lng = $addressComponet->lng;
				}
			}
		}
	}
}