<?php
$params = $this->getParams();
?>
<form action="<?=$this->createUrl('/params/updateDate')?>" id="date-range-filter">
<table>
		<tr>
			<td style="vertical-align: middle;">Date Range:&nbsp;&nbsp;&nbsp;</td>
			<td>
			    <div class="input-append date" id="date_from">
			   		 <input  value="<?=date('m/Y', strtotime($params['date_from']))?>" name="date_from" type="text" class="span2" readonly="true" /><span class="add-on"><i class="icon-th"></i></span>
			    </div>

			</td>
			<td>&nbsp;&nbsp;- to -&nbsp;&nbsp;</td>
			<td>
				 <div class="input-append date" id="date_to">
			   		 <input  value="<?=date('m/Y', strtotime($params['date_to']))?>" name="date_to" type="text" class="span2" readonly="true" /><span class="add-on"><i class="icon-th"></i></span>
			    </div>
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;End date needs to be some date in the future for the forecast&nbsp;&nbsp;&nbsp;&nbsp;

			<button class="btn btn-primary" type="submit">Update</button>
			</td>
		</tr>
	</table>
</form>
<script>
$(function(){
	new Views.DateRangeFilter({
		date_from_min: "<?=date('m/Y', strtotime($this->getBoundFrom()))?>",
		date_from_max: "<?=date('m/Y', strtotime(date('Y-m-d 00:00:00').' -1 month'))?>",
		date_to_min: "<?=date('m/Y')?>",
		date_to_max: "<?=date('m/Y', strtotime($this->getBoundTo()))?>",
	});
});
</script>