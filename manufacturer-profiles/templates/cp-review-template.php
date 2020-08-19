<?php
/**
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

 * Template Name: Review Page
 * 
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <script src='https://www.google.com/recaptcha/api.js' async defer ></script>
    <!-- Font Awesome Icon Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.checked {
  color: #fd6b21;
}
.mfp-primary {
    color: #fd6b21;
}
.mfp-review-box {
    display: block;
    overflow: hidden;
    width: 768px;
    margin: 40px auto;
    padding-top:50px 0;
}
.mfp-flex-box {
    display: flex;
    flex-flow: row;
    flex-wrap: wrap;
    padding: 15px;
}

.mfp-rating-overall {
    display: flex;
    flex-wrap: nowrap;
}
.mfp-flex-col {
    flex:0 0 40%;
}
.mfp-col-40 {
    flex:0 0 40%;
}
.mfp-col-60 {
    flex:0 0 60%;
}
.mfp-col-100 {
    flex:0 0 100%;
}
.mfp-col-30 {
    flex:0 0 30%;
}
.mfp-col-10 {
    flex:0 0 10%;
}
.mfp-border-light {
    border: solid 1px #efefef;
}
.mfp-rating-overall {
    margin-bottom: 10px;
}
.mfp-rating-count {
    background: #ffe3d2;
    width: 80px;
    padding: 5px;
    border-radius: 5px;
    color: #fd6b21;
    text-align: center;
    margin-right: 10px;
}
#mfp-rating-total {
    font-size: 30px;
    font-weight: bold;
}
.mfp-center {
    text-align: center;
}
.mfp-rating-message {
    font-weight: bold;
}
.mfp-error {
    background: #c33;
    color: #fff;
    border-left: solid 5px #0581c7;
}
.mfp-error ul li {
    padding: 7px 2px;
    list-style: none;
}
.mfp-success {
    background: #0581c7;
    color: #fff;
    padding: 8px;
    text-align: center;
    border-left: solid 10px #2b3;
}
button, .submit {
    background: #0581c7;
    color: #fff;
    float: right;
    border: none;
    padding: 7px 20px;
}
.additional_cmnt {
    -webkit-transition: 2s;
    transition: 2s;
}
/* Ratings widget */
.rate {
    display: inline-block;
    border: 0;
}
/* Hide radio */
.rate > input {
    display: none;
}
/* Order correctly by floating highest to the right */
.rate > label {
    float: right;
}
/* The star of the show */
.rate > label:before {
    display: inline-block;
    font-size: 2.1rem;
    padding: .3rem .2rem;
    margin: 0;
    cursor: pointer;
    font-family: FontAwesome;
    content: "\f005 "; /* full star */
}
/* Zero stars rating */
.rate > label:last-child:before {
    content: "\f006 "; /* empty star outline */
}
/* Half star trick */
.rate .half:before {
    content: "\f089 "; /* half star no outline */
    position: absolute;
    padding-right: 0;
}
/* Click + hover color */
input:checked ~ label, /* color current and previous stars on checked */
label:hover, label:hover ~ label { color: #FE541B;  } /* color previous stars on hover */

/* Hover highlights */
/*input:checked + label:hover, input:checked ~ label:hover, /* highlight current and previous stars */
input:checked ~ label:hover ~ label, /* highlight previous selected stars for new rating */
label:hover ~ input:checked ~ label  /*highlight previous selected stars */ { color: #A6E72D;  } 

/*mfp-modal*/

/* The mfp-modal (background) */
.mfp-modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 50px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* mfp-modal Content */
.mfp-modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 480px;
  min-height: 600px;
}

/* The Close Button */
.mfp-close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.mfp-close:hover,
.mfp-close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
.additional_cmnt span {
    font-size: 12px;
    float: left;
    font-style: italic;
}
#reviewSubmit {
    margin-top: 20px;
}

@media only screen and (max-width: 768px) {
    .mfp-review-box {
        width: auto;
        margin: 40px 20px;
    }
    .mfp-col-40, .mfp-col-60, .mfp-col-100, .mfp-col-30, .mfp-col-10 {
        flex:0 0 100%;
    }
    .mfp-flex-col {
        flex:0 0 100%;
    }
    .mfp-center {
        text-align:left;
    }
    fieldset {
        padding-left: 0;
    }

}



