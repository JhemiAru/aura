<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aura Gym | Entrenador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Mismos estilos que admin */
        :root { --primary: #6366f1; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: radial-gradient(circle at 10% 20%, rgba(99,102,241,0.15) 0%, rgba(236,72,153,0.15) 100%), linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); background-attachment: fixed; }
        .sidebar { position: fixed; left: 0; top: 0; height: 100vh; width: 280px; background: rgba(15,23,42,0.8); backdrop-filter: blur(20px); border-right: 1px solid rgba(255,255,255,0.1); z-index: 1000; transition: all 0.4s; overflow-y: auto; }
        .sidebar.collapsed { width: 90px; }
        .sidebar.collapsed .sidebar-text, .sidebar.collapsed .user-info .user-details { display: none; }
        .sidebar-header { padding: 30px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 15px; padding: 0 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 25px; }
        .nav-link { display: flex; align-items: center; gap: 15px; color: rgba(255,255,255,0.7); padding: 12px 20px; margin: 5px 15px; border-radius: 12px; transition: 0.3s; cursor: pointer; }
        .nav-link:hover { background: rgba(99,102,241,0.3); color: white; }
        .nav-link.active { background: linear-gradient(135deg, var(--primary), #4f46e5); color: white; }
        .main-content { margin-left: 280px; transition: 0.4s; min-height: 100vh; padding: 25px; }
        .main-content.expanded { margin-left: 90px; }
        .glass-card { background: rgba(255,255,255,0.07); backdrop-filter: blur(12px); border-radius: 24px; border: 1px solid rgba(255,255,255,0.15); padding: 20px; transition: 0.3s; }
        .glass-card:hover { transform: translateY(-4px); border-color: rgba(99,102,241,0.5); }
        .stat-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(8px); border-radius: 20px; padding: 20px; transition: 0.3s; cursor: pointer; border: 1px solid rgba(255,255,255,0.1); }
        .stat-number { font-size: 2rem; font-weight: 800; background: linear-gradient(135deg, #fff, #a5b4fc); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .btn-glow { background: linear-gradient(135deg, var(--primary), #4f46e5); border: none; box-shadow: 0 4px 15px rgba(99,102,241,0.4); }
        .fc { background: rgba(255,255,255,0.05); border-radius: 20px; padding: 15px; color: white; }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header text-center"><h3 class="text-white"><i class="fas fa-dumbbell"></i> <span class="sidebar-text">AURA GYM</span></h3><p class="text-white-50 small sidebar-text">Panel Entrenador</p></div>
    <div class="user-info"><img src="https://ui-avatars.com/api/?background=6366f1&color=fff&rounded=true&bold=true&size=50&name={{ Auth::user()->name }}" width="50" height="50" class="rounded-circle"><div class="user-details"><h6 class="text-white mb-0">{{ Auth::user()->name }}</h6><small class="text-white-50">Entrenador</small></div></div>
    <nav><div class="nav-link active" data-page="dashboard"><i class="fas fa-chart-pie"></i><span class="sidebar-text">Dashboard</span></div><div class="nav-link" data-page="clients"><i class="fas fa-users"></i><span class="sidebar-text">Mis Socios</span></div><div class="nav-link" data-page="schedule"><i class="fas fa-calendar-alt"></i><span class="sidebar-text">Horarios</span></div><div class="nav-link" data-page="routines"><i class="fas fa-dumbbell"></i><span class="sidebar-text">Rutinas</span></div></nav>
    <div class="position-absolute bottom-0 start-0 end-0 p-3"><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn btn-outline-danger w-100 rounded-pill"><i class="fas fa-sign-out-alt me-2"></i><span class="sidebar-text">Cerrar Sesión</span></button></form></div>
</div>

<div class="main-content" id="mainContent">
    <div class="glass-card mb-4 d-flex justify-content-between align-items-center">
        <div><button class="btn btn-link text-white" id="toggleSidebar"><i class="fas fa-bars fa-2x"></i></button><span class="ms-3 text-white h4" id="pageTitle">Dashboard</span></div>
        <div class="dropdown"><button class="btn btn-link text-white dropdown-toggle" data-bs-toggle="dropdown"><img src="https://ui-avatars.com/api/?background=6366f1&color=fff&rounded=true&bold=true&size=40&name={{ Auth::user()->name }}" width="40" height="40" class="rounded-circle"></button><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="#" onclick="showProfile()"><i class="fas fa-user me-2"></i>Mi Perfil</a></li><li><hr class="dropdown-divider"></li><li><form method="POST" action="{{ route('logout') }}" id="logout-form">@csrf<a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></form></li></ul></div>
    </div>

    <div id="dashboardSection">
        <div class="row g-4 mb-4">
            <div class="col-md-4"><div class="stat-card"><div><span class="text-white-50">Mis Socios</span><div class="stat-number" id="totalClients">0</div></div><i class="fas fa-users fa-3x text-primary opacity-50 float-end"></i></div></div>
            <div class="col-md-4"><div class="stat-card"><div><span class="text-white-50">Clases Hoy</span><div class="stat-number" id="todayClasses">0</div></div><i class="fas fa-chalkboard-user fa-3x text-success opacity-50 float-end"></i></div></div>
            <div class="col-md-4"><div class="stat-card"><div><span class="text-white-50">Rutinas Activas</span><div class="stat-number" id="activeRoutines">0</div></div><i class="fas fa-dumbbell fa-3x text-warning opacity-50 float-end"></i></div></div>
        </div>
        <div class="row"><div class="col-lg-8"><div class="glass-card"><div id="calendar"></div></div></div><div class="col-lg-4"><div class="glass-card"><h5 class="text-white">Próximas Clases con mis socios</h5><ul id="upcomingList" class="list-unstyled mt-3"></ul></div></div></div>
    </div>

    <div id="clientsSection" style="display: none;">
        <div class="glass-card"><h5 class="text-white"><i class="fas fa-users me-2"></i>Socios Asignados</h5><div class="table-responsive mt-3"><table class="table table-dark table-hover"><thead><tr><th>Nombre</th><th>Email</th><th>Membresía</th><th>Acciones</th></tr></thead><tbody id="clientsTableBody"></tbody></table></div></div>
    </div>

    <div id="scheduleSection" style="display: none;">
        <div class="glass-card"><div id="trainerCalendar"></div></div>
    </div>

    <div id="routinesSection" style="display: none;">
        <div class="glass-card"><h5 class="text-white"><i class="fas fa-dumbbell me-2"></i>Rutinas</h5><button class="btn btn-glow mb-3" onclick="createRoutine()"><i class="fas fa-plus"></i> Nueva Rutina</button><div id="routinesList" class="row g-3"></div></div>
    </div>
</div>

<!-- Modal asignar rutina -->
<div class="modal fade" id="assignRoutineModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content bg-dark text-white"><div class="modal-header"><h5 class="modal-title">Asignar Rutina</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="assignClientId"><div class="mb-3"><label>Cliente</label><input type="text" id="assignClientName" class="form-control bg-secondary bg-opacity-25 text-white border-0" readonly></div><div class="mb-3"><label>Rutina</label><select id="routineSelect" class="form-select bg-secondary bg-opacity-25 text-white border-0"></select></div><div class="mb-3"><label>Fecha inicio</label><input type="date" id="routineStartDate" class="form-control bg-secondary bg-opacity-25 text-white border-0"></div><div class="mb-3"><label>Notas</label><textarea id="routineNotes" class="form-control bg-secondary bg-opacity-25 text-white border-0" rows="2"></textarea></div></div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-primary" onclick="saveAssignedRoutine()">Asignar</button></div></div></div></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let calendar, trainerCalendar;
    let myClients = @json($myClients ?? []);
    let routines = [{ id:1, name:"Full Body", exercises:"Sentadillas, press banca, dominadas" }, { id:2, name:"Cardio HIIT", exercises:"Sprints, burpees" }];
    let events = [];

    $(document).ready(function() {
        initCalendar();
        loadClients();
        updateStats();
        loadUpcoming();
    });

    function initCalendar() {
        let calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, { initialView: 'dayGridMonth', locale: 'es', headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' }, events: events, eventClick: function(info) { Swal.fire(info.event.title, info.event.extendedProps.description, 'info'); } });
        calendar.render();
        let trainerCalEl = document.getElementById('trainerCalendar');
        if(trainerCalEl) { trainerCalendar = new FullCalendar.Calendar(trainerCalEl, { initialView: 'dayGridMonth', locale: 'es', events: events }); trainerCalendar.render(); }
    }

    function loadClients() { let html=''; myClients.forEach(c => { html+=`<tr><td>${c.name} ${c.lastname}</td><td>${c.email}</td><td>${c.membership_name||'N/A'}</td><td><button class="btn btn-sm btn-primary" onclick="assignRoutine(${c.id},'${c.name} ${c.lastname}')"><i class="fas fa-dumbbell"></i> Asignar Rutina</button></td></tr>`; }); $('#clientsTableBody').html(html); }
    function assignRoutine(clientId, clientName) { $('#assignClientId').val(clientId); $('#assignClientName').val(clientName); let options=''; routines.forEach(r=>{ options+=`<option value="${r.id}">${r.name}</option>`; }); $('#routineSelect').html(options); $('#routineStartDate').val(new Date().toISOString().split('T')[0]); $('#assignRoutineModal').modal('show'); }
    function saveAssignedRoutine() { Swal.fire('Asignado', 'Rutina asignada correctamente', 'success'); $('#assignRoutineModal').modal('hide'); }
    function createRoutine() { Swal.fire({ title:'Nueva Rutina', input:'text', inputLabel:'Nombre', showCancelButton:true }).then(result=>{ if(result.value) Swal.fire('Creada', 'Rutina creada', 'success'); }); }
    function updateStats() { $('#totalClients').text(myClients.length); $('#todayClasses').text(events.filter(e=>e.start.startsWith(new Date().toISOString().split('T')[0])).length); $('#activeRoutines').text(routines.length); }
    function loadUpcoming() { let html=''; myClients.forEach(c=>{ html+=`<li class="mb-2"><i class="fas fa-user text-info me-2"></i>${c.name} - Próxima clase: ${new Date().toLocaleDateString()}</li>`; }); $('#upcomingList').html(html); }
    function switchToPage(page) { $('.nav-link').removeClass('active'); $(`.nav-link[data-page="${page}"]`).addClass('active'); $('#dashboardSection, #clientsSection, #scheduleSection, #routinesSection').hide(); if(page==='dashboard') $('#dashboardSection').show(); else if(page==='clients') $('#clientsSection').show(); else if(page==='schedule') $('#scheduleSection').show(); else if(page==='routines') $('#routinesSection').show(); $('#pageTitle').text($(`.nav-link[data-page="${page}"] span`).text()); }
    $('#toggleSidebar').click(()=>{ $('#sidebar').toggleClass('collapsed'); $('#mainContent').toggleClass('expanded'); });
    $('.nav-link').click(function(){ switchToPage($(this).data('page')); });
    function showProfile() { Swal.fire('Mi Perfil', `Nombre: {{ Auth::user()->name }}\nEmail: {{ Auth::user()->email }}\nRol: Entrenador`, 'info'); }
</script>
</body>
</html>