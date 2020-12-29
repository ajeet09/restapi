<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../objectClasses/user.php';
include_once '../Activities/userActivities.php';
 
$request = (array) json_decode(file_get_contents("php://input"), TRUE);

if(!empty($request)) {
        if( !empty($request['email']) && !empty($request['password']))
        {
            $data = convertRequstIntoObject($request);
            $obj = new UserActivities();
            $response = $obj->authenticate($data);
            if($response == 200){
                setResponse(200, "User Logged In Successfully");
            }  else if($response == 404){
                setResponse(404, "User EmailId / Password Not Valid");
            } else {
                setResponse(400,"Bad Request");
            }
        } else {
            setResponse(400,"Bad Request");
        }

} else{
    setResponse(400,"Bad Request");
}


function convertRequstIntoObject($req)
{
    $user = new User();
    $user->setEmail($req['email']);
    $user->setPassword($req['password']);
    return $user;
}

function setResponse(int $statusCode, string $message){
    http_response_code($statusCode);
    echo json_encode(array("message" => $message, "code" => $statusCode));
}