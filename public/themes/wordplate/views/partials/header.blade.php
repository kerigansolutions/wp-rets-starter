<header class="top">
    <div role="navigation" class="topnav navbar navbar-expand-xl" >
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="text-center" >
                @if(get_theme_mod( 'custom_logo' ))
                    <a class="logo d-flex mx-auto" href="/">
                        <img 
                            src="{{ esc_url( 
                                wp_get_attachment_image_url(
                                    get_theme_mod( 'custom_logo' ), 
                                    'full' 
                                ) ) }}" 
                            alt=""
                            class="img-fluid"
                        >
                    </a>
                @else
                    <a class="logo d-flex mx-auto" href="/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mr-2"><circle cx="12" cy="12" r="10"></circle><line x1="14.31" y1="8" x2="20.05" y2="17.94"></line><line x1="9.69" y1="8" x2="21.17" y2="8"></line><line x1="7.38" y1="12" x2="13.12" y2="2.06"></line><line x1="9.69" y1="16" x2="3.95" y2="6.06"></line><line x1="14.31" y1="16" x2="2.83" y2="16"></line><line x1="16.62" y1="12" x2="10.88" y2="21.94"></line></svg>
                        REAL ESTATE AGENT
                    </a>
                @endif
            </div>
            
            <div class="flex-grow-1">
                <div class="contact-nav py-2">
                    <a class="mail top-button" href="mailto:{{ get_field('email', 'option') }}"><i class="fa fa-envelope d-inline-block mx-2" aria-hidden="true"></i><span class="d-none d-md-inline-block">{{ get_field('email', 'option') }}</span></a>
                    <a class="call top-button" href="tel:{{ get_field('phone', 'option') }}"><i class="fa fa-phone d-inline-block mx-2" aria-hidden="true"></i><span class="d-none d-md-inline-block">{{ get_field('phone', 'option') }}</span></a>
                    <button v-on:click="toggleMenu" class="d-xl-none btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#mobilemenu" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                        MENU <i
                                class="fa" 
                                :class="{
                                    'fa-bars': !mobileMenuOpen,
                                    'fa-times': mobileMenuOpen
                                }"
                                aria-hidden="true"
                            ></i>
                    </button>
                </div>
                
                <div class="main-navigation collapse navbar-collapse">
                    <main-menu :main-nav="{{ website_menu('main-navigation') }}" class="navbar-nav ml-auto"></main-menu>
                </div>
            </div>
        </div>
    </div>
</header>
<div v-if="mobileMenuOpen" class="mobile-menu" ref="mobileMenuContainer" :class="{ 'open': this.mobileMenuOpen }" >
    <mobile-menu :mobile-nav="{{ website_menu('mobile-navigation') }}" class="navbar-nav m-auto" ></mobile-menu>
</div>