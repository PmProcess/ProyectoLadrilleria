@extends('layout.index')
@section('contenido')
@section('configuracion-active', 'active')
@section('rol-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
        <h2 style="text-transform:uppercase"><b>Listado de Roles</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Roles</strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-2 col-md-2">
        <button id="btn_añadir_role" class="btn btn-block btn-w-m btn-primary m-t-md">
            <i class="fa fa-plus-square"></i> Añadir nuevo
        </button>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table dataTables-roles table-striped table-bordered table-hover"
                            style="text-transform:uppercase">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Slug</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">full access</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('css-custom')
<!-- DataTable -->
<link href="{{ asset('Inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('script-custom')
<!-- DataTable -->
<script src="{{ asset('Inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // DataTables
        $('.dataTables-roles').DataTable({
            "dom": '<"html5buttons"B>lTfgitp',
            "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'Roles'
                },
                {
                    titleAttr: 'Imprimir',
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Imprimir',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "bAutoWidth": false,
            "processing": true,
            "ajax": "{{ route('roles.getTable') }}",
            "columns": [{
                    data: 'name',
                    className: "text-center"
                },
                {
                    data: 'slug',
                    className: "text-left"
                },
                {
                    data: 'description',
                    className: "text-center"
                },
                {
                    data: 'full-access',
                    className: "text-center"
                },
                {
                    data: null,
                    className: "text-center",
                    render: function(data) {

                        //Ruta Modificar
                        var url_editar = '{{ route('roles.edit', ':id') }}';
                        url_editar = url_editar.replace(':id', data.id);
                        //Ruta Tiendas
                        return "<div class='btn-group'>" +
                            "<a class='btn btn-warning btn-sm modificarDetalle' href='" +
                            url_editar + "' title='Modificar'><i class='fa fa-edit'></i></a>" +
                            "<a class='btn btn-danger btn-sm' href='#' onclick='eliminar(" +
                            data.id + ")' title='Eliminar'><i class='fa fa-trash'></i></a>" +
                            "</div>";
                    }
                }
            ],
            "language": {
                "url": "{{ asset('Spanish.json') }}"
            },
            "order": [],
        });
        // Eventos
        $('#btn_añadir_role').on('click', añadirRole);
    });
    //Controlar Error
    $.fn.DataTable.ext.errMode = 'throw';
    //Modal Eliminar
    // Funciones de Eventos
    function añadirRole() {
        window.location = "{{ route('roles.create') }}";
    }

    function eliminar(id) {
        swal({
                title: "Estas seguro de eliminar?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    var url_eliminar = '{{ route('roles.destroy', ':id') }}';
                    url_eliminar = url_eliminar.replace(':id', id);
                    $(location).attr('href', url_eliminar);
                } else {
                    swal("Cancelled", "Fue Cancelado", "error");
                }
            }
        );
    }
</script>
@endsection
