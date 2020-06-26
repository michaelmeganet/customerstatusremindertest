
<table class="table">
    <thead>
        <tr style='background-color: black;color: white;'>
            <th>cid</th>
            <th>accno</th>
            <th>co_name</th>
            <th>current_status</th>
            <th>detail</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($error_reminderResult as $row_reminderResult){
            echo "<tr>";
            foreach($row_reminderResult as $key => $val){
                echo "<td>$val</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
