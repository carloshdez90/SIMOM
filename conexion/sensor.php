<?php
include('config.php');


class temperatura{
	//Conectamos con mysql
	var $mysql;
	var $idSensor = "";
	var $promedio = 0;

	function __construct() {
		$this->mysql = new mysql;
		$this->mysql->server   = "localhost";
		$this->mysql->user     = "root";
		$this->mysql->pass     = "raspberry";
		$this->mysql->connect();
		$this->mysql->select("SIMOM"); 
		
   }

   function promedio($result){
   		return ($result[0]+$result[1])/2; 

   }

   function graficoX()   {
   	$sql = $this->mysql->query("SELECT * FROM  `LECTURAS` ORDER BY  `LECTURAS`.`FECHAHORA` ASC "); 
   	$j = 1;
   	while ($result = $this->mysql->f_array($sql) and $j==1) {
			for($i = 0; $i < 4; $i++){
				$valores[] = $result[$i];
			}
			$j++;
		}

	return $valores;
   }

	function obtener(){

		$sql = $this->mysql->query("SELECT * FROM  `LECTURAS` ORDER BY  `LECTURAS`.`FECHAHORA` ASC "); 
		while ($result = $this->mysql->f_array($sql)) {
			for($i = 0; $i <= 14; $i++){
				echo $result[$i]."<br>";
			}
		}			
	}

	function lectura($max){
		$sql = $this->mysql->query("SELECT * FROM `LECTURAS` ORDER BY NLECTURA DESC;"); 
		$result = $this->mysql->f_array($sql);
		echo '
				<!-- ******************** hilera de sensores*************** -->
				<div id="hilera1">
					<div class="hilera">
							<label id="sensor1">HILERA N° 1</label>
					</div>';
			
		echo $this->imprimirSensor($max,$result[1],1);
		echo $this->imprimirSensor($max,$result[2],2);
		echo $this->imprimirSensor($max,$result[3],3);
		echo $this->imprimirSensor($max,$result[4],4);
		echo '			<div class="promedio">
							<label id="sensor1">Promedio: '.number_format((($result[1]+$result[2]+$result[3]+$result[4])/4), 2, ".", ",").'</label>
					</div>		
				</div>

			<!-- ******************** hilera de sensores*************** -->
				<div id="hilera2">
					<div class="hilera">
							<label id="sensor1">HILERA N° 2</label>
					</div>';
		echo $this->imprimirSensor($max,$result[5],5);
		echo $this->imprimirSensor($max,$result[6],6);
		echo $this->imprimirSensor($max,$result[7],7);
		echo $this->imprimirSensor($max,$result[8],8);
	
			echo'		<div class="promedio">
							<label id="sensor1">Promedio: '.number_format((($result[5]+$result[6]+$result[7]+$result[8])/4), 2, ".", ",").'</label>
					</div>	
				
				</div>

			<!-- ******************** hilera de sensores*************** -->
				<div id="hilera3">
					<div class="hilera">
							<label id="sensor1">HILERA N° 3</label>
					</div>';
					
			echo $this->imprimirSensor($max,$result[9],9);
		echo $this->imprimirSensor($max,$result[10],10);
		echo $this->imprimirSensor($max,$result[11],11);
		echo $this->imprimirSensor($max,$result[12],12);
	
			echo '
					<div class="promedio">
							<label id="sensor1">Promedio: '.number_format((($result[9]+$result[10]+$result[11]+$result[12])/4), 2, ".", ",").'</label>
					</div>	
				</div>
				<div class="total">
							<label id="sensor1">Promedio General: '.number_format((($result[1]+$result[2]+$result[3]+$result[4]+$result[5]+$result[6]+$result[7]+$result[8]+$result[9]+$result[10]+$result[11]+$result[12])/12), 2, ".", ",").'</label>
				</div>	
		';
	}
	
	function imprimirSensor($max,$lectura,$sensor){

	
	if($lectura>$max)
	echo "<div class='sensor' style='color:white; background-color:red; font-weight:bold;'>
		<label id='sensor".$sensor."'>Sensor ".$sensor.": ".$lectura."°C</label>
					</div>
		";
	else
	echo "<div  class='sensor' style='color:white; background-color:green; font-weight:bold;'>
		<label id='sensor12'>Sensor ".$sensor.": ".$lectura."°C</label>
					</div>
		";
	
	}
}
?>

