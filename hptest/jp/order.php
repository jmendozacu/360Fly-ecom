<?php
        $host = "staging.www.360fly.com/index.php"; //our online shop url
        $client = new SoapClient("http://".$host."/api/soap/?wsdl"); //soap handle
        $apiuser= "prashant"; //webservice user login
        $apikey = "ahy!234"; //webservice user pass
        $action = "sales_order.list"; //an action to call later (loading Sales Order List)
        try { 

          $sess_id = $client->login($apiuser, $apikey); //we do login
		  $result = $client->call($sess_id, $action);
		 

        echo "<pre>"; print_r(json_encode($result));
        }
        catch (Exception $e) { //while an error has occured
            echo "==> Error: ".$e->getMessage(); //we print this
               exit(); 
        }
?>