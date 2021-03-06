<?php
header("Pragma:no-cache");
?>
<!DOCTYPE html>
<html class="no-js" lang="fr">

<head>
  <title>Dvd back - <?= $title ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="favicon.ico" />
  <link rel="apple-touch-icon" href="favicon.ico">

  <!--link rel="stylesheet" href="./src/public/css/night.css"-->
  <link rel="stylesheet" href="./src/public/css/main.css">
  <link rel="stylesheet" href="./src/public/css/mystyles.css">

  <link rel="stylesheet" href="./src/public/script/datatables/1.10.16/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="./src/public/bulma-0.8.0/dataTables.bulma.min.css" />
  <link rel="stylesheet" href="./src/public/bulma-0.8.0/bulma-calendar/css/bulma-calendar.min.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>

  <section class="hero is-fullheight">
    <div class="pageloader is-active"><span class="title">Tu me vois... tu ne me verras plus.</span></div>
    <div class="hero-head" style="z-index:1">
      <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item" href=".">
            <img src="./src/public/img/logo.png" width="112" height="28">
          </a>

          <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
          <div class="navbar-start">
            <a class="navbar-item" href="./index.php?page=users">
              Utilisateur
            </a>

            <a class="navbar-item" href="./index.php?page=movies">
              Films
            </a>


            <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link">
                Gestion clients
              </a>

              <div class="navbar-dropdown">
                <a class="navbar-item" href="./index.php?page=cltfiche">
                  Fiche Client
                </a>
                <a class="navbar-divider">
                </a>
                <a class="navbar-item" href="./index.php?page=cltprepa">
                  Préparation envoi
                </a>
                <a class="navbar-item" href="./index.php?page=cltreception">
                  Réception Dvd
                </a>
                <hr class="navbar-divider">
                <a class="navbar-item" href="./index.php?page=cltrelance">
                  Relance client
                </a>
              </div>
            </div>
          </div>

          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a id="btnDeconnect" class="button is-primary">
                  <strong>Déconnecter</strong>
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>

    </div>
    <div class="hero-body ">
      <div class="container">
        <?= $content ?>
      </div>
    </div>
  </section>


  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <script src="./src/public/script/modernizr/modernizr-3.7.1.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="./src/public/script/jquery/jquery-3.4.1.min.js"><\/script>')
  </script>
  <script src="./src/public/script/deconnect.js"></script>
  <script src="./src/public/script/plugins.js"></script>
  <script src="./src/public/script/datatables/1.10.16/jquery.dataTables.min.js"></script>
  <script src="./src/public/bulma-0.8.0/dataTables.bulma.min.js"></script>
  <script src="./src/public/bulma-0.8.0/bulma-calendar/js/bulma-calendar.min.js"></script>
  <script src="./src/public/script/lodash.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <?= $js ?>
  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function() {
      ga.q.push(arguments)
    };
    ga.q = [];
    ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('set', 'transport', 'beacon');
    ga('send', 'pageview');

    document.addEventListener('DOMContentLoaded', () => {


      // Get all "navbar-burger" elements
      const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

      // Check if there are any navbar burgers
      if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(el => {
          el.addEventListener('click', () => {

            // Get the target from the "data-target" attribute
            const target = el.dataset.target;
            const $target = document.getElementById(target);

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');

          });
        });

      }
      
    });

    $(document).ready(function() {

      $('body').on('click', '#is-the-one', function() {
        $('.modal').addClass('is-active');
        $('html').addClass('is-clipped');
      });
      $('body').on('click', '.modal-background', function() {
        $(this).parent().removeClass('is-active');
        $('html').removeClass('is-clipped');
      });
      $('body').on('click', '.modal-close', function() {
        $(this).parent().removeClass('is-active');
        $('html').removeClass('is-clipped');
      })


    });

    var $loading = $('.pageloader');
    $loading.removeClass('is-active');
    $(document)
      .ajaxStart(function() {
        console.log('charge');
        $loading.addClass('is-active');
      })
      .ajaxStop(function() {
        console.log('fin');
        $loading.removeClass('is-active');
      });
  </script>

</body>

</html>