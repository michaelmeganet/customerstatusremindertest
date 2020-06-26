<?php
session_start();
include_once 'class/variables.inc.php';
#include_once 'class/functions.inc.php';
?>

        <?php
        
        //<--Begin converting CSV to Array-->//
        if(isset($_SESSION['uploadFileName'])){
            $filename = './csv/'.$_SESSION['uploadFileName'];
        }else{
            die("no file is detected, click <a href='index.php'>here to return</a>");
        }
        #$filename = './csv/raw_purchase.csv';
        
        // create array to contain the data
        $arr_upload_file = array();

        // Open the file for reading
        if (($h = fopen("{$filename}", "r"))) {
            //make a header value for the keys
            $raw_header = fgetcsv($h);
            //replace all space with underscores, this is to make it the same as database
            $arr_header = str_replace(' ', '_', $raw_header);
            // move data from csv into $data array, comma separated
            while (($data = fgetcsv($h, 1000, ","))) {
                // Each individual array is being pushed into the nested array
                $arr_upload_file[] = array_combine($arr_header, $data);
            }

            // Close the file
            fclose($h);
        }
        //<-- End converting CSV to Array-->//
        //echo '<META HTTP-EQUIV="refresh" content="0;URL=index.php">'; //using META tags instead of headers because headers didn't work in PHP5.3
        