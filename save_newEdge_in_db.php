<?php
//Endpoint for saving edges (created via dbl-clicks) in the Database

// load up config file
    require_once("dataBase_config.php");
	
	$src_id = $_REQUEST['src'];
	$target_id = $_REQUEST['target'];
	$kante = $_REQUEST['kante'];
	
	
	$queryString = "
		MATCH(i)
		where ID(i)=".$src_id."
		match(d)
		where ID(d)=".$target_id."
		MERGE (i)-[:".$kante."]->(d)
		";
		$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
		$result = $query->getResultSet();		
	
?>