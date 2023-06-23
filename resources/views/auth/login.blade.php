<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Humble's|Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />
  <!-- <link rel="stylesheet" href="css/login.css" /> -->
</head>

<style>
  :root{
    background-image: url("{{ asset('css/bgLogin.png') }}");
    background-repeat: no-repeat;
    background-size: cover ;
    background-attachment: fixed;
    position: relative;
    width: 100%;
    height: 100% ;
  }
  
  .main-bg {
    background: var(--main-bg) !important;
  }
  
  input:focus, button:focus {
    border: 1px solid var(--main-bg) !important;
    box-shadow: none !important;
  }
  
  .form-check-input:checked {
    background-color: var(--main-bg) !important;
    border-color: var(--main-bg) !important;
  }
  
  .card, .btn, input{
    border-radius:0 !important;
  }

  .login{
        /* Sign In */
    /* Auto layout */
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 20px 35px;
    gap: 30px;
    position: absolute;
    width: 574px;
    height: 604px;
    left: 750px;
    top: 150px;

    background: #FFFFFF;
    box-shadow: 0px 6px 6px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
  }
  .logo{
    background-image: url("{{ asset('css/logo.png') }}");
    position: absolute;
    width: 579px;
    height: 131px;
    left: 83px;
    top: 401px;

  }
  .form{
    
        width: 400px; /* Atur lebar form */
        height: 200px; /* Atur tinggi form */
  }

  .underline-text {
    text-decoration: underline;
    text-decoration-color: blue; /* mengatur warna garis bawah */
    text-decoration-style: dotted; /* mengatur gaya garis bawah */
    color: blue;
  }
  
</style>

<body class="main-bg" >
    <div class="logo">
    <img src="logo.png" class="rounded float-start" alt="">
    </div>
  <!-- Login Form -->
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="login">
        <x-auth-session-status class="mb-4" :status="session('status')" />   
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">Login</h2>
          </div>
          <form class="form" method="post" action="{{ route('login')}}">
            @csrf
            <div class="mb-4">
              <x-input-label for="email" class="form-label" :value="__('Email')">
                Username/Email
              </x-input-label>
              <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mb-4">
              <x-input-label for="password" class="form-label" :value="__('Password')">
                Password
              </x-input-label>
              <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" />
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="mb-4">
              <input type="checkbox" class="" id="remember_me" />
              <label for="remember_me" class="form-label">Remember Me</label>
            </div>
            <div class="d-grid">
              <button type="submit" class="p-3 mb-2 bg-primary text-white">Login</button>
            </div>
            @if (Route::has('password.request'))
              <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" 
                href="{{ route('password.request') }}">
                {{__('Forgot your password?') }}
              </a>
            @endif
            <a href="{{ route('register') }}"><p class="underline-text">Belum punya akun?, daftar disini</p></a>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
