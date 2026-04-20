<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Aura Gym | Mi Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: radial-gradient(circle at 10% 20%, rgba(99,102,241,0.15) 0%, rgba(236,72,153,0.15) 100%), linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); background-attachment: fixed; min-height: 100vh; }
        .glass-card { background: rgba(255,255,255,0.07); backdrop-filter: blur(12px); border-radius: 24px; border: 1px solid rgba(255,255,255,0.15); padding: 20px; transition: 0.3s; }
        .glass-card:hover { transform: translateY(-4px); border-color: rgba(99,102,241,0.5); }
        .stat-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(8px); border-radius: 20px; padding: 20px; border: 1px solid rgba(255,255,255,0.1); }
        .stat-number { font-size: 2rem; font-weight: 800; background: linear-gradient(135deg, #fff, #a5b4fc); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .btn-glow { background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; box-shadow: 0 4px 15px rgba(99,102,241,0.4); }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="glass-card mb-4 d-flex justify-content-between align-items-center">
            <div><h2 class="text-white"><i class="fas fa-dumbbell"></i> Aura Gym</h2><p class="text-white-50">Bienvenido, <strong>{{ $user->name }}</strong></p></div>
            <div class="dropdown"><button class="btn btn-link text-white dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-user-circle fa-2x"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="#" onclick="showProfile()"><i class="fas fa-user me-2"></i>Mi Perfil</a></li><li><hr class="dropdown-divider"></li><li><form method="POST" action="{{ route('logout') }}" id="logout-form">@csrf<a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></form></li></ul></div>
        </div>

        @if($member)
        <div class="row g-4 mb-4">
            <div class="col-md-4"><div class="stat-card"><i class="fas fa-id-card fa-2x text-primary"></i><h3 class="text-white mt-2">{{ $member->membership->name ?? 'Sin membresía' }}</h3><p class="text-white-50">Plan actual</p></div></div>
            <div class="col-md-4"><div class="stat-card"><i class="fas fa-calendar-alt fa-2x text-success"></i><h3 class="text-white mt-2">{{ \Carbon\Carbon::parse($member->end_date)->format('d/m/Y') }}</h3><p class="text-white-50">Vencimiento</p></div></div>
            <div class="col-md-4"><div class="stat-card"><i class="fas fa-check-circle fa-2x {{ $member->status == 'active' ? 'text-success' : 'text-danger' }}"></i><h3 class="text-white mt-2">{{ $member->status == 'active' ? 'Activo' : 'Inactivo' }}</h3><p class="text-white-50">Estado</p></div></div>
        </div>

        <div class="glass-card mb-4"><h4 class="text-white"><i class="fas fa-credit-card me-2"></i>Mis Últimos Pagos</h4><div class="table-responsive mt-3"><table class="table table-dark table-hover"><thead><tr><th>Fecha</th><th>Monto</th><th>Método</th><th>Estado</th></tr></thead><tbody>@forelse($myPayments as $payment)<tr><td>{{ $payment->payment_date }}</td><td>${{ number_format($payment->amount,2) }}</td><td>{{ ucfirst($payment->payment_method) }}</td><td><span class="badge bg-success">Completado</span></td></tr>@empty<tr><td colspan="4" class="text-center">No hay pagos</td></tr>@endforelse</tbody></table></div></div>

        <div class="glass-card mb-4"><h4 class="text-white"><i class="fas fa-calendar-check me-2"></i>Mis Asistencias</h4><div class="table-responsive"><table class="table table-dark table-hover"><thead><tr><th>Entrada</th><th>Salida</th></tr></thead><tbody>@forelse($myAttendance as $attendance)<tr><td>{{ \Carbon\Carbon::parse($attendance->check_in)->format('d/m/Y H:i') }}</td><td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('d/m/Y H:i') : 'No registrada' }}</td></tr>@empty<tr><td colspan="2" class="text-center">No hay asistencias</td></tr>@endforelse</tbody></table></div></div>

        <div class="glass-card"><h4 class="text-white"><i class="fas fa-dumbbell me-2"></i>Mis Rutinas Asignadas</h4><div id="userRoutines" class="mt-3">Cargando...</div></div>
        @else
        <div class="alert alert-warning">No se encontró tu información de socio. Contacta al administrador.</div>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() { loadUserRoutines(); });
        function loadUserRoutines() { $('#userRoutines').html('<div class="list-group"><div class="list-group-item bg-dark text-white">Rutina Full Body: 3x12 sentadillas, press banca, dominadas</div><div class="list-group-item bg-dark text-white">Cardio HIIT: 20 min intervalos</div></div>'); }
        function showProfile() { Swal.fire('Mi Perfil', `Nombre: {{ $user->name }}\nEmail: {{ $user->email }}\nRol: Usuario`, 'info'); }
    </script>
</body>
</html>