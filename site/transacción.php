<?php
// Config conection
$username = 'root';
$password = '12345678';
$dbName = 'dcleaner';
$dbHost = '34.134.50.99';


// Connect to the database.
$connConfig = [
   PDO::ATTR_TIMEOUT => 5,
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ];  
$dsn = sprintf('mysql:dbname=%s;host=%s', $dbName, $dbHost);
// Connect to the database
try {
  $conn = new PDO($dsn, $username, $password, $connConfig);
  if ($conn) {
    echo "Connected to the $dbName database successfully!";
  }
} catch (PDOException $e) {
	echo $e->getMessage();
}

$cantidad = $_POST['cantidad'];
$pago = $_POST['pago'];
$ciudad = $_POST['ciudad'];
$total = $cantidad * 8.56;
$sql = "INSERT INTO transacciones (prod_id, cliente_id, descripcion, cantidad, total, tipo_pago, fecha, ciudad) values
(1, 1, 'cubrebocas',".$cantidad.",".$total.",'".$pago."','".date('Y-m-d')."', '".$ciudad."')";
$statement = $conn->prepare($sql);
$statement->execute(); 

?>
