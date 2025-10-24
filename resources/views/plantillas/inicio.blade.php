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

    nav {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

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
        color: #25D366;
        text-decoration: none;
        font-weight: bold;
    }

    footer a:hover {
        text-decoration: underline;
    }

    /* ====== GRIDS Y TARJETAS ====== */
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
        word-wrap: break-word; /* Ajusta palabras largas */
        overflow-wrap: break-word;
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
        word-wrap: break-word;
        overflow-wrap: break-word;
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
        word-wrap: break-word;
        overflow-wrap: break-word;
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
        overflow-wrap: break-word;
        hyphens: auto;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:hover {
        background-color: #ffe6c2;
    }

    .styled-table td ul {
        padding-left: 16px;
        max-height: 120px;
        overflow-y: auto;
    }

    .styled-table td ul li {
        font-size: 12px;
        margin-bottom: 3px;
        word-wrap: break-word;
        overflow-wrap: break-word;
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
    @media (max-width: 768px) {

        /* Header */
        .div-botones2 a,
        .div-botones2 button {
            flex: 1 1 100%;
        }

        .styled-table td {
            font-size: 13px;
        }

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

        /* Tablas -> tarjetas en móvil */
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

    @media (max-width: 480px) {
        footer {
            font-size: 0.8em;
            padding: 15px;
        }
    }

    /* Paginación responsive */
    .paginacion {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        font-family: 'Arial', sans-serif;
    }

    .paginacion .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        gap: 5px;
        flex-wrap: wrap;
    }

    .paginacion .pagination li {
        display: inline-block;
    }

    .paginacion .pagination a,
    .paginacion .pagination span {
        display: inline-block;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        color: #444;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
    }

    .paginacion .pagination a:hover {
        background-color: #ef8504;
        color: #fff;
        border-color: #ef8504;
    }

    .paginacion .pagination .active span {
        background-color: #ef8504;
        color: #fff;
        border-color: #ef8504;
        font-weight: bold;
    }

    .paginacion .pagination .disabled span {
        color: #999;
        border-color: #ddd;
        cursor: not-allowed;
        background-color: #f7f7f7;
    }

    @media (max-width: 500px) {
        .paginacion .pagination a,
        .paginacion .pagination span {
            font-size: 12px !important;
            padding: 5px 10px !important;
        }
    }
</style>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Confirmar eliminación
            document.querySelectorAll('form').forEach(form => {
                const btnEliminar = form.querySelector('.btn-eliminar');
                if (!btnEliminar) return;

                form.addEventListener('submit', e => {
                    const fila = form.closest('tr');
                    const card = form.closest('.bird-card');

                    if (confirm('¿Seguro que lo quieres eliminar?')) {
                        e.preventDefault();
                        if (fila) fila.classList.add('fade-out');
                        if (card) card.classList.add('fade-out');

                        setTimeout(() => form.submit(), 400);
                    } else {
                        e.preventDefault();
                    }
                });
            });

            // Resaltar nueva fila o tarjeta si hay éxito
            @if (session('success'))
                const ultimaFila = document.querySelector('.styled-table tbody tr:last-child');
                const ultimaCard = document.querySelector('.bird-grid .bird-card:last-child');
                if (ultimaFila) ultimaFila.classList.add('new-item');
                if (ultimaCard) ultimaCard.classList.add('new-item');
            @endif
        });
    </script>
</head>

<body>

    <header>
        <h1>@yield('h1', 'Bienvenido')</h1>
        <nav>
            @guest
                @yield('botonesSesionCerrada')
            @else
                @yield('botonesSesionAbierta')
            @endguest
        </nav>
    </header>

    <div class="container">
        @yield('contenido')
    </div>

    <footer>
        <p>
            © {{ date('Y') }} HuAviar |
            <a href="https://wa.me/message/ACPCFECPVJO5C1" target="_blank">
                ¡Contáctanos!
            </a>
        </p>
    </footer>
</body>

</html>
