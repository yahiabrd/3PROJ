<?php

$this->_t = '3PROJ - Stats';

?>

<p>Statistics</p>

<?php if(sizeof($stats) != 0 || sizeof($stats2) != 0 ) { ?>
	<div class="row">
	<div class="col">
		<div id="chartContainer" style="height: 300px; width: 100%;"></div>
	</div>
	<div class="col">
		<div id="chartContainer2" style="height: 300px; width: 100%;"></div>
	</div>
	</div>

	<br>
<?php } ?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Number</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Number of attacks</th>
      <td><?= $nbT; ?></td>
    </tr>
	<tr>
      <th scope="row">Number of today's attack</th>
      <td><?= $nbD; ?></td>
    </tr>
	<tr>
      <th scope="row">Attacks number of the month</th>
      <td><?= $nbM; ?></td>
    </tr>
	<tr>
      <th scope="row">Attacks number of the year</th>
      <td><?= $nbY; ?></td>
    </tr>
  </tbody>
</table>

<script>
//chart1
window.onload = function() {
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		title: {
			text: "Number Of Attacks suffered"
		},
		subtitles: [{
			text: "June 2020"
		}],
		data: [{
			type: "pie",
			yValueFormatString: "",
			indexLabel: "{label} ({y})",
			dataPoints: <?php echo json_encode($stats, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();

  //chart2
	var chart2 = new CanvasJS.Chart("chartContainer2", {
		animationEnabled: true,
		title: {
			text: "Number Of Attacks By Sections"
		},
		subtitles: [{
			text: "June 2020"
		}],
		data: [{
			type: "pie",
			yValueFormatString: "",
			indexLabel: "{label} ({y})",
			dataPoints: <?php echo json_encode($stats2, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart2.render();
}
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>