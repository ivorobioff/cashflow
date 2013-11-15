 <br/>
 <?php
 	$id = isset($id) ? $id : 'hchart';
 ?>
<div id="<?=$id?>"></div>
 <script>
$(function(){

	var data = <?=$chart_data?>;

	$("#<?=$id?>").highcharts({
		chart: {
			type: "<?=$type?>",
		},
		xAxis: {
			categories: data.categories,
			max: data.total_categories > 11 ? 11 : data.total_categories - 1,
		},

		series: data.data,

		scrollbar: {
	        enabled: data.total_categories <= 12 ? false : true
	    },

        title: {
			text: "<?=$title?>"
        }
	});
});
 </script>