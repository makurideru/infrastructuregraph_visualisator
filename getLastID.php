<?php
//Endpoint for geting the current internal ID

// load up config file
    require_once("dataBase_config.php");
	
	
	$queryString = "
		MATCH(n) RETURN MAX(ID(n)) as nodeId
		";
		$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
		$result = $query->getResultSet();
		
		echo $result[0]['nodeId']; 

	
?>