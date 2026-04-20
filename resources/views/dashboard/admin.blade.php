<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aura Gym | Administrador</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Mismos estilos que super_admin (glassmorphism, sidebar, etc.) */
        :root { --primary: #6366f1; --primary-dark: #4f46e5; --secondary: #ec4899; --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --dark: #0f172a; --glass: rgba(255,255,255,0.1); }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: radial-gradient(circle at 10% 20%, rgba(99,102,241,0.15) 0%, rgba(236,72,153,0.15) 100%), linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); background-attachment: fixed; min-height: 100vh; }
        .sidebar { position: fixed; left: 0; top: 0; height: 100vh; width: 280px; background: rgba(15,23,42,0.8); backdrop-filter: blur(20px); border-right: 1px solid rgba(255,255,255,0.1); z-index: 1000; transition: all 0.4s; overflow-y: auto; }
        .sidebar.collapsed { width: 90px; }
        .sidebar.collapsed .sidebar-text, .sidebar.collapsed .user-info .user-details { display: none; }
        .sidebar-header { padding: 30px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 30px; }
        .user-info { display: flex; align-items: center; gap: 15px; padding: 0 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 25px; }
        .nav-link { display: flex; align-items: center; gap: 15px; color: rgba(255,255,255,0.7); padding: 12px 20px; margin: 5px 15px; border-radius: 12px; transition: 0.3s; cursor: pointer; font-weight: 500; }
        .nav-link:hover { background: rgba(99,102,241,0.3); color: white; transform: translateX(5px); }
        .nav-link.active { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; box-shadow: 0 8px 20px rgba(99,102,241,0.4); }
        .main-content { margin-left: 280px; transition: 0.4s; min-height: 100vh; padding: 25px; }
        .main-content.expanded { margin-left: 90px; }
        .glass-card { background: rgba(255,255,255,0.07); backdrop-filter: blur(12px); border-radius: 24px; border: 1px solid rgba(255,255,255,0.15); transition: 0.3s; overflow: hidden; }
        .glass-card:hover { transform: translateY(-4px); box-shadow: 0 20px 35px -10px rgba(0,0,0,0.3); border-color: rgba(99,102,241,0.5); }
        .stat-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(8px); border-radius: 20px; padding: 20px; transition: 0.3s; cursor: pointer; border: 1px solid rgba(255,255,255,0.1); }
        .stat-card:hover { transform: translateY(-5px); background: rgba(255,255,255,0.1); border-color: var(--primary); }
        .stat-number { font-size: 2.2rem; font-weight: 800; background: linear-gradient(135deg, #fff, #a5b4fc); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .modern-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .modern-table tbody tr { background: rgba(255,255,255,0.05); backdrop-filter: blur(4px); border-radius: 16px; transition: 0.2s; }
        .modern-table tbody tr:hover { background: rgba(255,255,255,0.1); transform: scale(1.01); }
        .btn-glow { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: none; transition: 0.3s; box-shadow: 0 4px 15px rgba(99,102,241,0.4); }
        .btn-glow:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99,102,241,0.6); }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } }
        .animate-in { animation: fadeInUp 0.5s ease forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fc { background: rgba(255,255,255,0.05); border-radius: 20px; padding: 15px; color: white; }
        .chart-container { position: relative; height: 300px; }
    </style>
</head>
<body>

<!-- Sidebar (similar a super_admin, pero con texto "Administrador") -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header text-center">
        <h3 class="text-white"><i class="fas fa-dumbbell"></i> <span class="sidebar-text">AURA GYM</span></h3>
        <p class="text-white-50 small sidebar-text">Panel Admin</p>
    </div>
    <div class="user-info">
        <img src="https://ui-avatars.com/api/?background=6366f1&color=fff&rounded=true&bold=true&size=50&name={{ Auth::user()->name }}" width="50" height="50" class="rounded-circle">
        <div class="user-details"><h6 class="text-white mb-0">{{ Auth::user()->name }}</h6><small class="text-white-50">Administrador</small></div>
    </div>
    <nav>
        <div class="nav-link active" data-page="dashboard"><i class="fas fa-chart-pie"></i><span class="sidebar-text">Dashboard</span></div>
        <div class="nav-link" data-page="members"><i class="fas fa-users"></i><span class="sidebar-text">Socios</span></div>
        <div class="nav-link" data-page="payments"><i class="fas fa-credit-card"></i><span class="sidebar-text">Pagos</span></div>
        <div class="nav-link" data-page="attendance"><i class="fas fa-calendar-check"></i><span class="sidebar-text">Asistencias</span></div>
        <div class="nav-link" data-page="reports"><i class="fas fa-chart-line"></i><span class="sidebar-text">Reportes</span></div>
        <div class="nav-link" data-page="settings"><i class="fas fa-cog"></i><span class="sidebar-text">Configuración</span></div>
    </nav>
    <div class="position-absolute bottom-0 start-0 end-0 p-3">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn btn-outline-danger w-100 rounded-pill"><i class="fas fa-sign-out-alt me-2"></i><span class="sidebar-text">Cerrar Sesión</span></button></form>
    </div>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <div class="glass-card p-3 mb-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-link text-white" id="toggleSidebar"><i class="fas fa-bars fa-2x"></i></button>
            <div><h4 class="mb-0 text-white" id="pageTitle">Dashboard</h4><small class="text-white-50">Panel de Administración</small></div>
        </div>
        <div class="dropdown">
            <button class="btn btn-link text-white dropdown-toggle" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?background=6366f1&color=fff&rounded=true&bold=true&size=40&name={{ Auth::user()->name }}" width="40" height="40" class="rounded-circle">
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" onclick="showProfile()"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><form method="POST" action="{{ route('logout') }}" id="logout-form">@csrf<a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></form></li>
            </ul>
        </div>
    </div>

    <!-- DASHBOARD SECTION -->
    <div id="dashboardSection" class="animate-in">
        <div class="row g-4 mb-4">
            <div class="col-md-3"><div class="stat-card" onclick="switchToPage('members')"><div class="d-flex justify-content-between"><div><span class="text-white-50">Socios Totales</span><div class="stat-number" id="dashTotalMembers">{{ $totalMembers ?? 0 }}</div><small class="text-success"><i class="fas fa-arrow-up"></i> Activos</small></div><i class="fas fa-users fa-3x text-primary opacity-50"></i></div></div></div>
            <div class="col-md-3"><div class="stat-card" onclick="switchToPage('attendance')"><div><span class="text-white-50">Asistencias Hoy</span><div class="stat-number" id="dashTodayAttendance">{{ $todayAttendance ?? 0 }}</div><small class="text-info">Registros</small></div><i class="fas fa-calendar-check fa-3x text-success opacity-50 float-end"></i></div></div>
            <div class="col-md-3"><div class="stat-card" onclick="switchToPage('payments')"><div><span class="text-white-50">Ingresos Totales</span><div class="stat-number">$<span id="dashTotalIncome">{{ number_format($totalPayments ?? 0, 2) }}</span></div><small class="text-warning">+15% vs mes pasado</small></div><i class="fas fa-dollar-sign fa-3x text-warning opacity-50 float-end"></i></div></div>
            <div class="col-md-3"><div class="stat-card"><div><span class="text-white-50">Renovaciones Próximas</span><div class="stat-number" id="dashPendingRenewals">{{ $pendingRenewals ?? 0 }}</div><small class="text-danger">7 días</small></div><i class="fas fa-clock fa-3x text-info opacity-50 float-end"></i></div></div>
        </div>
        <div class="row g-4">
            <div class="col-lg-8"><div class="glass-card p-4"><h5 class="text-white mb-3"><i class="fas fa-chart-line me-2"></i>Tendencia de Ingresos</h5><canvas id="trendChart" height="250"></canvas></div></div>
            <div class="col-lg-4"><div class="glass-card p-4"><h5 class="text-white mb-3"><i class="fas fa-chart-pie me-2"></i>Socios por Membresía</h5><canvas id="membershipChart" height="250"></canvas></div></div>
        </div>
        <div class="row mt-4"><div class="col-12"><div class="glass-card p-4"><h5 class="text-white mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Socios con Vencimiento Próximo (30 días)</h5><div class="table-responsive"><table class="modern-table"><thead class="text-white-50"><tr><th>Socio</th><th>Membresía</th><th>Vence</th><th>Días restantes</th><th>Acciones</th></tr></thead><tbody id="expiringMembersTable"></tbody></table></div></div></div></div>
    </div>

    <!-- MEMBERS SECTION (igual que super_admin pero sin gestión de usuarios del sistema) -->
    <div id="membersSection" style="display: none;">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2"><h5 class="text-white"><i class="fas fa-users me-2"></i>Gestión de Socios</h5><button class="btn btn-glow rounded-pill px-4" onclick="showMemberModal()"><i class="fas fa-plus me-2"></i>Nuevo Socio</button></div>
            <div class="row g-3 mb-4"><div class="col-md-4"><input type="text" id="memberSearch" class="form-control bg-dark text-white border-0 rounded-pill" placeholder="Buscar socio..."></div><div class="col-md-3"><select id="statusFilter" class="form-select bg-dark text-white border-0 rounded-pill"><option value="">Todos los estados</option><option value="active">Activo</option><option value="inactive">Inactivo</option></select></div></div>
            <div class="table-responsive"><table class="modern-table"><thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Membresía</th><th>Vencimiento</th><th>Estado</th><th>Acciones</th></tr></thead><tbody id="membersTableBody"></tbody></table></div>
        </div>
    </div>

    <!-- PAYMENTS SECTION (idéntico a super_admin) -->
    <div id="paymentsSection" style="display: none;">
        <div class="row g-4 mb-4"><div class="col-md-4"><div class="stat-card"><h6 class="text-white-50">Ingresos Totales</h6><div class="stat-number">$<span id="totalPayments">0</span></div></div></div><div class="col-md-4"><div class="stat-card"><h6 class="text-white-50">Pagos Este Mes</h6><div class="stat-number">$<span id="monthlyPayments">0</span></div></div></div><div class="col-md-4"><div class="stat-card"><h6 class="text-white-50">Transacciones</h6><div class="stat-number" id="transactionCount">0</div></div></div></div>
        <div class="glass-card p-4"><div class="d-flex justify-content-between align-items-center mb-4"><h5 class="text-white"><i class="fas fa-credit-card me-2"></i>Historial de Pagos</h5><button class="btn btn-glow rounded-pill" onclick="showPaymentModal()"><i class="fas fa-plus me-2"></i>Registrar Pago</button></div><div class="table-responsive"><table class="modern-table"><thead><tr><th>ID</th><th>Socio</th><th>Monto</th><th>Fecha</th><th>Método</th><th>Estado</th><th>Acciones</th></tr></thead><tbody id="paymentsTableBody"></tbody></table></div></div>
    </div>

    <!-- ATTENDANCE SECTION -->
    <div id="attendanceSection" style="display: none;">
        <div class="glass-card p-4"><div class="d-flex justify-content-between align-items-center mb-4"><h5 class="text-white"><i class="fas fa-calendar-check me-2"></i>Control de Asistencias</h5><button class="btn btn-success rounded-pill" onclick="checkIn()"><i class="fas fa-sign-in-alt me-2"></i>Registrar Entrada</button></div><div class="table-responsive"><table class="modern-table"><thead><tr><th>ID</th><th>Socio</th><th>Entrada</th><th>Salida</th><th>Acciones</th></tr></thead><tbody id="attendanceTableBody"></tbody></table></div></div>
    </div>

    <!-- REPORTS SECTION -->
    <div id="reportsSection" style="display: none;">
        <div class="row g-4 mb-4"><div class="col-md-6"><div class="glass-card p-4"><h5 class="text-white"><i class="fas fa-chart-bar me-2"></i>Socios por Estado</h5><canvas id="usersReportChart" height="200"></canvas><button class="btn btn-outline-primary w-100 mt-3 rounded-pill" onclick="exportMembersToExcel()"><i class="fas fa-file-excel me-2"></i>Exportar Socios a Excel</button></div></div><div class="col-md-6"><div class="glass-card p-4"><h5 class="text-white"><i class="fas fa-chart-line me-2"></i>Ingresos Mensuales</h5><canvas id="incomeReportChart" height="200"></canvas><button class="btn btn-outline-primary w-100 mt-3 rounded-pill" onclick="exportPaymentsToExcel()"><i class="fas fa-file-excel me-2"></i>Exportar Pagos a Excel</button></div></div></div>
        <div class="glass-card p-4"><h5 class="text-white"><i class="fas fa-file-alt me-2"></i>Reportes Rápidos</h5><div class="d-flex gap-3 flex-wrap"><button class="btn btn-outline-info rounded-pill" onclick="printReport()"><i class="fas fa-print me-2"></i>Imprimir</button></div></div>
    </div>

    <!-- SETTINGS SECTION -->
    <div id="settingsSection" style="display: none;">
        <div class="glass-card p-4"><h5 class="text-white"><i class="fas fa-user-shield me-2"></i>Información del Sistema</h5><p class="text-white-50">Versión: Aura Gym v2.0</p><p class="text-white-50">Usuario: {{ Auth::user()->name }}</p><p class="text-white-50">Rol: Administrador</p><hr><h5 class="text-white mt-3"><i class="fas fa-palette me-2"></i>Apariencia</h5><select id="themeSelect" class="form-select w-50 bg-dark text-white border-0 rounded-pill" onchange="changeTheme()"><option value="dark">Oscuro (por defecto)</option><option value="light">Claro</option></select></div>
    </div>
</div>

<!-- Modales (idénticos a super_admin) -->
<div class="modal fade" id="memberModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content bg-dark text-white"><div class="modal-header border-secondary"><h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Socio</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="editMemberId"><div class="mb-3"><label>Nombre</label><input type="text" id="memberName" class="form-control bg-secondary bg-opacity-25 text-white border-0"></div><div class="mb-3"><label>Apellido</label><input type="text" id="memberLastname" class="form-control bg-secondary bg-opacity-25 text-white border-0"></div><div class="mb-3"><label>Email</label><input type="email" id="memberEmail" class="form-control bg-secondary bg-opacity-25 text-white border-0"></div><div class="mb-3"><label>Teléfono</label><input type="text" id="memberPhone" class="form-control bg-secondary bg-opacity-25 text-white border-0"></div><div class="mb-3"><label>Membresía</label><select id="memberMembership" class="form-select bg-secondary bg-opacity-25 text-white border-0"></select></div><div class="mb-3"><label>Fecha Inicio</label><input type="date" id="memberStartDate" class="form-control bg-secondary bg-opacity-25 text-white border-0"></div><div class="mb-3"><label>Fecha Vencimiento</label><input type="date" id="memberEndDate" class="form-control bg-secondary bg-opacity-25 text-white border-0"></div><div class="mb-3"><label>Estado</label><select id="memberStatus" class="form-select bg-secondary bg-opacity-25 text-white border-0"><option value="active">Activo</option><option value="inactive">Inactivo</option></select></div></div><div class="modal-footer border-secondary"><button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-primary" onclick="saveMember()">Guardar</button></div></div></div></div>
<div class="modal fade" id="paymentModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content bg-dark text-white"><div class="modal-header border-secondary"><h5 class="modal-title"><i class="fas fa-credit-card me-2"></i>Registrar Pago</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label>Socio</label><select id="paymentMember" class="form-select bg-secondary bg-opacity-25 text-white border-0"></select></div><div class="mb-3"><label>Monto</label><input type="number" id="paymentAmount" class="form-control bg-secondary bg-opacity-25 text-white border-0" step="0.01"></div><div class="mb-3"><label>Método</label><select id="paymentMethod" class="form-select bg-secondary bg-opacity-25 text-white border-0"><option value="cash">Efectivo</option><option value="card">Tarjeta</option><option value="transfer">Transferencia</option></select></div><div class="mb-3"><label>Fecha</label><input type="date" id="paymentDate" class="form-control bg-secondary bg-opacity-25 text-white border-0"></div></div><div class="modal-footer border-secondary"><button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-primary" onclick="registerPayment()">Registrar</button></div></div></div></div>
<div class="modal fade" id="freezeModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content bg-dark text-white"><div class="modal-header bg-gradient-warning"><h5 class="modal-title"><i class="fas fa-snowflake me-2"></i>Congelar Membresía</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="freeze_member_id"><div class="mb-3"><label>Miembro</label><input type="text" id="freeze_member_name" class="form-control bg-secondary bg-opacity-25 text-white border-0" readonly></div><div class="mb-3"><label>Plan actual</label><input type="text" id="freeze_membership" class="form-control bg-secondary bg-opacity-25 text-white border-0" readonly></div><div class="mb-3"><label>Próximo pago</label><input type="text" id="freeze_current_end" class="form-control bg-secondary bg-opacity-25 text-white border-0" readonly></div><div class="mb-3"><label>Días a congelar</label><select id="freeze_days" class="form-select bg-secondary bg-opacity-25 text-white border-0"><option value="7">7 días</option><option value="15">15 días</option><option value="30">30 días</option><option value="60">60 días</option></select></div><div class="mb-3"><label>Motivo</label><textarea id="freeze_reason" class="form-control bg-secondary bg-opacity-25 text-white border-0" rows="2"></textarea></div><div class="alert alert-info bg-opacity-25 text-info">Nueva fecha: <strong id="preview_new_end">---</strong></div></div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-warning" onclick="confirmFreeze()"><i class="fas fa-check me-2"></i>Confirmar</button></div></div></div></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    let trendChart, membershipChart, usersReportChart, incomeReportChart;
    let membersData = [], paymentsData = [], attendancesData = [], membershipsData = [];
    let currentMemberEndDate = null;

    $(document).ready(function() {
        initCharts();
        loadMembers();
        loadPayments();
        loadAttendances();
        loadExpiringMembers();
        loadMembershipsForSelect();
        updateDashboardStats();
        setInterval(() => { updateDashboardStats(); loadExpiringMembers(); }, 30000);
    });

    function initCharts() {
        trendChart = new Chart(document.getElementById('trendChart').getContext('2d'), { type: 'line', data: { labels: ['Ene','Feb','Mar','Abr','May','Jun'], datasets: [{ label: 'Ingresos ($)', data: [1200,1900,2800,3500,4200,5100], borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.1)', tension: 0.4, fill: true }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { labels: { color: 'white' } } } } });
        membershipChart = new Chart(document.getElementById('membershipChart').getContext('2d'), { type: 'doughnut', data: { labels: ['Básica','Premium','VIP'], datasets: [{ data: [45,35,20], backgroundColor: ['#10b981','#f59e0b','#ec4899'] }] }, options: { responsive: true, plugins: { legend: { labels: { color: 'white' } } } } });
        if(document.getElementById('usersReportChart')) {
            usersReportChart = new Chart(document.getElementById('usersReportChart').getContext('2d'), { type: 'bar', data: { labels: ['Activos','Inactivos'], datasets: [{ label: 'Socios', data: [0,0], backgroundColor: '#6366f1' }] }, options: { responsive: true } });
            incomeReportChart = new Chart(document.getElementById('incomeReportChart').getContext('2d'), { type: 'line', data: { labels: ['Ene','Feb','Mar','Abr','May','Jun'], datasets: [{ label: 'Ingresos ($)', data: [0,0,0,0,0,0], borderColor: '#10b981', tension: 0.4 }] }, options: { responsive: true } });
        }
    }

    function updateDashboardStats() {
        $.ajax({ url: '{{ route("dashboard.stats") }}', type: 'GET', success: function(data) {
            $('#dashTotalMembers').text(data.totalMembers);
            $('#dashTodayAttendance').text(data.todayAttendance);
            $('#dashTotalIncome').text(data.totalIncome);
            $('#dashPendingRenewals').text(data.pendingRenewals || 0);
        } });
    }

    function switchToPage(page) {
        $('.nav-link').removeClass('active'); $(`.nav-link[data-page="${page}"]`).addClass('active');
        $('#dashboardSection, #membersSection, #paymentsSection, #attendanceSection, #reportsSection, #settingsSection').hide();
        if(page==='dashboard') $('#dashboardSection').show();
        else if(page==='members') { $('#membersSection').show(); loadMembers(); }
        else if(page==='payments') { $('#paymentsSection').show(); loadPayments(); }
        else if(page==='attendance') { $('#attendanceSection').show(); loadAttendances(); }
        else if(page==='reports') { $('#reportsSection').show(); updateReportCharts(); }
        else if(page==='settings') $('#settingsSection').show();
        $('#pageTitle').text($(`.nav-link[data-page="${page}"] span`).text());
    }
    $('#toggleSidebar').click(() => { $('#sidebar').toggleClass('collapsed'); $('#mainContent').toggleClass('expanded'); });
    $('.nav-link').click(function() { switchToPage($(this).data('page')); });

    // Members CRUD (idéntico a super_admin)
    function loadMembers() { $.ajax({ url: '{{ route("api.members") }}', type: 'GET', success: (data) => { membersData = data; renderMembersTable(data); } }); }
    function renderMembersTable(members) { let search = $('#memberSearch').val().toLowerCase(), status = $('#statusFilter').val(); let filtered = members.filter(m => (m.name+' '+m.lastname+' '+m.email).toLowerCase().includes(search) && (!status || m.status===status)); let html = ''; filtered.forEach(m => { let statusBadge = m.status==='active' ? 'bg-success' : 'bg-secondary'; html += `<tr><td>${m.id}</td><td class="fw-bold">${m.name} ${m.lastname}</td><td>${m.email}</td><td>${m.phone||'-'}</td><td>${m.membership_name||'N/A'}</td><td>${m.end_date||'-'}</td><td><span class="badge ${statusBadge}">${m.status==='active'?'Activo':'Inactivo'}</span></td><td><button class="btn btn-sm btn-outline-info me-1" onclick="editMember(${m.id})"><i class="fas fa-edit"></i></button><button class="btn btn-sm btn-outline-warning me-1" onclick="openFreezeModal(${m.id},'${m.name} ${m.lastname}','${m.membership_name}','${m.end_date}')"><i class="fas fa-snowflake"></i></button><button class="btn btn-sm btn-outline-danger" onclick="deleteMember(${m.id})"><i class="fas fa-trash"></i></button></td></tr>`; }); $('#membersTableBody').html(html); }
    function showMemberModal() { $('#editMemberId').val(''); $('#memberName,#memberLastname,#memberEmail,#memberPhone').val(''); $('#memberStartDate').val(new Date().toISOString().split('T')[0]); $('#memberEndDate').val(''); $('#memberStatus').val('active'); $('#memberModal').modal('show'); }
    function editMember(id) { let m = membersData.find(m=>m.id==id); if(m){ $('#editMemberId').val(m.id); $('#memberName').val(m.name); $('#memberLastname').val(m.lastname); $('#memberEmail').val(m.email); $('#memberPhone').val(m.phone); $('#memberMembership').val(m.membership_id); $('#memberStartDate').val(m.start_date); $('#memberEndDate').val(m.end_date); $('#memberStatus').val(m.status); $('#memberModal').modal('show'); } }
    function saveMember() { let id=$('#editMemberId').val(), data={ name:$('#memberName').val(), lastname:$('#memberLastname').val(), email:$('#memberEmail').val(), phone:$('#memberPhone').val(), membership_id:$('#memberMembership').val(), start_date:$('#memberStartDate').val(), end_date:$('#memberEndDate').val(), status:$('#memberStatus').val(), _token:'{{ csrf_token() }}' }; $.ajax({ url: id ? `/members/${id}` : '/members', type: id ? 'PUT' : 'POST', data: data, success:()=>{ $('#memberModal').modal('hide'); Swal.fire('Éxito',id?'Actualizado':'Creado','success'); loadMembers(); updateDashboardStats(); } }); }
    function deleteMember(id){ Swal.fire({ title:'¿Eliminar socio?', icon:'warning', showCancelButton:true, confirmButtonColor:'#d33', confirmButtonText:'Sí' }).then(result=>{ if(result.isConfirmed){ $.ajax({ url:`/members/${id}`, type:'DELETE', data:{ _token:'{{ csrf_token() }}' }, success:()=>{ Swal.fire('Eliminado','','success'); loadMembers(); updateDashboardStats(); } }); } }); }

    // Payments (idéntico)
    function loadPayments() { $.ajax({ url:'{{ route("api.payments") }}', type:'GET', success: data => { paymentsData = data; renderPaymentsTable(data); updatePaymentStats(data); } }); }
    function renderPaymentsTable(payments) { let html=''; payments.forEach(p=>{ html+=`<tr><td>${p.id}</td><td>${p.member_name||'N/A'}</td><td>$${parseFloat(p.amount).toFixed(2)}</td><td>${p.payment_date}</td><td><span class="badge bg-info">${p.payment_method}</span></td><td><span class="badge bg-success">${p.status}</span></td><td><button class="btn btn-sm btn-outline-danger" onclick="deletePayment(${p.id})"><i class="fas fa-trash"></i></button></td></tr>`; }); $('#paymentsTableBody').html(html); }
    function updatePaymentStats(payments) { let total=payments.reduce((s,p)=>s+parseFloat(p.amount),0); let monthly=payments.filter(p=>p.payment_date && p.payment_date.startsWith(new Date().toISOString().slice(0,7))).reduce((s,p)=>s+parseFloat(p.amount),0); $('#totalPayments').text(total.toFixed(2)); $('#monthlyPayments').text(monthly.toFixed(2)); $('#transactionCount').text(payments.length); }
    function showPaymentModal() { loadMembersForSelect(); $('#paymentAmount').val(''); $('#paymentDate').val(new Date().toISOString().split('T')[0]); $('#paymentModal').modal('show'); }
    function loadMembersForSelect() { $.ajax({ url:'{{ route("api.members.list") }}', type:'GET', success:data=>{ let options='<option value="">Seleccionar socio</option>'; data.forEach(m=>{ options+=`<option value="${m.id}">${m.name} ${m.lastname}</option>`; }); $('#paymentMember').html(options); } }); }
    function loadMembershipsForSelect() { $.ajax({ url:'{{ route("api.memberships") }}', type:'GET', success:data=>{ let options=''; data.forEach(m=>{ options+=`<option value="${m.id}">${m.name} - $${m.price}</option>`; }); $('#memberMembership').html(options); } }); }
    function registerPayment() { let data={ member_id:$('#paymentMember').val(), amount:$('#paymentAmount').val(), payment_method:$('#paymentMethod').val(), payment_date:$('#paymentDate').val(), _token:'{{ csrf_token() }}' }; if(!data.member_id || !data.amount){ Swal.fire('Error','Complete campos','error'); return; } $.ajax({ url:'{{ route("api.payments.store") }}', type:'POST', data:data, success:()=>{ $('#paymentModal').modal('hide'); Swal.fire('Éxito','Pago registrado','success'); loadPayments(); updateDashboardStats(); } }); }
    function deletePayment(id) { Swal.fire({ title:'¿Eliminar pago?', icon:'warning', showCancelButton:true, confirmButtonColor:'#d33', confirmButtonText:'Sí' }).then(result=>{ if(result.isConfirmed){ $.ajax({ url:`/payments/${id}`, type:'DELETE', data:{ _token:'{{ csrf_token() }}' }, success:()=>{ Swal.fire('Eliminado','','success'); loadPayments(); updateDashboardStats(); } }); } }); }

    // Attendance
    function loadAttendances() { $.ajax({ url:'{{ route("api.attendances") }}', type:'GET', success:data=>{ renderAttendancesTable(data); } }); }
    function renderAttendancesTable(attendances) { let html=''; attendances.forEach(a=>{ html+=`<tr><td>${a.id}</td><td>${a.member_name||'N/A'}</td><td>${a.check_in}</td><td>${a.check_out||'No registrada'}</td><td><button class="btn btn-sm btn-warning" onclick="checkOut(${a.id})"><i class="fas fa-sign-out-alt"></i> Salida</button></td></tr>`; }); $('#attendanceTableBody').html(html); }
    function checkIn() { Swal.fire({ title:'Registrar Entrada', input:'select', inputOptions: getMembersList(), inputPlaceholder:'Seleccionar socio', showCancelButton:true, confirmButtonText:'Registrar' }).then(result=>{ if(result.isConfirmed && result.value){ $.ajax({ url:'{{ route("api.attendance.checkin") }}', type:'POST', data:{ member_id:result.value, _token:'{{ csrf_token() }}' }, success:()=>{ Swal.fire('Entrada registrada','success'); loadAttendances(); updateDashboardStats(); } }); } }); }
    function checkOut(id) { $.ajax({ url:`/attendance/${id}/checkout`, type:'PUT', data:{ _token:'{{ csrf_token() }}' }, success:()=>{ Swal.fire('Salida registrada','success'); loadAttendances(); } }); }
    function getMembersList() { let options={}; $.ajax({ url:'{{ route("api.members.list") }}', type:'GET', async:false, success:data=>{ data.forEach(m=>{ options[m.id]=`${m.name} ${m.lastname}`; }); } }); return options; }

    // Expiring members
    function loadExpiringMembers() { $.ajax({ url:'{{ route("api.members.expiring") }}', type:'GET', success:data=>{ let html=''; data.forEach(m=>{ let daysLeft=Math.ceil((new Date(m.end_date)-new Date())/(1000*60*60*24)); let badgeClass=daysLeft<=7?'bg-danger':'bg-warning'; html+=`<tr><td>${m.name} ${m.lastname}</td><td>${m.membership_name}</td><td>${m.end_date}</td><td><span class="badge ${badgeClass}">${daysLeft} días</span></td><td><button class="btn btn-sm btn-primary" onclick="renewMembership(${m.id})">Renovar</button></td></tr>`; }); $('#expiringMembersTable').html(html); } }); }
    function renewMembership(id) { Swal.fire({ title:'Renovar Membresía', input:'number', inputLabel:'Días adicionales', inputValue:30, showCancelButton:true, confirmButtonText:'Renovar' }).then(result=>{ if(result.isConfirmed){ $.ajax({ url:`/members/${id}/renew`, type:'POST', data:{ days:result.value, _token:'{{ csrf_token() }}' }, success:()=>{ Swal.fire('Renovada','success'); loadMembers(); loadExpiringMembers(); } }); } }); }

    // Freeze
    function openFreezeModal(id, name, membership, endDate) { $('#freeze_member_id').val(id); $('#freeze_member_name').val(name); $('#freeze_membership').val(membership); $('#freeze_current_end').val(endDate); currentMemberEndDate = endDate; updatePreview(); $('#freezeModal').modal('show'); }
    function updatePreview() { let days = parseInt($('#freeze_days').val()); let currentDate = new Date(currentMemberEndDate); if(!isNaN(currentDate.getTime())){ let newDate = new Date(currentDate); newDate.setDate(currentDate.getDate() + days); $('#preview_new_end').text(newDate.toISOString().split('T')[0]); } else { $('#preview_new_end').text('Fecha inválida'); } }
    $('#freeze_days').on('change', updatePreview);
    function confirmFreeze() { let memberId = $('#freeze_member_id').val(); let days = $('#freeze_days').val(); let reason = $('#freeze_reason').val(); $.ajax({ url:`/members/${memberId}/freeze`, type:'POST', data:{ freeze_days:days, reason:reason, _token:'{{ csrf_token() }}' }, success:function(response) { $('#freezeModal').modal('hide'); Swal.fire('Éxito', `Congelada por ${days} días. Nueva fecha: ${response.new_end_date}`, 'success'); loadMembers(); loadExpiringMembers(); updateDashboardStats(); }, error:function() { Swal.fire('Error', 'No se pudo congelar', 'error'); } }); }

    // Reports & settings
    function updateReportCharts() { $.ajax({ url:'{{ route("api.reports.stats") }}', type:'GET', success:data=>{ if(usersReportChart) usersReportChart.data.datasets[0].data=[data.activeMembers,data.inactiveMembers]; usersReportChart.update(); if(incomeReportChart) incomeReportChart.data.datasets[0].data=data.monthlyIncome; incomeReportChart.update(); } }); }
    function exportMembersToExcel() { $.ajax({ url:'{{ route("api.members") }}', type:'GET', success:data=>{ const wsData = data.map(m=>({ ID:m.id, Nombre:`${m.name} ${m.lastname}`, Email:m.email, Teléfono:m.phone, Membresía:m.membership_name, Vencimiento:m.end_date, Estado:m.status==='active'?'Activo':'Inactivo' })); const ws = XLSX.utils.json_to_sheet(wsData); const wb = XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb, ws, 'Socios'); XLSX.writeFile(wb, `socios_${new Date().toISOString().split('T')[0]}.xlsx`); Swal.fire('Exportado','Excel generado','success'); } }); }
    function exportPaymentsToExcel() { $.ajax({ url:'{{ route("api.payments") }}', type:'GET', success:data=>{ const wsData = data.map(p=>({ ID:p.id, Socio:p.member_name, Monto:p.amount, Fecha:p.payment_date, Método:p.payment_method })); const ws = XLSX.utils.json_to_sheet(wsData); const wb = XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb, ws, 'Pagos'); XLSX.writeFile(wb, `pagos_${new Date().toISOString().split('T')[0]}.xlsx`); Swal.fire('Exportado','Excel generado','success'); } }); }
    function printReport() { window.print(); }
    function showProfile() { Swal.fire({ title:'Mi Perfil', html:`<strong>Nombre:</strong> {{ Auth::user()->name }}<br><strong>Email:</strong> {{ Auth::user()->email }}<br><strong>Rol:</strong> Administrador`, icon:'info', background:'#1e1b4b', color:'#fff' }); }
    function changeTheme() { let theme=$('#themeSelect').val(); if(theme==='light'){ $('body').css('background','#f3f4f6'); $('.glass-card, .stat-card').css('background','rgba(255,255,255,0.8)'); $('.text-white').css('color','#111'); } else { location.reload(); } }
    $('#memberSearch, #statusFilter').on('keyup change', () => loadMembers());
</script>
</body>
</html>