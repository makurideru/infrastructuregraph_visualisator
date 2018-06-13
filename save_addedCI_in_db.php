<?php
	//file exists just for saving entries from the mask in neo4j

	// load up config file
    require_once("dataBase_config.php");

	$anwendung_name = $_POST["anw_name"];

	$NumberOfInstances = $_POST["NumberOfInstances"]; //Anzahl Instanzen
	
	echo "Der Anwendung $anwendung_name wurden $NumberOfInstances Instanzen hinzugefügt (falls noch nicht vorhanden):<br/><br/><b>Details:</b/><br/><br/>";
	
	$anzahlDeployments = array(); //Anzahl Deployments pro Instanz
	$anzahlInnerArtefakte = array(); //Anzahl InnereArtefakte pro Deployment
	for ($i = 0; $i < $NumberOfInstances; $i++) {
		$serverNr = $i + 1;
		$anzahlDeployments[$i] = $_POST["NumberOfDeployments|$serverNr"];		
		echo "Server $serverNr hat ".$anzahlDeployments[$i]." Deploynments <br>" ;
		
			
			for ($j = 0; $j < $anzahlDeployments[$i]; $j++) {
				$deploymentNr = $j + 1;
				$anzahlInnerArtefakte[$i][$j] = $_POST["NumberOfInnerArtefakte|$serverNr|$deploymentNr"];		
				echo "Das Deployment $deploymentNr auf Server $serverNr hat ".$anzahlInnerArtefakte[$i][$j]." innere Artefakte <br>" ;				
			}			
			
			echo "---<br/>";		
	}
	
	echo "---<br/>";
	
	
	
	//Alle Artefaktnamen
	for ($i = 0; $i < $NumberOfInstances; $i++) {
		$serverNr_outer = $i + 1;
		
		$temp_serName = $_POST["ser_name|$serverNr_outer"];
		$temp_serZone = $_POST["ser_zone|$serverNr_outer"];
		$temp_serOS = $_POST["ser_os|$serverNr_outer"];
		$temp_serHW = $_POST["ser_hw|$serverNr_outer"]; //eigener Node
		
		echo "Server $serverNr_outer hat den Namen ".$_POST["ser_name|$serverNr_outer"]."<br>"; 
		echo "Server $serverNr_outer hat die Zone ".$_POST["ser_zone|$serverNr_outer"]."<br>"; 
		echo "Server $serverNr_outer hat das OS ".$_POST["ser_os|$serverNr_outer"]."<br>"; 
		echo "Server $serverNr_outer hat die HW ".$_POST["ser_hw|$serverNr_outer"]."<br>"; 
		echo "<ul>";
		for ($j = 0; $j < $anzahlDeployments[$i]; $j++) {
			$deploymentNr_outer = $j + 1;
			echo "<li>Server $serverNr_outer hat das DL $deploymentNr_outer mit DeploymentLayer ".$_POST["dep_lay|$serverNr_outer|$deploymentNr_outer"]."</li>";
			echo "<li>Server $serverNr_outer hat das DL $deploymentNr_outer mit RTE ".$_POST["dep_rte|$serverNr_outer|$deploymentNr_outer"]."</li>";
			echo "<li>Server $serverNr_outer hat das DL $deploymentNr_outer mit Port ".$_POST["dep_port|$serverNr_outer|$deploymentNr_outer"]."</li>";
			
			//kann bzw. muss mehrfach vorhanden sein können
			$temp_depDL = $_POST["dep_lay|$serverNr_outer|$deploymentNr_outer"];
			$temp_depRTE = $_POST["dep_rte|$serverNr_outer|$deploymentNr_outer"];
			$temp_depPort = $_POST["dep_port|$serverNr_outer|$deploymentNr_outer"];	
			
			for ($k = 0; $k < $anzahlInnerArtefakte[$i][$j]; $k++) {
				$artefaktNr_outer = $k + 1;
				echo "dem zugeordnet ist das Artefakt  $artefaktNr_outer:";
				echo "<ul>";
				echo "<li>Deployment $serverNr_outer hat das Artefakt $artefaktNr_outer mit Namen ".$_POST["art_Name|$serverNr_outer|$deploymentNr_outer|$artefaktNr_outer"]."</li>";
				echo "<li>Deployment $serverNr_outer hat das Artefakt $artefaktNr_outer mit Lizenz ".$_POST["art_Lizenz|$serverNr_outer|$deploymentNr_outer|$artefaktNr_outer"]."</li>";
				echo "<li>Deployment $serverNr_outer hat das Artefakt $artefaktNr_outer mit sonstigen Bemerkungen ".$_POST["art_sonst|$serverNr_outer|$deploymentNr_outer|$artefaktNr_outer"]."</li>";
				echo "</ul>";
				
				$temp_artName = $_POST["art_Name|$serverNr_outer|$deploymentNr_outer|$artefaktNr_outer"];
				$temp_artLizenz = $_POST["art_Lizenz|$serverNr_outer|$deploymentNr_outer|$artefaktNr_outer"];
				$temp_artSonst = $_POST["art_sonst|$serverNr_outer|$deploymentNr_outer|$artefaktNr_outer"];	
				
				$temp_zuordnungswert = $temp_artName.'_'.$temp_serName; //das Attribut Zuordnung existiert nur für interne Berechnungen, um keine unnötige Dopplung zu verursachen
						
				$queryString = "
				MERGE (ser:Server {name: '$temp_serName', type:'Server', Zone:'$temp_serZone', OS:'$temp_serOS'}) 
				MERGE (hw:Hardware {name: '$temp_serHW', type:'Hardware'}) 
				MERGE (ser)-[:instanced_On]-(hw)
				MERGE (dep:Deployment {type:'Deployment', DeploymentLayer:'$temp_depDL', RTE:'$temp_depRTE', Port:'$temp_depPort', Zuordnung:'$temp_zuordnungswert'})
				MERGE (dep)-[:installed_On]-(ser)
				MERGE (art:Artefakt {name: '$temp_artName', type:'Artefakt', Lizenz:'$temp_artLizenz', Sonstiges:'$temp_artSonst'}) 
				MERGE (art)-[:deployed_On]-(dep)
				
				MERGE (anw:Anwendung {name: '$anwendung_name', type:'Anwendung'})
				MERGE (anw)-[:has_child]-(art)
				";
				$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
				$result = $query->getResultSet();
				
			}
			
		}
		echo "</ul>";
	}	
	
	
	//delete node
/*
	$mynode = $neo4jClient->getNode(3);
	$mynode->delete();
	*/	

	//Anwendung -> Artefakt
	/*
	$queryString = "
	MERGE (anw:Anwendung {name: '$anwendung_name', type:'Anwendung'}) 
	MERGE (art:Artefakt { name:'$artefakt_name', type:'Artefakt', port:'$artefakt_port', AppServer: '$deployment_Apps', RTE: '$deployment_RTE'})
	MERGE (anw)-[:HAS_CHILD]-(art)";
	$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
	$result = $query->getResultSet();
	*/	
	
	
	//Experimental with Everyman\Neo4j\Client
	/*
	//Anwendungsknoten mergen
	$queryString = "MERGE (anw:Anwendung { name:'$anwendung_name', type:'Anwendung'})";
	$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
	$result = $query->getResultSet();

	//Artefakte mergen
	$queryString = "MERGE (art:Artefakt { name:'$artefakt_name', type:'Artefakt', port:'$artefakt_port', AppServer: '$deployment_Apps', RTE: '$deployment_RTE'})";
	$query = new Everyman\Neo4j\Cypher\Query($neo4jClient, $queryString);
	$result = $query->getResultSet();
	*/
?>
