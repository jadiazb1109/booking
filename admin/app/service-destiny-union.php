<?php

$pagina = "Services & destinys union";
$codigoMenu = "2,26";

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
                        <div class="form-group row text-center">  
                            <div class="col-sm-3">
                                <button type="button" id="btnGroupsPassanger" class="text-center btn btn-primary btn-icon">Groups passanger <i class="fa-solid fa-users"></i></button>
                            </div>                                                         
                        </div> 
                        <hr class="hr-horizontal">
                        <div id="grdDatos"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../_js/service-destiny-union.js" type="module"> </script>

<?php include 'page/footer.php'; ?>


<div class="modal fade" id="modalDetail" tabindex="-1" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" aria-labelledby="modalDetailLabel" style="display: none; background: linear-gradient(#000d, #000a);" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
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
                    <label class="form-label" for="cmbService"><strong>Service</strong></label>
                    <div id="cmbService"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="cmbDestiny"><strong>Destiny</strong></label>
                    <div id="cmbDestiny"></div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 d-none" id="divFecha">
                        <label class="form-label" for="dtFecha"><strong>Date</strong></label>
                        <input type="date" class="form-control" id="dtFecha" placeholder="Select a date">
                    </div>
                    <div class="form-group col-md-4 d-none" id="divPrice">
                        <label class="form-label" for="txtPrice"><strong>Price</strong></label>
                        <div id="txtPrice"></div>
                    </div>
                    <div class="form-group col-md-4 d-none" id="divAdditional">
                        <label class="form-label" for="txtAdditional"><strong>Additional</strong></label>
                        <div id="txtAdditional"></div>
                    </div>
                </div>
                <div class="row d-none" id="divPromo">
                    <div class="form-check form-switch form-check-inline col-md-3" style="padding-left: 3.5em;"><br>
                        <input class="form-check-input" type="checkbox" id="chkPromoDxU"/>
                        <label class="form-check-label pl-2" for="chkPromoDxU"><strong> Promo 2 x 1</strong></label>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="txtNextPassg"><strong>Next passg</strong></label>
                        <div id="txtNextPassg"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="txtNextPassgPrice"><strong>Next passg price</strong></label>
                        <div id="txtNextPassgPrice"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="txtInformationInitial"><strong>Information initial</strong></label>
                        <textarea class="form-control" id="txtInformationInitial" placeholder="Enter a information initial" style="height: 100px"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="txtTermsConditions"><strong>Terms & conditions</strong></label>
                        <textarea class="form-control" id="txtTermsConditions" placeholder="Enter a terms & conditions" style="height: 100px"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="txtNotes"><strong>Notes</strong></label>
                    <textarea class="form-control" id="txtNotes" placeholder="Enter a notes" style="height: 100px"></textarea>
                </div>                
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chkActivo"/>
                    <label class="form-check-label pl-2" for="chkActivo"><strong> Active</strong></label>
                </div>           
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnCancelar" class="btn btn-gray">Cancel</button>
                <button type="button" id="btnGuardar" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailGroupsPassanger" role="dialog" data-bs-backdrop="static"  data-bs-keyboard="false"style="display: none; background: linear-gradient(#000d, #000a);" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <strong><h5 class="modal-title">Groups</h5></strong>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="cmbServiceGroup"><strong>Service</strong></label>
                    <div id="cmbServiceGroup"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="cmbDestinyGroup"><strong>Destiny</strong></label>
                    <div id="cmbDestinyGroup"></div>
                </div>
                <hr class="hr-horizontal">
                <div class="form-group row">  
                    <div class="col-sm-3">
                        <label class="form-label" for="txtPassengerMinGroup"><strong>Pass min</strong></label>
                        <div id="txtPassengerMinGroup"></div>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="txtPassengerMaxGroup"><strong>Pass max</strong></label>
                        <div id="txtPassengerMaxGroup"></div>
                    </div>  
                    <div class="form-group col-md-3">
                        <label class="form-label" for="txtPriceGroup"><strong>Price</strong></label>
                        <div id="txtPriceGroup"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="form-label" for="txtAdditionalGroup"><strong>Additional</strong></label>
                        <div id="txtAdditionalGroup"></div>
                    </div>                                                             
                </div> 
                <div class="form-group"> 
                    <label class="form-label" for="txtNotesGroup"><strong>Notes</strong></label> 
                    <input type="text" placeholder="Enter a notes" class="form-control" id="txtNotesGroup">
                </div> 
                <hr class="hr-horizontal">
                <div class="form-group row">
                    <div class="col-sm-7">
                        <button id="btnGuardarGroup" class="btn btn-primary btn-sm" style="display: none;">Save</button>
                        <button id="btnEliminarGroup" class="btn btn-danger btn-sm" style="display: none;">Delete</button>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">                                                                                
                    <div class="col-lg-12">
                        <div id="grdDatosGroupsPassanger"></div>
                    </div>
                </div>            
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnCancelarGroup" class="btn btn-gray">Cancel</button>
            </div>
        </div>
    </div>
</div>