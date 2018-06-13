<?php

//file exists for getting autosuggest based on the data in neo4j

	// load up config file
    require_once("dataBase_config.php");
	
	$suggestQuery = $_REQUEST['query'];
	$suggestType = $_REQUEST['type'];
	$suggestProperty = $_REQUEST['prop'];
	$answer = array();
	
	$queryString = '
		MATCH (n) WHERE n.type="'.$suggestType.'" AND n.'.$suggestProperty.' =~ ".*'.$suggestQuery.'.*"
		RETURN DISTINCT "node" as element, n.'.$suggestProperty.' AS name
		LIMIT 25 
		UNION ALL MATCH ()-[r]-() WHERE EXISTS(r.name) 
		RETURN DISTINCT "relationship" AS element, r.name AS name LIMIT 25
		';
		$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
		$result = $query->getResultSet();
		
		foreach ($result as $row) {
			array_push($answer, $row['name']);
		}
		
		echo json_encode ($answer);

		//$arr = array('label' => 'graylog');

	//echo json_encode ($arr);
	
?>