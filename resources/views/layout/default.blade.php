<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8" />
            <title>@yield('title')</title>

        <!-- Site favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('vendors/images/apple-touch-icon.png')}}"/>
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('vendors/images/favicon-32x32.png')}}"/>
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('vendors/images/favicon-16x16.png')}}"/>

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"
        />

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/core.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/icon-font.min.css')}}"/>
        <link href="{{asset('/plugins/datatables/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables/css/responsive.bootstrap4.min.css')}}"
        />
        <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/style.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('styles/select2-bootstrap4.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('minimal_notification/notifications.css')}}" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="{{asset('styles/custom.css')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
        ></script>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258" crossorigin="anonymous"
        ></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());

            gtag("config", "G-GBZ3SGGX85");
        </script>
        <!-- Google Tag Manager -->
        <script>
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != "dataLayer" ? "&l=" + l : "";
                j.async = true;
                j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
        </script>
        <!-- End Google Tag Manager -->
    </head>

<body>
    <!-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="{{asset('vendors/images/deskapp-logo.svg')}}" alt="" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div> -->
    <header>
        @include('layout.head')
        @include('sidebar.sidebar')
    </header>
    <nav>
        <!-- Navigation content -->
    </nav>
    <main>
        <div class="main-container">
            <div class="xs-pd-20-10 pd-ltr-20">
                
                @yield('content')
                @stack('js_links')
               <div class="footer-wrap pd-20 mb-20 card-box">
                    Jio Soul
                    <a href="#" target="_blank"
                        ></a
                    >
                </div>
            </div>
        </div>
    </main>
    <footer>
        @include('layout.footer')
    </footer>
</body>
</html>