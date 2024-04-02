<?php 
require 'core/init.php';

$data = "
<table border=1>
            <tr>
                <th>Bill-No</th>
                <th>Supplier Name</th>
                <th>Date</th>
                <th>Items</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total price</th>
                <th>Assign</th>
            </tr>";

          
                $id = $user_data['id'];
                $result = getMaterials($con, $user_data["id"]);
                $i = 1;
                while($row = $result->fetch_assoc()) {
                    $data.= "<tr style='background-color:";
                    if ($i % 2 == 0) {
                        $data.= "#f2f2f2";
                    } else {
                        $data.= "white";
                    }
                    $i++;
                    $data.= "'>";
                    $data.= "<td style='text-align: center'>" . $row["bill_no"] . "</td>";
                    $data.= "<td style='text-align: center'>" . $row["supplier_name"] . '</td>';
                    $data.= '<td style="text-align: center">' . $row['transaction_date'] . '</td>';
                    $data.= '<td style="text-align: center">' . $row['item_names'] . '</td>'; // Corrected array key
                    $data.= '<td style="text-align: center">' . $row['quantity'] . '</td>'; // Assuming quantity is the correct column name
                    $data.= '<td style="text-align: center">' .'Rs '. $row['rates'] . '</td>'; // Assuming rate is the correct column name
                    $data.= '<td style="text-align: center">'.'Rs '.$row['quantity'] * $row['rates'] . '</td>'; 
                    $data.= '<td style="text-align: center">' . $row['Assign'] . '</td>'; // Make sure Assign is the correct column name
                    $data.= '</tr>';
                }

                $name="Materials - ".date("d-m-Y"); // Update the file name as desired
                
                header("Content-Type: application/xls");
                header("Content-Disposition: attachment; filename=$name.xls");

                echo $data;
?>
