
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  href="{{asset('images/logo-cumbre.svg')}}" rel="icon">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"> 
    
    <title>App Cumbre Petróleo, Gas y Energía</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css?v=2')}}">

</head>

<body>
    
  <!-- Wrapper -->
    <div id="wrapper" class="wrapper">
        <!-- Header Area -->
        <div class="tm-header tm-header-fixed tm-sticky-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-9 col-9">
                        <a class="tm-header-logo" href="{{route('welcome')}}">
                            <img src="{{asset('images/Logo-completo-cumbre.svg')}}" alt="Cumbre logo">
                        </a>
                    </div>
                    <div class="col-lg-9 col-md-3 col-3">
                        <nav class="tm-navigation tm-header-navigation">
                            <ul>
                                <li class="current"><a href="#tm-area-heroslider">Inicio</a></li>
                                <li><a href="#tm-area-features">Acerca de la App</a></li>
                                <li><a href="#tm-area-screenshots">Capturas</a></li>
                                <li><a href="{{route('policy')}}">Políticas</a></li>
                                <li><a href="{{route('terms')}}">Términos</a></li>
                                <li class="tm-navigation-dropdown" style="display: none;"><a href="#tm-area-blog">Blog</a>
                                    <ul>
                                        <li><a href="blog.html">Blog Grid</a></li>
                                        <li><a href="blog-without-sidebar.html">Blog Grid Without Sidebar</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                        <li><a href="blog-details-without-sidebar.html">Blog Details Without Sidebar</a></li>
                                    </ul>
                                </li>
                                <li><a href="#footer-contact">Contacto</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="tm-mobilenav"></div>
            </div>
        </div>
        <!--// Header Area -->

         <!-- Heroslider Area -->
         <div id="tm-area-heroslider" class="tm-heroslider">
            <div class="tm-heroslider-inner">
                <img src="{{asset('images/heroslider-overlay-shape.png')}}" alt="heroslider ovelay" class="tm-heroslider-ovelayshape">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-lg-7 order-2 order-lg-1">
                            <div class="tm-heroslider-content">
                                <h1>Descubre la nueva App<br> de la VII Cumbre de Petróleo, Gas y Energía</h1>
                                <p>Mantente informado, participa en tiempo real y no te pierdas ningún detalle de uno de los eventos más importantes de la industria.</p>
                                <div class="tm-buttongroup">
                                    <a href="https://play.google.com/store/apps/details?id=com.codant.viicumbre" target="_blank" class="tm-button tm-button-lg tm-button-white tm-button-transparent">
                                        <i class="icon-app">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="white" d="m3.637 3.434l8.74 8.571l-8.675 8.65a2.1 2.1 0 0 1-.326-.613a2.5 2.5 0 0 1 0-.755V4.567c-.026-.395.065-.79.26-1.133m12.506 4.833l-2.853 2.826L4.653 2.6c.28-.097.58-.124.873-.078c.46.126.899.32 1.302.573l7.816 4.325c.508.273 1.003.56 1.498.847M13.29 12.93l2.839 2.788l-2.058 1.146l-6.279 3.49c-.52.287-1.042.561-1.55.874a1.8 1.8 0 0 1-1.472.195zm7.36-.925a1.92 1.92 0 0 1-.99 1.72l-2.346 1.302l-3.087-3.022l3.1-3.074c.795.443 1.577.886 2.358 1.303a1.89 1.89 0 0 1 .964 1.771"/>
                                            </svg>
                                        </i>
                                        <span>Google Play</span>
                                    </a>
                                    <a href="https://apps.apple.com/co/app/viicumbrepetroleoygas/id6698888746" target='_blank' class="tm-button tm-button-lg tm-button-white tm-button-transparent">
                                        <i class="icon-app">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                <path fill="white" d="m8.809 14.92l6.11-11.037c.084-.152.168-.302.244-.459c.069-.142.127-.285.165-.44c.08-.326.058-.666-.066-.977a1.5 1.5 0 0 0-.62-.735a1.42 1.42 0 0 0-.922-.193c-.32.043-.613.194-.844.43c-.11.11-.2.235-.283.368c-.092.146-.175.298-.259.45l-.386.697l-.387-.698c-.084-.151-.167-.303-.259-.449a2.2 2.2 0 0 0-.283-.369a1.45 1.45 0 0 0-.844-.429a1.42 1.42 0 0 0-.921.193a1.5 1.5 0 0 0-.62.735a1.6 1.6 0 0 0-.066.977c.038.155.096.298.164.44c.076.157.16.307.244.459l1.248 2.254l-4.862 8.782H2.03c-.168 0-.336 0-.503.01c-.152.009-.3.028-.448.071c-.31.09-.582.28-.778.548A1.58 1.58 0 0 0 .3 17.404c.197.268.468.457.779.548c.148.043.296.062.448.071c.167.01.335.01.503.01h13.097a2 2 0 0 0 .1-.27c.415-1.416-.616-2.844-2.035-2.844zm-5.696 3.622l-.792 1.5c-.082.156-.165.31-.239.471a2.4 2.4 0 0 0-.16.452a1.7 1.7 0 0 0 .064 1.003c.121.318.334.583.607.755s.589.242.901.197c.314-.044.6-.198.826-.44c.108-.115.196-.242.278-.378c.09-.15.171-.306.253-.462L6 19.464c-.09-.15-.947-1.47-2.887-.922m20.586-3.006a1.47 1.47 0 0 0-.779-.54a2 2 0 0 0-.448-.071c-.168-.01-.335-.01-.503-.01h-3.321L14.258 7.1a4.06 4.06 0 0 0-1.076 2.198a4.64 4.64 0 0 0 .546 3l5.274 9.393c.084.15.167.3.259.444c.084.13.174.253.283.364c.231.232.524.38.845.423s.643-.024.922-.19a1.5 1.5 0 0 0 .621-.726c.125-.307.146-.642.066-.964a2.2 2.2 0 0 0-.165-.434c-.075-.155-.16-.303-.244-.453l-1.216-2.166h1.596c.168 0 .335 0 .503-.009c.152-.009.3-.028.448-.07a1.47 1.47 0 0 0 .78-.541a1.54 1.54 0 0 0 .3-.916a1.54 1.54 0 0 0-.3-.916"/>
                                            </svg>
                                        </i>
                                        <span>IOS App Store</span>
                                    </a>
                                </div>
                                <a href="#tm-area-features" class="tm-heroslider-scrolldown">
                                    <i class="zmdi zmdi-square-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 order-1 order-lg-2">
                            <div class="tm-heroslider-mobileshow">

                                <img src="{{asset('images/app-grande.png')}}" alt="appcumbre mobile">
                                <div class="tm-heroslider-mobileshowanim">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--// Heroslider Area -->

        <!----------Features----------->
        <main class="page-content">
            <div id="tm-area-features" class="tm-features-area tm-section tm-padding-section bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 tm-feature">
                            <span class="tm-feature-icon">
                                <img class="icon-features" src="{{asset('images/notifications-icon.svg')}}" alt="icono-notificaciones">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="70px" height="72px">
                                        <path fill="#7FB41E" d="M52.556,54.307 C64.348,37.302 73.747,12.982 68.512,4.877 C60.795,-7.064 13.848,4.659 2.850,20.520 C2.466,21.074 2.124,21.636 1.831,22.199 C-6.854,38.889 17.104,75.968 33.774,71.638 C39.513,70.148 46.364,63.237 52.556,54.307 " />
                                </svg>
                            </span>    
                            <div class="cont-feature">
                                <h2 class="title-feature" data-aos="fade-left" data-aos-duration="1000" data-aos-once="false">Notificaciones</h2>
                                <p data-aos="fade-left" data-aos-duration="1000" data-aos-once="false">Facilidad para estar al tanto de las charlas que más te interesen, mediante el sistema de notificaciones personalizadas.</p>
                            </div>
                        </div>

                        <div class="col-md-4 tm-feature">
                            <span class="tm-feature-icon">
                                <img class="icon-features" src="{{asset('images/people.svg')}}" alt="icono-notificaciones">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="70px" height="72px">
                                        <path fill="#7FB41E" d="M52.556,54.307 C64.348,37.302 73.747,12.982 68.512,4.877 C60.795,-7.064 13.848,4.659 2.850,20.520 C2.466,21.074 2.124,21.636 1.831,22.199 C-6.854,38.889 17.104,75.968 33.774,71.638 C39.513,70.148 46.364,63.237 52.556,54.307 " />
                                </svg>
                            </span>    
                            <div class="cont-feature">
                                <h2 class="title-feature">Interacción</h2>
                                <p>Ten contacto directo e interactua con los panelistas mediante el sistema de preguntas, comentarios y calificación de la nueva App</p>
                            </div>
                        </div>
                        <div class="col-md-4 tm-feature">
                            <span class="tm-feature-icon">
                                <img class="icon-features" src="{{asset('images/video-square.svg')}}" alt="icono-notificaciones">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="70px" height="72px">
                                        <path fill="#7FB41E" d="M52.556,54.307 C64.348,37.302 73.747,12.982 68.512,4.877 C60.795,-7.064 13.848,4.659 2.850,20.520 C2.466,21.074 2.124,21.636 1.831,22.199 C-6.854,38.889 17.104,75.968 33.774,71.638 C39.513,70.148 46.364,63.237 52.556,54.307 " />
                                </svg>
                            </span>    
                            <div class="cont-feature">
                                <h2 class="title-feature">Traducción</h2>
                                <p>Que el idioma no sea un limitante para perderte tu charla favorita, la nueva app cuenta con transmisión en vivo de voz de traductores expertos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <!--// Features---------------->

        <!-----------About App--------->
        <div id="tm-area-about" class="tm-about-area tm-section tm-padding-section bg-grey">
            <h2 class="text-center" data-aos="fade-left" data-aos-duration="1000" data-aos-once="false">Acerca de la App Cumbre del Petróleo y gas</h2>
            <div class="container">
                <div class="row pt-5">
                    <div class="col-md-6">
                        <div class="tm-about-image">
                            <img src="{{asset('images/image-about-app.png')}}" alt="about-app" data-aos="fade-left" data-aos-duration="1000" data-aos-once="false">
                        </div>      
                    </div>
                    <div class="col-md-6">
                        <h4>Descripción de la App:</h4>
                        <p>
                            En esta aplicación encontrará información relacionada con las agendas del evento, perfiles de conferencistas, 
                            patrocinadores, expositores y traducción en vivo, entre otras funciones que permitirán una mejor experiencia 
                            dentro del evento.
                        </p>

                        <h4>Secciones de la App:</h4>
                        <ul>
                            <li>Agendas</li>
                            <li>Panelistas</li>
                            <li>Comentarios y reviews</li>
                            <li>Actualidad de la cumbre</li>
                            <li>Traducción en vivo</li>
                            <li>Sitios de interés</li>
                            <li>Recursos de las charlas</li>
                            <li>Patrocinadores</li>
                            <li>Perfil de usuario</li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
        <!--//---About App-------- ---->

                <!--------FOOTER------->
                <div class="tm-footer bg-gradient">
            <div class="tm-footer-bgshape">
                <img src="{{asset('images/heroslider-overlay-shape.png')}}" alt="footer background shape">
            </div>
            <div class="container">
                <div class="tm-footer-toparea tm-padding-section">
                    <div class="row widgets tm-footer-widgets">
                        <div class="col-md-6">
                            <div class="single-widget widget-info">
                                <a href="index.html" class="widget-info-logo">
                                    <img src="{{asset('images/Logo-completo-cumbre.svg')}}" alt="logo-Cumbre">
                                </a>
                                <p>
                                    Eje central para reunir en un solo escenario, lo más selecto de una industria que
                                    tiene uno de los mayores aportes al Producto Interno Bruto (PIB) del país.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="single-widget widget-quicklinks">
                                <h5 class="widget-title">Accesos</h5>
                                <ul>
                                    <li><a href="#">Inicio</a></li>
                                    <li><a href="#tm-area-features">Acerca de la app</a></li>
                                    <li><a href="#">Capturas</a></li>
                                    <li><a href="{{route('policy')}}">Políticas de datos</a></li>
                                    <li><a href="{{route('terms')}}">Términos</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="single-widget widget-quicklinks">
                                <h5 class="widget-title" id="footer-contact">Contacto</h5>
                                <ul>
                                    <li><a href="mailto:app.cumbredelpetroleo@gmail.com ">app.cumbredelpetroleo@gmail.com</a></li>
                                </ul>
                            </div>
                            <h5 class="widget-title mt-5">Síguenos</h5>
                                <ul class="tm-footer-social">
                                    <li>
                                        <a href="https://www.facebook.com/CumbrePetroleoyGas" target="_blank">
                                            <i class="zmdi zmdi-facebook"></i>
                                            <i class="zmdi zmdi-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.youtube.com/@cumbredelpetroleoygas7632" target="_blank">
                                            <i class="zmdi zmdi-youtube"></i>
                                            <i class="zmdi zmdi-youtube"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/cumbredelpetroleoygas/" target="_blank">
                                            <i class="zmdi zmdi-instagram"></i>
                                            <i class="zmdi zmdi-instagram"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://x.com/i/flow/login?redirect_after_login=%2FPetroleoyGasCo" target="_blank">
                                            <i class="zmdi zmdi-twitter"></i>
                                            <i class="zmdi zmdi-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/company/cumbrepetroleoygas/" target="_blank">
                                            <i class="zmdi zmdi-linkedin"></i>
                                            <i class="zmdi zmdi-linkedin"></i>
                                        </a>
                                    </li>
                                </ul>
                        </div>
                    </div>
                </div>
                <div class="tm-footer-bottomarea">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <p class="tm-footer-copyright">Copyright 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--//----FOOTER------->

     <!-- Js Files -->
     <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
     <script src="{{asset('js/jquery.min.js')}}"></script>
     <script src="{{asset('js/plugins.js')}}"></script>
     <script src="{{asset('js/main.js')}}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
     <!--// Js Files -->
    <script>
        $(document).ready(function() {

        AOS.init({
            duration: 1000,
            easing: 'ease', 
            once: true
            
        });
        })
    </script>
     


</body>
</html>
