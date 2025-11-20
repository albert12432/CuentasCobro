{{-- Badge Component --}}
<style>
    .badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background: rgba(48, 209, 88, 0.15);
        color: var(--apple-green);
    }

    .badge-danger {
        background: rgba(255, 59, 48, 0.15);
        color: var(--apple-red);
    }

    .badge-warning {
        background: rgba(255, 149, 0, 0.15);
        color: var(--apple-orange);
    }

    .badge-info {
        background: rgba(0, 113, 227, 0.15);
        color: var(--apple-blue);
    }

    .badge-primary {
        background: rgba(102, 126, 234, 0.15);
        color: #667eea;
    }

    .badge-secondary {
        background: rgba(134, 134, 139, 0.15);
        color: var(--apple-gray);
    }

    .badge-admin { background: #e3f2fd; color: #1976d2; }
    .badge-supervisor { background: #f3e5f5; color: #7b1fa2; }
    .badge-contratista { background: #e8f5e9; color: #388e3c; }
    .badge-ordenador_gasto { background: #fff3e0; color: #f57c00; }
    .badge-tesoreria { background: #fce4ec; color: #c2185b; }
    .badge-alcalde { background: #e0f2f1; color: #00796b; }
</style>

<span class="badge badge-{{ $variant ?? 'info' }}">
    {{ $slot }}
</span>
