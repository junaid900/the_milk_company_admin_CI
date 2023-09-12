 <?php 
    $cssScriptDir = base_url() . "assets/admin/";
   $system_image = $this->db->get_where('brinkman_system_settings',array('type'=>'system_image'))->row()->description; ?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="text-center">
                <?php if(!empty($system_image)){ ?>
                <img src="<?php echo base_url(); ?>uploads/admin/<?php echo $system_image; ?>" style="width: 60%;height: 64px;" alt="image">
                <?php }else{ ?>
                <img src="https://via.placeholder.com/70" width="100%" height="64px" alt="">
                <?php } ?>
            </li>
            <!--li class="<?=$page_name == "dashboard"?"active":"" ?>">
                <a href="<?=base_url().admin_ctrl(). '/dashboard' ?>"><img src="<?=base_url(); ?>assets/admin/img/user.png" class="mr_1" /> <span class="nav-label">Home</span></a>
            </li-->
           
           <li class="<?=$main_page_name == "manage_visitor" || $page_name == "view_vistor" || $page_name == "view_bartender" || $page_name == "view_baradmin"?"active":"" ?>"> 
                <a href="#" class="parent_item"><img src="<?=base_url(); ?>assets/admin/img/user.png" class="mr_1" /> <span class="nav-label">Users</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?=$page_name == "manage_visitor"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_visitor' ?>"><?=get_phrase("visitor")?></a></li>
                    <li class="<?=$page_name == "manage_bartender"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_bartender' ?>"><?=get_phrase("bartender")?></a></li>
                    <li class="<?=$page_name == "manage_baradmin"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_baradmin' ?>"><?=get_phrase("bar_admin")?></a></li>
                    <li class="<?=$page_name == "manage_wholesaler"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_wholesaler' ?>"><?=get_phrase("wholesaler")?></a></li>
                </ul>
            </li>
            <li class="<?=$main_page_name == "manage_products" || $main_page_name == "manage_category" || $main_page_name == "manage_documents" || $main_page_name == "manage_brands"?"active":"" ?>">
                <a href="#" class="parent_item"><img src="<?=base_url(); ?>assets/admin/img/products.png" class="mr_1" /> <span class="nav-label">Products</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?=$main_page_name == "manage_documents"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_documents' ?>"><?=get_phrase("documents")?></a></li>
                    <li class="<?=$main_page_name == "manage_brands"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_brands' ?>"><?=get_phrase("brands")?></a></li>
                    <li class="<?=$main_page_name == "manage_category"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_category' ?>"><?=get_phrase("products_category")?></a></li>
                    <li class="<?=$main_page_name == "manage_products"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_products' ?>"><?=get_phrase("products")?></a></li>
                </ul>
            </li>
            <li class="<?=$main_page_name == "manage_events_category" || $main_page_name == "manage_events"?"active":"" ?>">
                <a href="#" class="parent_item"><img src="<?=base_url(); ?>assets/admin/img/events.png" class="mr_1" /> <span class="nav-label">Events</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?=$main_page_name == "manage_events_category"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_events_category' ?>"><?=get_phrase("events_category")?></a></li>
                    <li class="<?=$main_page_name == "manage_events"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_events' ?>"><?=get_phrase("events")?></a></li>
                </ul>
            </li>
            
            <li class="<?=$main_page_name == "manage_pubs_category" || $main_page_name == "manage_pubs"?"active":"" ?>">
                <a href="#" class="parent_item"><img src="<?=base_url(); ?>assets/admin/img/pubs.png" class="mr_1" /> <span class="nav-label">Bars</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?=$main_page_name == "manage_pubs_category"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_pubs_category' ?>"><?=get_phrase("bars_category")?></a></li>
                    <li class="<?=$main_page_name == "manage_pubs"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_pubs' ?>"><?=get_phrase("bars")?></a></li>
                </ul>
            </li>
            
             <li class="<?=$main_page_name == "manage_job_category" || $main_page_name == "manage_job"?"active":"" ?>">
                <a href="#" class="parent_item"><img src="<?=base_url(); ?>assets/admin/img/job.png" class="mr_1" /> <span class="nav-label">Job</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?=$main_page_name == "manage_job_category"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_job_category' ?>"><?=get_phrase("job_category")?></a></li>
                    <li class="<?=$main_page_name == "manage_job"?"active":"" ?>"><a href="<?=base_url().admin_ctrl(). '/manage_job' ?>"><?=get_phrase("job")?></a></li>
                </ul>
            </li>
            <li class="<?=$page_name == "manage_language"?"active":"" ?>">
                <a href="<?=base_url().admin_ctrl(). '/language' ?>"><i class="fa fa-language"></i> <span class="nav-label">Languages</span></a>
            </li>
            <li class="<?=$page_name == "system_settings"?"active":"" ?>">
                <a href="<?=base_url().admin_ctrl(). '/system_settings' ?>"><img src="<?=base_url(); ?>assets/admin/img/settings.png" class="mr_1" /> <span class="nav-label"><?=get_phrase("settings")?></span></a>
            </li>
            
            <!--li class="<?=$page_name == "manage_users"?"active":"" ?>">
                <a href="<?=base_url().admin_ctrl(). '/customer_list' ?>"><i class="fa fa-user-o"></i> <span class="nav-label"><?=get_phrase('customers')?></span></a>
            </li>
           
            <li class="<?=$page_name == "manage_roles"?"active":"" ?>">
                <a href="<?=base_url().admin_ctrl(). '/manage_roles' ?>"><i class="fa fa-ravelry"></i> <span class="nav-label">Roles</span></a>
            </li-->
            
            
        </ul>

    </div>
</nav>
