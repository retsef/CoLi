<?php

function get_users_list(){
	$result = mysql_query("
	SELECT *
	FROM utenti
	WHERE temp='0'
	");
	$data = array();
	while($tmp = mysql_fetch_assoc($result)){
		array_push($data, $tmp);
	};
	
	return $data;
}

function user_get_id($user){
	return mysql_result(mysql_query("
	SELECT id
	FROM utenti
	WHERE username='".$user['username']."' and password='".$user['password']."'
	"), 0, 'id');
}
?>