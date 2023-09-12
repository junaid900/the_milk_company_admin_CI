
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
                        <label class=""><?= get_phrase("name") ?></label>
                        <div class="row col-md-12">
                            <input type="text"
                               placeholder="Tiki Lovers"
                               name="en_name"
                               value="<?php echo $edit_data['en_name'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                      
                    <div class="row input-container">
                        <label class=""><?= get_phrase("name") ?>(中文)</label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="提基"
                               name="ch_name"
                               value="<?php echo $edit_data['ch_name'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                       <label class=""><?= get_phrase("category") ?> </label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name = "pubs_category_id" >
                                    <option value = "" disabled selected>Please select Category</option>
                                    <?php foreach($category as $data){ ?>
                                    <option value="<?php echo $data['pubs_category_id']; ?>" <?php if($data['pubs_category_id'] == $edit_data['pubs_category_id']){ echo 'selected';}?>><?php echo $data['en_name']; ?> </option>
                                    <?php } ?>
                           </select>
                       </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("city") ?> &nbsp; &nbsp;</label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="SHANGHAI"
                               name="city"
                               value="<?php echo $edit_data['city'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("province") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="SHANGHAI"
                               name="province"
                               value="<?php echo $edit_data['province'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("district") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="XUHUI"
                               name="district"
                               value="<?php echo $edit_data['district'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("address") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="xxxxxxxxxxxx"
                               name="address"
                               value="<?php echo $edit_data['address'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("number") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="021-89561617"
                               name="number"
                               value="<?php echo $edit_data['number'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("website") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="Http://xxxxxxxxxx"
                               name="website_link"
                               value="<?php echo $edit_data['website_link'];?>"
                               class="form-control col-md-6" required>
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