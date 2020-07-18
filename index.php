<?php
session_start();
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
if ($pageWasRefreshed) {
    unset($_SESSION['result_arr_issue_reminder']); //destroy cached issueReminder data
}
//includes here
include 'header.php';

//DO CHECK POST DATA HERE//
if (isset($_POST['pickoption'])) {
    $_SESSION['pickoption'] = $_POST['pickoption'];
}
if (isset($_POST['reset_click'])) {
    session_destroy();
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $_SERVER['PHP_SELF'] . '">';
    #header('Location: ' . $_SERVER['PHP_SELF']);
}
//Check if data is uploaded or not
if (isset($_SESSION['uploadMsg'])) {
    #unset($_SESSION['showTable']);
    $uploadMsg = $_SESSION['uploadMsg'];
    unset($_SESSION['uploadMsg']);
}

//---Update SESSION Checks--
//check if update process or not
if (isset($_SESSION['updateMsg'])) {
    #unset($_SESSION['showTable']);
    $updateMsg = $_SESSION['updateMsg'];
    unset($_SESSION['updateMsg']);
}

if (isset($_POST['showUpdResultBtn'])) {
    $arr_updateResult = $_SESSION['result_arr_customer_update'];
    unset($_SESSION['result_arr_customer_update']);
    #$showTable = TRUE;
}
if (isset($_POST['showUpdateTable'])) {
    $showUpdateTable = $_POST['showUpdateTable'];
}


//---Remind SESSION Checks--
if (isset($_SESSION['processRemindMsg'])) {
    $processRemindMsg = $_SESSION['processRemindMsg'];
    unset($_SESSION['processRemindMsg']);
}
if (isset($_SESSION['error_arr_issue_reminder'])) {
    $error_reminderResult = $_SESSION['error_arr_issue_reminder'];
    unset($_SESSION['error_arr_issue_reminder']);
}
#$_SESSION['result_arr_issue_reminder'] = $result_arr_issue_reminder;
//END CHECK POST DATA HERE//
?>
<form action="" method="post">
    <input class="button button-green mt-12 pull-right" type = "submit" name="reset_click" id="reset_click" value = "reset form">
</form>
<?php
if (!isset($_SESSION['pickoption'])) {
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
if (isset($_SESSION['pickoption'])) {
    $pickoption = $_SESSION['pickoption'];
    if ($pickoption == 'optionUpdate') {
        ?>
        <h1>UPDATE CUSTOMER STATUS</h1>
        <span><br></span>
        <div class="container">
        <?php
        if (isset($updateMsg)) {
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
        <?php if (isset($uploadMsg)) { ?>        
                    <h4><span style='font-weight: bold' class="label label-info"><?php echo $uploadMsg; ?></span></h4>
                    <?php } else {
                    ?>
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
        if (isset($uploadMsg)) {
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
        if (isset($showUpdateTable)) {
            include "update-result-table.php"; //Calls table for results
        }
        ?>
        </div>
        <!--End Show Table Area-->
            <?php
        } elseif ($pickoption == 'optionRemind') {
            ?>
        <h1>ISSUE REMINDER</h1>
        <span><br></span>
        <div class="container">
        <?php
        if (isset($processRemindMsg)) {
            ?>
                <div class='alert alert-success'>
                    <form action='testPrint.php' method='POST' id='showReminderResult' onsubmit="reminderPDF(this)">
                <?php echo $processRemindMsg; ?> 
                        <input type="submit" value="Issue Reminders" name="issueReminderBtn" id='issueReminderBtn'/>
                    </form>
                </div>
                        <?php
                    }
                    ?>
            <!--Upload File Form Area-->
            <form action='upload.php' method='POST' id='fileUpload' enctype="multipart/form-data">
            <?php if (isset($uploadMsg)) { ?>        
                    <h4><span style='font-weight: bold' class="label label-info"><?php echo $uploadMsg; ?></span></h4>
            <?php } else {
            ?>
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
        if (isset($uploadMsg)) {
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
        <!--Show Error List Table Area-->
        <div class="container"> 
        <?php
        if (isset($processRemindMsg)) {
            $countArr = count($error_reminderResult);
            echo " <h4><label class=\"label label-danger\">Found $countArr records that cannot be processed :</label></h4><br>";
            include "error-remind-table.php"; //Calls table for results
        }
        ?>
        </div>
        <!--End Show Error List Table Area-->





        <!-- Begin show testReport area--
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
</body>
<script>
    function reminderPDF(form) {
        window.open('testPrint.php', 'PDFreminder', 'width=800,height=600,resizeable,scrollbars');
        form.target = 'PDFreminder';
        //window.location.reload();
    }
</script>
<script>
    pickoption = document.getElementById('pickoption');
    submitoption = document.getElementById('submitOption');
    pickoption.addEventListener('change', function () {
        submitoption.click();
    })
</script>