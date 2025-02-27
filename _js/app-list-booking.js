document.addEventListener('DOMContentLoaded', () => {

   
    const dtFechaInicial = document.getElementById('dtFechaInicial');
    const dtFechaFinal = document.getElementById('dtFechaFinal');
    const btnGenerar = document.getElementById('btnGenerar');
    const btnExportar = document.getElementById('btnExportar');

    dtFechaInicial.value = fnFechaActual();
    dtFechaFinal.value = fnFechaActual();

    reloadClic();

    var grdDatos = $("#grdDatos").dxDataGrid({
        columns: [{
                dataField: "id",
                visible: false
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

    mtdOpionesGrid(grdDatos);

    btnGenerar.addEventListener('click', reloadClic);
    function reloadClic() {

        if (!dtFechaInicial.value) {
            mtdMostrarMensaje("Select start date","error");
            return;
        }
        if (!dtFechaFinal.value) {
            mtdMostrarMensaje("Select end date", "error");
            return;
        }

        if (dtFechaFinal.value < dtFechaInicial.value) {
            mtdMostrarMensaje("The end date can not be less than the start date", "error");
            return;
        }

        $.ajax({
            url: "api/v1/general/listBooking/type/date/"+ dtFechaInicial.value + "/" +dtFechaFinal.value,
            type: "GET",
            crossDomain: true,
            dataType: 'json',
            error: function() { 
                mtdMostrarMensaje("Could not complete request to server", "warning");               }
        }).done((resultado) => {
            if (resultado["state"] === 'ok') {
                if (resultado["data"].length == 0) {
                    mtdMostrarMensaje(resultado["message"], "warning"); 
                }
    
                grdDatos.option({ dataSource: resultado["data"] });
            }
            if (resultado["state"] === 'ko') {
                mtdMostrarMensaje(resultado["message"], "error");
            }
        });
    }

    btnExportar.addEventListener('click', btnExportarClick);
    function btnExportarClick(e) {
        e.preventDefault();      

        if (!grdDatos.getDataSource() || !grdDatos.getDataSource().items().length > 0) {
            mtdMostrarMensaje("No data to export", "error");
            return;
        }
        
        mtdGridExportar(grdDatos, "BOOKING_s_"+ dtFechaInicial.value + "_e_" + dtFechaFinal.value + "_a_" + fnFechaHoraActual(), "BOOKING"); 
    }

    function fnFechaActual() {
        var d = new Date();

        var dia = d.getDate();
        var mes = (d.getMonth() + 1);
        var anno = d.getFullYear();

        if (mes < 10) {
            mes = "0" + mes;
        }
        if (dia < 10) {
            dia = "0" + dia;
        }

        return anno + "-" + mes + "-" + dia;
    }

    function mtdMostrarMensaje(mensaje, tipo = "success", time = 3000) {

        let direction = "down-push";
        let position = "booton center";
    
        DevExpress.ui.notify({
            message: mensaje,
            width: 400,
            type: tipo,
            displayTime: time,
        }, {
            position,
            direction
        });
      }

    function mtdOpionesGrid(grdDatosInstancia, adaptarColumnas = true) {

        grdDatosInstancia.option({
            //filtro en cada columna
            headerFilter: {
                visible: true
            },
            filterRow: {
                visible: true,
                applyFilter: 'auto',
            },
            //Se activa al inicio cuando estan cargando los datos  
            loadPanel: {
                enabled: true,
            },
            //Oculta columnas dependiendo el tamaño
            columnHidingEnabled: adaptarColumnas,
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columnAutoWidth: true,
            //Dibuja la grid en la pagina
            showBorders: true,
            showColumnLines: true,
            showRowLines: true,
            //Permite agrupar columnas
            grouping: {
                contextMenuEnabled: true,
                allowCollapsing: true,
                autoExpandAll: false,
                expandMode: "rowClick",
            },
            //Activa el panel de busqueda
            searchPanel: {
                visible: true,
                highlightSearchText: true
            },
            //Activa el panel de agrupacion de colomna
            groupPanel: {
                visible: true
            },
            //Activa las opciones del paginador
            pager: {
                allowedPageSizes: [10, 30, 50, 100, 'all'],
                showNavigationButtons: true,
                showPageSizeSelector: true,
                visible: true,
                displayMode: "adaptive"
            },
            //Define el numero de registros por paginas
            paging: {
                pageSize: 10
            },
            //Permite seleccionar las columnas que aparecen en la Grid
            columnChooser: {
                search: {enabled: true},
                enabled: true,
            },
            sorting: {
                mode: "multiple",
                showSortIndexes: true
            },
            //Tipo de seleccion en la Grid
            selection: {
                mode: "single",
                deferred: false
            }
        });
    }

    function fnFechaHoraActual() {
        var d = new Date();

        var dia = d.getDate();
        var mes = (d.getMonth() + 1);
        var anno = d.getFullYear();

        var hora = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

        if (mes < 10) {
            mes = "0" + mes;
        }
        if (dia < 10) {
            dia = "0" + dia;
        }

        return anno + "-" + mes + "-" + dia + ' ' + hora;
    }

    function mtdGridExportar(grdDatosInstancia, nombreArchivo, nombreHoja = "") {

        var workbook = new ExcelJS.Workbook();
        var worksheet = workbook.addWorksheet(nombreHoja);

        DevExpress.excelExporter.exportDataGrid({
            component: grdDatosInstancia,
            worksheet: worksheet,
            autoFilterEnabled: true
        }).then(function() {
            workbook.xlsx.writeBuffer().then(function(buffer) {
                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), nombreArchivo + '.xlsx');
            });
        });
    }

});