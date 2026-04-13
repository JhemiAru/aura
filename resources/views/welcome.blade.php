{{-- resources/views/fitnessync.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FitnessSync Pro - Gestión Integral de Gimnasios</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f1e;
            overflow-x: hidden;
        }
        
        .sidebar-modern {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 10px 0 30px rgba(0,0,0,0.3);
        }
        
        .sidebar-modern.collapsed {
            width: 80px;
        }
        
        .sidebar-modern.collapsed .sidebar-text,
        .sidebar-modern.collapsed .logo-text {
            display: none;
        }
        
        .sidebar-modern.collapsed .nav-link i {
            margin-right: 0;
        }
        
        .sidebar-modern.collapsed .nav-link {
            justify-content: center;
            padding: 12px;
        }
        
        .logo-area {
            padding: 25px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 30px;
        }
        
        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 12px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }
        
        .nav-link:hover {
            background: rgba(0,210,255,0.1);
            color: #00d2ff;
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(0,210,255,0.3);
        }
        
        .main-content {
            margin-left: 280px;
            transition: all 0.3s;
            padding: 20px;
        }
        
        .main-content.expanded {
            margin-left: 80px;
        }
        
        .top-bar {
            background: rgba(26,26,46,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 15px 25px;
            margin-bottom: 25px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .stat-card-modern {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .stat-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,210,255,0.2);
        }
        
        .table-modern {
            background: #1a1a2e;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .table-modern thead {
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
        }
        
        .table-modern tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s;
        }
        
        .table-modern tbody tr:hover {
            background: rgba(0,210,255,0.05);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,210,255,0.4);
        }
        
        .modal-modern .modal-content {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
        }
        
        .modal-modern .modal-header {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            border-radius: 20px 20px 0 0;
        }
        
        .form-control, .form-select {
            background-color: #0f0f1e !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: white !important;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #00d2ff !important;
            box-shadow: 0 0 0 0.2rem rgba(0,210,255,0.25) !important;
        }
        
        .trainer-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .trainer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,210,255,0.2);
        }
        
        .trainer-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 40px;
        }
        
        .class-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .class-card:hover {
            transform: translateY(-5px);
        }
        
        .equipment-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
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
        
        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .badge-modern {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1a1a2e;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            border-radius: 10px;
        }
        
        .pagination .page-link {
            background: #1a1a2e;
            border-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .pagination .active .page-link {
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            border-color: transparent;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar-modern" id="sidebar">
        <div class="logo-area">
            <div class="d-flex align-items-center gap-3">
                <div class="logo-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <div class="logo-text">
                    <h4 class="text-white mb-0">FitnessSync</h4>
                    <small class="text-white-50">Pro Version</small>
                </div>
            </div>
        </div>
        
        <div class="nav flex-column">
            <div class="nav-link active" onclick="showSection('dashboard')">
                <i class="fas fa-tachometer-alt fa-fw"></i>
                <span class="sidebar-text">Dashboard</span>
            </div>
            <div class="nav-link" onclick="showSection('members')">
                <i class="fas fa-users fa-fw"></i>
                <span class="sidebar-text">Miembros</span>
            </div>
            <div class="nav-link" onclick="showSection('trainers')">
                <i class="fas fa-chalkboard-user fa-fw"></i>
                <span class="sidebar-text">Entrenadores</span>
            </div>
            <div class="nav-link" onclick="showSection('classes')">
                <i class="fas fa-calendar-alt fa-fw"></i>
                <span class="sidebar-text">Clases</span>
            </div>
            <div class="nav-link" onclick="showSection('attendance')">
                <i class="fas fa-fingerprint fa-fw"></i>
                <span class="sidebar-text">Asistencias</span>
            </div>
            <div class="nav-link" onclick="showSection('payments')">
                <i class="fas fa-credit-card fa-fw"></i>
                <span class="sidebar-text">Pagos</span>
            </div>
            <div class="nav-link" onclick="showSection('equipment')">
                <i class="fas fa-dumbbell fa-fw"></i>
                <span class="sidebar-text">Equipos</span>
            </div>
            <div class="nav-link" onclick="showSection('reports')">
                <i class="fas fa-chart-line fa-fw"></i>
                <span class="sidebar-text">Reportes</span>
            </div>
            <div class="nav-link" onclick="showSection('settings')">
                <i class="fas fa-cog fa-fw"></i>
                <span class="sidebar-text">Configuración</span>
            </div>
        </div>
        
        <div class="position-absolute bottom-0 w-100 p-3">
            <button class="btn btn-outline-light w-100" onclick="toggleSidebar()">
                <i class="fas fa-chevron-left" id="sidebarIcon"></i>
                <span class="sidebar-text">Colapsar</span>
            </button>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar d-flex justify-content-between align-items-center">
            <div>
                <h3 class="text-white mb-0" id="pageTitle">Dashboard</h3>
                <small class="text-white-50">Bienvenido de vuelta, Admin</small>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <div class="text-white">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <span id="currentDateTime"></span>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger position-absolute" id="notificationCount">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" id="notificationsList">
                        <a class="dropdown-item" href="#">📝 Nuevo miembro registrado</a>
                        <a class="dropdown-item" href="#">💰 Pago recibido de $80</a>
                        <a class="dropdown-item" href="#">🏋️ Clase de Yoga completada</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-light" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#" onclick="showProfile()"><i class="fas fa-user me-2"></i> Mi Perfil</a>
                        <a class="dropdown-item" href="#" onclick="showSettings()"><i class="fas fa-cog me-2"></i> Configuración</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- DASHBOARD SECTION -->
        <div id="dashboardSection">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stat-card-modern" onclick="filterMembers('all')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Total Miembros</small>
                                <h2 class="text-white mb-0" id="totalMembers">0</h2>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> +12% este mes</small>
                            </div>
                            <div>
                                <i class="fas fa-users fa-3x" style="color: #00d2ff; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card-modern" onclick="showPayments()">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Ingresos Mensuales</small>
                                <h2 class="text-white mb-0" id="monthlyIncome">$0</h2>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> +8% vs mes pasado</small>
                            </div>
                            <div>
                                <i class="fas fa-dollar-sign fa-3x" style="color: #00d2ff; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card-modern" onclick="showClasses()">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Clases Activas</small>
                                <h2 class="text-white mb-0" id="activeClasses">0</h2>
                                <small class="text-success"><i class="fas fa-calendar-check"></i> Esta semana</small>
                            </div>
                            <div>
                                <i class="fas fa-calendar-alt fa-3x" style="color: #00d2ff; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card-modern">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Tasa de Retención</small>
                                <h2 class="text-white mb-0" id="retentionRate">0%</h2>
                                <small class="text-success"><i class="fas fa-heart"></i> +5% mejora</small>
                            </div>
                            <div>
                                <i class="fas fa-chart-line fa-3x" style="color: #00d2ff; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-8 mb-3">
                    <div class="stat-card-modern">
                        <h5 class="text-white mb-3">Tendencia de Ingresos (Últimos 6 meses)</h5>
                        <canvas id="revenueChart" height="200"></canvas>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card-modern">
                        <h5 class="text-white mb-3">Distribución por Género</h5>
                        <canvas id="genderChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="stat-card-modern">
                <h5 class="text-white mb-3">Actividades Recientes</h5>
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr><th>Miembro</th><th>Actividad</th><th>Fecha</th><th>Estado</th></tr>
                        </thead>
                        <tbody id="recentActivities"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- MEMBERS SECTION -->
        <div id="membersSection" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Gestión de Miembros</h3>
                <button class="btn-gradient" data-bs-toggle="modal" data-bs-target="#memberModal" onclick="resetMemberForm()">
                    <i class="fas fa-user-plus me-2"></i> Nuevo Miembro
                </button>
            </div>
            
            <div class="stat-card-modern mb-4">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <input type="text" id="memberSearch" class="form-control" placeholder="🔍 Buscar miembro...">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select id="membershipTypeFilter" class="form-select">
                            <option value="">Todos los planes</option>
                            <option value="Básico">Básico</option>
                            <option value="Premium">Premium</option>
                            <option value="VIP">VIP</option>
                            <option value="Élite">Élite</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select id="memberStatusFilter" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button class="btn btn-outline-light w-100" onclick="exportMembers()">
                            <i class="fas fa-download me-2"></i> Exportar
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="stat-card-modern">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr><th>ID</th><th>Miembro</th><th>Contacto</th><th>Plan</th><th>Vencimiento</th><th>Estado</th><th>Acciones</th></tr>
                        </thead>
                        <tbody id="membersTableBody"></tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-white-50" id="memberPaginationInfo"></small>
                    <nav><ul class="pagination pagination-sm" id="memberPagination"></ul></nav>
                </div>
            </div>
        </div>
        
        <!-- TRAINERS SECTION -->
        <div id="trainersSection" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Equipo de Entrenadores</h3>
                <button class="btn-gradient" data-bs-toggle="modal" data-bs-target="#trainerModal" onclick="resetTrainerForm()">
                    <i class="fas fa-chalkboard-user me-2"></i> Nuevo Entrenador
                </button>
            </div>
            <div class="row" id="trainersGrid"></div>
        </div>
        
        <!-- CLASSES SECTION -->
        <div id="classesSection" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Clases y Horarios</h3>
                <button class="btn-gradient" data-bs-toggle="modal" data-bs-target="#classModal" onclick="resetClassForm()">
                    <i class="fas fa-plus me-2"></i> Nueva Clase
                </button>
            </div>
            <div class="row" id="classesGrid"></div>
        </div>
        
        <!-- ATTENDANCE SECTION -->
        <div id="attendanceSection" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Control de Asistencias</h3>
                <div>
                    <input type="date" id="attendanceDateFilter" class="form-control d-inline-block w-auto" value="{{ date('Y-m-d') }}">
                    <button class="btn-gradient ms-2" onclick="registerAttendance()">
                        <i class="fas fa-fingerprint me-2"></i> Registrar Asistencia
                    </button>
                </div>
            </div>
            <div class="stat-card-modern">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead><tr><th>Hora</th><th>Miembro</th><th>Plan</th><th>Estado</th></tr></thead>
                        <tbody id="attendanceTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- PAYMENTS SECTION -->
        <div id="paymentsSection" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Gestión de Pagos</h3>
                <button class="btn-gradient" data-bs-toggle="modal" data-bs-target="#paymentModal" onclick="resetPaymentForm()">
                    <i class="fas fa-plus me-2"></i> Registrar Pago
                </button>
            </div>
            <div class="stat-card-modern">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead><tr><th>ID</th><th>Miembro</th><th>Monto</th><th>Concepto</th><th>Fecha</th><th>Estado</th><th>Acciones</th></tr></thead>
                        <tbody id="paymentsTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- EQUIPMENT SECTION -->
        <div id="equipmentSection" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Inventario de Equipos</h3>
                <button class="btn-gradient" data-bs-toggle="modal" data-bs-target="#equipmentModal" onclick="resetEquipmentForm()">
                    <i class="fas fa-plus me-2"></i> Agregar Equipo
                </button>
            </div>
            <div class="row" id="equipmentGrid"></div>
        </div>
        
        <!-- REPORTS SECTION -->
        <div id="reportsSection" style="display: none;">
            <h3 class="text-white mb-4">Centro de Reportes</h3>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="stat-card-modern">
                        <h5 class="text-white mb-3">Reporte de Miembros</h5>
                        <button class="btn-gradient w-100" onclick="generateMemberReport()">
                            <i class="fas fa-chart-bar me-2"></i> Generar Reporte
                        </button>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="stat-card-modern">
                        <h5 class="text-white mb-3">Reporte Financiero</h5>
                        <button class="btn-gradient w-100" onclick="generateFinancialReport()">
                            <i class="fas fa-file-invoice-dollar me-2"></i> Generar Reporte
                        </button>
                    </div>
                </div>
            </div>
            <div id="reportResults" style="display: none;" class="stat-card-modern mt-3"></div>
        </div>
        
        <!-- SETTINGS SECTION -->
        <div id="settingsSection" style="display: none;">
            <h3 class="text-white mb-4">Configuración del Sistema</h3>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="stat-card-modern">
                        <h5 class="text-white mb-3">Configuración General</h5>
                        <div class="mb-3">
                            <label class="text-white-50">Nombre del Gimnasio</label>
                            <input type="text" id="gymName" class="form-control" value="FitnessSync Pro">
                        </div>
                        <div class="mb-3">
                            <label class="text-white-50">Email de Contacto</label>
                            <input type="email" id="gymEmail" class="form-control" value="contact@fitnessync.com">
                        </div>
                        <button class="btn-gradient" onclick="saveSettings()">
                            <i class="fas fa-save me-2"></i> Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODALS -->
    <!-- Member Modal -->
    <div class="modal fade modal-modern" id="memberModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Nuevo Miembro</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="memberForm">
                        <input type="hidden" id="memberId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-white-50">Nombre Completo *</label>
                                <input type="text" id="memberName" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white-50">Email *</label>
                                <input type="email" id="memberEmail" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white-50">Teléfono</label>
                                <input type="text" id="memberPhone" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white-50">Plan</label>
                                <select id="memberPlan" class="form-select">
                                    <option value="Básico">Básico - $30/mes</option>
                                    <option value="Premium">Premium - $50/mes</option>
                                    <option value="VIP">VIP - $80/mes</option>
                                    <option value="Élite">Élite - $120/mes</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-gradient" onclick="saveMember()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Trainer Modal -->
    <div class="modal fade modal-modern" id="trainerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Nuevo Entrenador</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Nombre</label>
                        <input type="text" id="trainerName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Especialidad</label>
                        <input type="text" id="trainerSpecialty" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Email</label>
                        <input type="email" id="trainerEmail" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-gradient" onclick="saveTrainer()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Class Modal -->
    <div class="modal fade modal-modern" id="classModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Nueva Clase</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Nombre de la Clase</label>
                        <input type="text" id="className" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Entrenador</label>
                        <select id="classTrainer" class="form-select"></select>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Horario</label>
                        <input type="time" id="classTime" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Capacidad</label>
                        <input type="number" id="classCapacity" class="form-control" value="20">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-gradient" onclick="saveClass()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payment Modal -->
    <div class="modal fade modal-modern" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Registrar Pago</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Miembro</label>
                        <select id="paymentMember" class="form-select"></select>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Monto</label>
                        <input type="number" id="paymentAmount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Concepto</label>
                        <select id="paymentConcept" class="form-select">
                            <option value="Membresía">Membresía</option>
                            <option value="Clase Personalizada">Clase Personalizada</option>
                            <option value="Nutrición">Nutrición</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-gradient" onclick="savePayment()">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Equipment Modal -->
    <div class="modal fade modal-modern" id="equipmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Agregar Equipo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Nombre del Equipo</label>
                        <input type="text" id="equipmentName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Cantidad</label>
                        <input type="number" id="equipmentQuantity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Estado</label>
                        <select id="equipmentStatus" class="form-select">
                            <option value="Bueno">Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Mantenimiento">Mantenimiento</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-gradient" onclick="saveEquipment()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // ============ CONFIGURACIÓN ============
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ============ CARGAR DATOS DESDE LA BD ============
    function loadMembers() {
        $.get('/api/members', function(members) {
            let html = members.map(m => `
                <tr>
                    <td>${m.id}</td>
                    <td><strong>${m.name}</strong><br><small>${m.email}</small></td>
                    <td>${m.phone || '-'}</td>
                    <td><span class="badge bg-info">${m.plan}</span></td>
                    <td>${m.expiry_date || 'N/A'}</td>
                    <td><span class="badge ${m.status === 'activo' ? 'bg-success' : 'bg-secondary'}">${m.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-info me-1" onclick="viewMember(${m.id})"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-sm btn-warning me-1" onclick="editMember(${m.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteMember(${m.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `).join('');
            $('#membersTableBody').html(html);
        });
    }

    function loadTrainers() {
        $.get('/api/trainers', function(trainers) {
            let html = trainers.map(t => `
                <div class="col-md-4 mb-3">
                    <div class="trainer-card">
                        <div class="trainer-avatar"><i class="fas fa-user"></i></div>
                        <h5 class="text-white">${t.name}</h5>
                        <p class="text-white-50">${t.specialty}</p>
                        <p><small class="text-white-50">${t.email}</small></p>
                        <button class="btn btn-sm btn-danger" onclick="deleteTrainer(${t.id})"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </div>
            `).join('');
            $('#trainersGrid').html(html);
        });
    }

    function loadPayments() {
        $.get('/api/payments', function(payments) {
            let html = payments.map(p => `
                <tr>
                    <td>${p.id}</td>
                    <td>${p.member?.name || 'N/A'}</td>
                    <td>$${p.amount}</td>
                    <td>${p.concept}</td>
                    <td>${p.payment_date}</td>
                    <td><span class="badge bg-success">${p.status}</span></td>
                    <td><button class="btn btn-sm btn-danger" onclick="deletePayment(${p.id})"><i class="fas fa-trash"></i></button></td>
                </tr>
            `).join('');
            $('#paymentsTableBody').html(html);
        });
    }

    // ============ GUARDAR MIEMBRO ============
    function saveMember() {
        let id = $('#memberId').val();
        let data = {
            name: $('#memberName').val(),
            email: $('#memberEmail').val(),
            phone: $('#memberPhone').val(),
            plan: $('#memberPlan').val()
        };

        if (id) {
            $.ajax({
                url: `/api/members/${id}`,
                method: 'PUT',
                data: data,
                success: function() {
                    Swal.fire('Actualizado', 'Miembro actualizado', 'success');
                    $('#memberModal').modal('hide');
                    loadMembers();
                    updateDashboardStats();
                }
            });
        } else {
            $.post('/api/members', data, function() {
                Swal.fire('Creado', 'Miembro creado', 'success');
                $('#memberModal').modal('hide');
                loadMembers();
                updateDashboardStats();
            }).fail(function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Error al crear', 'error');
            });
        }
    }

    function editMember(id) {
        $.get(`/api/members/${id}`, function(member) {
            $('#memberId').val(member.id);
            $('#memberName').val(member.name);
            $('#memberEmail').val(member.email);
            $('#memberPhone').val(member.phone);
            $('#memberPlan').val(member.plan);
            $('#memberModal').modal('show');
        });
    }

    function viewMember(id) {
        $.get(`/api/members/${id}`, function(member) {
            Swal.fire({
                title: member.name,
                html: `<p>Email: ${member.email}</p><p>Teléfono: ${member.phone}</p><p>Plan: ${member.plan}</p><p>Estado: ${member.status}</p>`,
                icon: 'info'
            });
        });
    }

    function deleteMember(id) {
        Swal.fire({
            title: '¿Eliminar?',
            text: "No se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/members/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire('Eliminado', '', 'success');
                        loadMembers();
                        updateDashboardStats();
                    }
                });
            }
        });
    }

    // ============ GUARDAR ENTRENADOR ============
    function saveTrainer() {
        let data = {
            name: $('#trainerName').val(),
            specialty: $('#trainerSpecialty').val(),
            email: $('#trainerEmail').val()
        };
        $.post('/api/trainers', data, function() {
            Swal.fire('Creado', 'Entrenador agregado', 'success');
            $('#trainerModal').modal('hide');
            loadTrainers();
        }).fail(function(xhr) {
            Swal.fire('Error', xhr.responseJSON?.message || 'Error al crear', 'error');
        });
    }

    function deleteTrainer(id) {
        Swal.fire({
            title: '¿Eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/trainers/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire('Eliminado', '', 'success');
                        loadTrainers();
                    }
                });
            }
        });
    }

    // ============ GUARDAR PAGO ============
    function savePayment() {
        let data = {
            member_id: $('#paymentMember').val(),
            amount: $('#paymentAmount').val(),
            concept: $('#paymentConcept').val(),
            payment_method: 'efectivo'
        };
        $.post('/api/payments', data, function() {
            Swal.fire('Registrado', 'Pago registrado', 'success');
            $('#paymentModal').modal('hide');
            loadPayments();
            updateDashboardStats();
        }).fail(function(xhr) {
            Swal.fire('Error', xhr.responseJSON?.message || 'Error al registrar', 'error');
        });
    }

    function deletePayment(id) {
        Swal.fire({
            title: '¿Eliminar pago?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/payments/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire('Eliminado', '', 'success');
                        loadPayments();
                        updateDashboardStats();
                    }
                });
            }
        });
    }

    // ============ DASHBOARD ESTADÍSTICAS ============
    function updateDashboardStats() {
        $.get('/api/dashboard/stats', function(stats) {
            $('#totalMembers').text(stats.totalMembers);
            $('#monthlyIncome').text(`$${stats.monthlyIncome}`);
            $('#activeClasses').text(stats.activeClasses);
            $('#retentionRate').text(stats.retentionRate + '%');
        });
    }

    // ============ ACTUALIZAR FUNCIONES EXISTENTES ============
    function updateStats() {
        updateDashboardStats();
    }

    function loadClasses() {
        // Si hay endpoint para clases, lo agregas
        console.log('Cargar clases desde BD');
    }

    function loadEquipment() {
        // Si hay endpoint para equipos, lo agregas
        console.log('Cargar equipos desde BD');
    }

    function registerAttendance() {
        Swal.fire('Registrar Asistencia', 'Función en desarrollo con BD', 'info');
    }

    function generateMemberReport() {
        Swal.fire('Reporte de Miembros', 'Función en desarrollo', 'info');
    }

    function generateFinancialReport() {
        Swal.fire('Reporte Financiero', 'Función en desarrollo', 'info');
    }

    // ============ INICIALIZACIÓN ============
    $(document).ready(function() {
        updateDateTime();
        setInterval(updateDateTime, 1000);
        updateDashboardStats();
        
        // Cargar datos iniciales
        loadMembers();
        loadTrainers();
        loadPayments();
        
        // Llenar selects
        $.get('/api/members', function(members) {
            $('#paymentMember').html(members.map(m => `<option value="${m.id}">${m.name}</option>`));
        });
    });
</script>
</body>
</html>