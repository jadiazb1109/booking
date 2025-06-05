import { clsGenerales } from './_generales.js';

document.addEventListener('DOMContentLoaded', () => {

    const clsGenerales_ = new clsGenerales();

    var txtPagina = document.getElementById('txtPagina').value;
    var txtCodigoMenu = document.getElementById('txtCodigoMenu').value;
    
    const btnGuardar = document.getElementById('btnGuardar');
    const btnExportar = document.getElementById('btnExportar');

    btnGuardar.addEventListener('click', btnGuardarClick);
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
        if (jsMenu.filter(menu => menu.opcion == "INSERT").length > 0) {$(btnGuardar).show();}
        if (jsMenu.filter(menu => menu.opcion == "PRINT").length > 0) {$(btnExportar).show();}

    });

    //#endregion permisos

    //#region principal
    

    var grdDatos = $("#grdDatos").dxDataGrid({
        columns: [
            {
                dataField: "id",
                visible: false
            },{
                dataField: "menu_option"
            },"option"
        ],
        summary: {
            totalItems: [{
                column: "option",
                summaryType: "count",
                displayFormat: "{0}"
            }],
            groupItems: [{
                column: "option",
                summaryType: "count",
                displayFormat: "{0}",
            }]
        },
    }).dxDataGrid("instance");

    clsGenerales_.mtdOpionesGridRolAsignacion(grdDatos, false);
    
    const cmbRoles = $('#cmbRoles').dxSelectBox({
        placeholder: 'Select a option',
        valueExpr: "id",
        displayExpr: "name",
        noDataText: "No data to display",
        searchEnabled: true,
        onValueChanged(data) {
            if (data.value !== null) {
                grdDatos.clearSelection(); 
                $.ajax({
                    url: "../../api/v1/rol/roles/asignation/menu/"+ data.value,
                    type: "GET",
                    crossDomain: true,
                    dataType: 'json',
                    headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                    error: function() { 
                        clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning"); 
                    }
                }).done((resultado) => {
                    let jsDatosMenu = resultado["data"];
                    grdDatos.option({
                        dataSource: resultado["data"]
                    });       
                    grdDatos.selectRows(jsDatosMenu.filter(menu => menu.asignation > 0).map(function(asignation){return asignation.id;}), true); 
                    if (resultado["state"] === 'ko') {
                        clsGenerales_.mtdMostrarMensaje(resultado["message"], "error");
                    }
                });

            } else { 
            
            }
        }
    }).dxSelectBox('instance');    
    
    clsGenerales_.mtdLlenarComponetTipos("../../api/v1/rol/rolesActive", cmbRoles);

    function btnGuardarClick(e) {
        e.preventDefault();   
        
        if (!clsGenerales_.fnComponetInstanceGetValue(cmbRoles)) {
            clsGenerales_.mtdMostrarMensaje("Select a rol", "error");
            cmbRoles.focus();
            return;
        }

        if (!validarPermiso(jsMenu.filter(menu => menu.opcion == "INSERT").length > 0)) { return; }

        var confirm = DevExpress.ui.dialog.confirm("<i>You'll want to assign the options to the role.</i>", "¿You want to assign?");

        confirm.done((dialogResult) => {
            if (dialogResult) {

                clsGenerales_.mtdActivarLoad(btnGuardar, "saving...");

                $.ajax({
                    url: "../../api/v1/rol/roles/asignation/menu/"+ clsGenerales_.fnComponetInstanceGetValue(cmbRoles),
                    type: "PUT",
                    dataType: 'json',
                    crossDomain: true,
                    headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                    data: JSON.stringify({
                        id_rol: clsGenerales_.fnComponetInstanceGetValue(cmbRoles),
                        js_permisos: grdDatos.getSelectedRowsData(),
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
                    }
                    if (respuesta["state"] === 'ko') {
                        clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
                    }
                });
            }
        });        
    }

    function btnExportarClick(e) {
        e.preventDefault();  
        
        if (!clsGenerales_.fnComponetInstanceGetValue(cmbRoles)) {
            clsGenerales_.mtdMostrarMensaje("Select a rol", "error");
            cmbRoles.focus();
            return;
        }

        if (this.id == "btnExportar" && validarPermiso(jsMenu.filter(menu => menu.opcion == "PRINT").length > 0)) {
            clsGenerales_.mtdGridExportar(grdDatos, "Permisos_ROL_"+ cmbRoles.option("text") +"_" + clsGenerales_.fnFechaHoraActual(), txtPagina.toUpperCase()); 
        }
    }

    function validarPermiso(EstadoPermiso) {
        if (!EstadoPermiso) {
            clsGenerales_.mtdMostrarMensaje("You do not have permission to use this option.", "warning");
        }
        return EstadoPermiso;
    }

    //#endregion principal

});