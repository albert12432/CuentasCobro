<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\CuentaCobro;
use App\Models\Contrato;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // Estadísticas de usuarios
        $totalUsers = User::count();
        $usersWithRoles = User::whereNotNull('role_id')->count();
        $usersWithoutRoles = User::whereNull('role_id')->count();
        $totalRoles = Role::count();
        
        // Estadísticas de cuentas de cobro y pagos
        $totalCuentas = CuentaCobro::count();
        $totalPagos = CuentaCobro::whereNotNull('contrato_id')->count();
        $totalTesoreria = CuentaCobro::whereHas('contrato')->count();
        $totalContratacion = Contrato::count();
        
        // Usuarios recientes (últimos 10)
        $recentUsers = User::with('role')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'usersWithRoles',
            'usersWithoutRoles',
            'totalRoles',
            'totalCuentas',
            'totalPagos',
            'totalTesoreria',
            'totalContratacion',
            'recentUsers'
        ));
    }
}
