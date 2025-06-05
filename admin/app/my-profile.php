<?php

$pagina="My profile"; 
$codigoMenu="0";

?>
<?php include 'page/head.php'; ?>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="d-flex flex-wrap align-items-center">
                                    <h4 class="mb-0"><?php echo $pagina;?></h4>
                                </div>
                                <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-bs-toggle="tab" href="#profile-information" role="tab" aria-selected="false">People</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#profile-password" role="tab" aria-selected="false">User</a>
                                    </li>                              
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title"></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="user-profile">
                                    <img src="../assets/images/avatars/01.png" alt="profile-img" id="uploadedAvatar" class="rounded-pill avatar-130 img-fluid">
                                </div>
                                <div class="mt-3">
                                    <h4 id="txtInfoUsuario" class="d-inline-block">Full name</h4><br>
                                </div>
                            </div>
                            <hr class="hr-horizontal">
                            <div class="row text-center">        
                                <form role="form" enctype="multipart/form-data" id="formAvatar">
                                    <div class="form-group row d-none"><label class="col-sm-2 col-form-label">OpcionForm</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" id="opcion" name="opcion" value="cambiar_avatar"></div>
                                    </div>
                                    <div class="form-group row d-none"><label class="col-sm-2 col-form-label">Id</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" id="txtModalId" name="txtModalId"></div>
                                    </div>
                                    <div>
                                        <div class="text-center">
                                            <label for="upload" class="btn btn-primary" tabindex="0">
                                                <span id="btnCargarAvatar" title="Actualizar" class="d-none d-sm-block">Update avatar</span>
                                                <input type="file" hidden accept="image/png, image/jpeg" id="upload" name="upload" />
                                            </label>
                                            <button type="button" id="btnResetAvatar" title="Remover" class="btn btn-gray">
                                                <span class="d-none d-sm-block">Remove</span>
                                            </button><br>
                                            <small>Permitid JPG, GIF or PNG. Max 800K</small>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="profile-content tab-content">
                        <div id="profile-information" class="tab-pane fade active show">
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">People information</h4>
                                        <hr class="hr-horizontal">
                                    </div>
                                </div>
                                <div class="card-body">                                    
                                    <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                                        <ul class="list-inline p-0 m-0">
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-success text-success"></div>
                                                <h6 class="form-label"><strong>Email:</strong></h6>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="txtPCorreo">                                                    
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-danger text-danger"></div>
                                                <h6 class="form-label"><strong>Address:</strong></h6>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="txtPDireccion">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-success text-success"></div>
                                                <h6 class="form-label"><strong>City:</strong></h6>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="txtPCiudad">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-danger text-danger"></div>
                                                <h6 class="form-label"><strong>State:</strong></h6>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="txtPEstado">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-success text-success"></div>
                                                <h6 class="form-label"><strong>Code zip:</strong></h6>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="txtPCodigoZip">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-danger text-danger"></div>
                                                <h6 class="form-label"><strong>Phone:</strong></h6>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="txtPTelefono">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-success text-success"></div>
                                                <h6 class="form-label"><strong>Birthdate:</strong></h6>
                                                <div class="form-group">
                                                    <input type="date" class="form-control" id="txtPFechaNacimiento" placeholder="Selecciona una fecha">
                                                </div>
                                            </li>                                            
                                        </ul>                                        
                                    </div>
                                    <hr class="hr-horizontal">                      
                                    <div class="row text-center">
                                        <div class="form-group">
                                            <button type="button" id="btnGuardarInfomacion" class="btn btn-primary">Update information</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="profile-password" class="tab-pane fade">
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">User information</h4>
                                        <hr class="hr-horizontal">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="txtUsuario"><strong>Username</strong></label>
                                            <input type="text" class="form-control" id="txtUsuario" placeholder="Digita un usuario" readonly>
                                        </div>  
                                    </div> 
                                    <br><hr class="hr-horizontal">
                                    <div class="row"> 
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="txtClaveA"><strong>Password current</strong></label>
                                            <input type="password" class="form-control" id="txtClaveA" placeholder="Enter your current password">
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="txtClaveN"><strong>New password</strong></label>
                                            <input type="password" class="form-control" id="txtClaveN" placeholder="Enter your new password">
                                        </div>  
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="txtClaveC"><strong>Confirm password</strong></label>
                                            <input type="password" class="form-control" id="txtClaveC" placeholder="Confirm your new password">
                                        </div>
                                    </div>          
                                    <hr class="hr-horizontal">                      
                                    <div class="row text-center">
                                        <div class="form-group">
                                            <button type="button" id="btnGuardarClave" class="btn btn-primary">Update password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div> 
        </div>

    <script src="../_js/my-profile.js" type="module"> </script>

<?php include 'page/footer.php'; ?>

<div class="modal fade" id="modalDetailEmail" tabindex="-1" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" aria-labelledby="modalDetailLabel" style="display: none; background: linear-gradient(#000d, #000a);" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <strong><h5 class="modal-title" id="modalDetailEmailLabel">Opcion</h5></strong>
            </div>
            <div class="modal-body">
                <div class="form-group d-none">
                    <label class="form-label">Id</label>
                    <input type="text" class="form-control" id="txtIdCorreo">
                </div>
                <div class="form-group">
                    <label class="form-label" for="cmbHostCorreo"><strong>Host</strong></label>
                    <div id="cmbHostCorreo"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="txtDescripcionCorreo"><strong>Descripcion</strong></label>
                    <input type="text" class="form-control" id="txtDescripcionCorreo" placeholder="Digita una descripcion">
                </div>
                <div class="form-group">
                    <label class="form-label" for="txtCorreoCorreo"><strong>Correo</strong></label>
                    <input type="email" class="form-control" id="txtCorreoCorreo" placeholder="Digita un correo">
                </div>
                <div class="form-group">
                    <label class="form-label" for="txtTokenCorreo"><strong>Token</strong></label>
                    <input type="text" class="form-control" id="txtTokenCorreo" placeholder="Digita el token">
                </div>
                <div class="form-group">
                    <label class="form-label" for="txtEnviarComoCorreo"><strong>Enviar como</strong></label>
                    <input type="text" class="form-control" id="txtEnviarComoCorreo" placeholder="Digita el enviar como">
                </div>
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chkActivoCorreo"/>
                    <label class="form-check-label pl-2" for="chkActivoCorreo"><strong> Activo</strong></label>
                </div>           
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnCancelarCorreo" class="btn btn-gray">Cancel</button>
                <button type="button" id="btnGuardarCorreo" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailCorreosEnviados" tabindex="-1" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" style="display: none; background: linear-gradient(#000d, #000a);" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <strong><h5 class="modal-title">Correos enviados</h5></strong>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <button type="button" id="btnConsutlarMensaje" class="btn btn-primary">Ver mensaje</button>
                    </div>
                </div>
                <div class="row">
                    <div id="grdDatosCorreosEnviados"></div>
                </div>          
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnCancelarCorreosEnviados" class="btn btn-gray">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailCorreosEnviadosMensaje" tabindex="-1" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" style="display: none; background: linear-gradient(#000d, #000a);" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <strong><h5 class="modal-title">Mensaje</h5></strong>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="summernote" id="txtMensajeCorreoEnviado"></div>
                    </div>
                </div>          
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnCancelarCorreosEnviadosMensaje" class="btn btn-gray">Cancelar</button>
            </div>
        </div>
    </div>
</div>