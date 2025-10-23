<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'HuAviar')</title>
    <link rel="icon" type="image/png" href="{{ asset('imagenes/logo2.png')}}" sizes="32x32">
    <style>
        html, body {
                    height: 100%;          /* ocupar toda la pantalla */
                    margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f7f7f7;
            color: #333;
            display: flex;
            flex-direction: column; /* apilar header, contenido, footer */
            min-height: 100vh;   
        }
        header {
            background: #ef8504;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            flex: 1; /* empuja el footer hacia abajo */
        }
        h2 {
            color: #ef8504;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }
        input:focus {
            border-color: #ef8504;
        }
        .btn {
            width: 100%;
            background: #ef8504;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #a75407;
        }
        .extra-links {
            text-align: center;
            margin-top: 15px;
        }
        .extra-links a {
            color: #ef8504;
            text-decoration: none;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<header>
    <h1>@yield('h1','HuAviar')</h1>
</header>

<div class="container">
    <h2>@yield('h2')</h2>

    @yield('contenido')
</div>

<footer>
  <p>
    © {{ date('Y') }} HuAviar |  
    <a 
      href="https://wa.me/message/ACPCFECPVJO5C1" 
      target="_blank" 
      style="color:#25D366; text-decoration:none; font-weight:bold;"
    >
      ¡Contáctanos!
    </a>
  </p>
</footer>

</body>
</html>