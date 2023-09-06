<?php
// header('Content-Type: application/json; charset=utf-8');
$return_value = ['success'=>1,'description'=>'','data'=>[],'test'=>'test'];
// print_r($data);
// exit();
try{
	if($data['verify']){
		// print_r($data);
		
		$sql = "SELECT * FROM " . DB_NAME . "_" . $data['account_id'] . "._users WHERE fcm_token = :fcm_token ";
		$sth = $db->prepare($sql);
		$sth->execute(['fcm_token'=>$data['verify']]);
		$user = $sth->fetch();
		$full_name = $user['full_name'];

		$sql = "select * from " . DB_NAME . ".accounts where id=:account_id";
		$sth = $db->prepare($sql);
		$sth->execute(['account_id'=>$data['account_id']]);
		$account = $sth->fetch();
		$account_code = $account['account_code'];
		
		
		// print_r($user);
		if(!$user)
			throw new Exception("link Not Valid");
		//exit();
	}

	if($data['step'] == 2 ){
		// print_r($data);
		// exit();
		$account_id = 0;
		$user_id = 0;
		$sth = $db->prepare("insert into otsi2.accounts (account_code) values('{$data['account_code']}')");
		//print_r($sth);
		
		$sth->execute();
		$account_id = $db->lastInsertId();
		
		if($account_id){
			$otsi2_database = "otsi2_{$account_id}";
			$sql = "CREATE DATABASE {$otsi2_database}";
	
			$sth = $db->prepare($sql);
			$sth->execute();
			//Create _users Table
			$sql = "CREATE TABLE `{$otsi2_database}`.`_users` (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`user_name` char(100) NOT NULL DEFAULT '',
				`email` char(100) NOT NULL DEFAULT '',
				`full_name` char(100) NOT NULL DEFAULT '',
				`first_name` char(100) NOT NULL DEFAULT '',
				`middle_name` char(100) NOT NULL DEFAULT '',
				`last_name` char(100) NOT NULL DEFAULT '',
				`company` char(100) NOT NULL DEFAULT '',
				`designation` char(100) NOT NULL DEFAULT '',
				`password` char(255) NOT NULL DEFAULT '',
				`photo` char(100) DEFAULT NULL,
				`created_by` bigint(20) NOT NULL DEFAULT 0,
				`created_at` int(11) NOT NULL DEFAULT 0,
				`updated_by` bigint(20) NOT NULL DEFAULT 0,
				`updated_at` int(11) NOT NULL DEFAULT 0,
				`deleted_at` int(11) NOT NULL DEFAULT 0,
				`deleted_by` bigint(20) NOT NULL DEFAULT 0,
				`is_active` tinyint(1) NOT NULL DEFAULT 1,
				`fcm_token` char(255) DEFAULT NULL,
				`system_user` tinyint(1) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`),
				UNIQUE KEY `user_name` (`user_name`)
			) ";
	
			$sth = $db->prepare($sql);
			$sth->execute();
			//create users first
			
			$sth = $db->prepare("insert into {$otsi2_database}._users (full_name, designation, company) values(?,?,?)");
			$sth->execute([$data['profile']['fullname'] , $data['profile']['designation'] , $data['profile']['company_name']]);
			$user_id = $db->lastInsertId();
			
			// _roles
			$sql = "CREATE TABLE `{$otsi2_database}`.`_roles` (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`role_name` char(100) NOT NULL DEFAULT '',
				`description` char(255) NOT NULL DEFAULT '',
				`created_by` bigint(20) NOT NULL DEFAULT 0,
				`created_at` int(11) NOT NULL DEFAULT 0,
				`updated_by` bigint(20) NOT NULL DEFAULT 0,
				`updated_at` int(11) NOT NULL DEFAULT 0,
				`deleted_at` int(11) NOT NULL DEFAULT 0,
				`deleted_by` bigint(20) NOT NULL DEFAULT 0,
				`is_active` tinyint(1) NOT NULL DEFAULT 1,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1";
			
			$sth = $db->prepare($sql);
			$sth->execute();
	
			// create ROles
			$sth = $db->prepare("insert into {$otsi2_database}._roles (role_name) values(?)");
			$sth->execute(['admin']);
			$role_id = $db->lastInsertId();

			$sql = "CREATE TABLE `{$otsi2_database}`.`roles` (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`role_name` char(100) NOT NULL DEFAULT '',
				`description` char(255) NOT NULL DEFAULT '',
				`created_by` bigint(20) NOT NULL DEFAULT 0,
				`created_at` int(11) NOT NULL DEFAULT 0,
				`deleted_at` int(11) NOT NULL DEFAULT 0,
				`deleted_by` bigint(20) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1";
			
			$sth = $db->prepare($sql);
			$sth->execute();
	
			// create ROles
			$sth = $db->prepare("insert into {$otsi2_database}.roles (role_name) values(?)");
			$sth->execute(['admin']);
			$roles_id = $db->lastInsertId();
	
			// Settings
			$sql = "CREATE TABLE `{$otsi2_database}`.`_settings` (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`created_by` bigint(20) NOT NULL DEFAULT 0,
				`created_at` int(11) NOT NULL DEFAULT 0,
				`updated_by` bigint(20) NOT NULL DEFAULT 0,
				`updated_at` int(11) NOT NULL DEFAULT 0,
				`deleted_at` int(11) NOT NULL DEFAULT 0,
				`deleted_by` bigint(20) NOT NULL DEFAULT 0,
				`is_active` tinyint(1) NOT NULL DEFAULT 0,
				`setting_name` char(100) DEFAULT NULL,
				`setting_value` char(255) DEFAULT NULL,
				`setting_label` char(100) DEFAULT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `setting_name` (`setting_name`)
			
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();

			// settings
			$sql = "insert into  `{$otsi2_database}`._settings (setting_name,setting_value, setting_label) values ('soa_due_dates','30','SOA DUE DATES');";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = " insert into `{$otsi2_database}`._settings (setting_name,setting_value, setting_label) values ('vat','12','VAT');";
			$sth = $db->prepare($sql);
			$sth->execute();
			//tenant tokens
			$sql = "CREATE TABLE `{$otsi2_database}`.`_tenant_tokens` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`tenant_id` int(11) NOT NULL DEFAULT 0,
				`token` char(32) DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `tenant_token` (`token`)
			) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=latin1 ";
	
			//User Roles Table
			$sth = $db->prepare($sql);
			$sth->execute();
	
			$sql = " CREATE TABLE `{$otsi2_database}`.`_user_roles` (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`user_id` bigint(20) NOT NULL DEFAULT 0,
				`role_id` bigint(20) NOT NULL DEFAULT 0,
				`created_by` bigint(20) NOT NULL DEFAULT 0,
				`created_at` int(11) NOT NULL DEFAULT 0,
				`updated_by` bigint(20) NOT NULL DEFAULT 0,
				`updated_at` int(11) NOT NULL DEFAULT 0,
				`deleted_at` int(11) NOT NULL DEFAULT 0,
				`deleted_by` bigint(20) NOT NULL DEFAULT 0,
				`is_active` tinyint(1) NOT NULL DEFAULT 1,
				PRIMARY KEY (`id`),
				UNIQUE KEY `user_role` (`user_id`,`role_id`),
				KEY `role_id` (`role_id`),
				CONSTRAINT `_user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `_users` (`id`) ON DELETE CASCADE,
				CONSTRAINT `_user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `_roles` (`id`) ON DELETE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//insert  User Roles -- role_id based on roles table
			$sth = $db->prepare("insert into {$otsi2_database}._user_roles (user_id,role_id) values(?,?)");
			$sth->execute([$user_id, $roles_id]);
			$user_role_id = $db->lastInsertId();
	
			// User Tokens
			$sql = " CREATE TABLE `{$otsi2_database}`.`_user_tokens` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL DEFAULT 0,
				`token` char(32) DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `user_token` (`token`)
			) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=latin1 ";

			$sth = $db->prepare($sql);
			$sth->execute();

			// contracts;
			$sql = "CREATE TABLE `{$otsi2_database}`.`contracts` (
				`id` int(12) NOT NULL AUTO_INCREMENT,
				`created_on` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`deleted_on` varchar(100) CHARACTER SET utf8mb4 DEFAULT 0,
				`deleted_by` int(11) DEFAULT NULL,
				`created_by` int(11) DEFAULT NULL,
				`status` varchar(11) DEFAULT NULL,
				`contract_name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`contract_number` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`effectivity_date` date DEFAULT NULL,
				`renewable` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`expiration_date` date DEFAULT NULL,
				`days_to_notify` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`negotiating_party` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`type_of_contract` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`office_address` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`contact_person` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`office_number` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`parent` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`sla` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			//contract_updates

			$sql = "CREATE TABLE {$otsi2_database}.`contract_updates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`description` text DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`status` char(30) NOT NULL DEFAULT 'New',
				`contract_id` int(11) NOT NULL DEFAULT 0,
				`contract_number` varchar(100) NULL DEFAULT NUll,
				`expiration_date` date DEFAULT null,
				`effectivity_date` date DEFAULT null,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//ivew_contracts
			$sql = "CREATE TABLE {$otsi2_database}.`view_contracts` (
				`id` int(12) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`created_on` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`deleted_on` varchar(100) CHARACTER SET utf8mb4 DEFAULT 0,
				`deleted_by` int(11) DEFAULT NULL,
				`created_by` int(11) DEFAULT NULL,
				`status` varchar(11) DEFAULT NULL,
				`contract_name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`contract_number` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`effectivity_date` date  DEFAULT NULL,
				`renewable` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`expiration_date` date  DEFAULT NULL,
				`days_to_notify` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`negotiating_party` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`type_of_contract` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`office_address` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`contact_person` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`office_number` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`parent` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//permits
			$sql = "CREATE TABLE {$otsi2_database}.`permits` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`created_on` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`deleted_on` varchar(100) CHARACTER SET utf8mb4 DEFAULT 0,
				`deleted_by` int(11) DEFAULT NULL,
				`created_by` int(11) DEFAULT NULL,
				`permit_name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`permit_number` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`status` varchar(11) DEFAULT NULL,
				`date_issued` date  DEFAULT NULL,
				`expiration_date` varchar(100)  DEFAULT NULL,
				`renewable` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`days_to_notify` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`issuing_office` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`office_address` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`contact_person` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`office_number` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`parent` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`sla` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();

			//permits Update
			$sql = "CREATE TABLE {$otsi2_database}.`permit_updates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`description` text DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`status` char(30) NOT NULL DEFAULT 'New',
				`permit_id` int(11) NOT NULL DEFAULT 0,
				`permit_number` varchar(100) NULL DEFAULT NUll,
				`expiration_date` date DEFAULT null,
				`date_issued` varchar(100) DEFAULT null,
				`effectivity_date` date DEFAULT null,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "CREATE TABLE {$otsi2_database}.`view_permits` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`created_on` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`deleted_on` varchar(100) CHARACTER SET utf8mb4 DEFAULT 0,
				`deleted_by` int(11) DEFAULT NULL,
				`created_by` int(11) DEFAULT NULL,
				`permit_name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`permit_number` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`status` varchar(11) DEFAULT NULL,
				`date_issued` date DEFAULT NULL,
				`expiration_date` varchar(100) DEFAULT NULL,
				`renewable` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`days_to_notify` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`issuing_office` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`office_address` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`contact_person` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`office_number` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				`parent` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();

			//Equipments
			$sql = " CREATE TABLE {$otsi2_database}.`equipments` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`asset_id` char(20) DEFAULT NULL,
				`equipment_name` varchar(200) DEFAULT NULL,
				`type` char(30) DEFAULT NULL,
				`location` varchar(100) DEFAULT NULL,
				`area_served` varchar(100) DEFAULT NULL,
				`brand` varchar(100) DEFAULT NULL,
				`model` varchar(100) DEFAULT NULL,
				`serial_number` varchar(100) DEFAULT NULL,
				`capacity` varchar(100) DEFAULT NULL,
				`asset_number` varchar(100) DEFAULT NULL,
				`critical_equipment` varchar(100) DEFAULT NULL,
				`maintenance_frequency` varchar(100) DEFAULT NULL,
				`date_installed` date DEFAULT NULL,
				`age` int(100) DEFAULT NULL,
				`service_provider` varchar(100) DEFAULT NULL,
				`is_critical` int(2) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`file` varchar(100) DEFAULT NULL,
				`category` char(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ";	
			$sth = $db->prepare($sql);
			$sth->execute();

			//View Equipments
			$sql = " CREATE TABLE {$otsi2_database}.`view_equipments` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`asset_id` char(20) DEFAULT NULL,
				`equipment_name` varchar(200) DEFAULT NULL,
				`type` char(30) DEFAULT NULL,
				`location` varchar(100) DEFAULT NULL,
				`area_served` varchar(100) DEFAULT NULL,
				`brand` varchar(100) DEFAULT NULL,
				`model` varchar(100) DEFAULT NULL,
				`serial_number` varchar(100) DEFAULT NULL,
				`capacity` varchar(100) DEFAULT NULL,
				`asset_number` varchar(100) DEFAULT NULL,
				`critical_equipment` varchar(100) DEFAULT NULL,
				`maintenance_frequency` varchar(100) DEFAULT NULL,
				`date_installed` date DEFAULT NULL,
				`age` int(100) DEFAULT NULL,
				`service_provider` varchar(100) DEFAULT NULL,
				`is_critical` int(2) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`file` varchar(100) DEFAULT NULL,
				`category` char(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ";	
			$sth = $db->prepare($sql);
			$sth->execute();

			// SErvice Providers
			$sql = " CREATE TABLE {$otsi2_database}.`service_providers` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`company` varchar(200) DEFAULT NULL,
				`contact_person` varchar(200) DEFAULT NULL,
				`username` char(30) DEFAULT NULL,
				`email` varchar(200) DEFAULT NULL,
				`contact_number` char(30) DEFAULT NULL,
				`company_address` varchar(200) DEFAULT NULL,
				`scope_of_service` char(30) DEFAULT NULL,
				`file` varchar(100) DEFAULT NULL,
				`vendor_score` char(30) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1";	
			$sth = $db->prepare($sql);
			$sth->execute();

			// SErvice Providers View
			
			$sql = " CREATE TABLE {$otsi2_database}.`service_providers_view` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`company` varchar(200) DEFAULT NULL,
				`contact_person` varchar(200) DEFAULT NULL,
				`username` char(30) DEFAULT NULL,
				`email` varchar(200) DEFAULT NULL,
				`contact_number` char(30) DEFAULT NULL,
				`company_address` varchar(200) DEFAULT NULL,
				`scope_of_service` char(30) DEFAULT NULL,
				`file` varchar(100) DEFAULT NULL,
				`vendor_score` char(30) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1";	
			$sth = $db->prepare($sql);
			$sth->execute();

			// building Personel
			
			$sql = " CREATE TABLE {$otsi2_database}.`building_personnel` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`employee_number` char(30) DEFAULT NULL,
				`employee_name` char(30) DEFAULT NULL,
				`username` char(30) DEFAULT NULL,
				`email` char(30) DEFAULT NULL,
				`contact_number` char(30) DEFAULT NULL,
				`home_address` varchar(100) DEFAULT NULL,
				`working_schedule` char(30) DEFAULT NULL,
				`working_hours` char(30) DEFAULT NULL,
				`person_to_contact_in_case_of_emergency` char(30) DEFAULT NULL,
				`relationship` char(30) DEFAULT NULL,
				`emergency_contact_number` char(30) DEFAULT NULL,
				`file` varchar(100) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1";	
			$sth = $db->prepare($sql);
			$sth->execute();

			// SErvice Providers View
			
			$sql = " CREATE TABLE {$otsi2_database}.`building_personnel_view` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`employee_number` char(30) DEFAULT NULL,
				`employee_name` char(30) DEFAULT NULL,
				`username` char(30) DEFAULT NULL,
				`email` char(30) DEFAULT NULL,
				`contact_number` char(30) DEFAULT NULL,
				`home_address` varchar(100) DEFAULT NULL,
				`working_schedule` char(30) DEFAULT NULL,
				`working_hours` char(30) DEFAULT NULL,
				`person_to_contact_in_case_of_emergency` char(30) DEFAULT NULL,
				`relationship` char(30) DEFAULT NULL,
				`emergency_contact_number` char(30) DEFAULT NULL,
				`file` varchar(100) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1";	
			$sth = $db->prepare($sql);
			$sth->execute();

			//stages
			$sql = " CREATE TABLE {$otsi2_database}.`stages` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`stage_type` char(30) DEFAULT NULL,
				`stage_name` char(30) DEFAULT NULL,
				`rank` int(11) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//INSERTING STAGES DATA
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('pm', 'open',1)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('pm', 'acknowledged',2)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('pm', 'work-started',3)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('pm', 'work-completed',4)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('pm', 'property-manager-verification',5)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('pm', 'closed',6)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('cm', 'open',1)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('cm', 'acknowledged',2)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('cm', 'work-started',3)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('cm', 'work-completed',4)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('cm', 'property-manager-verification',5)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('cm', 'closed',6)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('wo', 'open',1)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('wo', 'acknowledged',2)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('wo', 'work-started',3)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('wo', 'work-completed',4)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('wo', 'property-manager-verification',5)";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('wo', 'closed',6)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('sr', 'for-approval',1)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('sr', 'acknowledged',2)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('soa', 'billed',1)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('soa', 'sent',2)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('soa', 'patially-paid',3)";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			$sql = "insert into {$otsi2_database}.`stages` (stage_type, stage_name,rank) values ('soa', 'paid',4)";
			$sth = $db->prepare($sql);
			$sth->execute();
			

			//
			$sql = " CREATE TABLE {$otsi2_database}.`pm` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`location` varchar(100) DEFAULT NULL,
				`equipment_id` varchar(100) DEFAULT NULL,
				`pm_start_date` datetime DEFAULT NULL,
				`pm_end_date` datetime DEFAULT NULL,
				`frequency` varchar(100) DEFAULT NULL,
				`notify_days_before_next_schedule` varchar(100) DEFAULT NULL,
				`repeat_notif` varchar(100) DEFAULT 'off',
				`priority_level` varchar(100) DEFAULT NULL,
				`service_provider_id` varchar(100) DEFAULT NULL,
				`notify_vendor_before_next_schedule` varchar(100) DEFAULT NULL,
				`stage` varchar(100) DEFAULT 'open',
				`rank` int(11) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`parent` int(11) DEFAULT NULL,
				`critical` varchar(20) DEFAULT NULL,
				`target_date` datetime DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			//views_pm
			$sql = " CREATE TABLE {$otsi2_database}.`views_pm` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`location` varchar(100) DEFAULT NULL,
				`equipment_id` varchar(100) DEFAULT NULL,
				`pm_start_date` datetime DEFAULT NULL,
				`pm_end_date` datetime DEFAULT NULL,
				`frequency` varchar(100) DEFAULT NULL,
				`notify_days_before_next_schedule` varchar(100) DEFAULT 0,
				`repeat_notif` varchar(100) DEFAULT 'off',
				`priority_level` varchar(100) DEFAULT NULL,
				`service_provider_id` varchar(100) DEFAULT NULL,
				`notify_vendor_before_next_schedule` varchar(100) DEFAULT 0,
				`stage` varchar(100) DEFAULT 'open',
				`rank` int(11) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`parent` int(11) DEFAULT NULL,
				`critical` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//pm_updates
			$sql = " CREATE TABLE {$otsi2_database}.`pm_updates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`type` varchar(100) DEFAULT 'comment',
				`comment` varchar(100) DEFAULT 'created',
				`stage` varchar(100) DEFAULT 'new',
				`description` varchar(100) DEFAULT 'new',
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`rank` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			//pm cm

			$sql = "CREATE TABLE {$otsi2_database}.`cm` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`location` varchar(100) DEFAULT NULL,
				`equipment_id` int(11) NOT NULL,
				`category_id` varchar(255) DEFAULT NULL,
				`scope_of_work` varchar(100) DEFAULT NULL,
				`service_provider_id` int(11) NOT NULL,
				`assigned_personnel_id` int(11) NOT NULL DEFAULT 0,
				`breakdown` varchar(100) DEFAULT NULL,
				`amount` int(11) DEFAULT NULL,
				`cm_start_date` datetime DEFAULT NULL,
				`cm_end_date` datetime DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`stage` varchar(100) DEFAULT 'open',
				`priority_level` varchar(100) DEFAULT NULL,
				`rank` int(11) DEFAULT NULL,
				`wo_type` varchar(100) DEFAULT NULL,
				`critical` varchar(20) DEFAULT NULL,
				`target_date` datetime DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ";
			  $sth = $db->prepare($sql);
			  $sth->execute();

			  $sql = "CREATE TABLE {$otsi2_database}.`view_cm` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`location` varchar(100) DEFAULT NULL,
				`equipment_id` int(11) NOT NULL,
				`category_id` varchar(255) DEFAULT NULL,
				`scope_of_work` varchar(100) DEFAULT NULL,
				`service_provider_id` int(11) NOT NULL,
				`assigned_personnel_id` int(11) NOT NULL DEFAULT 0,
				`breakdown` varchar(100) DEFAULT NULL,
				`amount` int(11) DEFAULT NULL,
				`cm_start_date` datetime DEFAULT NULL,
				`cm_end_date` datetime DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`stage` varchar(100) DEFAULT 'open',
				`priority_level` varchar(100) DEFAULT NULL,
				`rank` int(11) DEFAULT NULL,
				`wo_type` varchar(100) DEFAULT NULL,
				`critical` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			// cmupdates
			$sql = "CREATE TABLE {$otsi2_database}.`cm_updates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`type` varchar(100) DEFAULT 'comment',
				`comment` varchar(100) DEFAULT 'created',
				`stage` varchar(100) DEFAULT 'new',
				`description` varchar(100) DEFAULT 'new',
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`rank` int(30) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//attachments
			$sql = " CREATE TABLE {$otsi2_database}.`attachments` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`filename` char(100) DEFAULT NULL,
				`description` char(200) DEFAULT NULL,
				`diskname` char(255) DEFAULT NULL,
				`reference_table` char(60) DEFAULT NULL,
				`reference_id` int(11) NOT NULL DEFAULT 0,
				`attachment_url` char(225) DEFAULT NULL,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//tenants
			$sql = " CREATE TABLE {$otsi2_database}.`tenant` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`owner_name` varchar(100) DEFAULT NULL,
				`owner_contact` varchar(100) DEFAULT NULL,
				`owner_email` varchar(100) DEFAULT NULL,
				`owner_username` varchar(100) DEFAULT NULL,
				`owner_spouse` varchar(100) DEFAULT NULL,
				`owner_spouse_contact` varchar(100) DEFAULT NULL,
				`unit_id` int(20) DEFAULT NULL,
				`unit_area` varchar(100) DEFAULT NULL,
				`tenant_name` varchar(100) DEFAULT NULL,
				`tenant_contact` varchar(100) DEFAULT NULL,
				`tenant_email` varchar(100) DEFAULT NULL,
				`tenant_username` varchar(100) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`floor_area` varchar(100) DEFAULT NULL,
				`first_name` varchar(50) DEFAULT NULL,
				`last_name` varchar(50) DEFAULT NULL,
				`type` varchar(50) DEFAULT NULL,
				`password` varchar(50) DEFAULT NULL,
				`status` varchar(50) DEFAULT NULL,
				`otp` varchar(50) NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1";
			  $sth = $db->prepare($sql);
			  $sth->execute();

			
			//view_tenants
			$sql = "CREATE TABLE {$otsi2_database}.`view_tenant` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`owner_name` varchar(100) DEFAULT NULL,
				`owner_contact` varchar(100) DEFAULT NULL,
				`owner_email` varchar(100) DEFAULT NULL,
				`owner_username` varchar(100) DEFAULT NULL,
				`owner_spouse` varchar(100) DEFAULT NULL,
				`owner_spouse_contact` varchar(100) DEFAULT NULL,
				`unit_id` int(20) DEFAULT NULL,
				`unit_area` varchar(100) DEFAULT NULL,
				`tenant_name` varchar(100) DEFAULT NULL,
				`tenant_contact` varchar(100) DEFAULT NULL,
				`tenant_email` varchar(100) DEFAULT NULL,
				`tenant_username` varchar(100) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`floor_area` varchar(100) DEFAULT NULL,
				`first_name` varchar(50) DEFAULT NULL,
				`last_name` varchar(50) DEFAULT NULL,
				`type` varchar(50) DEFAULT NULL,
				`password` varchar(50) DEFAULT NULL,
				`status` varchar(50) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();

			//wo
			$sql = " CREATE TABLE {$otsi2_database}.`wo` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`location` varchar(100) DEFAULT NULL,
				`equipment_id` int(11) NOT NULL,
				`category_id` varchar(50) NOT NULL,
				`scope_of_work` varchar(100) DEFAULT NULL,
				`service_provider_id` int(11) NOT NULL,
				`assigned_personnel_id` int(11) DEFAULT NULL,
				`breakdown` varchar(100) DEFAULT NULL,
				`amount` int(11) DEFAULT NULL,
				`priority_level` varchar(50) DEFAULT NULL,
				`wo_start_date` datetime DEFAULT NULL,
				`wo_end_date` datetime DEFAULT NULL,
				`rank` int(11) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`stage` varchar(100) DEFAULT 'open',
				`wo_type` varchar(50) DEFAULT NULL,
				`critical` varchar(20) DEFAULT NULL,
				`target_date` datetime DEFAULT NULL,
				`aging` varchar(100) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();
			//view_wo

			$sql = "CREATE TABLE {$otsi2_database}.`view_wo` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`location` varchar(100) DEFAULT NULL,
				`equipment_id` int(11) NOT NULL,
				`category_id` varchar(50) NOT NULL,
				`scope_of_work` varchar(100) DEFAULT NULL,
				`service_provider_id` int(11) NOT NULL,
				`assigned_personnel_id` int(11) DEFAULT NULL,
				`breakdown` varchar(100) DEFAULT NULL,
				`amount` int(11) DEFAULT NULL,
				`priority_level` varchar(50) DEFAULT NULL,
				`wo_start_date` datetime DEFAULT NULL,
				`wo_end_date` datetime DEFAULT NULL,
				`rank` int(11) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`stage` varchar(100) DEFAULT 'open',
				`wo_type` varchar(50) DEFAULT NULL,
				`critical` varchar(20) DEFAULT NULL,
				`target_date` datetime DEFAULT NULL,
				`aging` varchar(100) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//wo_updates
			$sql = "CREATE TABLE {$otsi2_database}.`wo_updates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`type` varchar(100) DEFAULT 'comment',
				`comment` varchar(100) DEFAULT 'created',
				`stage` varchar(100) DEFAULT 'new',
				`description` varchar(100) DEFAULT 'new',
				`rank` int(11) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//meters
			$sql = "CREATE TABLE {$otsi2_database}.`meters` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`meter_name` varchar(200) DEFAULT null,
				`utility_type` varchar(200) DEFAULT null,
				`unit_of_measurement` varchar(200) DEFAULT null,
				`meter_type` varchar(200) DEFAULT NULL,
				`serial_number` varchar(200) DEFAULT null,
				`meter_location` varchar(200) DEFAULT null,
				`unit` varchar(200) DEFAULT null,
				`meter_use` varchar(200) DEFAULT null,
				`tenant` varchar(200) DEFAULT null,
				`cycle` int(12) DEFAULT null,
				`tenant_type` varchar(200) DEFAULT null,
				`below_threshold` varchar(200) DEFAULT null,
				`max_threshold` varchar(200) DEFAULT null,
				`max_digit` varchar(200) DEFAULT null,
				`multiplier` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`active` varchar(200) DEFAULT null,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//view meters
			$sql = "CREATE TABLE {$otsi2_database}.`view_meters` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`meter_name` varchar(200) DEFAULT null,
				`utility_type` varchar(200) DEFAULT null,
				`unit_of_measurement` varchar(200) DEFAULT null,
				`meter_type` varchar(200) DEFAULT NULL,
				`serial_number` varchar(200) DEFAULT null,
				`meter_location` varchar(200) DEFAULT null,
				`unit` varchar(200) DEFAULT null,
				`meter_use` varchar(200) DEFAULT null,
				`tenant` varchar(200) DEFAULT null,
				`cycle` int(12) DEFAULT null,
				`tenant_type` varchar(200) DEFAULT null,
				`below_threshold` varchar(200) DEFAULT null,
				`max_threshold` varchar(200) DEFAULT null,
				`max_digit` varchar(200) DEFAULT null,
				`multiplier` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`active` varchar(200) DEFAULT null,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			//meter updates
			$sql = " CREATE TABLE {$otsi2_database}.`meter_updates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`type` varchar(100) DEFAULT 'comment',
				`comment` varchar(100) DEFAULT 'created',
				`stage` varchar(100) DEFAULT 'new',
				`description` varchar(100) DEFAULT 'new',
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`rank` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();

			// Billing and rates

			$sql = "CREATE TABLE {$otsi2_database}.`billing_and_rates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`mother_meter` varchar(200) DEFAULT null,
				`utility_type` varchar(200) DEFAULT null,
				`months` varchar(200) DEFAULT null,
				`year` varchar(200) DEFAULT null,
				`billing_perion_from` varchar(200) DEFAULT null,
				`billing_perion_to` varchar(200) DEFAULT null,
				`bill_amount` varchar(200) DEFAULT null,
				`consumption` varchar(200) DEFAULT null,
				`rate_` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			// Billing and rates View
			$sql = "CREATE TABLE {$otsi2_database}.`view_billing_and_rates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NULL DEFAULT NULL,
				`mother_meter` varchar(200) DEFAULT null,
				`utility_type` varchar(200) DEFAULT null,
				`months` varchar(200) DEFAULT null,
				`year` varchar(200) DEFAULT null,
				`billing_perion_from` varchar(200) DEFAULT null,
				`billing_perion_to` varchar(200) DEFAULT null,
				`bill_amount` varchar(200) DEFAULT null,
				`consumption` varchar(200) DEFAULT null,
				`rate_` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = " CREATE TABLE {$otsi2_database}.`billing_and_rate_updates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`type` varchar(100) DEFAULT 'comment',
				`comment` varchar(100) DEFAULT 'created',
				`stage` varchar(100) DEFAULT 'new',
				`description` varchar(100) DEFAULT 'new',
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`rank` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			// documents
			$sql = "CREATE TABLE {$otsi2_database}.`documents` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`form_name` varchar(200) DEFAULT null,
				`description` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//documents view
			$sql = "CREATE TABLE {$otsi2_database}.`view_documents` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NULL DEFAULT NULL,
				`form_name` varchar(200) DEFAULT null,
				`description` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//gate_passw
			$sql = "CREATE TABLE {$otsi2_database}.`gate_pass` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`gp_type` varchar(100) DEFAULT NULL,
				`gp_date` date DEFAULT NULL,
				`gp_time` time DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`courier` varchar(100) DEFAULT NULL,
				`courier_name` varchar(100) DEFAULT NULL,
				`courier_contact` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sr_type` varchar(255) DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//gp_items
			$sql = " CREATE TABLE {$otsi2_database}.`gp_items` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`gp_id` int(11) NOT NULL,
				`item_num` varchar(100) DEFAULT NULL,
				`item_name` varchar(100) DEFAULT NULL,
				`item_qty` varchar(100) DEFAULT NULL,
				`description` varchar(100) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//materials
			$sql = " CREATE TABLE {$otsi2_database}.`materials` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`ref_table` varchar(100) DEFAULT NULL,
				`qty` varchar(100) DEFAULT NULL,
				`description` varchar(100) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//move_in
			$sql = " CREATE TABLE {$otsi2_database}.`move_in` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`date` date DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`sr_type` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ";

			$sth = $db->prepare($sql);
			$sth->execute();

			
			//move_out
			$sql = " CREATE TABLE {$otsi2_database}.`move_out` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`date` date DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`sr_type` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();
			

			//reservation
			$sql = " CREATE TABLE {$otsi2_database}.`reservation` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`amenity` varchar(100) DEFAULT NULL,
				`date` date DEFAULT NULL,
				`time` time DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`purpose` varchar(100) DEFAULT NULL,
				`number_guest` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sr_type` varchar(255) DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//tools
			$sql = " CREATE TABLE {$otsi2_database}.`tools` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`ref_table` varchar(100) DEFAULT NULL,
				`qty` varchar(100) DEFAULT NULL,
				`description` varchar(100) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//unit_repair
			$sql = " CREATE TABLE {$otsi2_database}.`unit_repair` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`requestor_name` varchar(100) DEFAULT NULL,
				`contact_num` varchar(50) DEFAULT NULL,
				`email_add` varchar(100) DEFAULT NULL,
				`unit` varchar(100) NOT NULL,
				`description` varchar(100) DEFAULT NULL,
				`request_type` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sr_type` varchar(255) DEFAULT NULL,
				`priority_level` varchar(20) DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();

			//view_gate_pass
			$sql = " CREATE TABLE {$otsi2_database}.`view_gate_pass` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`gp_type` varchar(100) DEFAULT NULL,
				`gp_date` date DEFAULT NULL,
				`gp_time` time DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`courier` varchar(100) DEFAULT NULL,
				`courier_name` varchar(100) DEFAULT NULL,
				`courier_contact` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sr_type` varchar(255) DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//view_move_in
			$sql = " CREATE TABLE {$otsi2_database}.`view_move_in` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`date` date DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`sr_type` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//view_move_out
			$sql = " CREATE TABLE {$otsi2_database}.`view_move_out` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`date` date DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`sr_type` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//view_reservation
			$sql = " CREATE TABLE {$otsi2_database}.`view_reservation` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`amenity` varchar(100) DEFAULT NULL,
				`date` date DEFAULT NULL,
				`time` time DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`purpose` varchar(100) DEFAULT NULL,
				`number_guest` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sr_type` varchar(255) DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			//view_unit_repair
			$sql = " CREATE TABLE {$otsi2_database}.`view_unit_repair` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`requestor_name` varchar(100) DEFAULT NULL,
				`contact_num` varchar(50) DEFAULT NULL,
				`email_add` varchar(100) DEFAULT NULL,
				`unit` varchar(100) NOT NULL,
				`description` varchar(100) DEFAULT NULL,
				`request_type` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sr_type` varchar(255) DEFAULT NULL,
				`priority_level` varchar(20) DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			// view_visitor_pass 
			$sql = " CREATE TABLE {$otsi2_database}.`view_visitor_pass` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`date_from` date DEFAULT NULL,
				`date_to` date DEFAULT NULL,
				`time_arrival` time DEFAULT NULL,
				`time_departure` time DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sr_type` varchar(255) DEFAULT NULL,
				`purpose` varchar(50) DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ";

			$sth = $db->prepare($sql);
			$sth->execute();

			// view_work_permit
			$sql = " CREATE TABLE {$otsi2_database}.`view_work_permit` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`nature_work` varchar(100) DEFAULT NULL,
				`date` date DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`contractor_name` varchar(100) DEFAULT NULL,
				`scope_work` varchar(100) DEFAULT NULL,
				`pic_name` varchar(100) DEFAULT NULL,
				`pic_contact` varchar(100) DEFAULT NULL,
				`start_date` date DEFAULT NULL,
				`end_date` date DEFAULT NULL,
				`sr_type` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();
			
			// visitor_pass
			$sql = " CREATE TABLE {$otsi2_database}.`visitor_pass` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`date_from` date DEFAULT NULL,
				`date_to` date DEFAULT NULL,
				`time_arrival` time DEFAULT NULL,
				`time_departure` time DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sr_type` varchar(255) DEFAULT NULL,
				`purpose` varchar(50) DEFAULT NULL,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//  vp_guest
			$sql = " CREATE TABLE {$otsi2_database}.`vp_guest` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`vp_id` int(11) NOT NULL,
				`guest_name` varchar(100) DEFAULT NULL,
				`guest_num` varchar(100) DEFAULT NULL,
				`guest_add` varchar(100) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();

			//  work_permit
			$sql = " CREATE TABLE {$otsi2_database}.`work_permit` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`nature_work` varchar(100) DEFAULT NULL,
				`date` date DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`resident_type` varchar(100) DEFAULT NULL,
				`unit` varchar(100) DEFAULT NULL,
				`contact_num` varchar(100) DEFAULT NULL,
				`contractor_name` varchar(100) DEFAULT NULL,
				`scope_work` varchar(100) DEFAULT NULL,
				`pic_name` varchar(100) DEFAULT NULL,
				`pic_contact` varchar(100) DEFAULT NULL,
				`start_date` date DEFAULT NULL,
				`end_date` date DEFAULT NULL,
				`sr_type` varchar(100) DEFAULT NULL,
				`approve` int(11) NOT NULL DEFAULT 0,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sla` varchar(20) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ";

			$sth = $db->prepare($sql);
			$sth->execute();

			
			// workers   
			$sql = " CREATE TABLE {$otsi2_database}.`workers` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NOT NULL,
				`ref_table` varchar(100) DEFAULT NULL,
				`name` varchar(100) DEFAULT NULL,
				`description` varchar(100) DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";

			$sth = $db->prepare($sql);
			$sth->execute();


			//meter_readings
			$sql = "CREATE TABLE {$otsi2_database}.`meter_readings` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`meter_id` int(11) NULL DEFAULT NULL,
				`reading` varchar(200) DEFAULT null,
				`consumption` varchar(200) DEFAULT null,
				`description` varchar(200) DEFAULT null,
				`billing_month_year` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`notes` varchar(200) DEFAULT null,
				`month` varchar(5) DEFAULT null,
				`year` varchar(5) DEFAULT null,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			//view_meter_readings
			$sql = "CREATE TABLE {$otsi2_database}.`view_meter_readings` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NULL DEFAULT NULL,
				`meter_id` int(11) NULL DEFAULT NULL,
				`reading` varchar(200) DEFAULT null,
				`consumption` varchar(200) DEFAULT null,
				`description` varchar(200) DEFAULT null,
				`billing_month_year` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`notes` varchar(200) DEFAULT null,
				`month` varchar(5) DEFAULT null,
				`year` varchar(5) DEFAULT null,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//bills
			$sql = "CREATE TABLE {$otsi2_database}.`bills` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`tenant_id` int(11) NULL DEFAULT NULL,
				`month` varchar(200) DEFAULT null,
				`year` varchar(200) DEFAULT null,
				`association_dues` varchar(200) DEFAULT null,
				`electricity` varchar(200) DEFAULT null,
				`water` varchar(200) DEFAULT null,
				`description` varchar(200) DEFAULT null,
				`notes` varchar(200) DEFAULT null,
				`billed` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`sla` varchar(20) DEFAULT null,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//view_bills
			$sql = "CREATE TABLE {$otsi2_database}.`view_bills` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) NULL DEFAULT NULL,
				`tenant_id` int(11) NULL DEFAULT NULL,
				`month` varchar(200) DEFAULT null,
				`year` varchar(200) DEFAULT null,
				`association_dues` varchar(200) DEFAULT null,
				`electricity` varchar(200) DEFAULT null,
				`water` varchar(200) DEFAULT null,
				`description` varchar(200) DEFAULT null,
				`notes` varchar(200) DEFAULT null,
				`billed` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//meter updates
			$sql = " CREATE TABLE {$otsi2_database}.`bills_update` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`type` varchar(100) DEFAULT 'comment',
				`comment` varchar(100) DEFAULT 'created',
				`stage` varchar(100) DEFAULT 'new',
				`description` varchar(100) DEFAULT 'new',
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`rank` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//bills
			$sql = "CREATE TABLE {$otsi2_database}.`assoc_dues` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`dues` int(11) NULL DEFAULT NULL,
				`month` int(11) NULL DEFAULT NULL,
				`year` varchar(200) DEFAULT null,
				`notes` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			//bills
			$sql = "CREATE TABLE {$otsi2_database}.`soa` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`remaining_balance` varchar(200) NULL DEFAULT NULL,
				`amount_due` varchar(200) NULL DEFAULT NULL,
				`due_month` int(11) NULL DEFAULT NULL,
				`due_year` varchar(200) DEFAULT null,
				`due_date` varchar(200) DEFAULT null,
				`charges_inc_vat` varchar(200) NULL DEFAULT NULL,
				`vat_exempted` varchar(200) NULL DEFAULT NULL,
				`total_vat` varchar(200) NULL DEFAULT NULL,
				`notes` varchar(200) DEFAULT null,
				`bill_id` int(11) NULL DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`tenant_idi` int(11) NULL DEFAULT 0,
				`tenant_id` int(11) NULL DEFAULT 0,
				`total_amount_due` varchar(200) NULL DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

			$sql = "CREATE TABLE {$otsi2_database}.`view_soa` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`remaining_balance` varchar(200) NULL DEFAULT NULL,
				`amount_due` varchar(200) NULL DEFAULT NULL,
				`due_month` int(11) NULL DEFAULT NULL,
				`due_year` varchar(200) DEFAULT null,
				`due_date` varchar(200) DEFAULT null,
				`charges_inc_vat` varchar(200) NULL DEFAULT NULL,
				`vat_exempted` varchar(200) NULL DEFAULT NULL,
				`total_vat` varchar(200) NULL DEFAULT NULL,
				`notes` varchar(200) DEFAULT null,
				`bill_id` int(11) NULL DEFAULT NULL,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`tenant_idi` int(11) NULL DEFAULT 0,
				`tenant_id` int(11) NULL DEFAULT 0,
				`total_amount_due` varchar(200) NULL DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();
			
			//soa_updates
			
			$sql = " CREATE TABLE {$otsi2_database}.`soa_updates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`rec_id` int(11) DEFAULT NULL,
				`type` varchar(100) DEFAULT 'comment',
				`comment` varchar(100) DEFAULT 'created',
				`stage` varchar(100) DEFAULT 'new',
				`description` varchar(100) DEFAULT 'new',
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`rank` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();

			//soa items
			$sql = " CREATE TABLE {$otsi2_database}.`soa_items` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`item_type` varchar(200) DEFAULT null,
				`item_name` varchar(200) DEFAULT null,
				`previous` varchar(200) DEFAULT null,
				`current` varchar(200) DEFAULT null,
				`consumption` varchar(200) DEFAULT null,
				`rate` varchar(200) DEFAULT null,
				`item_amount` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`soa_id` int(11) DEFAULT NULL,
				`rank` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 ";
			$sth = $db->prepare($sql);
			$sth->execute();

			//payments
			$sql = "CREATE TABLE {$otsi2_database}.`payments` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`soa_id` varchar(200) DEFAULT null,
				`amount` varchar(200) DEFAULT null,
				`type_of_payment` varchar(200) DEFAULT null,
				`reference_number` varchar(200) DEFAULT null,
				`created_on` int(11) NOT NULL DEFAULT 0,
				`created_by` int(11) NOT NULL DEFAULT 0,
				`deleted_on` int(11) NOT NULL DEFAULT 0,
				`deleted_by` int(11) NOT NULL DEFAULT 0,
				`rank` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1";
			$sth = $db->prepare($sql);
			$sth->execute();

		}
		else{
			//throw Exception ('we');
		}
	
		$sql = "UPDATE {$otsi2_database}._users SET user_name=?, email=?, password=? WHERE id=?";
		$stmt= $db->prepare($sql);
		$stmt->execute([$data['email'],$data['email'] , md5($data['password']) , $user_id]);
	}	
	else if($data['step'] == 3){
		// $sql = "UPDATE otsi2_{$data['account_id'] }._users SET email=?, password=? WHERE id=?";
		// $stmt= $db->prepare($sql);
		$token = md5(randomString() . $data['user_id'] . time());

		$sql = "UPDATE otsi2_{$data['account_id'] }._users SET fcm_token =?WHERE id=?";
		$stmt= $db->prepare($sql);
		$stmt->execute([$token , $data['user_id']]);

		$sql = "select * from " . DB_NAME . "_" . $data['account_id'] . "._users where id=:user_id";
		$sth = $db->prepare($sql);
		$sth->execute(['user_id'=>$data['user_id']]);

		$user = $sth->fetch();
		$email = $user['email'];

		$mailer = new Mailer([]);
		$sent = $mailer->send([
			'subject' => 'Verification Link From Inventi',
			'body'=> "HI {$user['full_name']} this is your verification link <a href=\"http://i2-sandbox.inventiproptech.com/registration/emailconfirmed.php?verify={$token}&acc={$data['account_id']}\">Click Here</a>",
			'recipients' => [$email]
		]);
		// $sql = "UPDATE otsi2_{$data['account_id'] }._users SET fcm_token =?WHERE id=?";
		// $stmt= $db->prepare($sql);
		// $stmt->execute(['' , $data['user_id']]);
	}
	
	//echo validateInput();
	
	$return_value = ['success'=>1];
	$return_value['description']='Link Valid' ?? '';
	
	$return_value['account_code']=$account_code ?? '';
	$return_value['full_name']=$full_name ?? '';
	$return_value['redirect']=$redirect ?? '';
	$return_value['account_id'] = $account_id ?? intval($data['account_id']);
	$return_value['user_id'] = $user_id;

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'data'=>[]];
}

echo json_encode($return_value);
