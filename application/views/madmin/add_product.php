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
                    &nbsp;>&nbsp;<a>Add <?= $page_title ?></a>
                </li>
            </ol>
        </div>
        
    </div>
    
    
   
</div>
<div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
         <div class="col-sm-12 col-md-12 col-lg-12">
                <form role="form" method="post"
                      action="<?= base_url() . admin_ctrl() . "/" . $page_name . "/save" ?>"
                      enctype="multipart/form-data">
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("name") ?></label>
                        <div class="row col-md-12">
                            <input type="text"
                               placeholder="Tiki Lovers"
                               name="en_name"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                      
                    <div class="row input-container">
                        <label class=""><?= get_phrase("name") ?>(中文)</label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="提基"
                               name="ch_name"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                       <label class=""><?= get_phrase("brands") ?> </label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name = "products_brands_id" >
                                    <option value = "" disabled selected>Please select Brand</option>
                                    <?php foreach($brands as $data){ ?>
                                    <option value="<?php echo $data['products_brands_id']; ?>"><?php echo $data['en_name']; ?> </option>
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
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                      
                    <div class="row input-container">
                        <label class=""><?= get_phrase("origin") ?>(中文)</label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="墨西哥"
                               name="ch_origin"
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
                               class="form-control summernote" required></textarea>
                        </div>
                    </div>
                    
                      
                    <div class="row input-container">
                        <label class=""><?= get_phrase("details") ?>(中文)</label>
                        <div class="col-md-12 lbs">
                        <textarea type="text"
                               placeholder="Text"
                                rows="3"
                               name="ch_details"
                               class="form-control summernote" required></textarea>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                       <label class=""><?= get_phrase("category") ?> </label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name = "products_category_id" >
                                    <option value = "" disabled selected>Please select Category</option>
                                    <?php foreach($category as $data){ ?>
                                    <option value="<?php echo $data['products_category_id']; ?>"><?php echo $data['en_name']; ?> </option>
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
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    
                    <div class="row input-container">
                        <label class="">Volume</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="700ml"
                               name="volume"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <!--div class="row input-container">
                        <label class="">Retail Price</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="300.00"
                               name="retail_price"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class="">Trade Price</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="200.00"
                               name="trade_price"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class="">Wholesaler Price</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="100.00"
                               name="wholesaler_price"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class="">Special Price</label>
                        <div class="row col-md-12">
                            <input type="number"
                               placeholder="XX.00"
                               name="special_price"
                               class="form-control col-md-6" required>
                        </div>
                    </div--->
                    <div class="row input-container" id="tier_content">
                       
                    </div>
                    <!--div class="row input-container">
                        
                        <div class="col-sm-2 pd_zero" >
                            <div class="upload-btn-img">
                                <img src="<?php echo base_url(); ?>assets/rec_plus.png"
                                     class="img-thumbnail main_height p-0 m-0">
                                <input type="file" name="image" onchange="showThumbnail(this)" accept="image/*"/>
                            </div>
                            <label class="col-sm-12"><?= get_phrase("add_picture") ?></label>
                        </div>
                        
                    </div-->
                     <div class="row input-container">
                        
                        <div class="col-sm-2 pd_zero" >
                            <input type="file" name="document" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf"/>
                            <label class="col-sm-12 lbs"><b><?= get_phrase("upload_document") ?></b></label>
                        </div>
                        
                    </div>
                    
                    <div class="row input-container text-left" id="multi_img">
                        <button type="button" onclick="addClientGrid()" class="btn btn-primary">Add Image</button>
                       
                    </div>
                    <div class="row input-container image_grid" id="image_grid">
                       
                    </div>
                   
                    <div class="row input-container">
                        <label class="col-sm-1"><?= get_phrase("status") ?></label>

                        <div class="toggle-btn2 active">
                            <input type="checkbox" class="cb-value1" name="status" value="Active" checked/>
                            <span class="round-btn"></span>
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
</div>
<!--        Body End-->