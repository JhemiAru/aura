<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Aura Gym</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; padding: 20px; }
        .header { background: #2563eb; color: white; padding: 15px; border-radius: 10px; }
        .card { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; }
        .stats { display: flex; gap: 20px; }
        .stat { background: white; padding: 15px; border-radius: 10px; text-align: center; flex: 1; }
        .number { font-size: 30px; font-weight: bold; color: #2563eb; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏋️ Aura Gym - Administrador</h1>
        <p>Bienvenido, {{ Auth::user()->name }} | <a href="/logout" style="color:white;">Salir</a></p>
    </div>

    <div class="stats">
        <div class="stat">
            <div>👥</div>
            <div class="number">{{ $totalMembers ?? 0 }}</div>
            <div>Socios</div>
        </div>
        <div class="stat">
            <div>💰</div>
            <div class="number">${{ number_format($totalPayments ?? 0, 2) }}</div>
            <div>Ingresos</div>
        </div>
        <div class="stat">
            <div>📅</div>
            <div class="number">{{ $todayAttendance ?? 0 }}</div>
            <div>Asistencias Hoy</div>
        </div>
    </div>

    <div class="card">
        <h3>✅ Dashboard funcionando correctamente</h3>
        <p>Has iniciado sesión como <strong>Administrador</strong></p>
    </div>
</body>
</html>