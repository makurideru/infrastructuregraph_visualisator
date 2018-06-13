<?php
//Endpoint for deleting Relationships

// load up config file
    require_once("dataBase_config.php");
	

	$src_id = $_REQUEST['src'];
	$target_id = $_REQUEST['target'];
	$kante = $_REQUEST['kante'];
	
	
	$queryString = "
		START n=node(*) 
		MATCH (n)-[rel:".$kante."]->(r) 
		WHERE ID(n)=".$src_id." AND ID(r)=".$target_id."
		DELETE rel
		";
		$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
		$result = $query->getResultSet();
		
		echo "Edge erfolgreich geloescht! Seite neu laden!";
	
?>