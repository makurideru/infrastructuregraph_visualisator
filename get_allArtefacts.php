<?php

//file exists for getting all ARTEFAKTE for the dropdowns at connect-CIs page

	//load all the everyman neo4j-Framework stuff
	require('vendor/autoload.php');

	//create connection to the neo4j DB
	$neo4jClient = new Everyman\Neo4j\Client(
		(new Everyman\Neo4j\Transport\Curl('t8attro0',7474))
			->setAuth('neo4j','test')
	);
	
	$answer = array();

		$queryString = "
			MATCH (n:Artefakt) RETURN 'node' as element, n.name AS name ORDER BY (name) ASC
			";
		$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
		$result = $query->getResultSet();
		
		foreach ($result as $row) {
			array_push($answer, $row['name']);			
		}

	echo json_encode ($answer);

	
?>