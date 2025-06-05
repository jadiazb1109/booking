<?php

$pagina = "Assign permissions";
$codigoMenu = "1,41";

?>
<?php include 'page/head.php'; ?>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h4 class="mb-0"><?php echo $pagina;?></h4>
                        </div>
                        <div class="card-action">
                            <button id="btnExportar" style="display: none;" class="text-center btn btn-primary btn-icon" title="Print"><i class="fa-solid fa-download"></i></button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">    
                            <div class="form-group col-md-6">
                                <label class="form-label" for="cmbRoles"><strong>Rol</strong></label>
                                <div id="cmbRoles"></div>
                            </div>  
                        </div> 
                        <hr class="hr-horizontal">
                        <div class="row">
                            <div class="col-sm-7">
                                <button type="button" id="btnGuardar" class="btn btn-primary">Save</button>                                            
                            </div>
                        </div>
                        <br>
                        <div class="row text-center">
                            <h3><strong>Menu - Options</strong></h3>
                        </div>
                        <hr class="hr-horizontal">
                        <div class="row">
                            <div id="grdDatos"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../_js/role-menu.js" type="module"> </script>

<?php include 'page/footer.php'; ?>

<div class="modal fade" id="modalDetail" tabindex="-1" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" aria-labelledby="modalDetailLabel" style="display: none; background: linear-gradient(#000d, #000a);" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <strong><h5 class="modal-title" id="modalDetailLabel">Option</h5></strong>
            </div>
            <div class="modal-body">
                <div class="form-group d-none">
                    <label class="form-label">Id</label>
                    <input type="text" class="form-control" id="txtId">
                </div>
                <div class="row">
                    <div id="grdDatosDetalle"></div>
                </div>          
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnCancelar" class="btn btn-gray">Cancel</button>
            </div>
        </div>
    </div>
</div>
