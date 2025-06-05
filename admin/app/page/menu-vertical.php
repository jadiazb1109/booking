    <aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="home" class="navbar-brand">                
                <!--Logo start-->
                <div class="logo-main">
                    <div class="logo-normal">
                        <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                            <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                        </svg>
                    </div>
                    <div class="logo-mini">
                        <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                            <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
                <!--logo End-->
                <h4 class="logo-title">ORBE </h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="form-group row d-none"><label class="col-sm-2 col-form-label">pagina</label>
            <div class="col-sm-10"><input type="text" class="form-control" id="txtPagina" value="<?php echo $pagina ?>"></div>
        </div>
        <div class="form-group row d-none"><label class="col-sm-2 col-form-label">codigo</label>
            <div class="col-sm-10"><input type="text" class="form-control" id="txtCodigoMenu" value="<?php echo $codigoMenu ?>"></div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" >
                            <span class="default-icon">Modules</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <li class="nav-item" id="md_1" style="display: none;">
                        <a class="nav-link " aria-current="page" id="mdBtnConfiguracion">
                            <i class="fa-solid fa-layer-group"></i>
                            <span class="item-name">Configuration</span>
                        </a>
                    </li>
                    <li class="nav-item" id="md_2" style="display: none;">
                        <a class="nav-link " aria-current="page" id="mdBtnControlFactura">
                            <i class="fa-solid fa-layer-group"></i>
                            <span class="item-name">Booking</span>
                        </a>
                    </li>
                    <li class="nav-item" id="md_3" style="display: none;">
                        <a class="nav-link " aria-current="page" id="mdBtnInventario">
                            <i class="fa-solid fa-layer-group"></i>
                            <span class="item-name">Inventario</span>
                        </a>
                    </li>
                    <li><hr class="hr-horizontal"></li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" >
                            <span class="default-icon">Menu</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <div id="mnConfiguration" style="display: none;">
                        <li class="nav-item" id="mmp_1" style="display: none;">
                            <a class="nav-link" id="mma_1" data-bs-toggle="collapse" href="#mmau_1" role="button" aria-expanded="false" aria-controls="sidebar-user">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">General</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="mmau_1" data-bs-parent="#sidebar-menu">
                                <li class="nav-item" id="mm_2" style="display: none;">
                                    <a class="nav-link" id="mma_2" href="type-identification">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Type identification</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item" id="mm_7" style="display: none;">
                            <a class="nav-link" id="mma_7" href="third-parties">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Terceros</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_10" style="display: none;">
                            <a class="nav-link" id="mma_10" href="supplier">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Proveedores</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_11" style="display: none;">
                            <a class="nav-link" id="mma_11" href="employee">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Empleados</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_12" style="display: none;">
                            <a class="nav-link" id="mma_12" href="user">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Usuarios</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_29" style="display: none;">
                            <a class="nav-link" id="mma_29" href="user-rol">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Asignar roles</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_31" style="display: none;">
                            <a class="nav-link" id="mma_31" href="user-agency">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Asignar Agencias</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_5" style="display: none;">
                            <a class="nav-link" id="mma_5" href="role">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Roles</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_41" style="display: none;">
                            <a class="nav-link" id="mma_41" href="role-menu">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Assign permissions</span>
                            </a>
                        </li>                        
                    </div>
                    <div id="mnBooking" style="display: none;">
                        <li class="nav-item" id="mmp_21" style="display: none;">
                            <a class="nav-link" id="mma_21" data-bs-toggle="collapse" href="#mmau_21" role="button" aria-expanded="false" aria-controls="sidebar-user">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Configuration</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="mmau_21" data-bs-parent="#sidebar-menu">
                                <li class="nav-item" id="mm_22" style="display: none;">
                                    <a class="nav-link" id="mma_22" href="origin">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Origins</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_23" style="display: none;">
                                    <a class="nav-link" id="mma_23" href="service">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Services</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_24" style="display: none;">
                                    <a class="nav-link" id="mma_24" href="origin-service-union">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Union services</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_25" style="display: none;">
                                    <a class="nav-link" id="mma_25" href="Destiny">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Destinys</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_26" style="display: none;">
                                    <a class="nav-link" id="mma_26" href="service-destiny-union">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Union destinys</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item" id="mm_37" style="display: none;">
                            <a class="nav-link" id="mma_37" href="booking">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Booking</span>
                            </a>
                        </li>
                    </div>
                    <div id="mnInventario" style="display: none;">
                        <li class="nav-item" id="mmp_43" style="display: none;">
                            <a class="nav-link" id="mma_43" data-bs-toggle="collapse" href="#mmau_43" role="button" aria-expanded="false" aria-controls="sidebar-user">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Configuración</span>
                                <i class="right-icon">
                                    <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="mmau_43" data-bs-parent="#sidebar-menu">
                                <li class="nav-item" id="mm_44" style="display: none;">
                                    <a class="nav-link" id="mma_44" href="inventory-business-unit">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Unidades comercial</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_45" style="display: none;">
                                    <a class="nav-link" id="mma_45" href="inventory-category">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Categorias</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_46" style="display: none;">
                                    <a class="nav-link" id="mma_46" href="inventory-subcategory">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Subcategorias</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_49" style="display: none;">
                                    <a class="nav-link" id="mma_49" href="inventory-category-sub-union">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Union Subcategorias</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_47" style="display: none;">
                                    <a class="nav-link" id="mma_47" href="inventory-storehouse">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Almacenes</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_48" style="display: none;">
                                    <a class="nav-link" id="mma_48" href="inventory-warehouse">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Bodegas</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_50" style="display: none;">
                                    <a class="nav-link" id="mma_50" href="inventory-storehouse-warehouse-union">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Bodegas Agencias</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="mm_51" style="display: none;">
                                    <a class="nav-link" id="mma_51" href="user-warehouse">
                                        <i class="fa-solid fa-angles-right"></i>
                                        <span class="item-name">Asignar bodegas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item" id="mm_52" style="display: none;">
                            <a class="nav-link" id="mma_52" href="inventory-product">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Productos</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_53" style="display: none;">
                            <a class="nav-link" id="mma_53" href="inventory-move-input">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Entradas</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_54" style="display: none;">
                            <a class="nav-link" id="mma_54" href="inventory-move-output">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Salidas</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_55" style="display: none;">
                            <a class="nav-link" id="mma_55" href="inventory-move-setting-input">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Ajuste de entrada</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_56" style="display: none;">
                            <a class="nav-link" id="mma_56" href="inventory-move-setting-output">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Ajuste de salida</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_58" style="display: none;">
                            <a class="nav-link" id="mma_58" href="inventory-move-transfer-output">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Traslados</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_59" style="display: none;">
                            <a class="nav-link" id="mma_59" href="inventory-move-transfer-input">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">En transito</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_60" style="display: none;">
                            <a class="nav-link" id="mma_60" href="inventory-move-transfer-return">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">En devolucion</span>
                            </a>
                        </li>
                        <li class="nav-item" id="mm_57" style="display: none;">
                            <a class="nav-link" id="mma_57" href="inventory-move-kardex">
                                <i class="fa-solid fa-share"></i>
                                <span class="item-name">Kardex</span>
                            </a>
                        </li>
                    </div>
                    <li><hr class="hr-horizontal"></li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" >
                            <span class="default-icon"></span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                </ul>
                <!-- Sidebar Menu End -->        
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>