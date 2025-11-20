# 🚀 Guía de Inicio - Dewey Accounts

**Versión:** 2.2.0  
**Última actualización:** 19 de Noviembre de 2025

---

## ⚡ Inicio Rápido (5 minutos)

### 1. Verificar Requisitos

```bash
# PHP 8.2+
php -v

# MySQL 5.7+
mysql --version

# Node.js 18+
node -v
npm -v
```

### 2. Instalar Dependencias

```bash
# En la carpeta del proyecto
cd d:\CuentasCobro

# Instalar PHP
composer install

# Instalar Node.js
npm install
```

### 3. Configurar Entorno

```bash
# Copiar archivo de configuración
copy .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Base de Datos

```bash
# Crear base de datos en MySQL
mysql -u root -p
CREATE DATABASE dewey_accounts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit

# Editar .env con credenciales
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dewey_accounts
DB_USERNAME=root
DB_PASSWORD=

# Ejecutar migraciones
php artisan migrate
php artisan db:seed
```

### 5. Compilar Assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 6. Iniciar Servidor

```bash
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Vite (si usas dev)
npm run dev
```

### 7. Acceder al Sistema

```
URL: http://127.0.0.1:8000
Usuario: admin@sistema.com
Contraseña: admin123456
```

---

## 📁 Estructura del Proyecto

```
Dewey Accounts/
├── app/                  # Código del servidor
│   ├── Http/
│   │   ├── Controllers/  # Controladores
│   │   └── Middleware/   # Middleware de roles
│   └── Models/          # Modelos de base de datos
├── database/            # Migraciones y seeders
├── resources/
│   ├── views/           # Vistas Blade
│   └── css/             # Estilos
├── public/              # Archivos públicos
├── routes/              # Definición de rutas
├── storage/             # Archivos generados
├── vendor/              # Dependencias (no editar)
└── .env                 # Configuración (IMPORTANTE)
```

---

## 🔑 Usuarios por Defecto

Después de ejecutar `php artisan db:seed`:

| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@sistema.com | admin123456 | super_admin |
| alcalde@sistema.com | password | alcalde |
| ordenador@sistema.com | password | ordenador_gasto |
| contratacion@sistema.com | password | contratacion |
| supervisor@sistema.com | password | supervisor |
| tesoreria@sistema.com | password | tesoreria |
| contratista@sistema.com | password | contratista |

**⚠️ IMPORTANTE:** Cambiar contraseñas después de la instalación.

---

## 🛠️ Comandos Útiles

### Desarrollo

```bash
# Servidor de desarrollo
php artisan serve

# Ver rutas disponibles
php artisan route:list

# Limpiar caché
php artisan optimize:clear

# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback
```

### Base de Datos

```bash
# Ejecutar seeders
php artisan db:seed

# Refrescar base de datos
php artisan migrate:fresh --seed

# Crear respaldo
mysqldump -u root -p dewey_accounts > respaldo.sql
```

### Compilación

```bash
# Desarrollo (hot-reload)
npm run dev

# Producción
npm run build

# Ver logs en tiempo real
php artisan pail
```

---

## 🔍 Verificar Estado del Sistema

```bash
# Ver información del proyecto
php artisan about

# Listar migraciones ejecutadas
php artisan migrate:status

# Ver almacenamiento disponible
php artisan storage:link
```

---

## ⚙️ Configuración Importante

### Archivo `.env`

```env
# Aplicación
APP_NAME="Dewey Accounts"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Base de Datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dewey_accounts
DB_USERNAME=root
DB_PASSWORD=

# Email (SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

# Seguridad
SANCTUM_STATEFUL_DOMAINS=127.0.0.1:8000
SESSION_DOMAIN=127.0.0.1
```

---

## 🔐 Seguridad

### Cambiar Contraseña de Admin

```bash
# Acceder a Tinker
php artisan tinker

