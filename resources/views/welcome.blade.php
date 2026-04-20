<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura Gym | Tu mejor versión comienza aquí</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-x: hidden;
        }
        /* Hero section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            color: white;
            text-align: center;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
            pointer-events: none;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .btn-custom {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: white;
        }
        .btn-outline-custom {
            background: transparent;
            border: 2px solid white;
            padding: 10px 28px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-outline-custom:hover {
            background: white;
            color: #764ba2;
            transform: translateY(-3px);
        }
        .feature-card {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px 20px;
            transition: all 0.3s;
            height: 100%;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0,0,0,0.1);
            background: white;
        }
        .feature-icon {
            font-size: 3rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .footer {
            background: rgba(0,0,0,0.8);
            color: #ccc;
            padding: 40px 0 20px;
        }
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .section-title { font-size: 2rem; }
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <div class="container hero-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-3">🏋️‍♂️ Aura Gym</h1>
                <p class="lead mb-4">Transforma tu cuerpo, fortalece tu mente. El lugar donde el esfuerzo encuentra su recompensa.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-custom text-white">Ir al Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-custom text-white">Iniciar Sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-custom text-white">Registrarse</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Características -->
<section class="container py-5">
    <div class="text-center text-white mb-5">
        <h2 class="section-title">¿Por qué elegir Aura Gym?</h2>
        <p class="lead">Instalaciones de primer nivel, entrenadores certificados y una comunidad que te impulsa.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="feature-icon"><i class="fas fa-dumbbell"></i></div>
                <h4>Equipamiento Premium</h4>
                <p>Máquinas de última generación y área de pesas completamente equipada.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="feature-icon"><i class="fas fa-chalkboard-user"></i></div>
                <h4>Entrenadores Expertos</h4>
                <p>Personal capacitado para guiarte y ayudarte a alcanzar tus metas.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="feature-icon"><i class="fas fa-heartbeat"></i></div>
                <h4>Clases Grupales</h4>
                <p>Yoga, spinning, crossfit, zumba y más. Diversión y resultados asegurados.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="feature-icon"><i class="fas fa-clock"></i></div>
                <h4>Horarios Flexibles</h4>
                <p>Abierto de lunes a domingo, adaptamos nuestros horarios a tu rutina.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="feature-icon"><i class="fas fa-hand-holding-usd"></i></div>
                <h4>Planes Accesibles</h4>
                <p>Membresías adaptadas a tu bolsillo sin sacrificar calidad.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h4>Comunidad Activa</h4>
                <p>Eventos, retos y una red de apoyo para mantenerte motivado.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonios -->
<section class="container py-5">
    <div class="text-center text-white mb-5">
        <h2 class="section-title">Lo que dicen nuestros miembros</h2>
        <p>Historias reales de transformación.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card text-center">
                <i class="fas fa-quote-left fa-2x text-primary mb-3"></i>
                <p>"Desde que me uní a Aura Gym he perdido 15 kg y ganado confianza. El mejor gimnasio de la ciudad."</p>
                <h6 class="mt-3">- María González</h6>
                <small>Miembro Premium</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <i class="fas fa-quote-left fa-2x text-primary mb-3"></i>
                <p>"Los entrenadores son increíbles, siempre pendientes de tu técnica y progreso. Me encanta."</p>
                <h6 class="mt-3">- Carlos Rodríguez</h6>
                <small>Miembro VIP</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card text-center">
                <i class="fas fa-quote-left fa-2x text-primary mb-3"></i>
                <p>"Las clases de spinning son lo mejor. Instalaciones limpias y personal muy amable."</p>
                <h6 class="mt-3">- Ana Martínez</h6>
                <small>Miembro Básico</small>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="container py-5 text-center">
    <div class="bg-white bg-opacity-25 rounded-4 p-5">
        <h2 class="mb-3 text-white">¿Listo para empezar tu transformación?</h2>
        <p class="lead text-white mb-4">Únete hoy y obtén un 20% de descuento en tu primera mensualidad.</p>
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-custom text-white">Ir al Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="btn btn-custom text-white">Comienza Ahora</a>
        @endauth
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-dumbbell"></i> Aura Gym</h5>
                <p>Transformando vidas a través del fitness. Más que un gimnasio, una comunidad.</p>
                <div class="mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50 text-decoration-none">Inicio</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Clases</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Planes</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Contacto</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Horario</h5>
                <ul class="list-unstyled text-white-50">
                    <li>Lunes a Viernes: 6:00 - 22:00</li>
                    <li>Sábados: 8:00 - 20:00</li>
                    <li>Domingos: 9:00 - 14:00</li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Contacto</h5>
                <ul class="list-unstyled text-white-50">
                    <li><i class="fas fa-map-marker-alt me-2"></i> Av. Principal #123, Ciudad</li>
                    <li><i class="fas fa-phone me-2"></i> +123 456 7890</li>
                    <li><i class="fas fa-envelope me-2"></i> info@auragym.com</li>
                </ul>
            </div>
        </div>
        <hr class="bg-white-50">
        <div class="text-center text-white-50">
            &copy; {{ date('Y') }} Aura Gym. Todos los derechos reservados.
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>