@media only screen and (max-width: 480px) {
    .mfp-modal-content {
        width: 90%;
    }

}

</style>
</head>
<?php
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $table_reviewer        = "company_profile_reviewer";
    $table_review          = "company_profile_review";
    /**
     * Request validation
     */
    if(isset($_GET['verify'])){
        if(!empty($_GET['verify']) AND !empty($_GET['_email']) AND !empty($_GET['_salt']) AND !empty($_GET['id'])) {
            $_email = $_GET['_email'];
            $_salt = $_GET['_salt'];
           
            $cp_verifyq     = "SELECT * FROM ".$table_reviewer." WHERE email = '".$_email."' AND _salt ='".$_salt."'";
            $cp_result_verify  = $conn->query($cp_verifyq);
            if ($cp_result_verify->num_rows > 0) {
                $timestamp = date("Y-m-d H:i:s");

                $cp_update     = "UPDATE ".$table_review." SET verified = 1, verified_at ='".$timestamp."' WHERE id=".$_GET['id'];
                $cp_result_update  = $conn->query($cp_update);
                if($conn->affected_rows > 0){
                    echo "<p class='mfp-success'>Your review has been verified successfully!</p>";
                } else {
                    //echo $conn->error;
                    echo "<p class='mfp-error'>Review verification failed! please try again</p>";
                }
            } else {
                echo "<p class='mfp-error'>Review verification failed! please try to submit a new review</p>";
            }

            exit();
        } else {
            echo "<p class='mfp-error'>inavlid request</p>";
            exit();
        }
    }
    $cpid = get_query_var('_mf_id');
    if(empty($cpid)){
        echo "<p class='mfp-error'>Invalid Request</p>";
        exit();
    } else {
            $dic = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$converted = apply_filters('cp_convert_base', $cpid, $dic, '0123456789'); 
			$cpid = intval($converted)-3248564;
    }

    /*
   $del = "DELETE FROM $table_reviewer WHERE id";
   $conn->query($del);
    $del = "DELETE FROM $table_review WHERE reviewer_id";
   $conn->query($del);
*/
    $errMsg = array();
    $msg ="";
    if(isset($_POST['save'])){
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
        {
               
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LeSLL8ZAAAAAMhmn3fSpaMrPOuDIYeRz3iZQFpG&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);
                if($responseData->success)
                {
                   // $succMsg = 'Your contact request have submitted successfully.';
                   // print_r($_POST);
                    $email  = $_POST['remail'];
                    $name   = $_POST['rname'];
                    $c_name = $_POST['rcname'];
                    $phone  = $_POST['rphone'];
                    $ss      = $_POST['SS'];
                    $ots     = $_POST['OTS'];
                    $pq      = $_POST['PQ'];
                    $supplier_service_comment     = $_POST['supplier_service_comment'];
                    $one_time_comment             = $_POST['one_time_comment'];
                    $product_quality_comment      = $_POST['product_quality_comment'];
                    $overall     = $_POST['overall_rating'];
                    if($email == "") {
                        $errMsg[] = "Email is required";
                    } elseif($name ==""){
                        $errMsg[] = "Name is required";
                    } elseif($c_name ==""){
                        $errMsg[] = "Company Name is required";
                    } elseif($phone ==""){
                        $errMsg[] = "Phone Number is required";
                    } elseif($ss ==""){
                        $errMsg[] = "Pease rate Suplier Service";
                    } elseif($ots ==""){
                        $errMsg[] = "Pease rate On-Time Shipment";
                    } elseif($pq ==""){
                        $errMsg[] = "Pease rate Product Quality";
                    } elseif($supplier_service_comment ==""){
                        $errMsg[] = "Additional Comment is required";
                    } elseif($one_time_comment ==""){
                        $errMsg[] = "Additional Comment is required";
                    } elseif($product_quality_comment ==""){
                        $errMsg[] = "Additional Comment is required";
                    }
                    else {
                       
                    
                        //Save reviewer data
                        $cp_sql_check     = "SELECT * FROM ".$table_reviewer." WHERE email = '".$email."'";
                        $cp_result_check  = $conn->query($cp_sql_check);

                        if ($cp_result_check->num_rows > 0) {
                            while($row = $cp_result_check->fetch_assoc()) {
                                $reviewer_id = $row["id"];       
                            }
                            $hash = md5( rand(0,1000) );  
                            $cp_update_reviwer     = "UPDATE ".$table_reviewer." SET _salt = '".$hash."' WHERE id=".$reviewer_id;
                            $cp_res_reviwer  = $conn->query($cp_update_reviwer);

                        } else { 
                            $hash = md5( rand(0,1000) );
                            $cp_rvr_insertq   = "INSERT INTO ".$table_reviewer." (email,name,company_name,phone,_salt) VALUES ('".$email."', '".$name."', '".$c_name."', '".$phone."','".$hash."');";
                            $cp_rvr_insert = $conn->query($cp_rvr_insertq);
                            
                            if ($cp_rvr_insert === TRUE) {
                                // "reiewer create";
                                $reviewer_id = $conn->insert_id;
                            } else {
                                //echo "Error:" .$conn->error;
                                $errMsg[] = "Error in review submission. Please try later.";
                            }
                        }
                        //Save review data
                        if(!empty($reviewer_id)){
                            //check if already submitted
                            
                            $cp_sql_check     = "SELECT * FROM ".$table_review." WHERE reviewer_id = ".$reviewer_id." AND company_id =".$cpid;
                            $cp_result_check  = $conn->query($cp_sql_check);
                
                            if ($cp_result_check->num_rows > 0) {
                               $errMsg[] = "You have already submitted a review for this company";
                            }
                            else {
                                
                                $cp_rv_insertq   = "INSERT INTO ".$table_review." (company_id,reviewer_id,supplier_service_count, supplier_service_comment, one_time_shipment, one_time_comment, product_quality, product_quality_comment, overall_rating, verified) VALUES ($cpid, $reviewer_id, $ss, '".$supplier_service_comment."', $ots, '".$one_time_comment."', $pq, '".$product_quality_comment."', $overall, 0);";
                                $cp_rv_insert = $conn->query($cp_rv_insertq);
                                
                                if ($cp_rv_insert === TRUE) {
                                    $review_id = $conn->insert_id;
                                   
                                    $email_subject = "Verify Email";
                                    //Send Mail
                                    $headers[] = "Content-Type: text/html; charset=UTF-8";
                                    $headers[]= "From: Solarfeeds <infor@shop.solarfeeds.com>";
                                    
                                    ob_start();
                                    include("cp-verify-email.php");
                                    $message = ob_get_contents();
                                    ob_end_clean();
                                    if(wp_mail($email, $email_subject, $message, $headers)) {
                                       $msg = "A verification mail has been sent to your email address. Please Check your inbox";
                                    } else {
                                        $errMsg[] = "Error in sending verification email. Please try again.";
                                    }
                                } else {
                                       //echo "Error:" .$conn->error;
                                       $errMsg[] = "Error in review submission. Please try later.";
                                }
                            }
                            
                        } //save review
                    } 
                } else { // captcha verification faild
                    $errMsg[] = "Captcha verification failed, please try again.";
                }
        } else { //captcha missing
            $errMsg[] = "Invalid request";
        }
    } //  form action
