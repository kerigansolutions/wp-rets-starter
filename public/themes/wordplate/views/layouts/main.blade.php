<!DOCTYPE html>
<html {{ language_attributes() }}>
<head>
  <meta charset="{{ bloginfo('charset') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme-color" content="#6d9aea">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,800" rel="stylesheet">
  {{ wp_head() }}
</head>
<body {{ body_class() }}>
    <div id="app">
        <div 
            class="site-wrapper" 
            v-bind:class="{
                'full-height': footerStuck, 
                'scrolling': isScrolling,
                'mobile-menu-open': mobileMenuOpen 
            }">
            @include('partials.header')

            @yield('content')

            @include('partials.footer')
        </div>
        <portal-target name="modal"></portal-target>
    </div>

    {{ wp_footer() }}
    @yield('footer-scripts')
</body>
</html>