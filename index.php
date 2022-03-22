<?php



//determine current weather api 

 
$ip = "185.139.137.88";$_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));   
$apiKey = "a54dd6f6f714489b91ec51546ce4dc35";

if (isset($_GET['city'])) {
    $city= $_GET['city'];
   
      }
     else {
     $city= $details->city ;


}
 



$googleApiUrl = "https://api.weatherbit.io/v2.0/current?city=" . $city.  "&key="
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


 
$data = json_decode($response);



//rewriting json elements
$cityn=$data->data[0]->city_name;
$icon= $data->data[0]->weather->icon;
$pod=$data->data[0]->pod;
$temp=round($data->data[0]->temp);
$description=$data->data[0]->weather->description;
$main=$data->data[0]->wind_cdir_full;
$wind_Speed=round($data->data[0]->wind_spd);
$wind_d=$data->data[0]->wind_cdir_full;
$pressure= round($data->data[0]->pres);
$humidity=round($data->data[0]->rh);
$rise=$data->data[0]->sunrise;
$set=$data->data[0]->sunset;
$timezone=str_replace("\/", "/", $data->data[0]->timezone); 

//changing to local time
$userTimezone = new DateTimeZone($timezone);
$gmtTimezone = new DateTimeZone('GMT');
$myDateTime = new DateTime( $rise, $gmtTimezone);
$offset = $userTimezone->getOffset($myDateTime);
$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');
$myDateTime->add($myInterval);
$sunrise = $myDateTime->format('H:i');

//changing to local time
$userTimezone = new DateTimeZone($timezone);
$gmtTimezone = new DateTimeZone('GMT');
$myDateTime = new DateTime( $set, $gmtTimezone);
$offset = $userTimezone->getOffset($myDateTime);
$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');
$myDateTime->add($myInterval);
$sunset = $myDateTime->format('H:i');


  if (empty($description)) {
      
    $myfile ="City is not found <br>Please enter valid city name";
    
}
//changing d to day
 if ($pod===d) {
     $pod_="day";
     $pod=$pod_;
}
else{
    $pod_="night";
     $pod=$pod_;
}



$string=file_get_contents("icon.json");
$json_a=json_decode($string, true);

?>


<?php



//determine hourly weather api


$ip = "185.139.137.88";$_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

    
$apiKey = "a54dd6f6f714489b91ec51546ce4dc35";
if (isset($_GET['city'])) {

    $city= $_GET['city'];
} else {
    $city= $details->city;
}



$googleApiUrl = "https://api.weatherbit.io/v2.0/forecast/hourly?city=" . $city.  "&key="
. $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
date_default_timezone_set($response['timezone']);
curl_close($ch);
$forecast = json_decode($response);
$currentTime = time();


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
    <form >
        <input type="text" id="city" name="city" placeholder="enter your city" value="<?php echo $_GET['city']; ?>" onkeypress='validate(event)' required>
        <input   type="submit" id="search"  name="search" value="search" >
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
<div id="currenttable">
<h1> Current Weather in <?php echo $cityn;?> </h1>

 <h3 class="date"><?php echo date("jS F, Y"); ?></h3>
<div class="current-weather">

 <table>
     <tr>          
    <td><img
                src="<?php echo $json_a['weather'][$icon];?>"
                class="weather-icon" /></td>
     <td class="main-temp"><?php echo $temp ?> °С</td> 
    <td class="description"><?php echo ucwords($main); ?></td> 
             
      <td class="pressure"> pressure: <?php echo $pressure; ?>mb</td>             
</tr>
    <tr>
<td> <?php echo $pod; ?></td> 
 
<td class="description"><?php echo ucwords($description); ?></td>
<td class="wind"> wind speed: <?php echo $wind_Speed; ?>m/s</td> 
 <td class="humidity"> humidity: <?php echo $humidity; ?>%</td>
</tr>


    <tr >
        <td colspan="2" class="rise"> <img class="sun-icon" src="sun.jpg">sun rise: <?php echo $sunrise; ?></td> 

<td colspan="3" class="set"> <img class="sun-icon" src="sunset.jpg">sun set: <?php echo  $sunset; ?></td> 
<td ></td>
</tr>
</table>
</div>
</div>




    <div class="hourly">
    <h1>24 hours Weather in <?php echo $cityn;?> </h1>

    <div class="current-weather1">
   <?php for ($i=0; $i <24 ; $i++) {?>
        <table class="hourly-table">
        <tr>
            <td><?php echo $forecast->data[$i]->timestamp_local; ?></td>
            <td> <?php  if ($forecast->data[$i]->pod==="d") {
                $fpod_="day";
                $forecast->data[$i]->pod=$fpod_;
            }
            if($forecast->data[$i]->pod==="n"){
               $fpod_="night";
               $forecast->data[$i]->pod=$fpod_;
            } echo $forecast->data[$i]->pod; 
            
           ?></td>
            <td><img
            class="weather-icon"
                src="<?php echo $json_a['weather'][$forecast->data[$i]->weather->icon];?>"></td>
                <td><?php echo ucwords($forecast->data[$i]->weather->description); ?> </td>
                <td class="main-temp"><?php echo round($forecast->data[$i]->temp)."°C".'...' .round($forecast->data[$i]->app_temp);?>°C</td>
                    <td><?php echo $fwind=round($forecast->data[$i]->wind_spd); ?>m/s</td>
                    <td> <?php echo $fpressure= round($forecast->data[$i]->pres); ?>mb</td>
                    <td> <?php echo  $fhumidity=round($forecast->data[$i]->rh); ?>%</td>
            
      
            </tr>
    </table>
    <hr>
    <?php } ?>
    
    </div>
        </div>
<br>















<hr>
<footer>
    <small> Weather.UZ     <br> <a href="terms.html">Terms</a> <br> copy right &copy; 2020</small>
</footer>

<script src="alertify/alertify.js"></script>
<script src="main.js"></script>


</body>
</html>