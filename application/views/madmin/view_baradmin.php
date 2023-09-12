
<div class="row wrapper page-heading">
    <div class="col-md-12">
        <div class="alert alert-info" style="width:100%">
    	  <h2><?= $page_title ?></h2>
    	  
    	  <p><?php echo get_phrase('through_our_brands_internationally_renowned_for_their_quality,_consistency,_and_most_importantly_their_uniqueness,_
we_work_with_on_and_off_trade_leaders_to_inspire_creativity_and_sophistication.'); ?></p>
            <br>
    	    <div class="row mb_min" role="group" aria-label="Basic example">
              <div class="trapezoid <?php if(empty($param2)){ echo 'active'; } ?>" onclick="location.href='<?php echo base_url().admin_ctrl(); ?>/<?= $page_name ?>/<?php echo $param1; ?>'"><span><?= $page_title ?></span></div>
              <div class="trapezoid <?php if(!empty($param2) && $param2=='saved_pubs'){ echo 'active'; } ?>" onclick="location.href='<?php echo base_url().admin_ctrl(); ?>/<?= $page_name ?>/<?php echo $param1; ?>/saved_pubs'"><span ><?php echo get_phrase('saved_bars'); ?></span></div>
              <div class="trapezoid <?php if(!empty($param2) && $param2=='saved_events'){ echo 'active'; } ?>" onclick="location.href='<?php echo base_url().admin_ctrl(); ?>/<?= $page_name ?>/<?php echo $param1; ?>/saved_events'"><span ><?php echo get_phrase('saved_events'); ?></span></div>
              <div class="trapezoid <?php if(!empty($param2) && $param2=='saved_jobs'){ echo 'active'; } ?>" onclick="location.href='<?php echo base_url().admin_ctrl(); ?>/<?= $page_name ?>/<?php echo $param1; ?>/saved_jobs'"><span ><?php echo get_phrase('saved_jobs'); ?></span></div>
            </div>
    	</div>
    	<div class="row col-md-12">
            <span class="page-main-heading"><?php echo $page_sub_title; ?></span>
            <ol class="page_tree">
                <li class="breadcrumb-item">
                    &nbsp;>&nbsp;<?= $page_title ?>&nbsp;>&nbsp;<a>
                         <?php 
                            if(empty($param2)){
                                 echo 'Edit '.$page_title;
                            }else if(!empty($param2) && $param2=='saved_pubs'){
                                echo get_phrase('view_saved_bars');
                            }else if(!empty($param2) && $param2=='saved_events'){
                                echo get_phrase('view_saved_events');
                            }else if(!empty($param2) && $param2=='saved_jobs'){
                                echo get_phrase('view_saved_jobs');
                            }
                           
                         ?>
                    </a>
                </li>
            </ol>
        </div>
        
    </div>
    
    
   
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <?php if(empty($param2)){ ?>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <form role="form" method="post"
                                  action="<?= base_url() . admin_ctrl()."/" . $page_name . "/update/".$param1 ?>" enctype="multipart/form-data">
               <div class="row input-container">
                    <label class=""><?= get_phrase("first_name") ?></label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="Tian"
                           name="first_name"
                           value="<?php echo $edit_data['first_name'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>
               
                <div class="row input-container">
                    <label class=""><?= get_phrase("last_name") ?></label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="Tian"
                           name="last_name"
                           value="<?php echo $edit_data['last_name'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>
                
                <div class="row input-container">
                    <label class=""><?= get_phrase("other_name") ?></label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="Tian"
                           name="other_name"
                           value="<?php echo $edit_data['other_name'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>
                
                <div class="row input-container">
                    <label class=""><?= get_phrase("wechat") ?></label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="没有一条鱼的时候"
                           name="wechat"
                           value="<?php echo $edit_data['wechat'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>
                  
                <div class="row input-container">
                    <label class=""><?= get_phrase("company") ?></label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="Bar Sunflower"
                           name="company"
                           value="<?php echo $edit_data['company'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>  
                        
                <div class="row input-container">
                    <label class=""><?= get_phrase("contact_number") ?></label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="15601784302"
                           name="contact_number"
                           value="<?php echo $edit_data['contact_number'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>
                
                <div class="row input-container">
                    <label class=""><?= get_phrase("date_of_birth") ?></label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="1995/4/15"
                           name="date_of_birth"
                           value="<?php echo $edit_data['date_of_birth'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>
                
                <div class="row input-container">
                    <label class=""><?= get_phrase("Gender") ?></label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="1995/4/15"
                           name="gender"
                           value="<?php echo $edit_data['gender'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>
                
                
                <div class="row input-container">
                    <label class=""><?= get_phrase("city") ?>&nbsp;&nbsp;&nbsp;</label>
                    <div class="row col-md-12">
                        <input type="text"
                           placeholder="shanghai"
                           name="city"
                           value="<?php echo $edit_data['city'];?>"
                           class="form-control col-md-6" required>
                    </div>
                </div>
               
               
                <div class="row input-container">
                    <label class=""><?= get_phrase("en_introduction") ?></label>
                    <div class="row col-md-12">
                        <textarea type="text"
                           placeholder="text"
                           name="en_introduction"
                           class="form-control col-md-12" required><?php echo $edit_data['en_introduction'];?></textarea>
                    </div>
                </div>
                
                <div class="row input-container">
                    <label class=""><?= get_phrase("ch_introduction") ?></label>
                    <div class="row col-md-12">
                        <textarea type="text"
                           placeholder="Text"
                           name="ch_introduction"
                           class="form-control col-md-12" required><?php echo $edit_data['ch_introduction'];?></textarea>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn btn-lg btn-primary m-l-md " type="submit">
                        <strong><?= get_phrase("save") ?></strong>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
    <!-- pubs start--->
     <?php if(!empty($param2) && $param2=='saved_pubs'){ ?>
    <?php $this->load->view(strtolower($this->session->userdata('directory')).'/saved_pubs');?>
    <?php } ?>
    <!-- pubs start--->
    <!-- events start--->
    <?php if(!empty($param2) && $param2=='saved_events'){ ?>
     <?php $this->load->view(strtolower($this->session->userdata('directory')).'/saved_events');?>
    <?php } ?>
    <!-- events end--->
    <!-- jobs start--->
    <?php if(!empty($param2) && $param2=='saved_jobs'){ ?>
     <?php $this->load->view(strtolower($this->session->userdata('directory')).'/saved_jobs');?>
    <?php } ?>
    <!-- jobs end--->
</div>