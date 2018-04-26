<?php

include 'Graph.php';

class StackedBarChart extends Graph{

	private $graphTitle;
	private $fontSize;
	private $x_axis;
	private $grouping;

	function __construct($title, $fontsize, $width, $height, $email, $dataInputs) {
		parent::__construct($title, $fontsize, $width, $height, $email);
		$this->x_axis = $dataInputs[0];
		$this->grouping = $dataInputs[1];
	}

	protected function queryData(){
		include 'connectionInfo.php';
		$results = array();
		try{
			$conn = mssql_connect($host, $userName, $password);
			if($conn){
				mssql_select_db($dbName, $conn);
				$query = mssql_query('SELECT ' . $this->x_axis . ", ".$this->grouping.", COUNT(*) as counts FROM demographics GROUP BY " . $this->x_axis . ", " . $this->grouping . " ORDER BY " . $this->x_axis);
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
		$result = "<html><head><script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
		<script type='text/javascript'>google.charts.load('current', {'packages':['bar']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() { 
			var data = google.visualization.arrayToDataTable([['" . $this->x_axis . "'";

		$uniqueGroupings = $this->getUniqueGrouping();
		for($i = 0 ; $i < sizeof($uniqueGroupings)-1; ++$i){
			$result .= ",'".$uniqueGroupings[$i][$this->grouping]."'";
		}

		$counter = sizeof($uniqueGroupings)-1;
		$currentSet = "";
		for($i = 0; $i < sizeof($data)-1; ++$i){
			if($currentSet != $data[$i][$this->x_axis]){
				while($counter != sizeof($uniqueGroupings)-1){
					$result .= ",0";
					++$counter;
				}
				$result .= "],['" . $data[$i][$this->x_axis] . "'";
				$currentSet = $data[$i][$this->x_axis];
				$counter = 0;
			}
			while($data[$i][$this->grouping] != $uniqueGroupings[$counter][$this->grouping]){
				$result .= ",0";
				++$counter;
			}
			$result .= ",".$data[$i]['counts'];
			++$counter;
		}
		$result .= "]]);";
		$result .= "var options = {
			chart : {
				title: '". $this->graphTitle . "',}, 
				isStacked: true,
				width: ". $this->getWidth() . ",
				height: ". $this->getHeight() . ",
			};
		";
		$result .= "var chart = new google.charts.Bar(document.getElementById('stackedbarchart_material'));
		chart.draw(data, google.charts.Bar.convertOptions(options));}</script>
		</head>
		<body>
		<div id=\"stackedbarchart_material\" style='width: ".$this->width."px; height: ".$this->height."px;'>
		</div>
		</body>
		</html>";
		return $this->create_wp_page($result);
	}

	private function getUniqueGrouping(){
		include 'connectionInfo.php';
		try{
			$conn = mssql_connect($host, $userName, $password);
			if($conn){
				mssql_select_db($dbName, $conn);
				$query = mssql_query('SELECT DISTINCT(' . $this->grouping . ') FROM demographics');
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
}
?>
