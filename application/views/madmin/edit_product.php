<?php include 'theme/onpagecss.php'; ?>
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
                       <label class=""><?= get_phrase("brands") ?> </label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name = "products_brands_id" >
                                    <option value = "" disabled selected>Please select Brand</option>
                                    <?php foreach($brands as $data){ ?>
                                    <option value="<?php echo $data['products_brands_id']; ?>" <?php if($data['products_brands_id'] == $edit_data['products_brands_id']){ echo 'selected';}?>><?php echo $data['en_name']; ?> </option>
                                    <?php } ?>
                           </select>
                       </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("origin") ?>(EN)</label>
                        <div class="row col-md-12">
                            <input type="text"
                               placeholder="Mexico"
                               name="en_origin"
                                value="<?php echo $edit_data['en_origin'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                      
                    <div class="row input-container">
                        <label class=""><?= get_phrase("origin") ?>(中文)</label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="墨西哥"
                               name="ch_origin"
                                value="<?php echo $edit_data['ch_origin'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    <div class="row input-container">
                        <label class=""><?= get_phrase("details") ?>(EN)</label>
                        <div class="col-md-12 lbs">
                        <textarea type="text"
                               placeholder="Text"
                               name="en_details"
                               rows="3"
                               class="form-control summernote" required><?php echo $edit_data['en_details'];?></textarea>
                        </div>
                    </div>
                   <div class="row input-container">
                        <label class=""><?= get_phrase("details") ?>(中文)</label>
                        <div class="col-md-12 lbs">
                        <textarea type="text"
                               placeholder="Text"
                                rows="3"
                               name="ch_details"
                               class="form-control summernote" required><?php echo $edit_data['ch_details'];?></textarea>
                        </div>
                    </div> 
                      
                  
                     <div class="row input-container">
                       <label class=""><?= get_phrase("category") ?> </label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name = "products_category_id" >
                                    <option value = "" disabled selected>Please select Category</option>
                                    <?php foreach($category as $data){ ?>
                                    <option value="<?php echo $data['products_category_id']; ?>" <?php if($data['products_category_id'] == $edit_data['products_category_id']){ echo 'selected';}?>><?php echo $data['en_name']; ?> </option>
                                    <?php } ?>
                           </select>
                       </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class="">ABV &nbsp;&nbsp;</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="40%"
                               name="ABV"
                                value="<?php echo $edit_data['ABV'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    
                    <div class="row input-container">
                        <label class="">Volume</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="700ml"
                               name="volume"
                                value="<?php echo $edit_data['volume'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <!--div class="row input-container">
                        <label class="">Retail Price</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="300.00"
                               name="retail_price"
                                value="<?php echo $edit_data['retail_price'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class="">Trade Price</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="200.00"
                               name="trade_price"
                                value="<?php echo $edit_data['trade_price'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class="">Wholesaler Price</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="100.00"
                               name="wholesaler_price"
                                value="<?php echo $edit_data['wholesaler_price'];?>"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class="">Special Price</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="XX.00"
                               name="special_price"
                                value="<?php echo $edit_data['special_price'];?>"
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
                        
                    </div-->
                    <div class="row input-container" id="tier_content">
                       <?php foreach(json_decode($edit_data['tier_price']) as $key=>$price){  $key++; ?>
                         <div class="col-sm-6 row tier_price" id="div_<?php echo $key; ?>"  style="margin-bottom: 1em;">
                            <label class="col-sm-12 lbs">Tier Price <?php echo $key; ?></label>
                            <input type="number"  name="tier_prices[]" class="form-control col-sm-9" value="<?php echo $price; ?>" required>
                            <button  type="button" class="btn btn-success"  onclick="clone_tierPrice()"><i class="fa fa-plus"></i></button>
                            <button  type="button" class="btn btn-danger" onclick="remove_tierPrice(<?php echo $key; ?>)"><i class="fa fa-minus"></i></button>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <div class="row input-container">
                        
                        <div class="col-sm-2 pd_zero" >
                            <b><?php if(!empty($edit_data['document'])){ echo substr($edit_data['document'], strrpos($edit_data['document'], '/') + 1); } ?></b>
                            <input type="file" name="document" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf"/>
                            <label class="col-sm-12 lbs"><b><?= get_phrase("upload_document") ?></b></label>
                        </div>
                        
                    </div>
                    
                    <div class="row input-container text-left" id="multi_img">
                        <button type="button" onclick="addClientGrid()" class="btn btn-primary">Add Image</button>
                       
                    </div>
                    <div class="row input-container image_grid" id="image_grid">
                        <?php 
                        
                            foreach(json_decode($edit_data['image']) as $key=>$img){
                               
                        ?>
                        <input type='hidden' name='image_array[]' id='<?php echo $key; ?>' value='<?php echo $img; ?>'>
                         <div class="col-sm-2 pd_zero tot_grid" id="rem_<?php echo $key; ?>" >
                                <i class="fa fa-remove" onclick="deleteClientImage(<?php echo $key; ?>)" style="background-color:red;color:#fff;padding: 2px;position: absolute;cursor:pointer"></i>
                                <img src="<?php echo base_url().$img; ?>" class="img-thumbnail main_height " id="displayImg_<?php echo $key; ?>">
                                <!--onchange="encodeImgtoBase64(this,<?php echo $key; ?>,'')"-->
                                <input type="file" class="form-control" onchange="encodeImgtoBase64(this,<?php echo $key; ?>,0)" id="rm_input_<?php echo $key; ?>"  />
                                <div class="loading topl" id="loader_<?php echo $key; ?>" style="display:none"></div>
                        </div>
                        <?php } ?>
                       
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