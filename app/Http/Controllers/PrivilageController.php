<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PrivilageController extends Controller
{
    /**
     * gestion des permissions
     */
    public function indexPermission(){
        $permissions = Permission::all();
        return view('security.permissions.index', compact('permissions'));
    }

    public function createPermission(){
        return view('security.permissions.create');
    }

    public function storePermission(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        try{
            $permissions = Permission::create([
                'guard_name' => 'web',
                'name' => $request->name
            ]);
            return redirect()->route('permission.index')->with('message', 'permission cree avec succes');
        }
        catch(Exception $e){
            if ($e ) {
                return redirect()->back()->withErrors(['message' => 'la permission existe deja.']);
            }    
        }
    }

    public function editPermission($id){
        $permissions = Permission::where('id', $id)->first();
        return view('security.permissions.edit', compact('permissions'));
    }

    public function updatePermission($id, Request $request){
        $permissions = Permission::find($id);
        $permissions->update([
            'name' => $request->name
        ]);

        return redirect()->route('permission.index')->with('message', 'la permission a ete mis a jour avec succes.');
    }

    public function deletePermission($id){
        Permission::where('id', $id)->delete();
        return redirect()->back()->with('message', 'permission suprime avec succes');
    }

    /**
     * gestion des roles
     */
    public function indexRole(){
        $roles = Role::all();

        return view('security.roles.index', compact('roles'));
    }

    public function createRole(){
        $role = Role::all();
        $permissions = Permission::all();

        return view('security.roles.create', compact('permissions', 'permissions'));
    }

    public function storeRole(Request $request){
        if ($request->isMethod('post')) {
            $name = request()->input('name');
            $roles = role::where('name', $name)->first();
            if($roles)
            {
                return back()->withErrors(['name' => 'ce nom a deja ete utilise']);
                
            }
            else
            {
                $permissions[] = Permission::find($request->permission_id);
                // dd($permissions); 
                $roles = Role::create([
                    'name' => $request->name,
                ]);
                $roles->syncPermissions($permissions);
                
        
                return redirect()->route('role.index');
            }
        } 

            return redirect()->route('role.index')->with('message', 'roles cree avec succes');

    }

    public function editRole($id){
        $roles = Role::where('id', $id)->first();
        $permissions = Permission::all();
        return view('security.roles.edit', compact('roles', 'permissions'));
    }

    public function updateRole($id, Request $request){
        $Roles = Role::find($id);
        $Roles->update([
            'name' => $request->name
        ]);

        return redirect()->route('role.index')->with('message', 'le Role a ete mis a jour avec succes.');
    }

    public function deleteRole($id){
        Role::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Role suprime avec succes');
    }
}
