<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Aura Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Dashboard de Aura Gym</h1>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary 5mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Usuarios</h5>
                        <p class="card-text display-4">{{ $totalUsuarios }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                Usuarios Recientes
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Membresía</th>
                            <th>Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuariosRecientes as $usuario)
                        <tr>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->membresia }}</td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>