
<?php 

require_once('/srv/htdocs/wp-load.php'); 
get_header();
ini_set("default_charset", "UTF-8");


?>
<style>
	.primaryblock{
		width:100%;
	}
	.secondaryblock{
		width:100%;
	}
	.d-30{
		width: 30%;
    	float: left;
	}
	.d-40{
		width: 40%;
    	float: left;
	}
	.d-50{
		width: 50%;
    	float: left;
	}
	.d-70{
		width: 70%;
    	float: left;
	}
	.secondaryblock{
		width:100%;
	}
	.listsummary{
		display: inline-block;
	}
	.whiteblock {
    	border: solid 1px grey;
    	padding: 10px;
    	margin-bottom: 20px;
		display: block;
		overflow: hidden;
	}
	.btn_quote{
		background: #0581c7;
    	color: white;
    	padding: 10px;
	}
	.btn_quote:hover{
		background: white !important;
    	color: #0581c7 !important;
    	padding: 10px;
	}
	table, th, td {
    	border: none !important;
	}
	.sticky-header.admin-bar .site-header.minimized .header-main {
    	top: 0px !important;
	}
	.site-content {
    	padding-top: 10px !important;
    	padding-bottom: 0px !important;
	}
	.page-header-default .page-breadcrumbs {
    	background-color: #f1f1f1;
    	display: none;
	}
	@media only screen and (max-width: 768px) {
		.primaryblock {
			width: auto;
			display: block;
			overflow: hidden;
			margin-left: 15px;
			margin-right: 15px;
		}
  		.d-30 {
    		width:100% !important;
  		}
  		.d-70 {
    		width:100% !important;
  		}
		.row h1 {
			margin-left: 15px;
			margin-right: 15px;
		}
	}
</style>
<?php

	 $cou = $_GET['countries'];
	 $cat = $_GET['product_cat'];
	 $subcat = $_GET['product_subcat'];
	 $ifoem = $_GET['oem'];
	 $current_page = $_GET['p']; 

	 if (isset($current_page)) {

	 }
	 else {
	 	 $current_page = 1;
	 }

	 $cat_updated = str_replace('_',' ',$cat);
	 //var_dump($cou);
	 //var_dump($cat);
	 //var_dump($subcat);
	 //var_dump($ifoem);

?>


<?php 
if ((isset($cat)) && ($cat!="")){
	if ((isset($cou)) && ($cou!="")){
		?> <h1>[<?php echo $cat_updated; ?>] Manufacturers in [<?php echo $cou; ?>]</h1> <?php
	}
	else{
		?> <h1>[<?php echo $cat_updated; ?>] Manufacturers</h1> <?php
	}
}
else{
	if ((isset($cou)) && ($cou!="")){
		?> <h1>Manufacturers in [<?php echo $cou; ?>]</h1> <?php
	}
	else{
		?> <h1>Manufacturers</h1> <?php
	}
	
}
?>




