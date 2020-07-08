<?php

    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $tablename         = "company_profile_short";
    $tablename_details = "company_profile";
    $tablename_reviews = "company_profile_reviews";
    $tablename_news    = "company_profile_news";
 
    $cp_sql    = "SELECT * FROM ".$tablename;
    $cp_result = $conn->query($cp_sql);
 
    if($_POST && isset($_POST['createcpid'])){
    
        if (isset($_POST['cpname'])){
            $cp_name          = $_POST['cpname'];
            $cp_sql_check     = "SELECT * FROM ".$tablename." WHERE company_name = '".$cp_name."'";
            $cp_result_check  = $conn->query($cp_sql_check);

            if ($cp_result_check->num_rows > 0) {
                echo "Create Failed. There is an existing manufacturer name.";
                exit;
            }

        $sql_cp_id     = "SELECT MAX(company_id) AS LargestId FROM ".$tablename.";";   
        $result_cp_id  = $conn->query($sql_cp_id);

        if ($result_cp_id->num_rows > 0) {
            while($row = $result_cp_id->fetch_assoc()) {
                $new_cp_id = $row["LargestId"];        
            }
        }
        else {
            $new_cp_id = 0;
        }
        
        $related_profiles = realted_manufacturer($_POST['cpregion'], $_POST['cpcomtype'], $_POST['cpcrystalline']);
        
        $new_cp_id = intval($new_cp_id)+ 1;
         
        if ($cp_result_check->num_rows > 0) {
        }
        else {
            $y = 1;
            $is_review = 0;
            $x_write   = '<div class="whiteblock" id="userreviews"><h2 style="margin-bottom:0px !important;">Reviews for '.$_POST['cpname'].": </h2>";
            while(isset($_POST['cpreviewname'.$y])) {
                $cp_sql_reviews_create    = "INSERT INTO ".$tablename_reviews." (company_id, review_id, review_name, review_content) VALUES (".$new_cp_id.", ".$y.", '".$_POST['cpreviewname'.$y]."', '".$_POST['cpreviewcontent'.$y]."');";
                $cp_result_reviews_create = $conn->query($cp_sql_reviews_create);
                $x_write                  = $x_write."Name: ".$_POST['cpreviewname'.$y]."<br>";
                $x_write                  = $x_write."Content: ".$_POST['cpreviewcontent'.$y]."<br><br>";
                $y++;
                $is_review                = 1;
             }

            if ($is_review == 0){
                $x_write = $x_write.'</div>';
            }
            else {
                $x_write = $x_write.'</div>';
            }

             $yy = 1;
             $is_news   = 0;
             $xx_write  = '<div class="whiteblock" id="archivenews"><h2>Archive News for '.$_POST['cpname'].': </h2><div class="content">';
           
             while(isset($_POST['cpnewsname'.$yy]) && ($_POST['cpnewsname'.$yy] != '') && ($_POST['cpnewscontent'.$yy] != '')) {
                $cp_sql_news_create    = "INSERT INTO ".$tablename_news." (company_id, news_id,date, title, content) VALUES (".$new_cp_id.", ".$yy.",2020".", '".$_POST['cpnewsname'.$yy]."', '".$_POST['cpnewscontent'.$yy]."');";
                $cp_result_news_create = $conn->query($cp_sql_news_create);
                $xx_write  = $xx_write.'<div>';
                $xx_write  = $xx_write.'<input type="checkbox" id="question'.$yy.'" name="q" class="questions"><div class="plus">+</div><label for="question'.$yy.'" class="question">'.$_POST['cpnewsname'.$yy].'</label>';
                //$xx_write              = $xx_write."News Title: ".$_POST['cpnewsname'.$xx]."<br>";
                $xx_write  = $xx_write.'<div class="answers">'.str_replace('\"','',$_POST['cpnewscontent'.$yy]).'</div>';
                //$xx_write              = $xx_write."News Content: ".$_POST['cpnewscontent'.$xx]."<br><br>";
                $xx_write  = $xx_write.'</div>';
                $yy++;
                $is_news = 1;
             }
             
            if ($is_news == 1){
                $xx_write = $xx_write."</div></div>";
            }
           
             
            $new_cp_name           = $_POST['cpname'];
            $new_cp_address        = $_POST['cpaddress'];
            $new_cp_phone          = $_POST['cpphone'];
            $new_cp_email          = $_POST['cpemail'];
            $new_cp_url            = $_POST['cpurl'];
            $new_cp_region         = $_POST['cpregion'];
            $new_cp_facebook       = $_POST['cpfacebook'];
            $new_cp_linkedin       = $_POST['cplinkedin'];
            $new_cp_twitter        = $_POST['cptwitter'];
            $new_cp_youtube        = $_POST['cpyoutube'];
            $new_cp_about          = str_replace('\"','',$_POST['cpabout']); 
            $new_cp_image          = $_POST['example-jpg-file'];
            $new_cp_staffno        = intval($_POST['cpstaff_no']);
            $new_cp_crystalline    = $_POST['cpcrystalline'];
            $new_cp_cprl           = $_POST['cpcprl'];
            $new_cp_cprh           = $_POST['cpcprh'];
            $new_cp_high_eff       = $_POST['cphigh_eff'];
            $new_cp_hecprl         = $_POST['cphecprl'];
            $new_cp_hecprh         = $_POST['cphecprh'];
           // $new_cp_business_status = $_POST['cpbusiness_status'];
            $new_cp_comtype        = $_POST['cpcomtype'];
            $new_cp_cpme           = $_POST['cpme'];
            
            $cp_sql_insert         = "INSERT INTO ".$tablename." (company_id, name, address, phone, email, url, region,facebook, linkedin,twitter,youtube,company_image, about) VALUES (".$new_cp_id.", '".$new_cp_name."','".$new_cp_address."','".$new_cp_phone."','".$new_cp_email."','".$new_cp_url."','".$new_cp_region."','".$new_cp_facebook."','".$new_cp_linkedin."','".$new_cp_twitter."','".$new_cp_youtube."','".$new_cp_image."','".$new_cp_about."')";
            $cp_result_insert      = $conn->query($cp_sql_insert);
             
            $cp_sql_insert_details = "INSERT INTO ".$tablename_details." (company_id, staff_no, crystalline, cprl, cprh, high_eff, hecprl, hecprh,com_type,mounting_eq) VALUES (".$new_cp_id.",".$new_cp_staffno.",'".$new_cp_crystalline."','".$new_cp_cprl."','".$new_cp_cprh."','".$new_cp_high_eff."','".$new_cp_hecprl."','".$new_cp_hecprh."','".$new_cp_comtype."','".$new_cp_cpme."')";
            $cp_result_insert      = $conn->query($cp_sql_insert_details);
             
             
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

             if ($new_cp_youtube == ""){
                $new_cp_youtube = "Unknown";
            }  

             if ($new_cp_about == ""){
                 $new_cp_about = "Unknown";
             }
             
             if ($new_cp_staffno == 0){
                 $new_cp_staffno = "Unknown";
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
             if ($new_cp_comtype == ""){
                $new_cp_comtype = "Unknown";
             }
             if ($new_cp_cpme == ""){
                $new_cp_cpme = "Unknown";
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
            
             if ($new_cp_comtype == ""){
                $new_cp_comtype = "Unknown";
             }
             if ($new_cp_cpme == ""){
                $new_cp_cpme = "Unknown";
             } 
             
             
            $cpcreatecontent = "<?php require_once('".$_SERVER['DOCUMENT_ROOT']."/wp-load.php'); get_header();?>";
            $cpcreatecontent = $cpcreatecontent."<style>a{color: #4DB7FE !important;}.site-content{padding-top:30px !important;}.whiteblock{box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);background: #fff;border-radius: 10px;z-index:-1;margin-right: 20px;padding: 15px 30px;border: 1px solid #e5e7f2;}body {background: #f6f6f6 !important;}.content {width: 100%;padding: 20px;padding: 0 60px 0 0;}.question {position: relative;background: lightgrey;padding: 10px 10px 10px 50px;display: block;width:100%;cursor: pointer;}.answers {padding: 0px 15px;margin: 5px 0;max-height: 0;overflow: hidden;z-index: 0;position: relative;opacity: 0;-webkit-transition: .7s ease;-moz-transition: .7s ease;-o-transition: .7s ease;transition: .7s ease;}.questions:checked ~ .answers{max-height: max-content;opacity: 1;padding: 15px;}.plus {position: absolute;margin-left: 10px;z-index: 5;font-size: 2em;line-height: 100%;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;-webkit-transition: .3s ease;-moz-transition: .3s ease;-o-transition: .3s ease;transition: .3s ease;}.questions:checked ~ .plus {-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-o-transform: rotate(45deg);transform:rotate(45deg);}.questions {display: none;}#rightmenu {position: fixed;right: 0;top: 5%;width: 12em;margin-top: -2.5em;}.d-70{width:70%;float:left;}.d-30{width:30%;float:right;}@media only screen and (max-width: 767px) {.d-70{width:100%;}.d-30{width:100%;}.nomargins{margin-top:0px !important;margin-bottom:0px !important;}</style>";
             
            $cpcreatecontent = $cpcreatecontent."<style>
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
            </style>";
            if ( is_user_logged_in() ) {
				$edit_url= get_site_url()."/wp-admin/admin.php?page=cpcustomsubpage&company_id=".$new_cp_id;
				$add_url = get_site_url()."/wp-admin/admin.php?page=cpcreatepage";
				$admin_url = get_site_url()."/wp-admin";
				$cpcreatecontent = $cpcreatecontent."<div id='mfp-topbar'><ul><li><a href='".$edit_url."'>Edit this page</a> |</li><li><a href='".$add_url."'>Add a new profile</a> |</li><li><a href='".$admin_url."'>WP Dashboard</a></li></ul></div>";
                }
    
            $cpcreatecontent = $cpcreatecontent.'<section class="d-70">';
            $cpcreatecontent = $cpcreatecontent.'<div class="whiteblock"><h1>'.$new_cp_name.' | Product Reviews</h1>';
            $cpcreatecontent = $cpcreatecontent."Factory Location: ".$new_cp_region."      ";
            $cpcreatecontent = $cpcreatecontent.' | <a href="#userreviews">'.strval($y-1).' Reviews</a> | <a href="#archivenews">'.strval($yy-1)." News</a><br></div>";
            $cpcreatecontent = $cpcreatecontent.'<hr style="width:50%;text-align:left;margin-left:0">'; 
            if ($new_cp_business_status == "Closed permanently"){
				$cpcreatecontent = $cpcreatecontent."<div class='whiteblock' style='background-color: #f2dede; border: 4px solid #fff; padding: 0px 30px 12px 30px !important;'><h4 style='color: #a94442; line-height: 0.1; font-size: 14px;'><i class='fa fa-exclamation-circle' style='font-size:16px;color:red'></i> Removed Listing</h4>";
				$cpcreatecontent = $cpcreatecontent.'<span style="color: #a94442; font-size: 12px;">This business listing has been removed. Many factors might be considered: </span><ul style="color: #a94442; font-size: 12px;"><li> The company do not manufacture or sell solar materials any more.</li><li> The company is permanently closed.</li></ul>';
				$cpcreatecontent = $cpcreatecontent.'<span style="color: #a94442; font-size: 12px;">Sometimes a company is removed by mistake. If you are the owner of this company and you think SolarFeeds has made a mistake, please contact the Directory Manager at: content@shop.solarfeeds.com</b></span>';
				$cpcreatecontent = $cpcreatecontent.'</div>';
            }  
            $cpcreatecontent = $cpcreatecontent.'<hr style="width:50%;text-align:left;margin-left:0">';   
            $cpcreatecontent = $cpcreatecontent.'<div class="whiteblock"><h2>About '.$new_cp_name.": </h2>".$new_cp_about."</div><br>";
            $cpcreatecontent = "<br>".$cpcreatecontent.$x_write."<br>";
            $cpcreatecontent = $cpcreatecontent.$xx_write."<br></section>";
    
             
            $cpcreatecontent = $cpcreatecontent.'<aside class="d-30">';
            $cpcreatecontent = $cpcreatecontent.'<div class="whiteblock"><img src="'.$_POST['example-jpg-file'].'">';
            // $cpcreatecontent = $cpcreatecontent.'<h2 style="margin-top:10px !important;margin-bottom:10px !important">Contact Info</h2>'.'<div><a href="#"><i class="fa fa-building-o" aria-hidden="true"></i></a> '.$new_cp_address.'</div><div><a href="'.$new_cp_url.'"><i class="fa fa-globe" aria-hidden="true"></i></a> '.$new_cp_url.'</div><div><a href="tel:'.$new_cp_phone.'"><i class="fa fa-phone" aria-hidden="true"></i></a> '.$new_cp_phone.'</div>'.'<div><a href="mailto:'.$new_cp_email.'"><i class="fa fa-envelope"></i></a> '.$new_cp_email.'</div>'.'<div><a href="'.$new_cp_facebook.'"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> '.$new_cp_facebook.'</div>'.'<div><a href="'.$new_cp_linkedin.'"><i class="fa fa-linkedin" aria-hidden="true"></i></a> '.$new_cp_linkedin.'</div>'.'<div><a href="'.$new_cp_twitter.'"><i class="fa fa-twitter" aria-hidden="true"></i></a> '.$new_cp_twitter.'</div></div><br>'.'<div class="whiteblock" style="display:none;"><h2 style="margin-top:10px !important;margin-bottom:10px !important">Product Information</h2><ul><li><a href="#">Manufacturer Size: </a><br>'.$new_cp_staffno.'</li>'.'<li><a href="#">Crystalline</a><br>'.$new_cp_crystalline.'<br>Power Range (Wp): '.$new_cp_cprl.'-'.$new_cp_cprh.'</li>'.'<li><a href="#">High Efficiency Crystalline</a><br>'.$new_cp_high_eff.'<br>Power Range (Wp): '.$new_cp_hecprl.'-'.$new_cp_hecprh.'</li>'.'</ul>';
            // $cpcreatecontent = $cpcreatecontent."</div>";
            $cpcreatecontent = $cpcreatecontent.'<h2 style="margin-top:10px !important;margin-bottom:10px !important">Contact Info</h2>'.'<div>';
				if($new_cp_facebook != 'Unknown'){
					$cpcreatecontent = $cpcreatecontent.'<span ><a target = "_blank" href="'.$new_cp_facebook.'" title="'.$new_cp_facebook.'"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></span>';
				}
				if($new_cp_linkedin != 'Unknown'){
					$cpcreatecontent = $cpcreatecontent.'<span style="padding-left:7px"> <a target = "_blank" href="'.$new_cp_linkedin.'" title="'.$new_cp_linkedin.'"><i class="fa fa-linkedin" aria-hidden="true"></i></a></span>';
				}
				if($new_cp_twitter != 'Unknown'){
					$cpcreatecontent = $cpcreatecontent.'<span style="padding-left:7px"><a target = "_blank" href="'.$new_cp_twitter.'" title="'.$new_cp_twitter.'"><i class="fa fa-twitter" aria-hidden="true"></i></a></span>';
				}
				if($new_cp_youtube != 'Unknown'){
					$cpcreatecontent = $cpcreatecontent.'<span style="padding-left:7px"><a target = "_blank" href="'.$new_cp_youtube.'" title="'.$new_cp_youtube.'"><i class="fa fa-youtube" aria-hidden="true"></i></a></span>';
				}
			$cpcreatecontent = $cpcreatecontent."</div>";
			$cpcreatecontent = $cpcreatecontent.'<div><a href="#"><i class="fa fa-building-o" aria-hidden="true"></i></a> '.$new_cp_address.'</div><div><a href="'.$new_cp_url.'"><i class="fa fa-globe" aria-hidden="true"></i></a> '.$new_cp_url.'</div><div><a href="tel:'.$new_cp_phone.'"><i class="fa fa-phone" aria-hidden="true"></i></a> '.$new_cp_phone.'</div>'.'<div><a href="mailto:'.$new_cp_email.'"><i class="fa fa-envelope"></i></a> '.$new_cp_email.'</div> </div><br>'.'<div class="whiteblock" style="display:none;"><h2 style="margin-top:10px !important;margin-bottom:10px !important">Product Information</h2><ul><li><a href="#">Manufacturer Size: </a><br>'.$new_cp_staffno.'</li>'.'<li><a href="#">Crystalline</a><br>'.$new_cp_crystalline.'<br>Power Range (Wp): '.$new_cp_cprl.'-'.$new_cp_cprh.'</li>'.'<li><a href="#">High Efficiency Crystalline</a><br>'.$new_cp_high_eff.'<br>Power Range (Wp): '.$new_cp_hecprl.'-'.$new_cp_hecprh.'</li>'.'</ul>';
            $cpcreatecontent = $cpcreatecontent."</div>";
                
            $cpcreatecontent = $cpcreatecontent.'<div class="whiteblock"><br>Own or work here? <a href="https://shop.solarfeeds.com/claim-your-mnfctr-page/" target="_blank">Claim Now!</a> <br><br></div><br>';
            if(count($related_profiles)> 0){
            $cpcreatecontent = $cpcreatecontent.'<div class="whiteblock"><h2 style=" line-height: 0.1;"> Related Profiles</h2>';
		
                foreach($related_profiles as $related){
                    $c_url = str_replace(",","",$related["name"]);
                    $c_url = str_replace(".","",$c_url);
                    $c_url = str_replace(' ', '-', $c_url);
                    $cpcreatecontent = $cpcreatecontent.'<a href="https://shop.solarfeeds.com/brands/'.$c_url.'">'.$related["name"].'</a></br>';
                    }
			
            $cpcreatecontent = $cpcreatecontent.'<br><br></div><br>';
            }
            $cpcreatecontent = $cpcreatecontent. "</aside>";
            
            $cpcreatecontent = $cpcreatecontent."<?php get_footer(); ?>";
             
            $new_cp_name = str_replace(' ', '-', $new_cp_name);
            $new_cp_name = str_replace(',', '', $new_cp_name);
            $new_cp_name = str_replace('.', '', $new_cp_name);
 
 
            $cpwritefoldername = $_SERVER['DOCUMENT_ROOT']."/brands/".$new_cp_name;
             
            if (!file_exists($cpwritefoldername)) {
                mkdir($cpwritefoldername, 0777, true);
            }

            $cpwritefilename = $cpwritefoldername."/index.php";
            $cpwritefile     = file_put_contents($cpwritefilename,$cpcreatecontent);
         }
     }
     wp_redirect( 'https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustomsubpage&company_id='.$new_cp_id );
 }
 

 /**
 *  Manufacturer Profile form 
 * 
 *  @since  1.0.0
 */

    echo '<form action="" method="POST" onsubmit="setFormSubmitting()" enctype="multipart/form-data" enctype="multipart/form-data">';
    echo '<input id="createcpid" name="createcpid" type="hidden" value="1">';
    echo '<table>';
    echo '<tr><td><label for="cpname">Manufacturer Name: </label></td>';
    echo '<td><input type="text" id="cpname" name="cpname" required></td></tr>';
    add_action ('admin_enqueue_scripts', function() {
        if(is_admin())
            wp_enqueue_media(); 
        });
    
    echo '<input type="text" class="process_custom_images example-jpg-file" id="example-jpg-file" name="example-jpg-file" value=""><button class="set_custom_logo button" style="vertical-align: middle;">Select Manufacturer Logo</button>';
    
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
 
 
    /** Manufacturer Profile Table1 */
    echo '<tr><td><label for="cpaddress">Manufacturer Address: </label></td>';
    echo '<td><input type="text" id="cpaddress" name="cpaddress"></td></tr>';

    echo '<tr><td><label for="cpphone">Phone: </label></td>';
    echo '<td><input type="text" id="cpphone" name="cpphone"></td></tr>';

    echo '<tr><td><label for="cpemail">Email: </label></td>';
    echo '<td><input type="text" id="cpemail" name="cpemail"></td></tr>';

    echo '<tr><td><label for="cpurl">Url: </label></td>';
    echo '<td><input type="text" id="cpurl" name="cpurl"></td></tr>';

    echo '<tr><td><label for="cpregion">Region: </label></td>';
    echo '<td><input type="text" id="cpregion" name="cpregion"></td></tr>';
    
    echo '<tr><td><label for="cpfacebook">Facebook: </label></td>';
    echo '<td><input type="text" id="cpfacebook" placeholder="https://www.facebook.com" name="cpfacebook"></td></tr>';

    echo '<tr><td><label for="cplinkedin">Linkedin: </label></td>';
    echo '<td><input type="text" id="cplinkedin" placeholder="https://www.linkedin.com" name="cplinkedin"></td></tr>';

    echo '<tr><td><label for="cptwitter">Twitter: </label></td>';
    echo '<td><input type="text" id="cptwitter" placeholder="https://twitter.com" name="cptwitter"></td></tr>';

    echo '<tr><td><label for="cpyoutube">YouTube: </label></td>';
    echo '<td><input type="text" id="cpyoutube"  placeholder="https://www.youtube.com" name="cpyoutube"></td></tr>';

    echo '<tr><td><label for="cpabout">About: </label></td>';
    $content   = '';
    $editor_id = 'cpabout';
    $settings  = array( 'media_buttons' => true);

    echo '<td>';
    wp_editor( $content, $editor_id, $settings );
    echo '</td></tr>';

    echo '</tr></table>';

    echo '<br><br>';


    /** Manufacturer Profile Table2 */
    echo '<table>';
    echo '<tr><td><label for="cpstaff_no">Manufacturer Size: </label></td><td><input type="text" id="cpstaff_no" name="cpstaff_no"></td></tr>';
    echo '<tr><td><label for="cpcrystalline">Crystalline: </label></td><td><input type="text" id="cpcrystalline" name="cpcrystalline"></td></tr>';
    echo '<tr><td><label for="cpcprl">Crystalline Power Range (Low): </label></td><td><input type="text" id="cpcprl" name="cpcprl"></td></tr>';
    echo '<tr><td><label for="cpcprh">Crystalline Power Range (High): </label></td><td><input type="text" id="cpcprh" name="cpcprh"></td></tr>';
    echo '<tr><td><label for="cphigh_eff">High Efficiency Crystalline: </label></td><td><input type="text" id="cphigh_eff" name="cphigh_eff"></td></tr>';
    echo '<tr><td><label for="cphecprl">High Efficiency Crystalline Power Range (Low): </label></td><td><input type="text" id="cphecprl" name="cphecprl"></td></tr>';
    echo '<tr><td><label for="cphecprh">High Efficiency Crystalline Power Range (High): </label></td><td><input type="text" id="cphecprh" name="cphecprh"></td></tr>';
    echo '</table>';

     /** Manufacturer Profile update_Table3 */
	echo '<table>';
	echo '<tr><td><label for="cpcomtype">Component Type: </label></td><td><input type="text" id="cpcomtype" name="cpcomtype" ></td></tr>';
	echo '<tr><td><label for="cpme">Mounting Equipment: </label></td><td><input type="text" id="cpme" name="cpme" ></td></tr>';
	echo '</table>';
            
    
    /** Add More btn */
    echo '<br><br>Reviews&nbsp;&nbsp;&nbsp;<button type="button" onclick="addreviews()">Add More</button><br><br>';       
            
    echo '<script>function addreviews() {var s=document.getElementsByClassName("accordion").length+1;document.getElementById("reviewdemo").innerHTML =document.getElementById("reviewdemo").innerHTML+\'<button id="\'+String(s)+\'" type="button" class="accordion">New</button><div id="plus\'+String(s)+\'" class="panel"><label for="cpreviewname\'+String(s)+\'">Name: </label><textarea id="cpreviewname\'+String(s)+\'" name="cpreviewname\'+String(s)+\'" rows="1" cols="50"></textarea><br><label for="cpreviewcontent\'+String(s)+\'">Content: </label><textarea id="cpreviewcontent\'+String(s)+\'" name="cpreviewcontent\'+String(s)+\'" rows="4" cols="50"></textarea><br><br><button type="button" onclick="deletereviews(\'+String(s)+\')">Delete</button><br><br></div>\';var acc = document.getElementsByClassName("accordion");var i;for (i = 0; i < acc.length; i++) {acc[i].addEventListener("click", function() {this.classList.toggle("active");var panel = this.nextElementSibling;if (panel.style.maxHeight) {panel.style.maxHeight = null;} else {panel.style.maxHeight = panel.scrollHeight + "px";} });}}</script>';
    
    echo '<script>function deletereviews(a) {var myobj = document.getElementById(String(a));myobj.remove();var myobjplus = document.getElementById("plus"+String(a));myobjplus.remove();}</script>';
   
    echo '<style>.accordion {background-color: lightblue;color: #444;cursor: pointer;padding: 18px;width: 100%;border: none;text-align: left;outline: none;font-size: 15px;transition: 0.4s;}.active, .accordion:hover {background-color: #ccc;}.accordion:after {content: "\002B";color: #777;font-weight: bold;float: right;margin-left: 5px;}.active:after {content: "\2212";}.panel {padding: 0 18px;background-color: white;max-height: 0;overflow: hidden;transition: max-height 0.2s ease-out;}</style>';
    
    echo '<span id="reviewdemo">';
    echo '</span>';

    echo '<script>var acc = document.getElementsByClassName("accordion");var i;for (i = 0; i < acc.length; i++) {acc[i].addEventListener("click", function() {this.classList.toggle("active");var panel = this.nextElementSibling;if (panel.style.maxHeight) {panel.style.maxHeight = null;} else {panel.style.maxHeight = panel.scrollHeight + "px";} });}</script>';
    
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
            
    echo '<div><button id="btn_addnews" onclick="openmorenews();">Add More News</button></div>';
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
    
            
    echo '<br><br>';
    echo '<input type="submit" value="Submit">';
    echo '&nbsp;&nbsp;<span><a href="https://shop.solarfeeds.com/wp-admin/admin.php?page=cpcustompage">Back to Manufacturer Profile List</a></span>';
    echo '</form>';
   
    $conn->close();

?>