<?php 
//function update_cp_page(){
    


    require '../wp-load.php'; // Display WP database credentials 
	
    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//var_dump($conn);

	$tablename = "company_profile_short";
	$tablename_details = "company_profile";
	$tablename_reviews = "company_profile_reviews";
	$tablename_news = "company_profile_news";
	
    $cp_id = $_GET['company_id'];
	//var_dump($cp_id);
	
    $sql = "SELECT * FROM ".$tablename;
	var_dump($sql);
    $result = $conn->query($sql);
    //

			
	if ($result->num_rows > 0) {
		while($cp_row = $result->fetch_assoc()) {
			$new_cp_id = $cp_row['company_id'];
			$new_cp_name = $cp_row['name'];
			$new_cp_address= $cp_row['address'];
			$new_cp_phone= $cp_row['phone'];
			$new_cp_image = $cp_row['company_image'];
			$new_cp_email= $cp_row['email'];
			$new_cp_url= $cp_row['url'];
			$new_cp_region= $cp_row['region'];
			$new_cp_facebook= $cp_row['facebook'];
			$new_cp_linkedin= $cp_row['linkedin'];
			$new_cp_twitter= $cp_row['twitter'];
			$new_cp_about= $cp_row['about'];

			//var_dump($new_cp_name);
			//var_dump($new_cp_address);
			//var_dump($new_cp_phone);
			//var_dump($new_cp_email);
			//var_dump($new_cp_url);
			//var_dump($new_cp_facebook);


				//$sql_detail = "SELECT * FROM ".$tablename_details." WHERE company_id=".intval($new_cp_id);
				//var_dump($sql_detail);
    			//$result_detail = $conn->query($sql_detail);
				
				
				
				//if ($result_detail->num_rows > 0) {	
					//while ($cp_row_detail= $result_detail->fetch_assoc()){
						//$new_cp_staffno= intval($_POST['cpstaff_no']);
						//$new_cp_crystalline= $_POST['cpcrystalline'];
						//$new_cp_cprl= $_POST['cpcprl'];
						//$new_cp_cprh= $_POST['cpcprh'];
						//$new_cp_high_eff= $_POST['cphigh_eff'];
						//$new_cp_hecprl= $_POST['cphecprl'];
						//$new_cp_hecprh= $_POST['cphecprh'];
					//}
				//} 
								

			
			$file["url"]="https://shop.solarfeeds.com/brands/".$new_cp_image;
			var_dump($file["url"]);
			//var_dump($_POST['cimage']);
			//var_dump($sql_check);
				//
			if ( has_files_to_upload( 'example-jpg-file-new' ) ) {					
					if ( isset( $_FILES['example-jpg-file-new'] ) ) {						
						$file = wp_upload_bits( $_FILES['example-jpg-file-new']['name'], null, @file_get_contents( $_FILES['example-jpg-file-new']['tmp_name'] ) );
						//var_dump($file["url"]);
						//var_dump($file);
						if ( $file['error'] == "Empty filename") {	  
							//
							$file["url"]= $_POST['cimage'];// TODO	  
							//var_dump($file["url"]);
						}				    					
					}
			}

			else {
				if ( has_files_to_upload( 'example-jpg-file' ) ) {					
					if ( isset( $_FILES['example-jpg-file'] ) ) {						
						$file = wp_upload_bits( $_FILES['example-jpg-file']['name'], null, @file_get_contents( $_FILES['example-jpg-file']['tmp_name'] ) );
						//var_dump("2");
						//var_dump($file);
						if ( $file['error'] == "Empty filename") {	  
							$file["url"]= $_POST['cimage'];// TODO	
							//var_dump("4");
						}			    					
					}	
				}
			}
							
			
			$xx_write = '<div class="whiteblock" id="archivenews"><h2>Archive News for '.$new_cp_name.': </h2><div class="content">';
			$xx_write = $xx_write.'</div></div>';
			
			
			$x_write = '<div class="whiteblock" id="userreviews"><h2 style="margin-bottom:0px !important;">Reviews for '.$new_cp_name.": </h2>";
			$x_write=$x_write.'</div>';
			
				
			
			$updatecontent = "<?php require_once('".$_SERVER['DOCUMENT_ROOT']."/wp-load.php'); get_header();?>";
					
			$updatecontent = $updatecontent.'<style>.rating {
  display: inline-block;
  position: relative;
  line-height: 50px;
  margin-bottom: 10px !important;
  font-size: 30px;
}

.rating label {
  position: absolute;
  top: 0;
  left: 0;
  height: 50px;
  cursor: pointer;
}

.rating label:last-child {
  position: static;
}

.rating label:nth-child(1) {
  z-index: 5;
}

.rating label:nth-child(2) {
  z-index: 4;
}

.rating label:nth-child(3) {
  z-index: 3;
}

.rating label:nth-child(4) {
  z-index: 2;
}

.rating label:nth-child(5) {
  z-index: 1;
}

.rating label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.rating label .icon {
  float: left;
  color: transparent;
}

.rating label:last-child .icon {
  color: #000;
}

.rating:not(:hover) label input:checked ~ .icon,
.rating:hover label:hover input ~ .icon {
  color: #09f;
}

.rating label input:focus:not(:checked) ~ .icon:last-child {
  color: #000;
  text-shadow: 0 0 5px #09f;
}
#mfp-topbar {
	position: fixed;
	top: 0;
	width: 100%;
	left: 0;
	background: #000;
	height:30px;
}
#mfp-topbar ul {
	list-style: none;
	padding-left: 66px;
	display: inline;
}
#mfp-topbar ul li {
	display: inline;
	padding-left: 7px;
}
#mfp-topbar ul li a {
	color: #eee !important;
	font-size: 14px;
}

