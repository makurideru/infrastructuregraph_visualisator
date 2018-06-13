<?php

//file exists for getting search_request in editMode and in deleteMode
//-> I guess its obsolete now

	// load up config file
    require_once("dataBase_config.php");
	
	$suggestQuery = $_REQUEST['query'];
	$suggestType = $_REQUEST['type'];
	$suggestProperty = $_REQUEST['prop'];
	$answer = array();
	
	switch ($suggestType) {
    case "Anwendung":
		$queryString = '
			MATCH (n) WHERE n.type="'.$suggestType.'" AND n.'.$suggestProperty.' =~ ".*'.$suggestQuery.'.*"
			RETURN DISTINCT "node" as element, n.'.$suggestProperty.' AS name, ID(n) AS id
			';
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
			
			foreach ($result as $row) {
				array_push($answer, $row['name']);
				array_push($answer, $row['id']);				
			}
		break;
	case "Artefakt":
		$queryString = '
			MATCH (n) WHERE n.type="'.$suggestType.'" AND n.'.$suggestProperty.' =~ ".*'.$suggestQuery.'.*"
			RETURN DISTINCT "node" as element, n.'.$suggestProperty.' AS name, n.Lizenz AS lizenz, n.Sonstiges AS sonstiges, ID(n) AS id
			';
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
			
			foreach ($result as $row) {
				array_push($answer, $row['name']);			
				array_push($answer, $row['lizenz']);
				array_push($answer, $row['sonstiges']);
				array_push($answer, $row['id']);
			}
		break;
	case "Deployment":
		$teile = explode("|", $suggestQuery);
	
		$queryString = '
			MATCH (a)-[:deployed_On]->(b)-[:installed_On]->(c)
				WHERE a.name =~ ".*'.$teile[0].'.*" AND c.name =~ ".*'.$teile[1].'.*"
				RETURN DISTINCT b, b.DeploymentLayer AS dl, b.Port AS port, b.RTE AS rte, b.Zuordnung AS zuord, ID(b) AS id
			';
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
			
			foreach ($result as $row) {
				array_push($answer, $row['dl']);			
				array_push($answer, $row['port']);
				array_push($answer, $row['rte']);
				array_push($answer, $row['zuord']);
				array_push($answer, $row['id']);
			}
		break;
	case "Server":
		$queryString = '
			MATCH (n) WHERE n.type="'.$suggestType.'" AND n.'.$suggestProperty.' =~ ".*'.$suggestQuery.'.*"
			RETURN DISTINCT "node" as element, n.'.$suggestProperty.' AS name, n.Zone AS zone, n.OS AS os, ID(n) AS id
			';
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
			
			foreach ($result as $row) {
				array_push($answer, $row['name']);			
				array_push($answer, $row['zone']);
				array_push($answer, $row['os']);
				array_push($answer, $row['id']);
			}
		break;
	case "Hardware":
		$queryString = '
			MATCH (n) WHERE n.type="'.$suggestType.'" AND n.'.$suggestProperty.' =~ ".*'.$suggestQuery.'.*"
			RETURN DISTINCT "node" as element, n.'.$suggestProperty.' AS name, ID(n) AS id
			';
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
			
			foreach ($result as $row) {
				array_push($answer, $row['name']);
				array_push($answer, $row['id']);				
			}
		break;
	}

		echo json_encode ($answer);

		//$arr = array('label' => 'graylog');
	
?>