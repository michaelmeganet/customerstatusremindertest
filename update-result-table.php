
<table class="table">
    <thead>
        <tr style='background-color: black;color: white;'>
            <th>cid</th>
            <th>accno</th>
            <th>co_name</th>
            <th>old_status</th>
            <th>new_status</th>
            <th>detail</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($arr_updateResult as $row_updateResult){
            if($row_updateResult['Detail'] == 'update succesful!'){
                echo '<tr class="success">';
            }elseif($row_updateResult['Detail'] == 'Customer already deleted.'){
                echo '<tr class="warning">';
            }elseif($row_updateResult['Detail'] == 'old_status is the same as new_status'){
                echo '<tr class="warning">';                
            }else{
                echo "<tr class='danger'>";
            }
            foreach($row_updateResult as $key => $val){
                echo "<td>$val</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
