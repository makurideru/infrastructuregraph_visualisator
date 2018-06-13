<?php

//file exists for saving edges between Servers in DB

	// load up config file
    require_once("dataBase_config.php");
	
	$ser1 = $_REQUEST['ser1'];
	$ser2 = $_REQUEST['ser2'];
	$edge = $_REQUEST['edge2'];
	
	$queryString = "
			MATCH (a:Server),(b:Server)
			WHERE a.name = '".$ser1."' AND b.name = '".$ser2."'
			CREATE UNIQUE (a)-[r:".$edge."]->(b)
			RETURN r
			";
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
			
	echo "Serverbeziehung '$ser1 --- $edge --> $ser2' erfolgreich eingetragen!";
	
?>