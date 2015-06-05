<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Felicidades</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/style.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
<link rel="icon" href="images/inspira.ico" type="image/ico" />
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	
        <link rel="stylesheet" type="text/css" href="bootstrap/css/slide.css" />
        <link rel="stylesheet" type="text/css" href="bootstrap/css/slidestyle.css" />
	<link rel="stylesheet" href="jquery.h5-lightbox.css">
</head>
<body id="page" style="background-image:url('images/3.jpg'); background-repeat:no-repeat; background-position: center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
 <?php 
    $path_header = base_path()."/resources/views/chunks/header.php";
    include_once $path_header;

?>
<div class="container" style="margin-top:50px;">

<div class="container">
	
    <div class="row"  style="margin-bottom:50px; background-color:#e5e7e9; margin-bottom:500px;">
        
	
        
        
        <div class="col-lg-12 col-md-12">
			
        <form action="?route=users/login" method="post">
	        <div>
            <div><div><strong>Email</strong></div></div>
            <div><input type="text" name="email" /></div>
          </div>
          <div>
            <div><div><strong>Password</strong></div></div>
            <div><input type="password" name="password" /></div>
          </div>
           <div>
            <div style="margin-top:10px;"><input type="submit" value="Ingresar" class="btn btn-danger" style="background-color:#465664; border-color:#465664;"/> </div>
    </div>
  </div>
      
      <div class="col-md-6" style="display:inline;">
		</form>
     
    

			
        </div>
    </div>
    
      
</div>

</div>
	<?php 
if(isset($user_data["language"])){
if($user_data["language"]=="ES"){
include "php/footer.php";
}else{
include "php/footerENG.php";
}
}else{
include "php/footer.php";
}
?>
</body>
</html>
