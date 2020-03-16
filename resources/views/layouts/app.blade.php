<!doctype html>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Page analyzer</title>
  </head>
<body>
<div id="navbar">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('index') }}">
        <img src="../icons/lamp_icon.png" width="30" height="30" class="d-inline-block align-top" alt="">
        SEO TEST
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
              <li class="nav-item {{ getCurrentPath() === null ? 'active' : '' }} ">
                  <a class="nav-link" href="{{ route('index') }}" name="index"">Home</a>
              </li>
              <li class="nav-item {{ substr(getCurrentPath(), 0, 8) === '/domains' ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('domains.index') }}">Analyzed URLs</a>
              </li>
              <li class="nav-item {{ getCurrentPath() === '/about' ? 'active' : '' }}">
                  <a class="nav-link" href="{{  route('about')  }}">About</a>
              </li>
          </ul>
        </div>
      </nav>
</div>
{{-- <script>
$(document).ready(function() {
    $('a[href$="' + location.pathname + '"]').addClass('active');
    if (location.pathname == "/") {
         $('a[name*="index"]').addClass('active');
    }
});
</script> --}}
@yield('content')

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
