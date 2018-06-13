<?php

//file exists for saving edges between Artefakte in DB

	// load up config file
    require_once("dataBase_config.php");
	
	$art1 = $_REQUEST['art1'];
	$art2 = $_REQUEST['art2'];
	$edge = $_REQUEST['edge'];
	
	$queryString = "
			MATCH (a:Artefakt),(b:Artefakt)
			WHERE a.name = '".$art1."' AND b.name = '".$art2."'
			CREATE UNIQUE (a)-[r:".$edge."]->(b)
			RETURN r
			";
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
			
	echo "Artefaktbeziehung '$art1 --- $edge --> $art2' erfolgreich eingetragen!";
	
?>