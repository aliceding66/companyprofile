<?php 
    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   
    $tablename_details = "company_profile";
    $tablename_reviews = "company_profile_reviews";
    $tablename_news    = "company_profile_news";
    $tablename         = "company_profile_short";
    
    if($_POST && isset($_POST['deletecpid'])){
        
        $sql_delete_reviews = "DELETE FROM ".$tablename_reviews." WHERE company_id=".intval($_POST['deletecpid']);
        $result_cp_reviews  = $conn->query($sql_delete_reviews);
        
        $sql_delete_news    = "DELETE FROM ".$tablename_news." WHERE company_id=".intval($_POST['deletecpid']);
        $result_cp_news     = $conn->query($sql_delete_news);
        
        $sql_get_cp_no      = "SELECT * FROM ".$tablename." WHERE company_id=".intval($_POST['deletecpid']);
        $result_cp_no       = $conn->query($sql_get_cp_no);

        if ($result_cp_no->num_rows > 0) {

            while($row = $result_cp_no->fetch_assoc()) {
                $company_name     = $row["name"];
                $writefoldername  = $_SERVER['DOCUMENT_ROOT']."/brands/".$company_name;
                $writefilename    = $writefoldername."/index.php";

                if (file_exists($writefoldername)) {	
                    unlink($writefilename);
                    rmdir($writefoldername);
                }
            }
            
        }
        
        $cp_sql_delete_details  = "DELETE FROM ".$tablename_details." WHERE company_id=".intval($_POST['deletecpid']);
        $cp_sql_delete          = "DELETE FROM ".$tablename." WHERE company_id=".intval($_POST['deletecpid']);
        $cp_result              = $conn->query($cp_sql_delete);
        $cp_result              = $conn->query($cp_sql_delete_details);
        
    }
    
    if($_POST && isset($_POST['psearch'])){
        $cp_sql = "SELECT * FROM ".$tablename." WHERE name LIKE '%".$search_string."%'";
    }
    elseif (isset($_GET['psearch'])){
        $cp_sql = "SELECT * FROM ".$tablename." WHERE name LIKE '%".$search_string."%'";
    }
    else{
        $cp_sql = "SELECT * FROM ".$tablename;
    }

    $cp_result     = $conn->query($cp_sql);
    $page_numbers  = $cp_result->num_rows;
    $pnumber       = 250;
    $pcount        = 1;

    if($_POST && isset($_POST['psearch'])){
        $current_page = 1;
    }
    else{
        $current_page = intval($_GET['pnumber']);
    }
    
    if (isset($_GET['pnumber'])){}
    else {
        $current_page = 1;
    }

    echo "<style>table {font-size:18px;} td {border: solid 1px black;padding: 10px;}</style>";

    echo '<div style="margin-left: 10px;">';
        for ($y = 0; $y < $page_numbers; $y+=$pnumber) {
            $pp = intval($y/$pnumber + 1);
            if ($pp == $current_page){
                if($_POST && isset($_POST['psearch'])){
                    echo '<a href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage&psearch='.$_POST['psearch'].'&pnumber='.$pp.'"><span>'.strval(intval($y/$pnumber + 1)).'</span></a>&nbsp;';
                }
                elseif (isset($_GET['psearch'])){
                    echo '<a href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage&psearch='.$_GET['psearch'].'&pnumber='.$pp.'"><span>'.strval(intval($y/$pnumber + 1)).'</span></a>&nbsp;';
                }
                else{
                    echo '<a href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage&pnumber='.$pp.'"><span>'.strval(intval($y/$pnumber + 1)).'</span></a>&nbsp;';
                }
            }else {
                    if($_POST && isset($_POST['psearch'])){
                    echo '<a style="color:black;" href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage&psearch='.$_POST['psearch'].'&pnumber='.$pp.'"><span>'.strval(intval($y/$pnumber + 1)).'</span></a>&nbsp;';
                    }
                    elseif (isset($_GET['psearch'])){
                        echo '<a style="color:black;" href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage&psearch='.$_GET['psearch'].'&pnumber='.$pp.'"><span>'.strval(intval($y/$pnumber + 1)).'</span></a>&nbsp;';
                    }
                    else {
                        echo '<a style="color:black;" href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage&pnumber='.$pp.'"><span>'.strval(intval($y/$pnumber + 1)).'</span></a>&nbsp;';
                    } 
                }
        }
    echo '</div><br>';
    
    if ($cp_result->num_rows > 0) {
        
        echo "<table><tr><td>Manufacturer Name</td><td>Location</td><td></td><td></td></tr>";
            
            while($cp_row = $cp_result->fetch_assoc()) {
                if ((intval(($pcount-1)/$pnumber)+1) == $current_page){
                
                    echo "<tr>";
                    echo "<td>" . $cp_row["name"]."</td>";
                    echo "<td>" . $cp_row["region"]."</td>";
                    echo '<td><a href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustomsubpage&company_id='.$cp_row["company_id"].'">Edit</a></td>';
                    $cp_row["name"] = str_replace(',','',$cp_row["name"]);
                    $cp_row["name"] = str_replace(' ','-',$cp_row["name"]);
                    echo '<td><a href="https://shop.solarfeeds.com/brands/'.preg_replace("/[^A-Za-z0-9-]/", '', $cp_row["name"]).'" target=”_blank”>View Page</a></td>';
                    echo "</tr>";
                }

                $pcount = $pcount + 1;
            }
        echo "</table><br>";

        echo '<div style="margin-left: 10px;">';
            for ($x = 0; $x < $page_numbers; $x+=$pnumber) {
                $p = intval($x/$pnumber + 1);
                if ($p == $current_page){
                    echo '<a href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage&pnumber='.$p.'"><span>'.strval(intval($x/$pnumber + 1)).'</span></a>&nbsp;';
                } 
                else {
                    echo '<a style="color:black;" href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage&pnumber='.$p.'"><span>'.strval(intval($x/$pnumber + 1)).'</span></a>&nbsp;';
                }     
            }
        echo '</div>';
    }
    else {
        echo "0 results";
    }
    
    $conn->close();

?>