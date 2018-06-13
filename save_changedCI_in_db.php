<?php

//file exists for saving changed CIs editMode and adding new nodes by rightclick to DB

	// load up config file
    require_once("dataBase_config.php");
	
	$type = $_REQUEST['type'];
	$elements = $_REQUEST['elements'];
	$id = $_REQUEST['id'];
		
	switch ($type) {
    case "Anwendung":
		if(isset($id) and $id != ""){ //--> id existiert -> bearbeiten
			$queryString = "
			MATCH (n)
			WHERE ID(n) = ".$id."
			SET n.name = '".$elements[0]."'
			RETURN n
			";
		}
		else{ //--> id existiert nicht --> neu
			$queryString = "MERGE (anw:Anwendung {name: '$elements[0]', type:'Anwendung'})";
		}
		
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
		echo "Anwendung erfolgreich aktualisiert!";
		break;
	case "Artefakt":
		if(isset($id) and $id != ""){
			
			$queryString = "
			MATCH (n)
			WHERE ID(n) = ".$id."
			SET n.name = '".$elements[0]."', n.Lizenz = '".$elements[1]."', n.Sonstiges = '".$elements[2]."'
			RETURN n
			";
		}
		else{
			if($id == "")
			{
				$elements[1] = "";
				$elements[2] = "";
			}
			$queryString = "MERGE (art:Artefakt {name: '$elements[0]', type:'Artefakt', Lizenz:'$elements[1]', Sonstiges:'$elements[2]'})";
		}
		
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
		echo "Artefakt erfolgreich aktualisiert!";
		break;
	case "DeploymentLayer":
		if(isset($id) and $id != ""){
			$queryString = "
			MATCH (n)
			WHERE ID(n) = ".$id."
			SET n.DeploymentLayer = '".$elements[0]."', n.RTE = '".$elements[1]."', n.Port = '".$elements[2]."'
			RETURN n
			";
			echo "id " .$id;
		}
		else{
			if($id == "")
			{
				$elements[1] = "";
				$elements[2] = "";
			}
			$temp_zuordnungswert = ""; //$temp_artName.'_'.$temp_serName; //TODO beim Kantenziehen
			$queryString = "CREATE (dep:DeploymentLayer {type:'DeploymentLayer', DeploymentLayer:'$elements[0]', RTE:'$elements[1]', Port:'$elements[2]', Zuordnung:'$temp_zuordnungswert'})";
			echo "Element 1:" . $elements[1] ."Element2". $elements[2];
		}
		
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
		echo "Deployment erfolgreich aktualisiert!";
		break;
	case "Server":
		if(isset($id) and $id != ""){
			$queryString = "
			MATCH (n)
			WHERE ID(n) = ".$id."
			SET n.name = '".$elements[0]."', n.Zone = '".$elements[1]."', n.OS = '".$elements[2]."'
			RETURN n
			";
		}
		else{
			if($id == "")
			{
				$elements[1] = "";
				$elements[2] = "";
			}
			$queryString = "MERGE (ser:Server {name: '$elements[0]', type:'Server', Zone:'$elements[1]', OS:'$elements[2]'})";
		}
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
		echo "Server erfolgreich aktualisiert!";
		break;
	case "Hardware":
		if(isset($id) and $id != ""){
			$queryString = "
			MATCH (n)
			WHERE ID(n) = ".$id."
			SET n.name = '".$elements[0]."'
			RETURN n
			";
		}
		else{
			$queryString = "MERGE (hw:Hardware {name: '$elements[0]', type:'Hardware'})";
		}
		
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
		echo "Hardware erfolgreich aktualisiert!";
		break;
	case "Special":
		if(isset($id) and $id != ""){ //--> id existiert -> bearbeiten
			$queryString = "
			MATCH (n)
			WHERE ID(n) = ".$id."
			SET n.name = '".$elements[0]."', n.kategorie = '".$elements[1]."'
			RETURN n
			";
		}
		else{ //--> id existiert nicht --> neu
			$queryString = "MERGE (spe:Special {name: '$elements[0]', type:'Special', kategorie:'$elements[1]'})";
		}
		
			$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
			$result = $query->getResultSet();
		echo "Objekt erfolgreich aktualisiert!";
		break;
	}

	
?>