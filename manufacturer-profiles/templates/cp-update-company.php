<?php 
 //ini_set('max_execution_time', 500);
 //set_time_limit(500);
 /*********functions */
 require_once MFP_PLUGIN_PATH."includes/functions.php";
 
 /***********************end**********************/ 

	
    // Create connection
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//var_dump($conn);

	$tablename         = "company_profile_short";
	$tablename_details = "company_profile";
	$tablename_reviews = "company_profile_reviews";
	$tablename_news    = "company_profile_news";
	$tablename_milestones    = "company_profile_milestones";
    $cp_id = $cp_review_company_id;
	//fetch company data
// 	$offset = 0;
// while (true) {
// 	if ($offset == 0) {
//         $sql    = "SELECT * FROM company_profile_short LIMIT 10";
//     } else {
// 		$sql    = "SELECT * FROM company_profile_short LIMIT 10 OFFSET ".$offset;
//     }
    $sql = "SELECT * FROM company_profile_short WHERE company_id=".$cp_id;
    $result = $conn->query($sql);
	if ($result->num_rows > 0) {
        
		while($cp_row = $result->fetch_assoc()) {	
            
			$new_cp_id               = $cp_row['company_id'];
			$new_cp_name             = $cp_row['name'];
			$new_cp_asname           = $cp_row['as_name'];
			$new_cp_vision 			 = $cp_row['vision'];
			$new_cp_slogan 			 = $cp_row['slogan'];
			$new_cp_founded			 = $cp_row['founded'];
			$new_cp_founder			 = $cp_row['founder'];
			$new_cp_ceo				 = $cp_row['ceo'];
			$new_cp_address          = $cp_row['address'];
			$new_cp_phone            = $cp_row['phone'];
			$new_cp_image            = $cp_row['company_image'];
			$new_cp_email            = $cp_row['email'];
			$new_cp_url              = $cp_row['url'];
			$new_cp_region           = $cp_row['region'];
			$new_cp_facebook         = $cp_row['facebook'];
			$new_cp_linkedin         = $cp_row['linkedin'];
			$new_cp_twitter          = $cp_row['twitter'];
			$new_cp_youtube          = $cp_row['youtube']; 
			$new_cp_about            = $cp_row['about'];
			$new_cp_business_status  = $cp_row['status'];
			$new_cp_claimed			 = $cp_row['is_claimed'];

			$currentUserRole = wp_get_current_user();
			if ( in_array( 'mfp_owner', (array) $currentUserRole->roles ) ) {
				$currentUserId = get_current_user_id();
				$comapnyOwnerId = $cp_row['company_owner'];
				if ($currentUserId != $comapnyOwnerId) {
					echo 'You are not authorised to access this page';
					exit();
				}
			}   
			//var_dump($new_cp_name);
			//var_dump($new_cp_address);
			//var_dump($new_cp_phone);
			//var_dump($new_cp_email);
			//var_dump($new_cp_url);
			//var_dump($new_cp_facebook);


			$sql_detail = "SELECT * FROM ".$tablename_details." WHERE company_id=".intval($new_cp_id);
    		$result_detail = $conn->query($sql_detail);
				
				if ($result_detail->num_rows > 0) {	
					while ($cp_row_detail= $result_detail->fetch_assoc()){
						$new_cp_staffno     = $cp_row_detail['cpstaff_no'];
						$new_cp_crystalline = $cp_row_detail['cpcrystalline'];
						$new_cp_cprl        = $cp_row_detail['cpcprl'];
						$new_cp_cprh        = $cp_row_detail['cpcprh'];
						$new_cp_high_eff    = $_POST['cphigh_eff'];
						$new_cp_hecprl      = $cp_row_detail['cphecprl'];
						$new_cp_hecprh      = $cp_row_detail['cphecprh'];
					    $new_cp_comtype     = $cp_row_detail['cpcomtype'];
						$new_businesstype   = $cp_row_details['business_type'];
					}
				} 
				
		$related_profiles = realted_manufacturer($new_cp_region, $new_cp_comtype, $new_cp_crystalline,$new_cp_id); 
		//print_r($related_profiles);
		// $x =  $offset." Profiles get generated";
		print_r($x);
	
			//fetch News	
	
			$file["url"]="https://shop.solarfeeds.com/brands/".$new_cp_image;
			//var_dump($file["url"]);
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
			//Fetch News
			$sql_news = "SELECT * FROM ".$tablename_news." WHERE company_id=".intval($new_cp_id);
			$result_news = $conn->query($sql_news);
				if ($result_news->num_rows > 0) {	
					while ($cp_row_news = $result_news->fetch_assoc()){
						$news_id = $cp_row_news['news_id'];
						$news_title = $cp_row_news['title'];
						$news_content = $cp_row_news['content'];

						$xx_write  = $xx_write.'<div>';
						$xx_write  = $xx_write.'<input type="checkbox" id="question'.$news_id.'" name="q" class="questions"><div class="plus">+</div><label for="question'.$news_id.'" class="question">'.$news_title.'</label>';
						$xx_write  = $xx_write.'<div class="answers">'.$news_content.'</div>';
						$xx_write  = $xx_write.'</div>';
		
					}
				} 
			
			$xx_write = $xx_write.'</div></div>';
			
			
			$x_write = '<div class="whiteblock" id="userreviews"><h2>Reviews for '.$new_cp_name.": </h2>";
			//Fetch News
			$sql_reviews = "SELECT * FROM ".$tablename_reviews." WHERE company_id=".intval($new_cp_id);
			$result_reviews = $conn->query($sql_reviews);
				if ($result_reviews->num_rows > 0) {	
					while ($cp_row_reviews = $result_reviews->fetch_assoc()){
						$review_id = $cp_row_reviews['review_id'];
						$review_title = $cp_row_reviews['review_name'];
						$review_content = $cp_row_reviews['review_content'];

						$x_write                  = $x_write.$review_title.'<br>';
						$x_write                  = $x_write.$review_content."<br><br>";
		
					}
				} 
			$x_write=$x_write.'</div>';
				// Customer Reviews Section Start

				$x_write   = $x_write.'</br><div class="whiteblock" id="customerreviews"><h2>Customer reviews for '.$new_cp_name.": </h2>";

				$cp_sql_creviews    = "SELECT company_profile_review.*,company_profile_reviewer.name, company_profile_reviewer.email FROM company_profile_review INNER JOIN company_profile_reviewer ON company_profile_review.reviewer_id = company_profile_reviewer.id  WHERE company_profile_review.verified=1 AND company_profile_review.company_id='".$new_cp_id."' ORDER BY verified_at DESC ";
				$cp_result_creviews = $conn->query($cp_sql_creviews);
				if ($cp_result_creviews->num_rows > 0) {
				$x_write = $x_write. '<div class="content"><div>';
				$x_write  = $x_write.'<input type="checkbox" id="question-crv" class="questions"><div class="plus">+</div><label for="question-crv" class="question">View All</label>';
				$x_write = $x_write. '<div class="answers custom-answer">';
				while($row_creviews = $cp_result_creviews->fetch_assoc()) {
					$x_write = $x_write. '<div class="reviews_bx">';
					$rid = $row_creviews['id'];
					
					$x_write = $x_write. '<div class="review_bxmain">';
					$x_write = $x_write. '<p style="margin-bottom:10px"><img width="22px" src="'.MFP_PLUGIN_URL.'imgs/profile-default.png" alt="profile"><label style="margin-left: 10px;">'.$row_creviews["name"].'</label></p>';
					$x_write = $x_write. '<div class="review_bxrow">';
					$ovl = round($row_creviews['overall_rating']);
					//manul round
					$ovl_class = "mfp-star-".str_replace(".", "", $ovl);
					$x_write = $x_write. '<i style="margin-left:-5px" class="'.$ovl_class.' mfp-star-rating"> </i>'.$row_creviews['overall_rating'].'</br>';
					$x_write = $x_write. '<span>Submitted on '.$row_creviews["created_at"].' | </span><a onclick="reviewToggle('.$rid.')"  class="review_bx_toggle"><span>View Full Review</span></a>';
					$x_write = $x_write. '</div></div>';
	
					$x_write = $x_write. '<div class="review_bxfull" id="review_bxfull-'.$rid.'">';
					$x_write = $x_write. '<div class="review_bxrow">';
					$ssc = $row_creviews['supplier_service_count'];
					$ssc_class = "mfp-star-".str_replace(".", "", $ssc); 
					$x_write = $x_write. '<label><b>Suplier Service: </b></label><i class="'.$ssc_class.' mfp-star-rating"></i>'.$ssc.'</br>';
					$x_write = $x_write. '<span>'.$row_creviews["supplier_service_comment"].'</span></br>';
					$x_write = $x_write. '</div>';
	
					$x_write = $x_write. '<div class="review_bxrow">';
					$ots = $row_creviews['one_time_shipment'];
					$ots_class = "mfp-star-".str_replace(".", "", $ots);
					$x_write = $x_write. '<label><b>On-Time Shipment:</b></label><i class="'.$ots_class.' mfp-star-rating"></i>'.$ots.'</br>';
					$x_write = $x_write. '<span>'.$row_creviews["one_time_comment"].'</span></br>';
					$x_write = $x_write. '</div>';
	
					$x_write = $x_write. '<div class="review_bxrow">';
					$pq = $row_creviews['product_quality'];
					$pq_class = "mfp-star-".str_replace(".", "", $pq);
					$x_write = $x_write. '<label><b>Product Quality:</b></label><i class="'.$pq_class.' mfp-star-rating"> </i>'.$pq.'</br>';
					$x_write = $x_write. '<span>'.$row_creviews["product_quality_comment"].'</span></br>';
					$x_write = $x_write. '</div></div>';
					
					$x_write = $x_write. '</div>'; //.reviews_bx
						
					}	
					$x_write = $x_write. '</div></div></div>';
				}
				$x_write = $x_write.'<script>function reviewToggle(eleid){  var d = document.getElementById("review_bxfull-"+eleid); d.style.height = (d.style.height == "auto") ? "0px" : "auto"; }</script>';
				$x_write = $x_write.'</div>';
	
				// Cutomer Reviews Section End
				
			
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
	z-index:9999;
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

.history-tl-container{
	font-family: "Roboto",sans-serif;
	width:100%;
	margin:auto;
	display:block;
	position:relative;
	}
	.history-tl-container ul.tl{
		margin:0px 0 !important;
		padding:0;
		display:inline-block;

	}
	
	
	.history-tl-container ul.tl li{
		list-style: none;
		margin:auto;
		margin-left:80px;
		min-height:50px;
		/*background: rgba(255,255,0,0.1);*/
		border-left:1px dashed #86D6FF !important;
		padding:0 0 1px 30px;
		position:relative;
	}
	.history-tl-container .item-title > p{
		font-size:18px;
		margin: 0 !important;
		font-family: Work Sans, Arial, sans-serif;
	}
	.history-tl-container ul.tl li:last-child{ border-left:0;}
	.history-tl-container ul.tl li::before{
		position: absolute;
		left: -11px;
		top: -5px;
		content: " ";
		border: 8px solid rgba(255, 255, 255, 0.74);
		border-radius: 500%;
		background: #258CC7;
		height: 20px;
		width: 20px;
		transition: all 500ms ease-in-out;

	}
	.history-tl-container ul.tl li:hover::before{
		border-color:  #258CC7;
		transition: all 1000ms ease-in-out;
	}

	.history-tl-container ul.tl li .item-detail{
		color:rgba(0,0,0,0.5);
		font-size:14px;
	}
	.history-tl-container ul.tl li .timestamp{
		color: #8D8D8D;
		position: absolute;
	width:100px;
		left:-135px;
		top:-7px;
		text-align: right;
		font-size: 17px;
		font-family: Work Sans, Arial, sans-serif;
	}				
	.history-tl-container ul.tl li .item-title{
		color: #8D8D8D;
		position: inherit;
		top: -9px;
	}
	.mfp-star-rating {
		background-image:url("'.MFP_PLUGIN_URL.'imgs/stars.png");
		display: inline-block;
		height: 20px;
		background-repeat: no-repeat;
		width: 122px;
	}
	.mfp-star-5 {
		background-position:0;
	}
	.mfp-star-45 {
		background-position:-127px;
	}
	.mfp-star-4 {
		background-position:-256px;
	}
	.mfp-star-35 {
		background-position:-383px;
	}
	.mfp-star-3 {
		background-position:-521px;
	}
	.mfp-star-25 {
		background-position:-660px;
	}
	.mfp-star-2 {
		background-position:-798px;
	}
	.mfp-star-15 {
		background-position:-925px;
	}
	.mfp-star-1 {
		background-position:-1054px;
	}
	.mfp-star-05 {
		background-position:-1183px;
	}
	.mfp-star-0 {
		background-position:-1321px;
	}
	.review_bxrow {
		margin-bottom:10px;
	}
	.review_bxfull {
		height:0;
		display:block;
		overflow:hidden;
	}
	.review_bxrow span {
		font-size: 12px;
		line-height: 1.2;
	}
	.review_bxrow a {
		cursor: pointer;
	}
</style>';
			$updatecontent = $updatecontent."<style>a{color: #4DB7FE !important;}.site-content{padding-top:30px !important;}.whiteblock{box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);background: #fff;border-radius: 10px;z-index:-1;margin-right: 20px;padding: 15px 30px;border: 1px solid #e5e7f2;}body {background: #f6f6f6 !important;}.content {width: 80%;padding: 20px;padding: 0 60px 0 0;}.question {position: relative;background: lightgrey;padding: 10px 10px 10px 50px;display: block;width:100%;cursor: pointer;}.answers {padding: 0px 15px;margin: 5px 0;max-height: 0;overflow: hidden;z-index: 0;position: relative;opacity: 0;-webkit-transition: .7s ease;-moz-transition: .7s ease;-o-transition: .7s ease;transition: .7s ease;}.questions:checked ~ .answers{max-height: 500px;opacity: 1;padding: 15px;} .questions:checked ~ .custom-answer{ overflow-y: scroll;max-height:500px !important;} .plus {position: absolute;margin-left: 10px;z-index: 5;font-size: 2em;line-height: 100%;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;-webkit-transition: .3s ease;-moz-transition: .3s ease;-o-transition: .3s ease;transition: .3s ease;}.questions:checked ~ .plus {-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-o-transform: rotate(45deg);transform:rotate(45deg);}.questions {display: none;}#rightmenu {position: fixed;right: 0;top: 5%;width: 12em;margin-top: -2.5em;}.d-70{width:70%;float:left;}.d-30{width:30%;float:right;}@media only screen and (max-width: 767px) {.d-70{width:100%;}.d-30{width:100%;}.nomargins{margin-top:0px !important;margin-bottom:0px !important;}</style>";
			
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
				if ($new_cp_youtube == ""){
					$new_cp_youtube = "Unknown";
				}
			if ($new_cp_twitter == ""){
					$new_cp_twitter = "Unknown";
				}
			if ($new_cp_about == ""){
					$new_cp_about = "Unknown";
				}
				
			if ($new_cp_business_status == ""){
					$new_cp_business_status = "Unknown";
			}
			if ($new_cp_staffno == 0){
				$new_cp_staffno = "Unknown";
			}
			if($new_cp_founder == ""){
				$new_cp_founder = "Unknown";
			}
			if($new_cp_ceo == ""){
				$new_cp_ceo = "Unknown";
			}
			if ($new_cp_founded == ""){
				$new_cp_founded = "Unknown";
			}				
					
			/*Milestone Section Start */
			$cp_sql_milestones    = "SELECT * FROM ".$tablename_milestones." WHERE company_id=".intval($new_cp_id);
			$cp_result_milestones = $conn->query($cp_sql_milestones);
			if ($cp_result_milestones->num_rows > 0) {				
				while($row_milestones = $cp_result_milestones->fetch_assoc()) {
			    	$company_year = $row_milestones['milestone_year'];
			        	$company_name = $row_milestones['milestone_name'];
				    	$company_content = $row_milestones['milestone_content'];
				    	$company_milestone = $company_milestone.'<div class="history-tl-container">
							<ul class="tl">
								<li class="tl-item" ng-repeat="item in retailer_history">
									<div class="timestamp">'.$company_year.'<br></div>
									<div class="item-title"><p>'.$company_name.'</p></div>
									<div class="item-detail"><p>'.$company_content.'</p></div>
								</li>
							</ul>
							</div>';
					  /* Fetch Milestone End */
				  }
			}else{	
				$company_milestone ='<div class="history-tl-container">
						<ul class="tl">
							<li class="tl-item tl-else" ng-repeat="item in retailer_history">
								<div class="timestamp">'.$new_cp_founded.'<br></div>
								<div class="item-title"><p>'.$new_cp_asname.'. '.$new_cp_founded.'</p></div>
								<div class="item-detail"><p></p></div>
							</li>											
						</ul>
					</div>';				 
			}
			  
			/*Milestone Section End*/ 

			
			$updatecontent = $updatecontent.'<section class="d-70">';
			// Comapany Name & Product Review
			$updatecontent = $updatecontent.'<div class="whiteblock"><h1>'.$new_cp_asname.' | Product Reviews</h1>';
			if($new_cp_slogan !== ''){
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Slogan:</label><span style="padding-left:7px">'.$new_cp_slogan.'</span><br>';
			}
			$updatecontent = $updatecontent."Factory Location: ".$new_cp_region."      ";
			$updatecontent = $updatecontent.' | <a href="#userreviews">'.$result_reviews->num_rows.' Reviews</a> | <a href="#archivenews">'.$result_news->num_rows.' News</a><br></div>';
			$updatecontent = $updatecontent.'<hr style="width:50%;text-align:left;margin-left:0;margin-top:0px;border-top:0px;">';
			// Comapany Name & Product Review End
			if ($new_cp_business_status == "Closed permanently"){
				$updatecontent = $updatecontent."<div class='whiteblock' style='background-color: #f2dede; border: 4px solid #fff; padding: 0px 30px 12px 30px !important;'><h4 style='color: #a94442; line-height: 0.1; font-size: 14px;'><i class='fa fa-exclamation-circle' style='font-size:16px;color:red'></i> Removed Listing</h4>";
				$updatecontent = $updatecontent.'<span style="color: #a94442; font-size: 12px;">This business listing has been removed. Many factors might be considered: </span><ul style="color: #a94442; font-size: 12px;"><li> The company do not manufacture or sell solar materials any more.</li><li> The company is permanently closed.</li></ul>';
				$updatecontent = $updatecontent.'<span style="color: #a94442; font-size: 12px;">Sometimes a company is removed by mistake. If you are the owner of this company and you think SolarFeeds has made a mistake, please contact the Directory Manager at: content@solarfeeds.com</b></span>';
				$updatecontent = $updatecontent.'</div>';
			}	
			$updatecontent = $updatecontent.'<hr style="width:50%;text-align:left;margin-left:0;margin-top:0px;border-top:0px;">';
			$updatecontent = $updatecontent.$_POST['mycustomeditor'];
			// About Company
			$updatecontent = $updatecontent.'<div class="whiteblock"><h2>About '.$new_cp_asname.': </h2>';
			if($new_cp_vision !== ''){
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Vision:</label><span style="padding-left:7px">'.$new_cp_vision.'</span><br>';
			}
			$updatecontent = '<br>'.$updatecontent.$new_cp_about.'<br>';
			$updatecontent = $updatecontent.'</div><br>';
			$updatecontent = '<br>'.$updatecontent.$x_write.'<br>';
			$updatecontent = $updatecontent.$xx_write."<br>";
			$updatecontent = $updatecontent.'<div class="whiteblock" id="company_mile"><h2>Milestones for '.$new_cp_asname.': </h2>';
			$updatecontent = $updatecontent.$company_milestone;
			$updatecontent = $updatecontent."</div>";
					
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
			
			/*Comapany Info*/				
			$updatecontent = $updatecontent.'<div class="whiteblock">';
			$updatecontent = $updatecontent.'<h2 style="margin-top:10px !important;margin-bottom:10px !important">Company Info</h2>'.'<div>';
			$updatecontent = $updatecontent.'<label style="color:#000 !important;">Founded:</label><span style="padding-left:7px">'.$new_cp_founded.'</span><br>';
			$updatecontent = $updatecontent.'<label style="color:#000 !important;">Founder:</label><span style="padding-left:7px">'.$new_cp_founder.'</span><br>';	
			$updatecontent = $updatecontent.'<label style="color:#000 !important;">CEO:</label><span style="padding-left:7px">'.$new_cp_ceo.'</span><br>';	
			
			
			$updatecontent = $updatecontent.'<label style="color:#000 !important;">Manufacturer Size:</label><span style="padding-left:7px">'.$new_cp_staffno.'</span><br>';
			if($new_businesstype === 1){		
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Business Type:</label><span style="padding-left:7px">Distributor</span><br>';
			}elseif ($new_businesstype === 2) {
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Business Type:</label><span style="padding-left:7px">Manufacturer</span><br>';
			}				
			$updatecontent = $updatecontent."</div>";
			$updatecontent = $updatecontent."</div><br>";
			/*Comapny Info End */
			
			//Contact Info
			$updatecontent = $updatecontent.'<div class="whiteblock"><img src="'.$new_cp_image.'">';
			//$updatecontent = $updatecontent.'<h2 style="margin-top:10px !important;margin-bottom:10px !important">Contact Info</h2>'.'<div><a href="#"><i class="fa fa-building-o" aria-hidden="true"></i></a> '.$new_cp_address.'</div><div><a href="'.$new_cp_url.'"><i class="fa fa-globe" aria-hidden="true"></i></a> '.$new_cp_url.'</div><div><a href="tel:'.$new_cp_phone.'"><i class="fa fa-phone" aria-hidden="true"></i></a> '.$new_cp_phone.'</div>'.'<div><a href="mailto:'.$new_cp_email.'"><i class="fa fa-envelope"></i></a> '.$new_cp_email.'</div>'.'<div><a href="'.$new_cp_facebook.'"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> '.$new_cp_facebook.'</div>'.'<div><a href="'.$new_cp_linkedin.'"><i class="fa fa-linkedin" aria-hidden="true"></i></a> '.$new_cp_linkedin.'</div>'.'<div><a href="'.$new_cp_twitter.'"><i class="fa fa-twitter" aria-hidden="true"></i></a> '.$new_cp_twitter.'</div></div><br>';
			//$updatecontent = $updatecontent.'<div class="whiteblock"><h2 style="margin-top:10px !important;margin-bottom:10px !important">Product Information</h2><ul><li><a href="#">Company Size: </a><br>'.$new_cp_staffno.'</li>'.'<li><a href="#">Crystalline</a><br>'.$new_cp_crystalline.'<br>Power Range (Wp): '.$new_cp_cprl.'-'.$new_cp_cprh.'</li>'.'<li><a href="#">High Efficiency Crystalline</a><br>'.$new_cp_high_eff.'<br>Power Range (Wp): '.$new_cp_hecprl.'-'.$new_cp_hecprh.'</li>'.'</ul>';
			//$updatecontent = $updatecontent."</div>";
			$updatecontent = $updatecontent.'<h2 style="margin-top:10px !important;margin-bottom:10px !important">Contact Info</h2>'.'<div>';
				if($new_cp_facebook != 'Unknown'){
					$updatecontent = $updatecontent.'<span ><a target = "_blank" href="'.$new_cp_facebook.'" title="'.$new_cp_facebook.'"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></span>';
				}
				if($new_cp_linkedin != 'Unknown'){
					$updatecontent = $updatecontent.'<span style="padding-left:7px"> <a target = "_blank" href="'.$new_cp_linkedin.'" title="'.$new_cp_linkedin.'"><i class="fa fa-linkedin" aria-hidden="true"></i></a></span>';
				}
				if($new_cp_twitter != 'Unknown'){
					$updatecontent = $updatecontent.'<span style="padding-left:7px"><a target = "_blank" href="'.$new_cp_twitter.'" title="'.$new_cp_twitter.'"><i class="fa fa-twitter" aria-hidden="true"></i></a></span>';
				}
				if($new_cp_youtube != 'Unknown'){
					$updatecontent = $updatecontent.'<span style="padding-left:7px"><a target = "_blank" href="'.$new_cp_youtube.'" title="'.$new_cp_youtube.'"><i class="fa fa-youtube" aria-hidden="true"></i></a></span>';
				}
			$updatecontent = $updatecontent."</div>";
			$updatecontent = $updatecontent.'<div><a href="#"><i class="fa fa-building-o" aria-hidden="true"></i></a> '.$new_cp_address.'</div><div><a href="'.$new_cp_url.'"><i class="fa fa-globe" aria-hidden="true"></i></a> '.$new_cp_url.'</div><div><a href="tel:'.$new_cp_phone.'"><i class="fa fa-phone" aria-hidden="true"></i></a> '.$new_cp_phone.'</div>'.'<div><a href="mailto:'.$new_cp_email.'"><i class="fa fa-envelope"></i></a> '.$new_cp_email.'</div> </div><br>'.'<div class="whiteblock" style="display:none;"><h2 style="margin-top:10px !important;margin-bottom:10px !important">Product Information</h2><ul><li><a href="#">Manufacturer Size: </a><br>'.$new_cp_staffno.'</li>'.'<li><a href="#">Crystalline</a><br>'.$new_cp_crystalline.'<br>Power Range (Wp): '.$new_cp_cprl.'-'.$new_cp_cprh.'</li>'.'<li><a href="#">High Efficiency Crystalline</a><br>'.$new_cp_high_eff.'<br>Power Range (Wp): '.$new_cp_hecprl.'-'.$new_cp_hecprh.'</li>'.'</ul>';
			$updatecontent = $updatecontent."</div>";
			// Contact Info End

			// Claimed Section Start
			if($new_cp_claimed != 0){
				$updatecontent = $updatecontent.'<div class="whiteblock"><i style="font-size: 20;color: green;" class="fas fa-check-circle"></i>&nbsp;<p style="font-size:20px;display:inline;" >Claimed</p></div><br>';
			}else{
				$updatecontent = $updatecontent.'<div class="whiteblock"><i style="font-size: 20;color: red;" class="fas fa-times-circle"></i>&nbsp;<p style="font-size:20px;display:inline;">Claimed</p></div><br>';
			}
			// Claimed Section End

			$updatecontent = $updatecontent.'<div class="whiteblock"><br>Own or work here? <a href="https://solarfeeds.com/claim-your-mnfctr-page/">Claim Now!</a> <br><br></div><br>';
			
			if(count($related_profiles)> 0){
			$updatecontent = $updatecontent.'<div class="whiteblock"><h2> Related Profiles</h2>';
				foreach($related_profiles as $related){
					$id    = $related["ID"];
					$c_url = str_replace(",","",$related["name"]);
					$c_url = str_replace(".","",$c_url);
					$c_url = str_replace(' ', '-', $c_url);
					$x[$id]   = $c_url;
				  $updatecontent = $updatecontent.'<a href="https://shop.solarfeeds.com/brands/'.$c_url.'">'.$related["name"].'</a></br>';
					 }
				
			$updatecontent = $updatecontent.'<br><br></div><br>';
		    }   

			$updatecontent = $updatecontent. "</aside>";	
					
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
