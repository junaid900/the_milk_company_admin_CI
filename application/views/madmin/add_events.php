
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
                       <label class=""><?= get_phrase("category") ?> &nbsp;&nbsp;&nbsp;</label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name="events_category_id" >
                                    <option value = "" disabled selected>Please Select Category</option>
                                    <?php foreach($category as $data){ ?>
                                    <option value="<?php echo $data['events_category_id']; ?>"><?php echo $data['en_name']; ?> </option>
                                    <?php } ?>
                           </select>
                       </div>
                    </div>
                    
                    <div class="row input-container">
                       <label class=""><?= get_phrase("days") ?> &nbsp;&nbsp;&nbsp;</label>
                       <div class="row col-md-12">
                           <select class = "multipleSelect2 form-control col-sm-6" multiple name="days" >
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                           </select>
                       </div>
                    </div>
                    
                    <div class="row input-container">
                        
                        <div class="col-md-6 lbs">
                            <label class=""><?= get_phrase("start_date") ?> &nbsp; &nbsp;</label>
                            <input type="text"
                               placeholder="DD/MM/YYYY"
                               name="start_date"
                               class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class=""><?= get_phrase("end_date") ?> &nbsp; &nbsp;</label>
                            <input type="text"
                               placeholder="DD/MM/YYYY"
                               name="end_date"
                               class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        
                        <div class="col-md-6 lbs">
                            <label class=""><?= get_phrase("start_time") ?> &nbsp; &nbsp;</label>
                            <input type="text"
                                placeholder="00:00 PM"
                               name="start_time"
                               class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class=""><?= get_phrase("end_time") ?> &nbsp; &nbsp;</label>
                            <input type="text"
                                placeholder="00:00 PM"
                               name="end_time"
                               class="form-control" required>
                        </div>
                    </div>
                      
                    
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
                        <label class=""><?= get_phrase("city") ?> &nbsp; &nbsp;</label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="SHANGHAI"
                               name="city"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                        <label class=""><?= get_phrase("district") ?></label>
                        <div class="row col-md-12">
                        <input type="text"
                               placeholder="XUHUI"
                               name="district"
                               class="form-control col-md-6" required>
                        </div>
                    </div>
                    
                    <div class="row input-container">
                       <label class=""><?= get_phrase("pubs") ?> &nbsp;&nbsp;&nbsp;</label>
                       <div class="row col-md-12">
                           <select class = "form-control col-sm-6" name="pubs_id" >
                                    <option value = "" disabled selected>Please Select Pub</option>
                                    <?php foreach($pubs as $data){ ?>
                                    <option value="<?php echo $data['pubs_id']; ?>"><?php echo $data['en_name']; ?> </option>
                                    <?php } ?>
                           </select>
                       </div>
                    </div>
                    
                     <div class="row input-container">
                        <label class=""><?= get_phrase("details") ?></label><br>
                        <div class="col-md-12 lbs">
                            <textarea type="text"
                               placeholder="Text"
                               name="en_details"
                               rows="6"
                               class="form-control summernote " required></textarea> 
                        </div>
                       
                    </div>
                    
                     <div class="row input-container">
                        <label class=""><?= get_phrase("details") ?>(中文)</label>
                        <div class="col-md-12 lbs">
                         <textarea type="text"
                               placeholder="Text"
                               name="ch_details"
                               rows="6"
                               class="form-control summernote" required></textarea>
                        </div>
                    </div>
                    
                     <div class="row input-container">
                        
                        <div class="col-sm-2 pd_zero" >
                            <div class="upload-btn-img">
                                <img src="<?php echo base_url(); ?>assets/rec_plus.png"
                                     class="img-thumbnail main_height p-0 m-0">
                                <input type="file" name="image" onchange="showThumbnail(this)" accept="image/*"/>
                            </div>
                            <label class="col-sm-12"><?= get_phrase("add_picture") ?></label>
                        </div>
                        
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