</style>';
			$updatecontent = $updatecontent."<style>a{color: #4DB7FE !important;}.site-content{padding-top:30px !important;}.whiteblock{box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);background: #fff;border-radius: 10px;z-index:-1;margin-right: 20px;padding: 15px 30px;border: 1px solid #e5e7f2;}body {background: #f6f6f6 !important;}.content {width: 80%;padding: 20px;padding: 0 60px 0 0;}.question {position: relative;background: lightgrey;padding: 10px 10px 10px 50px;display: block;width:100%;cursor: pointer;}.answers {padding: 0px 15px;margin: 5px 0;max-height: 0;overflow: hidden;z-index: 0;position: relative;opacity: 0;-webkit-transition: .7s ease;-moz-transition: .7s ease;-o-transition: .7s ease;transition: .7s ease;}.questions:checked ~ .answers{max-height: 500px;opacity: 1;padding: 15px;}.plus {position: absolute;margin-left: 10px;z-index: 5;font-size: 2em;line-height: 100%;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;-webkit-transition: .3s ease;-moz-transition: .3s ease;-o-transition: .3s ease;transition: .3s ease;}.questions:checked ~ .plus {-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-o-transform: rotate(45deg);transform:rotate(45deg);}.questions {display: none;}#rightmenu {position: fixed;right: 0;top: 5%;width: 12em;margin-top: -2.5em;}.d-70{width:70%;float:left;}.d-30{width:30%;float:right;}@media only screen and (max-width: 767px) {.d-70{width:100%;}.d-30{width:100%;}.nomargins{margin-top:0px !important;margin-bottom:0px !important;}</style>";
			
			//top edit bar	
			//if ( is_user_logged_in() ) {
				$edit_url= "https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustomsubpage&company_id=".$new_cp_id;
				$add_url = "https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcreatepage";
				$admin_url = "https://shop.solarfeeds.com/wp-admin";
				$updatecontent = $updatecontent."<?php if ( is_user_logged_in() ) { ?>";
				$updatecontent = $updatecontent."<div id='mfp-topbar'><ul><li><a href='".$edit_url."'>Edit this page</a> |</li><li><a href='".$add_url."'>Add a new profile</a> |</li><li><a href='".$admin_url."'>WP Dashboard</a></li></ul></div>";
				$updatecontent = $updatecontent."<?php } ?>";
			//}
					
			if ($new_cp_name == ""){
					$new_cp_name = "Unknown";
				}
			if ($new_cp_address == ""){
					$new_cp_address = "Unknown";
				}
			if ($new_cp_phone == ""){
					$new_cp_phone = "Unknown";
				}
			if ($new_cp_email == ""){
					$new_cp_email = "Unknown";
				}
			if ($new_cp_url == ""){
					$new_cp_url = "Unknown";
				}
			if ($new_cp_region == ""){
					$new_cp_region = "Unknown";
				}
			if ($new_cp_facebook == ""){
					$new_cp_facebook = "Unknown";
			}
			if ($new_cp_linkedin == ""){
					$new_cp_linkedin = "Unknown";
				}
			if ($new_cp_twitter == ""){
					$new_cp_twitter = "Unknown";
				}
			if ($new_cp_about == ""){
					$new_cp_about = "Unknown";
				}
				
				
					
			$updatecontent = $updatecontent.'<section class="d-70">';
			$updatecontent = $updatecontent.'<div class="whiteblock"><h1>'.$new_cp_name.' | Product Reviews</h1>';
			$updatecontent = $updatecontent."Factory Location: ".$new_cp_region."      ";
			$updatecontent = $updatecontent.' | <a href="#userreviews">0 Reviews</a> | <a href="#archivenews">0 News</a><br></div>';
			$updatecontent = $updatecontent.'<hr style="width:50%;text-align:left;margin-left:0">';
						
			$updatecontent = $updatecontent.'<div class="whiteblock"><h2>About '.$new_cp_name.": </h2>".$new_cp_about."</div><br>";
			$updatecontent = '<br>'.$updatecontent.$x_write.'<br>';
			$updatecontent = $updatecontent.$xx_write."<br>";
					
					/* $updatecontent = $updatecontent.'<div class="whiteblock">
					<h2>Add Reviews</h2>
					<form class="rating" action="" method="POST" enctype="multipart/form-data">
  					<div>
					<label>
    					<input type="radio" name="stars" value="1" />
    					<span class="icon">★</span>
 				 	</label>
  					<label>
    					<input type="radio" name="stars" value="2" />
    					<span class="icon">★</span>
    					<span class="icon">★</span>
  					</label>
  					<label>
    					<input type="radio" name="stars" value="3" />
    					<span class="icon">★</span>
    					<span class="icon">★</span>
    					<span class="icon">★</span>   
  					</label>
 					<label>
    					<input type="radio" name="stars" value="4" />
    					<span class="icon">★</span>
    					<span class="icon">★</span>
    					<span class="icon">★</span>
    					<span class="icon">★</span>
  					</label>
  					<label>
    					<input type="radio" name="stars" value="5" />
    					<span class="icon">★</span>
    					<span class="icon">★</span>
    					<span class="icon">★</span>
    					<span class="icon">★</span>
    					<span class="icon">★</span>
  					</label>
					</div>
					<br>
				    <div style="font-size:17px;">
					Name: <input type="text" id="addnewname" name="addnewname"><br>
					Review: <input id="addnewreview" name="addnewreview" type="text"><br>
					</div>
    				
					<input type="submit" value="Submit" style="font-size:17px;">
				</form>
				
				</div>';
					
					$updatecontent = $updatecontent."<script>var $ = jQuery;$(':radio').change(function() {console.log('New star rating: ' + this.value);});</script>";*/
			$updatecontent = $updatecontent."</section>";
					
			$updatecontent = $updatecontent.'<aside class="d-30">';
			$updatecontent = $updatecontent.'<div class="whiteblock" style="padding: 0;"><a href="https://solarfeeds.com/list-your-business/ "><img src="https://shop.solarfeeds.com/wp-content/uploads/2019/08/Add-a-heading.png"></a></div><br>';
	
			$updatecontent = $updatecontent.'<div class="whiteblock"><img src="'.$file["url"].'">';
					
			$updatecontent = $updatecontent.'<h2 style="margin-top:10px !important;margin-bottom:10px !important">Contact Info</h2>'.'<div><a href="#"><i class="fa fa-building-o" aria-hidden="true"></i></a> '.$new_cp_address.'</div><div><a href="'.$new_cp_url.'"><i class="fa fa-globe" aria-hidden="true"></i></a> '.$new_cp_url.'</div><div><a href="tel:'.$new_cp_phone.'"><i class="fa fa-phone" aria-hidden="true"></i></a> '.$new_cp_phone.'</div>'.'<div><a href="mailto:'.$new_cp_email.'"><i class="fa fa-envelope"></i></a> '.$new_cp_email.'</div>'.'<div><a href="'.$new_cp_facebook.'"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> '.$new_cp_facebook.'</div>'.'<div><a href="'.$new_cp_linkedin.'"><i class="fa fa-linkedin" aria-hidden="true"></i></a> '.$new_cp_linkedin.'</div>'.'<div><a href="'.$new_cp_twitter.'"><i class="fa fa-twitter" aria-hidden="true"></i></a> '.$new_cp_twitter.'</div></div><br>';
			//$updatecontent = $updatecontent.'<div class="whiteblock"><h2 style="margin-top:10px !important;margin-bottom:10px !important">Product Information</h2><ul><li><a href="#">Company Size: </a><br>'.$new_cp_staffno.'</li>'.'<li><a href="#">Crystalline</a><br>'.$new_cp_crystalline.'<br>Power Range (Wp): '.$new_cp_cprl.'-'.$new_cp_cprh.'</li>'.'<li><a href="#">High Efficiency Crystalline</a><br>'.$new_cp_high_eff.'<br>Power Range (Wp): '.$new_cp_hecprl.'-'.$new_cp_hecprh.'</li>'.'</ul>';
			//$updatecontent = $updatecontent."</div>";
			$updatecontent = $updatecontent.'<div class="whiteblock"><br>Own or work here? <a href="https://solarfeeds.com/contact/">Claim Now!</a> <br><br></div>';
			$updatecontent = $updatecontent."</aside>";
				
					
					
			$updatecontent = $updatecontent."<?php get_footer(); ?>";
					//var_dump($updatecontent);
			$new_cp_name = str_replace(",","",$new_cp_name);
			$new_cp_name = str_replace(' ', '-', $new_cp_name);
			$new_cp_name = preg_replace("/[^A-Za-z0-9-]/", '', $new_cp_name);

			$writefoldername = $_SERVER['DOCUMENT_ROOT']."/brands/".$new_cp_name;
					
				
			if (file_exists($writefoldername)) {
				        rmdir($writefoldername, 0777, true); 
    					mkdir($writefoldername, 0777, true);
						
			}
					
			$writefilename = $writefoldername."/index.php";
					//var_dump($writefilename);
			$writefile = file_put_contents($writefilename,$updatecontent);
					//var_dump($writefile);
		}
	}
		
    $conn->close();

//}

?>
