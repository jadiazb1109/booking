import { clsGenerales } from './_generales.js';

document.addEventListener('DOMContentLoaded', () => {

    const clsGenerales_ = new clsGenerales();

    var txtPagina = document.getElementById('txtPagina').value;
    var txtCodigoMenu = document.getElementById('txtCodigoMenu').value;    

    const btnGuardar = document.getElementById('btnGuardar');
    const btnConsultar = document.getElementById('btnConsultar');

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

        jsMenu = respuesta["datos"];
        if (jsMenu.filter(menu => menu.opcion == "VIEW").length > 0) {$(btnConsultar).show();}
        if (jsMenu.filter(menu => menu.opcion == "INSERT").length > 0) {$(btnGuardar).show();}

    });

    //#endregion permisos
    
    //#region principal
    var grdDatos = $("#grdDatos").dxDataGrid({
        columns: [
            {
                dataField: "id",
                visible: false
            }, {
                dataField: "id_tercero",
                visible: false
            },{
                dataField: "seleccion",
                dataType: "boolean"
            },"usuario","tipo_identificacion","numero_identificacion","nombres","correo",
            {
                dataField: "activo",
                dataType: "boolean"
            }
        ],
        summary: {
            totalItems: [{
                column: "usuario",
                summaryType: "count",
                displayFormat: "{0}"
            }],
            groupItems: [{
                column: "usuario",
                summaryType: "count",
                displayFormat: "{0}",
            }]
        },
    }).dxDataGrid("instance");
    clsGenerales_.mtdOpionesGridRol(grdDatos, false);

    const cmbRoles = $('#cmbRoles').dxSelectBox({
        placeholder: 'Seleccione una opcion',
        valueExpr: "id",
        displayExpr: "descripcion",
        noDataText: "No hay datos que mostrar",
        searchEnabled: true,
        onValueChanged(data) {
            if (data.value !== null) {
                
                $.ajax({
                    url: "../../api/v1/usuario/usuariosAsignacionRol/"+ data.value,
                    type: "GET",
                    crossDomain: true,
                    dataType: 'json',
                    headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                    error: function() { 
                        clsGenerales_.mtdMostrarMensaje("No se pudo completar la solicitud al servidor", "warning"); 
                    }
                }).done((resultado) => {
                    grdDatos.option({
                        dataSource: resultado["datos"]
                    });                    
                    if (resultado["estado"] === 'ko') {
                        clsGenerales_.mtdMostrarMensaje(resultado["mensaje"], "error");
                    }
                });

            } else { 
            
            }
        }
    }).dxSelectBox('instance');

    clsGenerales_.mtdLlenarComponetTipos("../../api/v1/rol/rolesActive", cmbRoles);

    grdDatos.on("editingStart", (options) => {

        if (options.column.index == 0) {options.cancel = true;}
        if (options.column.index == 1) {options.cancel = true;}
        if (options.column.index == 3) {options.cancel = true;}
        if (options.column.index == 4) {options.cancel = true;}
        if (options.column.index == 5) {options.cancel = true;}
        if (options.column.index == 6) {options.cancel = true;}
        if (options.column.index == 7) {options.cancel = true;}
        if (options.column.index == 8) {options.cancel = true;}
        
    });
    
    btnGuardar.addEventListener('click', btnGuardarClick);

    function btnGuardarClick(e) {
        e.preventDefault();   
        
        if (!clsGenerales_.fnComponetInstanceGetValue(cmbRoles)) {
            clsGenerales_.mtdMostrarMensaje("Selecciona un rol", "error");
            cmbRoles.focus();
            return;
        }

        if (!validarPermiso(jsMenu.filter(menu => menu.opcion == "INSERT").length > 0)) { return; }

        var confirm = DevExpress.ui.dialog.confirm("<i>Seguro que desea asignar los usuarios al rol</i>", "¿Desea asignar?");

        confirm.done((dialogResult) => {
            if (dialogResult) {

                clsGenerales_.mtdActivarLoad(btnGuardar, "saving...");

                $.ajax({
                    url: "../api/v1/usuario/usuariosAsignacionRol/"+ clsGenerales_.fnComponetInstanceGetValue(cmbRoles),
                    type: "PUT",
                    dataType: 'json',
                    crossDomain: true,
                    headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                    data: JSON.stringify({
                        id_rol: clsGenerales_.fnComponetInstanceGetValue(cmbRoles),
                        js_usuarios: grdDatos.getDataSource().items(),
                        id_usuario: clsGenerales_.obtenerDataUsuario().id
                    }),
                    error: function () {
                        clsGenerales_.mtdDesactivarLoad(btnGuardar, "Save");
                        clsGenerales_.mtdMostrarMensaje("No se pudo completar la solicitud al servidor", "warning");
                    },
                }).done((respuesta) => {

                    clsGenerales_.mtdDesactivarLoad(btnGuardar, "Save");

                    if (respuesta["estado"] === 'ok') {
                        clsGenerales_.mtdMostrarMensaje(respuesta["mensaje"]);
                    }
                    if (respuesta["estado"] === 'ko') {
                        clsGenerales_.mtdMostrarMensaje(respuesta["mensaje"], "error");
                    }
                });
            }
        });        
    }

    function validarPermiso(EstadoPermiso) {
        if (!EstadoPermiso) {
            clsGenerales_.mtdMostrarMensaje("No tienes permisos para utilizar esta opcion", "warning");
        }
        return EstadoPermiso;
    }

    //#endregion principal

    //#region modal detalle

    var grdDatosDetalle = $("#grdDatosDetalle").dxDataGrid({
        columns: [
            {
                dataField: "id",
                visible: false
            }, {
                dataField: "id_tercero",
                visible: false
            },{
                dataField: "usuario",
                groupIndex: 0,

            },"rol","tipo_identificacion","numero_identificacion","nombres","correo",
            {
                dataField: "activo",
                dataType: "boolean"
            }
        ],
        summary: {
            totalItems: [{
                column: "rol",
                summaryType: "count",
                displayFormat: "{0}"
            }],
            groupItems: [{
                column: "rol",
                summaryType: "count",
                displayFormat: "{0}",
            }]
        },
    }).dxDataGrid("instance");   


    const modalDetail = document.getElementById('modalDetail');
    const modalDetailLabel = document.getElementById('modalDetailLabel');

    const btnCancelar = document.getElementById('btnCancelar');

    btnCancelar.addEventListener('click', btnCancelarClick);

    function btnCancelarClick() {

        $(modalDetail).modal("hide");    
        grdDatosDetalle.option({
            dataSource: []
        });  
    }

    btnConsultar.addEventListener('click', btnConsultarClick);

    function btnConsultarClick(e) {
        e.preventDefault();

        modalDetailLabel.innerHTML = "Consult roles for users.";        
        
        if (!validarPermiso(jsMenu.filter(menu => menu.opcion == "VIEW").length > 0)) { return; }
        $(modalDetail).modal("show");

        $.ajax({
            url: "../../api/v1/usuario/usuariosAsignacionRol",
            type: "GET",
            crossDomain: true,
            dataType: 'json',
            headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
            error: function() { 
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning"); 
            }
        }).done((resultado) => {
            grdDatosDetalle.option({
                dataSource: resultado["data"]
            });                    
            if (resultado["state"] === 'ko') {
                clsGenerales_.mtdMostrarMensaje(resultado["message"], "error");
            }
            clsGenerales_.mtdOpionesGrid(grdDatosDetalle, true);
        });
        


    }

    //#endregion modal detalle
});