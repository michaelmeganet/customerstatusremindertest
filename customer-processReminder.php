<?php
include_once('csv-import.php');
////////////////////////////////////
//Variables from csv-import.php : //
//$arr_upload_file                //
////////////////////////////////////
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

function keyCheck($inputArray){
    $arr_KeyCheck = array('cid','accno','co_name','current_status','reminder','our_ref_no','overdue_amount','number_text_amount','due_date','person_in_charge');
    foreach ($arr_KeyCheck as $keyVal){
        $chkResult = array_key_exists($keyVal, $inputArray);
        if (!$chkResult){
            throw new Exception("Error Input, Cannot find column for $keyVal.");
        }
    }
    return "Key OK";
}

function valueCheck($inputArray){
    foreach ($inputArray as $key => $val){
        if ($key != 'reminder'){
            if ($val == ''){
                throw new Exception("Error Input, Cannot find Value for $key.");
            }
        }
    }
    return "Value OK";
}

//<-- Begin Process Update Customer List-->//
    echo "<b>List of data in {$_SESSION['uploadFileName']} : </b><br>";
    $result_arr_issue_reminder = array();
    $error_arr_issue_reminder = array();
    
    
    foreach($arr_upload_file as $row_reminder){
        try {
        
            echo "<pre>";
            print_r($row_reminder);
            echo "</pre><br>"; 
            $accno = $row_reminder['accno'];
            $cid = $row_reminder['cid'];
            $co_name = $row_reminder['co_name'];
            $current_status = $row_reminder['current_status'];
            $reminder = $row_reminder['reminder'];

            //check if all key exists
            $result_checkKey = keyCheck($row_reminder);
            //check if value is empty or not
            $result_checkVal = valueCheck($row_reminder);
            
            //get necessary datas from database
            echo "\$result_checkKey = $result_checkKey and \$result_checkVal = $result_checkVal<br>";
            if ($result_checkKey == 'Key OK' && $result_checkVal == 'Value OK'){
                
                $our_ref_no = $row_reminder['our_ref_no'];
                $overdue_amount = $row_reminder['overdue_amount'];
                $number_text_amount = $row_reminder['number_text_amount'];
                $issue_date = date('F d, Y');
                $due_date = $row_reminder['due_date'];
                $person_in_charge = $row_reminder['person_in_charge'];
                
                $readResult = readCustomer_byAccno($accno);
                if($readResult != 'no data'){
                    echo "Data exists, process Reminder...<br>";
                    //3.a Check situational problems
                    $cid = $readResult['cid'];
                    $address1 = $readResult['address1'];
                    $address2 = $readResult['address2'];
                    $address3 = $readResult['address3'];
                    $attn_sales = $readResult['attn_sales'];
                    //check if reminder == yes
                    if($reminder == 'yes'){
                        echo "process reminder<br>";
                        $errCheck = 'no';
                        $arr_reminder_result = array('cid' => $cid, 'accno' => $accno, 'co_name' => $co_name,
                                                        'address1' => $address1, 'address2' => $address2,
                                                        'address3' => $address3, 'attn_sales' => $attn_sales,
                                                        'our_ref_no' => $our_ref_no, 'issue_date' => $issue_date,
                                                        'overdue_amount' => $overdue_amount, 'number_text_amount' => $number_text_amount,
                                                        'due_date' => $due_date, 'person_in_charge' => $person_in_charge
                                                      );
                        $result_arr_issue_reminder[] = $arr_reminder_result;
                    }else{
                        echo "reminder is not yes<br>";
                        Throw new Exception("Reminder do not Issue");
                    }
                    
                }else{
                    echo "cannot find data with accno<br>";
                    Throw new Exception("Cannot find Data for $accno / $co_name");
                }
            }
            
        } catch (Exception $e) {
            $errMessage = $e->getMessage();
            echo "$errMessage<br>";
            $error_result = array('cid' => $cid, 'accno' => $accno, 'co_name' => $co_name,
                                'current_status' => $current_status, 'Detail' => $errMessage
                              );
            $error_arr_issue_reminder[] = $error_result;
        }   
    }
    $_SESSION['result_arr_issue_reminder'] = $result_arr_issue_reminder;
    $resultCount = count($result_arr_issue_reminder);
    $_SESSION['error_arr_issue_reminder'] = $error_arr_issue_reminder;
    //<-- Enf Process Update Customer List-->//
    $_SESSION['processRemindMsg']="Succesfully processed {$resultCount} records.";
    #header('location: index2.php');
    #echo '<META HTTP-EQUIV="refresh" content="0;URL=index.php">'; //using META tags instead of headers because headers didn't work in PHP5.3
                      
