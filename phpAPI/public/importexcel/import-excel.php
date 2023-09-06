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
                if($val != "N/A"){
                    $EXCEL_DATE = $val;
                    $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
                    $new_date = gmdate("Y-m-d", $UNIX_DATE);
                    $new_excel_content_fixed_date[$ar_counter][$key] = $new_date;
                }
                else{
                    $new_excel_content_fixed_date[$ar_counter][$key] = $val;   
                } 
                
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
            

            if($data['table'] == 'equipments'){

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
                    
                }

                $category_name = '';
                if(str_contains( $key , 'Category')){
                    //filter Category
                    $allowed_category = [
                        'Mechanical','Electrical','Fire Protection','Plumbing & Sanitary','Civil','Structural'
                    ];
                    $category_name = $val;
                    $row_number = $ar_counter + 2;
                    if(!in_array($category_name, $allowed_category)){
                        array_push($excel_errors,"Uknown Category on '<b>{$category_name}</b>'  on row </b>{$row_number}</b> <a href='#' onclick='show_equipment_category_list()'>See List</a>");
                    }

                    //filter Category
                }
                if(str_contains( $key , 'Type')){
                    //filter Category
                    $allowed_type = [
                        'Mechanical'=>[
                            'Air-conditioning',
                            'Elevator',
                            'Fire Detection & Alarm System',
                            'Pumps',
                            'Generator',
                            'building Management System',
                            'CCTV',
                            'Pressurization Blower /  Fan',
                            'Exhaust Fan',
                            'Gondola',
                            'Others'
                        ],
                        'Electrical'=>[
                            'Transformers',
                            'UPS',
                            'Automatic Transfer Switch',
                            'Control Gear',
                            'Switch Gear',
                            'Capacitor',
                            'Breakers / Panel Boards',
                            'Meters',
                            'Others'
                        ],
                        'Fire Protection'=>[
                            'Sprinklers',
                            'Smoke Detectors',
                            'Manual Pull Stations',
                            'Fire Alarm',
                            'FDAS Panel',
                            'Others'
                        ],
                        'Plumbing & Sanitary'=>[
                            'Others'
                        ],
                        'Civil'=>[
                            'Others'
                        ],
                        'Structural'=>[
                            'Others'
                        ]
                    ];
                    $js_en = json_encode($allowed_type);
                    $type = $val;
                    $row_number = $ar_counter + 2;
                    $category = str_replace(' ','_',$ex_con['Category']);
                    $category = str_replace('&','',$category);

                    if(!in_array($type, $allowed_type[$ex_con['Category']])){
                        array_push($excel_errors,"Uknown Type'<b>{$type}</b>' on '<b>{$ex_con['Category']} Category</b>'  on row </b>{$row_number}</b> <a href='#' onclick='show_equipment_type_list(\"{$category}\")'>See List</a>");
                    }
                    

                    //filter Category
                }

                //VALIDATION OF UNIQUE NAME
                if(str_contains( $key , 'Equipment Name')){
                    $table = "{$account_db}.equipments"; 
                    $equipment_name = $val;
                    $sql = "select * from {$table} WHERE deleted_on=0 and equipment_name = '{$equipment_name}'";
                    $record_sth = $db->prepare($sql);
                    $record_sth->execute([]);
                    $result = $record_sth->fetch();
                    
                    $row_number = $ar_counter + 2;
                    if($result){
                        array_push($excel_errors,"Duplicate entry of Equipment Name '<b>{$equipment_name}</b>'  on row </b>{$row_number}</b>");
                    }
                }
                
                
            }
            if($data['table'] == 'meters'){
                if($key == 'Tenant'){
                    $table = "{$account_db}.tenant"; 
                    $tenant_name = $val;
                    $sql = "select * from {$table} WHERE deleted_on=0 and owner_name = '{$tenant_name}'";
                    $record_sth = $db->prepare($sql);
                    $record_sth->execute([]);
                    $result = $record_sth->fetch();
                    
                    $row_number = $ar_counter + 2;
                    if(!$result){
                        if($val != 'Common Area'){
                            array_push($excel_errors,"Uknown Tenant '<b>{$tenant_name}</b>'  on row </b>{$row_number}</b>");
                        }
                        else{
                            $new_excel_content_fixed_date[$ar_counter][$key] = 'Common Area';        
                        }
                        
                    }
                    else{
                        $new_excel_content_fixed_date[$ar_counter][$key] = $result['id'];    
                    }
                }

                //VALIDATION OF UNIQUE NAME
                if(str_contains( $key , 'Meter Name')){
                    $table = "{$account_db}.meters;"; 
                    $meters_name = $val;
                    $sql = "select * from {$table} WHERE deleted_on=0 and meter_name = '{$meters_name}'";
                    $record_sth = $db->prepare($sql);
                    $record_sth->execute([]);
                    $result = $record_sth->fetch();
                    
                    $row_number = $ar_counter + 2;
                    if($result){
                        array_push($excel_errors,"Duplicate entry of Meter Name '<b>{$meters_name}</b>'  on row </b>{$row_number}</b>");
                    }
                }
            }

            //VALIDATION OF UNIQUE NAME
            if($data['table'] == 'service_providers'){
                if(str_contains( $key , 'Company')){
                    $table = "{$account_db}.service_providers"; 
                    $service_provider_name = $val;
                    $sql = "select * from {$table} WHERE deleted_on=0 and company = '{$service_provider_name}'";
                    $record_sth = $db->prepare($sql);
                    $record_sth->execute([]);
                    $result = $record_sth->fetch();
                    
                    $row_number = $ar_counter + 2;
                    if($result){
                        array_push($excel_errors,"Duplicate entry of Company '<b>{$service_provider_name}</b>'  on row </b>{$row_number}</b>");
                    }
                }
            }

            if($data['table'] == 'tenant'){
                if(str_contains( $key , 'Username')){
                    $table = "{$account_db}.tenant"; 
                    $tenant_uname = $val;
                    $sql = "select * from {$table} WHERE deleted_on=0 and tenant_username = '{$tenant_uname}'";
                    $record_sth = $db->prepare($sql);
                    $record_sth->execute([]);
                    $result = $record_sth->fetch();
                    
                    $row_number = $ar_counter + 2;
                    if($result){
                        array_push($excel_errors,"Duplicate entry of Username '<b>{$tenant_uname}</b>'  on row </b>{$row_number}</b>");
                    }
                }
            }
            
            if($data['table'] == 'building_personnel'){
                if(str_contains( $key , 'Email')){
                    $table = "{$account_db}.building_personnel"; 
                    $personnel_uname = $val;
                    $sql = "select * from {$table} WHERE deleted_on=0 and email = '{$personnel_uname}'";
                    $record_sth = $db->prepare($sql);
                    $record_sth->execute([]);
                    $result = $record_sth->fetch();
                    
                    $row_number = $ar_counter + 2;
                    if($result){
                        array_push($excel_errors,"Duplicate entry of Email '<b>{$personnel_uname}</b>'  on row </b>{$row_number}</b>");
                    }
                }
            }
            
            if($data['table'] == 'permits'){
                if(str_contains( $key , 'Permit Name')){
                    $table = "{$account_db}.permits"; 
                    $permits_name = $val;
                    $sql = "select * from {$table} WHERE deleted_on=0 and permit_name = '{$permits_name}'";
                    $record_sth = $db->prepare($sql);
                    $record_sth->execute([]);
                    $result = $record_sth->fetch();
                    
                    $row_number = $ar_counter + 2;
                    if($result){
                        array_push($excel_errors,"Duplicate entry of Permit Name '<b>{$permits_name}</b>'  on row </b>{$row_number}</b>");
                    }
                }
            }

            if($data['table'] == 'contracts'){
                if(str_contains( $key , 'Contract Name')){
                    $table = "{$account_db}.contracts"; 
                    $contracts_name = $val;
                    $sql = "select * from {$table} WHERE deleted_on=0 and contract_name = '{$contracts_name}'";
                    $record_sth = $db->prepare($sql);
                    $record_sth->execute([]);
                    $result = $record_sth->fetch();
                    
                    $row_number = $ar_counter + 2;
                    if($result){
                        array_push($excel_errors,"Duplicate entry of Contract Name '<b>{$contracts_name}</b>'  on row </b>{$row_number}</b>");
                    }
                }
            }

        }
        $ar_counter++;
    }
    //Validate

    $new_excel_content = $new_excel_content_fixed_date;
    

    $excel_rows = $new_excel_content;
    // print_r($excel_rows);
    
    $c =0;
    foreach($excel_rows as $in => $row){
        unset($excel_rows[$c]['']);
        $c++;
    }
    // column names that are allowed to be blanks
    $allowed_blanks = [
        'Owner Spouse',
        'Tenant Name',
        'Tenant Email Address',
        'Tenant Username',
        'Below threshold'
    ];
    foreach($excel_rows as $in => $row){
        $val_ctr=0;
        foreach(array_values($row) as $val){
            
            if($val == '' || $val== '1899-12-30'){
                $row_number = $in + 2;
                $column_ = array_keys($row)[$val_ctr];
                if(!in_array(array_keys($row)[$val_ctr],$allowed_blanks))
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
            if($data['table'] == 'meters'){
                //to adjust the excel header to db column
                if($key == 'use')
                    $key = 'meter_use';
            }


            array_push($keys,strtolower($key));
        }
        foreach(array_values($row) as $index=>$val){
            array_push($vals,$val);
        }

        array_push($keys,'created_on');
        array_push($keys,'created_by');
        array_push($keys,'deleted_on');
        
        
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