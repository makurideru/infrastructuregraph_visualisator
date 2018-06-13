<?php

//file exists for getting all applications for the dropdowns at index-page

	// load up config file
    require_once("dataBase_config.php");
	
	$answer = array();

		$queryString = "
			MATCH (n:Anwendung) RETURN 'node' as element, n.name AS name ORDER BY (name) ASC
			";
		$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
		$result = $query->getResultSet();
		
		foreach ($result as $row) {
			array_push($answer, $row['name']);			
		}

	echo json_encode ($answer);

	
?>