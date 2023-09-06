<?php
class DB extends PDO{
	public function __construct()
	{
		//$db = new PDO("mysql:host=". DB_HOST . ";dbname=" . DB_NAME , DB_USER, DB_PWD);
		parent::__construct("mysql:host=". DB_HOST . ";dbname=" . DB_NAME , DB_USER, DB_PWD);
		// set the PDO error mode to exception
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
		$this->query("SET time_zone = '+08:00'");
	}

	public function getFilter($table,$field)
	{
		$record_sth = $this->prepare("select distinct({$field}) from {$table} where deleted_on=0");
		$record_sth->execute($filters);
		return $record_sth->fetchAll();
	}

	public function getRecord($table,$filters)
	{
		$where = [] ;
		foreach(array_keys($filters) as $filter)
		{
			$where[] = "{$filter} = :{$filter}";
		}

		$record_sth = $this->prepare("select * from {$table}" . (count($where) ? " where " : "")  . implode(" and ",$where));
		$record_sth->execute($filters);
		return $record_sth->fetch();
	}

	/**
	 * Format records for Datatable
	 *
	 * @param string $table
	 * @param string $key
	 * @param string $order
	 * @param string $filter
	 * @param boolean $debug
	 * @return array
	 */
	
	public function getRecords(string $table, string $key, array $params, string $order = null, $filter = null, $view = null,$debug = false): array
	{
		$table_split = explode(".",$table);

		/** total record count */
		$count_sth = $this->prepare("select count({$key}) as c from {$table} where deleted_on=0");
		$count_sth->execute();
		$records_total = $count_sth->fetch();

		/** data list */
		$select = [];
		$join = [];
		$where = [];
		$order = [];
		$offset = 0;
		$limit = 10;

		$select[] = "{$table}.*";
		if(strtolower(substr($table,0,4)) != 'view')
		{
				$users_table = (count($table_split) > 1 ? $table_split[0] : '') . '._users';
				$select[] = "{$users_table}.first_name,_users.last_name,concat({$users_table}.first_name,' ',{$users_table}.last_name) as created_name";
				$join[] = "left join {$users_table} on {$users_table}.id={$table}.created_by";
		}
			
		$where[] = "{$table}.deleted_on=0";
		
		if (isset($params['order'])) 
		{
			foreach ($params['order'] as $order_index => $order_details) 
			{
				$columnIndex = $order_details['column'];
				$sortDir  = $order_details['dir'];
				$order[] = "{$table}.{$params['columns'][$columnIndex]['data']} {$sortDir}";
			}
		}

		if (isset($params['start']) && $params['length'] != -1) 
		{
			$limit = $params['length'];
			$offset = $params['start'];
		}

		//global search
		$search_fields = [];
		$search_values = [];
		if ($params['search']['value'] != '') 
		{
			foreach ($params['columns'] as $column) 
			{
				if ($column['data'] && $column['searchable'] === 'true') 
				{
					$searchfor = $params['search']['value'];
					if ($column['data'] == 'id')
					{
						$search_fields[] = "{$table}.{$column['data']} = ?";
						$search_values[] = $searchfor;
					}else{
						$search_fields[] = "{$table}.{$column['data']} like ?";
						$search_values[] = "%{$searchfor}%";
					}
				}
			}

			if (count($search_fields))
				$where[] = "(" . implode(" or ", $search_fields) . ")";
		}

		//individual column search
		$search_string_columns = [];
		$search_string_columns2 = [];
		foreach ($params['columns'] as $column) {
			if ($column['searchable'] == 'true' && is_array($column['search']['value']) && count($column['search']['value']) && $column['data'] != null) {
				if ($column['datatype'] == 'datetime' || $column['datatype'] == 'date') //user want to filter the date time
				{
					$row_dates = $column['search']['value'];

					if ($row_dates[0] <> '' || $row_dates[1] <> '') {
						if ($row_dates[0] <> '')
							$where[] = "{$table}.{$column['data']} >= '{$row_dates[0]} 00:00:00'";

						if ($row_dates[1] <> '')
							$where[] = "{$table}.{$column['data']} <= '{$row_dates[1]} 23:59:59'";
					}
				} else {
					$in_placeholders = rtrim(str_repeat('?, ', count($column['search']['value'])), ', ');
					$where[] = "{$table}.{$column['data']} in ({$in_placeholders})";
					$search_values = array_merge($search_values,$column['search']['value']);
				}
			} elseif ($column['searchable'] == 'true' && $column['search']['value'] != '' && $column['data'] != null) {
				$where[] = "{$table}.{$column['data']} = ?";
				$search_values[] = $column['search']['value'];
			}
		}
		if($filter && is_array($filter))
		{
			foreach($filter as $filter_field=>$filter_value)
			{
				if($view == 'view_wo')
				{
					if($filter_value=="safetysecurity"){
						$where[] = "{$filter_field} IN ('Civil','Structural')";
					}else{
						$where[] = "{$filter_field} = ?";
						$search_values[] = $filter_value;
					}
				}else{
					if ($filter_field=="condition") // 23-0614 ATR: USE CONDITION
						$where[] = "{$filter_value}";
					else
						$where[] = "{$filter_field} = ?";
					$search_values[] = $filter_value;
				}
			}
		

			if($view == 'view_wo')
			{
				$sql = "select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}";
				$records_sth = $this->prepare("select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}");
				$records_sth->execute($search_values);
				$records = $records_sth->fetchAll();
		
			}
			else{
				$sql = "select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}";
				$records_sth = $this->prepare("select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}");
				$records_sth->execute($search_values);
				$records = $records_sth->fetchAll();
				// var_dump($where);
			}

		}


		elseif($filter)
		{
			if($view=="view_tenant"){
				$where[] = $table.'.'.$filter;
				$sql = "select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}";
				$records_sth = $this->prepare("select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order). " limit {$offset},{$limit}");
				$records_sth->execute($search_values);
				$records = $records_sth->fetchAll();

			}else{
				$where[] = $table.'.'.$filter;
				$sql = "select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}";
				$records_sth = $this->prepare("select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}");
				$records_sth->execute($search_values);
				$records = $records_sth->fetchAll();

	
			}
		}else{
			if($view=="view_bills"){
				$sql = "select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}";
				$records_sth = $this->prepare("select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order). " limit {$offset},{$limit}");
				$records_sth->execute($search_values);
				$records = $records_sth->fetchAll();
			}else{
				$sql = "select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}";
				$records_sth = $this->prepare("select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}");
				$records_sth->execute($search_values);
				$records = $records_sth->fetchAll();
				// var_dump($where);
			}
		}
		
	
		$records_filtered_count = $records_total['c'];

		/** filtered count */
		if (count($search_values)) 
		{

			$records_filtered_sth = $this->prepare("select count({$table}.{$key}) as c from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where));
			$records_filtered_sth->execute($search_values);
			$records_filtered = $records_filtered_sth->fetch();
		
			$records_filtered_count = $records_filtered['c'];

			$where1 = implode(" and ",$where);
		}
		
		// var_dump($records);
		return [
			'where1' => $where1,
			'recordsTotal' => $records_total['c'],
			'recordsFiltered' => $records_filtered_count,
			'data' => $records,
			'searchValues' => $search_values,
			'records_sth' => $sql
			// 'query' => "select " . implode(",",$select) . " from {$table} " . implode(" ",$join) . " where " . implode(" and ",$where) . " order by " . implode(", ", $order) . " limit {$offset},{$limit}"
		];
	}
}
