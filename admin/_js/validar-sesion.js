import { clsGenerales } from './_generales.js';

document.addEventListener('DOMContentLoaded', () => {

    const clsGenerales_ = new clsGenerales();

    //variable tomada de menu-horizontal.php
    const txtNombreUsuario = document.getElementById('txtNombreUsuario');
    const txtNombreUsuarioCargo = document.getElementById('txtNombreUsuarioCargo');
    const uplAvatarG = document.getElementById('uplAvatarG');

    //#region personalizacion

    const sidebarColorDefault = document.getElementById('sidebarColorDefault');
    const sidebarColorOscuro = document.getElementById('sidebarColorOscuro');
    const sidebarColorColor = document.getElementById('sidebarColorColor');
    const sidebarColorTransparente = document.getElementById('sidebarColorTransparente');

    sidebarColorDefault.addEventListener('click', sidebarColorClick); 
    sidebarColorOscuro.addEventListener('click', sidebarColorClick);
    sidebarColorColor.addEventListener('click', sidebarColorClick);
    sidebarColorTransparente.addEventListener('click', sidebarColorClick);

    function sidebarColorClick(e) {
        e.preventDefault();

        var sidebarColor = "sidebar-white";

        if (this.id == "sidebarColorDefault") {
            sidebarColor = "sidebar-white";
        }
        if (this.id == "sidebarColorOscuro") {
            sidebarColor = "sidebar-dark";
        }
        if (this.id == "sidebarColorColor") {
            sidebarColor = "sidebar-color";
        }
        if (this.id == "sidebarColorTransparente") {
            sidebarColor = "sidebar-transparent";
        }
        
        $.ajax({
            url: "../../api/v1/user/usersUpdateSidebarColor/"+ clsGenerales_.obtenerDataUsuario().id,
            type: "PUT",
            dataType: 'json',
            crossDomain: true,
            headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
            data: JSON.stringify({
                sidebar_color: sidebarColor,
                id_usuario: clsGenerales_.obtenerDataUsuario().id
            }),
            error: function () {
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
            },
        }).done((respuesta) => {
            
        });
    }

    const themeColorDefault = document.getElementById('themeColorDefault');
    const themeColorBlue = document.getElementById('themeColorBlue');
    const themeColorGray = document.getElementById('themeColorGray');
    const themeColorRed = document.getElementById('themeColorRed');
    const themeColorYellow = document.getElementById('themeColorYellow');
    const themeColorPink = document.getElementById('themeColorPink');

    themeColorDefault.addEventListener('click', themeColorClick); 
    themeColorBlue.addEventListener('click', themeColorClick);
    themeColorGray.addEventListener('click', themeColorClick);
    themeColorRed.addEventListener('click', themeColorClick);
    themeColorYellow.addEventListener('click', themeColorClick);
    themeColorPink.addEventListener('click', themeColorClick);

    function themeColorClick(e) {
        e.preventDefault();

        var themeColor = "theme-color-default";

        if (this.id == "themeColorDefault") {
            themeColor = "theme-color-default";
        }
        if (this.id == "themeColorBlue") {
            themeColor = "theme-color-blue";
        }
        if (this.id == "themeColorGray") {
            themeColor = "theme-color-gray";
        }
        if (this.id == "themeColorRed") {
            themeColor = "theme-color-red";
        }
        if (this.id == "themeColorYellow") {
            themeColor = "theme-color-yellow";
        }
        if (this.id == "themeColorPink") {
            themeColor = "theme-color-pink";
        }
        
        $.ajax({
            url: "../../api/v1/user/usersUpdateThemeColor/"+ clsGenerales_.obtenerDataUsuario().id,
            type: "PUT",
            dataType: 'json',
            crossDomain: true,
            headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
            data: JSON.stringify({
                theme_color: themeColor,
                id_usuario: clsGenerales_.obtenerDataUsuario().id
            }),
            error: function () {
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
            },
        }).done((respuesta) => {
            
        });
    }

    //#endregion personalizacion

    if (!localStorage.getItem("USER") || !localStorage.getItem("API_KEY")) {
        btnCerrarSesionClick();
    } else {

        $.ajax({
            url: "../../api/v1/general/validateToken/" + clsGenerales_.obtenerAPI_KEY(),
            type: "GET",
            crossDomain: true,
            dataType: 'json',
            error: function () {                 
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server.", "warning"); 
            }
        }).done((respuesta) => {

            if (respuesta["state"] === 'ko') {
                btnCerrarSesionClick();
            }else{

                let dirAvatar = "../assets/images/avatars/";
                $.ajax({
                    url: "../../api/v1/user/users/" + clsGenerales_.obtenerDataUsuario().id,
                    type: "GET",
                    crossDomain: true,
                    dataType: 'json',
                    headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                    error: function () { clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning"); }
                }).done((respuesta) => {

                    if (respuesta["state"] === 'ok') {

                        if (respuesta["data"][0].active == 1) {

                            txtNombreUsuario.innerHTML = clsGenerales_.toFristUpperCase(respuesta["data"][0].people) + " " + '                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.75 12C2.75 17.108 6.891 21.25 12 21.25C17.108 21.25 21.25 17.108 21.25 12C21.25 6.892 17.108 2.75 12 2.75C6.891 2.75 2.75 6.892 2.75 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M8.52832 10.5576L11.9993 14.0436L15.4703 10.5576" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                </svg>                            ';
                            uplAvatarG.src = dirAvatar + respuesta["data"][0].image;

                            sidebarColorDefault.classList.remove("active");
                            sidebarColorOscuro.classList.remove("active");
                            sidebarColorColor.classList.remove("active");
                            sidebarColorTransparente.classList.remove("active");

                            if(respuesta["data"][0].sidebar_color){
                                if(respuesta["data"][0].sidebar_color == "sidebar-white"){
                                    sessionStorage.setItem("sidebar", "sidebar-white");
                                    sidebarColorDefault.classList.add("active");
                                    sidebarColorDefault.setAttribute('data-value', 'sidebar-white');
                                }
                                if(respuesta["data"][0].sidebar_color == "sidebar-dark"){
                                    sessionStorage.setItem("sidebar", "sidebar-dark");
                                    sidebarColorOscuro.classList.add("active");
                                    sidebarColorOscuro.setAttribute('data-value', 'sidebar-dark');
                                }
                                if(respuesta["data"][0].sidebar_color == "sidebar-color"){
                                    sessionStorage.setItem("sidebar", "sidebar-color");
                                    sidebarColorColor.classList.add("active");
                                    sidebarColorColor.setAttribute('data-value', 'sidebar-color');
                                }
                                if(respuesta["data"][0].sidebar_color == "sidebar-transparent"){
                                    sessionStorage.setItem("sidebar", "sidebar-transparent");
                                    sidebarColorTransparente.classList.add("active");
                                    sidebarColorTransparente.setAttribute('data-value', 'sidebar-transparent');
                                }
                            }else{
                                sessionStorage.setItem("sidebar", "sidebar-white");
                                sidebarColorDefault.classList.add("active");
                                sidebarColorDefault.setAttribute('data-value', 'sidebar-white');
                            } 

                            themeColorDefault.classList.remove("active");
                            themeColorBlue.classList.remove("active");
                            themeColorGray.classList.remove("active");
                            themeColorRed.classList.remove("active");
                            themeColorYellow.classList.remove("active");
                            themeColorPink.classList.remove("active");
                            
                            if(respuesta["data"][0].theme_color){
                                if(respuesta["data"][0].theme_color == "theme-color-default"){                                
                                    sessionStorage.setItem("colorcustomchart-mode", "#3a57e8");
                                    sessionStorage.setItem("colorcustom-mode", "theme-color-default");
                                    sessionStorage.setItem("colorcustominfo-mode", "#079aa2");
                                    themeColorDefault.classList.add("active");
                                    themeColorDefault.setAttribute('data-value', respuesta["data"][0].theme_color);
                                    themeColorDefault.setAttribute('data-info', "#079aa2");
                                }
                                if(respuesta["data"][0].theme_color == "theme-color-blue"){
                                    sessionStorage.setItem("colorcustomchart-mode", "#00C3F9");
                                    sessionStorage.setItem("colorcustom-mode", "theme-color-blue");
                                    sessionStorage.setItem("colorcustominfo-mode", "#573BFF");
                                    themeColorBlue.classList.add("active");
                                    themeColorBlue.setAttribute('data-value', respuesta["data"][0].theme_color);
                                    themeColorDefault.setAttribute('data-info', "#573BFF");
                                }
                                if(respuesta["data"][0].theme_color == "theme-color-gray"){
                                    sessionStorage.setItem("colorcustomchart-mode", "#91969E");
                                    sessionStorage.setItem("colorcustom-mode", "theme-color-gray");
                                    sessionStorage.setItem("colorcustominfo-mode", "#FD8D00");
                                    themeColorGray.classList.add("active");
                                    themeColorGray.setAttribute('data-value', respuesta["data"][0].theme_color);
                                    themeColorDefault.setAttribute('data-info', "#FD8D00");
                                }
                                if(respuesta["data"][0].theme_color == "theme-color-red"){
                                    sessionStorage.setItem("colorcustomchart-mode", "#DB5363");
                                    sessionStorage.setItem("colorcustom-mode", "theme-color-red");
                                    sessionStorage.setItem("colorcustominfo-mode", "#366AF0");
                                    themeColorRed.classList.add("active");
                                    themeColorRed.setAttribute('data-value', respuesta["data"][0].theme_color);
                                    themeColorDefault.setAttribute('data-info', "#366AF0");
                                }
                                if(respuesta["data"][0].theme_color == "theme-color-yellow"){
                                    sessionStorage.setItem("colorcustomchart-mode", "#EA6A12");
                                    sessionStorage.setItem("colorcustom-mode", "theme-color-yellow");
                                    sessionStorage.setItem("colorcustominfo-mode", "#6410F1");
                                    themeColorYellow.classList.add("active");
                                    themeColorYellow.setAttribute('data-value', respuesta["data"][0].theme_color);
                                    themeColorDefault.setAttribute('data-info', "#6410F1");
                                }
                                if(respuesta["data"][0].theme_color == "theme-color-pink"){
                                    sessionStorage.setItem("colorcustomchart-mode", "#E586B3");
                                    sessionStorage.setItem("colorcustom-mode", "theme-color-pink");
                                    sessionStorage.setItem("colorcustominfo-mode", "#25C799");
                                    themeColorPink.classList.add("active");
                                    themeColorPink.setAttribute('data-value', respuesta["data"][0].theme_color);
                                    themeColorDefault.setAttribute('data-info', "#25C799");
                                }
                            }else{
                                sessionStorage.setItem("colorcustomchart-mode", "#3a57e8");
                                    sessionStorage.setItem("colorcustom-mode", "theme-color-default");
                                    sessionStorage.setItem("colorcustominfo-mode", "#079aa2");
                                    themeColorDefault.classList.add("active");
                                    themeColorDefault.setAttribute('data-value', respuesta["data"][0].theme_color);
                                    themeColorDefault.setAttribute('data-info', "#079aa2");
                            }

                            $.ajax({
                                url: "../../api/v1/rol/roles/modulesActive/user/" + clsGenerales_.obtenerDataUsuario().id,
                                type: "GET",
                                crossDomain: true,
                                dataType: 'json',
                                headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                                error: function () { clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning"); }
                            }).done((respuesta) => {
                        
                                dtModulos = respuesta["data"];
                                dtModulos.forEach((modulo) => {
                                    if (modulo.id_module == arrCodigos[0] && arrCodigos[0]  == 1) {
                                        mdBtnConfiguracion.classList.add("active");
                                        $('#mnConfiguration').show();
                                        $('#mnBooking').hide();
                                        $('#mnInventario').hide();
                                    }
                                    if (modulo.id_module == arrCodigos[0] && arrCodigos[0]  == 2) {
                                        mdBtnControlFactura.classList.add("active");
                                        $('#mnConfiguration').hide();
                                        $('#mnBooking').show();
                                        $('#mnInventario').hide();
                                    }
                                    if (modulo.id_module == arrCodigos[0] && arrCodigos[0]  == 3) {
                                        mdBtnInventario.classList.add("active");
                                        $('#mnConfiguration').hide();
                                        $('#mnBooking').hide();
                                        $('#mnInventario').show();
                                    }
                                    $('#md_' + modulo.id_module).show();
                                });
                        
                                $.ajax({
                                    url: "../../api/v1/rol/roles/menusActive/user/" + clsGenerales_.obtenerDataUsuario().id,
                                    type: "GET",
                                    crossDomain: true,
                                    dataType: 'json',
                                    headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                                    error: function () { clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning"); }
                                }).done((respuesta) => {
                            
                                    dtMenus = respuesta["data"];
                                    dtMenus.forEach((menu) => {
                                        if (menu.id_menu == arrCodigos[arrCodigos.length - 1]) {
                                            document.getElementById('mma_' + menu.id_menu).classList.add("active");
                                            if(menu.father > 0){
                                                $('#mma_' + menu.father).attr("aria-expanded","true");
                                                document.getElementById('mma_' + menu.father).classList.remove("collapsed");
                                                document.getElementById('mmau_' + menu.father).classList.add("show");
                                            }
                                        }
                                        if(menu.father > 0){
                                            $('#mmp_' + menu.father).show();
                                            $('#mm_a' + menu.id_menu).show();
                                        }
                        
                                        $('#mm_' + menu.id_menu).show();
                                    });

                                    if (txtCodigoMenu.value != "0" && dtMenus.filter(menu => menu.id_menu == arrCodigos[arrCodigos.length - 1]).length == 0) {
                                        localStorage.setItem("ACCESO_PAG", false);
                                        location.href = "home";
                    
                                    }
                            
                                    
                                });
                        
                        
                            });
                            
                        } else {
                            location.href = "login-locked";
                        }
                    }
                    if (respuesta["state"] === 'ko') {
                        clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
                    }
                });
            }
        });
    }

    const btnCerrarSesion = document.getElementById('btnCerrarSesion');
    btnCerrarSesion.addEventListener('click', btnCerrarSesionClick);

    function btnCerrarSesionClick() {

        localStorage.removeItem("USER");
        localStorage.removeItem("API_KEY");

        location.href = "../auth/sign-in";
    }


    //variable tomada de menu-vertical.php

    const mdBtnConfiguracion = document.getElementById('mdBtnConfiguracion');
    const mdBtnControlFactura = document.getElementById('mdBtnControlFactura');
    const mdBtnInventario = document.getElementById('mdBtnInventario');


    mdBtnConfiguracion.addEventListener('click', btnSeleccionarModuloClick);
    mdBtnControlFactura.addEventListener('click', btnSeleccionarModuloClick);
    mdBtnInventario.addEventListener('click', btnSeleccionarModuloClick);

    function btnSeleccionarModuloClick(e) {
        e.preventDefault();
        
        mdBtnConfiguracion.classList.remove("active");
        mdBtnControlFactura.classList.remove("active");   
        mdBtnInventario.classList.remove("active");             

        if (this.id == "mdBtnConfiguracion") {
            if (dtModulos.filter(modulo => modulo.id_module == 1).length == 0) {
                localStorage.setItem("ACCESO_PAG", false);
                location.href = "home";
    
            } else {
                mdBtnConfiguracion.classList.add("active");
                $('#mnConfiguration').show();
                $('#mnBooking').hide();
                $('#mnInventario').hide();
            }
        }
        if (this.id == "mdBtnControlFactura") {
            if (dtModulos.filter(modulo => modulo.id_module == 2).length == 0) {
                localStorage.setItem("ACCESO_PAG", false);
                location.href = "home";
    
            } else {
                mdBtnControlFactura.classList.add("active");
                $('#mnBooking').show();
                $('#mnConfiguration').hide();
                $('#mnInventario').hide();
            }
        }
        if (this.id == "mdBtnInventario") {
            if (dtModulos.filter(modulo => modulo.id_module == 2).length == 0) {
                localStorage.setItem("ACCESO_PAG", false);
                location.href = "home";
    
            } else {
                mdBtnInventario.classList.add("active");
                $('#mnBooking').hide();
                $('#mnConfiguration').hide();
                $('#mnInventario').show();
            }
        }

    }

    const txtPagina = document.getElementById('txtPagina');
    const txtCodigoMenu = document.getElementById('txtCodigoMenu');    

    var dtModulos;
    var dtMenus;
    var arrCodigos = txtCodigoMenu.value.split(',');  

    if (localStorage.getItem("ACCESO_PAG") == "false") {
        clsGenerales_.mtdMostrarMensaje("You do not have permission to access this page.", "warning");
        localStorage.setItem("ACCESO_PAG", true);
    }
        


});