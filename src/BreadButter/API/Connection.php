<?php

namespace BreadButter\API;
use \Exception as Exception;
use BreadButter\API\Response as Response;

/*
 *  BreadButter API Client
 */

class Connection {
    private $api_url = 'https://api.logonlabs.com/';
    private $app_secret = false;

    private $curl;
    private $headers = array();
    private $extra_header = array();

    private $response = array();

    const JSON = 'application/json';
    const URLENCODED = 'application/x-www-form-urlencoded';

    public function __construct($api_path, $app_secret) {
        if ($api_path) {
            $this->api_url = $api_path;
        }
        if ($app_secret) {
            $this->app_secret = $app_secret;
        }
        $this->curl = curl_init();
//        curl_setopt($this->curl, CURLOPT_HEADERFUNCTION, array($this, 'parseHeader'));
        curl_setopt($this->curl, CURLOPT_WRITEFUNCTION, array($this, 'parseBody'));

    }

    private function parseHeader($curl, $response)
    {
        $this->response['header'] = $response;
        return;
    }

    private function parseBody($curl, $response)
    {
        $this->response['body'] = $response;
        return;
    }


    public function redirectUrl($url, $query = false) {
        if (is_array($query)) {
            $url = sprintf("%s?%s", $url, http_build_query($query));
        }
        header('Location: ' . $url);
        return true;
    }

    public function redirect($cmd, $query = false) {
        $url = $this->api_url . $cmd;
        if (is_array($query)) {
            $url = sprintf("%s?%s", $url, http_build_query($query));
        }
        header('Location: ' . $url);
        return true;
    }

    public function addExtraHeader($data) {
        $this->extra_header[] = $data['name'] . ': ' . $data['value'];
    }

    public function cleanExtraHeader() {
        $this->extra_header = array();
    }

    private function applyExtraHeaders() {
        foreach($this->extra_header as $value) {
            $this->headers[] = $value;
        }
    }

    private function handleHeaders() {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
    }

    public function post($cmd, $data = false) {
        $url = $this->api_url . $cmd;

        $this->initCall();
        $this->applyExtraHeaders();
        $this->addExtraHeader(array('name'=> 'Content-Type', 'value'=> self::JSON));
        $this->handleHeaders();

        //$post_string = json_encode($data);
        $post_string = http_build_query($data);
        // echo $post_string;
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_string);

        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curl, CURLOPT_POST, true);


        $this->sendRequest($url);

        $this->cleanExtraHeader();
        return $this->handleResponse($url, $data);
    }
    public function patch($cmd, $data = false) {
        $url = $this->api_url . $cmd;

        $this->initCall();
        $this->applyExtraHeaders();
        $this->addExtraHeader(array('name'=> 'Content-Type', 'value'=> self::URLENCODED));
        $this->handleHeaders();

//        $post_string = json_encode($data);
        $post_string = http_build_query($data);
        // echo $post_string;
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_string);

        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($this->curl, CURLOPT_POST, true);


        $this->sendRequest($url);

        $this->cleanExtraHeader();
        return $this->handleResponse($url, $data);
    }
    public function get($cmd, $query = false) {
        $url = $this->api_url . $cmd;

        $this->initCall();

        if (is_array($query)) {
            $url = sprintf("%s?%s", $url, http_build_query($query));
        }

//        echo $url;
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->curl, CURLOPT_HTTPGET, true);

        $this->sendRequest($url);

        return $this->handleResponse($url, http_build_query($query));
    }

    private function sendRequest($url) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_exec($this->curl);
    }

    private function handleResponse($url, $data) {
        $body = $this->response['body'];
        $status = $this->getStatus();
        $redirect = $this->getRedirect();

        try {
            $body = json_decode($body, true);
        } catch (Exception $e) {
            $body = $this->response['body'];
        }

        return array(
            'status' => $status,
            'request' => $data,
            'redirect' => $redirect,
            'body' => $body,
            'url' => $url
        );
    }

    public function getRedirect() {
        return curl_getinfo($this->curl, CURLINFO_REDIRECT_URL);
    }

    public function getStatus() {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    private function initCall() {
        $this->headers = array();
        $this->headers[] = 'Accept: ' . self::JSON;
        if ($this->app_secret) {
            $this->headers[] = 'x-app-secret: ' . $this->app_secret;
        }
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, false);
        curl_setopt($this->curl, CURLOPT_PUT, false);
        curl_setopt($this->curl, CURLOPT_HTTPGET, false);
    }
}