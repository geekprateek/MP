  <!DOCTYPE HTML>
<html>
<head>
<title>Phenomanal</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<link rel="stylesheet" type="text/css" href="styles/layout.css">
<script src="scripts/jquery-1.7.2.min.js"></script>
<script src="scripts/jquery.carouFredSel-5.5.2.js"></script>
<script src="scripts/jquery.easing.1.3.js"></script>
<!--[if lt IE 9]>
<script src="scripts/html5.js"></script>
<script src="scripts/css3-mediaqueries.min.js"></script>
<![endif]-->
</head>
<body>
<div class="wrapper">
	<div id="top" class="clearfix">
		<!-- add in logo -->
		<div id="logo"><img id="logoimage" src="" alt=""> 
		  <h1 id="logotitle">Phenomanal</h1>
		</div>
		<!--/logo-->
		<nav>
		  <ul>
			<li><a href="index.html">Home</a></li>
			<li><a href="#">Data</a></li>
			<li><a href="work.html">Help</a></li>
			<li><a href="#">Contact</a></li>
		  </ul>
		</nav>
	</div>
  <header>
    <h1><span>Kitty</span> ipsum dolor sit amet, attack et orci turpis quis vehicula, pellentesque kittens stuck in a tree I don't like that food feed me hiss. </h1>
    <h2>Fluffy fur et bat tortor in viverra</h2>
  </header>
 
 <!--  /********************************** Body goes here**************************/  -->
 
  <?php 
//searches for specific diseases using index.html and POST to get the variable submitted
	if (isset($_GET['searchQuery'])){ 
    $searchQuery = $_GET['searchQuery'];

}
echo "var".$searchQuery."<br>";
$searchQuery2="phe:";
$searchQuery=$searchQuery2.$searchQuery;
echo "var".$searchQuery."<br>";


//this file loads specific things from biocrunch../sparql -- look at query below

//include rap
define("RDFAPI_INCLUDE_DIR", "rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");

//sparql client
$client = ModelFactory::getSparqlClient("http://biocrunch.dcs.aber.ac.uk:8890/sparql"); 
//Find the name of all diseases
$querystring = "


PREFIX phe: <http://phenomebrowser.org/phenomenet/>
PREFIX obo: <http://obofoundry.org/obo>

select *
where { $searchQuery phe:has_edge ?edge .
        ?edge phe:has_value ?value ;
              phe:has_node ?node .
		?node phe:has_name ?name
			  
		FILTER (?node != $searchQuery) 
		FILTER regex(?node, 'OMIM', 'i')
}
ORDER BY DESC(?value)
";


//the %s relates to the variable at the end of the line"
//?s= <http://www.example.co.uk/genotype/disease#X>
//?p= http://purl.org/dc/elements/1.1/title

//To execute the query, we create a new ClientQuery 
//object and pass it to the SPARQL client:

$query = new ClientQuery();
$query->query($querystring);
$result = $client->query($query);

//The following code loops over the result set and prints out all 
//results of the variable ?title.
?>
  <table id="hor-minimalist-a" summary="Diseases">
 <thead>
    	<tr>
        	<th scope="col">Edge  name (ID)</th>
            <th scope="col">Similarity Value</th>
			<th scope="col">Node</th>
			<th scope="col">Phenotypes</th>
			<th scope="col"></th>

			<!--            <th scope="col">Link</th> -->

          
        </tr>
    </thead>
    <tbody>
   <?php

foreach($result as $line){
  $name = $line['?name'];
  $value = $line['?value'];
  $node =$line['?node'];  
	/*if (preg_match('/"([^"]+)"/', $edge, $m)) { //finds instances that match regex aka gets url
    $edge = $m[0];   	//assign first instance to dis
	$c=explode("/", $edge); //explode dis to get just end of url
	$edge=end($c); 
	$edge = str_replace('"', "", $edge); //remove quotations from string.
} */
if (preg_match('/"([^"]+)"/', $node, $m)) { //finds instances that match regex aka gets url
    $node = $m[0];   	//assign first instance to dis
	$c=explode("/", $node); //explode dis to get just end of url
	$node=end($c); 
	$node = str_replace('"', "", $node); //remove quotations from string.
} 
if (preg_match('/"([^"]+)"/', $name, $n)) {
	$name = $n[0]; 
	$name =str_replace('"', "", $name);
} 
	if (preg_match('/"([^"]+)"/', $value, $n)) {
	$value = $n[0]; 
	$value =str_replace('"', "", $value);
} 
    if($name != ""){
      //echo $dis->toString()."..... ".$name->toString()."<br>"; // printed on same line now.  can easily turn into tables later on.
	 // echo $name->toString()."<br>";
	echo "<tr>";
        echo "<td>$name</td>";
		echo "<td>$value</td>"; //edge

       // echo "<td>Phenotypes</td>"; //edge pheno and inferred
		//trim string 
        echo "<td>$node</td>"; //edge
		echo "<td><a href='ontologyterms.php?searchQuery=$node'>Phenotypes</a></td>"; //edge
		echo "<td><a href='edge.php?searchQuery=$node'>Explore</a></td>"; //edge

        echo "</tr>";
	  }
    else{
      echo "undbound<br>";
	  }
	   //   (".*?")   < finds everything in the quotes. 
}
echo "</table>";
//SPARQLEngine::writeQueryResultAsHtmlTable($result); 
?>

 
 <footer id="footer" class="clearfix">
  <div class="wrapper">
    
    <section class="right social clear">
      <!-- Replace with any 32px x 32px icons -->
      <a href="https://plus.google.com/u/0/111044644508972712357/posts"><img class="icon" src="images/icons/google.png" alt=""></a> <a href="https://www.youtube.com/user/dudders666"><img class="icon" src="images/icons/youtube.png" alt=""></a> <a href="http://www.facebook.com/adamrconnah"><img class="icon" src="images/icons/facebook.png" alt=""></a> <a href="htpp://www.twitter.com/adamrconnah"><img class="icon" src="images/icons/twitter.png" alt=""></a>
      <!-- /icons -->
    </section>
    <!-- /section -->
    <section id="copyright" class="clearfix">
      <p class="left">Adam Connah<a href="#"></a> aoc9@aber.ac.uk</p>
      <p class="right">Website Template By <a target="_blank" href="http://www.birondesign.com/">Chris Biron</a> &amp; Modified By <a href="http://www.os-templates.com/">OS Templates</a></p>
    </section>
  </div>
</footer>

</body></html>