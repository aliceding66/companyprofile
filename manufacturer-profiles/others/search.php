<?php 

require_once('/srv/htdocs/wp-load.php'); 
get_header();


?>

<style>

.page-header-default .page-breadcrumbs {
    display: none !important;
}

.site-content {
    background: url(https://cdn.pixabay.com/photo/2016/05/15/16/08/solar-panel-1393880_1280.png);
    background-size: cover;
    height: 60vh;
    padding-top: 0px !important;
    padding-bottom: 0px !important;
}

button, select {
    text-transform: none;
    height: 35px !important;
    border: solid 2px #0581c7 !important;
    border-radius: 10px;
    background: #0581c7 !important;
    color: white !important;
}
button, html input[type="button"], input[type="reset"], input[type="submit"] {
    -webkit-appearance: button;
    cursor: pointer;
    background: #0581c7 !important;
    border: solid 2px #0581c7 !important;
    border-radius: 10px;
    color: white !important;
    height: 35px !important;
}

.btn_search{
	position: absolute;
    top: 40vh;
    left: 45vh;
}

.primarysearch{
		background:transparent;
    background-size: cover;
    height: 60vh;
    padding-top: 0px !important;
    padding-bottom: 0px !important;
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
}
.btn_quote {
    background: #0581c7;
    color: white;
    padding: 10px;
		margin:10px auto;
		display:block;
		overflow:hidden;
		width:150px;
}
.btn_quote:hover {
    background: white !important;
    color: #0581c7 !important;
    padding: 10px;
}
@media only screen and (max-width: 768px) {
		.d-30, .d-40 {
			width:100%;
		}
		.btn_search form {
			line-height: 2.6;
		}
			.btn_search {
			left: 0 !important;
		}
		.listcontent {
			text-align:center;
		}
		.primarysearch {
			text-align: center;
		}
		.whiteblock {
			margin-left: 15px;
    	margin-right: 15px;
		}
  
}
@media only screen and (max-width: 375px) {
  .primarysearch {
  	text-align: justify;
	}
  .btn_search {
  	left: 0 !important;
	  padding: 0 70px;
	}
}
</style>
<div class="primarysearch">
	<div class="btn_search">
		<form action="result.php">
  			<!--<label for="countries">Choose a factory location:</label>-->
  			<select name="countries" id="countries">
  				<option value="">Location</option>
  				<?php
  					// Create connection
    				$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   
    				$tablename_details = "company_profile";
    				$tablename         = "company_profile_short";
    				$sql_countries      = "SELECT DISTINCT region FROM ".$tablename." ORDER BY region";
        			$result_countries       = $conn->query($sql_countries);

  					if ($result_countries->num_rows > 0) {

            			while($row = $result_countries->fetch_assoc()) {
	                		$country_name     = $row["region"];
	                		echo '<option value="'.$country_name.'">'.$country_name.'</option>';
           				}
            
        			}
  				?>
 
  			</select>
  			
			<!--<label for="product_cat">Product Category:</label>-->
			
  			<!--Size dropdown menu-->
			<select name="product_cat" id="product_cat">
  				<option value="" onclick="">Product Category</option>
  				<option value="Solar_Panels">Solar Panels</option>
  				<option value="Inverter">Inverter</option>
  				<option value="Charge_Controllers">Charge Controllers</option>
  				<option value="Storage_System">Storage System</option>
  				<option value="Converter">Converter</option>
  				<option value="Mounting_System">Mounting System</option>
  				<option value="Tracker">Tracker</option>
			</select>

			<!--Size dropdown content-->

			<select name="product_subcat" id="product_subcat">
  				<option value="">Product Subcategory</option>
  				<option value="monocrystalline" class="size_chart Solar_Panels1">Monocrystalline</option>
  				<option value="polycrystalline" class="size_chart Solar_Panels1">Polycrystalline</option>
  				<option value="flexible" class="size_chart Solar_Panels1">Flexible</option>
  				<option value="bipv" class="size_chart Solar_Panels1">BIPV</option>

  				<option value="grid-tieinverter" class="size_chart Inverter1">GRID-TIE Inverter</option>
  				<option value="hybridinverter" class="size_chart Inverter1">HYBRID Inverter</option>
  				<option value="inverteraccessories" class="size_chart Inverter1">Inverter Accessories</option>
  				<option value="off-gridinverter" class="size_chart Inverter1">OFF-GRID Inverter</option>


  				<option value="mpptchargecontroller" class="size_chart Charge_Controllers1">MPPT Charge Controller</option>
  				<option value="pwmregulator" class="size_chart Charge_Controllers1">PWM Regulator</option>
  				<option value="shuntregulators" class="size_chart Charge_Controllers1">Shunt Regulators</option>


  				<option value="batteryaccessories" class="size_chart Storage_System1">Battery Accessories</option>
  				<option value="batteryenclosuresboxes" class="size_chart Storage_System1">Battery Enclosures & Boxes</option>
  				<option value="gelbattery" class="size_chart Storage_System1">Gel Battery</option>
  				<option value="leadacidbattery" class="size_chart Storage_System1">Lead Acid Battery</option>
  				<option value="lithiumionbattery" class="size_chart Storage_System1">Lithium ion battery</option>
  				<option value="saltwaterbattery" class="size_chart Storage_System1">Saltwater battery</option>
  				<option value="solarbatterychargers" class="size_chart Storage_System1">Solar Battery Chargers</option>


  				<option value="groundmounts" class="size_chart Mounting_System1">Ground Mounts</option>
  				<option value="polemounts" class="size_chart Mounting_System1">Pole Mounts</option>
  				<option value="roofingmounts" class="size_chart Mounting_System1">Roofing Mounts</option>
  				<option value="rvmounting" class="size_chart Mounting_System1">RV Mounting</option>


			</select>
			
			<!--<label for="oem">OEM Service:</label>-->
		
  			<select name="oem" id="oem">
  				<option value="">OEM</option>
  				<option value="yes">Yes</option>
  				<option value="no">No</option>
  			</select>
  		

			<input type="submit" value="Search">
		</form>
	</div>
</div>

<br>
<br>
<div class="whiteblock">
	<div class="listcontent">
		<div class="d-30">
			<img src="https://shop.solarfeeds.com/brands/images/AdityaKiran.jpg">
		</div>
		<div class="d-40">
			<h1>Applied Power System Inc</h1>
			Factory Location:
			<br>
			China       
			<br>
			Module, Inverter, Battery
		</div>
		<div class="d-30 text-center">
			<a class="btn_quote" href="#">Get a Quote</a>
			<a class="btn_quote" href="#">Know More</a>
		</div>
	</div>
	<div class="listsummary">
		APS manufactures high power electronic components, motor controls and power system products including IGBT Inverters, Converters & Phase Controllers (first 35 words)
	</div>
</div>

<div class="whiteblock">
	<div class="listcontent">
		<div class="d-30">
			<img src="https://shop.solarfeeds.com/brands/images/AdityaKiran.jpg">
		</div>
		<div class="d-40">
			<h1>Applied Power System Inc</h1>
			Factory Location:
			<br>
			China       
			<br>
			Module, Inverter, Battery
		</div>
		<div class="d-30 text-center">
			<a class="btn_quote" href="#">Get a Quote</a>
			<a class="btn_quote" href="#">Know More</a>
		</div>
	</div>
	<div class="listsummary">
		APS manufactures high power electronic components, motor controls and power system products including IGBT Inverters, Converters & Phase Controllers (first 35 words)
	</div>
</div>
<div class="whiteblock">
	<div class="listcontent">
		<div class="d-30">
			<img src="https://shop.solarfeeds.com/brands/images/AdityaKiran.jpg">
		</div>
		<div class="d-40">
			<h1>Applied Power System Inc</h1>
			Factory Location:
			<br>
			China       
			<br>
			Module, Inverter, Battery
		</div>
		<div class="d-30 text-center">
			<a class="btn_quote" href="#">Get a Quote</a>
			<a class="btn_quote" href="#">Know More</a>
		</div>
	</div>
	<div class="listsummary">
		APS manufactures high power electronic components, motor controls and power system products including IGBT Inverters, Converters & Phase Controllers (first 35 words)
	</div>
</div>
<div class="whiteblock">
	<div class="listcontent">
		<div class="d-30">
			<img src="https://shop.solarfeeds.com/brands/images/AdityaKiran.jpg">
		</div>
		<div class="d-40">
			<h1>Applied Power System Inc</h1>
			Factory Location:
			<br>
			China       
			<br>
			Module, Inverter, Battery
		</div>
		<div class="d-30 text-center">
			<a class="btn_quote" href="#">Get a Quote</a>
			<a class="btn_quote" href="#">Know More</a>
		</div>
	</div>
	<div class="listsummary">
		APS manufactures high power electronic components, motor controls and power system products including IGBT Inverters, Converters & Phase Controllers (first 35 words)
	</div>
</div>
<div class="whiteblock">
	<div class="listcontent">
		<div class="d-30">
			<img src="https://shop.solarfeeds.com/brands/images/AdityaKiran.jpg">
		</div>
		<div class="d-40">
			<h1>Applied Power System Inc</h1>
			Factory Location:
			<br>
			China       
			<br>
			Module, Inverter, Battery
		</div>
		<div class="d-30 text-center">
			<a class="btn_quote" href="#">Get a Quote</a>
			<a class="btn_quote" href="#">Know More</a>
		</div>
	</div>
	<div class="listsummary">
		APS manufactures high power electronic components, motor controls and power system products including IGBT Inverters, Converters & Phase Controllers (first 35 words)
	</div>
</div>
<script src="js/jquery.js"></script>
<script>
$(document).ready(function(){

  //hides dropdown content
  $(".size_chart").hide();
  
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