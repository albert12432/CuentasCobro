{{-- Modal Component --}}
<style>
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-dialog {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 500px;
        width: 90%;
        animation: slideInUp 0.3s ease;
        position: relative;
    }

    .modal-header {
        padding: 24px 28px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--apple-dark);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 28px;
    }

    .modal-footer {
        padding: 20px 28px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    @keyframes slideInUp {
        from {
            transform: translateY(40px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 100%;
            border-radius: 20px 20px 0 0;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.active {
            align-items: flex-end;
        }
    }
</style>

<div class="modal-overlay" id="{{ $id }}">
    <div class="modal-dialog">
        <div class="modal-header">
            <h2 class="modal-title">{{ $title ?? '' }}</h2>
            <button type="button" class="modal-close" onclick="closeModal('{{ $id }}')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <div class="modal-body">
            {{ $slot }}
        </div>
        @if($footer ?? false)
            <div class="modal-footer">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    // Cerrar modal al hacer clic en el overlay
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });

    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                closeModal(modal.id);
            });
        }
    });
</script>
