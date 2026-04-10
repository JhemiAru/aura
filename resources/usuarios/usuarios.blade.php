{{-- resources/views/usuarios.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Usuarios - Gym')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Usuarios</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreateUser">
                            <i class="fas fa-user-plus"></i> Nuevo Usuario
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtros de búsqueda -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre, email o teléfono...">
                        </div>
                        <div class="col-md-3">
                            <select id="roleFilter" class="form-control">
                                <option value="">Todos los roles</option>
                                <option value="admin">Administrador</option>
                                <option value="entrenador">Entrenador</option>
                                <option value="cliente">Cliente</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="statusFilter" class="form-control">
                                <option value="">Todos los estados</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="suspendido">Suspendido</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary" id="resetFilters">
                                <i class="fas fa-undo"></i> Limpiar
                            </button>
                        </div>
                    </div>

                    <!-- Tabla de usuarios -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="usersTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Membresía</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'entrenador' ? 'warning' : 'info') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $user->status == 'activo' ? 'success' : 'danger' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->membership)
                                            {{ $user->membership->name }}
                                            <small class="text-muted">(Hasta: {{ $user->membership->expiry_date->format('d/m/Y') }})</small>
                                        @else
                                            <span class="text-muted">Sin membresía</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-view" data-id="{{ $user->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $user->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay usuarios registrados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear/Editar Usuario -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Crear Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" id="userId" name="user_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Completo *</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="tel" name="phone" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rol *</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="cliente">Cliente</option>
                                    <option value="entrenador">Entrenador</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control">
                                <small class="text-muted">Dejar en blanco para mantener la actual</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                    <option value="suspendido">Suspendido</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Membresía</label>
                                <select name="membership_id" id="membership_id" class="form-control">
                                    <option value="">Sin membresía</option>
                                    @foreach($memberships as $membership)
                                        <option value="{{ $membership->id }}">{{ $membership->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Filtros de búsqueda
    $('#searchInput, #roleFilter, #statusFilter').on('keyup change', function() {
        filterTable();
    });

    function filterTable() {
        let search = $('#searchInput').val().toLowerCase();
        let role = $('#roleFilter').val();
        let status = $('#statusFilter').val();
        
        $('#usersTable tbody tr').filter(function() {
            let text = $(this).text().toLowerCase();
            let userRole = $(this).find('td:eq(4)').text().trim().toLowerCase();
            let userStatus = $(this).find('td:eq(5)').text().trim().toLowerCase();
            
            let matchesSearch = text.indexOf(search) > -1;
            let matchesRole = role === '' || userRole === role;
            let matchesStatus = status === '' || userStatus === status;
            
            $(this).toggle(matchesSearch && matchesRole && matchesStatus);
        });
    }

    $('#resetFilters').click(function() {
        $('#searchInput').val('');
        $('#roleFilter').val('');
        $('#statusFilter').val('');
        filterTable();
    });

    // Modal para crear usuario
    $('#modalCreateUser').click(function() {
        $('#modalTitle').text('Crear Nuevo Usuario');
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#password').prop('required', true);
        $('#password_confirmation').prop('required', true);
        $('#userModal').modal('show');
    });

    // Editar usuario
    $('.btn-edit').click(function() {
        let userId = $(this).data('id');
        $.get('/users/' + userId + '/edit', function(data) {
            $('#modalTitle').text('Editar Usuario');
            $('#userId').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#role').val(data.role);
            $('#status').val(data.status);
            $('#membership_id').val(data.membership_id);
            $('#password').prop('required', false);
            $('#password_confirmation').prop('required', false);
            $('#userModal').modal('show');
        });
    });

    // Eliminar usuario
    $('.btn-delete').click(function() {
        let userId = $(this).data('id');
        if(confirm('¿Estás seguro de eliminar este usuario?')) {
            $.ajax({
                url: '/users/' + userId,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(result) {
                    location.reload();
                }
            });
        }
    });

    // Enviar formulario
    $('#userForm').submit(function(e) {
        e.preventDefault();
        let userId = $('#userId').val();
        let url = userId ? '/users/' + userId : '/users';
        let method = userId ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(result) {
                $('#userModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error al guardar el usuario');
            }
        });
    });
});
</script>
@endsection