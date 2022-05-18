<?php

require "../config/connection.php";


class Logistics extends Database{

    public function registerLogistics($shipping_method, $order_date, $s_name, $r_name, $s_email, $r_email, $s_pnumber, $r_pnumber, $city, $postcode, $state, $billing_order_country){
        $this->shipping_method = $shipping_method;
        $this->order_date = $order_date;
        $this->s_name = $s_name;
        $this->r_name = $r_name;
        $this->s_email = $s_email;
        $this->r_email = $r_email;
        $this->s_pnumber = $s_pnumber;
        $this->r_pnumber = $r_pnumber;
        $this->city = $city;
        $this->postcode = $postcode;
        $this->state = $state;
        $this->billing_order_country = $billing_order_country;

        $this->CreateDataTables();

        $orderid = $this->IdGenerator("logistics", "orderid");

        $sql = "INSERT INTO logistics SET orderid='$orderid', s_name='$s_name', s_email='$s_email', r_name='$r_name', r_email='$r_email', s_phone='$s_pnumber', r_phone='$r_pnumber', city='$city', postcode='$postcode', state='$state', country='$billing_order_country', shipping_method='$shipping_method', package_status='0', delivery_date='$order_date', date=NOW()  ";
        $query = $this->connect()->query($sql);
        if($query){
            echo "201";
        }else{
            echo "401";
        }

    }

    public function getPackage($tracking_id){
        $this->tracking_id = $tracking_id;

        $sql = "SELECT * FROM logistics WHERE orderid='$tracking_id' ";
        $query = $this->connect()->query($sql);
        $num = $query->num_rows;
        if($num > 0){
            while($row = $query->fetch_assoc()){

                if($row["shipping_method"] == "sea"){
                    $method = "Sea Freight";
                }elseif($row["shipping_method"] == "land"){
                    $method = "Land Freight";
                }elseif ($row["shipping_method"] == "air") {
                    $method = "Air Freight";                
                }

                if($row["package_status"] == "0"){
                    $status = "In-transit";
                }elseif($row["package_status"] == "1"){
                    $status = "Ready for pickup @ our office";
                }elseif ($row["package_status"] == "2") {
                    $status = "Awaiting pick up";
                }

                echo "
                    <div class='container'>
                        <div class='row'>
                            <div class='col-6'>
                                <ul type='none'>
                                    <li class='left'>Tracking Id:</li>
                                    <li class='left'>Client:</li>
                                    <li class='left'>Carrier:</li>
                                    <li class='left'>
                                        <h6>Current Status</h6>
                                    </li>
                    
                                </ul>
                            </div>
                            <div class='col-6'>
                                <ul class='right' type='none'>
                                    <li class='right'>#DVNCONN-$row[orderid]</li>
                                    <li class='right'>$row[s_name]</li>
                                    <li class='right'>$row[orderid]</li>
                                    <li class='right'>$method</li>
                                    <li class='right'>$status</li>
                                </ul>
                            </div>
                        </div>
                        <hr />
                    
                        <div class='row' style='border-bottom: none'>
                            <div class='col-6'>
                                <ul class='right' type='none'>
                                    <li class='left'>Estimated arrival</li>
                                </ul>
                            </div>
                            <div class='col-6'>
                                <ul class='right' type='none'>
                                    <li class='right'>25-03-2020</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                ";
            }
        }else{
            echo "404";
        }
    }
}