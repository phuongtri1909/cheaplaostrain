<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Trang chủ - fociloans')</title>
    <meta name="description" content="@yield('description', '')">
    <meta name="keywords" content="@yield('keywords', '')">
    <meta name="robots" content="index,follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Trang chủ - fociloans')">
    <meta property="og:description" content="@yield('decription', '')">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="fociloans">
    <meta property="og:image" content="{{ asset('assets/images/logo/logo-fociloans.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('assets/images/logo/logo-fociloans.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'Trang chủ - fociloans')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Trang chủ - fociloans')">
    <meta name="twitter:description" content="@yield('decription', '')">
    <meta name="twitter:image" content="{{ asset('assets/images/logo/logo-fociloans.png') }}">
    <meta name="twitter:image:alt" content="@yield('title', 'Trang chủ - fociloans')">
    <link rel="icon" href="{{ asset('assets/images/logo/favicon.ico') }}" type="image/png/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.ico') }}" type="image/x-icon">
    <meta name="google-site-verification" content="RAtNnnVKhi1eNuDSLbuwklnYyOQ0SLvtWWEjlgfFyMY" />

    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('assets/images/logo/logo-fociloans.png')}}"
        }
    </script>

    @stack('meta')

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->

    {{-- styles --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    @stack('styles')

    {{-- end styles --}}
</head>

<body>
    <header id="siteHeader" class="site-header">
        <div class="container-xxl">
            <nav class="navbar navbar-expand-lg py-2">
                <div class="container-fluid px-0">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="logo-site" src="{{ asset('assets/images/logo/logo-fociloans.png') }}"
                            alt="Fociloans" height="20">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link fw-bold font-header fs-4-5"
                                    href="{{ route('tickets.search') }}">Book Ticket</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link fw-bold font-header fs-4-5"
                                    href="{{ route('home') }}">Orders</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link fw-bold font-header fs-4-5"
                                    href="{{ route('faq') }}">{{ __('FAQ') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold font-header fs-4-5"
                                    href="{{ route('blogs') }}">{{ __('News') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold font-header fs-4-5"
                                    href="{{ route('about.us') }}">{{ __('Contact Us') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold font-header fs-4-5"
                                    href="{{ route('about.us') }}">{{ __('About Us') }}</a>
                            </li>


                        </ul>

                        {{-- <div class="d-flex align-items-center">
                            <div class="language-switcher">
                                <div class="language-current" id="languageToggle">
                                    @if (app()->getLocale() == 'en')
                                        <img src="{{ asset('assets/images/flags/en.webp') }}" alt="English"
                                            class="lang-flag" width="18">
                                        <span>EN</span>
                                    @else
                                        <img src="{{ asset('assets/images/flags/vi.webp') }}" alt="Tiếng Việt"
                                            class="lang-flag" width="18">
                                        <span>VI</span>
                                    @endif
                                    <i class="fas fa-chevron-down lang-arrow"></i>
                                </div>
                                <div class="language-dropdown" id="languageDropdown">
                                    <a href="{{ route('language.switch', 'en') }}"
                                        class="language-option {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                        <img src="{{ asset('assets/images/flags/en.webp') }}" alt="English"
                                            class="lang-flag" width="18">
                                        <span>{{ __('English') }}</span>
                                    </a>
                                    <a href="{{ route('language.switch', 'vi') }}"
                                        class="language-option {{ app()->getLocale() == 'vi' ? 'active' : '' }}">
                                        <img src="{{ asset('assets/images/flags/vi.webp') }}" alt="Tiếng Việt"
                                            class="lang-flag" width="18">
                                        <span>{{ __('Vietnamese') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </nav>
        </div>
    </header>
