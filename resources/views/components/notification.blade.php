<div id="notification-container" class="fixed top-4 right-4 z-50"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if showToast is already defined
        if (typeof window.showToast !== 'function') {
            window.showToast = function(message, type = 'success', duration = 5000) {
                const toastContainer = document.getElementById('notification-container');

                // Create toast element
                const toast = document.createElement('div');
                toast.className = 'p-4 mb-3 rounded-md shadow-md flex items-center justify-between min-w-[250px] max-w-[350px] transform transition-all duration-300 translate-x-full';

                // Set background color based on type
                if (type === 'success') {
                    toast.classList.add('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700');
                } else if (type === 'error') {
                    toast.classList.add('bg-red-100', 'border-l-4', 'border-red-500', 'text-red-700');
                } else if (type === 'warning') {
                    toast.classList.add('bg-yellow-100', 'border-l-4', 'border-yellow-500', 'text-yellow-700');
                } else if (type === 'info') {
                    toast.classList.add('bg-blue-100', 'border-l-4', 'border-blue-500', 'text-blue-700');
                }

                // Create content
                toast.innerHTML = `
                    <div class="flex items-center">
                        <div class="ml-3">
                            <p class="text-sm font-medium">${message}</p>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;

                // Add to container
                toastContainer.appendChild(toast);

                // Animate in
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                    toast.classList.add('translate-x-0');
                }, 10);

                // Set up close button
                const closeButton = toast.querySelector('button');
                closeButton.addEventListener('click', () => {
                    closeToast(toast);
                });

                // Auto close after duration
                setTimeout(() => {
                    closeToast(toast);
                }, duration);

                function closeToast(toast) {
                    toast.classList.remove('translate-x-0');
                    toast.classList.add('translate-x-full');

                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }
            };
        }

        // Check for flash messages
        const successMessage = "{{ session('success') }}";
        const errorMessage = "{{ session('error') }}";

        if (successMessage && successMessage !== '') {
            window.showToast(successMessage, 'success');
        }

        if (errorMessage && errorMessage !== '') {
            window.showToast(errorMessage, 'error');
        }
    });
</script>