<div class="primaryblock">
	<aside class="d-30 filterbar">
		<form action="">
  			<label for="countries"><span style="color:red;">*</span>Choose a factory location:</label>
  			<select name="countries" id="countries">
  				<?php
  					
  					// Create connection
    				$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   					mysqli_set_charset($conn, "utf8");
    				$tablename_details = "company_profile";
    				$tablename         = "company_profile_short";
    				$tablename_filter   = "company_profile_filter";
    				$sql_countries      = "SELECT DISTINCT region FROM ".$tablename." ORDER BY region";
        			$result_countries       = $conn->query($sql_countries);

  					if ($result_countries->num_rows > 0) {

            			while($row = $result_countries->fetch_assoc()) {
	                		$country_name     = $row["region"];

	                		if ((isset($cou)) && ($cou == $country_name )){
	                			echo '<option value="'.$country_name.'" selected>'.$country_name.'</option>';
	                		}
	                		else{
	                			echo '<option value="'.$country_name.'">'.$country_name.'</option>';
	                		}
	                		
           				}
            
        			}
  				?>
 
  			</select>
  			
  			<br>
			<br>
			<label for="product_cat">Product Category:</label>
			<br>
  			<select name="product_cat" id="product_cat">
  				<?php 
  				echo '<option value="">Select Category</option>';
  				if ((isset($cat)) && ($cat =='Solar_Panels')){
	                echo '<option value="Solar_Panels" selected>Solar Panels</option>';
	            }
	            else{
	                echo '<option value="Solar_Panels">Solar Panels</option>';
	            }

	            if ((isset($cat)) && ($cat =='Inverter')){
	                echo '<option value="Inverter" selected>Inverter</option>';
	            }
	            else{
	                echo '<option value="Inverter">Inverter</option>';
	            }

	            if ((isset($cat)) && ($cat =='Charge_Controllers')){
	                echo '<option value="Charge_Controllers" selected>Charge Controllers</option>';
	            }
	            else{
	                echo '<option value="Charge_Controllers">Charge Controllers</option>';
	            }

	            if ((isset($cat)) && ($cat =='Storage_System')){
	                echo '<option value="Storage_System" selected>Storage System</option>';
	            }
	            else{
	                echo '<option value="Storage_System">Storage System</option>';
	            }

	            if ((isset($cat)) && ($cat =='Converter')){
	                echo '<option value="Converter" selected>Converter</option>';
	            }
	            else{
	                echo '<option value="Converter">Converter</option>';
	            }

	            if ((isset($cat)) && ($cat =='Mounting_System')){
	                echo '<option value="Mounting_System" selected>Mounting System</option>';
	            }
	            else{
	                echo '<option value="Mounting_System">Mounting System</option>';
	            }

	            if ((isset($cat)) && ($cat =='Tracker')){
	                echo '<option value="Tracker" selected>Tracker</option>';
	            }
	            else{
	                echo '<option value="Tracker">Tracker</option>';
	            }

  				?>
			</select>
			<br>
			<br>
			
			<label for="product_subcat">Product Subcategory:</label>
			<br>
  			<select name="product_subcat" id="product_subcat">

  				<?php 

  				echo '<option value="">Select Subcategory</option>';


  				if ((isset($subcat)) && ($subcat =='monocrystalline')){
	                echo '<option value="Monocrystalline" class="size_chart Solar_Panels1" selected>Monocrystalline</option>';
	            }
	            else{
	                echo '<option value="Monocrystalline" class="size_chart Solar_Panels1">Monocrystalline</option>';
	            }

	            if ((isset($subcat)) && ($subcat =='polycrystalline')){
	                echo '<option value="polycrystalline" class="size_chart Solar_Panels1" selected>Polycrystalline</option>';
	            }
	            else{
	                echo '<option value="polycrystalline" class="size_chart Solar_Panels1">Polycrystalline</option>';
	            }

	            if ((isset($subcat)) && ($subcat =='flexible')){
	                echo '<option value="flexible" class="size_chart Solar_Panels1" selected>Flexible</option>';
	            }
	            else{
	                echo '<option value="flexible" class="size_chart Solar_Panels1">Flexible</option>';
	            }

	            if ((isset($subcat)) && ($subcat =='bipv')){
	                echo '<option value="bipv" class="size_chart Solar_Panels1" selected>BIPV</option>';
	            }
	            else{
	                echo '<option value="bipv" class="size_chart Solar_Panels1">BIPV</option>';
	            }


	            if ((isset($subcat)) && ($subcat =='grid-tieinverter')){
	                echo '<option value="grid-tieinverter" class="size_chart Inverter1" selected>GRID-TIE Inverter</option>';
	            }
	            else{
	                echo '<option value="grid-tieinverter" class="size_chart Inverter1">GRID-TIE Inverter</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='hybridinverter')){
	                echo '<option value="hybridinverter" class="size_chart Inverter1" selected>HYBRID Inverter</option>';
	            }
	            else{
	                echo '<option value="hybridinverter" class="size_chart Inverter1">HYBRID Inverter</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='inverteraccessories')){
	                echo '<option value="inverteraccessories" class="size_chart Inverter1" selected>Inverter Accessories</option>';
	            }
	            else{
	                echo '<option value="inverteraccessories" class="size_chart Inverter1">Inverter Accessories</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='off-gridinverter')){
	                echo '<option value="off-gridinverter" class="size_chart Inverter1" selected>OFF-GRID Inverter</option>';
	            }
	            else{
	                echo '<option value="off-gridinverter" class="size_chart Inverter1">OFF-GRID Inverter</option>';
	            }


	            if ((isset($subcat)) && ($subcat =='mpptchargecontroller')){
	                echo '<option value="mpptchargecontroller" class="size_chart Charge_Controllers1" selected>MPPT Charge Controller</option>';
	            }
	            else{
	                echo '<option value="mpptchargecontroller" class="size_chart Charge_Controllers1">MPPT Charge Controller</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='pwmregulator')){
	                echo '<option value="pwmregulator" class="size_chart Charge_Controllers1" selected>PWM Regulator</option>';
	            }
	            else{
	                echo '<option value="pwmregulator" class="size_chart Charge_Controllers1">PWM Regulator</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='shuntregulators')){
	                echo '<option value="shuntregulators" class="size_chart Charge_Controllers1" selected>Shunt Regulators</option>';
	            }
	            else{
	                echo '<option value="shuntregulators" class="size_chart Charge_Controllers1">Shunt Regulators</option>';
	            }


	            if ((isset($subcat)) && ($subcat =='batteryaccessories')){

	                echo '<option value="batteryaccessories" class="size_chart Storage_System1" selected>Battery Accessories</option>';
	            }
	            else{
	                echo '<option value="batteryaccessories" class="size_chart Storage_System1">Battery Accessories</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='batteryenclosuresboxes')){
	                echo '<option value="batteryenclosuresboxes" class="size_chart Storage_System1" selected>Battery Enclosures & Boxes</option>';
	            }
	            else{
	                echo '<option value="batteryenclosuresboxes" class="size_chart Storage_System1">Battery Enclosures & Boxes</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='gelbattery')){
	                echo '<option value="gelbattery" class="size_chart Storage_System1" selected>Gel Battery</option>';
	            }
	            else{
	                echo '<option value="gelbattery" class="size_chart Storage_System1">Gel Battery</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='leadacidbattery')){
	                echo '<option value="leadacidbattery" class="size_chart Storage_System1" selected>Lead Acid Battery</option>';
	            }
	            else{
	                echo '<option value="leadacidbattery" class="size_chart Storage_System1">Lead Acid Battery</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='lithiumionbattery')){
	                echo '<option value="lithiumionbattery" class="size_chart Storage_System1" selected>Lithium ion battery</option>';
	            }
	            else{
	                echo '<option value="lithiumionbattery" class="size_chart Storage_System1">Lithium ion battery</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='saltwaterbattery')){
	                echo '<option value="saltwaterbattery" class="size_chart Storage_System1" selected>Saltwater battery</option>';
	            }
	            else{
	                echo '<option value="saltwaterbattery" class="size_chart Storage_System1">Saltwater battery</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='solarbatterychargers')){
	                echo '<option value="solarbatterychargers" class="size_chart Storage_System1" selected>Solar Battery Chargers</option>';
	            }
	            else{
	                echo '<option value="solarbatterychargers" class="size_chart Storage_System1">Solar Battery Chargers</option>';
	            }


	            if ((isset($subcat)) && ($subcat =='groundmounts')){
	                echo '<option value="groundmounts" class="size_chart Mounting_System1" selected>Ground Mounts</option>';
	            }
	            else{
	                echo '<option value="groundmounts" class="size_chart Mounting_System1">Ground Mounts</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='polemounts')){
	                echo '<option value="polemounts" class="size_chart Mounting_System1" selected>Pole Mounts</option>';
	            }
	            else{
	                echo '<option value="polemounts" class="size_chart Mounting_System1">Pole Mounts</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='roofingmounts')){
	                echo '<option value="roofingmounts" class="size_chart Mounting_System1" selected>Roofing Mounts</option>';
	            }
	            else{
	                echo '<option value="roofingmounts" class="size_chart Mounting_System1">Roofing Mounts</option>';
	            }
	            if ((isset($subcat)) && ($subcat =='rvmounting')){
	                echo '<option value="rvmounting" class="size_chart Mounting_System1" selected>RV Mounting</option>';
	            }
	            else{
	                echo '<option value="rvmounting" class="size_chart Mounting_System1">RV Mounting</option>';
	            }
	            ?>
  				

			</select>

			<br>
			<br>
			<label for="oem">OEM Service:</label>
			<br>
  			<select name="oem" id="oem">
  				<?php

  				echo '<option value="">Select OEM</option>';

  				if ((isset($ifoem)) && ($ifoem =='yes')){
	                echo '<option value="yes" selected>Yes</option>';
	           
	            }
	            else{
	                echo '<option value="yes">Yes</option>';
	                
	            }

	            if ((isset($ifoem)) && ($ifoem =='no')){
	                echo '<option value="no" selected>No</option>';
	           
	            }
	            else{
	                echo '<option value="no">No</option>';
	                
	            }
	            	
	                
  				?>
  			</select>
  			<br><br>

			<input type="submit" value="Submit">
		</form>
	</aside>
	<section class="d-70">

		<?php

			require '../wp-load.php'; // Display WP database credentials 
	
    		// Create connection
   			 $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   			 mysqli_set_charset($conn, "utf8");
			//var_dump($conn);

			$tablename = "company_profile_short";
			$tablename_details = "company_profile";
			$tablename_reviews = "company_profile_reviews";
			$tablename_news = "company_profile_news";
			$tablename_filter   = "company_profile_filter";
   		 	
			//var_dump($cp_id);
			if (isset($cou)){
				if (isset($cat)){
					if ($cat == 'Solar_Panels'){
						$sql = "select * from ".$tablename." WHERE region = '".$cou."' AND company_id in (select company_id from ".$tablename_details." where crystalline is not NULL AND crystalline != '')";
					}
					else {
						$sql = "select * from ".$tablename." WHERE region = '".$cou."' AND company_id in (select company_id from ".$tablename_details." where com_type like '%".str_replace('_',' ',$cat)."%')";
					}
					
				}
				else {
					$sql = "SELECT * FROM ".$tablename." WHERE region = '".$cou."'";
				}
				
			}
			else {
				if (isset($cat)){
					if ($cat == 'Solar_Panels'){
						$sql = "SELECT * FROM ".$tablename." WHERE company_id in (select company_id from ".$tablename_details." where crystalline is not NULL AND crystalline != '')";
					}
					else {
						$sql = "SELECT * FROM ".$tablename." WHERE company_id in (select company_id from ".$tablename_details." where com_type like '%".str_replace('_',' ',$cat)."%')";
					}
					
				}
				else {
					$sql = "SELECT * FROM ".$tablename;
				}
				
			}
    		
			//var_dump($sql);
    		$result = $conn->query($sql);

    		$total_numbers  = $result->num_rows;
    		$pnumber       = 50;
   			$pcount        = 0;
    		//

			
			if ($result->num_rows > 0) {
				echo '<div style="margin-left: 10px;">';
				for ($y = 0; $y < $total_numbers; $y+=$pnumber) {
					$pp = intval($y/$pnumber + 1);
					if ($pp == intval($current_page)){
						echo '<b style="color:#0581c7;text-decoration: underline;">'.$pp.'</b> ';
					}
					else {
						$page_pos = strpos($_SERVER['REQUEST_URI'],'&p=');
						if ($page_pos == ""){
							$new_domain = $_SERVER['REQUEST_URI'];
						}
						else{
							$new_domain = substr($_SERVER['REQUEST_URI'], 0, $page_pos);
							}
						
						//var_dump($new_domain);
						echo '<a href="'.$new_domain.'&p='.$pp.'">'.$pp."</a> ";
					}
					      
				}
				echo '</div>';
				while($cp_row = $result->fetch_assoc()) {
					$pcount        = $pcount + 1;
					//var_dump($pcount);
					if (($pcount > ($current_page*$pnumber-$pnumber)) && ($pcount <= ($current_page*$pnumber))){
						//var_dump($pcount);
						$name_new =  str_replace(" ","-",$cp_row["name"]);
						$name_new =  str_replace(".","",$name_new);
						
						?>
						<div class="whiteblock">
							<div class="listcontent" style="min-height: 120px;">
								<div class="d-30">
									<img src="<?php echo $cp_row["company_image"]; ?>" style="max-height: 100px;max-width: 210px;">
								</div>
								<div class="d-40">
									<h1 style="font-size:12px;"><?php echo $cp_row["name"]; ?></h1>
									Factory Location:
									<br>	
									<?php echo $cp_row["region"]; ?>  
									<br>
									<?php 
									$sql_cat="select crystalline, com_type from ".$tablename_details." WHERE company_id = ".$cp_row["ID"];
									//var_dump($sql_cat);
    								$result_cat = $conn->query($sql_cat);
    								if ($result_cat->num_rows > 0) {
    									while($cp_row_cat = $result_cat->fetch_assoc()) {
    										if ($cp_row_cat['crystalline'] == "") {
    											if ($cp_row_cat['com_type'] == ""){

    											}
    											else {
    												echo $cp_row_cat['com_type'];
    											}
    										}
    										else{
    											if ($cp_row_cat['com_type'] == ""){

    												echo 'Solar Panels';
    											}
    											else{
    												echo 'Solar Panels, ';
    												echo $cp_row_cat['com_type'];
    											}
    										}
    									
    									}
    								}


									?>
								</div>
								<div class="d-30">
									<br>
									<a href="https://solarfeeds.com/contact/" class="btn_quote">Get a Quote</a>
									<br><br>
									<a href="https://shop.solarfeeds.com/brands/<?php echo $name_new; ?>" class="btn_quote" target=" _blank">Know More</a>
								</div>
							</div>
							<div class="listsummary">
								<?php echo substr(Strip_tags($cp_row["about"]), 0,250); ?> ......
							</div>
						</div>
						<?php
						//if ($pcount>=$pnumber){break;}


					}
					
				}
			}

		?>


		
	</section>
