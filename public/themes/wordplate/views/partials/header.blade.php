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
                    <a class="logo d-flex mx-auto align-items-center text-primary" href="/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 97.51 63.2" fill="currentColor" class="d-block mr-2 text-secondary"><path d="M47,35.75h5.64v5.73H46.88V35.75Zm14.5,0v5.73H55.74V35.75h5.73Zm-9.86-8.86h1v6H46.84l.06-.31h-.06l0-.19V26.89Zm9.83,5.73h.06l0-.19V26.89H55.74v6H61.5ZM0,33.41v7.14H23.72l1.05-1L54.17,10.1,80.94,36.88V63.2h7.15V44l4.37,4.37,5.05-5-16-16V13.11h2.83V6H71.57v7.15H74.4v7.12L56.7,2.53,54.17,0,28.07,7.54Z"/></svg>
                        {{ get_bloginfo() }}
                    </a>
                @endif
            </div>
            
            <div class="flex-grow-1">
                <div class="contact-nav py-2">
                    <a class="mail top-button" href="mailto:{{ get_field('email', 'option') }}"><i class="fa fa-envelope d-inline-block mx-2" aria-hidden="true"></i><span class="d-none d-md-inline-block text-primary">{{ get_field('email', 'option') }}</span></a>
                    <a class="call top-button" href="tel:{{ get_field('phone', 'option') }}"><i class="fa fa-phone d-inline-block mx-2" aria-hidden="true"></i><span class="d-none d-md-inline-block text-primary">{{ get_field('phone', 'option') }}</span></a>
                    <button v-on:click="toggleMenu" class="d-xl-none btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#mobilemenu" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                        MENU <i
                                class="fa" 
                                v-bind:class="{
                                    'fa-bars': !mobileMenuOpen,
                                    'fa-times': mobileMenuOpen
                                }"
                                aria-hidden="true"
                            ></i>
                    </button>
                </div>
                
                <div class="main-navigation collapse navbar-collapse">
                    <main-menu v-bind:main-nav="{{ website_menu('main-navigation') }}" class="navbar-nav ml-auto"></main-menu>
                </div>
            </div>
        </div>
    </div>
</header>
<div v-if="mobileMenuOpen" class="mobile-menu align-items-center" ref="mobileMenuContainer" v-bind:class="{ 'open': this.mobileMenuOpen }" >
    <mobile-menu v-bind:mobile-nav="{{ website_menu('mobile-navigation') }}" class="navbar-nav m-auto" ></mobile-menu>
</div>