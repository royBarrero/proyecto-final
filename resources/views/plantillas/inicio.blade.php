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
        justify-content: space-between;
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
    width: 100%;
    max-width: 100%;
    height: 150px;
    min-height: 100px;
    padding: 12px;
    margin-top: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: vertical;
    font-size: 1em;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
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

/* Botones */
.div-botones {
    display: flex;
    gap: 10px;
}
.div-botones2 {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}
.btn-eliminar {
    color: red;
    background: #f9f9f9;
    padding: 3px 9px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s, color 0.3s;
    border: none;
    cursor: pointer;
}
.btn-eliminar:hover {
    background: red;
    color: white;
}
.btn-editar {
    color: blue;
    background: #f9f9f9;
    padding: 4px 10px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s, color 0.3s;
    border: none;
    cursor: pointer;
}
.btn-editar:hover {
    background: blue;
    color: white;
}

/* Ocultar grid en escritorio */
.grid-categorias {
    display: none;
}

/* Responsive: mostrar grid en móviles */
@media screen and (max-width: 768px) {
    .tabla-escritorio {
        display: none;
    }

    .grid-categorias {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
        margin-top: 20px;
    }

    .card-categoria {
        background: white;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card-categoria p {
        margin: 5px 0;
        font-size: 0.95em;
        color: #333;
    }

    .card-categoria .div-botones {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
}

/*-----------------------------------------*/
/* Animaciones */
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
    0% { background-color: #fffbb1; }
    100% { background-color: white; }
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
            if (confirm('¿Eliminar esta categoría?')) {
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
    @if(session('success'))
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
        <p>© {{ date('Y') }} Tu Empresa | Contacto: info@tudominio.com</p>
</footer>
</html>
