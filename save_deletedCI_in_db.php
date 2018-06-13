<?php
//Endpoint for deleting CIs

// load up config file
    require_once("dataBase_config.php");
	

	$id = $_REQUEST['id'];
	
	
	$queryString = "
		MATCH (p) where ID(p)=".$id."
		OPTIONAL MATCH (p)-[r]-()
		DELETE r,p
		";
		$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
		$result = $query->getResultSet();
		
		echo "CI erfolgreich gelöscht!";
	
?>
