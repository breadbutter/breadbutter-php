<?php

namespace BreadButter\API;

use \Exception as Exception;
use BreadButter\EventValidationTypes as EventValidationTypes;
/*
 *   BreadButter API Client
 */

class BreadButterClient {

    private $app_id;

    private $request;

    private $idpx_request;

    private $api_path = 'https://api.breadbutter.io/';
    private $app_secret;

    /*
     *  Configure API client with required settings
     *  $settins array will required the following keys
     *
     *  - api_key
     */

    const token = 'token';


    public function __construct($settings) {
        if (!isset($settings['app_id'])) {
            throw new Exception("'app_id' must be provided");
        }
        $this->app_id = $settings['app_id'];

        if (isset($settings['api_path'])) {
            if (substr($settings['api_path'], -1) != '/') {
                $settings['api_path'] .= '/';
            }
            $this->api_path = $settings['api_path'];
        }

        if (isset($settings['app_secret'])) {
            $this->app_secret = $settings['app_secret'];
        }
    }

    private function connection() {
        if (!$this->request) {
            $this->request = new Connection($this->api_path, $this->app_secret);
        }
        return $this->request;
    }

    private function idpx() {
        if (!$this->idpx_request) {
            $connection = $this->connection();
            $this->idpx_request = new IDPX($connection);
        }
        return $this->idpx_request;
    }

    public function updateEvent($event_id, $local_success, $tags) {
        if (empty($event_id)) {
            throw new Exception("'event_id' must be provided");
        }

        $data = array(
            'app_id' => $this->app_id
        );

        if (!empty($local_success)) {
            if (!in_array($local_success, EventValidationTypes::$eventValidationTypes)) {
                throw new Exception("'local_success' must be either Pass, Fail, or NotApplicable");
            }
            $data['local_success'] = $local_success;
        }

        if (!empty($tags)) {
            $data['tags'] = $tags;
        }

        return $this->idpx()->updateEvent($event_id, $data);
    }


    public function ping() {
        return $this->idpx()->ping($this->app_id);
    }


    public function getAuthentication($token) {
        return $this->idpx()->getAuthentication($this->app_id, $token);
    }

}