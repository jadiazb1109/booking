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

    btnActualizar.addEventListener('click', btnActualizarClick);
    btnAdicionar.addEventListener('click', btnAccionClick);
    btnModificar.addEventListener('click', btnAccionClick);
    btnConsultar.addEventListener('click', btnAccionClick);
    btnExportar.addEventListener('click', btnExportarClick);

    var arrCodigos = txtCodigoMenu.split(',');
    var jsMenu = [];

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

    //#endregion permisos

    //#region principal

    var txtOpcion = "";
    var urlApi = "../../api/v1/origin/origins";

    var grdDatos = $("#grdDatos").dxDataGrid({
        columns: [
            {
                dataField: "id",
                visible: false
            }, "name", "address",
            {
                dataField: "notes",
                visible: false
            },
            {
                dataField: "active",
                dataType: "boolean"
            }
        ],
        summary: {
            totalItems: [{
                column: "name",
                summaryType: "count",
                displayFormat: "{0}"
            }],
            groupItems: [{
                column: "name",
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
           
        }

        if (this.id == "btnModificar" || this.id == "btnConsultar") {
            if (selectId > 0) {

                clsGenerales_.mtdActivarLoad(this, "");

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
                        txtDescripcion.value = resultado["data"][0].name;
                        txtAddress.value = resultado["data"][0].address;
                        txtNotes.value = resultado["data"][0].notes;
                        chkActivo.checked = resultado["data"][0].active ? true : false;
                        $(modalDetail).modal("show");
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
    const txtDescripcion = document.getElementById('txtDescripcion');
    const txtAddress = document.getElementById('txtAddress');
    const txtNotes = document.getElementById('txtNotes');
    const chkActivo = document.getElementById('chkActivo');
    const btnGuardar = document.getElementById('btnGuardar');
    const btnCancelar = document.getElementById('btnCancelar');


    btnGuardar.addEventListener('click', btnGuardarClick);
    btnCancelar.addEventListener('click', btnCancelarClick);

    function btnCancelarClick() {    
        $(modalDetail).modal("hide");    
        txtDescripcion.value = "";
        txtAddress.value = "";
        txtNotes.value = "";
        chkActivo.checked = true;        
    }

    function btnGuardarClick(e) {
        e.preventDefault();

        if (!txtDescripcion.value) {
            clsGenerales_.mtdMostrarMensaje("Enter a description", "error");
            txtDescripcion.focus();
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
                    name: txtDescripcion.value,
                    address: txtAddress.value,
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
                    
                    if (txtOpcion == "Adicionar") {
                        txtDescripcion.value = null;
                        txtAddress.value = null;
                        txtNotes.value = null;
                        chkActivo.checked = true;
                    }
                    
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

});