<?php
 
 function get_10_related_lists($region,$cat,$crystalline){
   $conn  = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   //$data = "SELECT * FROM company_profile INNER JOIN company_profile_short ON company_profile.company_id = company_profile_short.company_id WHERE company_profile_short.region= ".$region;	
  // $x = "SELECT * FROM company_profile";

   if ($crystalline != ''){
     if ($cat == 'Solar_Panels'){
       $sql = "SELECT * FROM company_profile_short WHERE region = ".$region." AND company_id IN (SELECT company_id FROM company_profile WHERE (crystalline != '') OR (com_type like '%".str_replace('_',' ',$cat)."%')))";
     }
    else {
       $sql = "SELECT * FROM company_profile_short WHERE region = ".$region." AND company_id in (SELECT company_id FROM company_profile WHERE (crystalline == '') OR (com_type like '%".str_replace('_',' ',$cat)."%')))";
    }
    
}
   $result   = $conn->query($sql);
   $row_news = $result->fetch_assoc();
	return $row_news;
}

?>