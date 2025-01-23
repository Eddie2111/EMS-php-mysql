<?php
function renderToast($message = '')
{
?>
    <div id="toast-container" class="toast-container_1"></div>

    <style>
        .toast-container_1 {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast_1 {
            background-color: rgb(0, 0, 0);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            height: 40px;
            width: 300px;
            margin-top: 3px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            opacity: 1;
            transform: translateY(0);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .toast_1.hide_1 {
            opacity: 0;
            transform: translateY(100%);
        }
    </style>

    <script>
        function showToast(message) {
            if (!message) return;

            const toast = document.createElement('div');
            toast.className = 'toast_1';
            toast.textContent = message;

            const container = document.getElementById('toast-container');
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide_1');
                setTimeout(() => toast.remove(), 1000);
            }, 3000);
        }

        // Automatically show toast if message exists
        const message = <?= json_encode($message); ?>;
        if (message) {
            showToast(message);
        }
    </script>
<?php
}
?>