# Cambiar contraseña
$user = App\Models\User::find(1);
$user->password = Hash::make('nueva_contraseña');
$user->save();
exit
```

### Activar HTTPS (Producción)

```bash
# Forzar HTTPS en app.php
'url' => 'https://tu-dominio.com',
'force' => true,
```

---

## 📊 Solución de Problemas

### "No se encuentra la base de datos"

```bash
# Verificar que MySQL está corriendo
# Windows: php artisan migrate --force
# Si persiste: crear base de datos manualmente y luego migrar
```

### "Página en blanco"

```bash
# Verificar logs
tail -f storage/logs/laravel.log

# Limpiar caché
php artisan cache:clear
php artisan view:clear
```

### "Permisos denegados en storage"

```bash
# Windows
# Asegurarse que el usuario tiene permisos de escritura

# Linux/Mac
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### "Error 419 en formularios"

```bash
# CSRF token inválido - regenerar
php artisan cache:clear
php artisan view:clear
```

---

## 📱 Acceso por Diferentes Roles

### Contratista

1. Crear nueva cuenta de cobro
2. Ver estado de sus cuentas
3. Descargar PDFs
4. Recibir notificaciones

**Ruta:** `/cuentas_cobro/create`

### Supervisor

1. Revisar cuentas de cobro
2. Validar documentos
3. Enviar para aprobación
4. Rechazar si falta información

**Ruta:** `/cuentas_cobro/index`

### Ordenador del Gasto

1. Validar presupuesto
2. Verificar disponibilidad
3. Enviar a contratación
4. Devolver para corrección

**Ruta:** `/cuentas_cobro/index`

### Contratación

1. Revisar contratos
2. Validar información
3. Enviar a alcalde
4. Devolver al contratista

**Ruta:** `/cuentas_cobro/index`

### Alcalde

1. Aprobación final
2. Enviar a tesorería
3. Rechazar cuentas
4. Ver reportes

**Ruta:** `/cuentas_cobro/index`

### Tesorería

1. Registrar pagos
2. Adjuntar comprobantes
3. Completar proceso
4. Generar reportes

**Ruta:** `/cuentas_cobro/pagos`

### Super Admin

1. Gestionar usuarios
2. Asignar roles
3. Ver reportes globales
4. Configurar sistema

**Ruta:** `/admin/users`

---

## 📚 Documentación Completa

Para más información, consulta:

- [MANUAL_INSTALACION_TERCEROS.md](MANUAL_INSTALACION_TERCEROS.md) - Instalación detallada
- [ORGANIZACION_PROYECTO.md](ORGANIZACION_PROYECTO.md) - Estructura del código
- [PROCESO_COMPLETO_CUENTAS_COBRO.md](PROCESO_COMPLETO_CUENTAS_COBRO.md) - Flujo de trabajo
- [VERIFICACION_SISTEMA.md](VERIFICACION_SISTEMA.md) - Estado del sistema

---

## ✅ Checklist de Verificación

Después de instalar, verifica:

- [ ] Servidor Laravel corriendo en http://127.0.0.1:8000
- [ ] Puedes iniciar sesión como admin@sistema.com
- [ ] Dashboard carga correctamente
- [ ] Puedes crear un usuario
- [ ] Puedes asignar un rol
- [ ] Las vistas se ven con el diseño Apple (blanco, azul, iconos redondeados)
- [ ] Las notificaciones funcionan
- [ ] Puedes crear una cuenta de cobro
- [ ] El PDF se genera correctamente
- [ ] Puedes navegar a todos los módulos

---

## 🆘 Soporte Rápido

### Errores Comunes

**Error 1:** `SQLSTATE[HY000]: General error`
- **Solución:** `php artisan migrate:fresh --seed`

**Error 2:** `Class not found`
- **Solución:** `composer dump-autoload`

**Error 3:** `Module not found`
- **Solución:** `npm install && npm run build`

**Error 4:** `Port 8000 already in use`
- **Solución:** `php artisan serve --port=8001`

### Contacto

Para más ayuda, consulta la documentación o contacta al equipo de desarrollo.

---

**¡Bienvenido a Dewey Accounts! 🎉**

Sistema de gestión de cuentas de cobro - Moderno, Seguro, Profesional.
