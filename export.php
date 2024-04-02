<?php 
require 'core/init.php';

$data = "
<table border=1>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total price</th>
                <th>Supplier Name</th>
                <th>Acadamic Year.</th>
                <th>Assign</th>
            </tr>";
                $id = $user_data['id'];
                $result = getAssets($con, $user_data["id"]);
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
                    $data.= "<td style='text-align: center'>" . $row["title"] . "</td>";
                    $data.= "<td style='text-align: center'>" . $row["category"] . '</td>';
                    $data.= '<td style="text-align: center">' . $row['quantity'] . '</td>';
                    $data.= '<td style="text-align: center">' .'Rs '. $row['price'] . '</td>';
                    $data.= '<td style="text-align: center">'.'Rs '.$row['quantity'] * $row['price'] . '</td>';
                    $data.= '<td style="text-align: center">' . $row['supplier_name'] . '</td>';
                    $data.= '<td style="text-align: center">' . $row['acadamic_year'] . '</td>';
                    $data.= '<td style="text-align: center">' . $row['assign'] . '</td>';
                    $data.= '</tr>';

                }
                $name="TJ - ".date("d-m-Y");
                
                header("Content-Type: application/xls");
                header("Content-Disposition: attachment; filename=$name.xls");

                echo $data;
?>