n<?php $cssScriptDir = base_url() . "assets/admin/";?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link href="<?php echo $cssScriptDir; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $cssScriptDir; ?>font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="<?php echo $cssScriptDir; ?>css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <link href="<?php echo $cssScriptDir; ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo $cssScriptDir; ?>css/style.css" rel="stylesheet">
    <style>
        .ibox-title{
            background-color: #ffffff;
            border-color: #e7eaec;
            border-image: none;
            border-style: solid solid none;
            border-width: 2px 0 0; 
        }
        .ibox-content {
            background-color: #ffffff;
            color: inherit;
            padding: 15px 20px 20px 20px;
            border-color: #e7eaec;
            border-image: none;
            border-style: solid solid none;
            border-width: 1px 0;
        }
        .pr_color{
            color:#39b4eb;
            font-weight: 400;
        }
        .light_pr{
            color:#9ad8f5;
        }
        .ibx{
            border-top: none;
            border-right: 1px solid #949494;
        }
        .rpv{
            border-top: 1px solid #949494;
            border-bottom: 1px solid #949494;
            padding: 11px 0px;
        }
        .btnone{
            border-top:none;
        }
        ul.lst_st{
            list-style: decimal;
            margin-top: 0px;
        }
        .bg_st{
            background: #23b08b;
            color: #fff;
            height: 90%;
            font-weight:600;
        }
        .bg_st_1{
            position: absolute;
            bottom: 1em;
            left: 0;
            right: 0;
        }
         .bg_st_2{
             padding-top:85%;
         }   
    </style>
</head>

<body>
    <div id="wrapper">
   <?php $this->load->view(strtolower($this->session->userdata('directory')).'/theme/sidebar');?>

        <div id="page-wrapper" class="gray-bg">
        <?php $this->load->view(strtolower($this->session->userdata('directory')).'/theme/topbar');?>
    
        <div class="wrapper wrapper-content">
        
        </div>


        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo $cssScriptDir; ?>js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/popper.min.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/bootstrap.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="<?php echo $cssScriptDir; ?>js/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/flot/curvedLines.js"></script>

    <!-- Peity -->
    <script src="<?php echo $cssScriptDir; ?>js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $cssScriptDir; ?>js/inspinia.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?php echo $cssScriptDir; ?>js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="<?php echo $cssScriptDir; ?>js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?php echo $cssScriptDir; ?>js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Sparkline -->
    <script src="<?php echo $cssScriptDir; ?>js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="<?php echo $cssScriptDir; ?>js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="<?php echo $cssScriptDir; ?>js/plugins/chartJs/Chart.min.js"></script>
	<?php $this->load->view('modal'); ?>
   
     <script>
        function changeLanguage(lang) {
            $.ajax({
                url:"<?php echo base_url().admin_ctrl(); ?>/change_language",
                type:'post',
                data:{lang:lang},
                success:function(response){
                    console.log(response)
                   location.reload();
                }
            })
        }
    </script>
</body>
</html>
