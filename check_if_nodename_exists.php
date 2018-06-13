<?php

//file exists for saving new nodes added by rightclick to DB and check if they exists


// load up config file
require_once("dataBase_config.php");

$ci_name = $_REQUEST['ci_name'];

//nachschauen ob der Knoten unter diesem Namen schon existiert für RIghtclickmenü (MERGE würde DB ohnehin handeln)-> dann nicht neu anlegen -> Alert-Meldung
$queryString = "MATCH (n) WHERE n.name = '$ci_name' AND n.type <> 'DeploymentLayer' RETURN n"; //DeplLay kann mehrfach da sein
$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
$result = $query->getResultSet();			
$nodeExists = "";
foreach ($result as $row) {
	$nodeExists = $row['x']->getProperty('name') . "\n";
}	

if($nodeExists != "")
{
	echo "exists";
}
				
			
?>