<?php
session_start();
require_once("biblioteca/user.php");

/*$user_id = $_SESSION['user_session'];

if(is_loggedin()!="")
{
    //redirect('../index.php');
}*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Theme Made By www.w3schools.com - No Copyright -->
    <title>IFoundIt! how about you?</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./static/style.css">
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#myPage">Logo</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (is_loggedin()!="") {
                        echo '<li><a href="biblioteca/profile.php?logout=true"><span class="glyphicon glyphicon-user"></span>&nbsp;MI CUENTA</a></li>';
                        echo '<li><a href="biblioteca/logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;CERRAR SESION</a></li>';
                    } elseif (is_loggedin() == "") {
                        echo '<li><a href="biblioteca/login.php"><span class="glyphicon glyphicon-log-in"></span>&nbsp;INICIAR SESION</a></li>';
                        echo '<li><a href="biblioteca/sign-up.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;REGISTRARSE</a></li>';
                    }

                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>I Found It</h1>
    <p>Anuncios Clasificados</p>
    <form>
        <div class="input-group">
            <input type="text" class="form-control" size="50" placeholder="Tel&eacute;fonos, Autos, Departamentos, etc..." required>
            <div class="input-group-btn">
                <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Buscar</button>
            </div>            
            <div class="input-group-btn">
                <a href="biblioteca/crearAnuncio.php"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Crear Anuncio</button></a>
            </div>
        </div>
    </form>
</div>

<!-- Container (Services Section) -->
<div id="categorias" class="container-fluid text-center">
    <h2>CATEGORIAS</h2>
    <h4>¿Aun no sabe que buscar? Pruebe ver por categorias</h4>
    <br>
    <div class="row slideanim">
        <div class="col-sm-4">
            <span class="glyphicon glyphicon-off logo-small"></span>
            <h4>Electronicos</h4>
            <p>Lorem ipsum dolor sit amet..</p>
        </div>
        <div class="col-sm-4">
            <span class="glyphicon glyphicon-heart logo-small"></span>
            <h4>Cuidado</h4>
            <p>Lorem ipsum dolor sit amet..</p>
        </div>
        <div class="col-sm-4">
            <span class="glyphicon glyphicon-lock logo-small"></span>
            <h4>Trabajos</h4>
            <p>Lorem ipsum dolor sit amet..</p>
        </div>
    </div>
    <br><br>
    <div class="row slideanim">
        <div class="col-sm-4">,
            <span class="glyphicon glyphicon-leaf logo-small"></span>
            <h4>Bio</h4>
            <p>Lorem ipsum dolor sit amet..</p>
        </div>
        <div class="col-sm-4">
            <span class="glyphicon glyphicon-certificate logo-small"></span>
            <h4>Ofertas del momento</h4>
            <p>Lorem ipsum dolor sit amet..</p>
        </div>
        <div class="col-sm-4">
            <span class="glyphicon glyphicon-wrench logo-small"></span>
            <h4 style="color:#303030;">Herramientas</h4>
            <p>Lorem ipsum dolor sit amet..</p>
        </div>
    </div>
</div>

<!-- Container (Trending Section) -->
<div id="trending" class="container-fluid bg-grey">
    <h2 class="text-center">Trends</h2>
    <div class="row">
        <div class="col-sm-4 anuncio_trend">
            <img class="trend_img" src="https://s1.thcdn.com/productimg/600/600/11447563-1594485373406643.jpg" alt="trend#1"
                 style="width:128px;height:128px;">
        </div>
        <div class="col-sm-4 anuncio_trend">
            <img class="trend_img" src="http://cdn.iphonehacks.com/wp-content/uploads/2016/09/iphone-7-unboxing-22.jpg" alt="trend#2"
                 style="width:128px;height:128px;">
        </div>
        <div class="col-sm-4 anuncio_trend">
            <img class="trend_img" src="https://www1-lw.xda-cdn.com/files/2017/10/Google-Pixel-Buds-are-Assistant-Enabled-Earbuds-that-Cost-149.png" alt="trend#3"
                 style="width:128px;height:128px;">
        </div>
    </div>
</div>

<!-- Container (Pricing Section) -->
<div id="pricing" class="container-fluid">
    <div class="text-center">
        <h2>Pricing</h2>
        <h4>Choose a payment plan that works for you</h4>
    </div>
    <div class="row slideanim">
        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h1>Basic</h1>
                </div>
                <div class="panel-body">
                    <p><strong>20</strong> Lorem</p>
                    <p><strong>15</strong> Ipsum</p>
                    <p><strong>5</strong> Dolor</p>
                    <p><strong>2</strong> Sit</p>
                    <p><strong>Endless</strong> Amet</p>
                </div>
                <div class="panel-footer">
                    <h3>$19</h3>
                    <h4>per month</h4>
                    <button class="btn btn-lg">Sign Up</button>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h1>Pro</h1>
                </div>
                <div class="panel-body">
                    <p><strong>50</strong> Lorem</p>
                    <p><strong>25</strong> Ipsum</p>
                    <p><strong>10</strong> Dolor</p>
                    <p><strong>5</strong> Sit</p>
                    <p><strong>Endless</strong> Amet</p>
                </div>
                <div class="panel-footer">
                    <h3>$29</h3>
                    <h4>per month</h4>
                    <button class="btn btn-lg">Sign Up</button>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h1>Premium</h1>
                </div>
                <div class="panel-body">
                    <p><strong>100</strong> Lorem</p>
                    <p><strong>50</strong> Ipsum</p>
                    <p><strong>25</strong> Dolor</p>
                    <p><strong>10</strong> Sit</p>
                    <p><strong>Endless</strong> Amet</p>
                </div>
                <div class="panel-footer">
                    <h3>$49</h3>
                    <h4>per month</h4>
                    <button class="btn btn-lg">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Container (Contact Section) -->
<div id="contact" class="container-fluid bg-grey">
    <h2 class="text-center">CONTACT</h2>
    <div class="row">
        <div class="col-sm-5">
            <p>Contact us and we'll get back to you within 24 hours.</p>
            <p><span class="glyphicon glyphicon-map-marker"></span> Chicago, US</p>
            <p><span class="glyphicon glyphicon-phone"></span> +00 1515151515</p>
            <p><span class="glyphicon glyphicon-envelope"></span> myemail@something.com</p>
        </div>
        <div class="col-sm-7 slideanim">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                </div>
                <div class="col-sm-6 form-group">
                    <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
                </div>
            </div>
            <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <button class="btn btn-default pull-right" type="submit">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <a href="#myPage" title="To Top">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
</footer>

<script>
    $(document).ready(function(){
        // Add smooth scrolling to all links in navbar + footer link
        $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 900, function(){

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });

        $(window).scroll(function() {
            $(".slideanim").each(function(){
                var pos = $(this).offset().top;

                var winTop = $(window).scrollTop();
                if (pos < winTop + 600) {
                    $(this).addClass("slide");
                }
            });
        });
    })
</script>

</body>
</html>

