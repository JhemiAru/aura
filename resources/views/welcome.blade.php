{{-- resources/views/usuarios.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GymPower Nexus | Sistema Cuántico de Gestión</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    
    <!-- Google Fonts Premium -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-dark: linear-gradient(135deg, #5a67d8 0%, #6b46a0 100%);
            --secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --danger: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
            --glass: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle cx="100" cy="100" r="2" fill="white" opacity="0.3"/><circle cx="300" cy="150" r="3" fill="white" opacity="0.2"/><circle cx="500" cy="50" r="2" fill="white" opacity="0.4"/><circle cx="700" cy="200" r="4" fill="white" opacity="0.1"/><circle cx="900" cy="100" r="2" fill="white" opacity="0.3"/></svg>');
            background-repeat: repeat;
            pointer-events: none;
            z-index: 0;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            z-index: 1000;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .nav-label,
        .sidebar.collapsed .user-info {
            display: none;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.5rem;
        }

        .sidebar-header {
            padding: 30px 25px;
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: 30px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 25px;
            margin: 5px 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .nav-link i {
            width: 25px;
            margin-right: 12px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Glass Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        /* Calendar */
        .fc {
            background: white;
            border-radius: 15px;
            padding: 20px;
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 300px;
        }

        /* Tables */
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .modern-table tbody tr {
            background: white;
            transition: all 0.3s;
        }

        .modern-table tbody tr:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        .badge-modern {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header text-center">
        <h3 class="text-white"><i class="fas fa-dumbbell"></i> <span class="sidebar-text">GYMPOWER</span></h3>
        <p class="text-white-50 sidebar-text">Nexus System v3.0</p>
    </div>
    
    <div class="user-info text-center mb-4 sidebar-text">
        <img src="https://ui-avatars.com/api/?background=667eea&color=fff&rounded=true&bold=true&size=80&name=Admin" 
             class="rounded-circle mb-2" width="70" height="70">
        <h6 class="text-white mb-0">Admin Nexus</h6>
        <small class="text-white-50">Super Administrador</small>
    </div>
    
    <nav>
        <div class="nav-link active" data-page="dashboard">
            <i class="fas fa-chart-pie"></i>
            <span class="sidebar-text">Dashboard</span>
        </div>
        <div class="nav-link" data-page="users">
            <i class="fas fa-users"></i>
            <span class="sidebar-text">Usuarios</span>
        </div>
        <div class="nav-link" data-page="classes">
            <i class="fas fa-calendar-alt"></i>
            <span class="sidebar-text">Clases</span>
        </div>
        <div class="nav-link" data-page="payments">
            <i class="fas fa-credit-card"></i>
            <span class="sidebar-text">Pagos</span>
        </div>
        <div class="nav-link" data-page="reports">
            <i class="fas fa-chart-line"></i>
            <span class="sidebar-text">Reportes</span>
        </div>
        <div class="nav-link" data-page="settings">
            <i class="fas fa-cog"></i>
            <span class="sidebar-text">Configuración</span>
        </div>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Top Bar -->
    <div class="glass-card p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark" id="toggleSidebar">
                    <i class="fas fa-bars fa-2x"></i>
                </button>
                <div class="ms-3">
                    <h4 class="mb-0" id="pageTitle">Dashboard</h4>
                    <small class="text-muted">Bienvenido al sistema de gestión</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-link position-relative" data-bs-toggle="dropdown">
                        <i class="fas fa-bell fa-xl"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" id="notificationList">
                        <li><a class="dropdown-item" href="#">No hay notificaciones</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?background=667eea&color=fff&rounded=true&bold=true&size=40&name=Admin" 
                             width="40" height="40" class="rounded-circle">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="showProfile()"><i class="fas fa-user"></i> Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- DASHBOARD SECTION -->
    <div id="dashboardSection">
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card" onclick="switchToPage('users')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Usuarios</h6>
                            <h2 class="mb-0" id="dashTotalUsers">0</h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> +12%</small>
                        </div>
                        <div class="bg-primary text-white rounded p-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" onclick="switchToPage('classes')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Clases Activas</h6>
                            <h2 class="mb-0" id="dashTotalClasses">0</h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> +3</small>
                        </div>
                        <div class="bg-success text-white rounded p-3">
                            <i class="fas fa-chalkboard-user fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" onclick="switchToPage('payments')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Ingresos Mes</h6>
                            <h2 class="mb-0">$<span id="dashTotalIncome">0</span></h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> +18%</small>
                        </div>
                        <div class="bg-warning text-white rounded p-3">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Tasa Retención</h6>
                            <h2 class="mb-0"><span id="dashRetention">0</span>%</h2>
                            <small class="text-success">Excelente</small>
                        </div>
                        <div class="bg-info text-white rounded p-3">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-chart-line"></i> Tendencia de Usuarios</h5>
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-chart-pie"></i> Distribución</h5>
                    <div class="chart-container">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- USERS SECTION -->
    <div id="usersSection" style="display: none;">
        <div class="glass-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5><i class="fas fa-users"></i> Gestión de Usuarios</h5>
                <button class="btn btn-primary" onclick="showUserModal()">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="userSearch" class="form-control" placeholder="Buscar usuario...">
                </div>
                <div class="col-md-3">
                    <select id="roleFilter" class="form-select">
                        <option value="">Todos los roles</option>
                        <option value="admin">Administrador</option>
                        <option value="entrenador">Entrenador</option>
                        <option value="cliente">Cliente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="modern-table" id="usersTable">
                    <thead class="table-dark">
                        <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr>
                    </thead>
                    <tbody id="usersTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CLASSES SECTION -->
    <div id="classesSection" style="display: none;">
        <div class="glass-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5><i class="fas fa-calendar-alt"></i> Programación de Clases</h5>
                <button class="btn btn-primary" onclick="showClassModal()">
                    <i class="fas fa-plus"></i> Nueva Clase
                </button>
            </div>
            <div id="calendar"></div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-trophy"></i> Clases Populares</h5>
                    <div id="popularClasses"></div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-clock"></i> Próximas Clases</h5>
                    <div id="upcomingClasses"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- PAYMENTS SECTION -->
    <div id="paymentsSection" style="display: none;">
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h6 class="text-muted">Ingresos Totales</h6>
                    <h2>$<span id="totalPayments">0</span></h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h6 class="text-muted">Pagos Pendientes</h6>
                    <h2>$<span id="pendingPayments">0</span></h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h6 class="text-muted">Transacciones</h6>
                    <h2 id="transactionCount">0</h2>
                </div>
            </div>
        </div>
        
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5><i class="fas fa-credit-card"></i> Historial de Pagos</h5>
                <button class="btn btn-primary" onclick="showPaymentModal()">
                    <i class="fas fa-plus"></i> Registrar Pago
                </button>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead class="table-dark">
                        <tr><th>ID</th><th>Usuario</th><th>Monto</th><th>Fecha</th><th>Estado</th><th>Acciones</th></tr>
                    </thead>
                    <tbody id="paymentsTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- REPORTS SECTION -->
    <div id="reportsSection" style="display: none;">
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-chart-bar"></i> Reporte de Usuarios</h5>
                    <div class="chart-container">
                        <canvas id="usersReportChart"></canvas>
                    </div>
                    <button class="btn btn-primary mt-3 w-100" onclick="generateUserReport()">
                        <i class="fas fa-download"></i> Descargar Reporte
                    </button>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-chart-line"></i> Reporte de Ingresos</h5>
                    <div class="chart-container">
                        <canvas id="incomeReportChart"></canvas>
                    </div>
                    <button class="btn btn-primary mt-3 w-100" onclick="generateIncomeReport()">
                        <i class="fas fa-download"></i> Descargar Reporte
                    </button>
                </div>
            </div>
        </div>
        
        <div class="glass-card p-4">
            <h5 class="mb-3"><i class="fas fa-file-alt"></i> Reportes Rápidos</h5>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <button class="btn btn-outline-primary w-100" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Exportar Usuarios
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-outline-success w-100" onclick="exportPaymentsToExcel()">
                        <i class="fas fa-file-excel"></i> Exportar Pagos
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-outline-danger w-100" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </button>
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-outline-info w-100" onclick="printReport()">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SETTINGS SECTION -->
    <div id="settingsSection" style="display: none;">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-user-shield"></i> Perfil de Usuario</h5>
                    <form id="profileForm">
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" id="profileName" class="form-control" value="Admin Nexus">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" id="profileEmail" class="form-control" value="admin@gympower.com">
                        </div>
                        <div class="mb-3">
                            <label>Teléfono</label>
                            <input type="tel" id="profilePhone" class="form-control" value="+1234567890">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="updateProfile()">
                            Actualizar Perfil
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-palette"></i> Apariencia</h5>
                    <div class="mb-3">
                        <label>Tema</label>
                        <select id="themeSelect" class="form-select" onchange="changeTheme()">
                            <option value="light">Claro</option>
                            <option value="dark">Oscuro</option>
                            <option value="auto">Automático</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Idioma</label>
                        <select id="languageSelect" class="form-select" onchange="changeLanguage()">
                            <option value="es">Español</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="glass-card p-4">
            <h5 class="mb-3"><i class="fas fa-database"></i> Respaldo de Datos</h5>
            <button class="btn btn-warning" onclick="backupData()">
                <i class="fas fa-download"></i> Respaldar Datos
            </button>
            <button class="btn btn-danger ms-2" onclick="restoreData()">
                <i class="fas fa-upload"></i> Restaurar Respaldo
            </button>
            <button class="btn btn-info ms-2" onclick="clearData()">
                <i class="fas fa-trash"></i> Limpiar Datos
            </button>
        </div>
    </div>
</div>

<!-- Modales -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editUserId">
                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" id="userName" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" id="userEmail" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Rol</label>
                    <select id="userRole" class="form-select">
                        <option value="cliente">Cliente</option>
                        <option value="entrenador">Entrenador</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Estado</label>
                    <select id="userStatus" class="form-select">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" onclick="saveUser()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="classModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editClassId">
                <div class="mb-3">
                    <label>Nombre Clase</label>
                    <input type="text" id="className" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Instructor</label>
                    <input type="text" id="classInstructor" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Fecha y Hora</label>
                    <input type="datetime-local" id="classDateTime" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Capacidad</label>
                    <input type="number" id="classCapacity" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" onclick="saveClass()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Usuario</label>
                    <select id="paymentUser" class="form-select"></select>
                </div>
                <div class="mb-3">
                    <label>Monto</label>
                    <input type="number" id="paymentAmount" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Concepto</label>
                    <input type="text" id="paymentConcept" class="form-control" value="Membresía">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" onclick="registerPayment()">Registrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
    // ==================== DATA MODELS ====================
    let users = [
        { id: 1, name: "Carlos Rodríguez", email: "carlos@email.com", role: "admin", status: "activo", phone: "123456789", membership: "VIP" },
        { id: 2, name: "María González", email: "maria@email.com", role: "entrenador", status: "activo", phone: "123456789", membership: "Premium" },
        { id: 3, name: "Juan Pérez", email: "juan@email.com", role: "cliente", status: "activo", phone: "123456789", membership: "Básica" },
        { id: 4, name: "Ana Martínez", email: "ana@email.com", role: "cliente", status: "inactivo", phone: "123456789", membership: "Básica" }
    ];

    let classes = [
        { id: 1, name: "Yoga", instructor: "María González", date: "2024-01-20 10:00", capacity: 20, enrolled: 15 },
        { id: 2, name: "CrossFit", instructor: "Carlos Rodríguez", date: "2024-01-20 15:00", capacity: 15, enrolled: 12 },
        { id: 3, name: "Spinning", instructor: "Luis Fernández", date: "2024-01-21 09:00", capacity: 25, enrolled: 20 }
    ];

    let payments = [
        { id: 1, userId: 1, amount: 99, date: "2024-01-01", concept: "Membresía VIP", status: "completado" },
        { id: 2, userId: 2, amount: 59, date: "2024-01-02", concept: "Membresía Premium", status: "completado" },
        { id: 3, userId: 3, amount: 29, date: "2024-01-03", concept: "Membresía Básica", status: "completado" },
        { id: 4, userId: 4, amount: 29, date: "2023-12-15", concept: "Membresía Básica", status: "pendiente" }
    ];

    let nextUserId = 5;
    let nextClassId = 4;
    let nextPaymentId = 5;

    let calendar = null;
    let trendChart, distributionChart, usersReportChart, incomeReportChart;

    // ==================== INITIALIZATION ====================
    $(document).ready(function() {
        initCharts();
        updateDashboard();
        renderUsersTable();
        renderPaymentsTable();
        initCalendar();
        updatePopularClasses();
        updateUpcomingClasses();
        updateNotifications();
        
        setInterval(() => {
            updateDashboard();
            updateNotifications();
        }, 5000);
    });

    // ==================== NAVIGATION ====================
    function switchToPage(page) {
        $('.nav-link').removeClass('active');
        $(`.nav-link[data-page="${page}"]`).addClass('active');
        
        $('#dashboardSection, #usersSection, #classesSection, #paymentsSection, #reportsSection, #settingsSection').hide();
        
        if (page === 'dashboard') {
            $('#dashboardSection').show();
            $('#pageTitle').text('Dashboard');
            updateDashboard();
        } else if (page === 'users') {
            $('#usersSection').show();
            $('#pageTitle').text('Gestión de Usuarios');
            renderUsersTable();
        } else if (page === 'classes') {
            $('#classesSection').show();
            $('#pageTitle').text('Clases');
            if (calendar) calendar.render();
            updatePopularClasses();
            updateUpcomingClasses();
        } else if (page === 'payments') {
            $('#paymentsSection').show();
            $('#pageTitle').text('Pagos');
            renderPaymentsTable();
        } else if (page === 'reports') {
            $('#reportsSection').show();
            $('#pageTitle').text('Reportes');
            updateReportCharts();
        } else if (page === 'settings') {
            $('#settingsSection').show();
            $('#pageTitle').text('Configuración');
        }
    }

    $('.nav-link').click(function() {
        let page = $(this).data('page');
        switchToPage(page);
    });

    $('#toggleSidebar').click(function() {
        $('#sidebar').toggleClass('collapsed');
        $('#mainContent').toggleClass('expanded');
    });

    // ==================== DASHBOARD ====================
    function initCharts() {
        const ctx1 = document.getElementById('trendChart').getContext('2d');
        trendChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Usuarios',
                    data: [4, 6, 8, 12, 15, 18],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        const ctx2 = document.getElementById('distributionChart').getContext('2d');
        distributionChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Administradores', 'Entrenadores', 'Clientes'],
                datasets: [{
                    data: [1, 1, 2],
                    backgroundColor: ['#667eea', '#f093fb', '#4facfe']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }

    function updateDashboard() {
        $('#dashTotalUsers').text(users.length);
        $('#dashTotalClasses').text(classes.length);
        
        let totalIncome = payments.filter(p => p.status === 'completado').reduce((sum, p) => sum + p.amount, 0);
        $('#dashTotalIncome').text(totalIncome);
        
        let activeUsers = users.filter(u => u.status === 'activo').length;
        let retention = Math.round((activeUsers / users.length) * 100);
        $('#dashRetention').text(retention);
        
        if (trendChart) {
            trendChart.data.datasets[0].data = [4, 6, 8, users.length, users.length + 2, users.length + 5];
            trendChart.update();
        }
        
        if (distributionChart) {
            let admins = users.filter(u => u.role === 'admin').length;
            let trainers = users.filter(u => u.role === 'entrenador').length;
            let clients = users.filter(u => u.role === 'cliente').length;
            distributionChart.data.datasets[0].data = [admins, trainers, clients];
            distributionChart.update();
        }
    }

    // ==================== USERS SECTION ====================
    function renderUsersTable() {
        let search = $('#userSearch').val().toLowerCase();
        let role = $('#roleFilter').val();
        let status = $('#statusFilter').val();
        
        let filtered = users.filter(u => {
            let matchSearch = u.name.toLowerCase().includes(search) || u.email.toLowerCase().includes(search);
            let matchRole = !role || u.role === role;
            let matchStatus = !status || u.status === status;
            return matchSearch && matchRole && matchStatus;
        });
        
        let html = '';
        filtered.forEach(user => {
            let statusBadge = user.status === 'activo' ? 'bg-success' : 'bg-secondary';
            let roleBadge = user.role === 'admin' ? 'bg-danger' : (user.role === 'entrenador' ? 'bg-warning' : 'bg-info');
            
            html += `
                <tr>
                    <td>${user.id}</td>
                    <td><strong>${user.name}</strong></td>
                    <td>${user.email}</td>
                    <td><span class="badge ${roleBadge}">${user.role}</span></td>
                    <td><span class="badge ${statusBadge}">${user.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="editUser(${user.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
        
        $('#usersTableBody').html(html);
    }

    function showUserModal() {
        $('#editUserId').val('');
        $('#userName').val('');
        $('#userEmail').val('');
        $('#userRole').val('cliente');
        $('#userStatus').val('activo');
        $('#userModal').modal('show');
    }

    function editUser(id) {
        let user = users.find(u => u.id === id);
        if (user) {
            $('#editUserId').val(user.id);
            $('#userName').val(user.name);
            $('#userEmail').val(user.email);
            $('#userRole').val(user.role);
            $('#userStatus').val(user.status);
            $('#userModal').modal('show');
        }
    }

    function saveUser() {
        let id = $('#editUserId').val();
        let userData = {
            name: $('#userName').val(),
            email: $('#userEmail').val(),
            role: $('#userRole').val(),
            status: $('#userStatus').val(),
            phone: '123456789',
            membership: 'Básica'
        };
        
        if (id) {
            let index = users.findIndex(u => u.id == id);
            if (index !== -1) {
                users[index] = { ...users[index], ...userData };
                Swal.fire('Éxito', 'Usuario actualizado', 'success');
            }
        } else {
            userData.id = nextUserId++;
            users.push(userData);
            Swal.fire('Éxito', 'Usuario creado', 'success');
        }
        
        $('#userModal').modal('hide');
        renderUsersTable();
        updateDashboard();
        updateNotifications();
    }

    async function deleteUser(id) {
        let result = await Swal.fire({
            title: '¿Eliminar usuario?',
            text: 'No se puede revertir',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        });
        
        if (result.isConfirmed) {
            users = users.filter(u => u.id !== id);
            renderUsersTable();
            updateDashboard();
            Swal.fire('Eliminado', 'Usuario eliminado', 'success');
        }
    }

    // ==================== CLASSES SECTION ====================
    function initCalendar() {
        let calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: classes.map(c => ({
                id: c.id,
                title: `${c.name} - ${c.instructor}`,
                start: c.date,
                extendedProps: { capacity: c.capacity, enrolled: c.enrolled }
            })),
            eventClick: function(info) {
                Swal.fire({
                    title: info.event.title,
                    html: `
                        <strong>Instructor:</strong> ${info.event.extendedProps.instructor}<br>
                        <strong>Capacidad:</strong> ${info.event.extendedProps.enrolled}/${info.event.extendedProps.capacity}
                    `,
                    icon: 'info'
                });
            }
        });
        calendar.render();
    }

    function showClassModal() {
        $('#editClassId').val('');
        $('#className').val('');
        $('#classInstructor').val('');
        $('#classDateTime').val('');
        $('#classCapacity').val('');
        $('#classModal').modal('show');
    }

    function saveClass() {
        let id = $('#editClassId').val();
        let classData = {
            name: $('#className').val(),
            instructor: $('#classInstructor').val(),
            date: $('#classDateTime').val(),
            capacity: parseInt($('#classCapacity').val()),
            enrolled: 0
        };
        
        if (id) {
            let index = classes.findIndex(c => c.id == id);
            if (index !== -1) {
                classes[index] = { ...classes[index], ...classData };
                Swal.fire('Éxito', 'Clase actualizada', 'success');
            }
        } else {
            classData.id = nextClassId++;
            classes.push(classData);
            Swal.fire('Éxito', 'Clase creada', 'success');
        }
        
        $('#classModal').modal('hide');
        calendar.refetchEvents();
        updatePopularClasses();
        updateUpcomingClasses();
        updateDashboard();
    }

    function updatePopularClasses() {
        let popular = [...classes].sort((a,b) => b.enrolled - a.enrolled).slice(0,3);
        let html = '<div class="list-group">';
        popular.forEach(c => {
            let percent = (c.enrolled / c.capacity) * 100;
            html += `
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <strong>${c.name}</strong>
                        <span>${c.enrolled}/${c.capacity}</span>
                    </div>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-success" style="width: ${percent}%"></div>
                    </div>
                    <small class="text-muted">Instructor: ${c.instructor}</small>
                </div>
            `;
        });
        html += '</div>';
        $('#popularClasses').html(html);
    }

    function updateUpcomingClasses() {
        let now = new Date();
        let upcoming = classes.filter(c => new Date(c.date) > now).slice(0,3);
        let html = '<div class="list-group">';
        upcoming.forEach(c => {
            let date = new Date(c.date);
            html += `
                <div class="list-group-item">
                    <strong>${c.name}</strong><br>
                    <small><i class="fas fa-clock"></i> ${date.toLocaleString()}</small><br>
                    <small><i class="fas fa-chalkboard-user"></i> ${c.instructor}</small>
                </div>
            `;
        });
        html += '</div>';
        $('#upcomingClasses').html(html);
    }

    // ==================== PAYMENTS SECTION ====================
    function renderPaymentsTable() {
        let html = '';
        payments.forEach(payment => {
            let user = users.find(u => u.id === payment.userId);
            let statusBadge = payment.status === 'completado' ? 'bg-success' : 'bg-warning';
            
            html += `
                <tr>
                    <td>${payment.id}</td>
                    <td>${user ? user.name : 'N/A'}</td>
                    <td>$${payment.amount}</td>
                    <td>${payment.date}</td>
                    <td><span class="badge ${statusBadge}">${payment.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="deletePayment(${payment.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        $('#paymentsTableBody').html(html);
        
        let total = payments.filter(p => p.status === 'completado').reduce((sum, p) => sum + p.amount, 0);
        let pending = payments.filter(p => p.status === 'pendiente').reduce((sum, p) => sum + p.amount, 0);
        
        $('#totalPayments').text(total);
        $('#pendingPayments').text(pending);
        $('#transactionCount').text(payments.length);
    }

    function showPaymentModal() {
        let options = '<option value="">Seleccionar usuario</option>';
        users.forEach(u => {
            options += `<option value="${u.id}">${u.name} - ${u.membership}</option>`;
        });
        $('#paymentUser').html(options);
        $('#paymentAmount').val('');
        $('#paymentConcept').val('Membresía');
        $('#paymentModal').modal('show');
    }

    function registerPayment() {
        let paymentData = {
            id: nextPaymentId++,
            userId: parseInt($('#paymentUser').val()),
            amount: parseFloat($('#paymentAmount').val()),
            date: new Date().toISOString().split('T')[0],
            concept: $('#paymentConcept').val(),
            status: 'completado'
        };
        
        if (!paymentData.userId || !paymentData.amount) {
            Swal.fire('Error', 'Complete todos los campos', 'error');
            return;
        }
        
        payments.push(paymentData);
        $('#paymentModal').modal('hide');
        renderPaymentsTable();
        updateDashboard();
        Swal.fire('Éxito', 'Pago registrado', 'success');
    }

    function deletePayment(id) {
        Swal.fire({
            title: '¿Eliminar pago?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then(result => {
            if (result.isConfirmed) {
                payments = payments.filter(p => p.id !== id);
                renderPaymentsTable();
                updateDashboard();
                Swal.fire('Eliminado', 'Pago eliminado', 'success');
            }
        });
    }

    // ==================== REPORTS SECTION ====================
    function updateReportCharts() {
        const ctx1 = document.getElementById('usersReportChart').getContext('2d');
        if (usersReportChart) usersReportChart.destroy();
        
        let roles = ['admin', 'entrenador', 'cliente'];
        let counts = roles.map(r => users.filter(u => u.role === r).length);
        
        usersReportChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Administradores', 'Entrenadores', 'Clientes'],
                datasets: [{
                    label: 'Cantidad',
                    data: counts,
                    backgroundColor: '#667eea'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        
        const ctx2 = document.getElementById('incomeReportChart').getContext('2d');
        if (incomeReportChart) incomeReportChart.destroy();
        
        let months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
        let incomes = [500, 800, 1200, 1500, 1800, 2000];
        
        incomeReportChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Ingresos ($)',
                    data: incomes,
                    borderColor: '#4facfe',
                    backgroundColor: 'rgba(79, 172, 254, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }

    function generateUserReport() {
        let reportData = users.map(u => ({
            Nombre: u.name,
            Email: u.email,
            Rol: u.role,
            Estado: u.status,
            Membresía: u.membership
        }));
        
        console.table(reportData);
        Swal.fire('Reporte Generado', 'Se ha generado el reporte de usuarios', 'success');
    }

    function generateIncomeReport() {
        let total = payments.filter(p => p.status === 'completado').reduce((sum, p) => sum + p.amount, 0);
        Swal.fire('Reporte de Ingresos', `Total ingresos: $${total}`, 'success');
    }

    function exportToExcel() {
        const wsData = users.map(u => ({
            ID: u.id,
            Nombre: u.name,
            Email: u.email,
            Rol: u.role,
            Estado: u.status,
            Membresía: u.membership
        }));
        
        const ws = XLSX.utils.json_to_sheet(wsData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Usuarios');
        XLSX.writeFile(wb, `usuarios_${new Date().toISOString().split('T')[0]}.xlsx`);
        
        Swal.fire('Exportado', 'Archivo Excel generado', 'success');
    }

    function exportPaymentsToExcel() {
        const wsData = payments.map(p => {
            let user = users.find(u => u.id === p.userId);
            return {
                ID: p.id,
                Usuario: user ? user.name : 'N/A',
                Monto: p.amount,
                Fecha: p.date,
                Concepto: p.concept,
                Estado: p.status
            };
        });
        
        const ws = XLSX.utils.json_to_sheet(wsData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Pagos');
        XLSX.writeFile(wb, `pagos_${new Date().toISOString().split('T')[0]}.xlsx`);
        
        Swal.fire('Exportado', 'Archivo Excel generado', 'success');
    }

    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        doc.text('Reporte de Usuarios - GymPower', 14, 15);
        doc.text(`Generado: ${new Date().toLocaleString()}`, 14, 25);
        
        const tableData = users.map(u => [u.id, u.name, u.email, u.role, u.status]);
        doc.autoTable({
            head: [['ID', 'Nombre', 'Email', 'Rol', 'Estado']],
            body: tableData,
            startY: 35
        });
        
        doc.save(`reporte_${new Date().toISOString().split('T')[0]}.pdf`);
        Swal.fire('Exportado', 'Archivo PDF generado', 'success');
    }

    function printReport() {
        window.print();
    }

    // ==================== SETTINGS SECTION ====================
    function updateProfile() {
        Swal.fire('Perfil Actualizado', 'Los cambios han sido guardados', 'success');
    }

    function changeTheme() {
        let theme = $('#themeSelect').val();
        if (theme === 'dark') {
            $('body').css('background', 'linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)');
            $('.glass-card').css('background', 'rgba(0, 0, 0, 0.8)');
            $('.stat-card').css('background', 'rgba(0, 0, 0, 0.8)');
            $('.stat-card').css('color', 'white');
        } else {
            $('body').css('background', 'linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%)');
            $('.glass-card').css('background', 'rgba(255, 255, 255, 0.95)');
            $('.stat-card').css('background', 'white');
            $('.stat-card').css('color', 'black');
        }
        Swal.fire('Tema Cambiado', `Tema: ${theme}`, 'success');
    }

    function changeLanguage() {
        let lang = $('#languageSelect').val();
        Swal.fire('Idioma Cambiado', `Idioma: ${lang === 'es' ? 'Español' : 'English'}`, 'success');
    }

    function backupData() {
        let data = { users, classes, payments };
        localStorage.setItem('gympower_backup', JSON.stringify(data));
        Swal.fire('Respaldo Creado', 'Datos respaldados correctamente', 'success');
    }

    function restoreData() {
        let backup = localStorage.getItem('gympower_backup');
        if (backup) {
            let data = JSON.parse(backup);
            users = data.users;
            classes = data.classes;
            payments = data.payments;
            renderUsersTable();
            renderPaymentsTable();
            calendar.refetchEvents();
            updateDashboard();
            Swal.fire('Restaurado', 'Datos restaurados correctamente', 'success');
        } else {
            Swal.fire('Error', 'No hay respaldo disponible', 'error');
        }
    }

    function clearData() {
        Swal.fire({
            title: '¿Limpiar datos?',
            text: 'Esta acción eliminará todos los datos',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, limpiar'
        }).then(result => {
            if (result.isConfirmed) {
                users = [];
                classes = [];
                payments = [];
                renderUsersTable();
                renderPaymentsTable();
                calendar.refetchEvents();
                updateDashboard();
                Swal.fire('Datos Limpiados', 'Todos los datos han sido eliminados', 'success');
            }
        });
    }

    // ==================== NOTIFICATIONS ====================
    function updateNotifications() {
        let notifications = [];
        
        let pendingPayments = payments.filter(p => p.status === 'pendiente');
        if (pendingPayments.length > 0) {
            notifications.push(`${pendingPayments.length} pagos pendientes`);
        }
        
        let upcomingClasses = classes.filter(c => {
            let classDate = new Date(c.date);
            let now = new Date();
            let diff = classDate - now;
            return diff > 0 && diff < 86400000;
        });
        
        if (upcomingClasses.length > 0) {
            notifications.push(`${upcomingClasses.length} clases en las próximas 24 horas`);
        }
        
        $('#notificationCount').text(notifications.length);
        
        let html = '';
        if (notifications.length === 0) {
            html = '<li><a class="dropdown-item" href="#">No hay notificaciones</a></li>';
        } else {
            notifications.forEach(n => {
                html += `<li><a class="dropdown-item" href="#">🔔 ${n}</a></li>`;
            });
        }
        $('#notificationList').html(html);
    }

    // ==================== UTILITIES ====================
    function showProfile() {
        Swal.fire({
            title: 'Mi Perfil',
            html: `
                <strong>Nombre:</strong> Admin Nexus<br>
                <strong>Email:</strong> admin@gympower.com<br>
                <strong>Rol:</strong> Super Administrador<br>
                <strong>Membresía:</strong> VIP
            `,
            icon: 'info'
        });
    }

    function logout() {
        Swal.fire({
            title: 'Cerrar Sesión',
            text: '¿Estás seguro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, salir'
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire('Hasta luego', 'Sesión cerrada', 'success');
            }
        });
    }

    // Event listeners for filters
    $('#userSearch, #roleFilter, #statusFilter').on('keyup change', renderUsersTable);
</script>
</body>
</html>