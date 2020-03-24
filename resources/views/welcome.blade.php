<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('images/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('images/favicon-16x16.png') }}">
        <link rel="manifest" href="/site.webmanifest">

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

        <!-- Styles -->
        <style>
            body {
                padding: 0;
                margin: 0;
            }

            html, body, #mapid {
                height: 100%;
                width: 100%;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                color: #636b6f;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            } 

            .links > a {
                color: #fff;
                padding: 0 5px;
                font-size: 16px;
                font-weight: 600;
                /* letter-spacing: .1rem; */
                text-decoration: none;
                text-transform: uppercase;
            }

        </style>
    </head>
    <body>
        

    <div id="mapid">
        @if (Route::has('login'))
            <div class="top-right links" style="position: absolute;z-index: 99999;background: #4267B2;width: 300px;height: 65px;text-align: center;top: 0;right: 0;border-radius: 3px;">
                @auth
                    <a href="{{ url('/home') }}">Minha Conta</a>
                    <hr>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        Sair
                    </a>    
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @else
                    <a style="font-size: 25px;outline: none;text-align: center;top: 8px;left: 12px;position: absolute;" href="{{url('/facebook/redirect')}}" class="btn btn-primary">SEJA UM VOLUNTÁRIO</a>
                    <span style="color: #fff;top: 41px;position: absolute;left: 20px;">Entrar com Facebook</span>
                @endauth
            </div>
        @endif
            <div style="position: absolute;z-index: 99999;background: #4267B2;width: 100%;text-align: center;bottom: 0;right: 0;">
                <p style="color: #fff;padding: 0 25px;font-size: 16px;font-weight: 600;letter-spacing: .1rem;">Busque no mapa um voluntário disponível próximo a sua região.</p>
            </div>
    </div>      

    <script>
        var map = L.map('mapid').setView([-25.4452447,-49.2789062], 12);
        mapLink = '<a href="https://openstreetmap.org">OpenStreetMap</a>';
        
        var planes = <?php echo json_encode($data); ?>

        for (var i = 0; i < planes.length; i++) {
			marker = new L.marker([planes[i]['lat'],planes[i]['long']])
                .bindPopup("<b>"+planes[i]['user']['name']+"</b><br/>"+planes[i]['neighborhood']+" - "+planes[i]['city']+"<br/>"+planes[i]['whatsapp']+"<br>")
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
