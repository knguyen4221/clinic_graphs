<?php
/*
Template Name: UIPage
*/

	get_header();
?>

	<div class="site-content">
	    <div class="grid-container">
	        <div id="graph_inputs" class="inputs">
	            <header class="sub_header">
	                Chart Options
	            </header>
	            <div class="input">
	                <div class="label">
	                    Chart Type
	                </div>
	            <select id="graph_type">
	            	<option value="" selected disabled hidden> --- </option>
	                <option value="bar_chart">Bar Charts (1 Categorical Variable)</option>
	                <option value="histogram">Histogram (1 Continuous Variable)</option>
	                <option value="stacked_bar_chart">Stacked Bar Chart (2 Categorical Variables)</option>
	            </select>
	            </div>
	            <div class="input">
	                <div class="label">Title</div>
	                    <input type="text" id="title">
	            </div>
	            <div class="input">
	                <div class="label">Font Size</div>
	                    <input type="text" id="fontSize">
	            </div>
	            <div class="input">
	                <div class="label">Height (in px)</div>
	                    <input type="text" id="height">
	            </div>
	            <div class="input">
	                <div class="label">Width (in px)</div>
	                    <input type="text" id="width">
	            </div>
	            <div class="input">
	            	<div class="label">Email</div>
	            	<input type="text" id="email">
	            </div>
	        </div>


	        <div class="inputs">
	            <header class="sub_header">Data</header>
	            <div id= "data_inputs" class="input">
	            	<div class="variable" id="x-axis" hidden>
	                	<div class="label">
	                	   	X-axis
	                	</div>
	                	<select class="categorical_var" hidden>
	                	    <option value="adgroup">Group</option>
	                	    <option value="PatientStatusID">PatientStatusID</option>
	                	    <option value="PatientTypeID">PatientTypeID</option>
	                	    <option value="Sex">Sex</option>
	                	    <option value="Hisp">Hispanic</option>
	                	    <option value="Race">Race</option>
	                	    <option value="Ethnicity">Ethnicity</option>
	                	    <option value="Handedness">Handedness</option>
	                	    <option value="FirstLanguage">First Language</option>
	                	    <option value="PrimaryLanguage">Primary Language</option>
	                	    <option value="MartialStatus">Marital Status</option>
	                	</select>
	                	<select class="numerical_var" hidden>
	                		<option value="EduYears">Years of Education</option>
	                	</select>
					</div>
					<div class="variable" id="y-axis" hidden>
						<div class="label">Y-axis or Grouping</div>
	                	<select class="categorical_var" id="categorical_var2" hidden>
	                	    <option value="adgroup">Group</option>
	                	    <option value="PatientStatusID">PatientStatusID</option>
	                	    <option value="PatientTypeID">PatientTypeID</option>
	                	    <option value="Sex">Sex</option>
	                	    <option value="Hisp">Hispanic</option>
	                	    <option value="Race">Race</option>
	                	    <option value="Ethnicity">Ethnicity</option>
	                	    <option value="Handedness">Handedness</option>
	                	    <option value="FirstLanguage">First Language</option>
	                	    <option value="PrimaryLanguage">Primary Language</option>
	                	    <option value="MartialStatus">Marital Status</option>
	                	</select>
	                	<select class="numerical_var" id="numerical_var2" hidden>
	                		<option value="EduYears">Years of Education</option>
	                	</select>
					</div>
	            </div>
	        </div>
	    </div>

	    <input id="generate" type="button" value="Generate Graph" />
	    
	    <div id="results">
	    	<div id="hash"></div>
	    	<div id="permalink"></div>
	    </div>
	</div>
<footer>
<?php
	get_footer();
?>
</footer>
</html>
