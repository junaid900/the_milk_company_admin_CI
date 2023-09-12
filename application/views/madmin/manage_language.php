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

                				<th><?php echo get_phrase('language'); ?></th>
                				
                				<th><?php echo get_phrase('action'); ?></th>
                            </tr>
                            </thead>
                            <tbody >
                               	<tr>
    
                    				<td>1</td>
                    
                    				<td>English</td>
                    				
                    				<td>													
                                         <a href="<?php echo base_url().admin_ctrl(); ?>/edit_language/english">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                    				   
                    				</td>
                    
                    			</tr>
                    			<tr>
                    
                    				<td>2</td>
                    
                    				<td>Chinese</td>
                    				
                    				<td>													
                                         <a href="<?php echo base_url().admin_ctrl(); ?>/edit_language/Chinese">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                    				   
                    				</td>
                    
                    
                    			</tr>

                             </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Body End-->
