<?php

include_once '../objectClasses/user.php';
include_once '../Activities/userActivities.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$requestType = $_SERVER['REQUEST_METHOD']; 

if ($requestType === 'OPTIONS') {
     setResponse(200, "Success");
}

$request = (array) json_decode(file_get_contents("php://input"), TRUE);

if($requestType === 'POST') {
        if( !empty($request['email']) && !empty($request['password']))
        {
            $data = convertRequstIntoObject($request);
            $obj = new UserActivities();
            $response = $obj->authenticate($data);
            if($response['status'] == 200){
                setResponse(200, "User Logged In Successfully", $response['key']);
            }  else if($response['status'] == 404){
                setResponse(404, "User EmailId / Password Not Valid");
            } else if($response['status'] == 400) {
                setResponse(400,"Bad Request");
            }
        } else {
            setResponse(400,"Bad Request");
        }
} else{
    setResponse(400,"Bad Request Type");
}


function convertRequstIntoObject($req)
{
    $user = new User();
    $user->setEmail($req['email']);
    $user->setPassword($req['password']);
    return $user;
}

function setResponse(int $statusCode, string $message, string $data = ""){
    http_response_code($statusCode);
    echo json_encode(array("message" => $message, "code" => $statusCode, 'data' => $data));
}
