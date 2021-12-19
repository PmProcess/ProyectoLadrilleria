<?php

namespace Database\Seeders;

use App\Models\User;
use App\Permission\Models\Permission;
use App\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roladmin = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrado',
            'full-access' => 'yes',
            'eliminar' => 'no'
        ]);
        $useradmin = User::first();
        $useradmin->roles()->sync([$roladmin->id]);
        $permission_all = [];



        //permiso

        $permission = Permission::create([
            'name' => 'modulo tipo de Empleados',
            'slug' => 'tipoEmpleado.index',
            'description' => 'Un usuario puede ver el modulo de tipo de Empleados'
        ]);
        $permission_all[] = $permission->id;


        $permission = Permission::create([
            'name' => 'modulo de Empleado',
            'slug' => 'empleado.index',
            'description' => 'Un usuario puede ver el modulo empleado'
        ]);
        $permission_all[] = $permission->id;


        $permission = Permission::create([
            'name' => 'modulo de Proveedores',
            'slug' => 'proveedor.index',
            'description' => 'Un usuario puede ver el modulo Proveedores'
        ]);
        $permission_all[] = $permission->id;



        $permission = Permission::create([
            'name' => 'modulo de Clientes',
            'slug' => 'cliente.index',
            'description' => 'Un usuario puede ver el modulo Clientes'
        ]);
        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name' => 'modulo de Apis',
            'slug' => 'api.index',
            'description' => 'Un usuario puede ver el modulo de Apis'
        ]);
        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name' => 'modulo de Compras',
            'slug' => 'docCompra.index',
            'description' => 'Un usuario puede ver el modulo de Compras '
        ]);
        $permission_all[] = $permission->id;


        // $permission = Permission::create([
        //     'name' => 'modulo de Tipos de Productos',
        //     'slug' => 'tipoProducto.index',
        //     'description' => 'Un usuario puede ver el modulo de Tipos Productos'
        // ]);
        // $permission_all[] = $permission->id;
        $permission = Permission::create([
            'name' => 'modulo de Productos',
            'slug' => 'producto.index',
            'description' => 'Un usuario puede ver el modulo de Productos'
        ]);
        $permission_all[] = $permission->id;



        $permission = Permission::create([
            'name' => 'modulo de Documento de Ventas',
            'slug' => 'docVenta.index',
            'description' => 'Un usuario puede ver el modulo de Documentos de Ventas'
        ]);
        $permission_all[] = $permission->id;


        $permission = Permission::create([
            'name' => 'modulo de Datos de la empresa',
            'slug' => 'empresa.index',
            'description' => 'Un usuario puede ver el modulo de Empresa'
        ]);
        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'name' => 'modulo de Unidad de Medidas',
            'slug' => 'unidadMedida.index',
            'description' => 'Un usuario puede ver el modulo de Unidad de Medidas'
        ]);
        $permission_all[] = $permission->id;


        $permission = Permission::create([
            'name' => 'modulo de Almacen',
            'slug' => 'almacen.index',
            'description' => 'Un usuario puede consultar el modulo de Almacen'
        ]);
        $permission_all[] = $permission->id;


        $permission = Permission::create([
            'name' => 'modulo de Tipo de Documentos',
            'slug' => 'tipoDocumento.index',
            'description' => 'Un usuario puede consultar el modulo de tipos de Documentos'
        ]);
        $permission_all[] = $permission->id;

        $permission=Permission::create([
            'name'=>'modulo numeracion',
            'slug'=>'numeracion.index',
            'description'=>'Un usuario puede consultar el modulo de numeracion'
        ]);
        $permission_all[]=$permission->id;



        //permisos roles
        $permission = Permission::create([
            'name' => 'Lista roles',
            'slug' => 'roles.index',
            'description' => 'Un usuario puede ver el modulo roles'
        ]);
        $permission_all[] = $permission->id;
        $roladmin->permissions()->sync($permission_all);
    }
}
