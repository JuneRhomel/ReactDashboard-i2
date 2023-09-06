<?php 
$return_value = [    'success' => 1,
    'description' => 'Desc',
];
$excel_errors = [];
try{
    
    // print_r($data);
    if (!function_exists('str_contains')) {
        function str_contains($haystack, $needle) {
            return $needle !== '' && mb_strpos($haystack, $needle) !== false;
        }
    }
    $excel_content = $data['excel_content'];
    //fix the date

    $new_excel_content_fixed_date = [];
    $ar_counter = 0;
    foreach($excel_content as $ex_con){
        // print_r($ex_con);
        foreach($ex_con as $key => $val){
            if(str_contains( $key , 'Date')){
                // echo "this key has date ." . $key;
                $EXCEL_DATE = $val;
                $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
                $new_date = gmdate("Y-m-d", $UNIX_DATE);
                
                $new_excel_content_fixed_date[$ar_counter][$key] = $new_date;
            }else{
                $new_excel_content_fixed_date[$ar_counter][$key] = $val;
            }
            
        }
        $ar_counter++;
    }

    //Validate Service Provider
    $ar_counter = 0;
    foreach($new_excel_content_fixed_date as $ex_con){
        foreach($ex_con as $key => $val){
            
            if(str_contains( $key , 'Service Provider')){
                $table = "{$account_db}.service_providers_view"; 
                $service_provider_name = $val;
                $sql = "select * from {$table} WHERE deleted_on=0 and company = '{$service_provider_name}'";
                $record_sth = $db->prepare($sql);
                $record_sth->execute([]);
                $result = $record_sth->fetch();
                
                $row_number = $ar_counter + 2;
                if(!$result){
                    array_push($excel_errors,"Uknown Service Provider '<b>{$service_provider_name}</b>'  on row </b>{$row_number}</b>");
                }
                else{
                    $new_excel_content_fixed_date[$ar_counter][$key] = $result['id'];    
                }
                
            }else{
                $new_excel_content_fixed_date[$ar_counter][$key] = $val;
            }
            
        }
        $ar_counter++;
    }

    $new_excel_content = $new_excel_content_fixed_date;
    // exit();
    //verifying database;connection

    $excel_rows = $new_excel_content;

    //remove the blank
    $c =0;
    foreach($excel_rows as $in => $row){
        unset($excel_rows[$c]['']);
        $c++;
    }
    foreach($excel_rows as $in => $row){
        $val_ctr=0;
        foreach(array_values($row) as $val){
            
            if($val == '' || $val== '1899-12-30'){
                $row_number = $in + 2;
                $column_ = array_keys($row)[$val_ctr];
                $column_ = str_replace('_',' ', $column_);
                $column_ = ucwords($column_);
                array_push($excel_errors,"Missing values on row <b>{$row_number}</b> on '<b>{$column_}</b>' column ");
            }
            $val_ctr++;
        }
    }
    if(count($excel_errors) == 0){
        // echo "no Error";
    }
    else{
        throw new Exception('There are errors on Excel Sheets');
    }

    // print_r($excel_rows);
    foreach($excel_rows as $in => $row){
        
        $keys = [];
        $vals = [];
        // Filtering the array
        foreach (array_keys($row) as $key){

            


            $key = strtolower($key);
            $key = str_replace(' ','_', $key);
            $key = str_replace('(company)','', $key);
            $key = str_replace('#','number', $key);
            $key = rtrim($key,'_');

            
            if($data['table'] == 'tenant'){
                //to adjust the excel header to db column
                if($key == 'unit_owner_name')
                    $key = 'owner_name';
                if($key == 'contact_detail')
                    $key = 'owner_contact';
                if($key == 'email')
                    $key = 'owner_email';
                if($key == 'username')
                    $key = 'owner_username';
                if($key == 'unit')
                    $key = 'unit_id';
                if($key == 'tenant_email_address')
                    $key = 'tenant_email';
                if($key == 'floor_area')
                    $key = 'unit_area';
            }
            if($data['table'] == 'tenant'){
                //to adjust the excel header to db column
            }


            array_push($keys,strtolower($key));
        }
        foreach(array_values($row) as $index=>$val){
            array_push($vals,$val);
        }

        //removing the last_line
        // array_pop($keys);
        //adding new keys
        
        array_push($keys,'created_on');
        array_push($keys,'created_by');
        array_push($keys,'deleted_on');
        
        // print_r($keys);
        // print_r($vals);
        
        //adding new vals
        array_push($vals,time());
        array_push($vals,$user_token['user_id']);
        array_push($vals,0);
        // print_r($vals);
        
        $sql =  "insert into {$account_db}.{$data['table']} (" . implode(",",$keys) . ") values(?" . str_repeat(",?",count($keys)-1) .")\n";
        $sth = $db->prepare($sql);
        // print_r($sth);
        $sth->execute($vals);
        
        $rec_id = $db->lastInsertId();
        if($data['view_table']){
            array_push($keys, 'rec_id');
            
            array_push($vals, $rec_id);
            
            $sql =  "insert into {$account_db}.{$data['view_table']} (" . implode(",",$keys) . ") values(?" . str_repeat(",?",count($keys)-1) .")\n";
            $sth = $db->prepare($sql);
            
            $sth->execute($vals);
        }

        if($data['update_table']){
            $update_keys = [];
            $update_vals = [];

            array_push($update_keys,'created_on');
            array_push($update_keys,'created_by');
            array_push($update_keys,'deleted_on');
            array_push($update_keys,'status');

            array_push($update_vals,time());
            array_push($update_vals,$user_token['user_id']);
            array_push($update_vals,0);
            array_push($update_vals,'new');


            if($data['table'] == 'contracts'){
                array_push($update_keys,'contract_number');
                array_push($update_keys,'effectivity_date');
                array_push($update_keys,'expiration_date');
                array_push($update_keys,'contract_id');

                array_push($update_vals,$vals[1]);
                array_push($update_vals,$vals[2]);
                array_push($update_vals,$vals[4]);
                array_push($update_vals,$rec_id);
            }
            if($data['table'] == 'permits'){
                array_push($update_keys,'permit_number');
                array_push($update_keys,'date_issued');
                array_push($update_keys,'expiration_date');
                array_push($update_keys,'permit_id');

                array_push($update_vals,$vals[1]);
                array_push($update_vals,$vals[3]);
                array_push($update_vals,$vals[5]);
                array_push($update_vals,$rec_id);
            }


            $sql =  "insert into {$account_db}.{$data['update_table']} (" . implode(",",$update_keys) . ") values(?" . str_repeat(",?",count($update_keys)-1) .")\n";
            $sth = $db->prepare($sql);
            
            $sth->execute($update_vals);
        }
    
    }
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql'=> $sq,'excel_errors'=>$excel_errors];
}
echo json_encode($return_value);



