<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('images/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('images/favicon-16x16.png') }}">

        <!-- Primary Meta Tags -->
        <title>Deixa Que Eu Busco | Juntos Somos Mais Fortes</title>
        <meta name="title" content="Deixa Que Eu Busco | Juntos Somos Mais Fortes">
        <meta name="description" content="Cadastre-se e fique a disposição de pessoas próximas que estão no grupo de risco do Covid-19. Um simples gesto pode fazer toda diferença.">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://deixaqueeubusco.com.br/">
        <meta property="og:title" content="Deixa Que Eu Busco | Juntos Somos Mais Fortes">
        <meta property="og:description" content="Cadastre-se e fique a disposição de pessoas próximas que estão no grupo de risco do Covid-19. Um simples gesto pode fazer toda diferença.">
        <meta property="og:image" content="{{ secure_asset('images/logo.png') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="https://deixaqueeubusco.com.br/">
        <meta property="twitter:title" content="Deixa Que Eu Busco | Juntos Somos Mais Fortes">
        <meta property="twitter:description" content="Cadastre-se e fique a disposição de pessoas próximas que estão no grupo de risco do Covid-19. Um simples gesto pode fazer toda diferença.">
        <meta property="twitter:image" content="{{ secure_asset('images/logo.png') }}">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Styles -->
        <style>

            body {
                padding: 0;
                margin: 0;
            }

            html, body, #mapid {
                width: 100%;
                height:100vh;
            }

            header{
                position: absolute;
                width: 100%;
                top: 0;
                z-index: 999;
                background: #ffffffe0;
                padding: 0;
            }

            footer{
                /* position: absolute; */
                width: 100%;
                bottom: 0;
                z-index: 999;
                background: #ffffffa6;
                padding: 8px;
            }

            .nav-link {
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                font-size: 12px;
                text-transform: uppercase;
                font-weight: bold;
                color: #EF3D4F;
                padding: 1px 0 !important;
            }

            .auth a {
                text-align: center;
            }

        </style>
    </head>

    <body>

        <div class="cover-container">
            <header class="masthead mb-auto">
                <div class="inner">
                    <nav class="nav nav-masthead justify-content-center">
                    <div class="col-sm-12 col-md-3">
                        <a class="nav-link" href="/"><img src="{{ secure_asset('images/logo-2.png') }}" width="150" style="margin: 0 auto;display: table;" alt="Deixa Que Eu Busco"></a>
                    </div>
                    <div class="auth col-sm-12 col-md-2 offset-md-7">
                        <a class="nav-link" href="/sobre">Sobre</a>
                        @if (Route::has('login'))
                            @auth
                                <a class="nav-link" href="{{ url('/home') }}">Minha Conta</a>
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Sair</a>    
                                <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                </form>
                            @else
                                <a class="nav-link" href="{{url('/facebook/redirect')}}" class="btn btn-primary">Seja um Voluntário ❤️</a>
                            @endauth
                        @endif
                        </div>
                    </nav>
                </div>
            </header>

            <div id="mapid"></div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        var map = L.map('mapid').setView([-21.0445319,-48.6034182], 5);
        mapLink = '<a href="https://openstreetmap.org">OpenStreetMap</a>';
        
        var planes = <?php echo json_encode($data); ?>

        for (var i = 0; i < planes.length; i++) {
			marker = new L.marker([planes[i]['lat'],planes[i]['long']])
                .bindPopup("<b>"+planes[i]['user']['name']+"</b><br/>"+planes[i]['neighborhood']+" - "+planes[i]['city']+"<br/><a href='tel:"+planes[i]['whatsapp'].replace(/[^\d]/g, '')+"'>"+planes[i]['whatsapp']+"</a><br/><a href='https://wa.me/55"+planes[i]['whatsapp'].replace(/[^\d]/g, '')+"?text=Olá,%20te%20encontrei%20no%20Deixa%20Que%20Eu%20Busco,%20você%20poderia me ajudar?'><i class='fa fa-whatsapp' style='font-size: 20px;color: green;'></i> Chamar no WhatsApp</a><br>")
				.addTo(map);
		}

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; ' + mapLink + ' Contributors',
                maxZoom: 18,
            }).addTo(map);
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-161551353-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-161551353-1');
    </script>

    </body>
</html>
