--
-- PostgreSQL database dump
--

\restrict 2XPLgKR1ytHZFytl4nnttqITaVxx47aeLdzyqyygLgwMEDwNcoANZSuwuCia53o

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.6

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


--
-- Name: actualizar_cantidad_productoaves(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.actualizar_cantidad_productoaves() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    cantidad_actual INT;
    nueva_cantidad INT;
BEGIN
    -- Obtener la cantidad actual del producto
    SELECT cantidad INTO cantidad_actual
    FROM productoAves
    WHERE id = NEW.idproductoAves;

    -- Calcular la nueva cantidad
    nueva_cantidad := cantidad_actual + NEW.cantidad;

    -- Validar que no sea negativa
    IF nueva_cantidad < 0 THEN
        RAISE EXCEPTION 'No se puede quitar más cantidad(tiene % y quiere quitar %) del producto (cantidad quedaría negativa)',cantidad_actual,nueva_cantidad*-1;
    END IF;

    -- Actualizar cantidad en productoAves
    UPDATE productoAves
    SET cantidad = nueva_cantidad
    WHERE id = NEW.idproductoAves;

    -- Permitir la inserción en stocks
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.actualizar_cantidad_productoaves() OWNER TO postgres;

--
-- Name: actualizar_stock_producto(integer, character varying, numeric); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.actualizar_stock_producto(IN p_id integer, IN p_nombre character varying, IN p_precio numeric)
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE productoAves
    SET nombre = p_nombre,
	    precio = p_precio
    WHERE productoAves.id = p_id;

    RAISE NOTICE 'Stock del producto con ID % actualizado a % unidades.', p_id, p_stock;
END $$;


ALTER PROCEDURE public.actualizar_stock_producto(IN p_id integer, IN p_nombre character varying, IN p_precio numeric) OWNER TO postgres;

--
-- Name: actualizar_usuario_completo(integer, character varying, character varying, integer, character varying, character varying); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.actualizar_usuario_completo(IN p_id integer, IN p_nombre character varying, IN p_email character varying, IN p_idrols integer, IN p_direccion character varying, IN p_telefono character varying)
    LANGUAGE plpgsql
    AS $$
DECLARE
    v_idcliente INT;
    v_idvendedor INT;
BEGIN
    -- Obtener los ids asociados en clientes y vendedores
    SELECT id INTO v_idcliente FROM clientes WHERE idusuarios = p_id;
    SELECT id INTO v_idvendedor FROM vendedors WHERE idusuarios = p_id;

    -- Manejo si el rol es CLIENTE (idrols = 2)
    IF p_idrols = 2 THEN
        -- Actualizar o crear cliente
        IF v_idcliente IS NOT NULL THEN
            UPDATE clientes
            SET nombre = p_nombre,
                direccion = p_direccion,
                telefono = p_telefono,
                activo = 1
            WHERE id = v_idcliente;
        ELSE
            INSERT INTO clientes(nombre, direccion, telefono, idusuarios, activo)
            VALUES (p_nombre, p_direccion, p_telefono, p_id, 1)
            RETURNING id INTO v_idcliente;
        END IF;

        -- Desactivar vendedor si existía
        IF v_idvendedor IS NOT NULL THEN
            UPDATE vendedors
            SET activo = 0
            WHERE id = v_idvendedor;
        END IF;

    -- Manejo si el rol es VENDEDOR (idrols != 2)
    ELSEIF p_idrols != 2 THEN
        -- Actualizar o crear vendedor
        IF v_idvendedor IS NOT NULL THEN
            UPDATE vendedors
            SET nombre = p_nombre,
                direccion = p_direccion,
                telefono = p_telefono,
                email = p_email,
                activo = 1
            WHERE id = v_idvendedor;
        ELSE
            INSERT INTO vendedors(nombre, direccion, telefono, email, idusuarios, activo)
            VALUES (p_nombre, p_direccion, p_telefono, p_email, p_id, 1)
            RETURNING id INTO v_idvendedor;
        END IF;

        -- Desactivar cliente si existía
        IF v_idcliente IS NOT NULL THEN
            UPDATE clientes
            SET activo = 0
            WHERE id = v_idcliente;
        END IF;

    -- Otros roles: desactivar ambos
    ELSE
        IF v_idcliente IS NOT NULL THEN
            UPDATE clientes SET activo = 0 WHERE id = v_idcliente;
        END IF;
        IF v_idvendedor IS NOT NULL THEN
            UPDATE vendedors SET activo = 0 WHERE id = v_idvendedor;
        END IF;
    END IF;

    -- Actualizar información básica del usuario
    UPDATE usuarios
    SET nombre = p_nombre,
        email = p_email,
        idrols = p_idrols
    WHERE id = p_id;
END;
$$;


ALTER PROCEDURE public.actualizar_usuario_completo(IN p_id integer, IN p_nombre character varying, IN p_email character varying, IN p_idrols integer, IN p_direccion character varying, IN p_telefono character varying) OWNER TO postgres;

--
-- Name: actualizar_venta(integer, numeric, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.actualizar_venta(p_idventa integer, p_total numeric, p_metodo_pago integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE pedidos SET total = p_total WHERE id = p_idventa;
    UPDATE pagos SET monto = p_total, idmetodoPagos = p_metodo_pago WHERE idpedidos = p_idventa;
END;
$$;


ALTER FUNCTION public.actualizar_venta(p_idventa integer, p_total numeric, p_metodo_pago integer) OWNER TO postgres;

--
-- Name: cifrar_contrasenia(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.cifrar_contrasenia() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    -- En INSERT siempre cifra
    IF TG_OP = 'INSERT' THEN
        NEW.contrasenia := crypt(NEW.contrasenia, gen_salt('bf', 12));

    -- En UPDATE, solo si la contraseña cambió
    ELSIF TG_OP = 'UPDATE' AND NEW.contrasenia IS DISTINCT FROM OLD.contrasenia THEN
        NEW.contrasenia := crypt(NEW.contrasenia, gen_salt('bf', 12));
    END IF;

    RETURN NEW;
END;
$$;


ALTER FUNCTION public.cifrar_contrasenia() OWNER TO postgres;

--
-- Name: eliminar_venta(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.eliminar_venta(p_idventa integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    v_item RECORD;
BEGIN
    -- Devolver el stock antes de borrar
    FOR v_item IN SELECT * FROM detallePedidos WHERE idpedidos = p_idventa
    LOOP
        UPDATE productoAves
        SET cantidad = cantidad + v_item.cantidad
        WHERE id = v_item.idproductoAves;
    END LOOP;

    -- Borrar primero pagos, detalles y finalmente el pedido
    DELETE FROM pagos WHERE idpedidos = p_idventa;
    DELETE FROM detallePedidos WHERE idpedidos = p_idventa;
    DELETE FROM pedidos WHERE id = p_idventa;
END;
$$;


ALTER FUNCTION public.eliminar_venta(p_idventa integer) OWNER TO postgres;

--
-- Name: es_contrasenia_correcta(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.es_contrasenia_correcta(p_email character varying, p_contrasenia character varying) RETURNS integer
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


ALTER FUNCTION public.es_contrasenia_correcta(p_email character varying, p_contrasenia character varying) OWNER TO postgres;

--
-- Name: listar_ventas(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.listar_ventas() RETURNS TABLE(id integer, cliente character varying, vendedor character varying, total numeric, fecha date, metodo_pago character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT
        p.id,
        c.nombre::VARCHAR AS cliente,
        v.nombre::VARCHAR AS vendedor,
        p.total,
        p.fecha,
        m.descripcion AS metodo_pago
    FROM pedidos p
    JOIN clientes c ON p.idclientes = c.id
    JOIN vendedors v ON p.idvendedors = v.id
    JOIN pagos pa ON pa.idpedidos = p.id
    JOIN metodoPagos m ON pa.idmetodoPagos = m.id;
END;
$$;


ALTER FUNCTION public.listar_ventas() OWNER TO postgres;

--
-- Name: obtener_detalle_venta(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.obtener_detalle_venta(p_idventa integer) RETURNS TABLE(producto character varying, cantidad integer, precio numeric, subtotal numeric)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        pa.nombre AS producto,
        d.cantidad,
        d.precioUnitario AS precio,
        d.subtotal
    FROM detallePedidos d
    JOIN productoAves pa ON pa.id = d.idproductoAves
    WHERE d.idpedidos = p_idventa;
END;
$$;


ALTER FUNCTION public.obtener_detalle_venta(p_idventa integer) OWNER TO postgres;

--
-- Name: obtener_usuario_por_id(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.obtener_usuario_por_id(p_id integer) RETURNS TABLE(id integer, nombre character varying, correo character varying, rol character varying, direccion character varying, telefono character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id::INT,
        COALESCE(NULLIF(u.nombre, ''), NULLIF(c.nombre, ''), NULLIF(v.nombre, ''))::VARCHAR AS nombre,
        COALESCE(NULLIF(u.email, ''), NULLIF(v.email, ''))::VARCHAR AS correo,
        CASE
            WHEN c.idusuarios IS NOT NULL THEN 'Cliente'
            WHEN v.idusuarios IS NOT NULL THEN 'Vendedor'
            ELSE 'Desconocido'
        END::VARCHAR AS rol,
        COALESCE(NULLIF(c.direccion, ''), NULLIF(v.direccion, ''))::VARCHAR AS direccion,
        COALESCE(NULLIF(c.telefono, ''), NULLIF(v.telefono, ''))::VARCHAR AS telefono
    FROM usuarios u
    LEFT JOIN clientes c ON c.idusuarios = u.id
    LEFT JOIN vendedors v ON v.idusuarios = u.id
    LEFT JOIN rols r ON u.idrols = r.id
    WHERE u.id = p_id
    ORDER BY u.id ASC;
END;
$$;


ALTER FUNCTION public.obtener_usuario_por_id(p_id integer) OWNER TO postgres;

--
-- Name: obtener_usuario_por_id(integer, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.obtener_usuario_por_id(p_id integer, p_nombre character varying, p_correo character varying, p_rol character varying, p_telefono character varying) RETURNS TABLE(id integer, nombre character varying, correo character varying, rol character varying, direccion character varying, telefono character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id::INT,
        COALESCE(NULLIF(u.nombre, ''), c.nombre, v.nombre)::VARCHAR AS nombre,
        COALESCE(NULLIF(u.email, ''), v.email)::VARCHAR AS correo,
        (CASE
            WHEN u.idclientes IS NOT NULL THEN 'Cliente'
            WHEN u.idvendedors IS NOT NULL THEN 'Vendedor'
            ELSE 'Desconocido'
        END)::VARCHAR AS rol,
        COALESCE(c.direccion, v.direccion)::VARCHAR AS direccion,
        COALESCE(c.telefono, v.telefono)::VARCHAR AS telefono
    FROM usuarios u
    LEFT JOIN clientes c ON u.idclientes = c.id
    LEFT JOIN vendedors v ON u.idvendedors = v.id
    WHERE u.id = p_id;
END;
$$;


ALTER FUNCTION public.obtener_usuario_por_id(p_id integer, p_nombre character varying, p_correo character varying, p_rol character varying, p_telefono character varying) OWNER TO postgres;

--
-- Name: obtener_usuarios_completo(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.obtener_usuarios_completo() RETURNS TABLE(id integer, nombre character varying, correo character varying, rol character varying, direccion character varying, telefono character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id,
        COALESCE(c.nombre::VARCHAR, v.nombre::VARCHAR, u.nombre::VARCHAR) AS nombre,
        COALESCE(v.email::VARCHAR, u.email::VARCHAR) AS correo,
        CASE
            WHEN c.idusuarios IS NOT NULL THEN 'Cliente'::VARCHAR
            WHEN v.idusuarios IS NOT NULL THEN 'Vendedor'::VARCHAR
            ELSE 'Desconocido'::VARCHAR
        END AS rol,
        COALESCE(c.direccion::VARCHAR, v.direccion::VARCHAR) AS direccion,
        COALESCE(c.telefono::VARCHAR, v.telefono::VARCHAR) AS telefono
    FROM usuarios u
    LEFT JOIN clientes c ON c.idusuarios = u.id
    LEFT JOIN vendedors v ON v.idusuarios = u.id
    ORDER BY u.id;
END;
$$;


ALTER FUNCTION public.obtener_usuarios_completo() OWNER TO postgres;

--
-- Name: obtener_usuarios_con_su_rol(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.obtener_usuarios_con_su_rol() RETURNS TABLE(id integer, nombre text, email text, contrasenia text, rol text)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY SELECT usuarios.id, usuarios.nombre::TEXT, usuarios.email::TEXT, usuarios.contrasenia::TEXT, rols.descripcion::TEXT 
	FROM usuarios, rols
	WHERE idrols=rols.id
	ORDER BY usuarios.id ASC;
END;
$$;


ALTER FUNCTION public.obtener_usuarios_con_su_rol() OWNER TO postgres;

--
-- Name: registrar_venta(integer, integer, numeric, integer, json); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.registrar_venta(p_idcliente integer, p_idvendedor integer, p_total numeric, p_metodo_pago integer, p_detalles json) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    v_idpedido INT;
    v_item JSON;
    v_idproducto INT;
    v_cantidad INT;
    v_precio NUMERIC;
BEGIN
    -- 1️⃣ Crear el pedido
    INSERT INTO pedidos (fecha, estado, total, idclientes, idvendedors)
    VALUES (CURRENT_DATE, 1, p_total, p_idcliente, p_idvendedor)
    RETURNING id INTO v_idpedido;

    -- 2️⃣ Insertar los detalles
    FOR v_item IN SELECT * FROM json_array_elements(p_detalles)
    LOOP
        v_idproducto := (v_item->>'idproducto')::INT;
        v_cantidad   := (v_item->>'cantidad')::INT;
        v_precio     := (v_item->>'precio')::NUMERIC;

        INSERT INTO detallePedidos (idpedidos, idproductoAves, cantidad, precioUnitario, subtotal)
        VALUES (v_idpedido, v_idproducto, v_cantidad, v_precio, v_cantidad * v_precio);

        -- 3️⃣ Actualizar stock
        UPDATE productoAves
        SET cantidad = cantidad - v_cantidad
        WHERE id = v_idproducto;
    END LOOP;

    -- 4️⃣ Registrar el pago
    INSERT INTO pagos (fecha, estado, monto, idpedidos, idmetodoPagos)
    VALUES (CURRENT_DATE, 1, p_total, v_idpedido, p_metodo_pago);
END;
$$;


ALTER FUNCTION public.registrar_venta(p_idcliente integer, p_idvendedor integer, p_total numeric, p_metodo_pago integer, p_detalles json) OWNER TO postgres;

--
-- Name: sp_pedidos_cliente(integer); Type: PROCEDURE; Schema: public; Owner: postgres
--

CREATE PROCEDURE public.sp_pedidos_cliente(IN p_idcliente integer)
    LANGUAGE plpgsql
    AS $$
DECLARE
    cur_pedidos CURSOR FOR
        SELECT * FROM pedidos WHERE idclientes = p_idcliente;
BEGIN
    OPEN cur_pedidos;
END $$;


ALTER PROCEDURE public.sp_pedidos_cliente(IN p_idcliente integer) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: auditorias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auditorias (
    id integer NOT NULL,
    tabla character varying(255) NOT NULL,
    registro_id integer NOT NULL,
    accion character varying(50) NOT NULL,
    usuario_id integer,
    cambios jsonb,
    ip character varying(45),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.auditorias OWNER TO postgres;

--
-- Name: auditorias_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.auditorias_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.auditorias_id_seq OWNER TO postgres;

--
-- Name: auditorias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.auditorias_id_seq OWNED BY public.auditorias.id;


--
-- Name: cajas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cajas (
    id integer NOT NULL,
    fecha_apertura timestamp without time zone DEFAULT now() NOT NULL,
    fecha_cierre timestamp without time zone,
    monto_inicial numeric(12,2) NOT NULL,
    monto_final numeric(12,2),
    estado character varying(10) DEFAULT 'abierta'::character varying NOT NULL,
    idusuarios integer NOT NULL
);


ALTER TABLE public.cajas OWNER TO postgres;

--
-- Name: cajas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cajas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cajas_id_seq OWNER TO postgres;

--
-- Name: cajas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cajas_id_seq OWNED BY public.cajas.id;


--
-- Name: categorias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categorias (
    id integer NOT NULL,
    nombre character varying(100) NOT NULL,
    descripcion text
);


ALTER TABLE public.categorias OWNER TO postgres;

--
-- Name: categorias_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categorias_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categorias_id_seq OWNER TO postgres;

--
-- Name: categorias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categorias_id_seq OWNED BY public.categorias.id;


--
-- Name: clientes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clientes (
    id integer NOT NULL,
    nombre character varying(150) NOT NULL,
    direccion character varying(250),
    telefono character varying(30),
    idusuarios integer,
    activo smallint DEFAULT 1 NOT NULL,
    CONSTRAINT chk_clientes_activo CHECK ((activo = ANY (ARRAY[0, 1])))
);


ALTER TABLE public.clientes OWNER TO postgres;

--
-- Name: clientes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clientes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clientes_id_seq OWNER TO postgres;

--
-- Name: clientes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clientes_id_seq OWNED BY public.clientes.id;


--
-- Name: compras; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.compras (
    id integer NOT NULL,
    fecha date NOT NULL,
    estado integer NOT NULL,
    total numeric(12,2) NOT NULL,
    idproveedors integer NOT NULL,
    idvendedors integer NOT NULL
);


ALTER TABLE public.compras OWNER TO postgres;

--
-- Name: compras_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.compras_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.compras_id_seq OWNER TO postgres;

--
-- Name: compras_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.compras_id_seq OWNED BY public.compras.id;


--
-- Name: cotizaciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cotizaciones (
    id integer NOT NULL,
    fecha date NOT NULL,
    total numeric(12,2) NOT NULL,
    validez integer NOT NULL,
    idclientes integer NOT NULL
);


ALTER TABLE public.cotizaciones OWNER TO postgres;

--
-- Name: cotizaciones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cotizaciones_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cotizaciones_id_seq OWNER TO postgres;

--
-- Name: cotizaciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cotizaciones_id_seq OWNED BY public.cotizaciones.id;


--
-- Name: detalleaves; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalleaves (
    id integer NOT NULL,
    descripcion character varying(100) NOT NULL,
    edad character varying(7) NOT NULL
);


ALTER TABLE public.detalleaves OWNER TO postgres;

--
-- Name: detalleaves_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalleaves_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detalleaves_id_seq OWNER TO postgres;

--
-- Name: detalleaves_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalleaves_id_seq OWNED BY public.detalleaves.id;


--
-- Name: detallecompras; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detallecompras (
    id integer NOT NULL,
    idcompras integer NOT NULL,
    idproductoalimentos integer NOT NULL,
    cantidad integer NOT NULL,
    preciounitario numeric(10,2) NOT NULL,
    subtotal numeric(12,2) NOT NULL
);


ALTER TABLE public.detallecompras OWNER TO postgres;

--
-- Name: detallecompras_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detallecompras_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detallecompras_id_seq OWNER TO postgres;

--
-- Name: detallecompras_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detallecompras_id_seq OWNED BY public.detallecompras.id;


--
-- Name: detallecotizaciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detallecotizaciones (
    id integer NOT NULL,
    idcotizaciones integer NOT NULL,
    idproductoaves integer NOT NULL,
    cantidad integer NOT NULL,
    preciounitario numeric(10,2) NOT NULL,
    subtotal numeric(12,2) NOT NULL
);


ALTER TABLE public.detallecotizaciones OWNER TO postgres;

--
-- Name: detallecotizaciones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detallecotizaciones_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detallecotizaciones_id_seq OWNER TO postgres;

--
-- Name: detallecotizaciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detallecotizaciones_id_seq OWNED BY public.detallecotizaciones.id;


--
-- Name: detallepedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detallepedidos (
    id integer NOT NULL,
    idpedidos integer NOT NULL,
    idproductoaves integer NOT NULL,
    cantidad integer NOT NULL,
    preciounitario numeric(10,2) NOT NULL,
    subtotal numeric(12,2) NOT NULL
);


ALTER TABLE public.detallepedidos OWNER TO postgres;

--
-- Name: detallepedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detallepedidos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detallepedidos_id_seq OWNER TO postgres;

--
-- Name: detallepedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detallepedidos_id_seq OWNED BY public.detallepedidos.id;


--
-- Name: fotoaves; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fotoaves (
    id integer NOT NULL,
    nombrefoto character varying(250) NOT NULL,
    idproductoaves integer NOT NULL
);


ALTER TABLE public.fotoaves OWNER TO postgres;

--
-- Name: fotoaves_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fotoaves_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fotoaves_id_seq OWNER TO postgres;

--
-- Name: fotoaves_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fotoaves_id_seq OWNED BY public.fotoaves.id;


--
-- Name: metodopagos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.metodopagos (
    id integer NOT NULL,
    descripcion character varying(100) NOT NULL
);


ALTER TABLE public.metodopagos OWNER TO postgres;

--
-- Name: metodopagos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.metodopagos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.metodopagos_id_seq OWNER TO postgres;

--
-- Name: metodopagos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.metodopagos_id_seq OWNED BY public.metodopagos.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: movimientoscaja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movimientoscaja (
    id integer NOT NULL,
    idcaja integer NOT NULL,
    tipo character varying(10) NOT NULL,
    descripcion text,
    monto numeric(12,2) NOT NULL,
    fecha timestamp without time zone DEFAULT now(),
    origen character varying(30) DEFAULT NULL::character varying,
    idreferencia integer,
    CONSTRAINT movimientoscaja_tipo_check CHECK (((tipo)::text = ANY ((ARRAY['ingreso'::character varying, 'egreso'::character varying])::text[])))
);


ALTER TABLE public.movimientoscaja OWNER TO postgres;

--
-- Name: movimientoscaja_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.movimientoscaja_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.movimientoscaja_id_seq OWNER TO postgres;

--
-- Name: movimientoscaja_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.movimientoscaja_id_seq OWNED BY public.movimientoscaja.id;


--
-- Name: pagos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pagos (
    id integer NOT NULL,
    fecha date NOT NULL,
    estado integer NOT NULL,
    monto numeric(12,2) NOT NULL,
    idpedidos integer,
    idmetodopagos integer NOT NULL,
    idcaja integer,
    tipo character varying(10),
    descripcion text,
    origen character varying(30),
    idreferencia integer,
    CONSTRAINT pagos_tipo_check CHECK (((tipo)::text = ANY ((ARRAY['ingreso'::character varying, 'egreso'::character varying])::text[])))
);


ALTER TABLE public.pagos OWNER TO postgres;

--
-- Name: pagos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pagos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pagos_id_seq OWNER TO postgres;

--
-- Name: pagos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pagos_id_seq OWNED BY public.pagos.id;


--
-- Name: pedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedidos (
    id integer NOT NULL,
    fecha date NOT NULL,
    estado integer NOT NULL,
    total numeric(12,2) NOT NULL,
    idclientes integer NOT NULL,
    idvendedors integer NOT NULL
);


ALTER TABLE public.pedidos OWNER TO postgres;

--
-- Name: pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedidos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedidos_id_seq OWNER TO postgres;

--
-- Name: pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedidos_id_seq OWNED BY public.pedidos.id;


--
-- Name: productoalimentos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.productoalimentos (
    id integer NOT NULL,
    nombre character varying(150) NOT NULL,
    precio numeric(10,2) NOT NULL
);


ALTER TABLE public.productoalimentos OWNER TO postgres;

--
-- Name: productoalimentos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.productoalimentos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.productoalimentos_id_seq OWNER TO postgres;

--
-- Name: productoalimentos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.productoalimentos_id_seq OWNED BY public.productoalimentos.id;


--
-- Name: productoaves; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.productoaves (
    id integer NOT NULL,
    nombre character varying(150) NOT NULL,
    precio numeric(10,2) NOT NULL,
    idcategorias integer NOT NULL,
    iddetalleaves integer NOT NULL,
    cantidad integer DEFAULT 0 NOT NULL,
    CONSTRAINT chk_cantidad_no_negativa CHECK ((cantidad >= 0))
);


ALTER TABLE public.productoaves OWNER TO postgres;

--
-- Name: productoaves_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.productoaves_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.productoaves_id_seq OWNER TO postgres;

--
-- Name: productoaves_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.productoaves_id_seq OWNED BY public.productoaves.id;


--
-- Name: proveedors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.proveedors (
    id integer NOT NULL,
    nombre character varying(150) NOT NULL,
    direccion character varying(250),
    telefono character varying(30)
);


ALTER TABLE public.proveedors OWNER TO postgres;

--
-- Name: proveedores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.proveedores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.proveedores_id_seq OWNER TO postgres;

--
-- Name: proveedores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.proveedores_id_seq OWNED BY public.proveedors.id;


--
-- Name: rols; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rols (
    id integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.rols OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.rols.id;


--
-- Name: stocks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.stocks (
    id integer NOT NULL,
    cantidad integer NOT NULL,
    estado character(1) NOT NULL,
    fecha date NOT NULL,
    idproductoaves integer NOT NULL
);


ALTER TABLE public.stocks OWNER TO postgres;

--
-- Name: stocks_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.stocks_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.stocks_id_seq OWNER TO postgres;

--
-- Name: stocks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.stocks_id_seq OWNED BY public.stocks.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nombre character varying(150) NOT NULL,
    email character varying(150) NOT NULL,
    contrasenia character varying(255) NOT NULL,
    idrols integer DEFAULT 2 NOT NULL,
    created_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO postgres;

--
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- Name: vendedors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vendedors (
    id integer NOT NULL,
    nombre character varying(150) NOT NULL,
    direccion character varying(250),
    telefono character varying(30),
    email character varying(150) NOT NULL,
    idusuarios integer,
    activo smallint DEFAULT 0 NOT NULL,
    CONSTRAINT chk_vendedors_activo CHECK ((activo = ANY (ARRAY[0, 1])))
);


ALTER TABLE public.vendedors OWNER TO postgres;

--
-- Name: vendedores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vendedores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vendedores_id_seq OWNER TO postgres;

--
-- Name: vendedores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vendedores_id_seq OWNED BY public.vendedors.id;


--
-- Name: auditorias id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auditorias ALTER COLUMN id SET DEFAULT nextval('public.auditorias_id_seq'::regclass);


--
-- Name: cajas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cajas ALTER COLUMN id SET DEFAULT nextval('public.cajas_id_seq'::regclass);


--
-- Name: categorias id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias ALTER COLUMN id SET DEFAULT nextval('public.categorias_id_seq'::regclass);


--
-- Name: clientes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes ALTER COLUMN id SET DEFAULT nextval('public.clientes_id_seq'::regclass);


--
-- Name: compras id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.compras ALTER COLUMN id SET DEFAULT nextval('public.compras_id_seq'::regclass);


--
-- Name: cotizaciones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cotizaciones ALTER COLUMN id SET DEFAULT nextval('public.cotizaciones_id_seq'::regclass);


--
-- Name: detalleaves id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalleaves ALTER COLUMN id SET DEFAULT nextval('public.detalleaves_id_seq'::regclass);


--
-- Name: detallecompras id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallecompras ALTER COLUMN id SET DEFAULT nextval('public.detallecompras_id_seq'::regclass);


--
-- Name: detallecotizaciones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallecotizaciones ALTER COLUMN id SET DEFAULT nextval('public.detallecotizaciones_id_seq'::regclass);


--
-- Name: detallepedidos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallepedidos ALTER COLUMN id SET DEFAULT nextval('public.detallepedidos_id_seq'::regclass);


--
-- Name: fotoaves id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fotoaves ALTER COLUMN id SET DEFAULT nextval('public.fotoaves_id_seq'::regclass);


--
-- Name: metodopagos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.metodopagos ALTER COLUMN id SET DEFAULT nextval('public.metodopagos_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: movimientoscaja id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimientoscaja ALTER COLUMN id SET DEFAULT nextval('public.movimientoscaja_id_seq'::regclass);


--
-- Name: pagos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagos ALTER COLUMN id SET DEFAULT nextval('public.pagos_id_seq'::regclass);


--
-- Name: pedidos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id SET DEFAULT nextval('public.pedidos_id_seq'::regclass);


--
-- Name: productoalimentos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productoalimentos ALTER COLUMN id SET DEFAULT nextval('public.productoalimentos_id_seq'::regclass);


--
-- Name: productoaves id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productoaves ALTER COLUMN id SET DEFAULT nextval('public.productoaves_id_seq'::regclass);


--
-- Name: proveedors id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proveedors ALTER COLUMN id SET DEFAULT nextval('public.proveedores_id_seq'::regclass);


--
-- Name: rols id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rols ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: stocks id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.stocks ALTER COLUMN id SET DEFAULT nextval('public.stocks_id_seq'::regclass);


--
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- Name: vendedors id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vendedors ALTER COLUMN id SET DEFAULT nextval('public.vendedores_id_seq'::regclass);


--
-- Data for Name: auditorias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auditorias (id, tabla, registro_id, accion, usuario_id, cambios, ip, created_at) FROM stdin;
1	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 00:08:29.16311
2	productoaves	1	ACTUALIZAR	16	{"antes": {"id": 1, "nombre": "pollo", "precio": "35.00", "cantidad": 100, "idcategorias": 1, "iddetalleaves": 1}, "despues": {"id": 1, "nombre": "pollo", "precio": "25.00", "cantidad": "100", "idcategorias": "1", "iddetalleaves": 1}}	127.0.0.1	2025-10-23 00:58:27.197064
3	categorias	6	ELIMINAR	16	{"antes": {"id": 6, "nombre": "Huevos", "descripcion": "Producción de huevos"}}	127.0.0.1	2025-10-23 01:04:22.933477
4	categorias	13	CREAR	16	{"despues": {"id": 13, "nombre": "Huevos", "descripcion": "Produccion de huevos"}}	127.0.0.1	2025-10-23 01:04:44.336544
5	usuarios	16	CIERRE_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 01:55:39.186141
6	usuarios	21	INICIO_SESION	21	{"nombre": "Roy Barrero"}	127.0.0.1	2025-10-23 01:56:09.363529
7	proveedors	4	ACTUALIZAR	21	{"antes": {"id": 4, "nombre": "Granos del Oriente", "telefono": "7004444", "direccion": "Zona Plan 3000"}, "despues": {"id": 4, "nombre": "Granos del Oriente", "telefono": "7004410", "direccion": "Zona Plan 3001"}}	127.0.0.1	2025-10-23 02:15:53.261631
8	usuarios	21	CIERRE_SESION	21	{"nombre": "Roy Barrero"}	127.0.0.1	2025-10-23 02:56:15.174293
9	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 02:56:24.995069
10	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 12:23:06.033104
11	usuarios	16	CIERRE_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 13:52:54.402694
12	usuarios	21	INICIO_SESION	21	{"nombre": "Roy Barrero"}	127.0.0.1	2025-10-23 13:53:07.593565
13	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 17:35:13.703925
14	productoaves	1	ACTUALIZAR	16	{"antes": {"id": 1, "nombre": "pollo", "precio": "25.00", "cantidad": 100, "idcategorias": 1, "iddetalleaves": 1}, "despues": {"id": 1, "nombre": "pollo", "precio": "40", "cantidad": "100", "idcategorias": "1", "iddetalleaves": 1}}	127.0.0.1	2025-10-23 20:32:15.731026
15	usuarios	16	CIERRE_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 21:45:37.822072
16	usuarios	37	CREAR	\N	{"despues": {"id": 37, "email": "pepe@gmail.com", "idrols": 2, "nombre": "Pepe Gonzales", "contrasenia": "123456"}}	127.0.0.1	2025-10-23 21:52:14.766628
17	usuarios	38	CREAR	\N	{"despues": {"id": 38, "email": "pep1e@gmail.com", "idrols": 2, "nombre": "Pepe1 Gonzales", "contrasenia": "123456"}}	127.0.0.1	2025-10-23 21:58:53.497842
18	usuarios	39	CREAR	\N	{"despues": {"id": 39, "email": "pepe12@gmail.com", "idrols": 2, "nombre": "Pepe12 Gonzales", "contrasenia": "123456"}}	127.0.0.1	2025-10-23 22:00:29.868492
19	clientes	37	CREAR	\N	{"despues": {"id": 37, "nombre": "Pepe12 Gonzales", "telefono": null, "direccion": null, "idusuarios": 39}}	127.0.0.1	2025-10-23 22:00:29.873067
20	usuarios	39	INICIO_SESION	39	{"nombre": "Pepe12 Gonzales"}	127.0.0.1	2025-10-23 22:00:29.878033
21	usuarios	39	CIERRE_SESION	39	{"nombre": "Pepe12 Gonzales"}	127.0.0.1	2025-10-23 23:05:45.220185
22	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 23:06:01.8347
23	fotoaves	5	CREAR	16	{"despues": {"id": 5, "nombrefoto": "1761276980_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-23 23:36:20.964057
24	fotoaves	6	CREAR	16	{"despues": {"id": 6, "nombrefoto": "1761277560_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-23 23:46:00.402034
25	fotoaves	5	ELIMINAR	16	{"antes": {"id": 5, "nombrefoto": "1761276980_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-23 23:56:00.290202
26	usuarios	16	CIERRE_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 23:56:06.607606
27	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 23:56:21.070198
28	fotoaves	6	ELIMINAR	16	{"antes": {"id": 6, "nombrefoto": "1761277560_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-23 23:56:26.523521
29	usuarios	16	CIERRE_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 23:56:30.489709
30	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-10-23 23:56:44.491951
31	fotoaves	7	CREAR	16	{"despues": {"id": 7, "nombrefoto": "1761278253_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-23 23:57:33.678156
32	fotoaves	7	ELIMINAR	16	{"antes": {"id": 7, "nombrefoto": "1761278253_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-23 23:59:44.913087
33	fotoaves	8	CREAR	16	{"despues": {"id": 8, "nombrefoto": "1761278797_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 00:06:37.133134
34	fotoaves	8	ELIMINAR	16	{"antes": {"id": 8, "nombrefoto": "1761278797_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 00:37:18.935076
35	fotoaves	9	CREAR	16	{"despues": {"id": 9, "nombrefoto": "1761280658_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 00:37:38.640064
36	fotoaves	9	ELIMINAR	16	{"antes": {"id": 9, "nombrefoto": "1761280658_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 00:50:55.152972
37	fotoaves	10	CREAR	16	{"despues": {"id": 10, "nombrefoto": "1761281473_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 00:51:13.425247
38	fotoaves	10	ELIMINAR	16	{"antes": {"id": 10, "nombrefoto": "1761281473_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 00:57:01.129946
39	fotoaves	11	CREAR	16	{"despues": {"id": 11, "nombrefoto": "1761281839_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 00:57:19.764878
40	fotoaves	12	CREAR	16	{"despues": {"id": 12, "nombrefoto": "1761282283_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 01:04:43.973723
41	fotoaves	4	ELIMINAR	16	{"antes": {"id": 4, "nombrefoto": "1761174383_Captura de pantalla 2025-10-22 182806.png", "idproductoaves": 4}}	127.0.0.1	2025-10-24 01:17:38.671349
42	fotoaves	11	ELIMINAR	16	{"antes": {"id": 11, "nombrefoto": "1761281839_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 01:17:43.341277
43	fotoaves	12	ELIMINAR	16	{"antes": {"id": 12, "nombrefoto": "1761282283_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 01:17:47.768973
44	fotoaves	13	CREAR	16	{"despues": {"id": 13, "nombrefoto": "1761283083_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 01:18:03.882477
45	fotoaves	13	ELIMINAR	16	{"antes": {"id": 13, "nombrefoto": "1761283083_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 01:31:05.658058
46	fotoaves	14	CREAR	16	{"despues": {"id": 14, "nombrefoto": "1761283883_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 01:31:23.442558
47	fotoaves	14	ELIMINAR	16	{"antes": {"id": 14, "nombrefoto": "1761283883_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 02:25:41.179394
48	fotoaves	15	CREAR	16	{"despues": {"id": 15, "nombrefoto": "1761287187_Captura de pantalla 2025-10-22 182806.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 02:26:27.942889
49	fotoaves	16	CREAR	16	{"despues": {"id": 16, "nombrefoto": "1761287187_foto2.png", "idproductoaves": 1}}	127.0.0.1	2025-10-24 02:26:27.950484
50	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-11-03 11:29:37.263221
51	usuarios	16	CIERRE_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-11-03 11:29:48.212321
52	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-11-03 11:29:55.996748
53	usuarios	16	CIERRE_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-11-03 11:35:38.699774
54	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-11-03 11:35:50.126451
55	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-11-03 22:33:07.288989
56	usuarios	16	INICIO_SESION	16	{"nombre": "Cristian Huari"}	127.0.0.1	2025-11-04 13:34:58.671632
\.


--
-- Data for Name: cajas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cajas (id, fecha_apertura, fecha_cierre, monto_inicial, monto_final, estado, idusuarios) FROM stdin;
1	2025-11-04 13:38:31.425372	2025-11-04 17:47:41	1000.00	1000.00	cerrada	16
2	2025-11-04 13:47:54.310963	\N	1000.00	\N	abierta	16
\.


--
-- Data for Name: categorias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categorias (id, nombre, descripcion) FROM stdin;
2	Alimentos	Comida balanceada para aves
3	Accesorios	Jaulas, bebederos, comederos
4	Medicinas	Vitaminas y vacunas
5	Carnes	Carne de aves
7	Servicios	Servicios adicionales
1	Aves	Productos de aves vivos
11	Alimento de engorde	Balanceado para ponedoras
8	Transporte	Envío y logística
13	Huevos	Produccion de huevos
\.


--
-- Data for Name: clientes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clientes (id, nombre, direccion, telefono, idusuarios, activo) FROM stdin;
22	saturnino mamani	La salle	79632222	24	1
24	Samuel Torrico	\N	74559621	26	1
23	Belisario Landa	\N	66254417	25	1
30	Josue Vargas	\N	\N	32	1
10	Daniel Suárez	Av. Alemana 99	7894570	\N	1
11	Cristian Huari	Av. Siempre Viva 123	7133571	\N	1
28	Jose Aguirre	\N	66852470	30	1
1	Ana López	Av. Libertad 123	7894561	2	1
2	Carlos Ramos	Calle 10 #45	7458962	3	1
3	María López	Av. Principal 22	76543210	4	1
4	Pedro Ortiz	Zona Norte	7894564	5	1
5	Lucía García	Zona Sur	7894565	6	1
6	Roberto Díaz	Calle Bolívar	7894566	7	1
7	Sofía Vargas	Av. Cañoto 77	7894567	8	1
8	Daniel Guzmán	Zona Central	7894568	9	1
9	Laura Torres	Barrio Jardín	7894569	10	1
15	Asher Bustillos	Barrio Los Pinos, Zona arroyito	33449283	15	1
16	Luis Huari Choque	Barrio San Martín, Zona Plan 3000, Sobre avenida Panamericana	71336373	17	1
17	Santiago Huari Choque	Barrio San Martín, Zona Plan 3000, Sobre avenida Panamericana	71336373	18	1
19	Daniela Belen Ancalle Sejas	Cotoca	78632222	20	1
18	Yenny Jallasa Mamani	Plan 3000	67884712	19	1
20	Melissa Sanchez	Barrio los Cañas	77451269	22	1
21	Toribia Gallego	La pampa	78852246	23	1
32	Wilber Ortiz	\N	68990086	34	1
31	Santiago Justo Huari	\N	67791098	33	1
29	Melquiades Ancalle	\N	78556200	31	1
33	Luis Morales	\N	\N	35	1
37	Pepe12 Gonzales	\N	\N	39	1
\.


--
-- Data for Name: compras; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.compras (id, fecha, estado, total, idproveedors, idvendedors) FROM stdin;
1	2025-01-02	1	150.00	1	1
2	2025-01-03	1	200.00	2	2
3	2025-01-04	1	250.00	3	2
4	2025-01-05	1	300.00	3	1
5	2025-01-06	1	350.00	3	3
6	2025-01-07	1	400.00	2	1
7	2025-01-08	1	450.00	1	3
8	2025-01-09	1	500.00	1	3
9	2025-01-10	1	550.00	2	2
10	2025-01-11	1	600.00	3	1
\.


--
-- Data for Name: cotizaciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cotizaciones (id, fecha, total, validez, idclientes) FROM stdin;
1	2025-01-05	500.00	10	1
2	2025-01-06	600.00	10	2
3	2025-01-07	700.00	10	3
4	2025-01-08	800.00	10	4
5	2025-01-09	900.00	10	5
6	2025-01-10	1000.00	10	6
7	2025-01-11	1100.00	10	7
8	2025-01-12	1200.00	10	8
9	2025-01-13	1300.00	10	9
10	2025-01-14	1400.00	10	10
\.


--
-- Data for Name: detalleaves; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.detalleaves (id, descripcion, edad) FROM stdin;
1	Sussex	0-7
2	Sussex	8-14
3	Sussex	15-28
4	Sussex	28-*
6	Rhode Island Red	8-14
7	Rhode Island Red	15-28
8	Rhode Island Red	28-*
9	Plymouth Rock	0-7
10	Plymouth Rock	8-14
11	Plymouth Rock	15-28
12	Plymouth Rock	28-*
13	Orpington	0-7
14	Orpington	8-14
15	Orpington	15-28
16	Orpington	28-*
17	Australorp	0-7
18	Australorp	8-14
19	Australorp	15-28
20	Australorp	28-*
21	Brahma (gigante)	0-7
22	Brahma (gigante)	8-14
23	Brahma (gigante)	15-28
24	Brahma (gigante)	28-*
25	Leghorn	0-7
26	Leghorn	8-14
27	Leghorn	15-28
28	Leghorn	28-*
5	Rhode Islam Red	0-7
\.


--
-- Data for Name: detallecompras; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.detallecompras (id, idcompras, idproductoalimentos, cantidad, preciounitario, subtotal) FROM stdin;
1	1	1	10	15.00	150.00
2	2	2	20	10.00	200.00
3	3	3	25	10.00	250.00
4	4	4	30	10.00	300.00
5	5	5	35	10.00	350.00
6	6	6	40	10.00	400.00
7	7	7	45	10.00	450.00
8	8	8	50	10.00	500.00
9	9	9	55	10.00	550.00
10	10	10	60	10.00	600.00
\.


--
-- Data for Name: detallecotizaciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.detallecotizaciones (id, idcotizaciones, idproductoaves, cantidad, preciounitario, subtotal) FROM stdin;
1	1	1	10	50.00	500.00
2	2	2	12	50.00	600.00
3	3	3	14	50.00	700.00
4	4	4	16	50.00	800.00
5	5	5	18	50.00	900.00
6	6	6	20	50.00	1000.00
7	7	7	22	50.00	1100.00
8	8	8	24	50.00	1200.00
9	9	9	26	50.00	1300.00
10	10	10	28	50.00	1400.00
\.


--
-- Data for Name: detallepedidos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.detallepedidos (id, idpedidos, idproductoaves, cantidad, preciounitario, subtotal) FROM stdin;
1	1	1	5	50.00	250.00
2	2	2	6	50.00	300.00
3	3	3	7	50.00	350.00
4	4	4	8	50.00	400.00
5	5	5	9	50.00	450.00
6	6	6	10	50.00	500.00
7	7	7	11	50.00	550.00
8	8	8	12	50.00	600.00
9	9	9	13	50.00	650.00
10	10	10	14	50.00	700.00
\.


--
-- Data for Name: fotoaves; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fotoaves (id, nombrefoto, idproductoaves) FROM stdin;
15	1761287187_Captura de pantalla 2025-10-22 182806.png	1
16	1761287187_foto2.png	1
\.


--
-- Data for Name: metodopagos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.metodopagos (id, descripcion) FROM stdin;
1	Efectivo
2	Tarjeta de Débito
3	Tarjeta de Crédito
4	Transferencia Bancaria
5	Yape
6	QR
7	Cheque
8	Depósito
9	Crédito
10	Pago en línea
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
\.


--
-- Data for Name: movimientoscaja; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.movimientoscaja (id, idcaja, tipo, descripcion, monto, fecha, origen, idreferencia) FROM stdin;
\.


--
-- Data for Name: pagos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pagos (id, fecha, estado, monto, idpedidos, idmetodopagos, idcaja, tipo, descripcion, origen, idreferencia) FROM stdin;
1	2025-01-05	1	250.00	1	1	\N	\N	\N	\N	\N
2	2025-01-06	1	300.00	2	2	\N	\N	\N	\N	\N
3	2025-01-07	1	350.00	3	3	\N	\N	\N	\N	\N
4	2025-01-08	1	400.00	4	4	\N	\N	\N	\N	\N
5	2025-01-09	1	450.00	5	5	\N	\N	\N	\N	\N
6	2025-01-10	1	500.00	6	6	\N	\N	\N	\N	\N
7	2025-01-11	1	550.00	7	7	\N	\N	\N	\N	\N
8	2025-01-12	1	600.00	8	8	\N	\N	\N	\N	\N
9	2025-01-13	1	650.00	9	9	\N	\N	\N	\N	\N
10	2025-01-14	1	700.00	10	10	\N	\N	\N	\N	\N
16	2025-11-04	1	200.00	\N	1	2	egreso	comida	\N	\N
\.


--
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedidos (id, fecha, estado, total, idclientes, idvendedors) FROM stdin;
1	2025-01-05	1	250.00	1	1
2	2025-01-06	1	300.00	2	2
3	2025-01-07	1	350.00	3	3
4	2025-01-08	1	400.00	4	1
5	2025-01-09	1	450.00	5	3
6	2025-01-10	1	500.00	6	3
7	2025-01-11	1	550.00	7	2
8	2025-01-12	1	600.00	8	1
9	2025-01-13	1	650.00	9	2
10	2025-01-14	1	700.00	10	1
\.


--
-- Data for Name: productoalimentos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.productoalimentos (id, nombre, precio) FROM stdin;
1	Maíz molido	50.00
2	Trigo	45.00
3	Sorgo	55.00
4	Afrecho	60.00
5	Balanceado 10kg	70.00
6	Balanceado 25kg	150.00
7	Vitaminas A	40.00
8	Vitaminas B	45.00
9	Vitaminas C	60.00
10	Mezcla Premium	200.00
\.


--
-- Data for Name: productoaves; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.productoaves (id, nombre, precio, idcategorias, iddetalleaves, cantidad) FROM stdin;
2	pollo	45.00	1	2	200
3	pollo	50.00	1	3	50
4	pollo	80.00	1	4	300
5	pollo	25.00	1	5	120
6	pollo	100.00	1	6	90
7	pollo	45.00	1	7	60
8	pollo	60.00	1	8	110
9	pollo	55.00	1	9	150
10	pollo	65.00	1	10	75
11	pollo	85.50	1	11	0
14	pollo	85.50	1	13	0
1	pollo	40.00	1	1	100
\.


--
-- Data for Name: proveedors; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.proveedors (id, nombre, direccion, telefono) FROM stdin;
1	NutriAvicola S.R.L.	Av. Alemana 123	7001111
2	Avícola Integral S.A.	Av. San Martín 45	7002222
3	Balanceados Sofía	Av. Mutualista 10	7003333
5	Alimentos Rico Ave	Av. Santos Dumont 55	7005555
6	ProAgro Bolivia	Calle Ñuflo de Chávez 77	7006666
7	AgroGrain Import	Av. Radial 10	7007777
8	VitaMix Aves	Av. 3 Pasos al Frente 88	7008888
9	Proteínas del Valle	Av. Grigotá 99	7009999
10	AgroAvícola Santa Cruz	Zona Norte 11	7010000
4	Granos del Oriente	Zona Plan 3001	7004410
\.


--
-- Data for Name: rols; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rols (id, descripcion) FROM stdin;
2	Cliente
1	Vendedor
3	Dueño del negocio
\.


--
-- Data for Name: stocks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.stocks (id, cantidad, estado, fecha, idproductoaves) FROM stdin;
1	100	n	2025-01-10	1
2	200	n	2025-01-15	2
3	50	n	2025-01-20	3
4	300	n	2025-01-22	4
5	120	n	2025-01-25	5
6	90	n	2025-01-27	6
7	60	n	2025-01-30	7
8	110	n	2025-02-01	8
9	150	n	2025-02-05	9
10	75	n	2025-02-08	10
11	10	n	2025-09-12	11
12	-10	m	2025-09-12	11
\.


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id, nombre, email, contrasenia, idrols, created_at) FROM stdin;
2	Ana López	ana.lopez@gmail.com	$2a$12$xtOONtA.bdKpOibaHkD.sugIPeb3B7Vfx.TU9Hg8yoAqQOB7J8Su6	2	2025-09-11 18:42:16.73455
3	Carlos Ramos	carlos.ramos@gmail.com	$2a$12$4HNkVcvENLlkFzvklMn7T.BtLKAG9mJJvjVQBVIYpFPKsGRdLzFxi	2	2025-09-11 18:42:16.73455
4	María Suárez	maria.suarez@gmail.com	$2a$12$uGG2nMLPey64fSlfjptoR.IQeXQUA0C/J9CywDkl0iZZsJUbDO6wy	2	2025-09-11 18:42:16.73455
5	Pedro Ortiz	pedro.ortiz@gmail.com	$2a$12$h5hYR4euUHQgVpgYg88IEOWf0wKAxEl38pxxqYtnVx8i.Fc3HCoLG	2	2025-09-11 18:42:16.73455
6	Lucía García	lucia.garcia@gmail.com	$2a$12$Vo1CDmDPuRH6GS8mxyzm9OVN5S/S.tucVmdYcgc/Ihtg5AEp0PN4e	2	2025-09-11 18:42:16.73455
7	Roberto Díaz	roberto.diaz@gmail.com	$2a$12$pH5PY/vFriMHHMt5ZOBESOAoZJMlth6uRp4Q/LQeMUXzDVcLGT30C	2	2025-09-11 18:42:16.73455
8	Sofía Vargas	sofia.vargas@gmail.com	$2a$12$AphnAQInVVj0qptCBXVTzuVIhxoGNVJIGbvNYunrV2to6GLTWLnky	2	2025-09-11 18:42:16.73455
9	Daniel Guzmán	daniel.guzman@gmail.com	$2a$12$DMNSxHRX2sW62YY4i14GceP9.gfYT4EtDkebkDuNJpS59md97cmh2	2	2025-09-11 18:42:16.73455
10	Laura Torres	laura.torres@gmail.com	$2a$12$SxyMTzaZtnXU6HIruVmQq.kkDWvdhL036zPw0fPA4FLblpKwlzLim	2	2025-09-11 18:42:16.73455
15	Asher Bustillos	asher.bustillos@gmail.com	$2a$12$NlRCrL1UGBD25o.QiyYd2.xh4lXzfQqLbVClDNLqLqita8qHhgQu2	2	2025-10-02 14:26:58.978121
17	Luis Huari Choque	luis.huari29@gmail.com	$2a$12$VO2gTNj4VSezKnmjEDh1cenC59cpPEQLuKO6tq5Dm.2oevTmKPEUC	2	2025-10-02 15:58:15.346144
18	Santiago Huari Choque	santiago.huari29@gmail.com	$2a$12$GXTWfpigbbDyS23Qia18oeWX06szLhDZuYN.IQ3btHSCJXBtuIMwe	2	2025-10-02 16:00:35.222807
16	Cristian Huari	cristoteam29@gmail.com	$2a$12$PK64W2U173kk9vT.fXAMcOklNocOtZXUDVqM5.jaxXlblrSMEFbHS	3	2025-10-02 14:32:40.421708
21	Roy Barrero	roy.barrero@gmail.com	$2a$12$AD98OAVcxWfEvBgc9sGnxu775WPhJCM7HguDWq8Jb2/1jDuuSfEG2	1	2025-10-02 17:43:48.599009
20	Daniela Belen Ancalle Sejas	daniela.belen@gmail.com	$2a$12$27XHcvVfkHqsXkPZqrMbw.G//6u3sdGgBN4K9w.6ubA04PKccHZZC	1	2025-10-02 16:24:30.543493
19	Yenny Jallasa Mamani	yenny.jallasa@gmail.com	$2a$12$p4F/E29KsBbz8YkP1RlxSeZYWh/sSIULws7NoQWUdImmiUYYPSFVy	2	2025-10-02 16:15:15.788487
37	Pepe Gonzales	pepe@gmail.com	$2a$12$zACEfyJWAxiMKKSmCOdSKephGT/dpZb.xxk/ZElSJhCd2lkQrT2pS	2	2025-10-23 21:52:14.537225
22	Melissa Sanchez	mely@gmail.com	$2a$12$C/e7ocYOf0k/.vzGzs8VV.RJdrNURMmgfHI8ykcwXUmAHe/H9qq1u	2	2025-10-02 22:59:00.829061
23	Toribia Gallego	toribia@gmail.com	$2a$12$eHkAORTD27QM..EL3a79rO2EX8TSlAZzRMFaqlLSxlLf/5ZxxDl82	2	2025-10-02 23:01:34.720423
24	saturnino mamani	saturno@gmail.com	$2a$12$Jty7fptW20DuQlJnWYOQP.FKW6PTOb.640onyglBZM4jYAZB85AIi	2	2025-10-02 23:08:09.373352
38	Pepe1 Gonzales	pep1e@gmail.com	$2a$12$u5R/MdFgE4rOhZzdZnvS2.7Txe.pzppDWNPV/0ffi9hGTCETYs8Pe	2	2025-10-23 21:58:53.239201
39	Pepe12 Gonzales	pepe12@gmail.com	$2a$12$ApayBrKcBABpzmltvihrZ.gylyEh3PChd5MJZQZJ7jrAXBeMfOMc2	2	2025-10-23 22:00:29.629588
1	Limberg Huari	limberg.huari@gmail.com	$2a$12$CNt7HNlB3aXPpu7yvWiC2.6FiU8AFdaR.LlldMFMvUljB0va6Sydi	1	2025-09-11 18:42:16.73455
26	Samuel Torrico	samuel@gmail.com	$2a$12$JHi0OOK25q9weV7zKqdaTO9uYGrJFGd/sMhVqjuh3zxivFk2UQ4j2	2	2025-10-02 23:28:41.075029
25	Belisario Landa	beli.landa@gmail.com	$2a$12$qj98N63kbD8kH6yK.VxbnOxGKPDJCSnrvM3J8CPsIKlssgYWqIduu	2	2025-10-02 23:17:38.941907
30	Jose Aguirre	jose@gmail.com	$2a$12$435SR6hks6p.viZ7LcklpOXWF5oSL7kTD4wxWafJocWm0gQWgoA6G	2	2025-10-19 21:06:35.071247
33	Santiago Justo Huari	santiagojusto@gmail.com	$2a$12$jgAbjhcU9VQGkoYxqc4XyeTQXgd6Ra1USkZH2aj/.6fXHMmF22q/G	2	2025-10-19 22:08:45.281598
31	Melquiades Ancalle	melquiades@gmail.com	$2a$12$4S4m5d88swpKx3NXk2FzP.gLT6qxr8yEEAwyTeyrV2Y7ccdnO6SJW	2	2025-10-19 21:11:12.045146
35	Luis Morales	luismorales@gmail.com	$2a$12$9.ow7wNpsHUZX7cArSfAx.qGA4ywVWz9OqaLe4LsQ4Fb9Ydjf14tW	2	2025-10-19 22:29:05.429637
36	Limberg Huari Choque	limberg6@gmail.com	$2a$12$5ZezdTYm7UJ3ODhEAwW1oeGRM9mFPjYppIlAJf/pJaUhmZJy9CVW2	1	2025-10-19 23:42:32.855727
\.


--
-- Data for Name: vendedors; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.vendedors (id, nombre, direccion, telefono, email, idusuarios, activo) FROM stdin;
2	Roy Barrero	Av. Busch 21	7422222	roybarrero@gmail.com	\N	1
3	Melissa Sánchez	Calle Sucre 10	7433333	melissasanchez@gmail.com	\N	1
13	jonathan Chambi	\N	\N	jonathan@gmail.com	\N	1
14	Alex Junior Ticona	\N	\N	alex.junior@gmail.com	\N	1
15	Juan Padilla	\N	\N	juan@gmail.com	\N	1
1	Limberg Huari	Zona Plan 3000	7411111	limberg.huari@gmail.com	1	1
17	Limberg Huari Choque	\N	\N	limberg6@gmail.com	36	0
11	Cristian Huari	Barrio San Martín, Zona Plan 3000, Sobre avenida Panamericana	71336373	cristoteam29@gmail.com	16	1
12	Roy Barrero	Zona Norte, Barrio los norteños	63224700	roy.barrero@gmail.com	21	1
\.


--
-- Name: auditorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auditorias_id_seq', 56, true);


--
-- Name: cajas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cajas_id_seq', 2, true);


--
-- Name: categorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categorias_id_seq', 13, true);


--
-- Name: clientes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clientes_id_seq', 37, true);


--
-- Name: compras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.compras_id_seq', 1, false);


--
-- Name: cotizaciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cotizaciones_id_seq', 10, true);


--
-- Name: detalleaves_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.detalleaves_id_seq', 5, true);


--
-- Name: detallecompras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.detallecompras_id_seq', 1, false);


--
-- Name: detallecotizaciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.detallecotizaciones_id_seq', 10, true);


--
-- Name: detallepedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.detallepedidos_id_seq', 10, true);


--
-- Name: fotoaves_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fotoaves_id_seq', 16, true);


--
-- Name: metodopagos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.metodopagos_id_seq', 10, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 3, true);


--
-- Name: movimientoscaja_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.movimientoscaja_id_seq', 1, false);


--
-- Name: pagos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pagos_id_seq', 16, true);


--
-- Name: pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedidos_id_seq', 10, true);


--
-- Name: productoalimentos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.productoalimentos_id_seq', 10, true);


--
-- Name: productoaves_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.productoaves_id_seq', 14, true);


--
-- Name: proveedores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.proveedores_id_seq', 1, false);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 4, true);


--
-- Name: stocks_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.stocks_id_seq', 17, true);


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 39, true);


--
-- Name: vendedores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vendedores_id_seq', 17, true);


--
-- Name: auditorias auditorias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auditorias
    ADD CONSTRAINT auditorias_pkey PRIMARY KEY (id);


--
-- Name: cajas cajas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cajas
    ADD CONSTRAINT cajas_pkey PRIMARY KEY (id);


--
-- Name: categorias categorias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id);


--
-- Name: clientes clientes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_pkey PRIMARY KEY (id);


--
-- Name: compras compras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.compras
    ADD CONSTRAINT compras_pkey PRIMARY KEY (id);


--
-- Name: cotizaciones cotizaciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cotizaciones
    ADD CONSTRAINT cotizaciones_pkey PRIMARY KEY (id);


--
-- Name: detalleaves detalleaves_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalleaves
    ADD CONSTRAINT detalleaves_pkey PRIMARY KEY (id);


--
-- Name: detallecompras detallecompras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallecompras
    ADD CONSTRAINT detallecompras_pkey PRIMARY KEY (id);


--
-- Name: detallecotizaciones detallecotizaciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallecotizaciones
    ADD CONSTRAINT detallecotizaciones_pkey PRIMARY KEY (id);


--
-- Name: detallepedidos detallepedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallepedidos
    ADD CONSTRAINT detallepedidos_pkey PRIMARY KEY (id);


--
-- Name: fotoaves fotoaves_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fotoaves
    ADD CONSTRAINT fotoaves_pkey PRIMARY KEY (id);


--
-- Name: productoaves iddetalleaves; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productoaves
    ADD CONSTRAINT iddetalleaves UNIQUE (iddetalleaves);


--
-- Name: metodopagos metodopagos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.metodopagos
    ADD CONSTRAINT metodopagos_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: movimientoscaja movimientoscaja_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimientoscaja
    ADD CONSTRAINT movimientoscaja_pkey PRIMARY KEY (id);


--
-- Name: pagos pagos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagos
    ADD CONSTRAINT pagos_pkey PRIMARY KEY (id);


--
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id);


--
-- Name: productoalimentos productoalimentos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productoalimentos
    ADD CONSTRAINT productoalimentos_pkey PRIMARY KEY (id);


--
-- Name: productoaves productoaves_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productoaves
    ADD CONSTRAINT productoaves_pkey PRIMARY KEY (id);


--
-- Name: proveedors proveedores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proveedors
    ADD CONSTRAINT proveedores_pkey PRIMARY KEY (id);


--
-- Name: rols roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rols
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: stocks stocks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.stocks
    ADD CONSTRAINT stocks_pkey PRIMARY KEY (id);


--
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- Name: vendedors vendedores_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vendedors
    ADD CONSTRAINT vendedores_email_key UNIQUE (email);


--
-- Name: vendedors vendedores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vendedors
    ADD CONSTRAINT vendedores_pkey PRIMARY KEY (id);


--
-- Name: stocks trg_actualizar_cantidad; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trg_actualizar_cantidad BEFORE INSERT ON public.stocks FOR EACH ROW EXECUTE FUNCTION public.actualizar_cantidad_productoaves();


--
-- Name: usuarios trg_cifrar_contrasenia; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trg_cifrar_contrasenia BEFORE INSERT OR UPDATE ON public.usuarios FOR EACH ROW EXECUTE FUNCTION public.cifrar_contrasenia();


--
-- Name: cajas fk_cajas_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cajas
    ADD CONSTRAINT fk_cajas_usuarios FOREIGN KEY (idusuarios) REFERENCES public.usuarios(id);


--
-- Name: compras fk_compras_proveedores; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.compras
    ADD CONSTRAINT fk_compras_proveedores FOREIGN KEY (idproveedors) REFERENCES public.proveedors(id);


--
-- Name: compras fk_compras_vendedors; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.compras
    ADD CONSTRAINT fk_compras_vendedors FOREIGN KEY (idvendedors) REFERENCES public.vendedors(id);


--
-- Name: cotizaciones fk_cotizaciones_clientes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cotizaciones
    ADD CONSTRAINT fk_cotizaciones_clientes FOREIGN KEY (idclientes) REFERENCES public.clientes(id);


--
-- Name: detallecompras fk_detallecompras_compras; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallecompras
    ADD CONSTRAINT fk_detallecompras_compras FOREIGN KEY (idcompras) REFERENCES public.compras(id);


--
-- Name: detallecompras fk_detallecompras_productoalimentos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallecompras
    ADD CONSTRAINT fk_detallecompras_productoalimentos FOREIGN KEY (idproductoalimentos) REFERENCES public.productoalimentos(id);


--
-- Name: detallecotizaciones fk_detallecotizaciones_cotizaciones; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallecotizaciones
    ADD CONSTRAINT fk_detallecotizaciones_cotizaciones FOREIGN KEY (idcotizaciones) REFERENCES public.cotizaciones(id);


--
-- Name: detallepedidos fk_detallepedidos_pedidos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detallepedidos
    ADD CONSTRAINT fk_detallepedidos_pedidos FOREIGN KEY (idpedidos) REFERENCES public.pedidos(id);


--
-- Name: fotoaves fk_fotoaves_productoaves; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fotoaves
    ADD CONSTRAINT fk_fotoaves_productoaves FOREIGN KEY (idproductoaves) REFERENCES public.productoaves(id) ON DELETE CASCADE;


--
-- Name: pagos fk_pagos_metodopagos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagos
    ADD CONSTRAINT fk_pagos_metodopagos FOREIGN KEY (idmetodopagos) REFERENCES public.metodopagos(id);


--
-- Name: pagos fk_pagos_pedidos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagos
    ADD CONSTRAINT fk_pagos_pedidos FOREIGN KEY (idpedidos) REFERENCES public.pedidos(id);


--
-- Name: pedidos fk_pedidos_clientes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT fk_pedidos_clientes FOREIGN KEY (idclientes) REFERENCES public.clientes(id);


--
-- Name: pedidos fk_pedidos_vendedores; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT fk_pedidos_vendedores FOREIGN KEY (idvendedors) REFERENCES public.vendedors(id);


--
-- Name: productoaves fk_productoaves_categorias; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productoaves
    ADD CONSTRAINT fk_productoaves_categorias FOREIGN KEY (idcategorias) REFERENCES public.categorias(id);


--
-- Name: usuarios fk_usuarios_roles; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT fk_usuarios_roles FOREIGN KEY (idrols) REFERENCES public.rols(id);


--
-- Name: movimientoscaja movimientoscaja_idcaja_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimientoscaja
    ADD CONSTRAINT movimientoscaja_idcaja_fkey FOREIGN KEY (idcaja) REFERENCES public.cajas(id) ON DELETE CASCADE;


--
-- Name: pagos pagos_idcaja_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pagos
    ADD CONSTRAINT pagos_idcaja_fkey FOREIGN KEY (idcaja) REFERENCES public.cajas(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict 2XPLgKR1ytHZFytl4nnttqITaVxx47aeLdzyqyygLgwMEDwNcoANZSuwuCia53o