/*

        //Check If Array format is correct
        
            //1. array must have accno, co_name, current_status key
           
            $accno_check = array_key_exists('accno',$row_reminder);
            $co_name_check = array_key_exists('co_name',$row_reminder);
            $current_status_check = array_key_exists('current_status',$row_reminder);
            if(($accno_check && $co_name_check && $current_status_check)){
                echo "accno, co_name, and current_status column exists<br>";
                $accno = $row_reminder['accno'];
                $co_name = $row_reminder['co_name'];
                $current_status = $row_reminder['current_status'];
                $reminder = $row_reminder['reminder'];
                //2. Array must contain value on said key
                if(($accno && $co_name && $current_status)!= ''){
                    echo "accno, co_name, and current_status has value<br>";
                    $rowValueCheck = 'ok';
                }else{
                    echo "one of the column has no value, please check<br>";
                    $rowValueCheck = 'no';
                    $detailMsg = 'found NULL / empty value in accno, co_name or current_status.';
                }
            }else{
                echo "one of the column is missing, please check<br>";
                $rowValueCheck = 'no';
                $detailMsg = 'cannot find accno, co_name, or current_status. Please check';
            }    
                
            //3. Update data to database
            if ($rowValueCheck == 'ok'){
                $readResult = readCustomer_byAccno($accno);
                if($readResult != 'no data'){
                    echo "Data exists, process Reminder...<br>";
                    //3.a Check situational problems
                    $cid = $readResult['cid'];
                    $address1 = $readResult['address1'];
                    $address2 = $readResult['address2'];
                    $address3 = $readResult['address3'];
                    $attn_sales = $readResult['attn_sales'];
                    //check if reminder == yes
                    if($reminder == 'yes'){
                        $errCheck = 'no';
                        $arr_reminder_result = array('cid' => $cid, 'accno' => $accno, 'co_name' => $co_name,
                                                        'address1' => $address1, 'address2' => $address2,
                                                        'address3' => $address3, 'attn_sales' => $attn_sales
                                                      );
                    }else{
                        $errCheck = 'yes';
                        echo "Don't Process Reminder";
                        $detailMsg = "Reminder do not issue";
                        $error_result = array('cid' => $cid, 'accno' => $accno, 'co_name' => $co_name,
                                                        'current_status' => $current_status, 'Detail' => $detailMsg
                                                      );
                    }
                    
                }else{
                    $errCheck = 'yes';
                    echo "Cannot find data with accno = $accno<br>";
                    $detailMsg = "Cannot find data with accno = $accno";
                    $error_result = array('cid' => $cid, 'accno' => $accno, 'co_name' => $co_name,
                                                        'current_status' => $current_status, 'Detail' => $detailMsg
                                                      );
                }
                
            }else{
                $errCheck = 'yes';
                $error_result = array('cid' => $cid, 'accno' => $accno, 'co_name' => $co_name,
                                                        'current_status' => $current_status, 'Detail' => $detailMsg
                                                      );
            }
            if($errCheck == 'no'){
                $result_arr_issue_reminder[] = $arr_reminder_result;
            }else{
                $error_arr_issue_reminder[] = $error_result;
            }
       
        $_SESSION['result_arr_issue_reminder'] = $result_arr_issue_reminder;
        $resultCount = count($result_arr_issue_reminder);
        $_SESSION['error_arr_issue_reminder'] = $error_arr_issue_reminder;
        //<-- Enf Process Update Customer List-->//
        $_SESSION['processRemindMsg']="Succesfully processed {$resultCount} records.";
        #header('location: index2.php');
        #echo '<META HTTP-EQUIV="refresh" content="0;URL=index.php">'; //using META tags instead of headers because headers didn't work in PHP5.3
                      
        ?>
 * 
 */
