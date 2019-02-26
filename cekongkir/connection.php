<?php
$conf = array();
$conf['localhost'] = 'localhost';
$conf['username'] = 'root';
$conf['password'] = '';
$conf['dbname'] = 'ongkir';

$conn = new mysqli($conf['localhost'], $conf['username'], $conf['password'], $conf['dbname']);

if(!$conn) {	
	echo "Failed to connect to MySQL: (" . mysqli_connect_errno() . ") " . mysqli_connect_error();
}