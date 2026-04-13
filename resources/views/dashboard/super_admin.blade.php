<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Aura Gym</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-['Inter']">
    <!-- Sidebar -->
    <div class="flex h-screen">
        <div class="w-64 bg-gradient-to-b from-purple-800 to-purple-900 text-white fixed h-full">
            <div class="p-6">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    🏋️ Aura Gym
                </h1>
                <p class="text-purple-300 text-sm mt-2">Super Administrador</p>
            </div>
            <nav class="mt-8">
                <a href="#" class="flex items-center gap-3 px-6 py-3 bg-purple-700 mx-4 rounded-lg">
                    📊 Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 text-purple-200 hover:bg-purple-700 mx-4 rounded-lg transition mt-2">
                    👥 Socios
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 text-purple-200 hover:bg-purple-700 mx-4 rounded-lg transition">
                    💰 Pagos
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 text-purple-200 hover:bg-purple-700 mx-4 rounded-lg transition">
                    📅 Asistencias
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 text-purple-200 hover:bg-purple-700 mx-4 rounded-lg transition">
                    👨‍💼 Usuarios
                </a>
            </nav>
            <div class="absolute bottom-8 left-0 right-0 px-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-purple-200 hover:text-white w-full">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64 flex-1">
            <!-- Header -->
            <div class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Panel de Control</h2>
                <div class="flex items-center gap-4">
                    <span class="text-gray-600">{{ Auth::user()->name }}</span>
                    <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Socios Totales</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalMembers ?? 0 }}</p>
                            </div>
                            <div class="text-4xl">👥</div>
                        </div>
                        <div class="mt-4 text-green-600 text-sm">↑ 12% vs mes anterior</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Ingresos Totales</p>
                                <p class="text-3xl font-bold text-gray-800">${{ number_format($totalPayments ?? 0, 2) }}</p>
                            </div>
                            <div class="text-4xl">💰</div>
                        </div>
                        <div class="mt-4 text-green-600 text-sm">↑ 8% vs mes anterior</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Asistencias Hoy</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $todayAttendance ?? 0 }}</p>
                            </div>
                            <div class="text-4xl">📅</div>
                        </div>
                        <div class="mt-4 text-gray-500 text-sm">Registros del día</div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Administradores</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalAdmins ?? 0 }}</p>
                            </div>
                            <div class="text-4xl">👨‍💼</div>
                        </div>
                        <div class="mt-4 text-gray-500 text-sm">Total en el sistema</div>
                    </div>
                </div>

                <!-- Recent Payments Table -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">💰 Pagos Recientes</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Socio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($recentPayments ?? [] as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $payment->member->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 font-semibold text-green-600">${{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-6 py-4">{{ $payment->payment_date }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">
                                            {{ ucfirst($payment->payment_method) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        No hay pagos registrados
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>