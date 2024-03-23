<?php
// include the model in register file
include_once "MY_Model.php";


// get the user data
$user_data = array(
    "email" => $_POST['email'],
    "password" => $_POST['password'],
    "address" => $_POST['address'],
    "address2" => $_POST['address2'],
    "city" => $_POST['city'],
    "state" => $_POST['state'],
    "zip" => $_POST['zip']
);
// create object of  Model Class
$register=new MY_Model();


// store to db
$response=array();
if($register->insert("users",$user_data )){
    $response=array(
        "status"=>0,
        "statusMessage"=>"User Inserted successfully"
    );

}
else{

    $response=array(
        "status"=>1,
        "statusMessage"=>"User not inserted"
    ); 
}
echo json_encode($response);





?>