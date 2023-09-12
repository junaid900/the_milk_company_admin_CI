
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
                    &nbsp;>&nbsp;<a>Edit <?= $page_title ?></a>
                </li>
            </ol>
        </div>
        
    </div>
    
    
   
</div>
<div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
         <div class="col-sm-12 col-md-12 col-lg-12">
                <form role="form" method="post"
                                  action="<?= base_url() . admin_ctrl()."/" . $page_name . "/update/".$param1 ?>" enctype="multipart/form-data">
                              
                    <div class="row input-container">
                        <label class=""><?= get_phrase("en_name") ?></label>
                        <div class="row col-md-12">
                            <input type="text"
                               placeholder="liovr"
                               name="en_name"
                               value="<?php echo $edit_data['en_name'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    <div class="row input-container">
                        <label class=""><?= get_phrase("ch_name") ?></label>
                        <div class="row col-md-12">
                            <input type="text"
                               placeholder="liovr"
                               name="ch_name"
                               value="<?php echo $edit_data['ch_name'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    <div class="row input-container">
                        <label class=""><?= get_phrase("position") ?></label>
                        <div class="row col-md-12">
                            <input type="text"
                               placeholder="初级调酒师"
                               name="position"
                                value="<?php echo $edit_data['position'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("experience") ?> &nbsp; &nbsp;</label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="2年"
                               name="experience"
                                value="<?php echo $edit_data['experience'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("job_type") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="全职"
                               name="job_type"
                                value="<?php echo $edit_data['job_type'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                       <label class=""><?= get_phrase("pub") ?> &nbsp;&nbsp;</label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name = "pubs_id" >
                                    <option value = "" disabled selected>Please Select Pub</option>
                                    <?php foreach($pub as $data){ ?>
                                    <option value="<?php echo $data['pubs_id']; ?>" <?php if($data['pubs_id'] == $edit_data['pubs_id']){ echo 'selected'; } ?>><?php echo $data['en_name']; ?> </option>
                                    <?php } ?>
                           </select>
                       </div>
                    </div>
                    
                    <div class="row input-container">
                       <label class=""><?= get_phrase("job") ?> &nbsp;&nbsp;&nbsp;</label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name = "job_category_id" >
                                    <option value = "" disabled selected>Please Select Job</option>
                                    <?php foreach($category as $data){ ?>
                                    <option value="<?php echo $data['job_category_id']; ?>" <?php if($data['job_category_id'] == $edit_data['job_category_id']){ echo 'selected'; } ?>><?php echo $data['en_name']; ?> </option>
                                    <?php } ?>
                           </select>
                       </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("location") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="Chongqing"
                               name="location"
                                value="<?php echo $edit_data['location'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("deadline") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="2021/10/21"
                               name="deadline"
                                value="<?php echo $edit_data['deadline'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("salary_range") ?></label>
                        <div class="row col-md-12">
                        <input type="number"
                               placeholder="low"
                               name="salary_low"
                               value="<?php echo $edit_data['salary_low'];?>"
                               class="form-control col-md-3" required>
                        <input type="number"
                               placeholder="high"
                               name="salary_high"
                               value="<?php echo $edit_data['salary_high'];?>"
                               class="form-control col-md-3" required>
                        </div>
                    </div>
                    
                   <div class="row input-container">
                        <label class=""><?= get_phrase("details") ?></label>
                        <div class="col-md-12 lbs">
                            <textarea type="text"
                               placeholder="Text"
                               name="detail"
                               rows="3"
                               class="form-control summernote" required><?php echo $edit_data['detail'];?></textarea>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        
                        <div class="col-sm-2 pd_zero" >
                            <div class="upload-btn-img">
                                <?php if(!empty($edit_data['image'])){ ?>
                                <img src="<?php echo base_url(); ?><?php echo $edit_data['image']; ?>"
                                     class="img-thumbnail main_height p-0 m-0">
                                <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/rec_plus.png"
                                     class="img-thumbnail main_height p-0 m-0">
                                <?php } ?>
                                <input type="file" name="image" onchange="showThumbnail(this)" accept="image/*"/>
                            </div>
                            <label class="col-sm-12"><?= get_phrase("add_picture") ?></label>
                        </div>
                        
                    </div>
                    <div class="row input-container">
                        <label class="col-sm-1"><?= get_phrase("status") ?></label>

                       <div class="toggle-btn2 <?=$edit_data['status'] == 'Active'?'active':''?>">
                            <input type="checkbox" class="cb-value1" name="status" value="Active" <?=$edit_data['status'] == 'Active'?"checked":""?>/>
                            <span class="round-btn"></span>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-lg btn-primary m-l-md " type="submit">
                            <strong><?= get_phrase("update") ?></strong>
                        </button>
                    </div>
                </form>
            </div>
       
    </div>
</div>
<!--        Body End-->