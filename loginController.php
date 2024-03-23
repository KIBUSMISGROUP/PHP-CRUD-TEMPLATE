<?php
// include the model in register file
include_once "MY_Model.php";


// get the user data
$condition = array(
    "email" => $_POST['email'],
    "password" => $_POST['password'],

);
// create object of  Model Class
$login=new MY_Model();


// store to db
$response=array();

if($login->getAllWhere("users",$condition)){
    $response=array(
        "status"=>0,
        "statusMessage"=>"Login  successfully",
    );

}
else{

    $response=array(
        "status"=>1,
        "statusMessage"=>"Wrong username / Password"
    ); 
}
echo json_encode($response);





?>