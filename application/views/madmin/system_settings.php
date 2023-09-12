
<div class="row wrapper border-bottom page-heading">
    <div>
        <h2 class="page-main-heading"><?= get_phrase($page_sub_title) ?></h2>
        <ol class="page_tree">
            <li class="breadcrumb-item">
                <a><?= $page_title ?></a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="alert alert-info" style="width:100%">
	  <strong><?php echo get_phrase('info!'); ?></strong> <?php echo get_phrase('this_page_allows_you_to_edit_system_information'); ?>
	</div>

   
    <form role="form" method="POST" action="<?php echo base_url().admin_ctrl(); ?>/system_settings/update"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                  <?php echo get_phrase('general_settings'); ?>
                </header>
                <div class="panel-body">
                       <div class="form-group">
                             <label for="name"><?php echo get_phrase('company_name'); ?>:</label>
                            <input type="text" name="system_name" class="form-control" placeholder="" value="<?php echo $system_data[0]->description; ?>">
                        </div>
                        <div class="form-group">
                            <label for="home_page_SEO_title"><?php echo get_phrase('home_page_SEO_title'); ?></label>
                            <input type="text" name="home-page-seo-title" class="form-control" placeholder="" value="<?php echo $system_data[16]->description; ?>">
                        </div>
                        <div class="form-group">
                            <label for="home_page_SEO_description"><?php echo get_phrase('home_page_SEO_description'); ?></label>
                            <input type="text"  name="home-page-seo-description" class="form-control" placeholder="" value="<?php echo $system_data[17]->description; ?>" >
                        </div>
                        <div class=" ">
                        	<b><?php echo get_phrase('contact_settings'); ?></b>
                        	<hr>
                        </div>
                        
                        <div class="form-group">
                            <label><?php echo get_phrase('email'); ?></label>
                            <input type="text"  name="email" class="form-control" placeholder="" value="<?php echo $system_data[1]->description; ?>"  required>
						</div>
                        
                        <div class="form-group">
                            <label><?php echo get_phrase('phone'); ?></label>
                            <input type="text"  name="phone" class="form-control" placeholder="" value="<?php echo $system_data[2]->description; ?>"required>
						</div>
                        
                        <div class="form-group">
                            <label><?php echo get_phrase('address'); ?></label>
                        	<textarea rows="5" cols="5" name="address" class="form-control" placeholder="Address" required><?php echo $system_data[4]->description; ?></textarea>
                        </div>
						<div class=" ">
						    <hr>
                        	<b>Privacy</b>
                        	<hr>
                        </div>
                        <div class="form-group">
                            <label><?php echo get_phrase('en_description'); ?></label>
                        	<textarea rows="5" cols="5" name="privacy_en_description" class="form-control" placeholder="description" required><?php echo $system_data[30]->description; ?></textarea>
                        </div>
                         <div class="form-group">
                            <label><?php echo get_phrase('ch_description'); ?></label>
                        	<textarea rows="5" cols="5" name="privacy_ch_description" class="form-control" placeholder="description" required><?php echo $system_data[31]->description; ?></textarea>
                        </div>
		            	<div class=" ">
		            	    <hr>
							<b><?php echo get_phrase('terms_and_conditions'); ?></b>
							<hr>
						</div>
						 <div class="form-group">
                            <label><?php echo get_phrase('en_description'); ?></label>
                        	<textarea rows="5" cols="5" name="terms_en_description" class="form-control" placeholder="description" required><?php echo $system_data[32]->description; ?></textarea>
                        </div>
                         <div class="form-group">
                            <label><?php echo get_phrase('ch_description'); ?></label>
                        	<textarea rows="5" cols="5" name="terms_ch_description" class="form-control" placeholder="description" required><?php echo $system_data[33]->description; ?></textarea>
                        </div>
                        <div class=" ">
						    <hr>
                        	<b>Social Links</b>
                        	<hr>
                        </div>
                        <div class="form-group">
                            <label><?php echo get_phrase('linkdin'); ?></label>
                            <input type="text"  name="linkdin" class="form-control" placeholder="" value="<?php echo $system_data[34]->description; ?>"  required>
						</div>
						<div class="form-group">
                            <label><?php echo get_phrase('wechat'); ?></label>
                            <input type="text"  name="wechat" class="form-control" placeholder="" value="<?php echo $system_data[35]->description; ?>"  required>
						</div>
						<div class="form-group">
                            <label><?php echo get_phrase('youtube'); ?></label>
                            <input type="text"  name="youtube" class="form-control" placeholder="" value="<?php echo $system_data[36]->description; ?>"  required>
						</div>
						<div class="form-group">
                            <label><?php echo get_phrase('tiktok'); ?></label>
                            <input type="text"  name="tiktok" class="form-control" placeholder="" value="<?php echo $system_data[37]->description; ?>"  required>
						</div>
						<div class="form-group">
                            <label><?php echo get_phrase('instagram'); ?></label>
                            <input type="text"  name="instagram" class="form-control" placeholder="" value="<?php echo $system_data[38]->description; ?>"  required>
						</div>
						<div class="form-group">
                            <label><?php echo get_phrase('twitter'); ?></label>
                            <input type="text"  name="twitter" class="form-control" placeholder="" value="<?php echo $system_data[39]->description; ?>"  required>
						</div>
						<div class="form-group">
                            <label><?php echo get_phrase('youku'); ?></label>
                            <input type="text"  name="youku" class="form-control" placeholder="" value="<?php echo $system_data[40]->description; ?>"  required>
						</div>
						 <button type="submit" class="btn btn-primary"><?php echo get_phrase('update_system'); ?></button>
                       
                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Profile Image
                </header>
                <div class="panel-body">
                    <center>
						<?php if(empty($system_data[5]->description)){ ?>
							<img src="<?php echo base_url(); ?>assets/admin/images/admin.png" style="width:200px;">
						<?php }else{ ?>
							<img src="<?php echo base_url(); ?>uploads/admin/<?php echo $system_data[5]->description; ?>" style="width:210px;">
						<?php } ?>
						<br/>
						<br/>
						<div class="input-group  col-md-10 col-md-offset-1">
							<span class="input-group-addon"><i class="fa fa-image"></i></span>
							<input type="file" name="system_image" class="form-control"/>
						</div>
					</center>
                </div>
            </section>
        </div>
    </div>
    </form>
    
</div>
