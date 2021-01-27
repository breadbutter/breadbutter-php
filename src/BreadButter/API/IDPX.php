<?php

namespace BreadButter\API;


class IDPX {

    private $connection;

    private $options;

    const ROUTE_PING = 'ping';
    const ROUTE_VALIDATE_LOCAL = 'events';
    const ROUTE_APP = 'apps';

    public function __construct($connection, $options = array()) {
        if (!$this->connection) {
            $this->connection = $connection;
        }
        $this->options = $options;
    }

    public function handleRedirect($response, $redirect = true) {
        if ($response['redirect'] && $redirect) {
            $this->connection->redirectUrl($response['redirect']);
        }
    }

    public function ping($app_id) {;
        $cmd = self::ROUTE_PING;
        return $this->connection->get($cmd , array(
            'app_id' => $app_id
        ));
    }

    public function updateEvent($event_id, $data) {
        $cmd = self::ROUTE_VALIDATE_LOCAL . '/' . $event_id;
        return $this->connection->patch($cmd, $data);
    }

    public function getAuthentication($app_id, $token, $data = array()) {;
        $cmd = self::ROUTE_APP . '/' . $app_id . '/authentications/' . $token;
        return $this->connection->get($cmd, $data);
    }
}