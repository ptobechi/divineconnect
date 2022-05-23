<?php

require "logisticsModel.php";
$obj = new Logistics();

if($_POST["action"] == "register"){
    $shipping_method = $_POST["shipping_method"];
    $order_date = $_POST["order_date"];
    $s_name = $_POST["s_name"];
    $r_name = $_POST["r_name"];
    $s_email = $_POST["s_email"];
    $r_email = $_POST["r_email"];
    $s_pnumber = $_POST["s_pnumber"];
    $r_pnumber = $_POST["r_pnumber"];
    $city = $_POST["city"];
    $postcode = $_POST["postcode"];
    $state = $_POST["state"];
    $billing_order_country = $_POST["billing_order_country"];

    $obj->registerLogistics($shipping_method, $order_date, $s_name, $r_name, $s_email, $r_email, $s_pnumber, $r_pnumber, $city, $postcode, $state, $billing_order_country);
        
}

if($_POST["action"] == "fetch"){
    
    $tracking_id = $_POST["tracking_id"];

    $obj->getPackage($tracking_id);
}

if($_POST["action"] == "fetch_all"){
    
    $obj->getAllRegisteredPackage();
}


?>