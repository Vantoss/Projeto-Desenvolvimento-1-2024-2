
<?php
define('ROOT_DIR', '../');
$pagina_titulo = "Install";
require_once ROOT_DIR. 'includes/layout/header.php';
?>
<body>
  
  <div class="row g-3">
        <div class="row caption">
          <h3>Installation</h3>
          <?php echo isset($_SESSION['err_setup']) ? $_SESSION['err_setup'] : ''; unset($_SESSION['err_setup']); ?>
          <p class="alert alert-warning">
            Puggy is a vulnerable web application to exploit common vulnerabilities.<br>
            <b>Please, do not run this script in a production server.</b>
          </p>
        </div>
        
        
        <form id="mysql-setup" method="post">
          <div class="row" style="margin:10px 0px;">
            <div class="col" >
              <div class="form-horizontal">
                <div class="form-group">
                  <label><span style="color: #ccc;" class="fa fa-question-circle fa-lg" ></span> DB address</label>
                  <input type="text" class="form-control" autocomplete="off" name="dbaddr" value="localhost" required>
                </div>
              </div>
            </div>
            
            <div class="col" >
              <div class="form-horizontal">
                <div class="form-group">
                  <label><span style="color: #ccc;" class="fa fa-question-circle fa-lg" ></span> DB port</label>
                  <input type="number" class="form-control" autocomplete="off" name="dbport" value="3306">
                </div>
              </div>
            </div>
            <div class="col">
              <div class="form-horizontal">
                <div class="form-group">
                  <label><span style="color: #ccc;" class="fa fa-question-circle fa-lg" ></span> DB name</label>
                  <input type="text" class="form-control" autocomplete="off" name="dbname" value="senac" required>
                </div>
              </div>
            </div>  
          </div>

          <div class="row" style="margin:10px 0px;">
            <div class="col">
              <label><span style="color: #ccc;" class="fa fa-question-circle fa-lg" ></span> DB user</label>
              <input type="text" class="form-control" autocomplete="off" name="dbuser" value="root" required>
            </div>
            <div class="col">
              <label><span style="color: #ccc;" class="fa fa-question-circle fa-lg" ></span> DB password</label>
              <input type="password" class="form-control" autocomplete="off" name="dbpass" placeholder="None">
            </div>
          </div>

          <div class="row" style="margin:10px; ">
            <div class="col" style="padding:0;">
              <button type="submit" class="btn btn-primary ">SUBMIT</butto>
            </div>
          </div>
      </form>
  </div>
  <?php // MODAL ALERTA 
    require_once ROOT_DIR.'includes/components/modals/modal_alerta.php';?>

</body>
</html>


