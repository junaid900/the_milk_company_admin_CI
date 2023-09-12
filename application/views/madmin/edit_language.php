<div class="row wrapper page-heading">
    <div class="col-md-12">
        <div class="alert alert-info" style="width:100%">
    	  <h2><?= $page_title ?></h2>
    	  
    	  <p><?php echo get_phrase('through_our_brands_internationally_renowned_for_their_quality,_consistency,_and_most_importantly_their_uniqueness,_
we_work_with_on_and_off_trade_leaders_to_inspire_creativity_and_sophistication.'); ?></p>
            <br>
    	    <div class="row mb_min" role="group" aria-label="Basic example">
              <div class="trapezoid active"><span style="font-size: 11px;"><?= $page_title ?></span></div>
            </div>
    	</div>
    	<div class="row col-md-12">
            <span class="page-main-heading" ><?php echo $page_sub_title; ?></span>
            <ol class="page_tree">
                <li class="breadcrumb-item">
                    &nbsp;>&nbsp;<a><?= $page_title ?></a>
                </li>
            </ol>
        </div>
    </div>
</div>
<!--Body -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="">
                    <div class="table-responsive">
                        <table class="dataTables-example table-striped">
                            <thead>
                            <tr>
                              	<th>#</th>
    				
                				<th><?php echo get_phrase('translation'); ?></th>
                
                				<th><?php echo get_phrase('phrase'); ?></th>
                				
                				
                				<th><?php echo get_phrase('action'); ?></th>
                            </tr>
                            </thead>
                              <tbody>

                    				<?php $lang = $this->db->get('brinkman_language')->result_array(); ?>
                    				<?php $count= 1; foreach($lang as $l){ ?>
                    				<tr>
                    
                    					<td><?php echo $count++; ?></td>
                    
                    					<td><input id="phrase_<?php echo $l['phrase_id']; ?>" class="form-control" value="<?php echo $l[$param1]; ?>" ></td>
                    					
                    					<td>													
                                    		<button class="btn btn-success" onclick="save_language(<?php echo $l['phrase_id']; ?>,'<?php echo $param1; ?>')"><?php echo get_phrase('save'); ?></button>
                                    	</td>
                    					<td><?php echo $l['phrase']; ?></td>
                    				</tr>
                    				<?php } ?>
                    
                    			 </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Body End-->