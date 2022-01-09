<?php

use App\Http\Controllers\Administracion\ClienteController;
use App\Http\Controllers\Administracion\EmpleadoController;
use App\Http\Controllers\Administracion\ProveedorController;
use App\Http\Controllers\Administracion\TipoEmpleadoController;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\Compras\InsumoController;
use App\Http\Controllers\Configuracion\NumeracionController;
use App\Http\Controllers\Configuracion\RolController;
use App\Http\Controllers\Configuracion\TipoDocumentoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Mantenimiento\AlmacenController;
use App\Http\Controllers\Mantenimiento\EmpresaPersonalController;
use App\Http\Controllers\Mantenimiento\UnidadMedidaController;
use App\Http\Controllers\Ubigeo\UbigeoController;
use App\Http\Controllers\Ventas\DocumentoVentaController;
use App\Http\Controllers\Ventas\ProductoController;
use App\Http\Controllers\Ventas\TipoProductoController;
use App\Models\Configuracion\Numeracion;
use App\Models\Configuracion\TipoDocumento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user())
    {
        return redirect()->route('home');
    }
    else{
        return view('login');
    }
})->name('inicio');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('tipoempleado')->middleware('auth')->group(function(){
    Route::get('/', [TipoEmpleadoController::class, 'index'])->name('tipoempleado.index');
    Route::post('/store',[TipoEmpleadoController::class, 'store'])->name('tipoempleado.store');
    Route::post('/update/{id}',[TipoEmpleadoController::class, 'update'])->name('tipoempleado.update');
    Route::post('/destroy/{id}',[TipoEmpleadoController::class, 'destroy'])->name('tipoempleado.destroy');
    Route::get('/getList',[TipoEmpleadoController::class,'getList'])->name('tipoempleado.getList');
    Route::get('/verify',[TipoEmpleadoController::class,'verify'])->name('tipoempleado.verify');
});
Route::prefix('empleado')->middleware('auth')->group(function(){
    Route::get('/', [EmpleadoController::class, 'index'])->name('empleado.index');
    Route::get('/create', [EmpleadoController::class, 'create'])->name('empleado.create');
    Route::post('/store',[EmpleadoController::class, 'store'])->name('empleado.store');
    Route::get('/edit/{id}', [EmpleadoController::class, 'edit'])->name('empleado.edit');
    Route::post('/update/{id}',[EmpleadoController::class, 'update'])->name('empleado.update');
    Route::post('/destroy/{id}',[EmpleadoController::class, 'destroy'])->name('empleado.destroy');
    Route::get('/getList',[EmpleadoController::class,'getList'])->name('empleado.getList');
});
Route::prefix('cliente')->middleware('auth')->group(function(){
    Route::get('/', [ClienteController::class, 'index'])->name('cliente.index');
    Route::get('/create', [ClienteController::class, 'create'])->name('cliente.create');
    Route::post('/store',[ClienteController::class, 'store'])->name('cliente.store');
    Route::get('/edit/{id}', [ClienteController::class, 'edit'])->name('cliente.edit');
    Route::post('/update/{id}',[ClienteController::class, 'update'])->name('cliente.update');
    Route::post('/destroy/{id}',[ClienteController::class, 'destroy'])->name('cliente.destroy');
    Route::get('/getList',[ClienteController::class,'getList'])->name('cliente.getList');
});
Route::prefix('proveedor')->middleware('auth')->group(function(){
    Route::get('/', [ProveedorController::class, 'index'])->name('proveedor.index');
    Route::get('/create', [ProveedorController::class, 'create'])->name('proveedor.create');
    Route::post('/store',[ProveedorController::class, 'store'])->name('proveedor.store');
    Route::get('/edit/{id}', [ProveedorController::class, 'edit'])->name('proveedor.edit');
    Route::post('/update/{id}',[ProveedorController::class, 'update'])->name('proveedor.update');
    Route::post('/destroy/{id}',[ProveedorController::class, 'destroy'])->name('proveedor.destroy');
    Route::get('/getList',[ProveedorController::class,'getList'])->name('proveedor.getList');
});
Route::prefix('api')->middleware('auth')->group(function(){
    Route::get('/',[ApisController::class,'index'])->name('api.index');
    Route::post('/store',[ApisController::class,'index'])->name('api.store');
    Route::post('/update/{id}',[ApisController::class, 'update'])->name('api.update');
    Route::post('/destroy/{id}',[ApisController::class, 'destroy'])->name('api.destroy');
    Route::get('/getList',[ApisController::class,'getList'])->name('api.getList');
    Route::get('/apiDni/{documento}',[ApisController::class,'apiDni'])->name('api.getDni');
    Route::get('/apiRuc/{documento}',[ApisController::class,'apiRuc'])->name('api.getRuc');
});
Route::prefix('unidadMedida')->middleware('auth')->group(function(){
    Route::get('/', [UnidadMedidaController::class, 'index'])->name('unidadMedida.index');
    Route::post('/store',[UnidadMedidaController::class, 'store'])->name('unidadMedida.store');
    Route::post('/update/{id}',[UnidadMedidaController::class, 'update'])->name('unidadMedida.update');
    Route::post('/destroy/{id}',[UnidadMedidaController::class, 'destroy'])->name('unidadMedida.destroy');
    Route::get('/getList',[UnidadMedidaController::class,'getList'])->name('unidadMedida.getList');
});
Route::prefix('almacen')->middleware('auth')->group(function(){
    Route::get('/', [AlmacenController::class, 'index'])->name('almacen.index');
    Route::post('/store',[AlmacenController::class, 'store'])->name('almacen.store');
    Route::post('/update/{id}',[AlmacenController::class, 'update'])->name('almacen.update');
    Route::post('/destroy/{id}',[AlmacenController::class, 'destroy'])->name('almacen.destroy');
    Route::get('/getList',[AlmacenController::class,'getList'])->name('almacen.getList');
});
Route::prefix('tipoProducto')->middleware('auth')->group(function(){
    Route::get('/', [TipoProductoController::class, 'index'])->name('tipoProducto.index');
    Route::post('/store',[tipoProductoController::class, 'store'])->name('tipoProducto.store');
    Route::post('/update/{id}',[tipoProductoController::class, 'update'])->name('tipoProducto.update');
    Route::post('/destroy/{id}',[tipoProductoController::class, 'destroy'])->name('tipoProducto.destroy');
    Route::get('/getList',[tipoProductoController::class,'getList'])->name('tipoProducto.getList');
});
Route::prefix('producto')->middleware('auth')->group(function (){
    Route::get('/', [ProductoController::class, 'index'])->name('producto.index');
    Route::post('/store',[ProductoController::class, 'store'])->name('producto.store');
    Route::post('/update/{id}',[ProductoController::class, 'update'])->name('producto.update');
    Route::post('/destroy/{id}',[ProductoController::class, 'destroy'])->name('producto.destroy');
    Route::get('/getList',[ProductoController::class,'getList'])->name('producto.getList');
});
Route::prefix('insumo')->middleware('auth')->group(function (){
    Route::get('/', [InsumoController::class, 'index'])->name('insumo.index');
    Route::post('/store',[InsumoController::class, 'store'])->name('insumo.store');
    Route::post('/update/{id}',[InsumoController::class, 'update'])->name('insumo.update');
    Route::post('/destroy/{id}',[InsumoController::class, 'destroy'])->name('insumo.destroy');
    Route::get('/getList',[InsumoController::class,'getList'])->name('insumo.getList');
});
Route::prefix('ubigeo')->middleware('auth')->group(function(){
    Route::get('getprovincias/{departamentoid}',[UbigeoController::class,'getProvincias'])->name('ubigeo.getProvincias');
    Route::get('getdistritos/{provinciaid}',[UbigeoController::class,'getDistritos'])->name('ubigeo.getDistritos');
});
Route::prefix('empresaPersonal')->middleware('auth')->group(function () {
    Route::get('/index', [EmpresaPersonalController::class, 'index'])->name('EmpresaPersonal.index');
    Route::get('/empresaPersonal', [EmpresaPersonalController::class, 'getEmpresaPersonal'])->name('EmpresaPersonal.empresaPersonal');
    Route::post('/store', [EmpresaPersonalController::class, 'store'])->name('EmpresaPersonal.store');
    Route::get('/verify', [EmpresaPersonalController::class, 'verify'])->name('EmpresaPersonal.verify');
});
Route::prefix('tipoDocumento')->middleware('auth')->group(function(){
    Route::get('/index',[TipoDocumentoController::class,'index'])->name('tipoDocumento.index');
    Route::get('/vistaPrevia/{tipo}',[TipoDocumentoController::class,'vistaPrevia'])->name('tipoDocumento.vistaPrevia');
    Route::post('/update/{id}',[TipoDocumentoController::class,'update'])->name('tipoDocumento.update');
    Route::get('/vistaPreviaPdf/{arreglo}/{tipo}',[TipoDocumentoController::class,'vistaPreviaPdf'])->name('tipoDocumento.vistaPreviaPdf');
    Route::post('/updatePdf/{arreglo}/{tipo}',[TipoDocumentoController::class,'updatePdf'])->name('tipoDocumento.updatePdf');
    Route::get('/formatoPdf',[TipoDocumentoController::class,'formatoPdf'])->name('tipoDocumento.formatoPdf');
    Route::get('/getList',[TipoDocumentoController::class,'getList'])->name('tipoDocumento.getList');
});
Route::prefix('rol')->group(function () {
    Route::get('/', [RolController::class, 'index'])->name('roles.index');
    Route::get('/getTable', [RolController::class, 'getTable'])->name('roles.getTable');
    Route::get('/registrar', [RolController::class, 'create'])->name('roles.create');
    Route::post('/registrar', [RolController::class, 'store'])->name('roles.store');
    Route::get('/actualizar/{id}', [RolController::class, 'edit'])->name('roles.edit');
    Route::put('/actualizar/{id}', [RolController::class, 'update'])->name('roles.update');
    Route::get('/datos/{id}', [RolController::class, 'show'])->name('roles.show');
    Route::get('/destroy/{id}', [RolController::class, 'destroy'])->name('roles.destroy');
});
Route::prefix('numeracion')->middleware('auth')->group(function(){
    Route::get('/index',[NumeracionController::class,'index'])->name('numeracion.index');
    Route::post('/store',[NumeracionController::class,'store'])->name('numeracion.store');
    Route::post('/update/{id}',[NumeracionController::class,'update'])->name('numeracion.update');
    Route::post('/destroy/{id}',[NumeracionController::class,'destroy'])->name('numeracion.destroy');
    Route::post('/seleccionar/{id}',[NumeracionController::class,'seleccionar'])->name('numeracion.seleccionar');
    Route::post('/deseleccionar/{id}',[NumeracionController::class,'deseleccionar'])->name('numeracion.deseleccionar');
    Route::get('/getList',[NumeracionController::class,'getList'])->name('numeracion.getList');
});
Route::prefix('documentoVenta')->middleware('auth')->group(function(){
    Route::get('index',[DocumentoVentaController::class,'index'])->name('documentoVenta.index');
    Route::get('getList',[DocumentoVentaController::class,'getList'])->name('documentoVenta.getList');
    Route::get('create',[DocumentoVentaController::class,'create'])->name('documentoVenta.create');
    Route::post('store',[DocumentoVentaController::class,'store'])->name('documentoVenta.store');
    Route::get('edit/{id}',[DocumentoVentaController::class,'edit'])->name('documentoVenta.edit');
    Route::post('update/{id}',[DocumentoVentaController::class,'update'])->name('documentoVenta.update');
    Route::get('destroy/{id}',[DocumentoVentaController::class,'destroy'])->name('documentoVenta.destroy');
    Route::prefix('pago')->middleware('auth')->group(function(){
        Route::post('/store',[DocumentoVentaController::class,'storePago'])->name('documentoVenta.pago.store');
        Route::get('/downloadimg/{id}',[DocumentoVentaController::class,'download'])->name('documentoVenta.pago.download');
    });
    Route::get('ticket/{id}',[DocumentoVentaController::class,'ticket'])->name('documentoVenta.ticket');
    Route::get('a4/{id}',[DocumentoVentaController::class,'a4'])->name('documentoVenta.a4');
    Route::get('sunat/{id}',[DocumentoVentaController::class,'sunat'])->name('documentoVenta.sunat');

});
