<?php
 //could probably be written for an inheritance hierarchy *shrug* so that create_wp_post and create_wp_page are inherited

include 'Graph.php';

class BarChart extends Graph{
	private $graphTitle;
	private $fontSize;
	private $x_axis;

	function __construct($title, $fontsize, $width, $height, $email, $dataInputs) {
		parent::__construct($title, $fontsize, $width, $height, $email);
		$this->x_axis = $dataInputs[0];

	}

	protected function queryData(){
		include 'connectionInfo.php';
		$results = array();
		try{
			$conn = mssql_connect($host, $userName, $password);
			if($conn){
				mssql_select_db($dbName, $conn);
				$query = mssql_query('SELECT ' . $this->x_axis . ", COUNT(*) as counts FROM demographics GROUP BY " . $this->x_axis);
				while($results[] = mssql_fetch_array($query)){}
				return $results;
			}else{
				return "Connection to DB failed";
			}
		}catch(Exception $e){
			return "fail";
		}finally{
			mssql_free_result($query);
			mssql_close($conn);
		}
	}

	protected function createGraph($data){
		//Generate html stuff
		//This is the only thing that changes in between graphs
		$result = "<html><head><script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
		<script type='text/javascript'>google.charts.load('current', {'packages':['bar']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() { 
			var data = google.visualization.arrayToDataTable([['".$this->x_axis."', 'count']";
		for($i = 0; $i < sizeof($data)-1; $i++)
		{
			$result .= ",['".$data[$i][$this->x_axis]."',".$data[$i]['counts']."]";
		}

		$result .= "]);";
		$result .= "var options = {
			chart : {
				title: '". $this->graphTitle . "',}, 
				bars: 'horizontal',
				axes: { 
					x : {label: 'counts'}
				},
				legend: {position : 'none'},
			};
		";
		$result .= "var chart = new google.charts.Bar(document.getElementById('barchart_material'));
		chart.draw(data, google.charts.Bar.convertOptions(options));}</script>
		</head>
		<body>
		<div id=\"barchart_material\" style='width: ".$this->width."px; height: ".$this->height."px;'>
		</div>
		</body>
		</html>";
		return $this->create_wp_page($result);
	}

}
?>