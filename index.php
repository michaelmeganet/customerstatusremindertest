<?php
session_start();
//includes here
include 'header.php';

//DO CHECK POST DATA HERE//
if(isset($_POST['pickoption'])){
    $_SESSION['pickoption'] = $_POST['pickoption'];
}
if (isset($_POST['reset_click'])){    
    session_destroy();
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $_SERVER['PHP_SELF'] . '">';
    #header('Location: ' . $_SERVER['PHP_SELF']);
}
//Check if data is uploaded or not
if (isset($_SESSION['uploadMsg'])){
    #unset($_SESSION['showTable']);
    $uploadMsg = $_SESSION['uploadMsg'];
    unset($_SESSION['uploadMsg']);
}
//check if update process or not
if (isset($_SESSION['updateMsg'])){
    #unset($_SESSION['showTable']);
    $updateMsg = $_SESSION['updateMsg'];
    unset($_SESSION['updateMsg']);
}

if(isset($_POST['showUpdResultBtn'])){
    $arr_updateResult = $_SESSION['result_arr_customer_update'];
    unset($_SESSION['result_arr_customer_update']);
    #$showTable = TRUE;
}
if(isset($_POST['showUpdateTable'])){
    $showUpdateTable = $_POST['showUpdateTable'];
}
//END CHECK POST DATA HERE//
?>
<form action="" method="post">
    <input class="button button-green mt-12 pull-right" type = "submit" name="reset_click" id="reset_click" value = "reset form">
</form>
<?php
if (!isset($_SESSION['pickoption'])){
    ?>
    <form action="" method='post'>
        <select name='pickoption' id='pickoption'>
            <option value='optionUpdate'>Batch Update Customer</option>
            <option value='optionRemind'>Send Reminder</option>
        </select>
        <input type="submit" value="submit" name="submitOption" id="submitOption" />
    </form>
    <?php
}
?>
<?php
if (isset($_SESSION['pickoption'])){
    $pickoption = $_SESSION['pickoption'];
    if($pickoption == 'optionUpdate'){
        ?>
        <h1>UPDATE CUSTOMER STATUS</h1>
        <span><br></span>
        <div class="container">
            <?php
            if(isset($updateMsg)){
                ?>
                <div class='alert alert-success'>
                    <form action='' method='POST' id='showUpdResult'>
                        <?php echo $updateMsg; ?> 
                        <input type="submit" value="Show Results" name="showUpdResultBtn" id='showUpdResultBtn'/>
                        <input type='hidden' value='TRUE' name='showUpdateTable' id='showUpdateTable'/>
                    </form>
                </div>
                <?php
            }
            ?>
            <!--Upload File Form Area-->
            <form action='upload.php' method='POST' id='fileUpload' enctype="multipart/form-data">
                <?php
                if(isset($uploadMsg)){?>        
                <h4><span style='font-weight: bold' class="label label-info"><?php echo $uploadMsg; ?></span></h4>
                <?php            
                }else{?>
                <h4><span style='font-weight: bold' class="label label-default">Select CSV File to upload :</span></h4>   
                <?php    
                }
                ?>
                <span></span>
                <span style='width:10%'>Upload File:</span>
                <input type='file' name='fileUpload'/>
                <input type='submit' name='uploadBtn' value='Upload'/> 
            </form>
            <!--End Upload File Form Area-->
            <!--Import CSV Form Area-->
            <?php
            if (isset($uploadMsg)){
            ?>
                <form action='customer-updateStatus.php' method='POST' id='updateCustomer'>
                    Click Here to update Status Customer from Uploaded CSV<!--Put button next to this-->
                    <input type='submit' name='updateCustomer' value='Process'/>
                </form>
            <?php
            }
            ?>
            <!--End Import CSV Form Area-->
        </div>
        <br>
        <!--Show Table Area-->
        <div class="container"> 
        <?php
        if(isset($showUpdateTable)){
            include "update-result-table.php";//Calls table for results
        }
        ?>
        </div>
        <!--End Show Table Area-->
        <?php
    }
    elseif($pickoption == 'optionRemind'){
        ?>
        <h1>ISSUE REMINDER</h1>
        <span><br></span>
        <div class="container">
            <?php
            if(isset($updateMsg)){
                ?>
                <div class='alert alert-success'>
                    <form action='' method='POST' id='showReminderResult'>
                        <?php echo $reminderMsg; ?> 
                        <input type="submit" value="Show Results" name="showReminderBtn" id='showReminderBtn'/>
                        <input type='hidden' value='TRUE' name='showReminderTable' id='showReminderTable'/>
                    </form>
                </div>
                <?php
            }
            ?>
            <!--Upload File Form Area-->
            <form action='upload.php' method='POST' id='fileUpload' enctype="multipart/form-data">
                <?php
                if(isset($uploadMsg)){?>        
                <h4><span style='font-weight: bold' class="label label-info"><?php echo $uploadMsg; ?></span></h4>
                <?php            
                }else{?>
                <h4><span style='font-weight: bold' class="label label-default">Select CSV File to upload :</span></h4>   
                <?php    
                }
                ?>
                <span></span>
                <span style='width:10%'>Upload File:</span>
                <input type='file' name='fileUpload'/>
                <input type='submit' name='uploadBtn' value='Upload'/> 
            </form>
            <!--End Upload File Form Area-->
            <!--Import CSV Form Area-->
            <?php
            if (isset($uploadMsg)){
            ?>
                <form action='customer-processReminder.php' method='POST' id='processReminder'>
                    Click Here to Process Issue Reminder from CSV<!--Put button next to this-->
                    <input type='submit' name='processReminder' value='Process'/>
                </form>
            <?php
            }
            ?>
            <!--End Import CSV Form Area-->
        </div>
        <br>
        <!--Show Table Area-->
        <div class="container"> 
        <?php
        if(isset($showReminderTable)){
            include "issue-reminder.php";//Calls table for results
        }
        ?>
        </div>
        <!--End Show Table Area-->
        
        
        
        
        
        <!-- Begin show testReport area-->
        <form action='testPrint.php' method="POST" id='testPrint'>
            Insert name here (will be shown in the test report) : <input type="text" name='tempName' id='tempName'/>
            <input type='submit' name='submitPrint' id='submitPrint' value='Submit'/>
        </form>
        <!-- End show testReport area-->
        <?php
    }
}
?>
<!--- footer area --->
<?php

//include 'footer.php';
?>
<!-- end footer area -->