<?php
 
 function realted_manufacturer($region, $cat, $crystalline){
   $conn  = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   
   if ($crystalline != ''){
      $sql = "select * from company_profile_short WHERE region = '".$region."' AND company_id in (select company_id from company_profile where (crystalline is not NULL AND crystalline != '') OR (com_type like '%".$cat."%'))";
    }
    else {
      $sql = "select * from company_profile_short WHERE region = '".$region."' AND company_id in (select company_id from company_profile where (crystalline is NULL OR crystalline = '') OR (com_type like '%".$cat."%'))";
    }
   $result   = $conn->query($sql);
   if ($result->num_rows > 0) {
    $sorted_data = array();
    while($row_detail = $result->fetch_assoc()) {
        $c_id = $row_detail['company_id'];
        $filter_manufecturer[]['company_id'] = $c_id;

        $news = count_news_length($c_id);
        $reviews = count_reviews_length($c_id);
        $about = strlen($row_detail['about']);
        $score = $news + $reviews + $about;
        $row_detail['score'] = $score;
        
        array_push( $sorted_data, $row_detail );
    } 
   usort($sorted_data, function($a, $b) {
      return $b['score'] - $a['score'];
    }); 
    return array_slice($sorted_data, 0, 10);
    //return $sorted_data;
   }
 
}

function count_reviews_length($company_id){
  $conn  = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   $cp_sql_reviews     = "SELECT SUM(CHAR_LENGTH(CONCAT(review_name,review_content))) AS reviewslength FROM company_profile_reviews WHERE company_id = ".$company_id;
    $result   = $conn->query($cp_sql_reviews);
    if ($result->num_rows > 0) {
      $row_detail = $result->fetch_assoc();
        return $row_detail['reviewslength'];
    }
    else {
      return 0;
    }
}

function count_news_length($company_id){
  $conn  = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   $cp_sql_reviews     = "SELECT SUM(CHAR_LENGTH(CONCAT(content,title))) AS newslength FROM company_profile_news WHERE company_id = ".$company_id;
    $result   = $conn->query($cp_sql_reviews);
   
    if ($result->num_rows > 0) {
      $row_detail = $result->fetch_assoc();
      return $row_detail['newslength'];
    } else {
      return 0;
    }
}

?>