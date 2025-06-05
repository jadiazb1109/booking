<!doctype html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title> ORBE | <?php echo $pagina; ?> </title>

      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico">
      <!-- Library Bundle Script -->
      <script src="../assets/js/core/libs.min.js"></script>
      
      <!-- DevExtreme theme -->
      <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">

      <!-- DevExtreme libraries (reference only one of them) 
      <script type="text/javascript" src="../assets/devexpress/web/dx.all.js"></script> -->  
      <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script>   
      

      <!-- Exportar a excel -->
      <script src="../assets/devexpress/web/polyfill.min.js"></script>
      <script src="../assets/devexpress/web/exceljs.min.js"></script>
      <script src="../assets/devexpress/web/FileSaver.min.js"></script>
                  
      <!-- Library / Plugin Css Build -->
      <link rel="stylesheet" href="../assets/css/core/libs.min.css">
      
      <!-- Aos Animation Css -->
      <link rel="stylesheet" href="../assets/vendor/aos/dist/aos.css">
      
      <!-- Hope Ui Design System Css -->
      <link rel="stylesheet" href="../assets/css/hope-ui.min.css?v=4.0.0">
      
      <!-- Custom Css -->
      <link rel="stylesheet" href="../assets/css/custom.min.css?v=4.0.0">
      
      <!-- Dark Css -->
      <link rel="stylesheet" href="../assets/css/dark.min.css">
      
      <!-- Customizer Css -->
      <link rel="stylesheet" href="../assets/css/customizer.min.css">    

      <link href="../assets/font-awesome/css/all.css" rel="stylesheet">

      <!-- include summernote css/js -->
      <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

      <style>
        .form-control{
          color:#333 !important;
        }
        .form-label, .form-check-label{
          color:#5d5d5d !important;
        }
        .hr-horizontal {
          background: rgb(7 7 7 / 60%) !important;
        }
        .note-editor.note-frame, .note-editing-area, .note-editable {
          color:#333 !important;
        }
        #navbarHorizontal{
          background:#f2f3f9;
        }
      </style>
      
  </head>
  <body class="  ">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body">
          </div>
      </div>    </div>
    <!-- loader END -->
    
    <?php include 'page/menu-vertical.php'; ?>
    <main class="main-content">
    <?php include 'page/menu-horizontal.php'; ?>

    <script src="../_js/validar-sesion.js" type="module"></script>