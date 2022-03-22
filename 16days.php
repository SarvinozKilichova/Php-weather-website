
<?php

//determine 16days weather api

$ip = "185.139.137.88";$_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

    
$apiKey = "1535ee5b019d4d998e95d7b7a248e102";
if ( isset($_GET['city'])){
    $city=$_GET["city"] ;
 
}

else{
    $city= $details->city;
}



    
  
    $googleApiUrl = "https://api.weatherbit.io/v2.0/forecast/daily?city=" . $city.  "&key="
    . $apiKey;
    
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    
    curl_close($ch);
    
    
 
    $daily = json_decode($response);
    
    $string=file_get_contents("icon.json");
    $json_a=json_decode($string, true);




      if (empty($daily->data[0]->weather->description)) {
      
    $myfile ="City is not found <br>Please enter valid city name";
    
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="alertify/css/alertify.css">
    <title>Weather.uz</title>
</head>
<body>
    
<div  class="top" >
 
  <h1 class="logo">Weather.UZ</h1>
    <div  class="search-menu">
    <form>
        <input type="text" id="city" name="city" placeholder="enter your city" value="<?php echo $_GET['city']; ?>" onkeypress='validate(event)' required>
        <input   type="submit" id="search"  name="search" value="search">
         </div> 
                
        </div>

        <div class="main-navbar"> 
        <a href="index.php?city=<?php echo $_GET['city']; ?>&search=search"><input  type="button" name="current" id="current" value="Current" ></a>
        <a href="16days.php?city=<?php echo $_GET['city']; ?>&search=search"><input type="button" name="forecast" id="forecast" value="16 days"></a>
        
        </div>    
    </form>
</div>
<hr>


<h1 class="error"><?php echo $myfile;?></h1> 
<div class="daily-weather">

<h1>16 days weather in <?php echo $daily->city_name; ?></h1>
   
<?php for ($i=0; $i <16 ; $i++) { ?>
    <div class="daily-weather1">

<table class="daily-table">

    <tr>
        <td><?php echo $daily->data[$i]->datetime; ?></td>
        <td class="main-temp"><?php echo round($daily->data[$i]->max_temp); ?>°C...<?php echo round($daily->data[$i]->app_max_temp); ?>°C</td>
              <td>direction:<?php echo $daily->data[$i]->wind_cdir_full; ?></td>
             
                
                
</tr>

<tr>
     <td><img
            class="weather-icon"
            src="<?php echo $json_a['weather'][$daily->data[$i]->weather->icon];?>"></td>
             <td class="main-temp"><?php echo round($daily->data[$i]->min_temp); ?>°C...<?php echo round($daily->data[$i]->app_min_temp); ?>°C</td>
                <td>pressure:<?php echo round($daily->data[$i]->pres); ?>mb</td>
</tr>
<tr>
<td class="description"><?php echo $daily->data[$i]->weather->description; 
?></td> 
    <td>wind:<?php echo round($daily->data[$i]->wind_spd); ?>m/s</td>

        <td>humidity:<?php echo round($daily->data[$i]->rh); ?>%</td>

</tr>
       
   
  


<tr>
    
    <td colspan="2" class="table-border" > <img class="sun-icon" src="sun.jpg">sun rise:<?php echo date( "h:i a", $daily->data[$i]->sunrise_ts); ?></td>
    
    <td colspan="3" class="table-border"><img class="sun-icon" src="sunset.jpg">sun set:<?php echo date( "h:i a", $daily->data[$i]->sunset_ts); ?> </td>
    
</tr>








</table>
</div>
<br>
<?php } ?>







</div>


<hr>
<footer>
    <small> Weather.UZ   <br>  <a href="terms.html">Terms</a> <br>   copy right &copy; 2020</small>
</footer>

<script src="alertify/alertify.js"></script>
<script src="main.js"></script>


</body>
</html>