<?php
    class Geonames
    {
        protected $username;

        public function  __construct($username) {
            $this->username =  $username;
        }

        public function  getPlaceName($lat, $lng) {
            $url =  sprintf(
                "http://api.geonames.org/findNearbyPlaceNameJSON?lat=%f&lng=%f&username=%s",
                $lat, $lng, $this->username);
            $response = file_get_contents($url);
            if ($response === false) {
                throw new Exception("Failure to obtain data");
            }

            $places = json_decode($response);
            if (!$places) {
                throw new Exception("Invalid JSON response");
            }

            if(is_array($places->geonames) && count($places->geonames)) {
                return $places->geonames[0]->name;
            }
            else {
                return "Unknown";
            }

       }
    }