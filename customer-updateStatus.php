<?php
include_once('csv-import.php');
////////////////////////////////////
//Variables from csv-import.php : //
//$arr_upload_file                //
////////////////////////////////////

//<-- Begin Process Update Customer List-->//
        //Check If Array format is correct
        echo "<b>List of data in {$_SESSION['uploadFileName']} : </b><br>";
        
        $result_arr_customer_update = array();
        foreach ($arr_upload_file as $row_customer_update){
        //1. Array must have accno, co_name, status key
            echo "<pre>";
            print_r($row_customer_update);
            echo "</pre><br>";
            $accno_check = array_key_exists('accno',$row_customer_update);
            $co_name_check = array_key_exists('co_name', $row_customer_update);
            $status_check = array_key_exists('status', $row_customer_update);
            if($accno_check && $co_name_check && $status_check){
                echo "accno, co_name, and status column exists<br>";
                $accno = $row_customer_update['accno'];
                $co_name = $row_customer_update['co_name'];
                $status = $row_customer_update['status'];
                //2. Array must contain value on said key
                if(($accno && $co_name && $status)!= ''){
                    echo "accno, co_name, and status has value<br>";
                    $rowValueCheck = 'ok';
                }else{
                    echo "one of the column has no value, please check<br>";
                    $rowValueCheck = 'no';
                    $detailMsg = 'found NULL / empty value in accno, co_name or status.';
                }
            }else{
                echo "one of the column is missing, please check<br>";
                $rowValueCheck = 'no';
                $detailMsg = 'cannot find accno, co_name, or status. Please check';
            }            
            
            
            //3. Update data to database
            if ($rowValueCheck == 'ok'){
                $readResult = readCustomer_byAccno($accno);
                if($readResult != 'no data'){
                    echo "Data exists, updating the data...<br>";
                    //3.a Check situational problems
                    $cid = $readResult['cid'];
                    $oldStatus = $readResult['status'];
                    //if old_status is the same as new_status
                    if($oldStatus == 'deleted'){
                        echo "\$oldStatus = deleted, cannot proceed<br>";
                        $detailMsg = "Customer already deleted.";
                    }elseif($status == $oldStatus){
                        echo "\$status is the same as \$oldStatus<br>";
                        $detailMsg = "old_status is the same as new_status";
                    }else{
                        $updateResult = updateCustomer($accno, $status);
                        $detailMsg = $updateResult;
                    }
                }else{
                    echo "Cannot find data with accno = $accno<br>";
                    $oldStatus = "";
                    $detailMsg = "Cannot find data with accno = $accno";
                }
                
            }else{
                $oldStatus = "";
                
            }
            $array_result = array('cid' => $cid, 'accno' => $accno, 'co_name' => $co_name,
                              'old_status' => $oldStatus, 'new_status' => $status,
                              'Detail' => $detailMsg
                            );
            $result_arr_customer_update[] = $array_result;
            $_SESSION['result_arr_customer_update'] = $result_arr_customer_update;
            echo "<pre style='background-color:green;color:white'>";
            print_r($result_arr_customer_update);
            echo "</pre><br>";
        }
                
        //<-- Enf Process Update Customer List-->//
        $_SESSION['updateMsg']='Finished Updating Customer Table';
        #header('location: index2.php');
        echo '<META HTTP-EQUIV="refresh" content="0;URL=index.php">'; //using META tags instead of headers because headers didn't work in PHP5.3
                      
        ?>
<?php
//collection of functions
function readCustomer_byAccno($accno){
    $qr = "SELECT * FROM customer_pst WHERE accno = '$accno'";
    $objSQL = new SQL($qr);
    $result = $objSQL->getResultOneRowArray();
    if(!empty($result)){
        $valResult = $result;
    }else{
        $valResult = 'no data';
    }
    return $valResult;
}

function updateCustomer($accno, $status){
    $qr = "UPDATE customer_pst "
            . "SET status = '$status' "
            . "WHERE accno = '$accno'";
    echo "updateCustomer function,<br> \$qr = $qr<br>";
    $objSQL = new SQL($qr);
    $result = $objSQL->getUpdate();
    echo "\$result = $result<br>";
    if ($result == 'updated'){
        $resMsg = "update succesful!";
    }else{
        $resMsg = "update failed";
    }
    return $resMsg;
}
?>