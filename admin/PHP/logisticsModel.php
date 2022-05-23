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
                            <div class='col-12'>
                                <ul type='none'>
                                    <li class='left'><span class='text-primary' style='font-size:20px'>Tracking Id: </span>#DVNCONN-$row[orderid]</li>
                                    <li class='left'><span class='text-primary' style='font-size:20px'>Client: </span>$row[s_name]</li>
                                    <li class='left'><span class='text-primary' style='font-size:20px'>Carrier:</span> $method</li>
                                    <li class='left'>
                                        <h6 class='text-danger'>Current Status: $status</h6>
                                    </li>
                    
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
            echo "Invalid Tracking no.";
        }
    }

    public function getAllRegisteredPackage(){
        $sql = "SELECT * FROM logistics";
        $query = $this->connect()->query($sql);
        $num = $query->num_rows;;
        if($num > 0){
            while($row = $query->fetch_assoc()){
                if($row["package_status"] == "0"){
                    $status = "In transit";
                }elseif($row["package_status"] == "1"){
                    $status = "Ready for pick-up";
                }elseif ($row["package_status"] == "2") {
                    $status = "Awaiting Pickup"; 
                }elseif ($row["package_status"] == "3") {
                    $status = "Package Delivered and Cleared"; 
                }
                echo "
                    <tr>
                        <td class='ps-0'>
                            <a href='edit-shipment.html?id=$row[orderid]'
                                class='text-dark fw-bolder text-hover-primary mb-1 fs-6'>$row[orderid]</a>
                        </td>
                        <td>
                            <span class='text-dark fw-bolder d-block fs-6'>$row[s_name]</span>
                        </td>
                        <td>
                            <span class='text-dark fw-bolder d-block fs-6'>$row[date]</span>
                        </td>
                        <td>
                            <select class='form-select mb-2' data-control='select2'
                                data-hide-search='true' data-placeholder='Select an option'
                                name='shipping_metho' id='shipping_method'>
                                <option value='0'>$status</option>
                                <option value='1'>Ready for pick-up</option>
                                <option value='2'>Awaiting Pickup</option>
                                <option value='3'>Package Delivered and Cleared</option>
                            </select>
                        </td>
                        <td class='text-end'>
                            <a class='btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px'>
                                <span class='fa fa-check text-success'></span>
                            </a>
                        </td>
                    </tr>
                ";

            }
        }else{
            echo "No Package."; 
        }

    }
}