<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>JRESTPad <?php if (isset($page_title)) echo "| " . $page_title ?></title>

        <!-- Core CSS - Include with every page -->
        <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="public/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- Page-Level Plugin CSS - Blank -->

        <!-- SB Admin CSS - Include with every page -->
        <!--<link href="public/assets/css/sb-admin.css" rel="stylesheet">-->

        <!-- Other CSS File -->
        <link href="public/assets/css/main.css" rel="stylesheet">

    </head>
    <body>
        <!-- Begin page content -->
        <div class="container">
            <div class="page-header">
                <a href="index.php"><h1>JRESTPad</h1></a>
            </div>
            <p class="lead">Este é um aplicativo acadêmico RESTFul e AJAX, 
                usado para ser um Editor de Texto colaborativo. <a href="about_us">Leia mais.</a></p>
            <div class="panel-body">
                <?php if(isset($view_filename)) require $view_filename ?>
                <!-- /.panel-body -->
            </div>

            <div class="footer">
                <div class="container">
                    <p class="text-muted text-right">Desenvolvido por <a href="http://www.facebook.com/ljhonne" target="_blank">Luis Jhonne.</a></p>
                </div>
            </div>


            <!-- Core Scripts - Include with every page -->
            <script src="public/assets/js/jquery-1.11.1.js"></script>
            <script src="public/assets/js/bootstrap.min.js"></script>
            <!-- SB Admin Scripts - Include with every page -->
            <script src="public/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>

            <script src="public/assets/js/sb-admin.js"></script>

            <!-- Page-Level Demo Scripts - Blank - Use for reference -->
            <script src="public/assets/js/main.js"></script>
    </body>

</html>
