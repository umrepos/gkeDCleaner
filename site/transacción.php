<?php
// Config conection
$username = 'root';
$password = '12345678';
$dbName = 'dcleaner';
$dbHost = '35.238.96.185';


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
  }
} catch (PDOException $e) {
	echo $e->getMessage();
}

$usuario = $_GET['usuario'];
$producto = $_POST['producto'];
$cantidad = $_POST['cantidad'];
$total = 0;
$tipo_pago = $_POST['pago'];
$fecha = date('Y-m-d');
$estatus = 'En proceso';


$sql = "SELECT * FROM productos WHERE nombre like :producto";
$statement = $conn->prepare($sql);
$statement->bindParam(':producto', $producto, PDO::PARAM_STR);
$statement->execute();
$prod = $statement->fetch(PDO::FETCH_ASSOC);
if ($prod) {
  $producto_id = $prod['id'];
}

$sql = "SELECT * FROM clientes WHERE nombre like :usuario";
$statement = $conn->prepare($sql);
$statement->bindParam(':usuario', $usuario, PDO::PARAM_STR);
$statement->execute();
$cliente = $statement->fetch(PDO::FETCH_ASSOC);
if($cliente){
  $cliente_id = $cliente['id'];
}



$sql = "INSERT INTO transacciones (producto_id, cliente_id, cantidad, total, tipo_pago, fecha, estatus) VALUES (:producto_id, :cliente_id, :cantidad, :total, :tipo_pago, :fecha, :estatus)";
$statement = $conn->prepare($sql);
$statement->execute(array(
  ':producto_id' => $producto_id,
  ':cliente_id' => $cliente_id,
  ':cantidad' => $cantidad,
  ':total' => $total,
  ':tipo_pago' => $tipo_pago,
  ':fecha' => $fecha,
  ':estatus' => $estatus,
));
echo '<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
<title>DCleaner</title>
<meta name="description" content="">
<meta name="author" content="WebThemez">
<!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!--[if lte IE 8]>
		<script type="text/javascript" src="http://explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script>
	<![endif]-->
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/isotope.css" media="screen" />
<link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
<link href="css/animate.css" rel="stylesheet" media="screen">
<link href="flexslider/flexslider.css" rel="stylesheet" />
<link href="js/owl-carousel/owl.carousel.css" rel="stylesheet">
<link rel="stylesheet" href="css/styles.css" />
<!-- Font Awesome -->
<link href="font/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<header class="header">
  <div class="container">
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a href="#" class="navbar-brand scroll-top logo  animated bounceInLeft"><b>D<i>CLEANER</i></b></a> </div>
      <!--/.navbar-header-->
      <div id="main-nav" class="collapse navbar-collapse">
        <ul class="nav navbar-nav" id="mainNav">
          <li class="active" id="firstLink"><a href="index.php" class="scroll-link">Inicio</a></li>
          <li><a href="index.php" class="scroll-link">Productos</a></li>
          <li><a href="index.php" class="scroll-link">Conócenos</a></li>
          <li><a href="index.php" class="scroll-link">Eventos</a></li>
          <li><a href="index.php" class="scroll-link">Promociones</a></li>
          <li><a href="index.php" class="scroll-link">Contacto</a></li>
          <li class="plan-action"><a href=#>'.$usuario.'</a></li>
          <li class="plan-action"><a href="index.php">Salir</a></li>
        </ul>
      </div>
      <!--/.navbar-collapse-->
    </nav>
    <!--/.navbar-->
  </div>
  <!--/.container-->
</header>
<!--/.header-->
<div id="#top"></div>
<section id="contactUs" class="contact-parlex">
  <div class="parlex-back">
    <div class="container">
      <div class="row">
        <div class="heading text-center">
          <!-- Heading -->
          <h2></h2>
        </div>
      </div>
      <div class="row mrgn30">
      <h1>Su pedido se realizo con éxito</h1>
        <form method="post" action="transacción.php?usuario='.$usuario.'" id="contactfrm" role="form">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="producto">Elija un producto </label>
	      <select id="producto" name="producto">';

        $statement = $conn->query("SELECT * FROM productos");
        while ($row = $statement->fetch()) {
          echo '<option value="'.$row['nombre'].'">'.$row['nombre'].'</option>';
        }
	      echo '</select>
            </div>
            <div class="form-group">
              <label for="cantidad">Cantidad</label>
              <input type="int" class="form-control" name="cantidad" id="cantidad" placeholder="Escriba la cantidad" maxlength="7" title="Ingrese la cantidad númerica" required>
            </div>
            <div class="form-group">
                <label for="pago">Elija la opción de pago:</label>
                <select id="pago" name="pago">
                  <option value="transferencia">Transferencia</option>
                  <option value="Paypal">Paypal</option>
                  <option value="Skrill">Skril</option>
                </select>
            </div>
            <div class="form-group">
              <button name="submit" type="submit" class="btn btn-lg btn-primary" id="submit">Realizar pedido</button>
            </div>
            <div class="result"></div>
          </div>
      </div>
    </div>
    <!--/.container-->
  </div>
</section>
<footer>
<div class="container">
        <div class="row">
            <div class="col-md-3">
            	<div class="col">
                   <h4>Contacto</h4>
                   <ul>
                        <li>México</li>
                        <li>Telefóno: +22 342 2345 345 | Fax: +22 724 2342 343 </li>
                        <li>Correo: <a href="mailto:info@example.com" title="Email Us">info@dcleaner.com</a></li>
                        <li>Skype: <a href="skype:my.test?call" title="Skype us">my-dcleaner</a></li>
                    </ul>
                 </div>
            </div>
            <div class="col-md-3">
            	<div class="col">
                    <h4>Suscripción</h4>
                    <p>Suscríbase, para recibir nuestras mejores ofetas por correo.</p>
                    <form class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Escriba su correo...">
                            <span class="input-group-btn">
                                <button class="btn" type="button">Go!</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
            	<div class="col col-social-icons">
                    <h4>Síguenos</h4>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-google-plus"></i></a>
                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                    <a href="#"><i class="fa fa-flickr"></i></a>
                    <a href="#"><i class="fa fa-linkedin"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-skype"></i></a>
                    <a href="#"><i class="fa fa-pinterest"></i></a>
                </div>
            </div>
             <div class="col-md-3">
             	<div class="col">
                    <h4>Noticias</h4>
                    <p>
                    Enterese sobre los acontecimientos de DCleaner.
                    <br><br>
                    <a href="#" class="btn">Entérate!</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--/.page-section-->
<section class="copyright">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> Copyright 2021 | All Rights Reserved -- by <a href="http://dcleaner.com">dcleaner.com</a> </div>
    </div>
    <!-- / .row -->
  </div>
</section>
<a href="#top" class="topHome"><i class="fa fa-chevron-up fa-2x"></i></a>
<!--[if lte IE 8]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script><![endif]-->
<script src="js/modernizr-latest.js"></script>
<script src="js/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery.isotope.min.js" type="text/javascript"></script>
<script src="js/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="js/jquery.nav.js" type="text/javascript"></script>
<script src="js/jquery.fittext.js"></script>
<script src="js/waypoints.js"></script>
<script src="flexslider/jquery.flexslider.js"></script>
<script src="js/custom.js" type="text/javascript"></script>
<script src="js/owl-carousel/owl.carousel.js"></script>
</body>
</html>
';
?>
