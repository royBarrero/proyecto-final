<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @guest
            @yield('titulo', 'HuAviar')
        @else
            @yield('titulo', 'Bienvenido')
        @endguest
    </title>
    <link rel="icon" type="image/png" href="{{ asset('imagenes/logo2.png') }}" sizes="32x32">
    <style>
    /* ====== ESTILO BASE ====== */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #f7f7f7;
        color: #333;
    }

    header {
        background: #ef8504;
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        text-align: center;
    }

    header h1 {
        margin: 0;
        font-size: 1.8em;
        flex: 1;
    }

    .header-buttons,
    nav {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .header-buttons a,
    .header-buttons button,
    nav a,
    nav button {
        color: #ef8504;
        background: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: background 0.3s, color 0.3s;
    }

    .header-buttons a:hover,
    .header-buttons button:hover,
    nav a:hover,
    nav button:hover {
        background: #a75407;
        color: white;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 30px auto;
    }

    footer {
        background: #333;
        color: white;
        text-align: center;
        padding: 20px 0;
        margin-top: 50px;
        font-size: 0.9em;
    }

    footer a {
        color: #ef8504;
        text-decoration: none;
        font-weight: bold;
    }

    footer a:hover {
        text-decoration: underline;
    }

    /* ====== TARJETAS Y GRID ====== */
    .bird-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .bird-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .bird-card:hover {
        transform: scale(1.05);
    }

    .bird-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .bird-card .info {
        padding: 15px;
    }

    /* ====== FORMULARIOS ====== */
    .form-box {
        width: 90%;
        max-width: 400px;
        margin: 40px auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #ef8504;
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        box-sizing: border-box;
    }

    input:focus,
    textarea:focus {
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

    /* ====== TABLAS ====== */
    .styled-table {
        border-collapse: collapse;
        font-size: 0.95em;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px #f76104ed;
    }

    .styled-table thead {
        background-color: #ef8504;
        color: #fff;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        word-wrap: break-word;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:hover {
        background-color: #ffe6c2;
    }

    /* ====== BOTONES ====== */
    .div-botones,
    .div-botones2 {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-eliminar {
        color: red;
        background: #f9f9f9;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-eliminar:hover {
        background: red;
        color: white;
    }

    .btn-editar {
        color: blue;
        background: #f9f9f9;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-editar:hover {
        background: blue;
        color: white;
    }

    /* ====== RESPONSIVIDAD ====== */

    /* 1️⃣ Header adaptable */
    @media (max-width: 768px) {
        header {
            flex-direction: column;
            text-align: center;
        }

        header h1 {
            font-size: 1.5em;
        }

        nav {
            justify-content: center;
            width: 100%;
        }
    }

    /* 2️⃣ Tabla -> Cards en móvil */
    @media (max-width: 768px) {
        .styled-table thead {
            display: none;
        }

        .styled-table,
        .styled-table tbody,
        .styled-table tr,
        .styled-table td {
            display: block;
            width: 100%;
        }

        .styled-table tr {
            margin-bottom: 15px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
        }

        .styled-table td {
            text-align: right;
            padding: 10px;
            position: relative;
        }

        .styled-table td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            width: 50%;
            text-align: left;
            font-weight: bold;
            color: #555;
        }
    }

    /* 3️⃣ Footer adaptable */
    @media (max-width: 480px) {
        footer {
            font-size: 0.8em;
            padding: 15px;
        }
    }

    /* ====== ANIMACIONES ====== */
    @keyframes slideInNew {
        from {
            opacity: 0;
            transform: translateY(20px);
            background-color: #e3ffe3;
        }

        to {
            opacity: 1;
            transform: translateY(0);
            background-color: white;
        }
    }

    .new-item {
        animation: slideInNew 1s ease forwards;
    }

    .fade-out {
        opacity: 0;
        transform: translateX(-10px);
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    .highlight {
        animation: highlightEffect 1.5s ease;
    }

    @keyframes highlightEffect {
        0% {
            background-color: #fffbb1;
        }

        100% {
            background-color: white;
        }
    }
</style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Solo formularios que tengan un botón .btn-eliminar
            document.querySelectorAll('form').forEach(form => {
                const btnEliminar = form.querySelector('.btn-eliminar');
                if (!btnEliminar) return; // ignorar formularios sin botón de eliminar

                form.addEventListener('submit', e => {
                    const fila = form.closest('tr');
                    const card = form.closest('.card-categoria');

                    // Confirmación antes de eliminar
                    if (confirm('¿Seguro que lo quieres eliminar?')) {
                        e.preventDefault();
                        if (fila) fila.classList.add('fade-out');
                        if (card) card.classList.add('fade-out');

                        // Enviar el formulario después de la animación
                        setTimeout(() => form.submit(), 400);
                    } else {
                        e.preventDefault(); // cancelar envío
                    }
                });
            });

            // Resaltar nueva categoría si hay mensaje de éxito
            @if (session('success'))
                const ultimaFila = document.querySelector('.styled-table tbody tr:last-child');
                const ultimaCard = document.querySelector('.grid-categorias .card-categoria:last-child');
                if (ultimaFila) ultimaFila.classList.add('new-item');
                if (ultimaCard) ultimaCard.classList.add('new-item');
            @endif
        });
    </script>


</head>

<body>

    <header>
        <h1>@yield('h1', 'Bienvenido')</h1>

        <nav style="display:flex; justify-content:flex-end; align-items:center; gap:15px;">
            @guest
                @yield('botonesSesionCerrada')
            @else
                @yield('botonesSesionAbierta')
            @endguest
        </nav>

    </header>

    @yield('contenido')
</body>
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
</html>
