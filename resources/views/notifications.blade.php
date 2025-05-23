<x-videos-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Notificaciones Push</h1>
            <button id="clear-notifications" class="text-sm text-blue-600 hover:text-blue-800">
                Limpiar todas
            </button>
        </div>

        <!-- Contenedor de notificaciones -->
        <div id="notifications" class="bg-white rounded-lg shadow divide-y divide-gray-200">
            <!-- Mensaje cuando no hay notificaciones -->
            <div id="no-notifications" class="p-4 text-center text-gray-500">
                No hay notificaciones nuevas
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificationsContainer = document.getElementById('notifications');
            const noNotificationsMsg = document.getElementById('no-notifications');
            const clearBtn = document.getElementById('clear-notifications');

            // Ocultar mensaje de "no notificaciones" si hay contenido
            if (notificationsContainer.children.length > 1) {
                noNotificationsMsg.classList.add('hidden');
            }

            if (window.Echo) {
                console.log('Echo está cargado correctamente');

                // Escuchar el canal de videos
                window.Echo.channel('videos')
                    .listen('video.created', (event) => {
                        console.log('Nuevo evento recibido:', event);
                        noNotificationsMsg.classList.add('hidden');

                        // Crear elemento de notificación
                        const notification = document.createElement('div');
                        notification.className = 'p-4 hover:bg-gray-50 transition duration-150';

                        // Plantilla de la notificación
                        notification.innerHTML = `
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        Nuevo video disponible
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <span class="font-semibold">Título:</span> ${event.title}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-2">
                                        ${formatDate(event.created_at)}
                                    </p>
                                </div>
                            </div>
                        `;

                        // Añadir animación y insertar al principio
                        notification.classList.add('animate-fade-in');
                        notificationsContainer.insertBefore(notification, notificationsContainer.firstChild);
                    });

                // También puedes escuchar notificaciones privadas si el usuario está autenticado
                // window.Echo.private(`App.Models.User.${userId}`)
                //     .notification((notification) => {
                //         console.log('Notificación privada:', notification);
                //     });

            } else {
                console.error('Echo no está disponible');
                notificationsContainer.innerHTML = `
                    <div class="p-4 text-red-500">
                        Error: No se pudo cargar el servicio de notificaciones. Recarga la página.
                    </div>
                `;
            }

            // Limpiar todas las notificaciones
            clearBtn.addEventListener('click', () => {
                while (notificationsContainer.children.length > 1) {
                    notificationsContainer.removeChild(notificationsContainer.firstChild);
                }
                noNotificationsMsg.classList.remove('hidden');
            });

            // Función para formatear la fecha
            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('es-ES', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        });
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-videos-app-layout>
