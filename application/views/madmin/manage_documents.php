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
         <div class="">
            <button class="btn btn-primary" onclick="location.href='<?=base_url()."".admin_ctrl()."/add_document"?>'"><i class="fa fa-plus"></i>&nbsp;<?= $page_title ?></button>
        </div>	
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
                                <th><?=get_phrase("picture")?></th>
                                <th><?=get_phrase("name")?></th>
                                <th><?=get_phrase("permission")?></th>
                                <th><?=get_phrase("status")?></th>
                                <th><?=get_phrase("last_time")?></th>
                                <th><?=get_phrase("actions")?></th>
                            </tr>
                            </thead>
                            <tbody class="row_position">
                            <?php
                            $i = 0;
                            if(!empty($table_data)){
                            foreach ($table_data as $data) {$i++; ?>
                                <tr class="gradeX row_<?php echo $data['status']; ?>"
                                    id="<?php echo $data['products_documents_id']; ?>">
                                    <td><?= $i ?></td>
                                    <td>
                                        <?php if(!empty($data['attachment'])){ ?>
                                        <img src="<?php echo base_url(); ?><?= $data['attachment'] ?> " alt="<?= $data['en_name'] ?>" />
                                        <?php } ?>
                                    </td>
                                    <td><?= $data['en_name'] ?></td>
                                    <td><?php 
                                            foreach(json_decode($data['permission']) as $per){
                                                echo $per.',';
                                            }
                                    ?></td>
                                    <td>
                                        <div class="table-toggle">
                                            <div class="toggle-btn1 <?php if ($data['status'] == 'Active') {
                                                echo 'active';
                                            } ?>">
                                                <input type="checkbox" class="cb-value"
                                                       value="<?php echo $data['products_documents_id']; ?>" <?php if ($data['status'] == 'Active') {
                                                    echo 'checked';
                                                } ?>/>
                                                <span class="round-btn"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $data['created_at'] ?></td>
                                    <td class="center">
                                        <a href="<?=base_url().admin_ctrl().'/edit_document/'.$data['products_documents_id']; ?>">
                                            <img src="<?=base_url(); ?>assets/admin/img/edit.png" class="mr_1" /> 
                                        </a>
                                        <a href="javascript:;"
                                           onclick="confirm_modal_action('<?php echo base_url() . admin_ctrl() ?>/<?= $page_name ?>/delete/<?php echo $data['products_documents_id']; ?>');">
                                           <img src="<?=base_url(); ?>assets/admin/img/bin.png" class="mr_1" /> 
                                        </a>
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