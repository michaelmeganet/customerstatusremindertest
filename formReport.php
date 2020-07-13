<?php
if(isset($_SESSION['result_arr_issue_reminder'])){
    $count = 0;
    $arr_dataReminder = $_SESSION['result_arr_issue_reminder'];
    unset($_SESSION['result_arr_issue_reminder']);
    foreach($arr_dataReminder as $row_dataReminder){
        #echo "<pre>";
        #print_r($row_dataReminder);
        #echo "</pre>";
        extract($row_dataReminder, EXTR_PREFIX_ALL, 'dat');
        
        #$dat_co_name = $row_dataReminder['co_name'];
        #$dat_address1 = $row_dataReminder['address1'];
        #$dat_address2 = $row_dataReminder['address2'];
        #$dat_address3 = $row_dataReminder['address3'];
        #if($count == 0){
        #    echo "<div>";
        #}else{
        #    echo "<div style='page-break-before: always'>";
        #}
        ?>
        <div class="container">
            <?php
            if($count == 0){
                echo "<div>";
            }else{
                echo "<div style='page-break-before: always;max-width: 2480px; width:100%''>";
            }
            ?>
                <div style='margin-bottom: -20px;'>
                    <img src="./assets/images/phhlogoemail.png" alt="Cannot found image" width="300" height='28' style="display: block">
                </div>
                <div style="font-family: times-new-roman;margin: -2px 47px 0px 47px;">
                    <p style='font-size:12px'>
                        PHH METAL 1 SDN BHD (176257-T)</br>
                        Lot 2, Jalan CJ 1/6C, Kawasan Perusahaan Cheras Jaya, 43200, Selangor</br>
                        Tel: +603-9075 6800<span style='padding-right: 50px'>&nbsp;</span>Fax: +603-9075 6866</br>				
                    </p>
                    <p>Our Ref: <?php echo $dat_our_ref_no; ?></p>
                    <p><?php echo $dat_issue_date;?></p>
                    <p><strong><?php echo $dat_co_name;?> </strong> <br />
                        <?php echo $dat_address1;?> <br />
                        <?php echo $dat_address2;?><br />
                        <?php echo $dat_address3;?></p>
                    <p>Dear Sir/Madam</p>
                    <p><span style="text-decoration: underline;"><strong>RE: OVERDUE ACCOUNT- RM <?php echo number_format($dat_overdue_amount,2, '.', ',');?></strong></span></p>
                    <p style="text-align: justify;">We refer to the above subject matter.</p>
                    <p style="text-align: justify;">
                        We would like to bring to your attention that your account is <strong>OVERDUED</strong>. 
                        Please find the attached statement for your kind and needful action.
                    </p>
                    <p style="text-align: justify;">
                        Based on our records, your account has exceeded the approved credit terms of 60 Days&nbsp;
                        and the amount in arrears is <span style="text-decoration: underline;"><strong>RM <?php echo number_format($dat_overdue_amount,2, '.', ',');?></strong></span> 
                        (<strong>Ringgit Malaysia: <?php echo $dat_number_text_amount;?></strong>) 
                        as at <span style="text-decoration: underline;"><strong><?php echo $dat_due_date; ?></strong></span>.&nbsp;
                    </p>
                    <p style="text-align: justify;">
                        Please notify us of any discrepancies in our record within fourteen (14) days from the date of this letter. 
                        If we do not receive any feedback from you then the above overdue amount will be considered accurate and correct.
                    </p>
                    <p style="text-align: justify;">
                        We provide two options for you to settle the outstanding amount:-
                    </p>
                    <ol>
                        <li style="text-align: justify;"><span style="text-decoration: underline;">Credit Card Facility</span></li>
                        <li style="text-align: justify;"><span style="text-decoration: underline;">Installment Payment</span></li>
                    </ol>
                    <p>
                        Kindly arrange and remit the payment to us immediately. 
                        Fail to do so, we are determined to take the next course of recovery action by entering your name as a defaulter into&nbsp;
                        <strong>CTOS DATA SYSTEMS SDN BHD ('CTOS').</strong>
                    </p>
                    <p>
                        Please do not hesitate to contact the undersigned,&nbsp;
                        <strong><?php echo $dat_person_in_charge;?></strong> (Credit Control Department) should you need further clarification.
                    </p>
                    <p>Your kind co-operation on this matter will be deeply appreciated.</p>
                    <p>&nbsp;</p>
                    <p>Thank you,</p>
                    <p><strong>PHH METAL 1 SDN BHD</strong></p>
                    <p>This is a computer generated letter, no human signature is required.</p>
                </div>
            </div>
        </div>
        <?php
        echo '</div>';
        $count++;
    }
    
}else{
    echo "something is wrong";
}
?>
            
      

