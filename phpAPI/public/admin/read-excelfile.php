<?php 
$return_value = ['success'=>1,'description'=>''];
$excel_errors = [];
try{   
    $excel_content = $data['excel_content'];
    $table = $data['table'];
    
    // INIT UNIQUE FIELDS AND LABELS OF ERROR MESSAGE
    $unique = $data['unique'];   

    //*********************************************************************
    // LOCATION
    //*********************************************************************
    if ($table=='location') {
        // VALIDATIONS
        $ct=0;
        foreach($excel_content as $content) {
            if ($ct>0) { // SKIP FIRST ROW WITH FIELD LABEL

                //---------------------------------------------------------------------
                // CHECK FOR DUPLICATES
                //---------------------------------------------------------------------
                $condition = "";
                foreach($content as $key=>$val) {
                    if ($key=="location_name") {
                        $condition .= "and location_name='$val' ";
                        $fieldname = $val;
                    }
                    if ($key=="location_type")
                        $condition .= "and location_type='$val' ";
                    /*$label = searchArray($key,$unique);
                    if ($label!='') {
                        $uniques[] = "{$key}='{$val}'";
                    }*/
                }
                $sql = "select * from {$account_db}.{$table} where deleted_on=0 $condition";
                $sth = $db->prepare($sql);
                $sth->execute([]);
                $result = $sth->fetch();
                if ($result && $condition) {
                    array_push($excel_errors,"Duplicate record in database with Location <u>{$fieldname}</u> on <u>row ".($ct+2)."</u>.");
                }
                // .CHECK FOR DUPLICATES ----------------------------------------------

                //---------------------------------------------------------------------
                // CHECK FOR REQUIRED FIELDS
                //---------------------------------------------------------------------
                //$required = ['location_name','location_type','location_use','parent_location','floor_area','status'];
                // .CHECK FOR REQUIRED FIELDS -----------------------------------------

            }
            $ct++;
        }

        if ($excel_errors)
            throw new Exception('There are errors in the excel file. Please correct them and reupload again.');

        // SAVE DATA
        $ct=0;
        foreach($excel_content as $row) {
            if ($ct>0) { // SKIP FIRST ROW WITH FIELD LABEL
                foreach($row as $key=>$val) {
                    if ($key=="parent_location") {
                        $sth = $db->prepare("select * from {$account_db}.location where location_name=?");
                        $sth->execute([$val]);
                        $result = $sth->fetch();       
                        if ($result)
                            $row['parent_location_id'] = $result['id'];
                    }
                }
                unset($row['parent_location']);
                $row['created_by'] = $user_token['user_id'];
                $row['created_on'] = time();
                $fields = array_keys($row);
                $sql0 = $fields;
                $sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
                $sth->execute($row);
            }
            $ct++;
        }

    //*********************************************************************
    // RESIDENT
    //*********************************************************************
    } elseif ($table=="resident") {
        // VALIDATIONS
        $ct=0;
        foreach($excel_content as $content) {
            if ($ct>0) { // SKIP FIRST ROW WITH FIELD LABEL

                //---------------------------------------------------------------------
                // CHECK FOR DUPLICATES
                //---------------------------------------------------------------------
                $condition = "";
                foreach($content as $key=>$val) {
                    if ($key=="first_name") {
                        $condition .= "and first_name='$val' ";
                        $fieldname = $val;
                    }
                    if ($key=="last_name") {
                        $condition .= "and last_name='$val' ";
                        $fieldname .= ' '.$val;
                    }
                    if ($key=="email") {
                        $condition .= "and email='$val' ";
                        $fieldname .= ' '.$val;
                    }
                }
                $sql = "select * from {$account_db}.{$table} where deleted_on=0 $condition";
                $sth = $db->prepare($sql);
                $sth->execute([]);
                $result = $sth->fetch();
                if ($result) {
                    array_push($excel_errors,"Duplicate record in database with Resident Name <u>{$fieldname}</u> on <u>row ".($ct+2)."</u>.");
                }
                // .CHECK FOR DUPLICATES ----------------------------------------------

                //---------------------------------------------------------------------
                // CHECK FOR REQUIRED FIELDS
                //---------------------------------------------------------------------
                //$required = ['first_name','last_name','type','unit','contact_no','email'];
                // .CHECK FOR REQUIRED FIELDS -----------------------------------------
            }
            $ct++;
        }

        if ($excel_errors)
            throw new Exception('There are errors in the excel file. Please correct them and reupload again.');

        // SAVE DATA
        $ct=0;
        foreach($excel_content as $row) {
            if ($ct>0) { // SKIP FIRST ROW WITH FIELD LABEL
                foreach($row as $key=>$val) {
                    $row['unit_id'] = 0;
                    if ($key=="unit") {
                        $sth = $db->prepare("select * from {$account_db}.location where location_name=?");
                        $sth->execute([$val]);
                        $result = $sth->fetch(); 
                        if ($result)                   
	                        $row['unit_id'] = $result['id'];
                    }
                }
                unset($row['unit_name']);
                $row['created_by'] = $user_token['user_id'];
                $row['created_on'] = time();
                $fields = array_keys($row);
                $sth = $db->prepare("insert {$account_db}.occupant_reg (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
                $sth->execute($row);            
            }
            $ct++;
        }

    //*********************************************************************
    // METER
    //*********************************************************************
    } elseif ($table=="meter") {
        // VALIDATIONS
        $ct=0;
        foreach($excel_content as $content) {
            if ($ct>0) { // SKIP FIRST ROW WITH FIELD LABEL

                //---------------------------------------------------------------------
                // CHECK FOR DUPLICATES
                //---------------------------------------------------------------------
                $condition = $cond_mother = "";
                foreach($content as $key=>$val) {
                    if ($key=="meter_name") {
                        $condition .= "and meter_name='$val' ";
                        $fieldname = $val;
                        $metername = $val;
                    }
                    if ($key=="utility_type") {
                        $condition .= "and utility_type='$val' ";
                        $cond_mother .= "and utility_type='$val' ";
                        $fieldname = $val;
                        $utility_type = $val;
                    }
                    if ($key=="meter_type") {
                        $condition .= "and meter_type='$val' ";
                        $fieldname = $val;
                        if ($val=="Mother Meter")
                            $cond_mother .= "and meter_type='$val' ";
                    }
                }
                $sql = "select * from {$account_db}.{$table} where deleted_on=0 $condition";
                $sth = $db->prepare($sql);
                $sth->execute();
                $result = $sth->fetch();
                if ($result) {
                    array_push($excel_errors,"Duplicate record in database with Meter <u>{$fieldname}</u> on <u>row ".($ct+2)."</u>.");
                }
                // .CHECK FOR DUPLICATES ----------------------------------------------

                //---------------------------------------------------------------------
                // CHECK FOR REQUIRED FIELDS
                //---------------------------------------------------------------------
                //$required = ['location_name','location_type','location_use','parent_location','floor_area','status'];
                // .CHECK FOR REQUIRED FIELDS -----------------------------------------

                //---------------------------------------------------------------------
                // CHECK FOR DUPLICATE MOTHER METER OF SAME METER TYPE
                //---------------------------------------------------------------------
                if (strpos($cond_mother,"Mother Meter")!==false) {
                    $sql = "select * from {$account_db}.{$table} where deleted_on=0 $cond_mother";
                    $sth = $db->prepare($sql);
                    $sth->execute();
                    $result = $sth->fetch();
                    if ($result) {
                        array_push($excel_errors,"Mother meter for {$utility_type} already exist. Pls remove meter <u>{$metername}</u> on <u>row ".($ct+2)."</u>.");
                    }
                }
                // .CHECK FOR DUPLICATE MOTHER METER OF SAME METER TYPE ---------------

            }
            $ct++;
        }

        if ($excel_errors)
            throw new Exception('There are errors in the excel file. Please correct them and reupload again.');

        // SAVE DATA
        $ct=0;
        foreach($excel_content as $row) {
            if ($ct>0) { // SKIP FIRST ROW WITH FIELD LABEL
                foreach($row as $key=>$val) {
                    if ($key=="location") {
                        $sth = $db->prepare("select * from {$account_db}.location where location_name=?");
                        $sth->execute([$val]);
                        $result = $sth->fetch();                                            
                        if ($result)
                            $row['location_id'] = $result['id'];
                        else
                            $row['location_id'] = 0;
                    }
                    if ($key=="unit") {
                        $sth = $db->prepare("select * from {$account_db}.location where location_name=?");
                        $sth->execute([$val]);
                        $result = $sth->fetch();                    
                        if ($result)
                            $row['unit_id'] = $result['id'];
                        else
                            $row['unit_id'] = 0;
                    }
                }
                unset($row['location']);
                unset($row['unit']);
                $row['created_by'] = $user_token['user_id'];
                $row['created_on'] = time();
                $fields = array_keys($row);
                $sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
                $sth->execute($row);            
            }
            $ct++;
        }

    //*********************************************************************
    // CONTRACT
    //*********************************************************************
    } elseif ($table=="contract") {
        // VALIDATIONS
        $ct=0;
        foreach($excel_content as $content) {
            if ($ct>0) { // SKIP FIRST ROW WITH FIELD LABEL

                //---------------------------------------------------------------------
                // CHECK FOR DUPLICATES
                //---------------------------------------------------------------------
                $condition = "";
                foreach($content as $key=>$val) {
                    if ($key=="contract_number") {
                        $condition .= "and contract_number='$val'";                    
                    }
                    if ($key=="contract_name") {
                        $condition .= "and contract_name='$val'";
                        $fieldname = $val;
                    }
                }
                $sql = "select * from {$account_db}.{$table} where deleted_on=0 $condition";
                $sth = $db->prepare($sql);
                $sth->execute([]);
                $result = $sth->fetch();
                if ($result) {
                    array_push($excel_errors,"Duplicate record in database with Contract <u>{$fieldname}</u> on <u>row ".($ct+2)."</u>.");
                }
                // .CHECK FOR DUPLICATES ----------------------------------------------

                //---------------------------------------------------------------------
                // CHECK FOR REQUIRED FIELDS
                //---------------------------------------------------------------------
                //$required = ['location_name','location_type','location_use','parent_location','floor_area','status'];
                // .CHECK FOR REQUIRED FIELDS -----------------------------------------

            }
            $ct++;
        }

        if ($excel_errors)
            throw new Exception('There are errors in the excel file. Please correct them and reupload again.');

        // SAVE DATA
        $ct=0;
        foreach($excel_content as $row) {
            if ($ct>0) { // SKIP FIRST ROW WITH FIELD LABEL
                foreach($row as $key=>$val) {
                    if ($key=="resident") {
                        $sth = $db->prepare("select * from {$account_db}.vw_resident where fullname=?");
                        $sth->execute([$val]);
                        $result = $sth->fetch();                                            
                        if ($result)
                            $row['resident_id'] = $result['id'];
                    }
                    if ($key=="unit") {
                        $sth = $db->prepare("select * from {$account_db}.location where location_name=?");
                        $sth->execute([$val]);
                        $result = $sth->fetch();                    
                        if ($result)
                            $row['unit_id'] = $result['id'];
                    }
                    if ($key=="start_date" || $key=="end_date") {
                        if ($val != "N/A") {
                            $row[$key] = gmdate("Y-m-d", ($val - 25569) * 86400);
                        }
                    }
                } // FOREACH $ROW   
                
                unset($row['resident']);
                unset($row['unit']);
                $row['created_by'] = $user_token['user_id'];
                $row['created_on'] = time();
                $fields = array_keys($row);
                $sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
                $sth->execute($row);

                // UPDATE UNIT IN RESIDENT TABLE            
                $sth = $db->prepare("update {$account_db}.resident set unit_id=? where id=?");
                $sth->execute([ $row['unit_id'], $row['resident_id'] ]);
            }
            $ct++;
        }        
    }  // if table

    $return_value = ['success'=>1, 'description'=>'Successfully imported the file.', 'content'=>$content, 'sql'=>$sql];
}catch(Exception $e){
	$return_value = ['success'=>0, 'description'=>$e->getMessage(), 'sql'=>$sql0, 'excel_errors'=>$excel_errors, 'content'=>$row];
}
echo json_encode($return_value);