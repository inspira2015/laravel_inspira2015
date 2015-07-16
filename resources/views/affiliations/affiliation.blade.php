@extends('layouts.basic')

@section('content')
    <div class="container">
      <div class="row" style="background-color:#e5e7e9; margin-bottom:0px; padding-top:50px; padding-left:40px; padding-right:40px;">
        <h2 style="float:left; text-transform:uppercase; margin-bottom:25px; text-align:left; 40px;display:inline;">
          Favor de seleccionar la afiliaci&oacute;n de su preferencia
        </h2>
      </div>
      
      <div class="row"  style="margin-bottom:50px; background-color:#e5e7e9; margin-bottom:50px; padding-top:50px;">
        <form method="post" action="?route=users/afiliacion" id="profile" name="formulario"><input type="hidden" name="email" value="$user_data["email"]"/>
        

        <?PHP 
            if($user_codes["discover"]>=0){
                  echo '<div class="col-lg-'.(12/$cols).' col-md-'.(12/$cols).'" style="margin-bottom:100px;">
                        <h1 style="color:#ffffff; background-color:#529ad3; text-align:center;  margin:0px 10px; padding:10px; font-size:26px;">'.$user_affiliations[0]["name_es"].'</h1>
                        <div class="content" style="margin-top:0px; background-color:#eef0f0; margin-bottom:0px; padding-bottom:0px;">
                    
                          <div class="informacion">

                          <p style="text-align:center">'.$user_affiliations[0]["small_desc_es"].'</p>
                          
                        </div>
                          <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>
                        </div>




                          <div class="content" style="margin-top:0px; margin-bottom:0px;">
                          
                          <div class="informacion">

                          
                          
                        
                          <ul style="list-style-type:disc;">';

          foreach($large_desc as $k => $v)
            if($v['affiliation_id']==$user_affiliations[0]["id"])echo '<li>'.$v['description'].'</li>';

          ?>
<?PHP echo'</ul>
            
          </div>
            
          </div>

          <div class="content" style="margin-top:0px; background-color:#eef0f0; margin-bottom:0px; padding-bottom:0px; padding-top:0px;">
          <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>  
            <div class="informacion">

            
            
          
            <h2 style="text-align:center">CUOTA MENSUAL: <br>';
if($user_codes["currency"]=="MXN"){
echo $user_codes["discover"];
echo ' MXN';
if($user_data["currency"]=="USD"){
echo ' ('.(round($user_codes["discover"]/$currency["rate"], 2)).' USD)';
}
}
else{
echo $user_codes["discover"];
echo ' USD ';
if($user_data["currency"]=="MXN"){
echo ' ('.$user_codes["discover"]*$currency["rate"].' MXN)';
}
}


echo '</h2>


            
          </div>
            <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>
          </div>
          <div class="content" style="margin-top:0px; margin-bottom:0px;">
            
            <div class="informacion" style="min-height:130px;">

            <h2>PRIMER MES GRATIS</h2>
            
          
          <div style="display:inline; float:left; text-align:left;">
            <input type="radio" value="'.$user_affiliations[0]["id"].'" name="afiliacion" style="width:30px;" checked="checked"/>
          </div>
          <h2  style="display:inline;color:#5198cc; float:left; width:60%;">
            Deseo ser afiliado '.$user_affiliations[0]["name_es"].'</h2> 
            
          </div>
            
          </div>

        </div>';
    }

?>
       <?PHP 
