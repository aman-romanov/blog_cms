<?php
/**
 * Validation for article forms
 * 
 * @param string $title is Title of the article,
 * @param string $content is body of the article,
 * @param string $date is the publication date and time (yyyy-mm-dd hh:mm:ss)
 * 
 * @return array An array of the errors made while filling the article
 */
    function validateArticle($title, $content, $date){
        
        $error = [];
        
        if ($title == ''){
            $error[] = "Article title is required!";
        }
        if ($content == ''){
            $error[] = "Article content is not filled!";
        }
    
        if($date != ""){
            $date_time = date_create_from_format('Y-m-d H:i:s', $date);
            if($date_time === false){
                $error[] = 'Invalid date and time';
            }else{
                $date_errors = date_get_last_errors();
                if($date_errors['warning_count'] > 0){
                    $error[] = 'Invalid date and time';
                }
            }
        }

        return $error;
    }
?>