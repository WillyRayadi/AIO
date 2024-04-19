<?php

function cek_session($UserId){

	$db = db_connect();

	$cek = $db->table('administrators')->where(['id'=>$UserId])->get()->getResultArray();

	return $cek[0];

}