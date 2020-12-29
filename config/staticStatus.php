<?php 

class staticStatus {

    public $status = array();
    public $appPath = "/var/www/html/restapi/";

    public function getStatus() 
    {
        $this->status['BAD'] = 400;
        $this->status['SUCCESS'] = 200;
        $this->status['INTERNAL_SERVER_ERROR'] = 500;
        $this->status['CONFLICT'] = 309;
        $this->status['FORBIDDEN'] = 403;
        $this->status['NOT_FOUND'] = 404;
        return $this->status;
    }

    public function getAppPath(){
        return $appPath;
    }


}