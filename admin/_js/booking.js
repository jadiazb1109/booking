import { clsGenerales } from './_generales.js';

document.addEventListener('DOMContentLoaded', () => {

    const clsGenerales_ = new clsGenerales();

    var htmlButon = "";
    var selectId = 0;

    var txtPagina = document.getElementById('txtPagina').value;
    var txtCodigoMenu = document.getElementById('txtCodigoMenu').value;

     const btnActualizar = document.getElementById('btnActualizar');
    const btnExportar = document.getElementById('btnExportar');

    btnActualizar.addEventListener('click', reloadClic);
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
        if (jsMenu.filter(menu => menu.opcion == "PRINT").length > 0) {$(btnExportar).show();}

    });
   
    const dtFechaInicial = document.getElementById('dtFechaInicial');
    const dtFechaFinal = document.getElementById('dtFechaFinal');
    const btnGenerar = document.getElementById('btnGenerar');

    dtFechaInicial.value = clsGenerales_.fnFechaActual();
    dtFechaFinal.value = clsGenerales_.fnFechaActual();

    

    var grdDatos = $("#grdDatos").dxDataGrid({
        columns: [{
                dataField: "id",
                caption: "Number"
            },
            "date", "type",{
                dataField: "date_departure",
                caption: "Departure"
            }, {
                dataField: "pick_up_time_format",
                caption: "Pickup Time"
            }, "service", "destiny", "client_destiny", "return_date" ,"return_pick_up_time" ,"return_destiny","room_number","passengers" ,
            {
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
            },{
                dataField: 'pay',
                dataType: 'number',
                format: {
                    type: "currency",
                    precision: 2
                },
                alignment: 'right',
            }, "client_name", "client_phone_number", "client_email", "state"
        ],
        summary: {
            totalItems: [{
                column: "date_departure",
                summaryType: "count",
                displayFormat: "{0}"
            }],
            groupItems: [{
                column: "date_departure",
                summaryType: "count",
                displayFormat: "{0}",
            }]
        },
        onSelectionChanged: function(selectedItems) {
            selectId = selectedItems.selectedRowsData[0].id;
        }
    }).dxDataGrid("instance");

    reloadClic(false);

    btnGenerar.addEventListener('click', reloadClic);
    function reloadClic(cargar = true) {

        if (!dtFechaInicial.value) {
            clsGenerales_.mtdMostrarMensaje("Select start date","error");
            return;
        }
        if (!dtFechaFinal.value) {
            clsGenerales_.mtdMostrarMensaje("Select end date", "error");
            return;
        }

        if (dtFechaFinal.value < dtFechaInicial.value) {
            clsGenerales_.mtdMostrarMensaje("The end date can not be less than the start date", "error");
            return;
        }

         clsGenerales_.mtdOpionesGrid(grdDatos, cargar);
         htmlButon = 'Search';
         clsGenerales_.mtdActivarLoad(btnGenerar, "searching...");

        $.ajax({
            url: "../../api/v1/general/listBooking/type/date/"+ dtFechaInicial.value + "/" +dtFechaFinal.value,
            type: "GET",
            crossDomain: true,
            dataType: 'json',
            error: function() { 
                mtdMostrarMensaje("Could not complete request to server", "warning");  
                clsGenerales_.mtdDesactivarLoad(btnGenerar, htmlButon);
            }
        }).done((resultado) => {

            clsGenerales_.mtdDesactivarLoad(btnGenerar, htmlButon);
            if (resultado["state"] === 'ok') {
                grdDatos.option({ dataSource: resultado["data"] });
            }
            if (resultado["state"] === 'ko') {
                clsGenerales_.mtdMostrarMensaje(resultado["message"], "error");
            }
        });
    }

    function btnExportarClick(e) {
        e.preventDefault();      

        if (!grdDatos.getDataSource() || !grdDatos.getDataSource().items().length > 0) {
            clsGenerales_.mtdMostrarMensaje("No data to export", "error");
            return;
        }

        if (this.id == "btnExportar" && validarPermiso(jsMenu.filter(menu => menu.opcion == "PRINT").length > 0)) {
            clsGenerales_.mtdGridExportar(grdDatos, "BOOKING_s_"+ dtFechaInicial.value + "_e_" + dtFechaFinal.value + "_a_" + clsGenerales_.fnFechaHoraActual(), txtPagina.toUpperCase()); 
        }
    }

    function validarPermiso(EstadoPermiso) {
        if (!EstadoPermiso) {
            clsGenerales_.mtdMostrarMensaje("You do not have permission to use this option.", "warning");
        }
        return EstadoPermiso;
    }

});