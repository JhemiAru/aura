<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mi Cuenta - Aura Gym</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; padding: 20px; }
        .header { background: #16a34a; color: white; padding: 15px; border-radius: 10px; }
        .card { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏋️ Aura Gym - Mi Cuenta</h1>
        <p>Bienvenido, {{ $user->name ?? Auth::user()->name }} | <a href="/logout" style="color:white;">Salir</a></p>
    </div>

    <div class="card">
        <h3>✅ Mi Perfil</h3>
        <p>Email: {{ $user->email ?? Auth::user()->email }}</p>
        <p>Rol: Usuario Normal</p>
    </div>

    <div class="card">
        <h3>📋 Información de Socio</h3>
        @if($member)
            <p>Estado: {{ $member->status ?? 'Activo' }}</p>
            <p>Membresía válida hasta: {{ $member->end_date ?? 'No definida' }}</p>
        @else
            <p>No eres socio registrado. Contacta al administrador.</p>
        @endif
    </div>
</body>
</html>