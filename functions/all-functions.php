<?php
class allfunctions extends database{
    // print_r function
    public function pre($arr){
        echo '<pre>';
        print_r($arr);
        exit();
    }
    // get mysql real escape string
    public function real_string($var){
        return trim($this->connect()->real_escape_string($var));
    }
    // special character remove
    public function RemoveSpecialChar($str){
        $res = str_replace( array( '\'', '"',
        ',' , ';', '<', '>' ), '', $str);
        return $res;
    }
    // alert and redirect
    public function alertRedirect($message,$reditectUrl){
        echo '<script type="text/javascript" language="javascript">
        		alert("'.$message.'");
                window.location = "'.$reditectUrl.'";
        	  </script>';
    }
}
?>