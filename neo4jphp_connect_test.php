<?php
    require('vendor/autoload.php');

   $neo4jClient = new Everyman\Neo4j\Client(
		(new Everyman\Neo4j\Transport\Curl('localhost',7474))
			->setAuth('neo4j','test')
   );
   
   //add node
   //$user = $neo4jClient->makeNode();
   //$user ->setProperty('name', 'Rainer')->setProperty('business', 'Graph Story')->save();
   
   //modify node
   //$user = $neo4jClient->getNode(5);   
  // $user ->setProperty('name', 'Greg')->setProperty('business', 'CrowPlace')->save();
   
   //delete node
   //$user = $neo4jClient->getNode(13);
   //$user->delete();
   
   //labelling
	//$greg = $neo4jClient->getNode(14);
   //$userLabel = $neo4jClient->makeLabel("User");
   //$devLabel = $neo4jClient->makeLabel("Developer");
   //$memeLabel = $neo4jClient->makeLabel("GoodGuyRainer");   
  // $labels = $greg->addLabels(array($userLabel, $devLabel, $memeLabel));
   //$labels = $greg->getLabels();
   
   //add relation
   //$greg = $neo4jClient->getNode(5);
   //$rainer = $neo4jClient->getNode(14);
  // $greg -> relateTo($rainer, "FOLLOWS") -> save();
  
  //get relation
//$greg = $neo4jClient->getNode(5);
	//$gregRels = $greg->getRelationships(array("FOLLOWS"));
//	print_r($gregRels);
   
   //cipher query
  /* $queryString = "MATCH (n) RETURN n";
	$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
	$result = $query->getResultSet();

	foreach ($result as $row) {
		echo $row['x']->getProperty('name');
		 echo $row['x']->getProperty('business');
	}*/
	
	//get nodes by getLabel
	/*
	$devLabel = $neo4jClient->makeLabel("Developer"); //if exists its not created twice
	$devNodes = $devLabel->getNodes();
	
	foreach ($devNodes as $row) {
		echo $row->getProperty('name');
		echo $row->getProperty('business');
	}
	*/
	
   
   //print_r($result);
   
    //print_r($neo4jClient->getServerInfo());