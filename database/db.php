<?php
    class database{
        private $servername;
        private $username;
        private $password;
        private $databasename;
    
        protected function connect(){
            $this->servername = 'localhost';
            $this->username = 'u481674619_ltl';
            $this->password = 'u481674619_Ltl';
            $this->databasename = 'u481674619_ltl';
            $con = new mysqli($this->servername, $this->username, $this->password, $this->databasename);
            return $con;
        }
    }

    class query extends database{
        //select data
        public function getData($field,$table,$joins,$condition,$order_by_field='',$order_by_type='',$limit=''){
            
            $sql = "SELECT $field FROM `$table`";
            if($joins != ''){
                foreach($joins as $join){
                    $sql = $sql." ".$join[0]." JOIN `".$join[1]."` ON `".$join[2]."`.`".$join[3]."` = `".$join[4]."`.`".$join[5]."` ";
                }
            }
            $sql = rtrim($sql, 'AND ');
            if($condition != ''){
                $sql = $sql. ' WHERE ';
                if(count($condition) == count($condition, COUNT_RECURSIVE)){
                    foreach($condition as $key=>$val){
                        $sql = $sql. "`".$key."`" ."=". "'".$val."'" . ' AND ';
                    }
                }else{
                    foreach($condition as $condval){
                        $sl = 0;
                        foreach($condval as $val){
                            if($sl == 0){
                                $sql = $sql." `".$val."`";
                            }elseif($sl == 1){
                                $sql = $sql." ".$val;
                            }else{
                                if($val != "order_date"){
                                    $sql = $sql." '".$val."'";
                                }else{
                                    $sql = $sql." `".$val."`";
                                }
                            }
                            $sl++;
                        }
                        $sql = str_replace("'type_id'", "`type_id`", str_replace("'user_type'", "`user_type`", str_replace("'BETWEEN'", "BETWEEN", str_replace("'IS'", "IS", str_replace('"IS"', 'IS', str_replace('"NULL"', 'NULL', str_replace("'NULL'", "NULL", str_replace("'pickup_date'", "`pickup_date`", str_replace("'status'", "`status`", str_replace("'='", "=", str_replace("')", ")", str_replace("('", "(", str_replace(")'", ")", str_replace("'(", "(", str_replace("'!='", "!=", str_replace("'<='", "<=", str_replace("'=<'", "=<", str_replace("'>'", ">",str_replace("'<'", "<", str_replace("'=>'", "=>", str_replace("'>='", ">=", str_replace("`OR`", "OR", str_replace("'OR'", "OR", str_replace("'AND'", "AND", $sql))))))))))))))))))))))));
                        $sql = $sql.' AND ';
                    }
                }
            }
            if(preg_match("/ OR /i", $sql)){
                $sql = str_replace("OR", " AND `orders`.`lr_status` = 'show' OR ", $sql);
            }
            if($table == "orders"){
                if(!preg_match("/WHERE/i", $sql)){
                    $sql .= " WHERE ";
                }
                $sql .= " `orders`.`lr_status` = 'show'";
            }
            $sql = rtrim($sql, 'AND ');
            if($order_by_field != ''){
                $sql = $sql.' ORDER BY `'.$order_by_field.'` '.$order_by_type;
            }
            if($limit != ''){
                $sql = $sql.' LIMIT '.$limit;
            }
            $sql = str_replace("`RAND()`", "RAND()", $sql);
            // die($sql);
            $result = $this->connect()->query($sql);
            if($result->num_rows > 0){
                $arr = array();
                while($row = $result->fetch_assoc()){
                    $arr[] = $row;
                }
                return $arr;
            }
            else{
                return 0;
            }
        }
        

        // insert data
        public function insertData($table,$condition){
            
            if($condition != ''){
                foreach($condition as $key=>$val){
                    $colname[] = $key;
                    $valname[] = $val;
                }
                $cols = "`".implode("`, `", $colname)."`";
                $vals = "'".implode("', '", $valname)."'";
                $sqli = "INSERT INTO `$table` ($cols) VALUES ($vals)";
            }
            // die($sqli);
            $result = $this->connect()->query($sqli);
            return $result;
        }
    
        // delete data
        public function deleteData($table,$condition){
            
            if($condition != ''){
                $sqli = '';
                foreach($condition as $key=>$val){
                    $sqli = $sqli . $key."`" ."=". "'".$val."'" . ' and ';
                }
                $sqli = rtrim($sqli, 'and ');
                $sqld = "DELETE FROM `$table` WHERE $sqli";
            }
            $result = $this->connect()->query($sqld);
            return $result;
        }
    
        // update data
        public function updateData($table,$condition,$field_name,$field_value){
            
            if($condition != ''){
                $sqlu = 'UPDATE `'.$table.'` SET ';
                foreach($condition as $key=>$val){
                    $sqlu = $sqlu . "`".$key."`" ."=". "'".$val."'" . ', ';
                }
                $sqlu = rtrim($sqlu, ', ');
                $sqlu = $sqlu." WHERE `$field_name`='$field_value'";
            }
            // die($sqlu);
            $result = $this->connect()->query($sqlu);
            return $result;
        }
    }
