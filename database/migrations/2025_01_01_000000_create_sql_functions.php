<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        // =============================
        // pgcrypto extension
        // =============================
        DB::unprepared("CREATE EXTENSION IF NOT EXISTS pgcrypto;");

        // =============================
        // FUNCTION actualizar_cantidad_productoaves
        // =============================
        DB::unprepared("
CREATE FUNCTION public.actualizar_cantidad_productoaves() RETURNS trigger
LANGUAGE plpgsql
AS $$
DECLARE
    cantidad_actual INT;
    nueva_cantidad INT;
BEGIN
    SELECT cantidad INTO cantidad_actual
    FROM productoAves
    WHERE id = NEW.idproductoAves;

    nueva_cantidad := cantidad_actual + NEW.cantidad;

    IF nueva_cantidad < 0 THEN
        RAISE EXCEPTION 'No se puede quitar más cantidad(tiene % y quiere quitar %) del producto (cantidad quedaría negativa)',
        cantidad_actual, nueva_cantidad * -1;
    END IF;

    UPDATE productoAves
    SET cantidad = nueva_cantidad
    WHERE id = NEW.idproductoAves;

    RETURN NEW;
END;
$$;
        ");

        // =============================
        // FUNCTION actualizar_venta
        // =============================
        DB::unprepared("
CREATE FUNCTION public.actualizar_venta(p_idventa integer, p_total numeric, p_metodo_pago integer)
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE pedidos SET total = p_total WHERE id = p_idventa;
    UPDATE pagos SET monto = p_total, idmetodoPagos = p_metodo_pago WHERE idpedidos = p_idventa;
END;
$$;
        ");

        // =============================
        // FUNCTION cifrar_contrasenia
        // =============================
        DB::unprepared("
CREATE FUNCTION public.cifrar_contrasenia() RETURNS trigger
LANGUAGE plpgsql
AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.contrasenia := crypt(NEW.contrasenia, gen_salt('bf', 12));
    ELSIF TG_OP = 'UPDATE'
      AND NEW.contrasenia IS DISTINCT FROM OLD.contrasenia THEN
        NEW.contrasenia := crypt(NEW.contrasenia, gen_salt('bf', 12));
    END IF;

    RETURN NEW;
END;
$$;
        ");

        // =============================
        // FUNCTION eliminar_venta
        // =============================
        DB::unprepared("
CREATE FUNCTION public.eliminar_venta(p_idventa integer)
RETURNS void
LANGUAGE plpgsql
AS $$
DECLARE
    v_item RECORD;
BEGIN
    FOR v_item IN SELECT * FROM detallePedidos WHERE idpedidos = p_idventa LOOP
        UPDATE productoAves
        SET cantidad = cantidad + v_item.cantidad
        WHERE id = v_item.idproductoAves;
    END LOOP;

    DELETE FROM pagos WHERE idpedidos = p_idventa;
    DELETE FROM detallePedidos WHERE idpedidos = p_idventa;
    DELETE FROM pedidos WHERE id = p_idventa;
END;
$$;
        ");

        // =============================
        // FUNCTION es_contrasenia_correcta
        // =============================
        DB::unprepared("
CREATE FUNCTION public.es_contrasenia_correcta(p_email varchar, p_contrasenia varchar)
RETURNS integer
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN COALESCE((
        SELECT CASE
            WHEN crypt(p_contrasenia, contrasenia) = contrasenia THEN 2
            ELSE 1
        END
        FROM usuarios
        WHERE email = p_email
    ), 0);
END;
$$;
        ");

        // =============================
        // FUNCTION listar_ventas
        // =============================
        DB::unprepared("
CREATE FUNCTION public.listar_ventas()
RETURNS TABLE(id integer, cliente varchar, vendedor varchar, total numeric, fecha date, metodo_pago varchar)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT
        p.id,
        c.nombre,
        v.nombre,
        p.total,
        p.fecha,
        m.descripcion
    FROM pedidos p
    JOIN clientes c ON p.idclientes = c.id
    JOIN vendedors v ON p.idvendedors = v.id
    JOIN pagos pa ON pa.idpedidos = p.id
    JOIN metodoPagos m ON pa.idmetodoPagos = m.id;
END;
$$;
        ");

        // =============================
        // FUNCTION obtener_detalle_venta
        // =============================
        DB::unprepared("
CREATE FUNCTION public.obtener_detalle_venta(p_idventa integer)
RETURNS TABLE(producto varchar, cantidad integer, precio numeric, subtotal numeric)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT pa.nombre,
           d.cantidad,
           d.precioUnitario,
           d.subtotal
    FROM detallePedidos d
    JOIN productoAves pa ON pa.id = d.idproductoAves
    WHERE d.idpedidos = p_idventa;
END;
$$;
        ");

        // =============================
        // FUNCTION obtener_usuario_por_id
        // =============================
        DB::unprepared("
CREATE FUNCTION public.obtener_usuario_por_id(p_id integer)
RETURNS TABLE(id integer, nombre varchar, correo varchar, rol varchar, direccion varchar, telefono varchar)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id,
        COALESCE(NULLIF(u.nombre,''), NULLIF(c.nombre,''), NULLIF(v.nombre,'')),
        COALESCE(NULLIF(u.email,''), NULLIF(v.email,'')),
        CASE
            WHEN c.idusuarios IS NOT NULL THEN 'Cliente'
            WHEN v.idusuarios IS NOT NULL THEN 'Vendedor'
            ELSE 'Desconocido'
        END,
        COALESCE(NULLIF(c.direccion,''), NULLIF(v.direccion,'')),
        COALESCE(NULLIF(c.telefono,''), NULLIF(v.telefono,''))
    FROM usuarios u
    LEFT JOIN clientes c ON c.idusuarios = u.id
    LEFT JOIN vendedors v ON v.idusuarios = u.id
    WHERE u.id = p_id;
END;
$$;
        ");

        // =============================
        // FUNCTION obtener_usuarios_completo
        // =============================
        DB::unprepared("
CREATE FUNCTION public.obtener_usuarios_completo()
RETURNS TABLE(id integer, nombre varchar, correo varchar, rol varchar, direccion varchar, telefono varchar)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id,
        COALESCE(c.nombre, v.nombre, u.nombre),
        COALESCE(v.email, u.email),
        CASE
            WHEN c.idusuarios IS NOT NULL THEN 'Cliente'
            WHEN v.idusuarios IS NOT NULL THEN 'Vendedor'
            ELSE 'Desconocido'
        END,
        COALESCE(c.direccion, v.direccion),
        COALESCE(c.telefono, v.telefono)
    FROM usuarios u
    LEFT JOIN clientes c ON c.idusuarios = u.id
    LEFT JOIN vendedors v ON v.idusuarios = u.id
    ORDER BY u.id;
END;
$$;
        ");

        // =============================
        // FUNCTION obtener_usuarios_con_su_rol
        // =============================
        DB::unprepared("
CREATE FUNCTION public.obtener_usuarios_con_su_rol()
RETURNS TABLE(id integer, nombre text, email text, contrasenia text, rol text)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT u.id, u.nombre, u.email, u.contrasenia, r.descripcion
    FROM usuarios u
    JOIN rols r ON u.idrols = r.id
    ORDER BY u.id;
END;
$$;
        ");

        // =============================
        // FUNCTION registrar_venta
        // =============================
        DB::unprepared("
CREATE FUNCTION public.registrar_venta(p_idcliente integer, p_idvendedor integer, p_total numeric, p_metodo_pago integer, p_detalles json)
RETURNS void
LANGUAGE plpgsql
AS $$
DECLARE
    v_idpedido INT;
    v_item JSON;
    v_idproducto INT;
    v_cantidad INT;
    v_precio NUMERIC;
BEGIN
    INSERT INTO pedidos (fecha, estado, total, idclientes, idvendedors)
    VALUES (CURRENT_DATE, 1, p_total, p_idcliente, p_idvendedor)
    RETURNING id INTO v_idpedido;

    FOR v_item IN SELECT * FROM json_array_elements(p_detalles)
    LOOP
        v_idproducto := (v_item->>'idproducto')::INT;
        v_cantidad := (v_item->>'cantidad')::INT;
        v_precio := (v_item->>'precio')::NUMERIC;

        INSERT INTO detallePedidos (idpedidos, idproductoAves, cantidad, precioUnitario, subtotal)
        VALUES (v_idpedido, v_idproducto, v_cantidad, v_precio, v_cantidad * v_precio);

        UPDATE productoAves
        SET cantidad = cantidad - v_cantidad
        WHERE id = v_idproducto;
    END LOOP;

    INSERT INTO pagos (fecha, estado, monto, idpedidos, idmetodoPagos)
    VALUES (CURRENT_DATE, 1, p_total, v_idpedido, p_metodo_pago);
END;
$$;
        ");

        // =============================
        // PROCEDURE actualizar_stock_producto
        // =============================
        DB::unprepared("
CREATE PROCEDURE public.actualizar_stock_producto(IN p_id integer, IN p_nombre varchar, IN p_precio numeric)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE productoAves
    SET nombre = p_nombre, precio = p_precio
    WHERE id = p_id;
END;
$$;
        ");

        // =============================
        // PROCEDURE actualizar_usuario_completo
        // =============================
        DB::unprepared("
CREATE PROCEDURE public.actualizar_usuario_completo(
    IN p_id integer,
    IN p_nombre varchar,
    IN p_email varchar,
    IN p_idrols integer,
    IN p_direccion varchar,
    IN p_telefono varchar
)
LANGUAGE plpgsql
AS $$
DECLARE
    v_idcliente INT;
    v_idvendedor INT;
BEGIN
    SELECT id INTO v_idcliente FROM clientes WHERE idusuarios = p_id;
    SELECT id INTO v_idvendedor FROM vendedors WHERE idusuarios = p_id;

    IF p_idrols = 2 THEN
        IF v_idcliente IS NOT NULL THEN
            UPDATE clientes
            SET nombre = p_nombre, direccion = p_direccion, telefono = p_telefono, activo = 1
            WHERE id = v_idcliente;
        ELSE
            INSERT INTO clientes(nombre, direccion, telefono, idusuarios, activo)
            VALUES (p_nombre, p_direccion, p_telefono, p_id, 1)
            RETURNING id INTO v_idcliente;
        END IF;

        IF v_idvendedor IS NOT NULL THEN
            UPDATE vendedors
            SET activo = 0
            WHERE id = v_idvendedor;
        END IF;

    ELSE
        IF v_idvendedor IS NOT NULL THEN
            UPDATE vendedors
            SET nombre = p_nombre, direccion = p_direccion, telefono = p_telefono,
                email = p_email, activo = 1
            WHERE id = v_idvendedor;
        ELSE
            INSERT INTO vendedors(nombre, direccion, telefono, email, idusuarios, activo)
            VALUES (p_nombre, p_direccion, p_telefono, p_email, p_id, 1)
            RETURNING id INTO v_idvendedor;
        END IF;

        IF v_idcliente IS NOT NULL THEN
            UPDATE clientes SET activo = 0 WHERE id = v_idcliente;
        END IF;

    END IF;

    UPDATE usuarios
    SET nombre = p_nombre, email = p_email, idrols = p_idrols
    WHERE id = p_id;
END;
$$;
        ");

        // =============================
        // PROCEDURE sp_pedidos_cliente
        // =============================
        DB::unprepared("
CREATE PROCEDURE public.sp_pedidos_cliente(IN p_idcliente integer)
LANGUAGE plpgsql
AS $$
DECLARE
    cur_pedidos CURSOR FOR SELECT * FROM pedidos WHERE idclientes = p_idcliente;
BEGIN
    OPEN cur_pedidos;
END;
$$;
        ");
    }

    public function down()
    {
        DB::unprepared("DROP FUNCTION IF EXISTS public.actualizar_cantidad_productoaves CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.actualizar_venta CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.cifrar_contrasenia CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.eliminar_venta CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.es_contrasenia_correcta CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.listar_ventas CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.obtener_detalle_venta CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.obtener_usuario_por_id CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.obtener_usuarios_completo CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.obtener_usuarios_con_su_rol CASCADE;");
        DB::unprepared("DROP FUNCTION IF EXISTS public.registrar_venta CASCADE;");
        DB::unprepared("DROP PROCEDURE IF EXISTS public.actualizar_stock_producto CASCADE;");
        DB::unprepared("DROP PROCEDURE IF EXISTS public.actualizar_usuario_completo CASCADE;");
        DB::unprepared("DROP PROCEDURE IF EXISTS public.sp_pedidos_cliente CASCADE;");
    }
};
