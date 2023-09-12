<div class="row wrapper page-heading">
    <div class="col-md-12">
        <div class="alert alert-info" style="width:100%">
    	  <h2><?= $page_title ?></h2>
    	  
    	  <p><?php echo get_phrase('through_our_brands_internationally_renowned_for_their_quality,_consistency,_and_most_importantly_their_uniqueness,_
we_work_with_on_and_off_trade_leaders_to_inspire_creativity_and_sophistication.'); ?></p>
            <br>
    	    <div class="row mb_min" role="group" aria-label="Basic example">
              <div class="trapezoid active"><span><?= $page_title ?></span></div>
            </div>
    	</div>
    	<div class="row col-md-12">
            <span class="page-main-heading"><?php echo $page_sub_title; ?></span>
            <ol class="page_tree">
                <li class="breadcrumb-item">
                    &nbsp;>&nbsp;<a><?= $page_title ?></a>
                </li>
            </ol>
        </div>
         <!--div class="">
            <button class="btn btn-primary" onclick="location.href='<?=base_url()."".admin_ctrl()."/add_category"?>'"><i class="fa fa-plus"></i>&nbsp;<?= $page_title ?></button>
        </div-->	
    </div>
    
    
   
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="">
                    <div class="table-responsive">
                        <table class="dataTables-example table-striped">
                            <thead>
                            <tr>
                                <th><?="No."?></th>
                                <th><?=get_phrase("weChat")?></th>
                                <th><?=get_phrase("phone")?></th>
                                <th><?=get_phrase("city")?></th>
                                <th><?=get_phrase("address")?></th>
                                <th><?=get_phrase("last_time")?></th>
                                <th><?=get_phrase("actions")?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            if(!empty($table_data)){
                            foreach ($table_data as $data) {$i++; ?>
                                <tr class="gradeX">
                                    <td><?= $i ?></td>
                                    <td><?= $data['wechat'] ?></td>
                                    <td><?= $data['phone'] ?></td>
                                    <td><?= $data['city'] ?></td>
                                    <td><?= $data['address'] ?></td>
                                    <td><?= $data['date_added'] ?></td>
                                    <td>
                                        <a href="<?php echo base_url().admin_ctrl(); ?>/view_vistor/<?= $data['visitor_id'] ?>"  class="btn btn-primary">View</a>
                                    </td>
                                </tr>
                            <?php } 
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--        Body End-->