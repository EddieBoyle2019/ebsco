<!DOCTYPE HTML>  
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EBSCO API client</title>

    <!--[if lt IE 9]>
    <p>This website requires Internet Explorer 9 or later</p>
    <![endif]-->

    <!-- Twitter Bootstrap CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.css" rel="stylesheet" media="screen">
    <!-- jQuery library (necessary for Bootstrap) -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!-- Twitter Bootstrap JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <!--external stylesheet-->
    <link rel="stylesheet" type="text/css" href="api_client.css">
   
</head>

<body>  

<?php

//for development only
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// define variables and set to empty values

$search = "";
$searchErr = "";

//form validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["search"])) {
    $searchErr = "A search term is required";
  } else {
    $search = test_input($_POST["search"]);
    // check if search term only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/", $search)) {
      $searchErr = "Only letters and white space are allowed in the search term";
    } else{ // carry out the API request
    }
  }
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//recursive function to parse through levels of JSON associative arrays 
function printAll($a) {
    if (!is_array($a)) {
        //echo $a, '<br/>';
        return;
    }

    foreach($a as $k => $value) {

         if (($k == "packageName") && (!is_array($value)))
     {
        echo $value . "<br/>";
     }
         if (($k == "vendorId") && (!is_array($value)))
     {
        echo $value . "<br/>";
     }
         printAll($k);
         printAll($value);

    }
}

$api_key = '2YPSgidTwDaXf1d26VR004C0dcromPtB27mkBEE2';

$url = 'https://sandbox.ebsco.io/rm/rmaccounts/apidvgvmt/packages?search=boston&orderby=relevance&count=10&offset=1';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$headers = [
     'X-API-Key : ' . $api_key,
     'Content-Type: application/json',
     'Accept : application/json'
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

?>

<!-- Twitter Bootstrap RWD navbar header -->
<header id="navbar" class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <div class="header">
    <div class="title">
    EBSCO HoldingsIQ API client
    </div>
    <div class="headerLinks">
    </div>
      </div>
      <!-- used as the toggle for collapsed navbar menu -->
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
      </button>
    </div>
    <div class="navbar-collapse collapse">
      <!-- main navbar menu -->
      <nav>
    <ul class="menu nav navbar-nav">
      <li class="first leaf"></li>
      <li class="leaf"></li>
      <li class="leaf"></li>
      <li class="leaf"></li>
      <li class="last leaf"></li>
    </ul>
      </nav>
    </div>
  </div>

</header>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <h3>Search for packages</h3>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Search term: <input type="text" name="search" size="30" value="">
    <span class="error">* <?php echo $searchErr;?></span>
    <br/><br/>
    <p><span class="error">* required field</span></p>
    <br/>
    <input type="reset" value="Clear">
    <input type="submit" name="submit" value="Search">  
      </form>

<?php
echo "<h3>Search results</h3>";
echo "Search term: " . $search;
echo "<br>";
echo "Top 10 most relevant items only";
echo "<br>";

if ($search)
{    
    $result = curl_exec($ch);

    curl_close($ch);

    //var_dump(json_decode($result, true));

    //read JSON data response into associative array
    $data = json_decode($result, true);

    printAll($data);
}

?>

    </div>
  </div>

  <!-- Footer with links to functions and options -->
  <div id="footer">
    <div id="left-footer">
      <div class="open-help">
      </div>
      <div id="right-footer">
    <div class="open-data"></div>
      </div>
    </div>
  </div>

</div>

</body>
</html>