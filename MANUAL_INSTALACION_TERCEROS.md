# 🚀 Manual de Instalación y Ejecución - Sistema de Cuentas de Cobro

## 📋 Tabla de Contenidos

1. [Requisitos del Sistema](#requisitos-del-sistema)
2. [Instalación de Prerrequisitos](#instalación-de-prerrequisitos)
3. [Instalación del Sistema](#instalación-del-sistema)
4. [Configuración de la Base de Datos](#configuración-de-la-base-de-datos)
5. [Configuración del Sistema](#configuración-del-sistema)
6. [Ejecución del Sistema](#ejecución-del-sistema)
7. [Acceso al Sistema](#acceso-al-sistema)
8. [Solución de Problemas Comunes](#solución-de-problemas-comunes)
9. [Preguntas Frecuentes](#preguntas-frecuentes)

---

## 📦 Requisitos del Sistema

### Requisitos Mínimos de Hardware:
- **Procesador:** Intel Core i3 o equivalente (2.0 GHz)
- **Memoria RAM:** 4 GB mínimo (8 GB recomendado)
- **Espacio en disco:** 2 GB libres
- **Sistema Operativo:** Windows 10/11, macOS, o Linux

### Software Requerido:
- ✅ XAMPP (incluye Apache, MySQL, PHP)
- ✅ Composer (gestor de dependencias PHP)
- ✅ Node.js y NPM (para recursos front-end)
- ✅ Navegador web moderno (Chrome, Firefox, Edge)

---

## 🔧 Instalación de Prerrequisitos

### Paso 1: Instalar XAMPP

#### Windows:
1. Descarga XAMPP desde: https://www.apachefriends.org/
2. Ejecuta el instalador descargado (`xampp-windows-x64-8.2.x-installer.exe`)
3. Durante la instalación:
   - ✅ Marca: Apache
   - ✅ Marca: MySQL
   - ✅ Marca: PHP
   - ✅ Marca: phpMyAdmin
4. Instala en la ruta por defecto: `C:\xampp`
5. Al finalizar, inicia el **Panel de Control de XAMPP**

#### macOS:
1. Descarga XAMPP para Mac desde: https://www.apachefriends.org/
2. Abre el archivo `.dmg` descargado
3. Arrastra XAMPP a la carpeta de Aplicaciones
4. Ejecuta XAMPP desde Aplicaciones

#### Linux:
```bash
wget https://www.apachefriends.org/xampp-files/8.2.x/xampp-linux-x64-8.2.x-installer.run
chmod +x xampp-linux-x64-8.2.x-installer.run
sudo ./xampp-linux-x64-8.2.x-installer.run
```

### Paso 2: Instalar Composer

#### Windows:
1. Descarga Composer desde: https://getcomposer.org/download/
2. Ejecuta el instalador `Composer-Setup.exe`
3. El instalador detectará automáticamente PHP de XAMPP
4. Completa la instalación con las opciones por defecto
5. Abre una nueva terminal y verifica:
   ```powershell
   composer --version
   ```

#### macOS/Linux:
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

### Paso 3: Instalar Node.js y NPM

#### Windows:
1. Descarga Node.js desde: https://nodejs.org/
2. Ejecuta el instalador (versión LTS recomendada)
3. Sigue las instrucciones del asistente
4. Verifica la instalación en PowerShell:
   ```powershell
   node --version
   npm --version
   ```

#### macOS (con Homebrew):
```bash
brew install node
node --version
npm --version
```

#### Linux (Ubuntu/Debian):
```bash
curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
sudo apt-get install -y nodejs
node --version
npm --version
```

---

## 📥 Instalación del Sistema

### Paso 1: Obtener los Archivos del Sistema

Tienes dos opciones:

#### Opción A: Descargar archivo ZIP
1. Descarga el archivo ZIP del sistema proporcionado
2. Extrae el contenido a: `C:\xampp\htdocs\CuentasCobro` (Windows)
3. O a: `/Applications/XAMPP/htdocs/CuentasCobro` (macOS)

#### Opción B: Clonar desde repositorio Git (si aplica)
```bash
cd C:\xampp\htdocs
git clone [URL_DEL_REPOSITORIO] CuentasCobro
cd CuentasCobro
```

### Paso 2: Instalar Dependencias PHP

Abre una terminal (PowerShell en Windows) y ejecuta:

```powershell
# Navegar a la carpeta del proyecto
cd C:\xampp\htdocs\CuentasCobro

# Instalar dependencias de Composer
composer install
```

**Nota:** Este proceso puede tomar 5-10 minutos. Espera a que termine completamente.

### Paso 3: Instalar Dependencias Node.js

En la misma terminal, ejecuta:

```powershell
# Instalar dependencias de Node
npm install

# Compilar recursos front-end
npm run build
```

---

## 🗄️ Configuración de la Base de Datos

### Paso 1: Iniciar Servicios de XAMPP

1. Abre el **Panel de Control de XAMPP**
2. Inicia los siguientes servicios:
   - ✅ **Apache** (clic en "Start")
   - ✅ **MySQL** (clic en "Start")
3. Verifica que ambos servicios muestren **"Running"** en verde

### Paso 2: Acceder a phpMyAdmin

1. Abre tu navegador web
2. Ve a: http://localhost/phpmyadmin
3. Deberías ver la interfaz de phpMyAdmin

### Paso 3: Crear la Base de Datos

En phpMyAdmin:

1. Haz clic en la pestaña **"SQL"** en la parte superior
2. Copia y pega el siguiente código:

```sql
CREATE DATABASE cuentas_cobro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Haz clic en el botón **"Continuar"** o **"Go"**
4. Deberías ver el mensaje: "La consulta se ejecutó correctamente"

### Paso 4: Importar la Estructura de la Base de Datos

**Opción A: Si tienes el archivo respaldo.sql**

1. En phpMyAdmin, selecciona la base de datos `cuentas_cobro` (clic en el nombre en el panel izquierdo)
2. Haz clic en la pestaña **"Importar"**
3. Haz clic en **"Seleccionar archivo"**
4. Busca y selecciona el archivo `respaldo.sql` del proyecto
5. Haz clic en **"Continuar"** al final de la página
6. Espera a que la importación termine (puede tomar 1-2 minutos)

**Opción B: Si NO tienes respaldo.sql (usar migraciones de Laravel)**

Abre la terminal en la carpeta del proyecto y ejecuta:

```powershell
php artisan migrate
```

Este comando creará todas las tablas automáticamente.

### Paso 5: Poblar la Base de Datos con Datos Iniciales

Ejecuta en la terminal:

```powershell
php artisan db:seed
```

Esto creará:
- Roles del sistema (Contratista, Supervisor, Ordenador, Contratación, Alcalde, Tesorería, Super Admin)
- Permisos
- Usuario administrador por defecto

---

## ⚙️ Configuración del Sistema

### Paso 1: Crear el Archivo de Configuración

El proyecto incluye un archivo `.env.example` que debes copiar:

```powershell
# Copiar el archivo de ejemplo
copy .env.example .env
```

O en macOS/Linux:
```bash
cp .env.example .env
```

### Paso 2: Configurar el Archivo .env

Abre el archivo `.env` con un editor de texto (Notepad++, Visual Studio Code, etc.) y configura:

```env
# CONFIGURACIÓN DE LA APLICACIÓN
APP_NAME="Sistema de Cuentas de Cobro"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=America/Bogota
APP_URL=http://localhost/CuentasCobro/public

# CONFIGURACIÓN DE LA BASE DE DATOS
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cuentas_cobro
DB_USERNAME=root
DB_PASSWORD=

# CONFIGURACIÓN DE SESIÓN
SESSION_DRIVER=file
SESSION_LIFETIME=120

# CONFIGURACIÓN DE CACHÉ
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

**Notas importantes:**
- `DB_PASSWORD=` - Déjalo vacío si XAMPP no tiene contraseña configurada
- `APP_URL` - Ajusta si instalaste en una ruta diferente

### Paso 3: Generar la Clave de Aplicación

En la terminal, ejecuta:

```powershell
php artisan key:generate
```

Este comando generará una clave única para tu instalación en el archivo `.env`.

### Paso 4: Configurar Permisos de Carpetas (Importante)

#### Windows (PowerShell como Administrador):
```powershell
# Dar permisos de escritura a carpetas de almacenamiento
icacls "storage" /grant Users:F /T
icacls "bootstrap\cache" /grant Users:F /T
```

#### macOS/Linux:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Paso 5: Limpiar Caché (Opcional pero Recomendado)

```powershell
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## 🎮 Ejecución del Sistema

### Método 1: Usar el Servidor de Desarrollo de Laravel

Esta es la forma más sencilla para desarrollo:

```powershell
# Navegar a la carpeta del proyecto
cd C:\xampp\htdocs\CuentasCobro

# Iniciar el servidor de desarrollo
php artisan serve
```

Verás un mensaje como:
```
Starting Laravel development server: http://127.0.0.1:8000
```

**Accede al sistema en tu navegador:** http://127.0.0.1:8000

### Método 2: Usar XAMPP (Apache)

Si prefieres usar Apache de XAMPP:

1. Asegúrate de que Apache esté corriendo en el Panel de Control de XAMPP
2. Abre tu navegador
3. Ve a: http://localhost/CuentasCobro/public

### Método 3: Configurar Virtual Host (Recomendado para Producción)

#### Windows - Editar httpd-vhosts.conf:

1. Abre: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Agrega al final:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/CuentasCobro/public"
    ServerName cuentascobro.local
    <Directory "C:/xampp/htdocs/CuentasCobro/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Edita el archivo hosts: `C:\Windows\System32\drivers\etc\hosts` (como Administrador)
4. Agrega:
```
127.0.0.1    cuentascobro.local
```

5. Reinicia Apache desde el Panel de XAMPP
6. Accede desde: http://cuentascobro.local

---

## 🔐 Acceso al Sistema

### Credenciales por Defecto

Una vez que el sistema esté corriendo, accede con:

**Usuario Super Administrador:**
- **Email:** admin@sistema.com
- **Contraseña:** admin123456

**Usuario de Prueba (Contratista):**
- **Email:** contratista@test.com
- **Contraseña:** password

**Usuario de Prueba (Supervisor):**
- **Email:** supervisor@test.com
- **Contraseña:** password

**Importante:** ⚠️ **Cambia estas contraseñas inmediatamente después del primer inicio de sesión.**

### Primer Inicio de Sesión

1. Abre tu navegador
2. Ve a la URL configurada (ej: http://127.0.0.1:8000)
3. Verás la página de inicio de sesión
4. Ingresa las credenciales del Super Administrador
5. Una vez dentro, ve a **Administración** > **Usuarios**
6. Cambia la contraseña del administrador
7. Crea nuevos usuarios según sea necesario

---

## 🛠️ Solución de Problemas Comunes

### Problema 1: "No se puede conectar a la base de datos"

**Soluciones:**
1. Verifica que MySQL esté corriendo en XAMPP (luz verde)
2. Verifica las credenciales en el archivo `.env`:
   ```env
   DB_HOST=127.0.0.1
   DB_DATABASE=cuentas_cobro
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Prueba la conexión en phpMyAdmin: http://localhost/phpmyadmin
4. Si no puedes acceder, reinicia MySQL desde XAMPP

### Problema 2: "500 | Server Error"

**Soluciones:**
1. Verifica que ejecutaste: `php artisan key:generate`
2. Limpia el caché:
   ```powershell
   php artisan config:clear
   php artisan cache:clear
   ```
3. Verifica permisos de carpetas `storage` y `bootstrap/cache`
4. Revisa el archivo de log: `storage/logs/laravel.log`

### Problema 3: "Composer not found" o "PHP not found"

**Soluciones:**
1. Verifica la instalación:
   ```powershell
   php --version
   composer --version
   ```
2. Si no se reconocen, agrega a las Variables de Entorno del Sistema:
   - `C:\xampp\php`
   - `C:\ProgramData\ComposerSetup\bin`
3. Reinicia la terminal después de agregar las variables

### Problema 4: "Class not found" o "Target class does not exist"

**Soluciones:**
```powershell
composer dump-autoload
php artisan clear-compiled
php artisan optimize:clear
```

### Problema 5: La página no carga estilos (sin CSS)

**Soluciones:**
1. Verifica que ejecutaste: `npm run build`
2. Si no funciona, ejecuta:
   ```powershell
   npm run dev
   ```
3. Verifica que la carpeta `public/build` exista
4. Limpia la caché del navegador (Ctrl + Shift + R)

### Problema 6: "Port 80 already in use" (Puerto ocupado)

**Soluciones:**

**Opción A:** Usar el servidor de Laravel (puerto 8000):
```powershell
php artisan serve
```

**Opción B:** Cambiar el puerto de Apache:
1. Abre: `C:\xampp\apache\conf\httpd.conf`
2. Busca: `Listen 80`
3. Cambia a: `Listen 8080`
4. Reinicia Apache
5. Accede: http://localhost:8080/CuentasCobro/public

**Opción C:** Detén el servicio que usa el puerto 80:
```powershell
# Ver qué está usando el puerto 80
netstat -ano | findstr :80

# Detener Skype, IIS u otro servicio si está usando el puerto
```

### Problema 7: "SQLSTATE[HY000] [2002] No connection could be made"

**Soluciones:**
1. Verifica que MySQL esté corriendo
2. Cambia `DB_HOST` en `.env`:
   ```env
   DB_HOST=127.0.0.1
   # o prueba con
   DB_HOST=localhost
   ```
3. Verifica el puerto MySQL en XAMPP (por defecto 3306)
4. Ejecuta:
   ```powershell
   php artisan config:clear
   ```

### Problema 8: "Permission denied" al crear archivos

**Windows:**
```powershell
icacls "storage" /grant Users:F /T
icacls "bootstrap\cache" /grant Users:F /T
```

**macOS/Linux:**
```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

---

## ❓ Preguntas Frecuentes

### ¿Necesito instalar algo más aparte de XAMPP?

Sí, necesitas:
- **Composer** (gestor de dependencias PHP)
- **Node.js y NPM** (para compilar recursos front-end)

### ¿Puedo usar WAMP, MAMP u otro stack?

Sí, el sistema funciona con cualquier stack que tenga:
- PHP 8.1 o superior
- MySQL 5.7 o superior
- Apache o Nginx

### ¿Dónde están las credenciales por defecto?

- **Email:** admin@sistema.com
- **Contraseña:** admin123456

Cámbialas inmediatamente después del primer inicio de sesión.

### ¿Cómo creo nuevos usuarios?

1. Inicia sesión como Super Admin
2. Ve a **Administración** > **Usuarios**
3. Haz clic en **"Nuevo Usuario"**
4. Completa el formulario y asigna un rol
5. El nuevo usuario recibirá sus credenciales

### ¿Cómo hago un respaldo de la base de datos?

**Método 1: phpMyAdmin**
1. Ve a http://localhost/phpmyadmin
2. Selecciona la base de datos `cuentas_cobro`
3. Clic en la pestaña **"Exportar"**
4. Clic en **"Continuar"**
5. Se descargará un archivo `.sql`

**Método 2: Línea de comandos**
```powershell
# Navegar a la carpeta bin de MySQL
cd C:\xampp\mysql\bin

# Crear respaldo
.\mysqldump -u root cuentas_cobro > respaldo_[fecha].sql
```

### ¿Cómo actualizo el sistema?

1. **Haz respaldo** de la base de datos primero
2. Descarga la nueva versión del sistema
3. Reemplaza los archivos (excepto `.env` y `storage/`)
4. Ejecuta:
   ```powershell
   composer install
   npm install
   npm run build
   php artisan migrate
   php artisan cache:clear
   ```

### ¿El sistema funciona en red local?

Sí, para acceder desde otras computadoras:

1. En la computadora servidor, obtén la IP:
   ```powershell
   ipconfig
   # Busca "Dirección IPv4"
   ```
2. En el archivo `.env` del servidor:
   ```env
   APP_URL=http://[TU_IP_LOCAL]/CuentasCobro/public
   ```
3. Desde otros equipos, accede a: http://[IP_DEL_SERVIDOR]/CuentasCobro/public
4. Asegúrate de que el firewall permita conexiones al puerto 80

### ¿Puedo cambiar el idioma?

El sistema está en español por defecto. Los archivos de idioma están en:
- `lang/es/`

### ¿Dónde se guardan los archivos subidos?

Los archivos (PDFs, soportes, comprobantes) se guardan en:
- `storage/app/soportes/`
- `storage/app/pdf/`

**Importante:** Haz respaldo regular de estas carpetas.

### ¿Cómo activo el modo de producción?

En el archivo `.env`, cambia:
```env
APP_ENV=production
APP_DEBUG=false
```

Y ejecuta:
```powershell
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📞 Soporte Adicional

### Recursos Útiles

- **Documentación de Laravel:** https://laravel.com/docs
- **Documentación de XAMPP:** https://www.apachefriends.org/docs/
- **Foro de Laravel:** https://laracasts.com/discuss

### Archivos de Log

Si encuentras errores, revisa los logs en:
- `storage/logs/laravel.log` - Errores de Laravel
- `C:\xampp\apache\logs\error.log` - Errores de Apache
- `C:\xampp\mysql\data\mysql_error.log` - Errores de MySQL

### Información del Sistema

Para obtener información del sistema, ejecuta:
```powershell
php artisan about
```

---

## ✅ Lista de Verificación de Instalación

Usa esta lista para verificar que todo esté correctamente instalado:

- [ ] XAMPP instalado y funcionando
- [ ] Apache corriendo (luz verde en XAMPP)
- [ ] MySQL corriendo (luz verde en XAMPP)
- [ ] Composer instalado (`composer --version` funciona)
- [ ] Node.js y NPM instalados (`node --version` y `npm --version` funcionan)
- [ ] Archivos del proyecto en `C:\xampp\htdocs\CuentasCobro`
- [ ] Dependencias PHP instaladas (`composer install` ejecutado)
- [ ] Dependencias Node instaladas (`npm install` ejecutado)
- [ ] Recursos compilados (`npm run build` ejecutado)
- [ ] Base de datos creada en phpMyAdmin
- [ ] Estructura de base de datos importada o migrada
- [ ] Datos iniciales cargados (`php artisan db:seed`)
- [ ] Archivo `.env` configurado correctamente
- [ ] Clave de aplicación generada (`php artisan key:generate`)
- [ ] Permisos de carpetas configurados
- [ ] Sistema accesible desde el navegador
- [ ] Login funciona con credenciales por defecto
- [ ] Contraseñas por defecto cambiadas

---

## 🎉 ¡Instalación Completada!

Si has seguido todos los pasos, tu sistema de Cuentas de Cobro debería estar funcionando correctamente.

**Próximos pasos recomendados:**

1. � **Lee el documento ORGANIZACION_PROYECTO.md** para entender la estructura completa del proyecto
2. �📖 Lee el documento **PROCESO_COMPLETO_CUENTAS_COBRO.md** para entender el flujo del sistema
3. 👥 Crea los usuarios necesarios para tu organización
4. 🔐 Cambia todas las contraseñas por defecto
5. 💾 Configura respaldos automáticos de la base de datos
6. 🧪 Prueba el flujo completo con cuentas de prueba

---

## 📚 Documentación Completa del Sistema

Este proyecto incluye documentación completa organizada en los siguientes archivos:

### 📄 Documentos Principales

1. **MANUAL_INSTALACION_TERCEROS.md** (Este documento)
   - Guía completa de instalación paso a paso
   - Para desarrolladores nuevos y terceros
   - No requiere conocimientos previos del sistema

2. **ORGANIZACION_PROYECTO.md** ⭐ **LEER DESPUÉS DE INSTALAR**
   - Estructura completa del proyecto
   - Organización de carpetas y archivos
   - Convenciones de código y nomenclatura
   - Sistema de estilos (Apple-inspired design)
   - Buenas prácticas de desarrollo
   - **ESENCIAL para desarrolladores**

3. **PROCESO_COMPLETO_CUENTAS_COBRO.md**
   - Flujo obligatorio de aprobación (5 etapas)
   - Roles y permisos detallados
   - Opciones de intervención por rol
   - Proceso de pago completo
   - Matrices de decisiones
   - Para usuarios finales y administradores

4. **FLUJO_DOCUMENTOS.md**
   - Documentación del flujo original
   - Referencia técnica histórica

### 🗂️ Orden de Lectura Recomendado

```
1️⃣ MANUAL_INSTALACION_TERCEROS.md    → Instala el sistema
2️⃣ ORGANIZACION_PROYECTO.md          → Entiende la estructura
3️⃣ PROCESO_COMPLETO_CUENTAS_COBRO.md → Conoce el flujo de trabajo
4️⃣ FLUJO_DOCUMENTOS.md                → Referencia adicional
```

---

**Fecha de actualización:** Noviembre 5, 2025  
**Versión del manual:** 1.0  
**Documento:** MANUAL_INSTALACION_TERCEROS.md
