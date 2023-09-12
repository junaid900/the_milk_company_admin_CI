<style>
	.bold_font {
		font-weight: bold;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card m-b-30">
			<h4 class="card-header mt-0"><i class="fa fa-file"></i> 
			    Excel Import 
			</h4> 
			<div class="card-body">
				 <form method="post" action="<?php echo base_url(); ?>admin/<?php echo $param1;  ?>/excel_import" enctype="multipart/form-data">
                   <p><label>Select Excel File</label>
                   <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
                   <br />
                   <input type="submit" name="import" value="Import" class="btn btn-info" />
                  </form>
		    </div>
        </div>
    </div>
</div> 