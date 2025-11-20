<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/test-users', function () {
    $users = User::with('role')->get();
    
    echo "<h1>Usuarios Registrados</h1>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user->id}</td>";
        echo "<td>{$user->name}</td>";
        echo "<td>{$user->email}</td>";
        echo "<td>" . ($user->role ? $user->role->name : 'Sin rol') . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    echo "<p>Total: " . $users->count() . " usuarios</p>";
    
    return null;
});
