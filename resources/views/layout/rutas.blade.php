<ul class="nav metismenu" id="side-menu">
    <li class="nav-header">
        <div class="dropdown profile-element text-center">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img src="{{ asset('default.jpg') }}" style="display: block;
                                            margin: auto;
                                            width:70%;
                                            height: 80px;" alt="">
                <span class="block m-t-xs font-bold"> <img src="" alt="" width="60">{{ ' ' . auth()->user()->name }}
                </span>
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
        <div class="logo-element">
            <img src="{{ asset('img/header.jpg') }}" height="45" width="45">
        </div>
    </li>

    @if (auth()->user()->can('haveaccess', 'tipoEmpleado.index') ||
    auth()->user()->can('haveaccess', 'empleado.index') ||
    auth()->user()->can('haveaccess', 'roles.index') ||
    auth()->user()->can('haveaccess', 'api.index'))
        <li class="@yield('administracion-active')">
            <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Seguridad</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                @if (auth()->user()->can('haveaccess', 'tipoEmpleado.index'))
                    <li class="@yield('tipoempleado-active')"><a href="{{ route('tipoempleado.index') }}"><i
                                class="fa fa-building" aria-hidden="true"></i>Cargo</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'empleado.index'))
                    <li class="@yield('empleado-active')"><a href="{{ route('empleado.index') }}"><i
                                class="fa fa-users" aria-hidden="true"></i>Empleados</a></li>
                @endif


                @if (auth()->user()->can('haveaccess', 'api.index'))
                    <li class="@yield('api-active')"><a href="{{ route('api.index') }}"><i class="fa fa-paper-plane"
                                aria-hidden="true"></i>Apis</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'roles.index'))
                    <li class="@yield('rol-active')"><a href="{{ route('roles.index') }}"><i class="fa fa-building"
                                aria-hidden="true"></i>Roles</a></li>
                @endif
            </ul>

        </li>
    @endif
    @if (auth()->user()->can('haveaccess', 'docCompra.index') ||
    auth()->user()->can('haveaccess', 'proveedor.index'))
        <li class="@yield('compra-active')">
            <a href="#"><i class="fa fa-cart-plus"></i> <span class="nav-label">Compras</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                @if (auth()->user()->can('haveaccess', 'documentoCompra.index'))
                    <li class="@yield('documentoCompra-active')"><a href="{{ route('documentoCompra.index') }}"><i
                                class="fa fa-cart-plus" aria-hidden="true"></i>Orden de Compra</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'proveedor.index'))
                    <li class="@yield('proveedor-active')"><a href="{{ route('proveedor.index') }}"><i
                                class="fa fa-users" aria-hidden="true"></i>Proveedores</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'insumo.index'))
                    <li class="@yield('insumo-active')"><a href="{{ route('insumo.index') }}"><i
                                class="fa fa-list" aria-hidden="true"></i>Insumos</a></li>
                @endif
            </ul>
        </li>
    @endif
    @if (auth()->user()->can('haveaccess', 'docVenta.index') ||
    auth()->user()->can('haveaccess', 'tipoDocumento.index') ||
    auth()->user()->can('haveaccess', 'numeracion.index') ||
    auth()->user()->can('haveaccess', 'cliente.index'))
        <li class="@yield('ventas-active')">
            <a href="#"><i class="fa fa-cart-plus"></i> <span class="nav-label">Ventas</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                {{-- @if (auth()->user()->can('haveaccess', 'tipoProducto.index'))
                    <li class="@yield('tipoProducto-active')"><a href="{{ route('tipoProducto.index') }}"><i
                                class="fa fa-book" aria-hidden="true"></i>Tipos
                            de Productos</a></li>
                @endif --}}

                @if (auth()->user()->can('haveaccess', 'docVenta.index'))
                    <li class="@yield('docVenta-active')"><a href="{{ route('documentoVenta.index') }}"><i
                                class="fa fa-book" aria-hidden="true"></i>Comprobante de Ventas</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'tipoDocumento.index'))
                    <li class="@yield('tipoDocumento-active')"><a href="{{ route('tipoDocumento.index') }}"><i
                                class="fa fa-building" aria-hidden="true"></i>Tipo de Documentos</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'numeracion.index'))
                    <li class="@yield('numeracion-active')"><a href="{{ route('numeracion.index') }}"><i
                                class="fa fa-building" aria-hidden="true"></i>Numeracion</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'cliente.index'))
                    <li class="@yield('cliente-active')"><a href="{{ route('cliente.index') }}"><i
                                class="fa fa-users" aria-hidden="true"></i>Clientes</a></li>
                @endif
                <li class="@yield('cotizacion-active')"><a href="{{ route('cotizacion.index') }}"><i
                                class="fa fa-users" aria-hidden="true"></i>Cotizacion</a></li>
            </ul>
        </li>
    @endif
    @if (auth()->user()->can('haveaccess', 'empresa.index'))
        <li class="@yield('mantenimiento-active')">
            <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Mantenimiento</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                @if (auth()->user()->can('haveaccess', 'empresa.index'))
                    <li class="@yield('empresa-active')"><a href="{{ route('EmpresaPersonal.index') }}"><i
                                class="fa fa-building" aria-hidden="true"></i>Datos de
                            la Empresa</a></li>
                @endif

            </ul>
        </li>
    @endif
    @if (auth()->user()->can('haveaccess', 'almacen.index') ||
    auth()->user()->can('haveaccess', 'producto.index') ||
    auth()->user()->can('haveaccess', 'unidadMedida.index'))
        <li class="@yield('almacenM-active')">
            <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Almacen</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                @if (auth()->user()->can('haveaccess', 'almacen.index'))
                    <li class="@yield('almacen-active')"><a href="{{ route('almacen.index') }}"><i
                                class="fa fa-archive" aria-hidden="true"></i>Almacen</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'producto.index'))
                    <li class="@yield('producto-active')"><a href="{{ route('producto.index') }}"><i
                                class="fa fa-cart-plus" aria-hidden="true"></i>Productos</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'unidadMedida.index'))
                    <li class="@yield('unidadMedida-active')"><a href="{{ route('unidadMedida.index') }}"><i
                                class="fa fa-building" aria-hidden="true"></i>Unidad de Medida</a></li>
                @endif
                @if (auth()->user()->can('haveaccess', 'notaIngreso.index'))
                    <li class="@yield('notaIngreso-active')"><a href="{{ route('notaIngreso.index') }}"><i
                                class="fa fa-building" aria-hidden="true"></i>Nota de Ingreso</a></li>
                @endif
            </ul>
        </li>
    @endif
    <li class="@yield('reportes-active')">
        <a href="{{ route('reporte.index') }}" class="@yield('reporte-active')"><i class="fa fa-globe"></i> <span
                class="nav-label">Reportes</a>
    </li>
</ul>
