<div class="panel import-options">
	 <ul class="breadcrumb">
    <li><a href="<?=$this->createUrl('/import');?>">Import</a> <span class="divider">/</span></li>
    <li class="active">Freshbooks API</li>
    </ul>
    
    <form class="form-horizontal" action="<?=$this->createUrl('/import/saveFreshbooks')?>" id="signin-form">
	    <div class="control-group">
		    <label>Enter your Freshbooks API key</label>
		    <input type="text" name="token" />
	    </div>
	    <div class="control-group">
		    <label>Enter your Freshbooks sub-domain</label>
		   <input type="text" name="domain" />
	    </div>
	    <div class="control-group">
		    <button type="submit" class="btn">Import Data</button>
	    </div>
    </form>
</div>
<script type="text/javascript">
	$(function(){
		new Views.ImportFreshbooks('<?=$this->createUrl('/dashboard')?>');
	})
</script>