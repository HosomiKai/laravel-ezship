
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="laravel台灣便利配demo">
    <meta name="author" content="hosomikai">
    <link rel="icon" href="https://www.ezship.com.tw/favicon.ico">

    <title>台灣便利配demo - @yield('title')</title>

    <link rel="canonical" href="{{ url('/') }}">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  </head>

  <body class="bg-light">

    @yield('content')

    <div class="container">
      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2021-now hosomikai</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="https://github.com/hosomikai">github</a></li>
        </ul>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    @stack('scripts')
  </body>
</html>
