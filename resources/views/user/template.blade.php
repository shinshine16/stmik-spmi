<!DOCTYPE html>
<html lang="zxx">


<head>

    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">

    <!-- Title -->
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link href="{{ asset('') }}img/logo.png" rel="icon" type="image/x-icon" />

    <!-- Fonts -->
    <link href="{{ asset('') }}user/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Mobile Menu -->
    <link href="{{ asset('') }}user/css/mmenu.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}user/css/mmenu.positioning.css" rel="stylesheet" type="text/css" />

    <!-- Accordion Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}user/css/jquery.accordion.css">

    <!-- Stylesheet -->
    <link href="{{ asset('') }}user/style.css" rel="stylesheet" type="text/css" />

    @yield('css')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

</head>

<body>

    <!-- Start: Header Section -->
    <header id="header-v1" class="navbar-wrapper inner-navbar-wrapper">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-default">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="navbar-header">
                                <div class="navbar-brand">
                                    <h1>
                                        <a href="{{ url('') }}">
                                            <img src="{{ url('storage/app/public/config/'. $config->logo) }}"
                                                alt="STMIK - SMPI" />
                                        </a>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- Header Topbar -->
                            <div class="header-topbar hidden-sm hidden-xs">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="topbar-info">
                                            <a href="tel:+61-3-8376-6284"><i class="fa fa-phone"></i>{{ $config->telpon }}</a>
                                            <span>/</span>
                                            <a href="mailto:{{ $config->email }}"><i
                                                    class="fa fa-envelope"></i>{{ $config->email }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="navbar-collapse hidden-sm hidden-xs">
                                <ul class="nav navbar-nav">
                                    
                                    {{-- @foreach ($kategori as $key => $value)
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle disabled"
                                            href="#">{{ $value['menu']['nama_menu'] }}</a>
                                        <ul class="dropdown-menu">
                                            {{-- @foreach ($kategori as $value_k) --}}
                                            {{-- <li>
                                                @if ($value['terbit'] == 'Ya')
                                                @if ($value['type'] == 'document')
                                                <a href="{{ route('user_table',$value['slug']) }}"
                                                    style="background-color:transparent;color: black">{{ $value['nama_kategori'] }}</a>
                                                @else
                                                <a href="{{ route('user_text', $value['slug']) }}"
                                                    style="background-color:transparent;color: black">{{ $value['nama_kategori'] }}</a>
                                                @endif
                                                @endif
                                            </li>
                                            {{-- @endforeach --}}
                                        {{-- </ul>
                                    </li>
                                    @endforeach  --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu hidden-lg hidden-md">
                        <a href="#mobile-menu"><i class="fa fa-navicon"></i></a>
                        <div id="mobile-menu">
                            <ul>
                                <li class="mobile-title">
                                    <h4>Navigation</h4>
                                    <a href="#" class="close"></a>
                                </li>
                                {{-- @foreach ($kategori as $key => $value)
                                <li>
                                    <a href="#">{{ $value['menu']['nama_menu'] }}</a>
                                    <ul>
                                        {{-- @foreach ($kategori as $value_k) --}}
                                        {{-- <li>
                                            @if ($value['terbit'] == 'Ya')
                                            @if ($value['type'] == 'document')
                                            <a href="{{ route('user_table',$value['slug']) }}"
                                                value="{{ $value['enc_id'] }}">{{ $value['nama_kategori'] }}</a>
                                            @else
                                            <a href="{{ route('user_text', $value['slug']) }}"
                                                value="{{ $value['enc_id'] }}">{{ $value['nama_kategori'] }}</a>
                                            @endif
                                            @endif
                                        </li>
                                        {{-- @endforeach --}}
                                    {{-- </ul>
                                </li>
                                @endforeach --}}
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- End: Header Section -->

    <!-- Start: Page Banner -->
    <section class="page-banner services-banner">
        <div class="container">
            <div class="banner-header">
                <h2>{{ $config->nama_aplikasi }}</h2>
                <span class="underline center"></span>
                <p class="lead">{{ $config->deskripsi }}</p>
            </div>
            <div class="breadcrumb">
                <ul>
                    @yield('tag')
                </ul>
            </div>
        </div>
    </section>
    <!-- End: Page Banner -->

    @yield('content')

    @yield('modal')

    <!-- Start: Footer -->
    <footer class="site-footer">
        <div class="container">
            <div id="footer-widgets">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 widget-container">
                        <div id="text-2" class="widget widget_text">
                            <h3 class="footer-widget-title">Tentang {{ $config->nama_aplikasi }}</h3>
                            <span class="underline left"></span>
                            <div class="textwidget">
                               {{ $config->deskripsi }}
                            </div>
                            <address>
                                <div class="info">
                                    <i class="fa fa-location-arrow"></i>
                                    <span>{{ $config->lokasi }}</span>
                                </div>
                                <div class="info">
                                    <i class="fa fa-envelope"></i>
                                    <span><a href="mailto:{{ $config->email }}">{{ $config->email }}</a></span>
                                </div>
                                <div class="info">
                                    <i class="fa fa-phone"></i>
                                    <span><a href="tel:022-7207777">+Telp : +{{ $config->telpon }} </a></span>
                                </div>
                            </address>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 widget-container">
                        <div id="nav_menu-2" class="widget widget_nav_menu">
                            <h3 class="footer-widget-title">Tentang STMIK Bandung</h3>
                            <span class="underline left"></span>
                            <div class="menu-quick-links-container">
                                <ul id="menu-quick-links" class="menu">
                                    <li><a target="_blank" href="https://stmik-bandung.ac.id/profil">Sejarah</a></li>
                                    <li><a target="_blank" href="https://stmik-bandung.ac.id/visimisi">Visi Misi &
                                            Tujuan</a></li>
                                    <li><a target="_blank" href="https://stmik-bandung.ac.id/pimpinan">Pimpinan</a></li>
                                    <li><a target="_blank"
                                            href="https://stmik-bandung.ac.id/struktur-organisasi">Struktur
                                            Organisasi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-lg hidden-md hidden-xs tablet-margin-bottom"></div>
                    <div class="col-lg-3 col-md-3 col-sm-6 widget-container">
                        <div id="text-4" class="widget widget_text">
                            <h3 class="footer-widget-title">Strategic Partnership</h3>
                            <span class="underline left"></span>
                            <div class="menu-quick-links-container">
                                <ul id="menu-quick-links" class="menu">
                                    <li><a href="#">PT. Solmit Academy</a></li>
                                    <li><a href="#">Casugol</a></li>
                                    <li><a href="#">Center for Artificial Intelligence ITB</a></li>
                                    <li><a href="#">DycodeX</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 widget-container">
                        <div class="widget twitter-widget">
                            <h3 class="footer-widget-title">Temukan Kami</h3>
                            <span class="underline left"></span>
                            <div class="menu-quick-links-container">
                                <ul class="menu-quick-links">
                                    <li style=" color: #f8bb36; font-size: 16px; font-weight 600;"><a target="_blank"
                                            href="{{ $config->facebook }}"><i class="fa fa-facebook-square">
                                            </i> @BandungSTMIK </a></li>
                                    <li style=" color: #f8bb36; font-size: 16px; font-weight 600;"><a
                                            href="{{ $config->whatsapp }}"
                                            target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i>
                                            Whatsapp</a></li>
                                    <li style=" color: #f8bb36; font-size: 16px; font-weight 600;"><a target="_blank"
                                            href="{{ $config->instagram }}"><i class="fa fa-instagram"
                                                aria-hidden="true"></i> @stmikbandung</a></li>
                                    <li style=" color: #f8bb36; font-size: 16px; font-weight 600;"><a target="_blank"
                                            href="{{ $config->youtube }}"><i class="fa fa-youtube-play" aria-hidden="true"></i> STMIK
                                            BANDUNG</a></li>
                                    <li style=" color: #f8bb36; font-size: 16px; font-weight 600;"><a target="_blank"
                                            href="{{ $config->linkedin }}"><i
                                                class="fa fa-linkedin-square" aria-hidden="true"></i> STMIK BANDUNG</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="footer-text col-md-12 text-center">
                        <p><a target="_blank" style="color:#003679;">STMIK Bandung &copy; {{ date('Y') }} All rights
                                reserved</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End: Footer -->

    <!-- jQuery Latest Version 1.x -->
    <script type="text/javascript" src="{{ asset('') }}user/js/jquery-1.12.4.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <!-- jQuery UI -->
    <script type="text/javascript" src="{{ asset('') }}user/js/jquery-ui.min.js"></script>

    <!-- jQuery Easing -->
    <script type="text/javascript" src="{{ asset('') }}user/js/jquery.easing.1.3.js"></script>

    <!-- Bootstrap -->
    <script type="text/javascript" src="{{ asset('') }}user/js/bootstrap.min.js"></script>

    <!-- Mobile Menu -->
    <script type="text/javascript" src="{{ asset('') }}user/js/mmenu.min.js"></script>

    <!-- Harvey - State manager for media queries -->
    <script type="text/javascript" src="{{ asset('') }}user/js/harvey.min.js"></script>

    <!-- Waypoints - Load Elements on View -->
    <script type="text/javascript" src="{{ asset('') }}user/js/waypoints.min.js"></script>

    <!-- Facts Counter -->
    <script type="text/javascript" src="{{ asset('') }}user/js/facts.counter.min.js"></script>

    <!-- MixItUp - Category Filter -->
    <script type="text/javascript" src="{{ asset('') }}user/js/mixitup.min.js"></script>

    <!-- Owl Carousel -->
    <script type="text/javascript" src="{{ asset('') }}user/js/owl.carousel.min.js"></script>

    <!-- Accordion -->
    <script type="text/javascript" src="{{ asset('') }}user/js/accordion.min.js"></script>

    <!-- Responsive Tabs -->
    <script type="text/javascript" src="{{ asset('') }}user/js/responsive.tabs.min.js"></script>

    <!-- Responsive Table -->
    <script type="text/javascript" src="{{ asset('') }}user/js/responsive.table.min.js"></script>

    <!-- Masonry -->
    <script type="text/javascript" src="{{ asset('') }}user/js/masonry.min.js"></script>

    <!-- Carousel Swipe -->
    <script type="text/javascript" src="{{ asset('') }}user/js/carousel.swipe.min.js"></script>

    <!-- bxSlider -->
    <script type="text/javascript" src="{{ asset('') }}user/js/bxslider.min.js"></script>

    <!-- Custom Scripts -->
    <script type="text/javascript" src="{{ asset('') }}user/js/main.js"></script>

    @yield('script')

</body>


</html>
