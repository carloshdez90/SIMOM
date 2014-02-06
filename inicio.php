<!doctype html>
<?php
	include('conexion/sensor.php');
	if(isset($_REQUEST['max'])&& $_REQUEST['max']!=""){
		$maximo = $_REQUEST['max'];
	}else {
		$maximo = 40;
	}

error_reporting(E_ALL & ~E_NOTICE);
   include 'funciones/funciones.php';
   date_default_timezone_set('America/El_Salvador');
  $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
   //creamos la sesion
    session_start();

    //si no se ha hecho la sesion nos regresará a login.php
    if(!isset($_SESSION['usuario']))
    {
      header('Location: index.php');
      $_SESSION = array();
     //Destruir Sesión
     session_destroy();
     exit();
    }
?>

<html>
<head>
<meta charset="utf-8">
<title>SIMOM | Sistema de Monitoreo de Temperatura</title>
<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/JavaScript">
 
var conexion;
function crearXMLHttpRequest() 
{
  var xmlHttp=null;
  if (window.ActiveXObject) 
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  else 
    if (window.XMLHttpRequest) 
      xmlHttp = new XMLHttpRequest();
  return xmlHttp;
}
function mostrarTemperaturas()
{
    conexion=crearXMLHttpRequest();
    conexion.onreadystatechange = procesarEventos;
    conexion.open('GET', 'conexion/proceso.php?max='+document.getElementById('maximo').value, true);
    conexion.send(null);
}
 
function procesarEventos()
{
  var detalles = document.getElementById("sensores");
  if(conexion.readyState == 4)
  {
    detalles.innerHTML = conexion.responseText;
  } 
  else 
  {
    //detalles.innerHTML = 'Cargando...';
  }
}
</script>
</head>

<body onLoad="setInterval('mostrarTemperaturas()',1000);">

<div class='barra'>
	<span class='fecha'>
		<?php
	        echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');
	    ?>
    </span>

    <span class='cerrar'>
		
	        <a href="logout.php"> Cerrar sesión </a>
	   
    </span>
</div>
	
	
	<div id="logo" style='display:none'>
		<img src="imagenes/BBpi.png" alt = "Proyecto elaborado con el raspberry pi" width="150px"
			 height="150px" />		
	</div>
	<?php
	echo "<input type='hidden' value='".$maximo."' id='maximo'>";
	
	
	?>

	<div id="botones">
		<form method="get" >
			   <label>Limite Actual: <strong> <?php echo $maximo." °C" ?> </strong></strong></label> <br><br>
			  <label>Limite Temperatura:</label>
              <input class="temEntrada" name="max" type="number" pattern="[0-9]+([\.|,][0-9]+)?" step="0.01" title="Solo se permiten dos decimales"  placeholder="00.00"/><br>
              <input class="temBoton" type="submit" value="Registrar">
		</form>
			
	</div>

	<div id="principal">
		<h1>Sistema de Monitoreo de Temperatura</h1>

		<div id="sensores">
			
		</div>
	</div>
</body>
</html>
