<?php /* Branded Login page for KMA */

function expand_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/kma-logo.svg);
            height:65px;
            width:320px;
            background-size: 320px 65px;
            background-repeat: no-repeat;
        	padding-bottom: 30px;
            width: auto;
        }

        body.login {
            background-color: #111;
        }

        body.login form {
            margin-top: 20px;
            margin-left: 0;
            padding: 26px 24px 46px;
            font-weight: 400;
            overflow: hidden;
            background: #333;
            box-shadow: 0 1px 3px rgba(0,0,0,0.13);
        }

        body.login #nav a:hover, 
        body.login #backtoblog a:hover, 
        body.login h1 a:hover {
            color: #b4be35;
        }

        body.wp-core-ui .button-primary, 
        body.wp-core-ui .button-primary:hover, 
        body.wp-core-ui .button-primary, 
        body.wp-core-ui .button-primary:focus {
            background: #b4be35;
            border: none;
            color: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,.3);
            text-shadow: 0 0 5px rgba(0,0,0,.3);
        }

        body.login form .input, 
        body.login input[type="text"], 
        body.login form input[type="checkbox"] {
            background: #999;
            border: #222;
        }

        body.wp-core-ui form input[type="checkbox"]:checked:before {
            color: #b4be35;
        }
    </style>
<?php
}
add_action('login_enqueue_scripts', 'expand_login_logo');