<?php

namespace BreadButter\API;


class IDPX {

    private $connection;

    private $options;

    const ROUTE_APP = 'apps';

    public function __construct($connection, $options = array()) {
        if (!$this->connection) {
            $this->connection = $connection;
        }
        $this->options = $options;
    }

    public function getAuthentication($app_id, $authentication_token, $data = array()) {;
        $cmd = self::ROUTE_APP . '/' . $app_id . '/authentications/' . $authentication_token;
        return $this->connection->get($cmd, $data);
    }
}