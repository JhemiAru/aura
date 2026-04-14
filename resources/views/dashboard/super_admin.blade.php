<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aura Gym | Sistema de Gestión</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-dark: linear-gradient(135deg, #5a67d8 0%, #6b46a0 100%);
            --secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --danger: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            overflow-x: hidden;
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
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            overflow-y: auto;
        }

        .sidebar.collapsed { width: 80px; }
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .nav-label,
        .sidebar.collapsed .user-info { display: none; }

        .sidebar-header { padding: 30px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 30px; }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 25px;
            margin: 5px 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-link:hover { background: rgba(255, 255, 255, 0.15); color: white; transform: translateX(5px); }
        .nav-link.active { background: var(--primary); color: white; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .nav-link i { width: 25px; margin-right: 12px; }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .main-content.expanded { margin-left: 80px; }

        /* Glass Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .glass-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .stat-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15); }

        .chart-container { position: relative; height: 300px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in-up { animation: fadeInUp 0.6s ease forwards; }

        .badge-modern { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        
        .fc { background: white; border-radius: 15px; padding: 20px; }
        
        .modern-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
        .modern-table tbody tr { background: white; transition: all 0.3s; }
        .modern-table tbody tr:hover { transform: scale(1.02); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header text-center">
        <h3 class="text-white"><i class="fas fa-dumbbell"></i> <span class="sidebar-text">AURA GYM</span></h3>
        <p class="text-white-50 sidebar-text">Sistema de Gestión</p>
    </div>
    
    <div class="user-info text-center mb-4 sidebar-text">
        <img src="https://ui-avatars.com/api/?background=667eea&color=fff&rounded=true&bold=true&size=80&name={{ Auth::user()->name }}" 
             class="rounded-circle mb-2" width="70" height="70">
        <h6 class="text-white mb-0">{{ Auth::user()->name }}</h6>
        <small class="text-white-50">{{ Auth::user()->role->name ?? 'Usuario' }}</small>
    </div>
    
    <nav>
        <div class="nav-link active" data-page="dashboard">
            <i class="fas fa-chart-pie"></i>
            <span class="sidebar-text">Dashboard</span>
        </div>
        <div class="nav-link" data-page="members">
            <i class="fas fa-users"></i>
            <span class="sidebar-text">Socios</span>
        </div>
        <div class="nav-link" data-page="payments">
            <i class="fas fa-credit-card"></i>
            <span class="sidebar-text">Pagos</span>
        </div>
        <div class="nav-link" data-page="attendance">
            <i class="fas fa-calendar-check"></i>
            <span class="sidebar-text">Asistencias</span>
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
    
    <div style="position: absolute; bottom: 20px; width: 100%; padding: 0 15px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt"></i> <span class="sidebar-text">Cerrar Sesión</span>
            </button>
        </form>
    </div>
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
                        <img src="https://ui-avatars.com/api/?background=667eea&color=fff&rounded=true&bold=true&size=40&name={{ Auth::user()->name }}" 
                             width="40" height="40" class="rounded-circle">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="showProfile()"><i class="fas fa-user"></i> Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- DASHBOARD SECTION -->
    <div id="dashboardSection">
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card" onclick="switchToPage('members')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Socios</h6>
                            <h2 class="mb-0" id="dashTotalMembers">{{ $totalMembers ?? 0 }}</h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> Activos</small>
                        </div>
                        <div class="bg-primary text-white rounded p-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" onclick="switchToPage('attendance')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Asistencias Hoy</h6>
                            <h2 class="mb-0" id="dashTodayAttendance">{{ $todayAttendance ?? 0 }}</h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> Registros</small>
                        </div>
                        <div class="bg-success text-white rounded p-3">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" onclick="switchToPage('payments')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Ingresos Totales</h6>
                            <h2 class="mb-0">$<span id="dashTotalIncome">{{ number_format($totalPayments ?? 0, 2) }}</span></h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> Este mes</small>
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
                            <h6 class="text-muted">Membresías Activas</h6>
                            <h2 class="mb-0" id="dashActiveMemberships">0</h2>
                            <small class="text-success">En vigencia</small>
                        </div>
                        <div class="bg-info text-white rounded p-3">
                            <i class="fas fa-id-card fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-chart-line"></i> Tendencia de Ingresos</h5>
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-chart-pie"></i> Distribución por Género</h5>
                    <div class="chart-container">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-clock"></i> Próximos Vencimientos</h5>
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead class="table-dark">
                                <tr><th>Socio</th><th>Membresía</th><th>Fecha Vencimiento</th><th>Días Restantes</th><th>Acciones</th></tr>
                            </thead>
                            <tbody id="expiringMembersTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MEMBERS SECTION -->
    <div id="membersSection" style="display: none;">
        <div class="glass-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5><i class="fas fa-users"></i> Gestión de Socios</h5>
                <button class="btn btn-primary" onclick="showMemberModal()">
                    <i class="fas fa-plus"></i> Nuevo Socio
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="memberSearch" class="form-control" placeholder="Buscar socio...">
                </div>
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="active">Activo</option>
                        <option value="inactive">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="modern-table" id="membersTable">
                    <thead class="table-dark">
                        <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Membresía</th><th>Vencimiento</th><th>Estado</th><th>Acciones</th></tr>
                    </thead>
                    <tbody id="membersTableBody"></tbody>
                </table>
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
                    <h6 class="text-muted">Pagos Este Mes</h6>
                    <h2>$<span id="monthlyPayments">0</span></h2>
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
                        <tr><th>ID</th><th>Socio</th><th>Monto</th><th>Fecha</th><th>Método</th><th>Estado</th><th>Acciones</th></tr>
                    </thead>
                    <tbody id="paymentsTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ATTENDANCE SECTION -->
    <div id="attendanceSection" style="display: none;">
        <div class="glass-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5><i class="fas fa-calendar-check"></i> Control de Asistencias</h5>
                <button class="btn btn-success" onclick="checkIn()">
                    <i class="fas fa-sign-in-alt"></i> Registrar Entrada
                </button>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead class="table-dark">
                        <tr><th>ID</th><th>Socio</th><th>Entrada</th><th>Salida</th><th>Acciones</th></tr>
                    </thead>
                    <tbody id="attendanceTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- REPORTS SECTION -->
    <div id="reportsSection" style="display: none;">
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-chart-bar"></i> Reporte de Socios</h5>
                    <div class="chart-container">
                        <canvas id="usersReportChart"></canvas>
                    </div>
                    <button class="btn btn-primary mt-3 w-100" onclick="exportMembersToExcel()">
                        <i class="fas fa-file-excel"></i> Exportar Socios a Excel
                    </button>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="glass-card p-4">
                    <h5 class="mb-3"><i class="fas fa-chart-line"></i> Reporte de Ingresos</h5>
                    <div class="chart-container">
                        <canvas id="incomeReportChart"></canvas>
                    </div>
                    <button class="btn btn-primary mt-3 w-100" onclick="exportPaymentsToExcel()">
                        <i class="fas fa-file-excel"></i> Exportar Pagos a Excel
                    </button>
                </div>
            </div>
        </div>
        
        <div class="glass-card p-4">
            <h5 class="mb-3"><i class="fas fa-file-alt"></i> Reportes Rápidos</h5>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <button class="btn btn-outline-primary w-100" onclick="printReport()">
                        <i class="fas fa-print"></i> Imprimir Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SETTINGS SECTION -->
    <div id="settingsSection" style="display: none;">
        <div class="glass-card p-4">
            <h5 class="mb-3"><i class="fas fa-user-shield"></i> Información del Sistema</h5>
            <p><strong>Versión:</strong> Aura Gym v1.0</p>
            <p><strong>Usuario:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Rol:</strong> {{ Auth::user()->role->name ?? 'Usuario' }}</p>
            <hr>
            <h5 class="mb-3"><i class="fas fa-palette"></i> Apariencia</h5>
            <div class="mb-3">
                <label>Tema</label>
                <select id="themeSelect" class="form-select w-50" onchange="changeTheme()">
                    <option value="light">Claro</option>
                    <option value="dark">Oscuro</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Modales -->
<div class="modal fade" id="memberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Socio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editMemberId">
                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" id="memberName" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Apellido</label>
                    <input type="text" id="memberLastname" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" id="memberEmail" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Teléfono</label>
                    <input type="text" id="memberPhone" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Membresía</label>
                    <select id="memberMembership" class="form-select"></select>
                </div>
                <div class="mb-3">
                    <label>Fecha Inicio</label>
                    <input type="date" id="memberStartDate" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Fecha Vencimiento</label>
                    <input type="date" id="memberEndDate" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Estado</label>
                    <select id="memberStatus" class="form-select">
                        <option value="active">Activo</option>
                        <option value="inactive">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" onclick="saveMember()">Guardar</button>
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
                    <label>Socio</label>
                    <select id="paymentMember" class="form-select"></select>
                </div>
                <div class="mb-3">
                    <label>Monto</label>
                    <input type="number" id="paymentAmount" class="form-control" step="0.01">
                </div>
                <div class="mb-3">
                    <label>Método de Pago</label>
                    <select id="paymentMethod" class="form-select">
                        <option value="cash">Efectivo</option>
                        <option value="card">Tarjeta</option>
                        <option value="transfer">Transferencia</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Fecha</label>
                    <input type="date" id="paymentDate" class="form-control">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    // ==================== VARIABLES GLOBALES ====================
    let trendChart, distributionChart, usersReportChart, incomeReportChart;
    let membersData = @json($members ?? []);
    let paymentsData = @json($payments ?? []);
    let attendancesData = @json($attendances ?? []);
    let membershipsData = @json($memberships ?? []);

    // ==================== INICIALIZACIÓN ====================
    $(document).ready(function() {
        initCharts();
        loadMembers();
        loadPayments();
        loadAttendances();
        loadExpiringMembers();
        loadMembershipsForSelect();
        updateNotifications();
        
        setInterval(() => {
            updateDashboardStats();
            updateNotifications();
        }, 30000);
    });

    function initCharts() {
        const ctx1 = document.getElementById('trendChart').getContext('2d');
        trendChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Ingresos ($)',
                    data: [500, 800, 1200, 1500, 1800, 2000],
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
                labels: ['Hombres', 'Mujeres'],
                datasets: [{ data: [60, 40], backgroundColor: ['#667eea', '#f093fb'] }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        
        // Report charts
        if (document.getElementById('usersReportChart')) {
            const ctx3 = document.getElementById('usersReportChart').getContext('2d');
            usersReportChart = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: ['Activos', 'Inactivos'],
                    datasets: [{ label: 'Socios', data: [0, 0], backgroundColor: '#667eea' }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }
        
        if (document.getElementById('incomeReportChart')) {
            const ctx4 = document.getElementById('incomeReportChart').getContext('2d');
            incomeReportChart = new Chart(ctx4, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                    datasets: [{ label: 'Ingresos ($)', data: [0, 0, 0, 0, 0, 0], borderColor: '#4facfe', tension: 0.4, fill: true }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }
    }

    function updateDashboardStats() {
        $.ajax({
            url: '{{ route("dashboard.stats") }}',
            type: 'GET',
            success: function(data) {
                $('#dashTotalMembers').text(data.totalMembers);
                $('#dashTodayAttendance').text(data.todayAttendance);
                $('#dashTotalIncome').text(data.totalIncome);
                if (trendChart) trendChart.update();
                if (distributionChart) distributionChart.update();
            }
        });
    }

    // ==================== NAVEGACIÓN ====================
    function switchToPage(page) {
        $('.nav-link').removeClass('active');
        $(`.nav-link[data-page="${page}"]`).addClass('active');
        
        $('#dashboardSection, #membersSection, #paymentsSection, #attendanceSection, #reportsSection, #settingsSection').hide();
        
        if (page === 'dashboard') {
            $('#dashboardSection').show();
            $('#pageTitle').text('Dashboard');
            updateDashboardStats();
        } else if (page === 'members') {
            $('#membersSection').show();
            $('#pageTitle').text('Gestión de Socios');
            loadMembers();
        } else if (page === 'payments') {
            $('#paymentsSection').show();
            $('#pageTitle').text('Pagos');
            loadPayments();
        } else if (page === 'attendance') {
            $('#attendanceSection').show();
            $('#pageTitle').text('Asistencias');
            loadAttendances();
        } else if (page === 'reports') {
            $('#reportsSection').show();
            $('#pageTitle').text('Reportes');
            updateReportCharts();
        } else if (page === 'settings') {
            $('#settingsSection').show();
            $('#pageTitle').text('Configuración');
        }
    }

    $('#toggleSidebar').click(function() {
        $('#sidebar').toggleClass('collapsed');
        $('#mainContent').toggleClass('expanded');
    });

    $('.nav-link').click(function() {
        let page = $(this).data('page');
        switchToPage(page);
    });

    // ==================== MIEMBROS (CRUD) ====================
    function loadMembers() {
        $.ajax({
            url: '{{ route("api.members") }}',
            type: 'GET',
            success: function(data) {
                membersData = data;
                renderMembersTable(data);
            },
            error: function() {
                renderMembersTable(membersData);
            }
        });
    }

    function renderMembersTable(members) {
        let search = $('#memberSearch').val().toLowerCase();
        let status = $('#statusFilter').val();
        
        let filtered = members.filter(m => {
            let matchSearch = (m.name + ' ' + m.lastname + ' ' + m.email).toLowerCase().includes(search);
            let matchStatus = !status || m.status === status;
            return matchSearch && matchStatus;
        });
        
        let html = '';
        filtered.forEach(m => {
            let statusBadge = m.status === 'active' ? 'bg-success' : 'bg-secondary';
            html += `
                <tr>
                    <td>${m.id}</td>
                    <td><strong>${m.name} ${m.lastname}</strong></td>
                    <td>${m.email}</td>
                    <td>${m.phone || '-'}</td>
                    <td>${m.membership_name || 'N/A'}</td>
                    <td>${m.end_date || '-'}</td>
                    <td><span class="badge ${statusBadge}">${m.status === 'active' ? 'Activo' : 'Inactivo'}</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="editMember(${m.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteMember(${m.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
        $('#membersTableBody').html(html);
    }

    function showMemberModal() {
        $('#editMemberId').val('');
        $('#memberName').val('');
        $('#memberLastname').val('');
        $('#memberEmail').val('');
        $('#memberPhone').val('');
        $('#memberStartDate').val(new Date().toISOString().split('T')[0]);
        $('#memberEndDate').val('');
        $('#memberStatus').val('active');
        $('#memberModal').modal('show');
    }

    function editMember(id) {
        let member = membersData.find(m => m.id === id);
        if (member) {
            $('#editMemberId').val(member.id);
            $('#memberName').val(member.name);
            $('#memberLastname').val(member.lastname);
            $('#memberEmail').val(member.email);
            $('#memberPhone').val(member.phone);
            $('#memberMembership').val(member.membership_id);
            $('#memberStartDate').val(member.start_date);
            $('#memberEndDate').val(member.end_date);
            $('#memberStatus').val(member.status);
            $('#memberModal').modal('show');
        }
    }

    function saveMember() {
        let id = $('#editMemberId').val();
        let data = {
            name: $('#memberName').val(),
            lastname: $('#memberLastname').val(),
            email: $('#memberEmail').val(),
            phone: $('#memberPhone').val(),
            membership_id: $('#memberMembership').val(),
            start_date: $('#memberStartDate').val(),
            end_date: $('#memberEndDate').val(),
            status: $('#memberStatus').val(),
            _token: '{{ csrf_token() }}'
        };
        
        let url = id ? `/members/${id}` : '/members';
        let method = id ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                $('#memberModal').modal('hide');
                Swal.fire('Éxito', id ? 'Socio actualizado' : 'Socio creado', 'success');
                loadMembers();
                updateDashboardStats();
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema', 'error');
            }
        });
    }

    function deleteMember(id) {
        Swal.fire({
            title: '¿Eliminar socio?',
            text: 'No se puede revertir',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/members/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        Swal.fire('Eliminado', 'Socio eliminado', 'success');
                        loadMembers();
                        updateDashboardStats();
                    }
                });
            }
        });
    }

    // ==================== PAGOS ====================
    function loadPayments() {
        $.ajax({
            url: '{{ route("api.payments") }}',
            type: 'GET',
            success: function(data) {
                paymentsData = data;
                renderPaymentsTable(data);
                updatePaymentStats(data);
            }
        });
    }

    function renderPaymentsTable(payments) {
        let html = '';
        payments.forEach(p => {
            html += `
                <tr>
                    <td>${p.id}</td>
                    <td>${p.member_name || 'N/A'}</td>
                    <td>$${parseFloat(p.amount).toFixed(2)}</td>
                    <td>${p.payment_date}</td>
                    <td><span class="badge bg-info">${p.payment_method}</span></td>
                    <td><span class="badge bg-success">${p.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="deletePayment(${p.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
        $('#paymentsTableBody').html(html);
    }

    function updatePaymentStats(payments) {
        let total = payments.reduce((sum, p) => sum + parseFloat(p.amount), 0);
        let monthly = payments.filter(p => p.payment_date && p.payment_date.startsWith(new Date().toISOString().slice(0,7)))
            .reduce((sum, p) => sum + parseFloat(p.amount), 0);
        $('#totalPayments').text(total.toFixed(2));
        $('#monthlyPayments').text(monthly.toFixed(2));
        $('#transactionCount').text(payments.length);
    }

    function showPaymentModal() {
        loadMembersForSelect();
        $('#paymentAmount').val('');
        $('#paymentDate').val(new Date().toISOString().split('T')[0]);
        $('#paymentModal').modal('show');
    }

    function loadMembersForSelect() {
        $.ajax({
            url: '{{ route("api.members.list") }}',
            type: 'GET',
            success: function(data) {
                let options = '<option value="">Seleccionar socio</option>';
                data.forEach(m => {
                    options += `<option value="${m.id}">${m.name} ${m.lastname}</option>`;
                });
                $('#paymentMember').html(options);
            }
        });
    }

    function loadMembershipsForSelect() {
        $.ajax({
            url: '{{ route("api.memberships") }}',
            type: 'GET',
            success: function(data) {
                let options = '';
                data.forEach(m => {
                    options += `<option value="${m.id}">${m.name} - $${m.price}</option>`;
                });
                $('#memberMembership').html(options);
            }
        });
    }

    function registerPayment() {
        let data = {
            member_id: $('#paymentMember').val(),
            amount: $('#paymentAmount').val(),
            payment_method: $('#paymentMethod').val(),
            payment_date: $('#paymentDate').val(),
            _token: '{{ csrf_token() }}'
        };
        
        if (!data.member_id || !data.amount) {
            Swal.fire('Error', 'Complete todos los campos', 'error');
            return;
        }
        
        $.ajax({
            url: '{{ route("api.payments.store") }}',
            type: 'POST',
            data: data,
            success: function() {
                $('#paymentModal').modal('hide');
                Swal.fire('Éxito', 'Pago registrado', 'success');
                loadPayments();
                updateDashboardStats();
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema', 'error');
            }
        });
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
                $.ajax({
                    url: `/payments/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        Swal.fire('Eliminado', 'Pago eliminado', 'success');
                        loadPayments();
                        updateDashboardStats();
                    }
                });
            }
        });
    }

    // ==================== ASISTENCIAS ====================
    function loadAttendances() {
        $.ajax({
            url: '{{ route("api.attendances") }}',
            type: 'GET',
            success: function(data) {
                renderAttendancesTable(data);
            }
        });
    }

    function renderAttendancesTable(attendances) {
        let html = '';
        attendances.forEach(a => {
            html += `
                <tr>
                    <td>${a.id}</td>
                    <td>${a.member_name || 'N/A'}</td>
                    <td>${a.check_in}</td>
                    <td>${a.check_out || 'No registrada'}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="checkOut(${a.id})"><i class="fas fa-sign-out-alt"></i> Salida</button>
                    </td>
                </tr>
            `;
        });
        $('#attendanceTableBody').html(html);
    }

    function checkIn() {
        Swal.fire({
            title: 'Registrar Entrada',
            input: 'select',
            inputOptions: getMembersList(),
            inputPlaceholder: 'Seleccionar socio',
            showCancelButton: true,
            confirmButtonText: 'Registrar'
        }).then(result => {
            if (result.isConfirmed && result.value) {
                $.ajax({
                    url: '{{ route("api.attendance.checkin") }}',
                    type: 'POST',
                    data: { member_id: result.value, _token: '{{ csrf_token() }}' },
                    success: function() {
                        Swal.fire('Entrada registrada', 'success');
                        loadAttendances();
                        updateDashboardStats();
                    }
                });
            }
        });
    }

    function checkOut(id) {
        $.ajax({
            url: `/attendance/${id}/checkout`,
            type: 'PUT',
            data: { _token: '{{ csrf_token() }}' },
            success: function() {
                Swal.fire('Salida registrada', 'success');
                loadAttendances();
            }
        });
    }

    function getMembersList() {
        let options = {};
        $.ajax({
            url: '{{ route("api.members.list") }}',
            type: 'GET',
            async: false,
            success: function(data) {
                data.forEach(m => { options[m.id] = `${m.name} ${m.lastname}`; });
            }
        });
        return options;
    }

    // ==================== VENCIMIENTOS ====================
    function loadExpiringMembers() {
        $.ajax({
            url: '{{ route("api.members.expiring") }}',
            type: 'GET',
            success: function(data) {
                let html = '';
                data.forEach(m => {
                    let daysLeft = Math.ceil((new Date(m.end_date) - new Date()) / (1000 * 60 * 60 * 24));
                    let badgeClass = daysLeft <= 7 ? 'bg-danger' : 'bg-warning';
                    html += `
                        <tr>
                            <td>${m.name} ${m.lastname}</td>
                            <td>${m.membership_name}</td>
                            <td>${m.end_date}</td>
                            <td><span class="badge ${badgeClass}">${daysLeft} días</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="renewMembership(${m.id})">Renovar</button>
                            </td>
                        </tr>
                    `;
                });
                $('#expiringMembersTable').html(html);
            }
        });
    }

    function renewMembership(id) {
        Swal.fire({
            title: 'Renovar Membresía',
            input: 'number',
            inputLabel: 'Días adicionales',
            inputValue: 30,
            showCancelButton: true,
            confirmButtonText: 'Renovar'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/members/${id}/renew`,
                    type: 'POST',
                    data: { days: result.value, _token: '{{ csrf_token() }}' },
                    success: function() {
                        Swal.fire('Membresía renovada', 'success');
                        loadMembers();
                        loadExpiringMembers();
                    }
                });
            }
        });
    }

    // ==================== REPORTES ====================
    function updateReportCharts() {
        $.ajax({
            url: '{{ route("api.reports.stats") }}',
            type: 'GET',
            success: function(data) {
                if (usersReportChart) {
                    usersReportChart.data.datasets[0].data = [data.activeMembers, data.inactiveMembers];
                    usersReportChart.update();
                }
                if (incomeReportChart) {
                    incomeReportChart.data.datasets[0].data = data.monthlyIncome;
                    incomeReportChart.update();
                }
            }
        });
    }

    function exportMembersToExcel() {
        $.ajax({
            url: '{{ route("api.members") }}',
            type: 'GET',
            success: function(data) {
                const wsData = data.map(m => ({
                    ID: m.id,
                    Nombre: `${m.name} ${m.lastname}`,
                    Email: m.email,
                    Teléfono: m.phone,
                    Membresía: m.membership_name,
                    Vencimiento: m.end_date,
                    Estado: m.status === 'active' ? 'Activo' : 'Inactivo'
                }));
                const ws = XLSX.utils.json_to_sheet(wsData);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Socios');
                XLSX.writeFile(wb, `socios_${new Date().toISOString().split('T')[0]}.xlsx`);
                Swal.fire('Exportado', 'Archivo Excel generado', 'success');
            }
        });
    }

    function exportPaymentsToExcel() {
        $.ajax({
            url: '{{ route("api.payments") }}',
            type: 'GET',
            success: function(data) {
                const wsData = data.map(p => ({
                    ID: p.id,
                    Socio: p.member_name,
                    Monto: p.amount,
                    Fecha: p.payment_date,
                    Método: p.payment_method
                }));
                const ws = XLSX.utils.json_to_sheet(wsData);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Pagos');
                XLSX.writeFile(wb, `pagos_${new Date().toISOString().split('T')[0]}.xlsx`);
                Swal.fire('Exportado', 'Archivo Excel generado', 'success');
            }
        });
    }

    function printReport() {
        window.print();
    }

    // ==================== NOTIFICACIONES ====================
    function updateNotifications() {
        $.ajax({
            url: '{{ route("api.notifications") }}',
            type: 'GET',
            success: function(data) {
                $('#notificationCount').text(data.length);
                let html = '';
                if (data.length === 0) {
                    html = '<li><a class="dropdown-item" href="#">No hay notificaciones</a></li>';
                } else {
                    data.forEach(n => {
                        html += `<li><a class="dropdown-item" href="#">🔔 ${n.message}</a></li>`;
                    });
                }
                $('#notificationList').html(html);
            }
        });
    }

    function showProfile() {
        Swal.fire({
            title: 'Mi Perfil',
            html: `
                <strong>Nombre:</strong> {{ Auth::user()->name }}<br>
                <strong>Email:</strong> {{ Auth::user()->email }}<br>
                <strong>Rol:</strong> {{ Auth::user()->role->name ?? 'Usuario' }}
            `,
            icon: 'info'
        });
    }

    function changeTheme() {
        let theme = $('#themeSelect').val();
        if (theme === 'dark') {
            $('body').css('background', 'linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)');
            $('.glass-card').css('background', 'rgba(0, 0, 0, 0.8)');
            $('.stat-card').css('background', 'rgba(0, 0, 0, 0.8)').css('color', 'white');
        } else {
            $('body').css('background', 'linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%)');
            $('.glass-card').css('background', 'rgba(255, 255, 255, 0.95)');
            $('.stat-card').css('background', 'white').css('color', 'black');
        }
        Swal.fire('Tema Cambiado', `Tema: ${theme === 'light' ? 'Claro' : 'Oscuro'}`, 'success');
    }

    // Event listeners
    $('#memberSearch, #statusFilter').on('keyup change', () => loadMembers());
</script>
</body>
</html>