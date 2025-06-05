import { clsGenerales } from './_generales.js';

document.addEventListener('DOMContentLoaded', () => {

    const clsGenerales_ = new clsGenerales();

    var htmlButon = "";
    var selectId = 0;
    var txtPagina = document.getElementById('txtPagina').value;
    var txtCodigoMenu = document.getElementById('txtCodigoMenu').value;

    const btnActualizar = document.getElementById('btnActualizar');
    const btnAdicionar = document.getElementById('btnAdicionar');
    const btnModificar = document.getElementById('btnModificar');
    const btnConsultar = document.getElementById('btnConsultar');
    const btnExportar = document.getElementById('btnExportar');

    const btnGroupsPassanger = document.getElementById('btnGroupsPassanger');

    btnActualizar.addEventListener('click', btnActualizarClick);
    btnAdicionar.addEventListener('click', btnAccionClick);
    btnModificar.addEventListener('click', btnAccionClick);
    btnConsultar.addEventListener('click', btnAccionClick);
    btnExportar.addEventListener('click', btnExportarClick);

    var arrCodigos = txtCodigoMenu.split(',');
    var jsMenu = [];
    var jsMenuGroupsPassanger = [];

    //#region permisos

    $.ajax({
        url: "../../api/v1/rol/roles/menus/" + arrCodigos[arrCodigos.length - 1] + "/user/" + clsGenerales_.obtenerDataUsuario().id,
        type: "GET",
        crossDomain: true,
        dataType: 'json',
        headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() }
    }).done((respuesta) => {

        jsMenu = respuesta["data"];
        if (jsMenu.filter(menu => menu.opcion == "VIEW").length > 0) {$(btnConsultar).show();}
        if (jsMenu.filter(menu => menu.opcion == "INSERT").length > 0) {$(btnAdicionar).show();}
        if (jsMenu.filter(menu => menu.opcion == "UPDATE").length > 0) {$(btnModificar).show();}
        if (jsMenu.filter(menu => menu.opcion == "PRINT").length > 0) {$(btnExportar).show();}

    });

    $.ajax({
        url: "../../api/v1/rol/roles/menus/32/user/" + clsGenerales_.obtenerDataUsuario().id,
        type: "GET",
        crossDomain: true,
        dataType: 'json',
        headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() }
    }).done((respuesta) => {

        jsMenuGroupsPassanger = respuesta["data"];
        if (jsMenuGroupsPassanger.filter(menu => menu.opcion == "VIEW").length > 0) {$(btnGroupsPassanger).show();}
        if (jsMenuGroupsPassanger.filter(menu => menu.opcion == "INSERT").length > 0) {$(btnGuardarGroup).show();}
        if (jsMenuGroupsPassanger.filter(menu => menu.opcion == "UPDATE").length > 0) {$(btnEliminarGroup).show();}

    });

    //#endregion permisos

    //#region principal
    var txtOpcion = "";
    var urlApi = "../../api/v1/unionServiceDestiny/unionServiceDestinys";

    var jsSelectItem = [];
    
    var grdDatos = $("#grdDatos").dxDataGrid({
        columns: [
            {
                dataField: "id",
                visible: false
            }, "type_service","service","destiny","date",{
                dataField: 'price',
                dataType: 'number',
                format: {
                    type: "currency",
                    precision: 2
                },
                alignment: 'right'
            },{
                dataField: 'additional',
                dataType: 'number',
                format: {
                    type: "currency",
                    precision: 2
                },
                alignment: 'right'
            },
            {
                dataField: "promo_one_x_two",
                dataType: "boolean"
            },"promo_next_pass",{
                dataField: 'promo_next_pass_preci',
                caption: "Promo next pass price",
                dataType: 'number',
                format: {
                    type: "currency",
                    precision: 2
                },
                alignment: 'right'
            },
            {
                dataField: "active",
                dataType: "boolean"
            }
        ],
        summary: {
            totalItems: [{
                column: "destiny",
                summaryType: "count",
                displayFormat: "{0}"
            }],
            groupItems: [{
                column: "destiny",
                summaryType: "count",
                displayFormat: "{0}",
            }]
        },
        onSelectionChanged: function(selectedItems) {
            if (selectedItems.selectedRowsData.length > 0) {
                selectId = selectedItems.selectedRowsData[0].id;
            }

        }
    }).dxDataGrid("instance");

    
    btnActualizarClick(false);

    function btnActualizarClick(cargar = true) {
        clsGenerales_.mtdOpionesGrid(grdDatos, cargar);

        htmlButon = '<i class="fa-solid fa-rotate"></i>';
        clsGenerales_.mtdActivarLoad(btnActualizar, "");

        $.ajax({
            url: urlApi,
            type: "GET",
            crossDomain: true,
            dataType: 'json',
            headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
            error: function() { 
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning"); 
                clsGenerales_.mtdDesactivarLoad(btnActualizar, htmlButon);
            }
        }).done((resultado) => {
            grdDatos.option({
                dataSource: resultado["data"]
            });
            if (resultado["state"] === 'ko') {
                clsGenerales_.mtdMostrarMensaje(resultado["message"], "error");
            }
            clsGenerales_.mtdDesactivarLoad(btnActualizar, htmlButon);
        });
    }

    function btnExportarClick(e) {
        e.preventDefault();      

        if (this.id == "btnExportar" && validarPermiso(jsMenu.filter(menu => menu.opcion == "PRINT").length > 0)) {
            clsGenerales_.mtdGridExportar(grdDatos, txtPagina + "_" + clsGenerales_.fnFechaHoraActual(), txtPagina.toUpperCase()); 
        }
    }

    function btnAccionClick(e) {
        e.preventDefault();

        htmlButon = this.innerHTML;        
        
        btnGuardar.classList.remove("d-none");

        if (this.id == "btnAdicionar") {
            if (!validarPermiso(jsMenu.filter(menu => menu.opcion == "INSERT").length > 0)) { return; }
            txtOpcion = "Adicionar";            
            chkActivo.checked = true;
            $(modalDetail).modal("show");

            clsGenerales_.mtdLlenarComponetTipos("../../api/v1/service/servicesActive", cmbService);            
           
        }

        if (this.id == "btnModificar" || this.id == "btnConsultar") {
            if (selectId > 0) {

                clsGenerales_.mtdLlenarComponetTipos("../../api/v1/service/services", cmbService);

                clsGenerales_.mtdActivarLoad(this, "");
                cmbService.option({readOnly: true});
                cmbDestiny.option({readOnly: true});

                if (this.id == "btnModificar") {
                    if (!validarPermiso(jsMenu.filter(menu => menu.opcion == "UPDATE").length > 0)) { return; }
                    txtOpcion = "Modificar";                    
                } else {
                    if (!validarPermiso(jsMenu.filter(menu => menu.opcion == "VIEW").length > 0)) { return; }
                    txtOpcion = "Consultar";
                    btnGuardar.classList.add("d-none");
                }

                $.ajax({
                    url: urlApi + "/" + selectId,
                    type: "GET",
                    crossDomain: true,
                    dataType: 'json',
                    headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                    error: function() { 
                        clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");  
                        clsGenerales_.mtdDesactivarLoad(this, htmlButon);
                    }
                }).done((resultado) => {
                    
                    clsGenerales_.mtdDesactivarLoad(this, htmlButon);

                    if (resultado["state"] === 'ok') {
                        txtId.value = resultado["data"][0].id;                        
                        clsGenerales_.fnComponetInstanceSetValue(cmbService, resultado["data"][0].service_id);
                        clsGenerales_.fnComponetInstanceSetValue(cmbDestiny, resultado["data"][0].destiny_id);

                        setTimeout(() => {

                            dtFecha.value = resultado["data"][0].date; 
                            clsGenerales_.fnNumberSetValue(txtPrice,resultado["data"][0].price);
                            clsGenerales_.fnNumberSetValue(txtAdditional,resultado["data"][0].additional);
                            chkPromoDxU.checked = resultado["data"][0].promo_one_x_two ? true : false;
                            clsGenerales_.fnNumberSetValue(txtNextPassg,resultado["data"][0].promo_next_pass);
                            clsGenerales_.fnNumberSetValue(txtNextPassgPrice,resultado["data"][0].promo_next_pass_preci);
                            txtInformationInitial.value = resultado["data"][0].important_information_initial; 
                            txtTermsConditions.value = resultado["data"][0].terms_and_conditions; 
                            txtNotes.value = resultado["data"][0].notes; 
                            chkActivo.checked = resultado["data"][0].active ? true : false;
                            $(modalDetail).modal("show");

                        }, 1000);
                    }
                    if (resultado["state"] === 'ko') {
                        clsGenerales_.mtdMostrarMensaje(resultado["message"], "error");
                    }
                });
            } else {
                clsGenerales_.mtdMostrarMensaje("Select a record", "error");
                return;
            }
        }
        modalDetailLabel.innerHTML = txtOpcion == "Adicionar" ? "Insert" : txtOpcion == "Modificar" ? "Update" : "View";
    }

    function validarPermiso(EstadoPermiso) {
        if (!EstadoPermiso) {
            clsGenerales_.mtdMostrarMensaje("You do not have permission to use this option.", "warning");
        }
        return EstadoPermiso;
    }

    //#endregion principal

    //#region modal detalle

    const modalDetail = document.getElementById('modalDetail');
    const modalDetailLabel = document.getElementById('modalDetailLabel');
    const txtId = document.getElementById('txtId');
    const divFecha = document.getElementById('divFecha');
    const dtFecha = document.getElementById('dtFecha');
    const divPrice = document.getElementById('divPrice');
    const txtPrice = clsGenerales_.fnNumberCurrency(document.getElementById('txtPrice'), true);    
    const divAdditional = document.getElementById('divAdditional');
    const txtAdditional = clsGenerales_.fnNumberCurrency(document.getElementById('txtAdditional'), true);
    const divPromo = document.getElementById('divPromo');
    const chkPromoDxU = document.getElementById('chkPromoDxU');
    const txtNextPassg = clsGenerales_.fnNumber(document.getElementById('txtNextPassg'), 0);
    const txtNextPassgPrice = clsGenerales_.fnNumberCurrency(document.getElementById('txtNextPassgPrice'), true);
    const txtInformationInitial = document.getElementById('txtInformationInitial');
    const txtTermsConditions = document.getElementById('txtTermsConditions');
    const txtNotes = document.getElementById('txtNotes');
    const chkActivo = document.getElementById('chkActivo');
    const btnGuardar = document.getElementById('btnGuardar');
    const btnCancelar = document.getElementById('btnCancelar');    

    const cmbService = $('#cmbService').dxSelectBox({
        placeholder: 'Select a option',
        valueExpr: "id",
        displayExpr: "union_service",
        searchEnabled: true,
    }).dxSelectBox('instance');

    const cmbDestiny = $('#cmbDestiny').dxSelectBox({
        placeholder: 'Select a option',
        valueExpr: "id",
        displayExpr: "union_destiny",
        searchEnabled: true,
    }).dxSelectBox('instance');
    
    var var_type_id = 0;

    cmbService.on("selectionChanged", function (itemData) {
        if (itemData.selectedItem !== null) {
            var_type_id = itemData.selectedItem.type_id;
            clsGenerales_.mtdLlenarComponetTipos("../../api/v1/destiny/destinys/type/" + var_type_id, cmbDestiny);

            divFecha.classList.add("d-none");
            divPrice.classList.add("d-none");
            divAdditional.classList.add("d-none");
            divPromo.classList.add("d-none");
            dtFecha.value = null;

            if (var_type_id == 1) {
                divFecha.classList.remove("d-none");
                divPrice.classList.remove("d-none");
                divAdditional.classList.remove("d-none");

                dtFecha.value = clsGenerales_.fnFechaActual();
            } else if (var_type_id == 3) {

                divPrice.classList.remove("d-none");
                divAdditional.classList.remove("d-none");
                divPromo.classList.remove("d-none");

            }
            
            clsGenerales_.fnNumberSetValue(txtPrice, 0);
            clsGenerales_.fnNumberSetValue(txtAdditional, 0);
            chkPromoDxU.checked = false;
            clsGenerales_.fnNumberSetValue(txtNextPassg, 0);
            clsGenerales_.fnNumberSetValue(txtNextPassgPrice, 0);
            txtInformationInitial.value = null;
            txtTermsConditions.value = null;

        }else{
            var_type_id = 0;
            clsGenerales_.fnComponetInstanceSetValue(cmbDestiny, null);
        }
    });


    btnGuardar.addEventListener('click', btnGuardarClick);
    btnCancelar.addEventListener('click', btnCancelarClick);

    function btnCancelarClick() {    
        $(modalDetail).modal("hide");    
        
        clearInputs();       
    }

    function clearInputs() {           
        clsGenerales_.fnComponetInstanceSetValue(cmbService, null);
        clsGenerales_.fnComponetInstanceSetValue(cmbDestiny, null);
        dtFecha.value = null;
        clsGenerales_.fnNumberSetValue(txtPrice, 0);
        clsGenerales_.fnNumberSetValue(txtAdditional, 0);
        chkPromoDxU.checked = false;
        clsGenerales_.fnNumberSetValue(txtNextPassg, 0);
        clsGenerales_.fnNumberSetValue(txtNextPassgPrice, 0);
        txtInformationInitial.value = null;
        txtTermsConditions.value = null;
        txtNotes.value = null;
        chkActivo.checked = true;       
        
        cmbService.option({readOnly: false});
        cmbDestiny.option({readOnly: false});    
        
        cmbDestiny.option({ dataSource: []});
        divFecha.classList.add("d-none");
        divPrice.classList.add("d-none");
        divAdditional.classList.add("d-none");
        divPromo.classList.add("d-none");
    }

    function btnGuardarClick(e) {
        e.preventDefault();        

        if (!clsGenerales_.fnComponetInstanceGetValue(cmbService)) {
            clsGenerales_.mtdMostrarMensaje("Select a service", "error");
            cmbService.focus();
            return;
        }

        if (!clsGenerales_.fnComponetInstanceGetValue(cmbDestiny)) {
            clsGenerales_.mtdMostrarMensaje("Select a destiny", "error");
            cmbDestiny.focus();
            return;
        }

        if (!dtFecha.value && var_type_id == 1) {
            clsGenerales_.mtdMostrarMensaje("Select a date", "error");
            dtFecha.focus();
            return;
        }

        if (dtFecha.value < clsGenerales_.fnFechaActual() && var_type_id == 1) {
            clsGenerales_.mtdMostrarMensaje("The selected date cannot be less than the current date.", "error");
            dtFecha.focus();
            return;
        }

        if (clsGenerales_.fnComponetInstanceGetValue(txtPrice) == 0 && (var_type_id == 1 || var_type_id == 3)) {
            clsGenerales_.mtdMostrarMensaje("Enter a price", "error");
            txtPrice.focus();
            return;
        }

        if (clsGenerales_.fnComponetInstanceGetValue(txtNextPassg) > 0 && var_type_id == 3 && clsGenerales_.fnComponetInstanceGetValue(txtNextPassgPrice) == 0) {
            clsGenerales_.mtdMostrarMensaje("Enter a price", "error");
            txtNextPassgPrice.focus();
            return;
        }

        if (txtOpcion == "Adicionar" || txtOpcion == "Modificar") {

            clsGenerales_.mtdActivarLoad(btnGuardar, "saving...");

            $.ajax({
                url: clsGenerales_.obtenerUrlSolicitud(txtOpcion, urlApi, selectId),
                type: clsGenerales_.obtenerTipoSolicitud(txtOpcion),
                dataType: 'json',
                crossDomain: true,
                headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                data: JSON.stringify({
                    type_id: var_type_id,
                    service_id: clsGenerales_.fnComponetInstanceGetValue(cmbService),
                    destiny_id: clsGenerales_.fnComponetInstanceGetValue(cmbDestiny),
                    date: var_type_id == 1 ? dtFecha.value : null,
                    price: clsGenerales_.fnComponetInstanceGetValue(txtPrice),
                    additional: clsGenerales_.fnComponetInstanceGetValue(txtAdditional),
                    promo_one_x_two: var_type_id == 3 ? chkPromoDxU.checked : false,
                    promo_next_pass: var_type_id == 3 ? clsGenerales_.fnComponetInstanceGetValue(txtNextPassg) : null,
                    promo_next_pass_preci: var_type_id == 3 ? clsGenerales_.fnComponetInstanceGetValue(txtNextPassgPrice) : null,
                    important_information_initial: var_type_id == 3 ? txtInformationInitial.value : null,
                    terms_and_conditions: var_type_id == 3 ? txtTermsConditions.value : null,
                    notes: txtNotes.value,                    
                    active: chkActivo.checked,
                    id_user: clsGenerales_.obtenerDataUsuario().id
                }),
                error: function () {
                    clsGenerales_.mtdDesactivarLoad(btnGuardar, "Save");
                    clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
                },
            }).done((respuesta) => {

                clsGenerales_.mtdDesactivarLoad(btnGuardar, "Save");

                if (respuesta["state"] === 'ok') {
                    clsGenerales_.mtdMostrarMensaje(respuesta["message"]);
                    
                    btnActualizarClick(false);                    
                }
                if (respuesta["state"] === 'ko') {
                    clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
                }
            });

        } else {
            clsGenerales_.mtdMostrarMensaje("You do not have permission to use this option.", "warning");
        }
        
    }

    //#endregion modal detalle

    //#region GroupsPassanger

    btnGroupsPassanger.addEventListener('click', btnGroupsPassangerClick);
    function btnGroupsPassangerClick() {    
        if (selectId > 0) {          

            if (!validarPermiso(jsMenuGroupsPassanger.filter(menu => menu.opcion == "VIEW").length > 0)) { return; }

            htmlButon = btnGroupsPassanger.innerHTML;
            clsGenerales_.mtdActivarLoad(btnGroupsPassanger, "");

            $.ajax({
                url: "../../api/v1/unionServiceDestiny/unionServiceDestinys/" + selectId,
                type: "GET",
                crossDomain: true,
                dataType: 'json',
                headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                error: function() { 
                    clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");  
                    clsGenerales_.mtdDesactivarLoad(btnGroupsPassanger, htmlButon);
                }
            }).done((resultado) => {
                
                clsGenerales_.mtdDesactivarLoad(btnGroupsPassanger, htmlButon);

                if (resultado["state"] === 'ok') {

                    jsSelectItem = resultado["data"][0];

                    if (jsSelectItem.type_id_destiny != 4) {
                        clsGenerales_.mtdMostrarMensaje("Select a record with service type groups", "error");
                        return;
                    }else{

                        clsGenerales_.mtdLlenarComponetTipos("../../api/v1/service/services", cmbServiceGroup);

                        $(modalDetailGroupsPassanger).modal("show");                        


                        clsGenerales_.fnComponetInstanceSetValue(cmbServiceGroup, jsSelectItem.service_id);
                        clsGenerales_.fnComponetInstanceSetValue(cmbDestinyGroup, jsSelectItem.destiny_id);

                        clsGenerales_.mtdLlamarDatosApi("../../api/v1/unionServiceDestinyGroup/unionServiceDestinyGroups/union/"+selectId,
                                grdDatosGroupsPassanger);
                        clsGenerales_.mtdOpionesGrid(grdDatosGroupsPassanger, true); 
                    }
                }
                if (resultado["state"] === 'ko') {
                    clsGenerales_.mtdMostrarMensaje(resultado["message"], "error");
                }
            });                         
        }else {
            clsGenerales_.mtdMostrarMensaje("Select a record", "error");
            return;
        }
    }

    const modalDetailGroupsPassanger = document.getElementById('modalDetailGroupsPassanger');
    const txtPassengerMinGroup = clsGenerales_.fnNumber(document.getElementById('txtPassengerMinGroup'), 0);
    const txtPassengerMaxGroup = clsGenerales_.fnNumber(document.getElementById('txtPassengerMaxGroup'), 0);
    const txtPriceGroup = clsGenerales_.fnNumberCurrency(document.getElementById('txtPriceGroup'), true);   
    const txtAdditionalGroup = clsGenerales_.fnNumberCurrency(document.getElementById('txtAdditionalGroup'), true);
    const txtNotesGroup = document.getElementById('txtNotesGroup');
    const btnGuardarGroup = document.getElementById('btnGuardarGroup');
    const btnEliminarGroup = document.getElementById('btnEliminarGroup');
    const btnCancelarGroup = document.getElementById('btnCancelarGroup');   

    const cmbServiceGroup = $('#cmbServiceGroup').dxSelectBox({
        placeholder: 'Select a option',
        valueExpr: "id",
        displayExpr: "union_service",
        searchEnabled: true,
    }).dxSelectBox('instance');

    const cmbDestinyGroup = $('#cmbDestinyGroup').dxSelectBox({
        placeholder: 'Select a option',
        valueExpr: "id",
        displayExpr: "union_destiny",
        searchEnabled: true,
    }).dxSelectBox('instance');
    
    cmbServiceGroup.on("selectionChanged", function (itemData) {
        if (itemData.selectedItem !== null) {
            clsGenerales_.mtdLlenarComponetTipos("../../api/v1/destiny/destinys/type/" + itemData.selectedItem.type_id, cmbDestinyGroup);

        }else{
            var_type_id = 0;
            clsGenerales_.fnComponetInstanceSetValue(cmbDestinyGroup, null);
        }
    }); 

    cmbServiceGroup.option({readOnly: true});
    cmbDestinyGroup.option({readOnly: true});

     btnCancelarGroup.addEventListener('click', btnCancelarGroupsPassangerClick);
    function btnCancelarGroupsPassangerClick() {    
        $(modalDetailGroupsPassanger).modal("hide");   
        clsGenerales_.fnComponetInstanceSetValue(cmbServiceGroup, null);
        clsGenerales_.fnComponetInstanceSetValue(cmbDestinyGroup, null);
        clearInputsGroup();       
    }

    function clearInputsGroup() {           
        
        clsGenerales_.fnNumberSetValue(txtPassengerMinGroup, 0);
        clsGenerales_.fnNumberSetValue(txtPassengerMaxGroup, 0);
        clsGenerales_.fnNumberSetValue(txtPriceGroup, 0);
        clsGenerales_.fnNumberSetValue(txtAdditionalGroup, 0);
        txtNotesGroup.value = null;    
        
    }

    var selectIdGroupsPassanger = 0;

    var grdDatosGroupsPassanger = $("#grdDatosGroupsPassanger").dxDataGrid({
        columns: [{
            dataField: 'id',
            visible: false
        }, {
            dataField: 'passenger_min',
            caption: 'Pass min'
        },{
            dataField: 'passenger_max',
            caption: 'Pass max'
        },{
            dataField: 'price',
            dataType: 'number',
            format: {
                type: "currency",
                precision: 2
            },
            alignment: 'right',
        }, {
            dataField: 'additional',
            dataType: 'number',
            format: {
                type: "currency",
                precision: 2
            },
            alignment: 'right',
        }, "notes"],
        summary: {
            totalItems: [{
                column: "passenger_min",
                summaryType: "count",
                displayFormat: "{0}"
            }],
            groupItems: [{
                column: "passenger_min",
                summaryType: "count",
                displayFormat: "{0}",
            }]
        },
        onSelectionChanged: function(selectedItems) {
            if (selectedItems.selectedRowsData.length > 0) {
                selectIdGroupsPassanger = selectedItems.selectedRowsData[0].id;
            }
        }
    }).dxDataGrid("instance");    


    btnGuardarGroup.addEventListener('click', btnGuardarGroupClick);
    function btnGuardarGroupClick(e) {
        e.preventDefault();


        if (clsGenerales_.fnComponetInstanceGetValue(txtPassengerMinGroup) == 0) {
            clsGenerales_.mtdMostrarMensaje("enter a minimum number of passengers", "error");
            txtPassengerMinGroup.focus();
            return;
        }

        if (clsGenerales_.fnComponetInstanceGetValue(txtPassengerMaxGroup) == 0) {
            clsGenerales_.mtdMostrarMensaje("enter a maximum number of passengers", "error");
            txtPassengerMinGroup.focus();
            return;
        }

        if (clsGenerales_.fnComponetInstanceGetValue(txtPassengerMinGroup) > clsGenerales_.fnComponetInstanceGetValue(txtPassengerMaxGroup)) {
            clsGenerales_.mtdMostrarMensaje("The minimum number of passengers cann't be greater than the maximum number of passengers.", "error");
            txtPassengerMaxGroup.focus();
            return;
        }

        if (clsGenerales_.fnComponetInstanceGetValue(txtPriceGroup) == 0) {
            clsGenerales_.mtdMostrarMensaje("enter a price", "error");
            txtPriceGroup.focus();
            return;
        }

        if (!validarPermiso(jsMenuGroupsPassanger.filter(menu => menu.opcion == "INSERT").length > 0)) { return; }

        
        clsGenerales_.mtdActivarLoad(btnGuardarGroup, "Saving...");

        $.ajax({
            url: "../../api/v1/unionServiceDestinyGroup/unionServiceDestinyGroups",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
            data: JSON.stringify({
                id: 0,
                service_destiny_union_id: selectId,
                passenger_min: clsGenerales_.fnComponetInstanceGetValue(txtPassengerMinGroup),
                passenger_max: clsGenerales_.fnComponetInstanceGetValue(txtPassengerMaxGroup),
                price: clsGenerales_.fnComponetInstanceGetValue(txtPriceGroup),
                additional: clsGenerales_.fnComponetInstanceGetValue(txtAdditionalGroup),
                notes: txtNotesGroup.value,
                active: true,
                id_user: clsGenerales_.obtenerDataUsuario().id
            }),
            error: function() {
                clsGenerales_.mtdDesactivarLoad(btnGuardarGroup, "Save");
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
            }
        }).done((resultado) => {

            clsGenerales_.mtdDesactivarLoad(btnGuardarGroup, "Save");

            if (resultado["state"] === 'ok') {
                clsGenerales_.mtdMostrarMensaje(resultado["message"]);

                clearInputsGroup();

                clsGenerales_.mtdLlamarDatosApi("../../api/v1/unionServiceDestinyGroup/unionServiceDestinyGroups/union/"+selectId,
                                grdDatosGroupsPassanger);
                        clsGenerales_.mtdOpionesGrid(grdDatosGroupsPassanger, true);                
               
            }
            if (resultado["state"] === 'ko') {
                clsGenerales_.mtdMostrarMensaje(resultado["message"], "error");
            }
        });

    }

    btnEliminarGroup.addEventListener('click', btnEliminarGroupClic);
    function btnEliminarGroupClic(e) {
        e.preventDefault();

        if (!validarPermiso(jsMenuGroupsPassanger.filter(menu => menu.opcion == "UPDATE").length > 0)) { return; }


        if (selectIdGroupsPassanger > 0) {

            $.ajax({
                url: "../../api/v1/unionServiceDestinyGroup/unionServiceDestinyGroups/" + selectIdGroupsPassanger,
                type: "GET",
                crossDomain: true,
                dataType: 'json',
                headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                error: function() {
                    clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
                }
            }).done((respuestaGroup) => {

                var confirm = DevExpress.ui.dialog.confirm("<i>Are you sure you want to delete the record?</i>", "Delete record");

                confirm.done((dialogResult) => {
                    if (dialogResult) {

                        clsGenerales_.mtdActivarLoad(btnEliminarGroup, "deleting...");

                        $.ajax({
                            url: "../../api/v1/unionServiceDestinyGroup/unionServiceDestinyGroups/"+ selectIdGroupsPassanger,
                            type: "PUT",
                            crossDomain: true,
                            dataType: 'json',
                            headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                            data: JSON.stringify({
                                id: respuestaGroup["data"][0].id,
                                service_destiny_union_id: respuestaGroup["data"][0].service_destiny_union_id,
                                passenger_min: respuestaGroup["data"][0].passenger_min,
                                passenger_max: respuestaGroup["data"][0].passenger_max,
                                price: respuestaGroup["data"][0].price,
                                additional: respuestaGroup["data"][0].additional,
                                notes: respuestaGroup["data"][0].notes,
                                active: false,
                                id_user: clsGenerales_.obtenerDataUsuario().id
                            }),
                            error: function() {
                                clsGenerales_.mtdDesactivarLoad(btnEliminarGroup, "Delete");
                                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
                            }
                        }).done((resultado) => {

                            clsGenerales_.mtdDesactivarLoad(btnEliminarGroup, "Delete");
                            
                            if (resultado["state"] === 'ok') {
                                clsGenerales_.mtdMostrarMensaje(resultado["message"]);

                                clearInputsGroup();

                                clsGenerales_.mtdLlamarDatosApi("../../api/v1/unionServiceDestinyGroup/unionServiceDestinyGroups/union/"+selectId,
                                                grdDatosGroupsPassanger);
                                        clsGenerales_.mtdOpionesGrid(grdDatosGroupsPassanger, true);                
                            
                            }
                            if (resultado["state"] === 'ko') {
                                clsGenerales_.mtdMostrarMensaje(resultado["message"], "error");
                            }
                        });
                    }
                });
            });
        }else {
            clsGenerales_.mtdMostrarMensaje("Select a record", "error");
            return;
        }

    }

    //#endregion GroupsPassanger


});