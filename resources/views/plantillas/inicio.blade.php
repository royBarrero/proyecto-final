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
    <link rel="icon" type="image/png" href="{{ asset('imagenes/logo2.png')}}" sizes="32x32">
    <style>
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
        padding: 20px 20px;
        text-align: center;
        display: flex;
        justify-content: space-between; /* título a la izquierda, botones a la derecha */
        align-items: center;
        }
        header h1 {
        margin: 0;
        font-size: 2em;
        }
        .header-buttons {
        display: flex;
        gap: 15px;
        }
        .header-buttons a,
        .header-buttons button {
        color: #ef8504;
        background: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s, color 0.3s;
        border: none;
        cursor: pointer;
        }
        .header-buttons a:hover,
        .header-buttons button:hover {
        background: #a75407;
        color: white;
        }

        .container {
        width: 90%;
        max-width: 1200px;
        margin: 30px auto;
        }
        .category {
        margin-bottom: 50px;
        }
        .category h2 {
        border-bottom: 2px solid #ef8504;
        padding-bottom: 10px;
        color: #ef8504;
        }
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
        .bird-card .info h3 {
        margin: 0 0 10px 0;
        font-size: 1.2em;
        }
        .bird-card .info p {
        margin: 0;
        font-size: 0.95em;
        color: #666;
        }
        .textarea-controlado {
    width: 100%;                /* Ocupa todo el ancho del contenedor del formulario */
    max-width: 100%;            /* Evita que sobresalga */
    height: 150px;              /* Altura cómoda */
    min-height: 100px;          /* Altura mínima */
    padding: 12px;              /* Espacio interno */
    margin-top: 10px;           /* Espacio arriba */
    margin-bottom: 20px;        /* Espacio abajo */
    border: 1px solid #ccc;     /* Borde suave */
    border-radius: 5px;         /* Bordes redondeados */
    resize: vertical;           /* Permite cambiar altura */
    font-size: 1em;             /* Tamaño de texto legible */
    font-family: Arial, sans-serif;
    box-sizing: border-box;     /* Incluye padding dentro del ancho */
}

    /* Formularios */
    .form-box {
        width: 90%;
        max-width: 400px;
        margin: 50px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        padding: 20px 0;
        margin-top: 50px;
    }
    /* Tabla estilizada */
    .styled-table {
    border-collapse: collapse;
    font-size: 0.95em;
    font-family: Arial, sans-serif;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px #f76104ed;
    }

    .styled-table thead tr {
    background-color: #ef8504;
    color: #ffffff;
    text-align: left;
    font-weight: bold;
    }

    .styled-table th,
    .styled-table td {
    padding: 12px 15px;
    border-bottom: 1px solid #dddddd;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:hover {
        background-color: #ffe6c2;
        transition: background 0.3s;
    }

    .styled-table tbody tr td .header-buttons {
        padding: 5px 10px;
        font-size: 0.85em;
    }

    /* Responsive */
    @media screen and (max-width: 768px) {
    .styled-table thead {
        display: none;
    }
    .styled-table, .styled-table tbody, .styled-table tr, .styled-table td {
        display: block;
        width: 100%;
    }
    .styled-table tr {
        margin-bottom: 15px;
    }
    .styled-table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
    .styled-table td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        width: 50%;
        padding-left: 10px;
        font-weight: bold;
        text-align: left;
    }
    } /* ← aquí cerramos el media query */
    .header-buttons .btn-cerrar {
    background: white;
    color: #ef8504;
    border: 1px solid #ef8504;
    padding: 8px 15px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, color 0.3s;
    }

    .header-buttons .btn-cerrar:hover {
    background: #ff4c4c; /* rojo suave */
    color: white;
    }
.div-botones {
    display: flex;
    gap: 10px; /* espacio entre los botones */
}
.div-botones2{
    display: flex;
    gap: 10px; /* espacio entre los botones */
    margin-top: 20px; /* separación hacia abajo */
}
    /* Estilo para eliminar */
.btn-eliminar {
    color: red;                 /* letra roja */
    background: #f9f9f9;        /* gris muy claro */
    padding: 3px 9px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s, color 0.3s;
    border: none;
    cursor: pointer;
}
.volver-btn {
    margin-top: 50px; /* separa el botón hacia abajo */
}
.btn-eliminar:hover {
    background: red;            /* fondo rojo */
    color: white;               /* letra blanca */
}

/* Estilo para editar */
.btn-editar {
    color: blue;                /* letra azul */
    background: #f9f9f9;        /* gris muy claro */
    padding: 4px 10px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s, color 0.3s;
    border: none;
    cursor: pointer;
}

.btn-editar:hover {
    background: blue;           /* fondo azul */
    color: white;               /* letra blanca */
}
/*-----------------------------------------*/
@media screen and (max-width: 768px) {
    .styled-table thead {
        display: none;
    }
    .styled-table, .styled-table tbody, .styled-table tr, .styled-table td {
        display: block;
        width: 100%;
    }
    .styled-table tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px;
        background: white;
    }
    .styled-table td {
        text-align: left; /* cambiar de right a left */
        padding-left: 45%; /* espacio para el label */
        position: relative;
        border: none;
        padding-top: 8px;
        padding-bottom: 8px;
        min-height: 40px; /* asegura suficiente espacio para botones */
    }
    .styled-table td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 40%; /* suficiente para mostrar la etiqueta */
        font-weight: bold;
        text-align: left;
    }
    .div-botones {
        justify-content: flex-start; /* que los botones no se alineen a la derecha */
        gap: 10px;
    }
}

</style>

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
        <p>© {{ date('Y') }} Tu Empresa | Contacto: info@tudominio.com</p>
</footer>
</html>
