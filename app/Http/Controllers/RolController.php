<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Mostrar todos los roles
     */
    public function index()
    {
        $roles = Role::with('users')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Mostrar formulario para crear un nuevo rol
     */
    public function create()
    {
        $availablePermissions = [
            'create_cuenta_cobro',
            'view_cuenta_cobro',
            'edit_cuenta_cobro',
            'approve_cuenta_cobro',
            'upload_documents',
            'view_documents',
            'manage_contracts',
            'authorize_payment',
            'view_reports'
        ];

        return view('roles.create', compact('availablePermissions'));
    }

    /**
     * Guardar un nuevo rol en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);

        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    /**
     * Mostrar formulario para editar un rol existente
     */
    public function edit(Role $role)
    {
        $availablePermissions = [
            'create_cuenta_cobro',
            'view_cuenta_cobro',
            'edit_cuenta_cobro',
            'approve_cuenta_cobro',
            'upload_documents',
            'view_documents',
            'manage_contracts',
            'authorize_payment',
            'view_reports'
        ];

        return view('roles.edit', compact('role', 'availablePermissions'));
    }

    /**
     * Actualizar un rol existente
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);

        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach(); // Remover todos los permisos si no hay ninguno seleccionado
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Eliminar un rol
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }

    /**
     * Mostrar un rol (opcional, si lo usas)
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Asignar un rol a un usuario (AJAX)
     */
    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);
        $user->role()->associate($role);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Rol asignado correctamente.']);
    }

    /**
     * Remover rol de un usuario (AJAX)
     */
    public function removeRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->role()->dissociate();
        $user->save();

        return response()->json(['success' => true, 'message' => 'Rol removido correctamente.']);
    }

    /**
     * Obtener usuarios sin rol (AJAX)
     */
    public function getUsersWithoutRole()
    {
        $users = User::whereNull('role_id')->get();
        return response()->json($users);
    }
}
