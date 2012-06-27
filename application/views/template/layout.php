<!DOCTYPE html>
<html lang="en">	
    <head>		
        <meta charset="utf-8"/>
        <title><?php echo $title ?></title>
        <link href="/css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }
        </style>
        <link href="/css/bootstrap-responsive.css" rel="stylesheet">

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?php echo $include_header; ?>
    </head>

    <body screen_capture_injected="true">	

        <?php
        //include header partial
        include_partial("template/header");
        ?>
        <div class="container-fluid">
            <div class="row-fluid">

                <?php
                //include content
                include($content_page);
                ?>
                <?php
                //include footer partial
                include_partial("template/footer");
                ?>
            </div>
        </div>


        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
    </body>	
</html>
