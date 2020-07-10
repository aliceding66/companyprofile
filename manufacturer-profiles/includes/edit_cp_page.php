<?php
     
    // Create connection
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$tablename         = "company_profile_short";
	$tablename_details = "company_profile";
	$tablename_reviews = "company_profile_reviews";
	$tablename_news    = "company_profile_news";
	$tablename_milestones    = "company_profile_milestones";
	$tablename_projects    = "company_profile_projects";
	$tablename_project_cat   = "company_profile_project_category";
	
    $cp_id             = $_GET['company_id'];
	
	if($_POST && isset($_POST['updatecpid'])){
		if (isset($_GET['company_id'])){	
			
			$cp_sql_news    = "SELECT * FROM ".$tablename_news." WHERE company_id = ".$cp_id;
			$cp_result_news = $conn->query($cp_sql_news);

			if ($cp_result_news->num_rows > 0) {
				$cp_sql_news_delete    ="DELETE FROM ".$tablename_news." WHERE company_id = ".$cp_id;
				$cp_result_news_delete = $conn->query($cp_sql_news_delete);
			}
			
			$cp_sql_reviews     = "SELECT * FROM ".$tablename_reviews." WHERE company_id = ".$cp_id;
			$cp_result_reviews  = $conn->query($cp_sql_reviews);

			if ($cp_result_reviews->num_rows > 0) {
				$cp_sql_reviews_delete    ="DELETE FROM ".$tablename_reviews." WHERE company_id = ".$cp_id;
				$cp_result_reviews_delete = $conn->query($cp_sql_reviews_delete);
			}
			
			$cp_sql_milestones     = "SELECT * FROM ".$tablename_milestones." WHERE company_id = ".$cp_id;
			$cp_result_milestones  = $conn->query($cp_sql_milestones);

			if ($cp_result_milestones->num_rows > 0) {
				$cp_sql_milestones_delete    ="DELETE FROM ".$tablename_milestones." WHERE company_id = ".$cp_id;
				$cp_result_milestones_delete = $conn->query($cp_sql_milestones_delete);
			}
			
			$cp_sql_projects     = "SELECT * FROM ".$tablename_projects." WHERE company_id = ".$cp_id;
			$cp_result_projects  = $conn->query($cp_sql_projects);

			if ($cp_result_projects->num_rows > 0) {
				$cp_sql_projects_delete    ="DELETE FROM ".$tablename_projects." WHERE company_id = ".$cp_id;
				$cp_result_projects_delete = $conn->query($cp_sql_projects_delete);
			}
			
			$related_profiles = realted_manufacturer($_POST['cpregion'], $_POST['cpcomtype'], $_POST['cpcrystalline'],$_GET['company_id']);
			// print_r($related_profiles);
			// exit(); 


			// Condition for Company name
			if(empty($_POST['cpasname'])){
				$final_company_name = $_POST['cpname'];
			}else{
				$final_company_name = $_POST['cpasname'];
			}
			// Condition for company name end

			$xxxx = 1;
			$xxxx_write = '<div class="whiteblock" id="archiveprojects"><h2>Archive Solar Projects for '.$_POST['cpname'].': </h2><div class="content">';
			$is_projects  = 0;

			while(isset($_POST['cpsolarprojectsno'.$xxxx]) && ($_POST['cpsolarprojectsno'.$xxxx] != '')) {
    			$cp_sql_projects_update       = "INSERT INTO ".$tablename_projects." (company_id, project_cat_id,model_no) VALUES (".$cp_id.", ".$_POST['cpsolarprojectscat'.$xxxx].", '".$_POST['cpsolarprojectsno'.$xxxx]."');";
				$cp_result_projects_update = $conn->query($cp_sql_projects_update);
				var_dump($cp_sql_projects_update );
				
				$xxxx_write  = $xxxx_write.'<div>';
				$xxxx_write  = $xxxx_write.'<input type="checkbox" id="question'.$xxxx.'" name="q" class="questions"><div class="plus">+</div><label for="question'.$xx.'" class="question">'.$_POST['cpsolarprojectsno'.$xxxx].'</label>';
				$xxxx_write  = $xxxx_write.'<div class="answers">'.str_replace('\"','',$_POST['cpsolarprojectsno'.$xxxx]).'</div>';
				$xxxx_write  = $xxxx_write.'</div>';
    			$xxxx++;
				$is_projects = 1;
            }
            
			if ($is_projects == 1) {
                $xxxx_write = $xxxx_write.'</div></div>';
            }

			$xxx = 1;
			$xxx_write = '<div class="whiteblock" id="milestones"><h2>Milestone for '.$_POST['cpname'].': </h2><div class="content">';
			$is_milestones  = 0;

			while(isset($_POST['cpmilestonesname'.$xxx]) && ($_POST['cpmilestonesname'.$xxx] != '') && ($_POST['cpmilestonesyear'.$xxx] != '')) {
    			$cp_sql_milestones_update       = "INSERT INTO ".$tablename_milestones." (company_id, milestone_id, milestone_year,milestone_name, milestone_content	) VALUES (".$cp_id.", ".$xxx.",".$_POST['cpmilestonesyear'.$xxx].", '".$_POST['cpmilestonesname'.$xxx]."', '".$_POST['cpmilestonescontent'.$xxx]."');";
				$cp_result_milestones_update = $conn->query($cp_sql_milestones_update);
				
				$xxx_write  = $xxx_write.'<div>';
				$xxx_write  = $xxx_write.'<input type="checkbox" id="question'.$xxx.'" name="q" class="questions"><div class="plus">+</div><label for="question'.$xxx.'" class="question">'.$_POST['cpmilestonesyear'.$xxx].'</label>';
				$xxx_write  = $xxx_write.'<div class="answers">'.$_POST['cpmilestonesname'.$xxx].'<br><br>'.str_replace('\"','',$_POST['cpmilestonescontent'.$xxx]).'</div>';
				$xxx_write  = $xxx_write.'</div>';
    			$xxx++;
				$is_milestones = 1;
            }
            
			if ($is_milestones == 1) {
                $xxx_write = $xxx_write.'</div></div>';
            }



			$xx = 1;
			// Archive News for Company		
			$xx_write = '<div class="whiteblock" id="archivenews"><h2>Archive News for '.$final_company_name.': </h2><div class="content">';			
			$is_news  = 0;

			while(isset($_POST['cpnewsname'.$xx]) && ($_POST['cpnewsname'.$xx] != '') && ($_POST['cpnewscontent'.$xx] != '')) {
    			$cp_sql_news_update       = "INSERT INTO ".$tablename_news." (company_id, news_id, date,title, content) VALUES (".$cp_id.", ".$xx.",2020".", '".$_POST['cpnewsname'.$xx]."', '".$_POST['cpnewscontent'.$xx]."');";
				$cp_result_reviews_update = $conn->query($cp_sql_news_update);
				
				$xx_write  = $xx_write.'<div>';
				$xx_write  = $xx_write.'<input type="checkbox" id="question'.$xx.'" name="q" class="questions"><div class="plus">+</div><label for="question'.$xx.'" class="question">'.$_POST['cpnewsname'.$xx].'</label>';
				$xx_write  = $xx_write.'<div class="answers">'.str_replace('\"','',$_POST['cpnewscontent'.$xx]).'</div>';
				$xx_write  = $xx_write.'</div>';
    			$xx++;
				$is_news = 1;
            }
            
			if ($is_news == 1) {
                $xx_write = $xx_write.'</div></div>';
            }
			
			$x = 1;
			$is_review = 0;
			/* Reviews For Company */
			$x_write   = '<div class="whiteblock" id="userreviews"><h2 style="margin-bottom:0px !important;">Reviews for '.$final_company_name.": </h2>";
			/* Reviews for company end */
			
			while(isset($_POST['cpreviewname'.$x])) {
				$x_write                  = $x_write.'<br>';
    			$cp_sql_reviews_update    = "INSERT INTO ".$tablename_reviews." (company_id, review_id, review_name, review_content) VALUES (".$cp_id.", ".$x.", '".$_POST['cpreviewname'.$x]."', '".$_POST['cpreviewcontent'.$x]."');";
				$cp_result_reviews_update = $conn->query($cp_sql_reviews_update);
				$x_write                  = $x_write.$_POST['cpreviewname'.$x].'<br>';
				$x_write                  = $x_write.$_POST['cpreviewcontent'.$x]."<br>";
				$is_review                = 1;
    			$x++;
			}

			if ($is_news == 1) {
				$x_write=$x_write.'</div>';
			}else {
				$x_write=$x_write.'</div>';
			}	
			
			$cp_sql_details_check     = "SELECT * FROM ".$tablename_details." WHERE company_id = ".$cp_id;
			$cp_result_details_check  = $conn->query($cp_sql_details_check);
			
			if ($cp_result_details_check->num_rows > 0) {
				$new_cp_name              = $_POST['cpname'];
				$new_cp_asname     		  = $_POST['cpasname'];
				$new_cp_founded     	  = $_POST['cpfounded'];
				$new_cp_founder     	  = $_POST['cpfounder'];
				$new_cp_ceo    	 		  = $_POST['cpceo'];
				$new_cp_address           = $_POST['cpaddress'];
				$new_cp_phone             = $_POST['cpphone'];
				$new_cp_image             = basename($_FILES["fileToUpload"]["name"]);
				$new_cp_email             = $_POST['cpemail'];
				$new_cp_url               = $_POST['cpurl'];
				$new_cp_region            = $_POST['cpregion'];
				$new_cp_facebook          = $_POST['cpfacebook'];
				$new_cp_linkedin          = $_POST['cplinkedin'];
				$new_cp_twitter           = $_POST['cptwitter'];
				$new_cp_youtube           = $_POST['cpyoutube'];
				$new_cp_slogan  		  = $_POST['cpslogan'];
				$new_cp_vision    		  = $_POST['cpvision'];

				$new_cp_about             = str_replace('\"','',$_POST['cpabout']); 
				$new_cp_trading_cap   	  = intval($_POST['cptrading_cap']);
				$new_cp_respond   		  = floatval($_POST['cprespond']);

				$new_cp_staffno           = intval($_POST['cpstaff_no']);
				$new_businesstype		  = intval($_POST['cpbusiness_type']);
				$new_cp_crystalline       = $_POST['cpcrystalline'];
				$new_cp_cprl              = $_POST['cpcprl'];
				$new_cp_cprh              = $_POST['cpcprh'];
				$new_cp_high_eff          = $_POST['cphigh_eff'];
				$new_cp_hecprl            = $_POST['cphecprl'];
				$new_cp_hecprh            = $_POST['cphecprh'];
				$new_cp_business_status   = $_POST['cpbusiness_status'];
				$new_cp_comptype   		  = $_POST['cpcomtype'];
				$new_cp_me                = $_POST['cpme'];
				
				$cp_sql_details_update    = "UPDATE ".$tablename_details." SET business_type=".$new_businesstype.", staff_no=".$new_cp_staffno.",crystalline='".$new_cp_crystalline."',cprl=".$new_cp_cprl.",cprh='".$new_cp_cprh."', high_eff='".$new_cp_high_eff."',hecprl='".$new_cp_hecprl."', hecprh='".$new_cp_hecprh."', com_type='".$new_cp_comptype."', mounting_eq='".$new_cp_me."' WHERE company_id=".$cp_id;
				$cp_result_details_update = $conn->query($cp_sql_details_update);
				
				//var_dump($cp_sql_details_update);

            }
            
			$file["url"] = $_POST['cimage'];
						
			if (( isset( $_POST['example-jpg-file-new'] ) ) && ($_POST['example-jpg-file-new'] != '')) {						
					$file["url"] = $_POST['example-jpg-file-new'];
						
					if ( $file['error'] == "Empty filename") {	  
						$file["url"] = $_POST['cimage'];	  
					}
			}
				
			else {
					
					if (( isset($_POST['example-jpg-file'] ) ) && ($_POST['example-jpg-file'] != '')){						
						$file["url"] = $_POST['example-jpg-file'];
			
						if ( $file['error'] == "Empty filename") {	  
							$file["url"]= $_POST['cimage'];
						}			    					
                    }
                    else{
					    $file["url"]= $_POST['cimage'];
				        }
			    }
				
			if ($cp_result_check->num_rows > 0) {
				$new_cp_name      = $_POST['cpname'];
				$new_cp_parentname = $_POST['cpparentname'];
				$new_cp_asname      = $_POST['cpasname'];
				$new_cp_founded      = $_POST['cpfounded'];
				$new_cp_founder     = $_POST['cpfounder'];
				$new_cp_ceo     = $_POST['cpceo'];
				$new_cp_image     = $file["url"];
				$new_cp_address   = $_POST['cpaddress'];
				$new_cp_phone     = $_POST['cpphone'];
				$new_cp_email     = $_POST['cpemail'];
				$new_cp_url       = $_POST['cpurl'];
				$new_cp_region    = $_POST['cpregion'];
				$new_cp_facebook  = $_POST['cpfacebook'];
				$new_cp_linkedin  = $_POST['cplinkedin'];
				$new_cp_twitter   = $_POST['cptwitter'];
				$new_cp_youtube   = $_POST['cpyoutube'];
				$new_cp_trading_cap   = intval($_POST['cptrading_cap']);
				$new_cp_business_status = $_POST['cpbusiness_status'];
				$new_cp_about     = str_replace('\"','',$_POST['cpabout']); 
				$new_cp_cpcomtype	  = $_POST['cpcomtype'];
				$new_cp_respond   	  = floatval($_POST['cprespond']);
				$new_cp_slogan    = $_POST['cpslogan'];
				$new_cp_vision    = $_POST['cpvision'];
				
			}

			
			
            
			$old_product_no   = $_POST['cpoldname'];
			$cp_sql_update    = "UPDATE ".$tablename." SET name='".$new_cp_name."', parent_company='".$new_cp_parentname."', as_name='".$new_cp_asname."', founded='".$new_cp_founded."', founder='".$new_cp_founder."', ceo='".$new_cp_ceo."', address='".$new_cp_address."',phone='".$new_cp_phone."',email='".$new_cp_email."', url='".$new_cp_url."', region='".$new_cp_region."', facebook='".$new_cp_facebook."', linkedin='".$new_cp_linkedin."', twitter='".$new_cp_twitter."',youtube='".$new_cp_youtube."', trading_capacity=".$new_cp_trading_cap.", respond=".$new_cp_respond.", slogan='".$new_cp_slogan."', vision='".$new_cp_vision."', company_image='".$file["url"]."', about='".$new_cp_about."',status='".$new_cp_business_status."' WHERE company_id=".$cp_id;
			$cp_result_update = $conn->query($cp_sql_update);
				
			if ($cp_result_update){
					
				echo '<span style="color:red;">Update Success! </span><br>';
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

				$updatecontent = $updatecontent."<style>.page-breadcrumbs{display:none !important;}.relatedprofiles a{font-size: 14px !important;} a{color: #4DB7FE !important;}.site-content{padding-top:30px !important;}.whiteblock{box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);background: #fff;border-radius: 10px;z-index:-1;margin-right: 20px;padding: 15px 30px;border: 1px solid #e5e7f2;}body {background: #f6f6f6 !important;}.content {width: 100%;padding: 20px;padding: 0 60px 0 0;}.question {position: relative;background: lightgrey;padding: 10px 10px 10px 50px;display: block;width:100%;cursor: pointer;}.answers {padding: 0px 15px;margin: 5px 0;max-height: 0;overflow: hidden;z-index: 0;position: relative;opacity: 0;-webkit-transition: .7s ease;-moz-transition: .7s ease;-o-transition: .7s ease;transition: .7s ease;}.questions:checked ~ .answers{max-height: max-content;opacity: 1;padding: 15px;}.plus {position: absolute;margin-left: 10px;z-index: 5;font-size: 2em;line-height: 100%;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;-webkit-transition: .3s ease;-moz-transition: .3s ease;-o-transition: .3s ease;transition: .3s ease;}.questions:checked ~ .plus {-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-o-transform: rotate(45deg);transform:rotate(45deg);}.questions {display: none;}#rightmenu {position: fixed;right: 0;top: 5%;width: 12em;margin-top: -2.5em;}.d-70{width:70%;float:left;}.d-30{width:30%;float:right;}@media only screen and (max-width: 767px) {.d-70{width:100%;}.d-30{width:100%;}.nomargins{margin-top:0px !important;margin-bottom:0px !important;}</style>";
				//top edit bar	
				//if ( is_user_logged_in() ) {
				$edit_url= get_site_url()."/wp-admin/admin.php?page=cpcustomsubpage&company_id=".$cp_id;
				$add_url = get_site_url()."/wp-admin/admin.php?page=cpcreatepage";
				$admin_url = get_site_url()."/wp-admin";
				$updatecontent = $updatecontent."<?php if ( is_user_logged_in() ) { ?>";
				$updatecontent = $updatecontent."<div id='mfp-topbar'><ul><li><a href='".$edit_url."'>Edit this page</a> |</li><li><a href='".$add_url."'>Add a new profile</a> |</li><li><a href='".$admin_url."'>WP Dashboard</a></li></ul></div>";
				$updatecontent = $updatecontent."<?php } ?>";
				//}
				if ($new_cp_name == ""){
					$new_cp_name = "Unknown";
				}
				if ($new_cp_asname == ""){
					$new_cp_asname = "Unknown";
				}
				if ($new_cp_founded == ""){
					$new_cp_founded = "Unknown";
				}
				if ($new_cp_founder == ""){
					$new_cp_founder = "Unknown";
				}
				if ($new_cp_ceo == ""){
					$new_cp_ceo = "Unknown";
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
				if ($new_cp_youtube == ""){
					$new_cp_youtube = "Unknown";
				}
				if ($new_cp_about == ""){
					$new_cp_about = "Unknown";
				}

				if ($new_cp_trading_cap == ""){
					$new_cp_trading_cap = "Unknown";
				}

				if ($new_cp_respond  == ""){
					$new_cp_respond  = "Unknown";
				}
					
				if ($new_cp_staffno == 0){
					$new_cp_staffno = "Unknown";
				}
				if ($new_businesstype == 0){
					$new_businesstype = "Unknown";
				}
				
				if ($new_cp_crystalline == ""){
					$new_cp_crystalline = "Unknown";
				}
				if ($new_cp_cprl == ""){
					$new_cp_cprl = "Unknown";
				}
				if ($new_cp_cprh == ""){
					$new_cp_cprh = "Unknown";
				}
				if ($new_cp_high_eff == ""){
					$new_cp_high_eff = "Unknown";
				}
				if ($new_cp_hecprl == ""){
					$new_cp_hecprl = "Unknown";
				}
				if ($new_cp_hecprh == ""){
					$new_cp_hecprh = "Unknown";
				}	
						
				if ($new_cp_crystalline == "0"){
					$new_cp_crystalline = "Unknown";
				}
				if ($new_cp_cprl == "0"){
					$new_cp_cprl = "Unknown";
				}
				if ($new_cp_cprh == "0"){
					$new_cp_cprh = "Unknown";
				}
				if ($new_cp_high_eff == "0"){
					$new_cp_high_eff = "Unknown";
				}
				if ($new_cp_hecprl == "0"){
					$new_cp_hecprl = "Unknown";
				}
				if ($new_cp_hecprh == "0"){
					$new_cp_hecprh = "Unknown";
				}
				if ($new_cp_business_status == ""){
					$new_cp_business_status = "Unknown";
				}
				// Comapany Name & Product Review	
				$updatecontent = $updatecontent.'<section class="d-70">';
				$updatecontent = $updatecontent.'<div class="whiteblock"><h1>'.$final_company_name.' | Product Reviews</h1>';				
				$updatecontent = $updatecontent."Factory Location: ".$new_cp_region."      ";
				$updatecontent = $updatecontent.' | <a href="#userreviews">'.strval($x-1).' Reviews</a> | <a href="#archivenews">'.strval($xx-1)." News</a><br></div>";					
				$updatecontent = $updatecontent.'<hr style="width:50%;text-align:left;margin-left:0;margin-top:0px;border-top:0px;">';
				// Comapany Name & Product Review End
				if ($new_cp_business_status == "Closed permanently"){
					$updatecontent = $updatecontent."<div class='whiteblock' style='background-color: #f2dede; border: 4px solid #fff; padding: 0px 30px 12px 30px !important;'><h4 style='color: #a94442; line-height: 0.1; font-size: 14px;'><i class='fa fa-exclamation-circle' style='font-size:16px;color:red'></i> Removed Listing</h4>";
					$updatecontent = $updatecontent.'<span style="color: #a94442; font-size: 12px;">This business listing has been removed. Many factors might be considered: </span><ul style="color: #a94442; font-size: 12px;"><li> The company do not manufacture or sell solar materials any more.</li><li> The company is permanently closed.</li></ul>';
					$updatecontent = $updatecontent.'<span style="color: #a94442; font-size: 12px;">Sometimes a company is removed by mistake. If you are the owner of this company and you think SolarFeeds has made a mistake, please contact the Directory Manager at: info@solarfeeds.com</b></span>';
					$updatecontent = $updatecontent.'</div>'; 
				 } 
				$updatecontent = $updatecontent.'<hr style="width:50%;text-align:left;margin-left:0;margin-top:0px;border-top:0px;">';
				$updatecontent = $updatecontent.$_POST['mycustomeditor'];
				// About Company
				$updatecontent = $updatecontent.'<div class="whiteblock"><h2>About '.$final_company_name.": </h2>".$final_company_name."</div><br>";			
				$updatecontent = '<br>'.$updatecontent.$x_write.'<br>';
				$updatecontent = $updatecontent.$xx_write."<br>";
				$updatecontent = $updatecontent."</section>";
					
				$updatecontent = $updatecontent.'<aside class="d-30">';
				$updatecontent = $updatecontent.'<div class="whiteblock" style="padding: 0;"><a href="'.get_site_url().'/list-your-business/ "><img src="'.get_site_url().'/wp-content/uploads/2019/08/Add-a-heading.png"></a></div><br>';
				
				/*Comapany Info*/				
				$updatecontent = $updatecontent.'<div class="whiteblock">';
				$updatecontent = $updatecontent.'<h2 style="margin-top:10px !important;margin-bottom:10px !important">Company Info</h2>'.'<div>';
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Founded:</label><span style="padding-left:7px">'.$new_cp_founded.'</span><br>';
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Founder:</label><span style="padding-left:7px">'.$new_cp_founder.'</span><br>';	
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">CEO:</label><span style="padding-left:7px">'.$new_cp_ceo.'</span><br>';	
				if($new_cp_slogan !== ''){
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Slogan:</label><span style="padding-left:7px">'.$new_cp_slogan.'</span><br>';
				}
				if($new_cp_vision !== ''){
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Vision:</label><span style="padding-left:7px">'.$new_cp_vision.'</span><br>';
				}
				$updatecontent = $updatecontent.'<label style="color:#000 !important;">Manufacturer Size:</label><span style="padding-left:7px">'.$new_cp_staffno.'</span><br>';
				if($new_businesstype === 1){		
					$updatecontent = $updatecontent.'<label style="color:#000 !important;">Business Type:</label><span style="padding-left:7px">Distributor</span><br>';
				}elseif ($new_businesstype === 2) {
					$updatecontent = $updatecontent.'<label style="color:#000 !important;">Business Type:</label><span style="padding-left:7px">Manufacturer</span><br>';
				}				
				$updatecontent = $updatecontent."</div>";
				$updatecontent = $updatecontent."</div><br>";
				/*Comapny Info End */
				
				$updatecontent = $updatecontent.'<div class="whiteblock">';
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
					$updatecontent = $updatecontent.'<span style="padding-left:7px"><a target = "_blank" href="'.$new_cp_youtube.'" title="'.$new_cp_youtube.'"></a></span>';
				}
				$updatecontent = $updatecontent."</div>";
				$updatecontent = $updatecontent.'<div><a href="#"><i class="fa fa-building-o" aria-hidden="true"></i></a> '.$new_cp_address.'</div><div><a href="http://'.$new_cp_url.'"><i class="fa fa-globe" aria-hidden="true"></i></a> '.$new_cp_url.'</div><div><a href="tel:'.$new_cp_phone.'"><i class="fa fa-phone" aria-hidden="true"></i></a> '.$new_cp_phone.'</div>'.'<div><a href="mailto:'.$new_cp_email.'"><i class="fa fa-envelope"></i></a> '.$new_cp_email.'</div> </div><br>'.'<div class="whiteblock" style="display:none;"><h2 style="margin-top:10px !important;margin-bottom:10px !important">Product Information</h2><ul><li><a href="#">Manufacturer Size: </a><br>'.$new_cp_staffno.'</li>'.'<li><a href="#">Crystalline</a><br>'.$new_cp_crystalline.'<br>Power Range (Wp): '.$new_cp_cprl.'-'.$new_cp_cprh.'</li>'.'<li><a href="#">High Efficiency Crystalline</a><br>'.$new_cp_high_eff.'<br>Power Range (Wp): '.$new_cp_hecprl.'-'.$new_cp_hecprh.'</li>'.'</ul>';
				$updatecontent = $updatecontent."</div>";
				

				$updatecontent = $updatecontent.'<div class="whiteblock"><br>Own or work here? <a href="'.get_site_url().'/claim-your-mnfctr-page/" target="_blank">Claim Now!</a> <br><br></div><br>';
				
				if(count($related_profiles)> 0){
				$updatecontent = $updatecontent.'<div class="whiteblock relatedprofiles"><br><h2> Related Profiles</h2>';
					foreach($related_profiles as $related){
					$c_url = str_replace(",","",$related["name"]);
					$c_url = str_replace(".","",$c_url);
					$c_url = str_replace(' ', '-', $c_url);
					$updatecontent = $updatecontent.'<a href="'.get_site_url().'/brands/'.$c_url.'">'.$related["name"].'</a></br>';
					}
				
				$updatecontent = $updatecontent.'<br><br></div><br>';
			}
				$updatecontent = $updatecontent. "</aside>";
	
				$updatecontent = $updatecontent."<?php get_footer(); ?>";
			
				$new_cp_name = str_replace(",","",$new_cp_name);
				$new_cp_name = str_replace(' ', '-', $new_cp_name);
				$new_cp_name = str_replace('.', '', $new_cp_name);

				$writefoldername = $_SERVER['DOCUMENT_ROOT']."/brands/".$new_cp_name;
				$oldfoldername   = $_SERVER['DOCUMENT_ROOT']."/brands/".$old_product_no;
				
					if (!file_exists($writefoldername)) {
    					mkdir($writefoldername, 0777, true);
						rmdir($oldfoldername, 0777, true); 
					}
					
				$writefilename = $writefoldername."/index.php";
				$writefile     = file_put_contents($writefilename,$updatecontent);
			}
				else {echo "Update Failed! <br>";}
		}

	}
	
	$tablename_details = "company_profile";
	$tablename_review  = "company_profile_reviews";
	$tablename_news    = "company_profile_news";
	
	$cp_name           = $_POST['cpname'];
	$cp_sql            = "SELECT * FROM ".$tablename." WHERE company_id=".$cp_id;
    $cp_result         = $conn->query($cp_sql);
	
	$cp_sql_detail     = "SELECT * FROM ".$tablename_details." WHERE company_id=".$cp_id;
    $cp_result_detail  = $conn->query($cp_sql_detail);

	
	
	if ($cp_result_detail->num_rows > 0) {
   
        while($row_detail = $cp_result_detail->fetch_assoc()) {

			$update_cp_staffno      = intval($row_detail['staff_no']);
			
			$update_cp_businesstype = intval($row_detail['business_type']);
			$update_cp_crystalline  = $row_detail['crystalline'];
			$update_cp_cproduction  = $row_detail['c_production'];
			$update_cp_cprl         = $row_detail['cprl'];
			$update_cp_cprh         = $row_detail['cprh'];
			$update_cp_high_eff     = $row_detail['high_eff'];
			$update_cp_chproduction = $row_detail['h_production'];
			$update_cp_hecprl       = $row_detail['hecprl'];
			$update_cp_hecprh       = $row_detail['hecprh'];
			$update_cp_cis          = $row_detail['cis'];
			$update_cp_bipv         = $row_detail['bipv'];
			$update_cp_bipv_prod    = $row_detail['bipv_production'];
			$update_cp_bipvl        = $row_detail['bipvl'];
			$update_cp_bipvh        = $row_detail['bipvh'];
			$update_cp_flexible     = $row_detail['bipv_flexible'];
			$update_cp_comptype     = $row_detail['com_type'];
			$update_cp_me           = $row_detail['mounting_eq'];
		}
	}
	
	

    if ($cp_result->num_rows > 0) {
   
        while($row = $cp_result->fetch_assoc()) {

			

			echo '<style>
			.mfp-editbox {
				display: flex;
				flex-wrap: wrap;
			}
			.mfp-edit-left {
				-ms-flex: 0 0 70%;
				flex: 0 0 70%;
				max-width: 70%;
			}
			.mfp-edit-right {
				-ms-flex: 0 0 30%;
				flex: 0 0 30%;
				max-width: 30%;
			}
			.mfp-update-box {
				box-shadow: hsl(0, 0%, 80%) 0 0 16px;
				padding: 20px;
				margin-right: 15px;
				position:fixed;
				
			}
			#btn_delete{
				background: aliceblue;
				color:black;
    			border: none !important;
    		}
    		#btn_delete:hover{
    			background: cadetblue;
    			color: white;
    			border: none !important;
    			cursor: pointer;
    		}
			</style>
			';
			echo '<br>';
			echo '<div style="font-size:18px;">Company '.$row["name"].' Page</div>';
			echo '<br>';
	
			echo '<form action="" method="POST" onsubmit="setFormSubmitting()" enctype="multipart/form-data">';
			echo '<div class="mfp-editbox">';
			echo '<div class="mfp-edit-left">';
			echo '<input id="updatecpid" name="updatecpid" type="hidden" value="1">';
    		echo '<input type="hidden" id="cpoldname" name="cpoldname" value="'. $row["name"].'">';
			echo '<label for="cpname">Manufacturer Name: </label>';
    		echo '<input type="text" id="cpname" name="cpname" value="'. $row["name"].'"> <br><br>';

    		echo '<label for="cpasname">Do Business As: </label>';
            echo '<input type="text" id="cpasname" name="cpasname" value="'. $row["as_name"].'"><br><br>';

			echo '<label for="cpname">Parent Manufacturer Name: </label>';
    		echo '<input type="text" id="cpparentname" name="cpparentname" value="'. $row["parent_company"].'"> <br><br>';
			

			echo '<label for="cpfounded">Founded: </label></td>';
            echo '<input type="text" id="cpfounded" name="cpfounded" value="'. $row["founded"].'"><br><br>';

            echo '<label for="cpfounder">Founder(s): </label></td>';
            echo '<input type="text" id="cpfounder" name="cpfounder" value="'. $row["founder"].'"><br><br>';

            echo '<label for="cpceo">CEO: </label></td>';
            echo '<input type="text" id="cpceo" name="cpceo" value="'. $row["ceo"].'"><br><br>';

            echo '<label for="cpslogan">Slogan: </label></td>';
            echo '<textarea id="cpslogan" name="cpslogan" rows="1" cols="80">'.$row["slogan"].'</textarea><br><br>';

            echo '<label for="cpvision">Vision/Mission Statement: </label></td>';
            echo '<textarea id="cpvision" name="cpvision" rows="4" cols=80">'.$row["vision"].'</textarea><br><br>';


            /** Manufacturer Profile update_Table1 */
			echo '<table>';
			echo '<tr><td><label for="cpname">Manufacturing: </label></td>';
            echo '<td><input type="text" id="cpmanuf" name="cpmanuf" value="'. $row["manuf"].'"> </td></tr>';
            
            echo '<tr><td><label for="cpaddress">Address: </label></td>';
            echo '<td><input type="text" id="cpaddress" name="cpaddress" value="'. $row["address"].'"></td></tr>';
            
            echo '<tr><td><label for="cpphone">Phone: </label></td>';
            echo '<td><input type="text" id="cpphone" name="cpphone" value="'. $row["phone"].'"></td></tr>';
			
			echo '<tr><td><label for="cpemail">Email: </label></td>';
            echo '<td><input type="text" id="cpemail" name="cpemail" value="'. $row["email"].'"></td></tr>';
            
			echo '<tr><td><label for="cpurl">Url: </label></td>';
            echo '<td><input type="text" id="cpurl" name="cpurl" value="'. $row["url"].'"></td></tr>';
            
			echo '<tr><td><label for="cpregion">Region: </label></td>';
            echo '<td><input type="text" id="cpregion" name="cpregion" value="'. $row["region"].'"></td></tr>';
            
			echo '<tr><td><label for="cpfacebook">Facebook: </label></td>';
            echo '<td><input type="text" id="cpfacebook" name="cpfacebook" placeholder="https://www.facebook.com" value="'. $row["facebook"].'"></td></tr>';
            
			echo '<tr><td><label for="cplinkedin">Linkedin: </label></td>';
            echo '<td><input type="text" id="cplinkedin" name="cplinkedin" placeholder="https://www.linkedin.com" value="'. $row["linkedin"].'"></td></tr>';
            
			echo '<tr><td><label for="cptwitter">Twitter: </label></td>';
			echo '<td><input type="text" id="cptwitter" name="cptwitter" placeholder="https://twitter.com"  value="'. $row["twitter"].'"></td></tr>';
			
			echo '<tr><td><label for="cpyoutube">YouTube: </label></td>';
			echo '<td><input type="text" id="cpyoutube" name="cpyoutube" placeholder="https://www.youtube.com"  value="'. $row["youtube"].'"></td></tr>';

			echo '<tr><td><label for="cptrading_cap">Trading Capacity: </label></td><td><input type="text" id="cptrading_cap" name="cptrading_cap" value="'. $row["trading_capacity"].'">&nbsp;Watts</td></tr>';


			echo '<tr><td><label for="corespond">Average Respond Time: </label></td><td><input type="text" id="cprespond" name="cprespond" value="'. $row["respond"].'">&nbsp;Hours</td></tr>';
            echo '</table>';
			echo '<label for="cpabout"><h2>About: </h2></label>';
			$content   = $row["about"];
			$editor_id = 'cpabout';
			$settings  = array( 'media_buttons' => true);
 
			wp_editor( $content, $editor_id, $settings );
			
            echo '<br><br>';	
            
			/** Manufacturer Profile update_Table2 */
			echo '<table>';
			echo '<tr><td><label for="cpstaff_no">Manufacturer Size: </label></td><td><input type="text" id="cpstaff_no" name="cpstaff_no" value="'. $update_cp_staffno.'"></td></tr>';
			
			//var_dump($update_cp_businesstype);
            
			if ($update_cp_businesstype == 1) {
				echo '<tr><td><label for="cpbusiness_type">Business Type: </label></td><td><select id="cpbusiness_type" name="cpbusiness_type"><option value="1" selected>Distributor</option><option value="2">Manufacturer</option></select></td></tr>';
			}
			elseif ($update_cp_businesstype == 2) {
				echo '<tr><td><label for="cpbusiness_type">Business Type: </label></td><td><select id="cpbusiness_type" name="cpbusiness_type"><option value="1">Distributor</option><option value="2" selected>Manufacturer</option></select></td></tr>';
			}
			else {
				echo '<tr><td><label for="cpbusiness_type">Business Type: </label></td><td><select id="cpbusiness_type" name="cpbusiness_type"><option value="1">Distributor</option><option value="2">Manufacturer</option></select></td></tr>';
			}
			
			echo '<tr><td><label for="cpcrystalline">Crystalline: </label></td><td><input type="text" id="cpcrystalline" name="cpcrystalline" value="'. $update_cp_crystalline.'"></td></tr>';
			echo '<tr><td><label for="cpcproduction">Crystalline Production: </label></td><td><input type="text" id="cpcproduction" name="cpcproduction" value="'. $update_cp_cproduction.'"></td></tr>';
			echo '<tr><td><label for="cpcprl">Crystalline Power Range (Low): </label></td><td><input type="text" id="cpcprl" name="cpcprl" value="'. $update_cp_cprl.'"></td></tr>';
			echo '<tr><td><label for="cpcprh">Crystalline Power Range (High): </label></td><td><input type="text" id="cpcprh" name="cpcprh" value="'. $update_cp_cprh.'"></td></tr>';
			echo '<tr><td><label for="cphigh_eff">Crystalline High Efficiency: </label></td><td><input type="text" id="cphigh_eff" name="cphigh_eff" value="'. $update_cp_high_eff.'"></td></tr>';
			echo '<tr><td><label for="cpchproduction">Crystalline High Production: </label></td><td><input type="text" id="cpchproduction" name="cpchproduction" value="'. $update_cp_chproduction.'"></td></tr>';
			echo '<tr><td><label for="cphecprl">Crystalline High Efficiency Power Range (Low): </label></td><td><input type="text" id="cphecprl" name="cphecprl" value="'. $update_cp_hecprl.'"></td></tr>';
			echo '<tr><td><label for="cphecprh">Crystalline High Efficiency Power Range (High): </label></td><td><input type="text" id="cphecprh" name="cphecprh" value="'. $update_cp_hecprh.'"></td></tr>';
			echo '<tr><td><label for="cpcis">Thin Film CIS Family: </label></td><td><input type="text" id="cpcis" name="cpcis" value="'. $update_cp_cis.'"></td></tr>';
			echo '<tr><td><label for="cpbipv">Thin Film BIPV: </label></td><td><input type="text" id="cpbipv" name="cpbipv" value="'. $update_cp_bipv.'"></td></tr>';
			echo '<tr><td><label for="cpbipv_production">Thin Film BIPV Production: </label></td><td><input type="text" id="cpbipv_production" name="cpbipv_production" value="'. $update_cp_bipv_prod.'"></td></tr>';
			echo '<tr><td><label for="cpbipvlow">Thin Film BIPV Power Range (Low): </label></td><td><input type="text" id="cpbipvlow" name="cpbipvlow" value="'. $update_cp_bipvl.'"></td></tr>';
			echo '<tr><td><label for="cpbipvhigh">Thin Film BIPV Power Range (High): </label></td><td><input type="text" id="cpbipvhigh" name="cpbipvhigh" value="'. $update_cp_bipvh.'"></td></tr>';
			echo '<tr><td><label for="cpbipvflexible">Thin Film Flexible: </label></td><td><input type="text" id="cpbipvflexible" name="cpbipvflexible" value="'. $update_cp_flexible.'"></td></tr>';
			
			echo '</table>';
			echo '<br><br>';	
            
            /** Manufacturer Profile update_Table3 */
			echo '<table>';
			echo '<tr><td><label for="cpcomtype">Component Type: </label></td><td><input type="text" id="cpcomtype" name="cpcomtype" value="'. $update_cp_comptype.'"></td></tr>';
			echo '<tr><td><label for="cpme">Mounting Equipment: </label></td><td><input type="text" id="cpme" name="cpme" value="'. $update_cp_me.'"></td></tr>';
			echo '</table>';
            
            
			/** Add More btn */
			echo '<br><br>Milestones&nbsp;&nbsp;&nbsp;<button type="button" onclick="addmilestones()">Add More</button><br><br>';
			
			
			echo '<script>
					function addmilestones() {var s=document.getElementsByClassName("accordionm").length+1;document.getElementById("milestonedemo").innerHTML =document.getElementById("milestonedemo").innerHTML+\'<button id="\'+String(s)+\'" type="button" class="accordionm">New</button><div id="plus\'+String(s)+\'" class="panel"><label for="cpmilestonesyear\'+String(s)+\'">Year: </label><textarea id="cpmilestonesyear\'+String(s)+\'" name="cpmilestonesyear\'+String(s)+\'" rows="1" cols="50"></textarea><br><label for="cpmilestonesname\'+String(s)+\'">Name: </label>'.
					'<textarea id="cpmilestonesname\'+String(s)+\'" name="cpmilestonesname\'+String(s)+\'"></textarea><br>'.'<label for="cpmilestonescontent\'+String(s)+\'">Content: </label>'.'<textarea id="cpmilestonescontent\'+String(s)+\'" name="cpmilestonescontent\'+String(s)+\'"></textarea><br>'.
					'<br><br><button type="button" onclick="deletemilestones(\'+String(s)+\')">Delete</button><br><br></div>\';var acc = 
					document.getElementsByClassName("accordionm");var i;for (i = 0; i < acc.length; i++) {acc[i].addEventListener("click", function() {this.classList.toggle("active");var panel = this.nextElementSibling;if (panel.style.maxHeight) {panel.style.maxHeight = null;} else {panel.style.maxHeight = panel.scrollHeight + "px";} });}}
					
				 </script>';

			echo '<script>function deletemilestones(a) {var myobj = document.getElementById(String(a));myobj.remove();var myobjplus = document.getElementById("plus"+String(a));myobjplus.remove();}</script>';
			wp_enqueue_script( 'jQuery' );
			
			
			$cp_sql_milestones    = "SELECT * FROM ".$tablename_milestones." WHERE company_id=".$cp_id;
    		$cp_result_milestones = $conn->query($cp_sql_milestones);
			echo '<style>.accordionm {background-color: lightblue;color: #444;cursor: pointer;padding: 18px;width: 100%;border: none;text-align: left;outline: none;font-size: 15px;transition: 0.4s;}.active, .accordionm:hover {background-color: #ccc;}.accordionm:after {content: "\002B";color: #777;font-weight: bold;float: right;margin-left: 5px;}.active:after {content: "\2212";}.panel {padding: 0 18px;background-color: white;max-height: 0;overflow: hidden;transition: max-height 0.2s ease-out;}</style>';
			
			echo '<span id="milestonedemo">';
					if ($cp_result_milestones->num_rows > 0) {
				
						while($row_milestones = $cp_result_milestones->fetch_assoc()) {
							echo '<button id="'.$row_milestones["milestone_id"].'" type="button" class="accordionm">'.$row_milestones["milestone_year"].'</button>
							<div id="plus'.$row_milestones["milestone_id"].'" class="panel"><label for="cpmilestonesname'.$row_milestones["milestone_id"].'">Name: </label><textarea id="cpmilestonesname'.$row_milestones["milestone_name"].'" name="cpmilestonesname'.$row_milestones["milestone_id"].'" rows="1" cols="80">'.$row_milestones["milestone_name"].'</textarea><br>'.'<label for="cpmilestonescontent'.$row_milestones["milestone_id"].'">Content: </label><textarea id="cprmilestonescontent'.$row_milestones["milestone_content"].'" name="cprmilestonescontent'.$row_milestones["milestone_id"].'" rows="1" cols="80">'.$row_milestones["milestone_content"].'</textarea><br>'.'<br><br><button type="button" onclick="deletemilestones('.$row_milestones["milestone_id"].')">Delete</button><br><br></div>';
						}	
					}
					else {echo '0 Milestones<br><br>';}
			
			echo '</span>';
  			echo '<script>var acc = 
					document.getElementsByClassName("accordionm");var i;for (i = 0; i < acc.length; i++) {acc[i].addEventListener("click", function() {this.classList.toggle("active");var panel = this.nextElementSibling;if (panel.style.maxHeight) {panel.style.maxHeight = null;} else {panel.style.maxHeight = panel.scrollHeight + "px";} });}</script>';
		
			$cp_sql_solarprocat = "SELECT * FROM ".$tablename_project_cat;
    		$cp_result_solarprocat = $conn->query($cp_sql_solarprocat);	
			
			//var_dump($cp_sql_solarprocat);

    		$prod_cat=[];
    		if ($cp_result_solarprocat->num_rows > 0) {
    			while($row_proj_cat = $cp_result_solarprocat->fetch_assoc()) {
    				$cat_index = intval($row_proj_cat["ID"]);
    				$prod_cat[$cat_index] = $row_proj_cat["cat_name"];
    			}
    		}
			
			//var_dump($prod_cat);

		    /** Add More btn */
			echo '<br><br>Solar projects that we supplied:&nbsp;&nbsp;&nbsp;<button type="button" onclick="addsolarprojects()">Add More</button><br><br>';
			
			
			echo '<script>
					function addsolarprojects() {
					var s=document.getElementsByClassName("accordions").length+1;
					document.getElementById("solarprojectsdemo").innerHTML =document.getElementById("solarprojectsdemo").innerHTML+\'<button id="\'+String(s)+\'" type="button" class="accordions">New</button><div id="plus\'+String(s)+\'" class="panel"><label for="cpsolarprojectscat\'+String(s)+\'">Solar Project Category: </label>\'+\'<select id="cpsolarprojectscat\'+String(s)+\'" name="cpsolarprojectscat\'+String(s)+\'">';
  			foreach ($prod_cat as $v) {
				
  				echo '<option value="'.array_search($v, $prod_cat).'">'.$v.'</option>';
			}
    		
  					echo '</select><br><label for="cpsolarprojectsno\'+String(s)+\'">Model Number: </label>'.
					'<textarea id="cpsolarprojectsno\'+String(s)+\'" name="cpsolarprojectsno\'+String(s)+\'"></textarea><br>'.
					'<br><br><button type="button" onclick="deletesolarprojects(\'+String(s)+\')">Delete</button><br><br></div>\';var acc = 
					document.getElementsByClassName("accordions");var i;for (i = 0; i < acc.length; i++) {acc[i].addEventListener("click", function() {this.classList.toggle("active");var panel = this.nextElementSibling;if (panel.style.maxHeight) {panel.style.maxHeight = null;} else {panel.style.maxHeight = panel.scrollHeight + "px";} });}}
					
				 </script>';

			echo '<script>function deletesolarprojects(a) {var myobj = document.getElementById(String(a));myobj.remove();var myobjplus = document.getElementById("plus"+String(a));myobjplus.remove();}</script>';
			wp_enqueue_script( 'jQuery' );	
			
			
			$cp_sql_solarprojects    = "SELECT * FROM ".$tablename_projects." WHERE company_id=".$cp_id;
    		$cp_result_solarprojects = $conn->query($cp_sql_solarprojects);

    		

			echo '<style>.accordions {background-color: lightblue;color: #444;cursor: pointer;padding: 18px;width: 100%;border: none;text-align: left;outline: none;font-size: 15px;transition: 0.4s;}.active, .accordions:hover {background-color: #ccc;}.accordions:after {content: "\002B";color: #777;font-weight: bold;float: right;margin-left: 5px;}.active:after {content: "\2212";}.panel {padding: 0 18px;background-color: white;max-height: 0;overflow: hidden;transition: max-height 0.2s ease-out;}</style>';
			
			echo '<span id="solarprojectsdemo">';
					if ($cp_result_solarprojects->num_rows > 0) {
				
						while($row_solarprojects = $cp_result_solarprojects->fetch_assoc()) {
							echo '<button id="'.$row_solarprojects["project_id"].'" type="button" class="accordions">'.$row_solarprojects["model_no"].'</button>
							<div id="plus'.$row_solarprojects["model_no"].'" class="panel">
							  <select id="cpsolarprojectscat'.$row_solarprojects["project_id"].'" name="cpsolarprojectscat'.$row_solarprojects["project_id"].'>';
  							  foreach ($prod_cat as $v) {
  							  	if (array_search($v, $prod_cat) == $row_solarprojects["project_id"]){
  							  		echo '<option value="'.array_search($v, $prod_cat).'" selected>'.$v.'</option>';
  							  	}
  								else {
  									echo '<option value="'.array_search($v, $prod_cat).'">'.$v.'</option>';
  								}
							  }
    		
  							  echo '</select>


							  <br><label for="cpsolarprojectsno'.$row_solarprojects["project_id"].'">Model Number: </label><textarea id="cpsolarprojectsno'.$row_solarprojects["model_no"].'" name="cpmilestonesname'.$row_solarprojects["project_id"].'" rows="1" cols="80">'.$row_solarprojects["model_no"].'</textarea><br>'.'<br><br><button type="button" onclick="deletemilestones('.$row_solarprojects["milestone_id"].')">Delete</button><br><br></div>';
						}	
					}
					else {echo '0 Solar Projects<br><br>';}
			
			echo '</span>';

			echo '<script>var accs = 
					document.getElementsByClassName("accordions");var is;for (is = 0; is < accs.length; is++) {accs[is].addEventListener("click", function() {this.classList.toggle("active");var panel = this.nextElementSibling;if (panel.style.maxHeight) {panel.style.maxHeight = null;} else {panel.style.maxHeight = panel.scrollHeight + "px";} });}</script>';


            /** Add More btn */
			echo '<br><br>Reviews&nbsp;&nbsp;&nbsp;<button type="button" onclick="addreviews()">Add More</button><br><br>';
			
			
			echo '<script>
					function addreviews() {var s=document.getElementsByClassName("accordion").length+1;document.getElementById("reviewdemo").innerHTML =document.getElementById("reviewdemo").innerHTML+\'<button id="\'+String(s)+\'" type="button" class="accordion">New</button><div id="plus\'+String(s)+\'" class="panel"><label for="cpreviewname\'+String(s)+\'">Name: </label><textarea id="cpreviewname\'+String(s)+\'" name="cpreviewname\'+String(s)+\'" rows="1" cols="50"></textarea><br><label for="cpreviewcontent\'+String(s)+\'">Content: </label>'.
					'<textarea id="cpreviewcontent\'+String(s)+\'" name="cpreviewcontent\'+String(s)+\'" rows="4" cols="50"></textarea>'.
					'<br><br><button type="button" onclick="deletereviews(\'+String(s)+\')">Delete</button><br><br></div>\';var acc = 
					document.getElementsByClassName("accordion");var i;for (i = 0; i < acc.length; i++) {acc[i].addEventListener("click", function() {this.classList.toggle("active");var panel = this.nextElementSibling;if (panel.style.maxHeight) {panel.style.maxHeight = null;} else {panel.style.maxHeight = panel.scrollHeight + "px";} });}}
					
				 </script>';

			echo '<script>function deletereviews(a) {var myobj = document.getElementById(String(a));myobj.remove();var myobjplus = document.getElementById("plus"+String(a));myobjplus.remove();}</script>';
			wp_enqueue_script( 'jQuery' );
			
			
			$cp_sql_reviews    = "SELECT * FROM ".$tablename_review." WHERE company_id=".$cp_id;
    		$cp_result_reviews = $conn->query($cp_sql_reviews);
			echo '<style>.accordion {background-color: lightblue;color: #444;cursor: pointer;padding: 18px;width: 100%;border: none;text-align: left;outline: none;font-size: 15px;transition: 0.4s;}.active, .accordion:hover {background-color: #ccc;}.accordion:after {content: "\002B";color: #777;font-weight: bold;float: right;margin-left: 5px;}.active:after {content: "\2212";}.panel {padding: 0 18px;background-color: white;max-height: 0;overflow: hidden;transition: max-height 0.2s ease-out;}</style>';
			
			echo '<span id="reviewdemo">';
					if ($cp_result_reviews->num_rows > 0) {
				
						while($row_reviews = $cp_result_reviews->fetch_assoc()) {
							echo '<button id="'.$row_reviews["review_id"].'" type="button" class="accordion">'.$row_reviews["review_name"].'</button>
							<div id="plus'.$row_reviews["review_id"].'" class="panel"><label for="cpreviewname'.$row_reviews["review_id"].'">Name: </label><textarea id="cpreviewname'.$row_reviews["review_id"].'" name="cpreviewname'.$row_reviews["review_id"].'" rows="1" cols="50">'.$row_reviews["review_name"].'</textarea><br><label for="cpreviewcontent'.$row_reviews["review_id"].'">Content: </label><textarea id="cpreviewcontent'.$row_reviews["review_id"].'" name="cpreviewcontent'.$row_reviews["review_id"].'" rows="4" cols="50">'.$row_reviews["review_content"].'</textarea><br><br><button type="button" onclick="deletereviews('.$row_reviews["review_id"].')">Delete</button><br><br></div>';
						}	
					}
					else {echo '0 Reviews<br><br>';}
			
			echo '</span>';

			echo '<script>var acco = document.getElementsByClassName("accordion");var j;for (j = 0; j < acco.length; j++) {acco[j].addEventListener("click", function() {this.classList.toggle("active");var panelo = this.nextElementSibling;if (panelo.style.maxHeight) {panelo.style.maxHeight = null;} else {panelo.style.maxHeight = panelo.scrollHeight + "px";} });}</script>';



			$cp_sql_news    = "SELECT * FROM ".$tablename_news." WHERE company_id=".$cp_id;
    		$cp_result_news = $conn->query($cp_sql_news);
			$i = 0;
			if ($cp_result_news->num_rows > 0) {
    	
        		while($row_news = $cp_result_news->fetch_assoc()) {
					$i = $i + 1;
					echo '<h3>News '.strval($i).'</h3>';
					echo '<label for="cpnewsname'.strval($i).'">Name: </label><textarea id="cpnewsname'.strval($i).'" name="cpnewsname'.strval($i).'" rows="1" cols="50">'.$row_news["title"].'</textarea><br><br>';
					$content   = $row_news["content"];
					$editor_id = 'cpnewscontent';
					$settings  = array( 'media_buttons' => true);

					wp_editor( $content, $editor_id.strval($i), $settings );
				}
				
			}
			
			
			while ($i < 1) {
				$i = $i + 1;
				echo '<h3>News '.strval($i).'</h3>';
				echo '<label for="cpnewsname'.strval($i).'">Name: </label><textarea id="cpnewsname'.strval($i).'" name="cpnewsname'.strval($i).'" rows="1" cols="50"></textarea><br><br>';
				$content   = '';
				$editor_id = 'cpnewscontent';
				$settings  = array( 'media_buttons' => true);
				wp_editor( $content, $editor_id.strval($i), $settings );
			}
			
			while ($i < 8) {
				$i = $i + 1;
				echo '<div class="hidenews" style="display:none;">';
				echo '<h3>News '.strval($i).'</h3>';
				echo '<label for="cpnewsname'.strval($i).'">Name: </label><textarea id="cpnewsname'.strval($i).'" name="cpnewsname'.strval($i).'" rows="1" cols="50"></textarea><br><br>';
				$content   = '';
				$editor_id = 'cpnewscontent';
				$settings  = array( 'media_buttons' => true);
				wp_editor( $content, $editor_id.strval($i), $settings );
				echo '</div>';
			}
			
			while ($i < 30) {
				$i = $i + 1;
				echo '<div class="hidenews2" style="display:none;">';
				echo '<h3>News '.strval($i).'</h3>';
				echo '<label for="cpnewsname'.strval($i).'">Name: </label><textarea id="cpnewsname'.strval($i).'" name="cpnewsname'.strval($i).'" rows="1" cols="50"></textarea><br><br>';
				$content   = '';
				$editor_id = 'cpnewscontent';
				$settings  = array( 'media_buttons' => true);
				wp_editor( $content, $editor_id.strval($i), $settings );
				echo '</div>';
			}
            
            /** Add More News1 btn */
            echo '<div><button id="btn_addnews" onclick="openmorenews();">Add More News</button></div>';

             /** Add More News2 btn */
			echo '<div><button id="btn_addnews_2" onclick="openmorenews2();" style="display:none;">Add More News</button></div>';
			
			
			echo '<script>function openmorenews(){event.preventDefault();var y = document.getElementsByClassName("hidenews"); var i;document.getElementById("btn_addnews").style.display = "none";document.getElementById("btn_addnews_2").style.display = "block";
							for (i = 0; i < y.length; i++) {
								y[i].style.display = "block";
							}}
                  </script>';
                  
			echo '<script>function openmorenews2(){event.preventDefault();var z = document.getElementsByClassName("hidenews2"); var j;document.getElementById("btn_addnews_2").style.display = "none";
							for (j = 0; j < z.length; j++) {
								z[j].style.display = "block";
							}}
				  </script>';
			
            echo '<br>';
            
          	
			$row["name"] = str_replace(",","",$row["name"]);
			$row["name"] = str_replace(".","",$row["name"]);
			$row["name"] = str_replace(' ', '-', $row["name"]);
			echo '</div>';

			echo '<div class="mfp-edit-right">';
			echo '<div class="mfp-update-box">';

			add_action ('admin_enqueue_scripts', function() {
				if(is_admin())
					wp_enqueue_media(); 
				});
			
				if (is_null($row["company_image"])){
						
					echo '<input type="text" class="process_custom_images example-jpg-file-new" id="example-jpg-file-new" name="example-jpg-file-new" value=""><button class="set_custom_logo button" style="vertical-align: middle;">Select Manufacturer Logo</button>';
			
					echo "<script>jQuery(document).ready(function() {
									var $ = jQuery;
									if ($('.set_custom_logo').length > 0) {
										if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
											$(document).on('click', '.set_custom_logo', function(e) {
												e.preventDefault();
												var button = $(this);
												var id = button.prev();
												wp.media.editor.send.attachment = function(props, attachment) {
													id.val(attachment.url);
												};
												wp.media.editor.open(button);
												return false;
											});
										}
									}
								});
							</script>";
				}else{
						
					echo '<input type="text" class="process_custom_images example-jpg-file" id="example-jpg-file" name="example-jpg-file" value=""><button class="set_custom_logo button" style="vertical-align: middle;">Update Manufacturer Logo</button>';
					echo '<br><br>('.'<label for="cimage">Current Image: </label>'.'  <input type="text" id="cimage" name="cimage" value="'.$row["company_image"].'" size="" readonly> ) <br><br><img src="'.$row["company_image"].'"> <br>';
		
					echo "<script>jQuery(document).ready(function() {
									var $ = jQuery;
									if ($('.set_custom_logo').length > 0) {
										if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
											$(document).on('click', '.set_custom_logo', function(e) {
												e.preventDefault();
												var button = $(this);
												var id = button.prev();
												wp.media.editor.send.attachment = function(props, attachment) {
													id.val(attachment.url);
												};
												wp.media.editor.open(button);
												return false;
											});
										}
									}
								});
							</script>";
					}

			echo '<label for="cplastedit">Last Edit Date: </label>';
			echo '<input type="text" id="cplastedit" name="cplastedit" value="'. $row["last_edit"].'"><br><br>';		
			
		    echo "Business status : "; 
			echo '<select name="cpbusiness_status">'; ?>
			<option value="">Select</option>
			<option value="Closed permanently" <?php if($row["status"] == "Closed permanently"){echo $select_attribute = 'selected'; } ?> >Closed permanently</option>;
			<option value="Active" <?php if($row["status"] == "Active"){echo $select_attribute = 'selected'; } ?>>Active</option> 
			<option value="Acquired" <?php if($row["status"] == "Acquired"){echo $select_attribute = 'selected'; } ?>>Acquired</option> 

			<?php echo '</select><br><br>';
					
			echo '&nbsp;<a href="'.get_site_url().'/brands/'.$row["name"].'" target=”_blank”>View Page</a></td>';
			echo '&nbsp;<input type="submit" value="Submit">';
			echo '</div>';
			echo '</div>';	
			echo '</div>';	
			echo '</form><br>';
            
			echo '<form action="'.get_site_url().'/wp-admin/admin.php?page=cpcustompage" method="POST" onsubmit="setFormSubmitting(); return confirm(\'Are you sure you want to delete this profile?\');"><input type="submit" value="Delete" id="btn_delete">';
			echo '<input id="deletecpid" name="deletecpid" type="hidden" value="'.$cp_id.'">';
			echo '&nbsp;&nbsp;<span><a href="'.get_site_url().'/wp-admin/admin.php?page=cpcustompage">Back to Manufacturer Profile List</a></span>';
			echo '</form>';
            
        }
        
    }
    else {
        echo "0 results";
    }
    
    $conn->close();

?>
