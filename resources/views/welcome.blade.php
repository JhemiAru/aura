<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura Gym | Donde la fuerza encuentra su propósito</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Premium -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0a0a0a;
            overflow-x: hidden;
            color: white;
        }

        /* Particle Background */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.15) 0%, rgba(0,0,0,0) 50%),
                        radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.15) 0%, rgba(0,0,0,0) 50%);
        }

        /* Animated Gradient Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(125deg, 
                #0a0a0a 0%, 
                #1a1a2e 25%,
                #16213e 50%,
                #1a1a2e 75%,
                #0a0a0a 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            z-index: -2;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 20s infinite ease-in-out;
            z-index: -1;
        }

        .orb-1 { width: 400px; height: 400px; background: #667eea; top: -100px; left: -100px; animation-delay: 0s; }
        .orb-2 { width: 500px; height: 500px; background: #764ba2; bottom: -150px; right: -150px; animation-delay: 5s; }
        .orb-3 { width: 300px; height: 300px; background: #f093fb; top: 50%; left: 50%; animation-delay: 10s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .glow-text {
            font-family: 'Orbitron', monospace;
            font-size: 5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 30%, #f093fb 60%, #f5576c 100%);
            background-size: 300% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shine 3s linear infinite;
        }

        @keyframes shine {
            to { background-position: 200% center; }
        }

        .subtitle {
            font-size: 1.2rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            background: linear-gradient(135deg, #667eea, #f093fb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 600;
        }

        /* Botones modernos */
        .btn-primary-glow {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 700;
            letter-spacing: 1px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary-glow:hover {
            transform: scale(1.05) translateY(-3px);
            box-shadow: 0 0 35px rgba(102, 126, 234, 0.8);
        }

        .btn-outline-glow {
            background: transparent;
            border: 2px solid rgba(102, 126, 234, 0.8);
            padding: 12px 38px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.4s;
            backdrop-filter: blur(10px);
        }

        .btn-outline-glow:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: 0 0 25px rgba(102, 126, 234, 0.5);
        }

        /* Glass Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            position: relative;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.6s;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .glass-card:hover {
            transform: translateY(-15px);
            border-color: rgba(102, 126, 234, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(240, 147, 251, 0.2));
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 25px;
            transition: all 0.3s;
        }

        .glass-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        /* Stats Counter */
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #f093fb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Pricing Card */
        .pricing-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.03));
            backdrop-filter: blur(15px);
            border-radius: 30px;
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.4s;
        }

        .pricing-card.popular {
            border: 1px solid rgba(102, 126, 234, 0.6);
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.3);
            transform: scale(1.02);
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            border-color: #667eea;
        }

        .price {
            font-size: 3rem;
            font-weight: 800;
            color: #667eea;
        }

        /* Navbar */
        .navbar-glass {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s;
        }

        .navbar-glass.scrolled {
            background: rgba(0, 0, 0, 0.9);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .nav-link-custom {
            color: rgba(255,255,255,0.8);
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s;
            position: relative;
        }

        .nav-link-custom:hover {
            color: white;
        }

        .nav-link-custom::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #f093fb);
            transition: all 0.3s;
            transform: translateX(-50%);
        }

        .nav-link-custom:hover::after {
            width: 80%;
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Scroll Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .glow-text { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

<div class="animated-bg"></div>
<div class="particles"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-glass fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="#" style="font-family: 'Orbitron', monospace;">
            <i class="fas fa-dumbbell" style="color: #667eea;"></i>
            <span style="font-weight: 800; background: linear-gradient(135deg, #667eea, #f093fb); -webkit-background-clip: text; background-clip: text; color: transparent;">AURA</span>
            <span style="color: white;">GYM</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#home">Inicio</a></li>
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#features">Características</a></li>
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#pricing">Planes</a></li>
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#testimonials">Testimonios</a></li>
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#contact">Contacto</a></li>
            </ul>
            <div class="d-flex gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary-glow text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-glow text-white">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary-glow text-white">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container text-center">
        <div data-aos="fade-up" data-aos-duration="1000">
            <span class="subtitle">✦ EL MEJOR GIMNASIO DE LATINOAMÉRICA ✦</span>
            <h1 class="glow-text mt-3 mb-4">DESPIERTA<br>TU FUERZA INTERIOR</h1>
            <p class="lead mb-5" style="max-width: 700px; margin: 0 auto; opacity: 0.9;">
                Más que un gimnasio, una comunidad donde cada repetición te acerca a la mejor versión de ti mismo.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary-glow text-white">Ir al Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary-glow text-white">Comienza Gratis</a>
                    <a href="#features" class="btn btn-outline-glow text-white">Descubrir Más</a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="0">
                <div class="glass-card p-4">
                    <div class="stat-number" id="counter1">5000</div>
                    <p class="mb-0">+ Socios Activos</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="glass-card p-4">
                    <div class="stat-number" id="counter2">50</div>
                    <p class="mb-0">+ Entrenadores</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="glass-card p-4">
                    <div class="stat-number" id="counter3">30</div>
                    <p class="mb-0">Clases Semanales</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="glass-card p-4">
                    <div class="stat-number" id="counter4">98</div>
                    <p class="mb-0">% Satisfacción</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="subtitle">✦ SERVICIOS PREMIUM ✦</span>
            <h2 class="display-4 fw-bold mt-2">Todo lo que necesitas</h2>
            <p class="lead opacity-75">Instalaciones de élite para alcanzar tus metas</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="glass-card p-4 text-center h-100">
                    <div class="feature-icon mx-auto"><i class="fas fa-dumbbell"></i></div>
                    <h4 class="mb-3">Equipamiento Élite</h4>
                    <p class="opacity-75">Máquinas Technogym de última generación y área de pesas profesional.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card p-4 text-center h-100">
                    <div class="feature-icon mx-auto"><i class="fas fa-chalkboard-user"></i></div>
                    <h4 class="mb-3">Coaching Personalizado</h4>
                    <p class="opacity-75">Entrenadores certificados que te guían paso a paso hacia tu objetivo.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card p-4 text-center h-100">
                    <div class="feature-icon mx-auto"><i class="fas fa-heartbeat"></i></div>
                    <h4 class="mb-3">Clases Grupales</h4>
                    <p class="opacity-75">Yoga, Spinning, CrossFit, Zumba y más. Diversión garantizada.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-card p-4 text-center h-100">
                    <div class="feature-icon mx-auto"><i class="fas fa-spa"></i></div>
                    <h4 class="mb-3">Área de Relajación</h4>
                    <p class="opacity-75">Sauna, jacuzzi y zona de recuperación muscular.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="glass-card p-4 text-center h-100">
                    <div class="feature-icon mx-auto"><i class="fas fa-clock"></i></div>
                    <h4 class="mb-3">24/7 Acceso</h4>
                    <p class="opacity-75">Entrena cuando quieras, las 24 horas del día, los 7 días de la semana.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <div class="glass-card p-4 text-center h-100">
                    <div class="feature-icon mx-auto"><i class="fas fa-apple-alt"></i></div>
                    <h4 class="mb-3">Nutrición Deportiva</h4>
                    <p class="opacity-75">Asesoría nutricional y smoothie bar para complementar tu entrenamiento.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="subtitle">✦ PLANES ADAPTADOS A TI ✦</span>
            <h2 class="display-4 fw-bold mt-2">Elige tu membresía</h2>
            <p class="lead opacity-75">Sin letra chica, sin sorpresas</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="0">
                <div class="pricing-card p-4 text-center h-100">
                    <h3>BÁSICO</h3>
                    <div class="price mt-3">$29</div>
                    <p class="opacity-75">/mes</p>
                    <hr class="opacity-25">
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Acceso 24/7</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Área de pesas</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Cardio</li>
                        <li class="mb-2 text-muted"><i class="fas fa-times-circle me-2"></i> Clases grupales</li>
                        <li class="mb-2 text-muted"><i class="fas fa-times-circle me-2"></i> Entrenador personal</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-outline-glow text-white mt-3 w-100">Elegir Plan</a>
                </div>
            </div>
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="100">
                <div class="pricing-card popular p-4 text-center h-100">
                    <div class="badge bg-primary position-absolute top-0 start-50 translate-middle">🔥 MÁS POPULAR</div>
                    <h3>PREMIUM</h3>
                    <div class="price mt-3">$59</div>
                    <p class="opacity-75">/mes</p>
                    <hr class="opacity-25">
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Todo el plan Básico</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Clases grupales</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Nutricionista</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> App exclusiva</li>
                        <li class="mb-2 text-muted"><i class="fas fa-times-circle me-2"></i> Entrenador 1:1</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary-glow text-white mt-3 w-100">Elegir Plan</a>
                </div>
            </div>
            <div class="col-md-4" data-aos="flip-left" data-aos-delay="200">
                <div class="pricing-card p-4 text-center h-100">
                    <h3>VIP</h3>
                    <div class="price mt-3">$99</div>
                    <p class="opacity-75">/mes</p>
                    <hr class="opacity-25">
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Todo el plan Premium</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Entrenador 1:1</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Spa y sauna</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Parking VIP</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Invitados gratis</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-outline-glow text-white mt-3 w-100">Elegir Plan</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="subtitle">✦ TRANSFORMACIONES REALES ✦</span>
            <h2 class="display-4 fw-bold mt-2">Lo que dicen nuestros miembros</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="0">
                <div class="glass-card p-4 h-100">
                    <i class="fas fa-quote-left fa-2x mb-3" style="color: #667eea;"></i>
                    <p class="lead">"En 6 meses cambié mi vida. Bajé 20kg y gané una comunidad increíble."</p>
                    <div class="d-flex align-items-center mt-3">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3" width="50">
                        <div>
                            <h6 class="mb-0">María González</h6>
                            <small class="opacity-75">Miembro Premium</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="glass-card p-4 h-100">
                    <i class="fas fa-quote-left fa-2x mb-3" style="color: #f093fb;"></i>
                    <p class="lead">"Los entrenadores son los mejores. Siempre pendientes de tu técnica."</p>
                    <div class="d-flex align-items-center mt-3">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-3" width="50">
                        <div>
                            <h6 class="mb-0">Carlos Rodríguez</h6>
                            <small class="opacity-75">Miembro VIP</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="glass-card p-4 h-100">
                    <i class="fas fa-quote-left fa-2x mb-3" style="color: #f5576c;"></i>
                    <p class="lead">"Las clases de spinning son mi terapia. Instalaciones de lujo."</p>
                    <div class="d-flex align-items-center mt-3">
                        <img src="https://randomuser.me/api/portraits/women/45.jpg" class="rounded-circle me-3" width="50">
                        <div>
                            <h6 class="mb-0">Ana Martínez</h6>
                            <small class="opacity-75">Miembro Básico</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="glass-card p-5 text-center" data-aos="flip-up">
            <h2 class="display-5 fw-bold mb-3">¿Listo para empezar tu transformación?</h2>
            <p class="lead mb-4">Únete hoy y obtén 30% de descuento en tu primera mensualidad.</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary-glow text-white">Ir al Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary-glow text-white">Comienza Ahora</a>
            @endauth
        </div>
    </div>
</section>

<!-- Footer -->
<footer id="contact" class="footer pt-5 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4><i class="fas fa-dumbbell" style="color: #667eea;"></i> AURA GYM</h4>
                <p class="opacity-75">Donde la fuerza encuentra su propósito. Transformando vidas desde 2020.</p>
                <div class="mt-3">
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="#home" class="text-white-50 text-decoration-none">Inicio</a></li>
                    <li><a href="#features" class="text-white-50 text-decoration-none">Características</a></li>
                    <li><a href="#pricing" class="text-white-50 text-decoration-none">Planes</a></li>
                    <li><a href="#testimonials" class="text-white-50 text-decoration-none">Testimonios</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Horario</h5>
                <ul class="list-unstyled opacity-75">
                    <li><i class="far fa-calendar-alt me-2"></i> Lunes a Viernes: 6:00 - 22:00</li>
                    <li><i class="far fa-calendar-alt me-2"></i> Sábados: 8:00 - 20:00</li>
                    <li><i class="far fa-calendar-alt me-2"></i> Domingos: 9:00 - 14:00</li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Contacto</h5>
                <ul class="list-unstyled opacity-75">
                    <li><i class="fas fa-map-marker-alt me-2"></i> Av. Principal #123, CDMX</li>
                    <li><i class="fas fa-phone me-2"></i> +52 55 1234 5678</li>
                    <li><i class="fas fa-envelope me-2"></i> hola@auragym.com</li>
                </ul>
            </div>
        </div>
        <hr class="opacity-25">
        <div class="text-center opacity-50">
            &copy; {{ date('Y') }} Aura Gym. Todos los derechos reservados. | Hecho con <i class="fas fa-heart" style="color: #f5576c;"></i> para tu éxito
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Counter animation
    function animateCounter(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.innerText = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                if (id === 'counter1') animateCounter(entry.target, 0, 5000, 2000);
                if (id === 'counter2') animateCounter(entry.target, 0, 50, 1500);
                if (id === 'counter3') animateCounter(entry.target, 0, 30, 1500);
                if (id === 'counter4') animateCounter(entry.target, 0, 98, 1500);
                observer.unobserve(entry.target);
            }
        });
    });

    document.querySelectorAll('.stat-number').forEach(el => observer.observe(el));
</script>
</body>
</html>