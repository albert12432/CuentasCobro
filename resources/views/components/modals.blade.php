{{-- resources/views/components/modals.blade.php --}}
{{-- Reusable Modal Components --}}

<style>
    /* Modal Base Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
        animation: fadeIn 0.2s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        padding: 0;
        max-width: 520px;
        width: 92%;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-header.warning {
        background: linear-gradient(135deg, #FF9500 0%, #FF6B00 100%);
        color: white;
    }

    .modal-header.danger {
        background: linear-gradient(135deg, #FF3B30 0%, #DC2626 100%);
        color: white;
    }

    .modal-header.success {
        background: linear-gradient(135deg, #34C759 0%, #22C55E 100%);
        color: white;
    }

    .modal-header.info {
        background: linear-gradient(135deg, #007AFF 0%, #0051D5 100%);
        color: white;
    }

    /* Toast animations */
    @keyframes toastSlideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes toastSlideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    .modal-header.permission {
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        color: white;
    }

    .modal-header .material-symbols-rounded {
        font-size: 28px;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
    }

    .modal-header .close-btn {
        margin-left: auto;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: inherit;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .modal-header .close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .modal-body {
        padding: 24px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        background: #f9fafb;
    }

    .modal-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }

    .modal-btn-cancel {
        background: #e5e7eb;
        color: #374151;
    }

    .modal-btn-cancel:hover {
        background: #d1d5db;
    }

    .modal-btn-primary {
        background: #007AFF;
        color: white;
    }

    .modal-btn-primary:hover {
        background: #0051D5;
        transform: translateY(-1px);
    }

    .modal-btn-danger {
        background: #FF3B30;
        color: white;
    }

    .modal-btn-danger:hover {
        background: #DC2626;
        transform: translateY(-1px);
    }

    .modal-btn-success {
        background: #34C759;
        color: white;
    }

    .modal-btn-success:hover {
        background: #22C55E;
        transform: translateY(-1px);
    }

    .modal-btn-warning {
        background: #FF9500;
        color: white;
    }

    .modal-btn-warning:hover {
        background: #F59E0B;
        transform: translateY(-1px);
    }

    /* Form elements inside modals */
    .modal-form-group {
        margin-bottom: 16px;
    }

    .modal-form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #374151;
        font-size: 14px;
    }

    .modal-form-group input,
    .modal-form-group textarea,
    .modal-form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .modal-form-group input:focus,
    .modal-form-group textarea:focus,
    .modal-form-group select:focus {
        outline: none;
        border-color: #007AFF;
        box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
    }

    .modal-form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Permission warning styles */
    .permission-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .permission-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .permission-list li .material-symbols-rounded {
        color: #8B5CF6;
    }

    /* Alert box inside modal */
    .modal-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px;
        border-radius: 12px;
        margin-bottom: 16px;
    }

    .modal-alert.warning {
        background: #FEF3C7;
        border: 1px solid #F59E0B;
        color: #92400E;
    }

    .modal-alert.danger {
        background: #FEE2E2;
        border: 1px solid #EF4444;
        color: #991B1B;
    }

    .modal-alert.info {
        background: #DBEAFE;
        border: 1px solid #3B82F6;
        color: #1E40AF;
    }

    .modal-alert .material-symbols-rounded {
        flex-shrink: 0;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Loading spinner in modals */
    .modal-loading {
        display: none;
        align-items: center;
        gap: 10px;
        color: #6B7280;
    }

    .modal-loading.active {
        display: flex;
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid #e5e7eb;
        border-top-color: #007AFF;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Confirmation badge */
    .confirmation-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: #F3F4F6;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        color: #4B5563;
    }

    /* Role badge */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
</style>

<script>
// Modal Management Functions
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
        document.body.style.overflow = '';
    }
}

// Close modal when clicking overlay
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(modal => {
            modal.classList.remove('active');
        });
        document.body.style.overflow = '';
    }
});

// Confirmation dialog helper
function showConfirmation(title, message, onConfirm, type = 'warning') {
    const modalId = 'confirmModal';
    let modal = document.getElementById(modalId);
    
    if (!modal) {
        modal = document.createElement('div');
        modal.id = modalId;
        modal.className = 'modal-overlay';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header ${type}">
                    <span class="material-symbols-rounded">${type === 'danger' ? 'warning' : type === 'success' ? 'check_circle' : 'help'}</span>
                    <h2 id="confirmTitle">Confirmar</h2>
                    <button class="close-btn" onclick="closeModal('${modalId}')">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="confirmMessage"></p>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn modal-btn-cancel" onclick="closeModal('${modalId}')">
                        <span class="material-symbols-rounded">close</span>
                        Cancelar
                    </button>
                    <button class="modal-btn modal-btn-${type}" id="confirmBtn">
                        <span class="material-symbols-rounded">check</span>
                        Confirmar
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
    document.getElementById('confirmTitle').textContent = title;
    document.getElementById('confirmMessage').textContent = message;
    document.getElementById('confirmBtn').onclick = function() {
        closeModal(modalId);
        if (typeof onConfirm === 'function') onConfirm();
    };
    
    openModal(modalId);
}

// Permission warning helper
function showPermissionWarning(requiredRole, currentRole) {
    showConfirmation(
        'Permisos Insuficientes',
        `Esta acción requiere el rol de "${requiredRole}". Tu rol actual es "${currentRole}".`,
        null,
        'warning'
    );
}

// Success notification toast
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span class="material-symbols-rounded">${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'info'}</span>
        <span>${message}</span>
    `;
    toast.style.cssText = `
        position: fixed;
        bottom: 24px;
        right: 24px;
        padding: 14px 20px;
        background: ${type === 'success' ? '#34C759' : type === 'error' ? '#FF3B30' : '#007AFF'};
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: toastSlideIn 0.3s ease;
    `;
    
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'toastSlideOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
