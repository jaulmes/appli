<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('users.index', compact('users'));

    }

    public function create(){
        $roles=Role::orderBy('name', 'asc')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request){
        $users = new User();
        $users->email = $request->input('email');
        $users->name = $request->input('name');
        $users->numero = $request->input('numero');
        $users->password = Hash::make($request->input('password'));
        
        //je recupere l'id du role dans le formulaire
        $roleID = $request->role_id;

        //je recupere le role dans la bd en fonction de l'id
        $roles = Role::find($roleID);

        $permissions=[];
        
        //pour toutes les permissions attache au role, je stock dans le tableau
            foreach ($roles->permissions as $permission) {

                $permissions[]= $permission;
            }
        
        $users->assignRole($roles);
        $users->givePermissionTo($permissions);
        $users->save();
        
        return redirect()->route('users.index');
        
    }

    public function edit($id)
    {
       $users = User::find($id);
        $permissions = $users->permissions;
        $roles = $users->getRoleNames();
        return view('users.edit' , compact('users', 'roles', 'permissions'));
       
    }
    
    //modifier ses donnees personnel
    public function update(Request $request, $id)
    {
        
        $users = User::find($id);
        $users->email = $request->input('email');
        $users->name = $request->input('name');
        $users->numero = $request->input('numero');
        
        // $current_password = Hash::make($request->input('current_password'));
        // dd($current_password, $users->password);
        
        
        if (!Hash::check($request->current_password, $users->password)) {
            
            return redirect()->back()->with("error", 'Mot de passe incorrect');
        }
        $users->password = Hash::make($request->new_password);
        
        $permissions = $users->permissions;
        $roles = $users->getRoleNames();

        $users->assignRole($roles);
        $users->givePermissionTo($permissions);
        $users->save();
        session()->flash("message", "vous avez modifie vos donnees avec succes");
        return redirect()->back();
        
    }
    
    //afficher le formulaire de modification des donnees d'un utilisateur
    public function editAdmin(Request $request, $id)
    {
        
       $users = User::find($id);
        $roles=Role::orderBy('name', 'asc')->get();
        return view('users.editAdmin' , compact('users', 'roles'));
        
    }
    
    //modifier les donnees d'un utilisateur
    public function updateAdmin(Request $request, $id)
    {
        $users = User::find($id);
        $users->email = $request->input('email');
        $users->name = $request->input('name');
        $users->numero = $request->input('numero');
        
        $permissions = $users->permissions;
        $roles = $users->getRoleNames();
        

        
        //je recupere l'id du role dans le formulaire
        $roleID = $request->role_id;

        //je recupere le role dans la bd en fonction de l'id
        $roles = Role::find($roleID);

        $permissions=[];
        
        
        
        //pour toutes les permissions attache au role, je stock dans le tableau
            foreach ($roles->permissions as $permission) {

                $permissions[]= $permission;
            }
        
        $users->syncRoles($roles);
        $users->syncPermissions($permissions);
        //dd($users->getRoleNames());
        
        
        $users->save();
        session()->flash("message", "vous avez mis a jour l'utilisateur");
        return redirect()->route('users.index');
        
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        session()->flash("message", "you've drop these user");
        return redirect()->route('users.index');
    }
}
