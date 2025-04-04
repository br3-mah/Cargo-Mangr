{{-- Flash Message --}}
@if(session('error'))
<div class="error-notification" role="alert">
    <div class="notification-content">
        <div class="notification-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div class="notification-message">{{ session('error') }}</div>
    </div>
    <button type="button" class="notification-close" data-dismiss="alert" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<style>
    .error-notification {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(16, 185, 129, 0.12) 100%);
        border-left: 4px solid #e82300;
        color: #5f0606;
        margin: 1rem 0;
        padding: 0;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.1), 0 4px 6px -2px rgba(16, 185, 129, 0.05);
        overflow: hidden;
        transform: translateY(-10px);
        opacity: 0;
        animation: slideDown 0.3s ease forwards;
    }

    @keyframes slideDown {
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .notification-content {
        display: flex;
        align-items: center;
        flex-grow: 1;
        padding: 1rem 1.5rem;
    }

    .notification-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #b91010;
        border-radius: 50%;
        margin-right: 1rem;
        color: white;
        flex-shrink: 0;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(185, 16, 16, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(185, 16, 16, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(185, 16, 16, 0);
        }
    }

    .notification-message {
        font-size: 1rem;
        line-height: 1.5;
        font-weight: 500;
    }

    .notification-close {
        background: transparent;
        border: none;
        color: #5f0606;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        padding: 0;
        margin-right: 0.5rem;
        opacity: 0.7;
        transition: all 0.2s ease;
        border-radius: 50%;
    }

    .notification-close:hover {
        background-color: rgba(185, 16, 16, 0.12);
        opacity: 1;
    }

    .notification-close:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(185, 16, 16, 0.5);
    }

    /* Smooth exit animation */
    .error-notification.fade-out {
        animation: fadeOut 0.5s ease forwards;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }

    /* Add a subtle progress bar that automatically dismisses the notification */
    .error-notification::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: #b91010;
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        0% {
            width: 100%;
        }

        100% {
            width: 0%;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .notification-content {
            padding: 0.75rem 1rem;
        }

        .notification-icon {
            width: 36px;
            height: 36px;
        }

        .notification-message {
            font-size: 0.9375rem;
        }

        .notification-close {
            width: 40px;
            height: 40px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss after 5 seconds
    const notification = document.querySelector('.error-notification');
    if (notification) {
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => {
                notification.style.display = 'none';
            }, 500);
        }, 5000);

        // Close button functionality
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', function() {
            notification.classList.add('fade-out');
            setTimeout(() => {
                notification.style.display = 'none';
            }, 500);
        });
    }
});
</script>
@endif
{{-- End Flash Message --}}