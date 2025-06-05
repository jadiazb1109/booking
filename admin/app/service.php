<?php

$pagina = "Services";
$codigoMenu = "2,23";

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
                            <button id="btnActualizar" class="text-center btn btn-primary btn-icon" title="Reload"><i class="fa-solid fa-rotate"></i></button>
                            <button id="btnAdicionar" style="display: none;" class="text-center btn btn-primary btn-icon" title="Insert"><i class="fa-solid fa-plus"></i></button>
                            <button id="btnModificar" style="display: none;" class="text-center btn btn-primary btn-icon" title="Update"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button id="btnConsultar" style="display: none;" class="text-center btn btn-primary btn-icon" title="View"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <button id="btnExportar" style="display: none;" class="text-center btn btn-primary btn-icon" title="Print"><i class="fa-solid fa-download"></i></button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <div id="grdDatos"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../_js/service.js" type="module"> </script>

<?php include 'page/footer.php'; ?>


<div class="modal fade" id="modalDetail" tabindex="-1" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" aria-labelledby="modalDetailLabel" style="display: none; background: linear-gradient(#000d, #000a);" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <strong><h5 class="modal-title" id="modalDetailLabel">Opcion</h5></strong>
            </div>
            <div class="modal-body">
                <div class="form-group d-none">
                    <label class="form-label">Id</label>
                    <input type="text" class="form-control" id="txtId">
                </div>
                <div class="form-group">
                    <label class="form-label" for="cmbType"><strong>Type</strong></label>
                    <div id="cmbType"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="txtDescripcion"><strong>Name *</strong></label>
                    <input type="text" class="form-control" id="txtDescripcion" placeholder="Enter a description">
                </div>
                <div class="form-group">
                    <label class="form-label" for="txtNotes"><strong>Notes</strong></label>
                    <textarea class="form-control" id="txtNotes" placeholder="Enter a notes" style="height: 100px"></textarea>
                </div>
                <div class="row form-group">
                    <div class="form-check form-switch form-check-inline col-md-3" style="padding-left: 3.5em;">
                        <input class="form-check-input" type="checkbox" id="chkReturn"/>
                        <label class="form-check-label pl-2" for="chkReturn"><strong> Return</strong></label>
                    </div>
                    <div class="form-check form-switch form-check-inline col-md-4">
                        <input class="form-check-input" type="checkbox" id="chkNumberRoom"/>
                        <label class="form-check-label pl-2" for="chkNumberRoom"><strong> Number room</strong></label>
                    </div>
                    <div class="form-check form-switch form-check-inline col-md-3">
                        <input class="form-check-input" type="checkbox" id="chkActivo"/>
                        <label class="form-check-label pl-2" for="chkActivo"><strong> Active</strong></label>
                    </div>          
                </div> 
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnCancelar" class="btn btn-gray">Cancel</button>
                <button type="button" id="btnGuardar" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>