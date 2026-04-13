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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
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
        
        .trainer-card, .class-card, .equipment-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .trainer-card:hover, .class-card:hover, .equipment-card:hover {
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
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in { animation: fadeInUp 0.6s ease-out; }
        
        .badge-modern {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #1a1a2e; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #00d2ff, #3a7bd5); border-radius: 10px; }
        
        .pagination .page-link {
            background: #1a1a2e;
            border-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .pagination .active .page-link {
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            border-color: transparent;
        }
        
        .loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: rgba(0,0,0,0.8);
            padding: 20px;
            border-radius: 15px;
        }
        
        /* Estilos para búsqueda */
        .input-group-text {
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .input-group-text:hover {
            background: #00d2ff !important;
            color: white !important;
        }
        
        mark {
            background: #00d2ff;
            color: white;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        #searchResults {
            animation: fadeInUp 0.3s ease-out;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading" id="loading">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
    </div>

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
                    <button class="btn btn-outline-light" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Mi Perfil</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Configuración</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ==================== DASHBOARD SECTION ==================== -->
        <div id="dashboardSection">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stat-card-modern" onclick="showSection('members')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Total Miembros</small>
                                <h2 class="text-white mb-0" id="totalMembers">0</h2>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> Registrados</small>
                            </div>
                            <div><i class="fas fa-users fa-3x" style="color: #00d2ff; opacity: 0.5;"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card-modern" onclick="showSection('payments')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Ingresos Mensuales</small>
                                <h2 class="text-white mb-0" id="monthlyIncome">$0</h2>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> Este mes</small>
                            </div>
                            <div><i class="fas fa-dollar-sign fa-3x" style="color: #00d2ff; opacity: 0.5;"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card-modern" onclick="showSection('attendance')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Asistencias Hoy</small>
                                <h2 class="text-white mb-0" id="todayAttendance">0</h2>
                                <small class="text-success"><i class="fas fa-calendar-check"></i> En tiempo real</small>
                            </div>
                            <div><i class="fas fa-fingerprint fa-3x" style="color: #00d2ff; opacity: 0.5;"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card-modern">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50">Tasa de Retención</small>
                                <h2 class="text-white mb-0" id="retentionRate">0%</h2>
                                <small class="text-success"><i class="fas fa-heart"></i> Clientes activos</small>
                            </div>
                            <div><i class="fas fa-chart-line fa-3x" style="color: #00d2ff; opacity: 0.5;"></i></div>
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
                        <h5 class="text-white mb-3">Distribución por Plan</h5>
                        <canvas id="planChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ==================== MEMBERS SECTION CON BÚSQUEDA ==================== -->
        <div id="membersSection" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Gestión de Miembros</h3>
                <button class="btn-gradient" data-bs-toggle="modal" data-bs-target="#memberModal" onclick="resetMemberForm()">
                    <i class="fas fa-user-plus me-2"></i> Nuevo Miembro
                </button>
            </div>
            
            <!-- Filtros y Búsqueda -->
            <div class="stat-card-modern mb-4">
                <div class="row">
                    <!-- CAMPO DE BÚSQUEDA -->
                    <div class="col-md-5 mb-2">
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-0">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="memberSearch" class="form-control" 
                                   placeholder="🔍 Buscar por nombre, email o teléfono...">
                            <button class="btn btn-outline-light" onclick="clearSearch()" id="clearSearchBtn" style="display: none;">
                                <i class="fas fa-times"></i> Limpiar
                            </button>
                        </div>
                        <small class="text-white-50 mt-1 d-block">
                            <i class="fas fa-info-circle"></i> Busca por nombre, email o teléfono - Resultados en tiempo real
                        </small>
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
                    
                    <div class="col-md-2 mb-2">
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
                
                <!-- Resultados de búsqueda -->
                <div id="searchResults" class="mt-3" style="display: none;">
                    <div class="alert alert-info">
                        <i class="fas fa-search me-2"></i>
                        Se encontraron <strong id="searchCount">0</strong> resultados para: 
                        "<span id="searchTerm"></span>"
                    </div>
                </div>
            </div>
            
            <!-- Tabla de Miembros -->
            <div class="stat-card-modern">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Miembro</th>
                                <th>Contacto</th>
                                <th>Plan</th>
                                <th>Vencimiento</th>
                                <th>Estado</th>
                                <th>Asistencias</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="membersTableBody">
                            <tr><td colspan="8" class="text-center">Cargando...</td><th
                        </tbody>
                    </table>
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
                    <button class="btn-gradient ms-2" data-bs-toggle="modal" data-bs-target="#quickAttendanceModal">
                        <i class="fas fa-fingerprint me-2"></i> Registrar Asistencia
                    </button>
                </div>
            </div>
            
            <div class="stat-card-modern">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr><th>Hora</th><th>Miembro</th><th>Plan</th><th>Estado</th><th>Método</th><th>Acciones</th></tr>
                        </thead>
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
                        <thead>
                            <tr><th>ID</th><th>Miembro</th><th>Monto</th><th>Concepto</th><th>Fecha</th><th>Estado</th><th>Acciones</th></tr>
                        </thead>
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
    
    <!-- ==================== MODALES ==================== -->
    
    <!-- MODAL MIEMBRO -->
    <div class="modal fade modal-modern" id="memberModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="memberModalTitle">Nuevo Miembro</h5>
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
                            <div class="col-md-6 mb-3">
                                <label class="text-white-50">Estado</label>
                                <select id="memberStatus" class="form-select">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white-50">Fecha Nacimiento</label>
                                <input type="date" id="memberBirthDate" class="form-control">
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
    
    <!-- MODAL ENTRENADOR -->
    <div class="modal fade modal-modern" id="trainerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Nuevo Entrenador</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Nombre *</label>
                        <input type="text" id="trainerName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Especialidad *</label>
                        <input type="text" id="trainerSpecialty" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Email *</label>
                        <input type="email" id="trainerEmail" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Teléfono</label>
                        <input type="text" id="trainerPhone" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-gradient" onclick="saveTrainer()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL CLASE -->
    <div class="modal fade modal-modern" id="classModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Nueva Clase</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Nombre de la Clase *</label>
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
    
    <!-- MODAL ASISTENCIA RÁPIDA -->
    <div class="modal fade modal-modern" id="quickAttendanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Registrar Asistencia</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Seleccionar Miembro *</label>
                        <select id="attendanceMemberId" class="form-select" required></select>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Tipo de Registro</label>
                        <select id="attendanceType" class="form-select">
                            <option value="checkin">Check-in (Entrada)</option>
                            <option value="checkout">Check-out (Salida)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-gradient" onclick="registerQuickAttendance()">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL PAGO -->
    <div class="modal fade modal-modern" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Registrar Pago</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Miembro *</label>
                        <select id="paymentMemberId" class="form-select" required></select>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Monto *</label>
                        <input type="number" id="paymentAmount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Concepto *</label>
                        <select id="paymentConcept" class="form-select">
                            <option value="Membresía">Membresía</option>
                            <option value="Clase Personalizada">Clase Personalizada</option>
                            <option value="Nutrición">Nutrición</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Método de Pago</label>
                        <select id="paymentMethod" class="form-select">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
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
    
    <!-- MODAL EQUIPO -->
    <div class="modal fade modal-modern" id="equipmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Agregar Equipo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="text-white-50">Nombre del Equipo *</label>
                        <input type="text" id="equipmentName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50">Cantidad *</label>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // ==================== CONFIGURACIÓN INICIAL ====================
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        
        let members = [], trainers = [], classes = [], payments = [], equipment = [], attendances = [];
        let searchTimeout;
        
        function showLoading() { $('#loading').fadeIn(); }
        function hideLoading() { $('#loading').fadeOut(); }
        
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            $('#currentDateTime').text(now.toLocaleDateString('es-ES', options));
        }
        
        function toggleSidebar() {
            $('#sidebar').toggleClass('collapsed');
            $('#mainContent').toggleClass('expanded');
            const icon = $('#sidebarIcon');
            if ($('#sidebar').hasClass('collapsed')) {
                icon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
            } else {
                icon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
            }
        }
        
        // ==================== NAVEGACIÓN ====================
        function showSection(section) {
            $('#dashboardSection, #membersSection, #trainersSection, #classesSection, #attendanceSection, #paymentsSection, #equipmentSection, #reportsSection, #settingsSection').hide();
            
            if (section === 'dashboard') {
                $('#dashboardSection').show();
                $('#pageTitle').text('Dashboard');
                loadDashboardStats();
                loadCharts();
            } else if (section === 'members') {
                $('#membersSection').show();
                $('#pageTitle').text('Miembros');
                loadMembers();
            } else if (section === 'trainers') {
                $('#trainersSection').show();
                $('#pageTitle').text('Entrenadores');
                loadTrainers();
            } else if (section === 'classes') {
                $('#classesSection').show();
                $('#pageTitle').text('Clases');
                loadClasses();
            } else if (section === 'attendance') {
                $('#attendanceSection').show();
                $('#pageTitle').text('Asistencias');
                loadAttendance();
                loadMembersForAttendanceSelect();
            } else if (section === 'payments') {
                $('#paymentsSection').show();
                $('#pageTitle').text('Pagos');
                loadPayments();
                loadMembersForSelect();
            } else if (section === 'equipment') {
                $('#equipmentSection').show();
                $('#pageTitle').text('Equipos');
                loadEquipment();
            } else if (section === 'reports') {
                $('#reportsSection').show();
                $('#pageTitle').text('Reportes');
            } else if (section === 'settings') {
                $('#settingsSection').show();
                $('#pageTitle').text('Configuración');
            }
            
            $('.nav-link').removeClass('active');
            $(`.nav-link:contains('${$('#pageTitle').text()}')`).addClass('active');
        }
        
        // ==================== DASHBOARD ====================
        function loadDashboardStats() {
            $.get('/api/dashboard/stats', function(response) {
                $('#totalMembers').text(response.totalMembers || 0);
                $('#monthlyIncome').text('$' + (response.monthlyIncome || 0));
                $('#todayAttendance').text(response.todayAttendance || 0);
                $('#retentionRate').text((response.retentionRate || 0) + '%');
            }).fail(() => console.log('Error cargando estadísticas'));
        }
        
        function loadCharts() {
            const ctx1 = document.getElementById('revenueChart')?.getContext('2d');
            if (ctx1) {
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                        datasets: [{ label: 'Ingresos', data: [1200, 1350, 1500, 1800, 2100, 2450], borderColor: '#00d2ff', backgroundColor: 'rgba(0,210,255,0.1)', tension: 0.4 }]
                    },
                    options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { labels: { color: 'white' } } } }
                });
            }
            
            const ctx2 = document.getElementById('planChart')?.getContext('2d');
            if (ctx2) {
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: { labels: ['Básico', 'Premium', 'VIP', 'Élite'], datasets: [{ data: [40, 30, 20, 10], backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#17a2b8'] }] },
                    options: { responsive: true, plugins: { legend: { labels: { color: 'white' } } } }
                });
            }
        }
        
        // ==================== CRUD MIEMBROS CON BÚSQUEDA ====================
        function loadMembers() {
            showLoading();
            $.get('/api/members', function(data) {
                members = data;
                applyFiltersAndSearch();
                hideLoading();
            }).fail(function() {
                hideLoading();
                Swal.fire('Error', 'Error cargando miembros', 'error');
            });
        }
        
        function applyFiltersAndSearch() {
            let searchTerm = $('#memberSearch').val().toLowerCase().trim();
            let plan = $('#membershipTypeFilter').val();
            let status = $('#memberStatusFilter').val();
            
            // Mostrar/ocultar botón de limpiar
            if (searchTerm.length > 0) {
                $('#clearSearchBtn').show();
            } else {
                $('#clearSearchBtn').hide();
            }
            
            // Filtrar miembros
            let filtered = members.filter(member => {
                let matchSearch = true;
                let matchPlan = !plan || member.plan === plan;
                let matchStatus = !status || member.status === status;
                
                if (searchTerm.length > 0) {
                    matchSearch = member.name.toLowerCase().includes(searchTerm) ||
                                 member.email.toLowerCase().includes(searchTerm) ||
                                 (member.phone && member.phone.includes(searchTerm));
                }
                
                return matchSearch && matchPlan && matchStatus;
            });
            
            // Mostrar resultados de búsqueda
            if (searchTerm.length > 0) {
                $('#searchCount').text(filtered.length);
                $('#searchTerm').text(searchTerm);
                $('#searchResults').show();
            } else {
                $('#searchResults').hide();
            }
            
            renderMembersTable(filtered, searchTerm);
        }
        
        function renderMembersTable(filtered, searchTerm) {
            if (filtered.length === 0) {
                let html = `
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-search fa-3x mb-3 d-block text-muted"></i>
                            <h5 class="text-white">No se encontraron resultados</h5>
                            <p class="text-white-50">Prueba con otro término de búsqueda</p>
                            <button class="btn btn-gradient btn-sm" onclick="clearSearch()">
                                <i class="fas fa-undo"></i> Limpiar búsqueda
                            </button>
                        </td>
                    </tr>
                `;
                $('#membersTableBody').html(html);
                return;
            }
            
            let html = '';
            filtered.forEach(m => {
                let statusClass = m.status === 'activo' ? 'bg-success' : 'bg-secondary';
                
                // Resaltar texto buscado
                let nameHighlighted = m.name;
                let emailHighlighted = m.email;
                let phoneHighlighted = m.phone || '-';
                
                if (searchTerm) {
                    nameHighlighted = highlightText(m.name, searchTerm);
                    emailHighlighted = highlightText(m.email, searchTerm);
                    phoneHighlighted = m.phone ? highlightText(m.phone, searchTerm) : '-';
                }
                
                html += `
                    <tr class="animate-fade-in">
                        <td>${m.id}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-2" style="background: linear-gradient(135deg, #00d2ff, #3a7bd5);">
                                    ${m.name.charAt(0)}
                                </div>
                                <div>
                                    <strong>${nameHighlighted}</strong><br>
                                    <small class="text-white-50">${emailHighlighted}</small>
                                </div>
                            </div>
                        </td>
                        <td><i class="fas fa-phone me-1"></i> ${phoneHighlighted}</td>
                        <td><span class="badge bg-info">${m.plan}</span></td>
                        <td>${m.expiry_date || 'N/A'}</td>
                        <td><span class="badge ${statusClass}">${m.status}</span></td>
                        <td><span class="badge bg-primary">${m.attendance_count || 0}</span></td>
                        <td>
                            <button class="btn btn-sm btn-info me-1" onclick="viewMember(${m.id})" title="Ver">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning me-1" onclick="editMember(${m.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteMember(${m.id})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            $('#membersTableBody').html(html);
        }
        
        function highlightText(text, searchTerm) {
            if (!searchTerm || searchTerm.length === 0) return text;
            let regex = new RegExp(`(${searchTerm})`, 'gi');
            return text.replace(regex, '<mark style="background: #00d2ff; color: white; padding: 2px 5px; border-radius: 3px;">$1</mark>');
        }
        
        function debounceSearch() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFiltersAndSearch();
            }, 300);
        }
        
        function clearSearch() {
            $('#memberSearch').val('');
            $('#searchResults').hide();
            $('#clearSearchBtn').hide();
            applyFiltersAndSearch();
        }
        
        function saveMember() {
            let id = $('#memberId').val();
            let data = {
                name: $('#memberName').val(),
                email: $('#memberEmail').val(),
                phone: $('#memberPhone').val(),
                plan: $('#memberPlan').val(),
                status: $('#memberStatus').val(),
                birth_date: $('#memberBirthDate').val()
            };
            
            if (!data.name || !data.email) {
                Swal.fire('Error', 'Nombre y email son obligatorios', 'error');
                return;
            }
            
            showLoading();
            let url = id ? `/api/members/${id}` : '/api/members';
            let method = id ? 'PUT' : 'POST';
            
            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function() {
                    Swal.fire('Éxito', id ? 'Miembro actualizado' : 'Miembro creado', 'success');
                    $('#memberModal').modal('hide');
                    loadMembers();
                    loadDashboardStats();
                    hideLoading();
                },
                error: function(xhr) {
                    hideLoading();
                    Swal.fire('Error', xhr.responseJSON?.message || 'Error al guardar', 'error');
                }
            });
        }
        
        function editMember(id) {
            let member = members.find(m => m.id === id);
            if (member) {
                $('#memberId').val(member.id);
                $('#memberName').val(member.name);
                $('#memberEmail').val(member.email);
                $('#memberPhone').val(member.phone);
                $('#memberPlan').val(member.plan);
                $('#memberStatus').val(member.status);
                $('#memberBirthDate').val(member.birth_date);
                $('#memberModalTitle').text('✏️ Editar Miembro');
                $('#memberModal').modal('show');
            }
        }
        
        function viewMember(id) {
            let member = members.find(m => m.id === id);
            if (member) {
                Swal.fire({
                    title: member.name,
                    html: `<p><strong>Email:</strong> ${member.email}</p><p><strong>Teléfono:</strong> ${member.phone || '-'}</p><p><strong>Plan:</strong> ${member.plan}</p><p><strong>Estado:</strong> ${member.status}</p>`,
                    icon: 'info'
                });
            }
        }
        
        function deleteMember(id) {
            Swal.fire({
                title: '¿Eliminar miembro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                        url: `/api/members/${id}`,
                        method: 'DELETE',
                        success: function() {
                            Swal.fire('Eliminado', 'Miembro eliminado', 'success');
                            loadMembers();
                            loadDashboardStats();
                            hideLoading();
                        },
                        error: function() {
                            hideLoading();
                            Swal.fire('Error', 'No se pudo eliminar', 'error');
                        }
                    });
                }
            });
        }
        
        function resetMemberForm() {
            $('#memberForm')[0].reset();
            $('#memberId').val('');
            $('#memberModalTitle').text('Nuevo Miembro');
            $('#memberStatus').val('activo');
        }
        
        function exportMembers() {
            Swal.fire('Exportado', 'Datos exportados a Excel', 'success');
        }
        
        // ==================== ENTRENADORES ====================
        function loadTrainers() {
            showLoading();
            $.get('/api/trainers', function(data) {
                trainers = data;
                let html = '';
                trainers.forEach(t => {
                    html += `<div class="col-md-4 mb-3"><div class="trainer-card"><div class="trainer-avatar"><i class="fas fa-user"></i></div>
                        <h5 class="text-white">${t.name}</h5><p class="text-white-50">${t.specialty}</p>
                        <p><small class="text-white-50">${t.email}</small></p>
                        <button class="btn btn-sm btn-danger" onclick="deleteTrainer(${t.id})"><i class="fas fa-trash"></i> Eliminar</button></div></div>`;
                });
                $('#trainersGrid').html(html || '<div class="col-12 text-center text-white">No hay entrenadores</div>');
                hideLoading();
            }).fail(() => { hideLoading(); $('#trainersGrid').html('<div class="col-12 text-center text-white">Error cargando entrenadores</div>'); });
        }
        
        function saveTrainer() {
            let data = {
                name: $('#trainerName').val(),
                specialty: $('#trainerSpecialty').val(),
                email: $('#trainerEmail').val(),
                phone: $('#trainerPhone').val()
            };
            if (!data.name || !data.specialty || !data.email) {
                Swal.fire('Error', 'Complete los campos requeridos', 'error');
                return;
            }
            showLoading();
            $.post('/api/trainers', data, function() {
                Swal.fire('Creado', 'Entrenador agregado', 'success');
                $('#trainerModal').modal('hide');
                loadTrainers();
                hideLoading();
            }).fail(function(xhr) {
                hideLoading();
                Swal.fire('Error', xhr.responseJSON?.message || 'Error al crear', 'error');
            });
        }
        
        function deleteTrainer(id) {
            Swal.fire({ title: '¿Eliminar entrenador?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Sí' })
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({ url: `/api/trainers/${id}`, method: 'DELETE', success: function() {
                        Swal.fire('Eliminado', '', 'success');
                        loadTrainers();
                        hideLoading();
                    }, error: function() { hideLoading(); Swal.fire('Error', 'No se pudo eliminar', 'error'); } });
                }
            });
        }
        
        function resetTrainerForm() { $('#trainerForm')[0]?.reset(); }
        
        // ==================== CLASES ====================
        function loadClasses() {
            showLoading();
            $.get('/api/classes', function(data) {
                classes = data;
                let html = '';
                classes.forEach(c => {
                    html += `<div class="col-md-4 mb-3"><div class="class-card"><h5 class="text-white">${c.name}</h5>
                        <p><i class="fas fa-user"></i> ${c.trainer?.name || 'Sin entrenador'}</p>
                        <p><i class="fas fa-clock"></i> ${c.start_time} - ${c.end_time}</p>
                        <p><i class="fas fa-users"></i> Cupo: ${c.capacity}</p>
                        <button class="btn btn-sm btn-danger" onclick="deleteClass(${c.id})"><i class="fas fa-trash"></i> Eliminar</button></div></div>`;
                });
                $('#classesGrid').html(html || '<div class="col-12 text-center text-white">No hay clases registradas</div>');
                hideLoading();
            }).fail(() => { hideLoading(); $('#classesGrid').html('<div class="col-12 text-center text-white">Error cargando clases</div>'); });
        }
        
        function saveClass() {
            let data = {
                name: $('#className').val(),
                trainer_id: $('#classTrainer').val(),
                start_time: $('#classTime').val(),
                end_time: $('#classTime').val(),
                capacity: $('#classCapacity').val()
            };
            if (!data.name) { Swal.fire('Error', 'Complete los campos requeridos', 'error'); return; }
            showLoading();
            $.post('/api/classes', data, function() {
                Swal.fire('Creado', 'Clase agregada', 'success');
                $('#classModal').modal('hide');
                loadClasses();
                hideLoading();
            }).fail(function(xhr) { hideLoading(); Swal.fire('Error', xhr.responseJSON?.message || 'Error al crear', 'error'); });
        }
        
        function deleteClass(id) {
            Swal.fire({ title: '¿Eliminar clase?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Sí' })
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({ url: `/api/classes/${id}`, method: 'DELETE', success: function() {
                        Swal.fire('Eliminada', '', 'success');
                        loadClasses();
                        hideLoading();
                    }, error: function() { hideLoading(); Swal.fire('Error', 'No se pudo eliminar', 'error'); } });
                }
            });
        }
        
        function resetClassForm() { $('#classForm')[0]?.reset(); }
        
        // ==================== ASISTENCIAS ====================
        function loadAttendance() {
            let date = $('#attendanceDateFilter').val();
            showLoading();
            $.get(`/api/attendances?date=${date}`, function(data) {
                let html = '';
                data.forEach(a => {
                    html += `<tr><td>${a.check_in_time || '--:--'}</td><td><strong>${a.member?.name || 'N/A'}</strong></td>
                        <td>${a.member?.plan || '-'}</td><td><span class="badge bg-success">Presente</span></td>
                        <td>${a.check_in_method || 'manual'}</td>
                        <td>${!a.check_out_time ? `<button class="btn btn-sm btn-warning" onclick="checkOut(${a.id})">Salida</button>` : `<span class="badge bg-secondary">Completado</span>`}</td></tr>`;
                });
                $('#attendanceTableBody').html(html || '<tr><td colspan="6" class="text-center">No hay asistencias registradas</td></tr>');
                hideLoading();
            }).fail(() => { hideLoading(); $('#attendanceTableBody').html('<tr><td colspan="6" class="text-center">Error cargando asistencias</td></tr>'); });
        }
        
        function loadMembersForAttendanceSelect() {
            $.get('/api/members', function(data) {
                let options = '<option value="">Seleccionar miembro</option>';
                data.forEach(m => { if (m.status === 'activo') options += `<option value="${m.id}">${m.name} - ${m.plan}</option>`; });
                $('#attendanceMemberId').html(options);
            });
        }
        
        function registerQuickAttendance() {
            let data = { member_id: $('#attendanceMemberId').val(), type: $('#attendanceType').val(), method: 'manual' };
            if (!data.member_id) { Swal.fire('Error', 'Seleccione un miembro', 'error'); return; }
            showLoading();
            $.post('/api/attendances/register', data, function() {
                Swal.fire('Registrado', 'Asistencia registrada', 'success');
                $('#quickAttendanceModal').modal('hide');
                loadAttendance();
                hideLoading();
            }).fail(function(xhr) { hideLoading(); Swal.fire('Error', xhr.responseJSON?.message || 'Error al registrar', 'error'); });
        }
        
        function checkOut(id) {
            showLoading();
            $.post(`/api/attendances/${id}/checkout`, function() {
                Swal.fire('Salida', 'Salida registrada', 'success');
                loadAttendance();
                hideLoading();
            }).fail(function() { hideLoading(); Swal.fire('Error', 'No se pudo registrar salida', 'error'); });
        }
        
        // ==================== PAGOS ====================
        function loadPayments() {
            showLoading();
            $.get('/api/payments', function(data) {
                payments = data;
                let html = '';
                payments.forEach(p => {
                    html += `<tr><td>${p.id}</td><td>${p.member?.name || 'N/A'}</td><td>$${p.amount}</td>
                        <td>${p.concept}</td><td>${p.payment_date}</td><td><span class="badge bg-success">${p.status}</span></td>
                        <td><button class="btn btn-sm btn-danger" onclick="deletePayment(${p.id})"><i class="fas fa-trash"></i></button></td></tr>`;
                });
                $('#paymentsTableBody').html(html || '<tr><td colspan="7" class="text-center">No hay pagos registrados</td></tr>');
                hideLoading();
            }).fail(() => { hideLoading(); $('#paymentsTableBody').html('<tr><td colspan="7" class="text-center">Error cargando pagos</td></tr>'); });
        }
        
        function loadMembersForSelect() {
            $.get('/api/members', function(data) {
                let options = '<option value="">Seleccionar miembro</option>';
                data.forEach(m => { options += `<option value="${m.id}">${m.name} - ${m.plan}</option>`; });
                $('#paymentMemberId').html(options);
            });
        }
        
        function savePayment() {
            let data = {
                member_id: $('#paymentMemberId').val(),
                amount: $('#paymentAmount').val(),
                concept: $('#paymentConcept').val(),
                payment_method: $('#paymentMethod').val(),
                payment_date: new Date().toISOString().split('T')[0]
            };
            if (!data.member_id || !data.amount) { Swal.fire('Error', 'Seleccione un miembro y un monto', 'error'); return; }
            showLoading();
            $.post('/api/payments', data, function() {
                Swal.fire('Registrado', 'Pago registrado', 'success');
                $('#paymentModal').modal('hide');
                loadPayments();
                loadDashboardStats();
                hideLoading();
            }).fail(function(xhr) { hideLoading(); Swal.fire('Error', xhr.responseJSON?.message || 'Error al registrar', 'error'); });
        }
        
        function deletePayment(id) {
            Swal.fire({ title: '¿Eliminar pago?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Sí' })
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({ url: `/api/payments/${id}`, method: 'DELETE', success: function() {
                        Swal.fire('Eliminado', '', 'success');
                        loadPayments();
                        loadDashboardStats();
                        hideLoading();
                    }, error: function() { hideLoading(); Swal.fire('Error', 'No se pudo eliminar', 'error'); } });
                }
            });
        }
        
        function resetPaymentForm() { $('#paymentForm')[0]?.reset(); $('#paymentAmount').val(''); }
        
        // ==================== EQUIPOS ====================
        function loadEquipment() {
            showLoading();
            $.get('/api/equipment', function(data) {
                equipment = data;
                let html = '';
                equipment.forEach(e => {
                    let statusClass = e.status === 'Bueno' ? 'bg-success' : (e.status === 'Regular' ? 'bg-warning' : 'bg-info');
                    html += `<div class="col-md-3 mb-3"><div class="equipment-card"><h5 class="text-white">${e.name}</h5>
                        <p><i class="fas fa-hashtag"></i> Cantidad: ${e.quantity}</p>
                        <p><span class="badge ${statusClass}">${e.status}</span></p>
                        <button class="btn btn-sm btn-danger" onclick="deleteEquipment(${e.id})"><i class="fas fa-trash"></i> Eliminar</button></div></div>`;
                });
                $('#equipmentGrid').html(html || '<div class="col-12 text-center text-white">No hay equipos registrados</div>');
                hideLoading();
            }).fail(() => { hideLoading(); $('#equipmentGrid').html('<div class="col-12 text-center text-white">Error cargando equipos</div>'); });
        }
        
        function saveEquipment() {
            let data = {
                name: $('#equipmentName').val(),
                quantity: $('#equipmentQuantity').val(),
                status: $('#equipmentStatus').val()
            };
            if (!data.name || !data.quantity) { Swal.fire('Error', 'Complete los campos requeridos', 'error'); return; }
            showLoading();
            $.post('/api/equipment', data, function() {
                Swal.fire('Agregado', 'Equipo agregado', 'success');
                $('#equipmentModal').modal('hide');
                loadEquipment();
                hideLoading();
            }).fail(function(xhr) { hideLoading(); Swal.fire('Error', xhr.responseJSON?.message || 'Error al agregar', 'error'); });
        }
        
        function deleteEquipment(id) {
            Swal.fire({ title: '¿Eliminar equipo?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Sí' })
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({ url: `/api/equipment/${id}`, method: 'DELETE', success: function() {
                        Swal.fire('Eliminado', '', 'success');
                        loadEquipment();
                        hideLoading();
                    }, error: function() { hideLoading(); Swal.fire('Error', 'No se pudo eliminar', 'error'); } });
                }
            });
        }
        
        function resetEquipmentForm() { $('#equipmentForm')[0]?.reset(); }
        
        // ==================== REPORTES ====================
        function generateMemberReport() {
            let html = `<h5>Reporte de Miembros</h5><table class="table"><thead><tr><th>Nombre</th><th>Email</th><th>Plan</th><th>Estado</th></tr></thead><tbody>`;
            members.forEach(m => { html += `<tr><td>${m.name}</td><td>${m.email}</td><td>${m.plan}</td><td>${m.status}</td></tr>`; });
            html += `</tbody></table><p><strong>Total Miembros:</strong> ${members.length}</p>`;
            $('#reportResults').html(html).show();
        }
        
        function generateFinancialReport() {
            let total = payments.reduce((sum, p) => sum + p.amount, 0);
            let html = `<h5>Reporte Financiero</h5><p>Total ingresos: <strong>$${total}</strong></p><p>Total transacciones: ${payments.length}</p>`;
            $('#reportResults').html(html).show();
        }
        
        // ==================== CONFIGURACIÓN ====================
        function saveSettings() { Swal.fire('Guardado', 'Configuración actualizada', 'success'); }
        
        // ==================== EVENTOS ====================
        $(document).ready(function() {
            updateDateTime();
            setInterval(updateDateTime, 1000);
            loadDashboardStats();
            loadCharts();
            
            // Eventos de búsqueda
            $('#memberSearch').on('keyup', function() { debounceSearch(); });
            $('#membershipTypeFilter, #memberStatusFilter').on('change', function() { applyFiltersAndSearch(); });
            $('#memberSearch').on('keyup', function(e) { if (e.key === 'Escape') clearSearch(); });
            
            $('#attendanceDateFilter').on('change', function() { loadAttendance(); });
        });
    </script>
</body>
</html>