if($user_codes["platinum"]>=0){
    echo '<div class="col-lg-'.(12/$cols).' col-md-'.(12/$cols).'">
          <h1 style="color:#ffffff; background-color:#a4ce3a; text-align:center;  margin:0px 10px; padding:10px; font-size:26px;">'.$user_affiliations[1]["name_es"].'</h1>
          <div class="content" style="margin-top:0px; background-color:#eef0f0; margin-bottom:0px; padding-bottom:0px;">
            
            <div class="informacion">

            
            
          
            <p style="text-align:center">'.$user_affiliations[1]["small_desc_es"].'</p>


            
          </div>
            <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>
          </div>




            <div class="content" style="margin-top:0px; margin-bottom:0px;">
            
            <div class="informacion">

            
            
          
            <ul style="list-style-type:disc;">';

foreach($large_desc as $k => $v)
if($v['affiliation_id']==$user_affiliations[1]["id"])echo '<li>'.$v['description'].'</li>';

?>
<?PHP echo'</ul>
            
          </div>
            
          </div>

          <div class="content" style="margin-top:0px; background-color:#eef0f0; margin-bottom:0px; padding-bottom:0px; padding-top:0px;">
          <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>  
            <div class="informacion">

            
            
          
            <h2 style="text-align:center">CUOTA MENSUAL: <br>';
if($user_codes["currency"]=="MXN"){
echo $user_codes["platinum"];
echo ' MXN';
if($user_data["currency"]=="USD"){
echo ' ('.(round($user_codes["platinum"]/$currency["rate"], 2)).' USD)';
}
}
else{
echo $user_codes["platinum"];
echo ' USD ';
if($user_data["currency"]=="MXN"){
echo ' ('.$user_codes["platinum"]*$currency["rate"].' MXN)';
}
}


echo '</h2>


            
          </div>
            <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>
          </div>
          <div class="content" style="margin-top:0px; margin-bottom:0px;">
            
            <div class="informacion" style="min-height:130px;">
<h2>PRIMER MES GRATIS</h2>
            
            
          
          <div style="display:inline; float:left; text-align:left;">
            <input type="radio" value="'.$user_affiliations[1]["id"].'" name="afiliacion" style="width:30px;" checked="checked"/>
          </div>
          <h2  style="display:inline;color:#a4ce3a; float:left; width:60%;">
            Deseo ser afiliado '.$user_affiliations[1]["name_es"].'</h2> 
            
          </div>
            
          </div>

        </div>';
    }

?>
       
             <?PHP 
if($user_codes["diamond"]>=0){
    echo '<div class="col-lg-'.(12/$cols).' col-md-'.(12/$cols).'">
          <h1 style="color:#ffffff; background-color:#cc4b9b; text-align:center;  margin:0px 10px; padding:10px; font-size:26px;">'.$user_affiliations[2]["name_es"].'</h1>
          <div class="content" style="margin-top:0px; background-color:#eef0f0; margin-bottom:0px; padding-bottom:0px;">
            
            <div class="informacion">

            
            
          
            <p style="text-align:center">'.$user_affiliations[2]["small_desc_es"].'</p>


            
          </div>
            <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>
          </div>




            <div class="content" style="margin-top:0px; margin-bottom:0px;">
            
            <div class="informacion">

            
            
          
            <ul style="list-style-type:disc;">';

foreach($large_desc as $k => $v)
if($v['affiliation_id']==$user_affiliations[2]["id"])echo '<li>'.$v['description'].'</li>';

?>
<?PHP echo'</ul>
            
          </div>
            
          </div>

          <div class="content" style="margin-top:0px; background-color:#eef0f0; margin-bottom:0px; padding-bottom:0px; padding-top:0px;">
          <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>  
            <div class="informacion">

            
            
          
            <h2 style="text-align:center">CUOTA MENSUAL: <br>';
if($user_codes["currency"]=="MXN"){
echo $user_codes["diamond"];
echo ' MXN';
if($user_data["currency"]=="USD"){
echo ' ('.(round($user_codes["diamond"]/$currency["rate"], 2)).' USD)';
}
}
else{
echo $user_codes["diamond"];
echo ' USD ';
if($user_data["currency"]=="MXN"){
echo ' ('.$user_codes["diamond"]*$currency["rate"].' MXN)';
}
}

echo '</h2>


            
          </div>
            <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>
          </div>
          <div class="content" style="margin-top:0px; margin-bottom:0px;">
            
            <div class="informacion" style="min-height:130px;">
<h2>PRIMER MES GRATIS</h2>
            
            
          
          <div style="display:inline; float:left; text-align:left;">
            <input type="radio" value="'.$user_affiliations[2]["id"].'" name="afiliacion" style="width:30px;" checked="checked"/>
</div>
          <h2  style="display:inline;color:#cc4b9b; float:left; width:60%;">
            Deseo ser afiliado '.$user_affiliations[2]["name_es"].'</h2> 
            
          </div>
            
          </div>

        </div>';
    }

?>
        <div class="col-lg-12 col-md-12" style="padding:20px;">
          <div class="divider"></div></div>
        <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  <a href="?route=users/profile"><img style="width:50%; height:auto;"src="images/regresartransparente.png"/></a></div>
          <div class="col-lg-4 col-md-4 col-sm-4">&nbsp;</div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  <a href="#" onClick="formulario.submit()"><img style="width:50%; height:auto;"src="images/continuar.png"/></a></div>
    </div>
    
      
  </div>

@endsection