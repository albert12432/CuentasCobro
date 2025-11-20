<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrearUsuario;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CuentaCobroController;
use App\Http\Controllers\ItemCuentaCobroController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\InteraccionController;
use App\Http\Controllers\ReportesController;

// ========================================
// RUTA PRINCIPAL
// ========================================
Route::get('/', fn() => redirect()->route('login'));

// ========================================
// AUTENTICACIÓN
// ========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [CrearUsuario::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CrearUsuario::class, 'register']);

// RUTA TEMPORAL DE PRUEBA (eliminar después)
Route::get('/test-users', function () {
    $users = \App\Models\User::with('role')->get();
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
});

// ========================================
// RUTAS PROTEGIDAS POR AUTH
// ========================================
Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // NOTIFICACIONES
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/{id}/marcar-leida', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.marcarLeida');
    Route::post('/notificaciones/marcar-todas-leidas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.marcarTodasLeidas');

    // ========================================
    // ADMIN (alcalde, super_admin, ordenador_gasto)
    // ========================================
    Route::middleware(['check.role:alcalde,super_admin,ordenador_gasto'])
        ->prefix('admin')->name('admin.')->group(function () {

        Route::resource('users', UserController::class)->except(['show']);
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::resource('roles', RolController::class)->except(['show']);
        Route::get('roles/{role}', [RolController::class, 'show'])->name('roles.show');

        // Asignar / remover roles
        Route::post('roles/assign-role', [RolController::class, 'assignRole'])->name('roles.assign');
        Route::post('roles/remove-role', [RolController::class, 'removeRole'])->name('roles.remove');
        Route::get('roles/users-without-role', [RolController::class, 'getUsersWithoutRole'])->name('roles.users.without');

        // Configuración y reportes
        Route::view('settings', 'admin.settings')->name('settings');
        Route::view('reports', 'admin.reports')->name('reports');
    });

    // ========================================
    // CONTRATISTA
    // ========================================
    Route::middleware(['check.role:contratista'])
        ->prefix('contratista')->name('contratista.')->group(function () {
        Route::view('/dashboard', 'dashboard.contratista')->name('dashboard');
    });

    // ========================================
    // SUPERVISOR
    // ========================================
    Route::middleware(['check.role:supervisor'])
        ->prefix('supervisor')->name('supervisor.')->group(function () {
        Route::view('/dashboard', 'dashboard.supervisor')->name('dashboard');
    });

    // ========================================
    // CONTRATACIÓN (contratación, super_admin, alcalde)
    // ========================================
    Route::middleware(['check.role:contratacion,super_admin,alcalde'])
        ->prefix('contratacion')->name('contratacion.')->group(function () {
        Route::resource('contratos', ContratoController::class);
    });

    // ========================================
    // CUENTAS DE COBRO (todos los roles del flujo)
    // ========================================
    Route::middleware(['check.role:contratista,ordenador_gasto,supervisor,tesoreria,contratacion,alcalde,super_admin'])
        ->group(function () {
        
        // Ruta de pagos (acceso también para Tesorería)
        Route::get('cuentas_cobro/pagos', [CuentaCobroController::class, 'pagos'])
            ->name('cuentas_cobro.pagos');
        
        // Generar/visualizar PDF de una cuenta de cobro
        Route::get('cuentas_cobro/{id}/pdf', [CuentaCobroController::class, 'pdf'])
            ->name('cuentas_cobro.pdf');
        
        Route::resource('cuentas_cobro', CuentaCobroController::class);
    });

    // ========================================
    // REPORTES (acceso a ordenador_gasto y super_admin)
    // ========================================
    Route::middleware(['check.role:ordenador_gasto,super_admin'])
        ->prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReportesController::class, 'index'])->name('index');
        Route::get('/departamento/{nombre}', [ReportesController::class, 'departamento'])->name('departamento');
        Route::get('/cliente/{userId}', [ReportesController::class, 'cliente'])->name('cliente');
        Route::get('/aging', [ReportesController::class, 'aging'])->name('aging');
        Route::get('/exportar/{tipo}', [ReportesController::class, 'exportar'])->name('exportar');
    });

    // ========================================
    // INTERACCIONES (agregar notas a cuentas)
    // ========================================
    Route::middleware(['check.role:contratista,ordenador_gasto,supervisor,tesoreria,contratacion,alcalde,super_admin'])
        ->prefix('cuentas_cobro')->name('cuentas_cobro.')->group(function () {
        Route::post('{id}/interacciones', [InteraccionController::class, 'store'])->name('interacciones.store');
        Route::delete('{id}/interacciones/{interaccionId}', [InteraccionController::class, 'destroy'])->name('interacciones.destroy');
    });

    // ========================================
    Route::prefix('cuentas_cobro')->name('cuentas_cobro.')->group(function () {
        Route::post('{cuenta}/items', [ItemCuentaCobroController::class, 'store'])->name('items.store');
        Route::delete('items/{id}', [ItemCuentaCobroController::class, 'destroy'])->name('items.destroy');
        // Soportes
        Route::post('{cuenta}/soportes', [SoporteController::class, 'store'])->name('soportes.store');
        Route::delete('{cuenta}/soportes/{soporte}', [SoporteController::class, 'destroy'])->name('soportes.destroy');
        // Archivar (solo contratista)
        Route::post('{id}/archivar', [CuentaCobroController::class, 'archivar'])->middleware('check.role:contratista')->name('archivar');
        // Desarchivar (solo contratista)
        Route::post('{id}/desarchivar', [CuentaCobroController::class, 'desarchivar'])->middleware('check.role:contratista')->name('desarchivar');
    });

    // ========================================
    // APROBACIONES (todas las áreas involucradas)
    // ========================================
    Route::middleware(['check.role:ordenador_gasto,contratacion,tesoreria,supervisor,alcalde,super_admin'])->group(function () {
        Route::get('/aprobaciones', [CuentaCobroController::class, 'misAprobaciones'])->name('aprobaciones.index');
        Route::post('/cuentas_cobro/{id}/aprobar', [CuentaCobroController::class, 'aprobar'])->name('cuentas_cobro.aprobar');
        Route::post('/cuentas_cobro/{id}/rechazar', [CuentaCobroController::class, 'rechazar'])->name('cuentas_cobro.rechazar');
        // Devolver para corrección (Contratación)
        Route::post('/cuentas_cobro/{id}/devolver', [CuentaCobroController::class, 'devolver'])->name('cuentas_cobro.devolver');
        Route::post('/cuentas_cobro/{id}/enviar-cliente', [CuentaCobroController::class, 'enviarCliente'])->name('cuentas_cobro.enviar_cliente');
        // Acciones de pago (solo tesorería/super_admin)
        Route::post('/cuentas_cobro/{id}/pagar', [CuentaCobroController::class, 'registrarPago'])->name('cuentas_cobro.pagar');
        Route::post('/cuentas_cobro/{id}/rechazar-pago', [CuentaCobroController::class, 'rechazarPago'])->name('cuentas_cobro.rechazar_pago');
    });
    // Reenviar (Contratista)
    Route::post('/cuentas_cobro/{id}/reenviar', [CuentaCobroController::class, 'reenviar'])->middleware('check.role:contratista')->name('cuentas_cobro.reenviar');
});
