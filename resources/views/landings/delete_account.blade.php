<!DOCTYPE html>
<html lang="es">
  <style>
    .button-form-app
        {
            border: 1px solid #E6641C;
            background: transparent;
            color: #E6641C;
            font-family: Inter;
            padding-right: 40px;
            padding-left: 40px;
        }

        .button-form-app:hover
        {
           background-color:#E6641C;
           border: none;
           color: #FFFFFF;     
        }
        .alert-message
        {
            font-size:12px;
        }
  </style>  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  href="{{asset('images/logo-cumbre.svg')}}" rel="icon">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"> 
    <title>Solictar eliminación de datos</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css?v=2')}}">

</head>
<body>
    <div id="wrapper" class="wrapper">    
        <div class="header-page tm-header-fixed tm-sticky-header">
            <div class="container pt-5 pb-5">
                <a class="tm-header-logo" href="{{route('welcome')}}">
                    <img src="{{asset('images/Logo-completo-cumbre.svg')}}" alt="Logo-Cumbre">
                </a>
            </div>
        </div>
       
    <!----------------DELETE ACCOUNT------------>

            <div class="tm-heroslider-inner">
                <img src="{{asset('images/heroslider-overlay-shape.png')}}" alt="heroslider ovelay" class="tm-heroslider-ovelayshape">
                    <div class="container">
                        <h1 class="text-center text-white">Solicitar eliminación mis datos almacenados dentro de la App</h1>
                        
                        <div class="row mt-5 align-items-center">
                            <div class="col-md-6 text-center">
                                <img src="{{asset('images/app-grande.png')}}" alt="appcumbre mobile" style="max-width:300px;">
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-center">Ingresa datos de inicio de sesión de la App</h4>
                                        <p class="text-center alert-message mb-3">**Los datos seran eliminados 30 días despues de la validación de la solicitud</p>
                                        @if(session('success'))
                                            <script>
                                                alert('{{ session('success') }}');
                                                window.location.href = "{{ url()->current() }}";
                                            </script>
                                        @endif

                                        @if(session('error'))
                                            <script>
                                                alert('{{ session('error') }}');
                                                window.location.href = "{{ url()->current() }}";
                                            </script>
                                        @endif
                                        <form method="post" action="{{route('delete_data')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="title">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">Contraseña</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                            </div>
                                            <button type="submit" class="button-form-app">Enviar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
            </div>

    <!-----//-----------DELETE ACCOUNT------------>

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
    </div>
</body>
</html>