?>
<body class="cleanpage">
<?php
    while ( have_posts() ) : the_post();  
        the_content();
    endwhile;
?>

<div class="mfp-review-box">
    <?php if(count($errMsg) > 0) { ?>
        <div class="mfp-error">
            <ul>
                <?php foreach($errMsg as $error){
                    echo "<li>".$error."</li>";
                }
                ?>
            </ul>
        </div>
    <?php } 
    if($msg != "") {
        echo "<p class='mfp-success'>".$msg."</p>";
    }
    ?>
    <form action="" method="post" enctype="multitype/formdata">
    <div class="mfp-rating-overall">
        <div class="mfp-rating-count">
            <span id="mfp-rating-total">5.0</span>/<span class="mfp-outoff">5</span>
            <input type="hidden" name="overall_rating" />
        </div>
        <div>
              <span class="mfp-rating-message" id="mfp-rating-message">Very Satisfied</span><br/>
              <span class="mfp-total-reviews">30 Reviews</span>
        </div>
        
    </div>
    <div class="mfp-flex-box mfp-border-light">
        <div class="mfp-col-40">
            <span>Suplier Service</span>
        </div>
        <div class="mfp-col-30 mfp-center"> 
            <fieldset class="rate" id="SS">
                <input type="radio" id="rating10SS" name="SS" value="5.0" /><label for="rating10SS" title="5 stars"></label>
                <input type="radio" id="rating9SS" name="SS" value="4.5" /><label class="half" for="rating9SS" title="4 1/2 stars"></label>
                <input type="radio" id="rating8SS" name="SS" value="4.0" /><label for="rating8SS" title="4 stars"></label>
                <input type="radio" id="rating7SS" name="SS" value="3.5" /><label class="half" for="rating7SS" title="3 1/2 stars"></label>
                <input type="radio" id="rating6SS" name="SS" value="3.0" /><label for="rating6SS" title="3 stars"></label>
                <input type="radio" id="rating5SS" name="SS" value="2.5" /><label class="half" for="rating5SS" title="2 1/2 stars"></label>
                <input type="radio" id="rating4SS" name="SS" value="2.0" /><label for="rating4SS" title="2 stars"></label>
                <input type="radio" id="rating3SS" name="SS" value="1.5" /><label class="half" for="rating3SS" title="1 1/2 stars"></label>
                <input type="radio" id="rating2SS" name="SS" value="1.0" /><label for="rating2SS" title="1 star"></label>
                <input type="radio" id="rating1SS" name="SS" value="0.5" /><label class="half" for="rating1SS" title="1/2 star"></label>
                <input type="radio" id="rating0SS" name="SS" value="0" />
            </fieldset>
            <div class="additional_cmnt" style="display:none">
            <label for="supplier_service_comment">Additional Comment</label>
            <textarea id ="supplier_service_comment" name="supplier_service_comment" onkeyup="showlength(this);"> </textarea>   
            <span></span>         
            </div>
        </div>
        <div class="mfp-col-10">
            <span class="displayMsg"></span>
        </div>
        <div class="mfp-col-20 mfp-primary">
            <span class="showMsg"></span>
        </div>
       
    </div>
  
    <div class="mfp-flex-box">
        <div class="mfp-col-40">
            <span>On-Time Shipment</span>
        </div>
        <div class="mfp-col-30 mfp-center"> 
            <fieldset class="rate" id="OTS">
                <input type="radio" id="rating10OTS" name="OTS" value="5.0" /><label for="rating10OTS" title="5 stars"></label>
                <input type="radio" id="rating9OTS" name="OTS" value="4.5" /><label class="half" for="rating9OTS" title="4 1/2 stars"></label>
                <input type="radio" id="rating8OTS" name="OTS" value="4.0" /><label for="rating8OTS" title="4 stars"></label>
                <input type="radio" id="rating7OTS" name="OTS" value="3.5" /><label class="half" for="rating7OTS" title="3 1/2 stars"></label>
                <input type="radio" id="rating6OTS" name="OTS" value="3.0" /><label for="rating6OTS" title="3 stars"></label>
                <input type="radio" id="rating5OTS" name="OTS" value="2.5" /><label class="half" for="rating5OTS" title="2 1/2 stars"></label>
                <input type="radio" id="rating4OTS" name="OTS" value="2.0" /><label for="rating4OTS" title="2 stars"></label>
                <input type="radio" id="rating3OTS" name="OTS" value="1.5" /><label class="half" for="rating3OTS" title="1 1/2 stars"></label>
                <input type="radio" id="rating2OTS" name="OTS" value="1.0" /><label for="rating2OTS" title="1 star"></label>
                <input type="radio" id="rating1OTS" name="OTS" value="0.5" /><label class="half" for="rating1OTS" title="1/2 star"></label>
                <input type="radio" id="rating0OTS" name="OTS" value="0" />
            </fieldset>
            <div class="additional_cmnt" style="display:none">
            <label for="one_time_comment">Additional Comment</label>
              <textarea name="one_time_comment" id="one_time_comment" onkeyup="showlength(this);"></textarea> 
              <span></span>
            </div>
        </div>
        <div class="mfp-col-10">
            <span class="displayMsg"></span>
        </div>
        <div class="mfp-col-20 mfp-primary">
            <span class="showMsg"></span>
        </div>
    </div>
    <div class="mfp-flex-box mfp-border-light">
        <div class="mfp-col-40">
            <span>Product Quality</span>
        </div>
        <div class="mfp-col-30 mfp-center"> 
            <fieldset class="rate" id="PQ">
                <input type="radio" id="rating10PQ" name="PQ" value="5.0" /><label for="rating10PQ" title="5 stars"></label>
                <input type="radio" id="rating9PQ" name="PQ" value="4.5" /><label class="half" for="rating9PQ" title="4 1/2 stars"></label>
                <input type="radio" id="rating8PQ" name="PQ" value="4.0" /><label for="rating8PQ" title="4 stars"></label>
                <input type="radio" id="rating7PQ" name="PQ" value="3.5" /><label class="half" for="rating7PQ" title="3 1/2 stars"></label>
                <input type="radio" id="rating6PQ" name="PQ" value="3.0" /><label for="rating6PQ" title="3 stars"></label>
                <input type="radio" id="rating5PQ" name="PQ" value="2.5" /><label class="half" for="rating5PQ" title="2 1/2 stars"></label>
                <input type="radio" id="rating4PQ" name="PQ" value="2.0" /><label for="rating4PQ" title="2 stars"></label>
                <input type="radio" id="rating3PQ" name="PQ" value="1.5" /><label class="half" for="rating3PQ" title="1 1/2 stars"></label>
                <input type="radio" id="rating2PQ" name="PQ" value="1.0" /><label for="rating2PQ" title="1 star"></label>
                <input type="radio" id="rating1PQ" name="PQ" value="0.5" /><label class="half" for="rating1PQ" title="1/2 star"></label>
                <input type="radio" id="rating0PQ" name="PQ" value="0" />
            </fieldset>
            <div class="additional_cmnt" style="display:none">
                <label for="product_quality_comment">Additional Comment</label>
                <textarea id = "product_quality_comment" name="product_quality_comment" onkeyup="showlength(this);"> </textarea>
                <span></span>
            </div>
        </div>
        <div class="mfp-col-10">
            <span class="displayMsg"></span>
        </div>
        <div class="mfp-col-20 mfp-primary">
            <span class="showMsg"></span>
        </div>
    </div>
    <button id="reviewSubmit">Submit</button>
    <div id="reviewModal" class="mfp-modal">

  <!-- Modal content -->
  <div class="mfp-modal-content">
  
    <span class="mfp-close">&times;</span>
    <div style="text-align:center;">We need the following information to verify your submission. Thank you.</div>
        <label for="remail">Email</label>
        <input type="text" id="remail" name="remail" placeholder="Your email.." required="required">

        <label for="rname">Name</label>
        <input type="text" id="rname" name="rname" placeholder="Your Name.." required="required">

        <label for="rcname">Company Name</label>
        <input type="text" id="rcname" name="rcname" placeholder="Company Name.." required="required">

        <label for="rphone">Phone</label>
        <input type="text" id="rphone" name="rphone" placeholder="Phone.." required="required">
        <div class="g-recaptcha" data-sitekey="6LeSLL8ZAAAAAPgy0hupdigc64BdortOkMokizBv"></div>
        <input type="submit" class="submit" name="save" value="Submit">

        
   
  </div>