</div>

<div class="secondaryblock">

	<?php 
		if (isset($cou)){
			$sql_country_filter      = "SELECT countries, product_cat, title, content FROM ".$tablename_filter." WHERE countries = '".strval($cou)."' and product_cat = '0'";
			//var_dump($sql_country_filter);
        	$result_country_filter      = $conn->query($sql_country_filter);

  					if ($result_country_filter->num_rows > 0) {

            			while($row = $result_country_filter->fetch_assoc()) {
            				//var_dump($row);
            				$country_content = $row['content'];
            				//$country_content = str_replace('\"','',$row['content']); 
            				echo $country_content;
            			}
            		}

		}

		?><br><?php

		if (isset($cat)){
			$sql_cat_filter      = "SELECT countries, product_cat, title, content FROM ".$tablename_filter." WHERE countries = '0 and product_cat = '".$cat."'";
			//var_dump($sql_country_filter);
        	$result_cat_filter      = $conn->query($sql_cat_filter);

  					if ($result_cat_filter->num_rows > 0) {

            			while($row = $result_cat_filter->fetch_assoc()) {
            				//var_dump($row);
            				$country_content = $row['content'];
            				//$country_content = str_replace('\"','',$row['content']); 
            				echo $country_content;
            			}
            		}

		}

	?>
	
</div>


<script src="js/jquery.js"></script>
<script>
$(document).ready(function(){

  //hides dropdown content
  $(".size_chart").hide();

  var queryString = window.location.search;
  var urlParams = new URLSearchParams(queryString);
  var product = urlParams.get('product_cat');

  //alert(product_new);
  $("."+product+"1").show();
  //unhides first option content
  //$("#option1").show();
  
  //listen to dropdown for change
  $("#product_cat").change(function(){
    //rehide content on change
    $('.size_chart').hide();
    //unhides current item
    $('.'+$(this).val()+'1').show();
  });
  
});

</script>

<?php 
get_footer(); 
?>