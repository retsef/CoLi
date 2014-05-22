<?php
function reg_register($data){
	//registro l'utente
	global $_CONFIG;
	
	$id = reg_get_unique_id();
	mysql_query("
	INSERT INTO ".$_CONFIG['table_utenti']."
	(name, surname, indirizzo, occupazione, username, password, temp, regdate, uid)
	VALUES
	('".$data['name']."','".$data['surname']."','".$data['indirizzo']."',
	'".$data['occupazione']."','".$data['username']."',MD5('".$data['password']."'),
	'1', '".time()."','".$id."')");
	
	//Decommentate la riga seguente per testare lo script in locale
	//echo "<a href=\"http://localhost/Articoli/autenticazione/2/scripts/confirm.php?id=".$id."\">Conferma</a>";
	if(mysql_insert_id()){
		return reg_send_confirmation_mail($data['mail'], "test@localhost", $id);
	}else return REG_FAILED;
}

function reg_send_confirmation_mail($to, $from, $id){
	//invio la mail di conferma
	$msg = "Per confermare l'avvenuta registrazione, clicckate il link seguente:
	http://localhost/Articoli/autenticazione/1/scripts/confirm.php?id=".$id."
	";
	return (mail($to, "Conferma la registrazione", $msg, "From: ".$from)) ? REG_SUCCESS : REG_FAILED;
}

function reg_clean_expired(){
	global $_CONFIG;
	
	$query = mysql_query("
	DELETE FROM ".$_CONFIG['table_utenti']."
	WHERE (regdate + ".($_CONFIG['regexpire'] * 60 * 60).") <= ".time()." and temp='1'");
}

function reg_get_unique_id(){
	//restituisce un ID univoco per gestire la registrazione
	list($usec, $sec) = explode(' ', microtime());
	mt_srand((float) $sec + ((float) $usec * 100000));
	return md5(uniqid(mt_rand(), true));
}

function reg_check_data(&$data){
	global $_CONFIG;
	
	$errors = array();
	
	foreach($data as $field_name => $value){
		$func = $_CONFIG['check_table'][$field_name];
		if(!is_null($func)){
			$ret = $func($value);
			if($ret !== true)
				$errors[] = array($field_name, $ret);
		}
	}
	
	return count($errors) > 0 ? $errors : true;
}

function reg_confirm($id){
	global $_CONFIG;
	
	$query = mysql_query("
	UPDATE ".$_CONFIG['table_utenti']."
	SET temp='0'
	WHERE uid='".$id."'");
	
	return (mysql_affected_rows () != 0) ? REG_SUCCESS : REG_FAILED;
}
?>