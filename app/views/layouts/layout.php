<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JRESTPad <?php if(isset($page_title)) echo "| " . $page_title  ?></title>

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
        <h1>JRESTPad</h1>
      </div>
      <p class="lead">Este é um aplicativo acadêmico RESTFul e AJAX, usado para ser um Editor de Texto colaborativo.</p>
<div class="panel-body">
                            <div class="row">
                                <!--<div class="col-lg-6">-->
                                    <form role="form">
					<div class="form-group">
                                            <div class="panel panel-default ()">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">O conteúdo será exibido abaixo</h3>
                                                </div>
                                                <div class="panel-body" id="resultado">
                                                    
                                                </div>    
                                                <div class="panel-footer">Panel footer</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Digite seu texto e tecle Enter">
                                        </div>
                                        <button type="submit" id="btnSubmit" class="btn btn-default">Submit Button</button>
                                        <button type="reset" class="btn btn-default">Reset Button</button>
                                    </form>
                                <!--</div>-->
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
    </div>

    <div class="footer">
      <div class="container">
        <p class="text-muted">Desenvolvido por <a href="http://www.facebook.com/ljhonne" target="_blank">Luis Jhonne.</a></p>
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
