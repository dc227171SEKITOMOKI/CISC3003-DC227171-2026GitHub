<?php
// Developer: SEKI TOMOKI (ID: dc227171)


function readCustomers($filename) {
    $customers = array();
    
    if (file_exists($filename)) {
        $file = fopen($filename, "r");
        
        while (($line = fgets($file)) !== false) {
            $data = explode(';', trim($line));
            
            if (count($data) >= 12) {
                $customers[$data[0]] = array(
                    'id'         => $data[0],
                    'firstName'  => $data[1],
                    'lastName'   => $data[2],
                    'email'      => $data[3],
                    'university' => $data[4],
                    'address'    => $data[5],
                    'city'       => $data[6],
                    'state'      => $data[7],
                    'country'    => $data[8],
                    'zip'        => $data[9],
                    'phone'      => $data[10],
                    'sales'      => $data[11]
                );
            }
        }
        fclose($file);
    }
    return $customers;
}


function readOrders($customer_id, $filename) {
    $orders = array();
    
    if (file_exists($filename)) {
        $file = fopen($filename, "r");
        
        while (($line = fgets($file)) !== false) {
            $data = explode(',', trim($line));
            
            if (count($data) >= 5 && $data[1] == $customer_id) {
                $orders[] = array(
                    'orderId'    => $data[0],
                    'customerId' => $data[1],
                    'isbn'       => $data[2],
                    'title'      => $data[3],
                    'category'   => $data[4]
                );
            }
        }
        fclose($file);
    }
    return $orders;
}
?>