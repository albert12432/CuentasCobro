{{-- Alert Component --}}
<style>
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInDown 0.3s ease;
        border-left: 4px solid transparent;
    }

    .alert.success {
        background: rgba(48, 209, 88, 0.1);
        border-left-color: var(--apple-green);
        color: var(--apple-green);
    }

    .alert.danger {
        background: rgba(255, 59, 48, 0.1);
        border-left-color: var(--apple-red);
        color: var(--apple-red);
    }

    .alert.warning {
        background: rgba(255, 149, 0, 0.1);
        border-left-color: var(--apple-orange);
        color: var(--apple-orange);
    }

    .alert.info {
        background: rgba(0, 113, 227, 0.1);
        border-left-color: var(--apple-blue);
        color: var(--apple-blue);
    }

    .alert-icon {
        font-size: 20px;
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-close {
        background: none;
        border: none;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.2s;
        display: flex;
        align-items: center;
    }

    .alert-close:hover {
        opacity: 1;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="alert alert-{{ $type ?? 'info' }}" role="alert" id="alert-{{ uniqid() }}">
    <span class="material-symbols-rounded alert-icon">
        @switch($type ?? 'info')
            @case('success')
                check_circle
            @break
            @case('danger')
                error
            @break
            @case('warning')
                warning
            @break
            @default
                info
        @endswitch
    </span>
    <div class="alert-content">
        {{ $slot }}
    </div>
    @if($closeable ?? true)
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <span class="material-symbols-rounded">close</span>
        </button>
    @endif
</div>
