# KontaCash

Sistema administrativo de control de ingresos y gastos desarrollado con **Laravel 12**, **MySQL** y **Bootstrap 5**.

## Requisitos

* PHP 8.2+
* Composer
* MySQL / MariaDB

## Instalación

1. Clonar o ubicarse en el proyecto e instalar dependencias:

```bash
cd kontacash
composer install
```

2. Configurar `.env` con los datos de MySQL (base de datos `kontacash`):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kontacash
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_TABLE=session
```

3. Generar clave, migrar y cargar datos iniciales:

```bash
php artisan key:generate
php artisan migrate --seed
```

4. Iniciar servidor local:

```bash
php artisan serve
```

Abrir `http://127.0.0.1:8000`.

## Acceso inicial

* **Correo:** `admin@kontacash.com`
* **Contraseña:** `password`

*(No existe registro público; los administradores se crean desde el módulo **Administradores**).*

## Módulos

* **Inicio (`/dashboard`):** Balance total, ingresos/gastos del mes, saldo actual por cuenta y los 10 movimientos recientes.
* **Movimientos (`/movements`):** Registro de ingresos (`kind = 1`) y gastos (`kind = 2`), filtros por descripción, tipo y cuenta.
* **Cuentas (`/accounts`):** Cuentas bancarias con saldo calculado (`initial_balance + ingresos - gastos`).
* **Categorías (`/categories`):** Clasificación separada para ingresos y gastos.
* **Formas de pago (`/payment-methods`):** Catálogo de métodos de pago.
* **Personas (`/people`):** Clientes, proveedores o contactos relacionados.
* **Administradores (`/users`):** Gestión de usuarios administradores.

## Tablas principales (MySQL)

* `user`: Administradores del sistema.
* `account`: Cuentas bancarias y saldo inicial.
* `category`: Categorías (`kind`: `1` ingreso, `2` gasto).
* `payment_method`: Formas de pago.
* `person`: Personas relacionadas.
* `movement`: Ingresos y gastos asociados a cuenta, categoría, forma de pago, persona (opcional) y administrador.

## Pruebas

```bash
php artisan test
```
