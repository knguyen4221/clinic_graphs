<?php

function renderGraph($post){
	//Grabs data inputs and then checks the graph type
	//If it's a bar chart then it makes a bar chart object and so on so forth for other chart types
	//Ideally to add a new bar chart you would need to do three things
	// Add it to the front end for user input
	// Create the chart class that renders the html
	// 
	$response = array();
	$dataInputs = json_decode(stripslashes($post['data']), true);
	if($post['graph_type'] == "bar_chart"){
		include 'BarChart.php';
		$graph = new BarChart($post['gTitle'], $post['fontSize'], $post['width'], $post['height'], $post['email'], $dataInputs);
		echo $graph->constructGraph();
	}else if($post['graph_type'] == "histogram"){
		include 'Histogram.php';
		$graph = new Histogram($post['gTitle'], $post['fontSize'], $post['width'], $post['height'], $post['email'], $dataInputs);
		echo $graph->constructGraph();
	}

}


?>