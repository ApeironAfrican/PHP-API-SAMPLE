<?php

require_once("class.rest.php");
//Connect to the database for processing of the sent data
require 'connect.php';

class API extends REST {

    public function __construct() {
        parent::__construct();
    }

	public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['action'])));
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else
            $this->response('', 404);
    }

	private function refer() {

        if ($this->get_request_method() != "POST") {
            $this->response($this->json(array('status' => 'false', 'message' => 'method not allowed.')), 405);
        }

        if (isset($this->_request['email'])) {

            $member_id = $this->_request['email'];
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $email_address = $email;
                if ($q > 0) {
                    $res = array('status' => 'true', 'message' => 'user email successfully logged in.','name' => $name, 'email' => $email);
                    $this->response($this->json($res), 200);
                }
            }
        }

        $error = array('status' => 'false', 'message' => 'Invalid email or password');
        $this->response($this->json($error), 200);
    }
	
    private function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

}

$api = new API;
$api->processApi();