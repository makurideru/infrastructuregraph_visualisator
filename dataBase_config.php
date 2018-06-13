<?php
//load all the everyman neo4j-Framework stuff
require('vendor/autoload.php');

//create connection to the neo4j DB
$neo4jClient = new Everyman\Neo4j\Client(
	(new Everyman\Neo4j\Transport\Curl('localhost',7474)) //host
		->setAuth('neo4j','test') //username, password
);
?>
