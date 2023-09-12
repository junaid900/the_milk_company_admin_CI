<?php 
    $details = $this->db->get_where('order', array('order_id'=>$param1))->row_array(); 
    $decode_data = json_decode($details['data']);
    $events_array = $this->db->get_where('events',array('events_id'=>$details['events_id']))->row();
?>
<style>
	.bold_font {
		font-weight: bold;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card m-b-30">
			<h4 class="card-header mt-0"><i class="fa fa-eye"></i> 
			    <?php echo $events_array->en_main_title;?>
			    <span style="float: right;"><?php echo $details['payment_method']; ?>(<?php echo $details['payment_total']; ?>)</span>
			</h4> 
			<div class="card-body">
				<?php 
				foreach($decode_data as $data){
                ?>    
               
				<div class="form-group row">
					<label class="col-sm-4 bold_font col-form-label"><?php echo $data->title; ?></label>
					<div class="col-sm-8">
						<label class="col-form-label"><?php echo $data->value; ?></label>
					</div>
				</div>
				 <?php 
			    	}
				 ?>
				
				
            </div>
        </div>
    </div>
</div> 