</div>
</form>
</div>


<script>

    var ratingsArr={'SS':0,'PQ':0,'OTS':0};
    let getMain = document.querySelectorAll('.mfp-flex-box');
    let star = document.querySelectorAll('input[type=radio]');


    for (let i = 0; i < star.length; i++) {
        star[i].addEventListener('click', function(){
            let showMsg = this.parentElement.parentElement.nextElementSibling.nextElementSibling.querySelector('span');
            let displayMsg = this.parentElement.parentElement.nextElementSibling.querySelector('span');
            let showCmnt = this.parentElement.parentElement.querySelector('.additional_cmnt');
            showCmnt.style.display ="block";
            console.log({showMsg});
           j = this.value;
           if(j > 4.5){
               showMsg.innerHTML = "Very Satisfied";
           }else if(j >=3.5 && j <= 4.5 ){
               showMsg.innerHTML = "Satisfied";
           }else if(j >=2.5 && j < 3.5 ){
               showMsg.innerHTML = "Average";
           }else if(j >=1.5 && j < 3.5 ){
               showMsg.innerHTML = "Needs improvement";
           }else if(j >= 0.5 && j < 2.5 ){
               showMsg.innerHTML = "Poor";
           }
           displayMsg.innerHTML = j;
           console.log(this.getAttribute('name'));
           ratingsArr[this.getAttribute('name')]=parseFloat(j);
           sum=k=0;
           for (const property in ratingsArr) {
                console.log(ratingsArr[property]);
                sum+=(ratingsArr[property]);
                k++;
                // console.log(`${property}: ${object[property]}`);
            }
            avg=sum/k;
            avg = avg.toFixed(1);
            if(avg > 4.5){
               finalMsg = "Very Satisfied";
            }else if(avg >=3.5 && avg <= 4.5 ){
                finalMsg = "Satisfied";
            }else if(avg >=2.5 && avg < 3.5 ){
                finalMsg = "Average";
            }else if(avg >=1.5 && avg < 3.5 ){
                finalMsg = "Needs improvement";
            }else if(avg >= 0.5 && avg < 2.5 ){
                finalMsg = "Poor";
            }
            document.querySelector('#mfp-rating-total').innerHTML=avg;
            document.querySelector('input[name=overall_rating]').value =avg;
            document.querySelector('#mfp-rating-message').innerHTML=finalMsg;
          // console.log({ratingsArr});
        })     
    }
    // Get the modal
    var modal = document.getElementById("reviewModal");

    // Get the button that opens the modal
    var btn = document.getElementById("reviewSubmit");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("mfp-close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        if(validateForm()){
            modal.style.display = "block";
        }
       
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    function showlength(textarea){
        let wcount = textarea.value.match(/\S+/g);
        wcount =  parseInt(wcount.length, 10);
        if(wcount < 250){
            textarea.nextElementSibling.innerHTML=250-wcount+" More words required";
        } else  {
            textarea.nextElementSibling.innerHTML="";
        }

            
    };
    function validateForm() {
        let ssc_count = otc_count = pqc_count = 0;
        let row_0 = document.querySelectorAll('input[name=SS]');
        let row_1 = document.querySelectorAll('input[name=OTS]');
        let row_2 = document.querySelectorAll('input[name=PQ]');
        let ssc = document.getElementById("supplier_service_comment");
        let otc = document.getElementById("one_time_comment");
        let pqc = document.getElementById("product_quality_comment");
        


        let redcount = 250;

        let row0Valid = row1Valid = row2Valid = false;

        let i = 0;
        while (!row0Valid && i < row_0.length) {
            if (row_0[i].checked) row0Valid = true;
            i++;        
        }
         i = 0;
        while (!row1Valid && i < row_1.length) {
            if (row_1[i].checked) row1Valid = true;
            i++;        
        }
         i = 0;
        while (!row2Valid && i < row_2.length) {
            if (row_2[i].checked) row2Valid = true;
            i++;        
        }
        //check comments
         

        if (!row0Valid || !row1Valid || !row2Valid){
            alert("Must provide rating for all options!");
           
        } else {
            if(ssc.value != "" && otc.value != "" && pqc.value != ""){
                ssc_count = ssc.value.match(/\S+/g);
                ssc_count = parseInt(ssc_count.length, 10);
                otc_count = otc.value.match(/\S+/g);
                otc_count = parseInt(otc_count.length, 10);
                pqc_count = pqc.value.match(/\S+/g);
                pqc_count = parseInt(pqc_count.length, 10);

                if(ssc_count < redcount || otc < redcount || pqc_count < redcount) {
                    alert("Atleast 250 words are required for each comment!");
                    
                } else {
                    return true;
                }
            }  else {
                alert("All additional comments are required!");
            }
        }
        
    }

    
   </script>
<?php wp_footer(); ?>
</body>
</html>