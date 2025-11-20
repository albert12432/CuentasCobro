# 📋 Flujo de Documentos: Sistema de Aprobación de Cuentas de Cobro

## 🌟 Resumen General

El sistema implementa un **flujo de aprobación por etapas** donde cada cuenta de cobro debe pasar por diferentes áreas (roles) para su validación completa antes de ser enviada al cliente final.

---

## 🔄 Diagrama de Flujo

```
[Contratista crea cuenta]
         ↓
   [SUPERVISOR]
         ↓ aprueba
  [ORDENADOR DEL GASTO]
         ↓ aprueba
     [ALCALDE]
         ↓ aprueba
    [APROBADO]
         ↓
 [Envío al Cliente]
         ↓
   [ENVIADO_CLIENTE]
```

> **Nota:** En cualquier etapa se puede **RECHAZAR** con motivo obligatorio.

---

## � Credenciales de Acceso (Demostración)

A continuación se encuentran los usuarios registrados en el sistema con sus roles, correos y contraseñas para pruebas:

| Nombre Completo | Email | Contraseña | Rol | Descripción |
|---|---|---|---|---|
| **Contratista Demo** | contratista@example.com | `Demo1234*` | Contratista | Crea y envía cuentas de cobro |
| **Ordenador del Gasto** | ordenador@example.com | `Demo1234*` | Ordenador del Gasto | Autoriza pagos y gestiona roles |
| **Contratación** | contratacion@example.com | `Demo1234*` | Contratación | Valida contratos y contratistas |
| **Tesorería** | tesoreria@example.com | `Demo1234*` | Tesorería | Procesa pagos y notifica |
| **Supervisor** | supervisor@example.com | `Demo1234*` | Supervisor | Revisa y valida cuentas inicialmente |
| **Alcalde** | alcalde@example.com | `Demo1234*` | Alcalde | Aprobación final de cuentas |
| **Daniel Ramirez** | daniel00250@hotmail.com | `cosita1225*` | Ordenador del Gasto | Administrador del sistema |

> **⚠️ IMPORTANTE:** Estas credenciales son solo para desarrollo/pruebas. En producción, usar credenciales seguras y cambiar contraseñas inmediatamente.

---

##  Roles y Permisos

### 1. **Contratista**
- **Descripción:** Proveedor o prestador de servicios que genera las cuentas de cobro
- **Acciones Principales:**
  - ✅ Crear nuevas cuentas de cobro
  - ✅ Cargar archivos de soporte (facturas, recibos, comprobantes)
  - ✅ Ver el estado de sus propias cuentas
  - ✅ Recibir notificaciones sobre aprobaciones/rechazos
  - ✅ Editar cuentas en estado `en_correccion` (si fueron devueltas)
  - ✅ Reenviar cuentas después de corregirlas
  - ✅ Archivar/Desarchivar sus cuentas completadas
- **Restricciones:**
  - ❌ NO puede aprobar, revisar ni rechazar cuentas
  - ❌ NO puede ver cuentas de otros contratistas
  - ❌ NO puede modificar cuentas que ya están en revisión
- **Acceso a vistas:**
  - `/cuentas_cobro` - Listado de sus propias cuentas
  - `/cuentas_cobro/create` - Crear nueva cuenta
  - `/cuentas_cobro/{id}` - Ver detalle de cuenta propia

---

### 2. **Supervisor** (Opcional, primer validador)
- **Descripción:** Revisor inicial que valida la completitud y coherencia de la documentación
- **Acciones Principales:**
  - ✅ Recibe notificación cuando contratista crea una cuenta
  - ✅ Revisa completitud de datos y documentos adjuntos (primer filtro)
  - ✅ Valida información del beneficiario y montos
  - ✅ Aprueba y avanza la cuenta a **Ordenador del Gasto**
  - ✅ Rechaza con motivo obligatorio
  - ✅ Agregar comentarios durante revisión
- **Restricciones:**
  - ❌ NO puede crear cuentas
  - ❌ NO puede enviar al cliente
  - ❌ Solo ve cuentas en etapa `supervisor`
- **Acceso a vistas:**
  - `/aprobaciones` - Cuentas pendientes de su revisión
  - `/notificaciones` - Bandeja de notificaciones

---

### 3. **Ordenador del Gasto** (Principal coordinador)
- **Descripción:** Responsable de validar legalidad, presupuesto y orden de gasto
- **Acciones Principales:**
  - ✅ Recibe notificación cuando Supervisor aprueba
  - ✅ Revisa aspectos legales y presupuestarios
  - ✅ Valida contra presupuesto disponible
  - ✅ Aprueba y avanza a **Contratación**
  - ✅ Rechaza con motivo si hay inconsistencias
  - ✅ Envía cuentas al cliente (una vez aprobadas por todas las etapas)
  - ✅ Ve todas las cuentas del municipio (auditoría)
  - ✅ Accede a reportes de pagos
- **Restricciones:**
  - ❌ NO puede crear cuentas de cobro
  - ❌ Solo aprueba si está en su etapa asignada
- **Acceso a vistas:**
  - `/aprobaciones` - Cuentas en etapa `ordenador_gasto`
  - `/cuentas_cobro` - Listado completo de cuentas
  - `/cuentas_cobro/pagos` - Resumen de pagos realizados
  - `/notificaciones` - Bandeja de notificaciones

---

### 4. **Contratación** (Validador de contratos)
- **Descripción:** Valida que la cuenta corresponda a un contrato vigente y existente
- **Acciones Principales:**
  - ✅ Recibe notificación cuando Ordenador aprueba
  - ✅ Valida existencia del contrato relacionado
  - ✅ Valida vigencia del contrato
  - ✅ Aprueba y avanza a **Tesorería**
  - ✅ Rechaza si contrato no existe o está vencido
  - ✅ **Puede DEVOLVER para corrección** si hay errores no graves
  - ✅ Accede a detalles del contrato desde la cuenta
- **Restricciones:**
  - ❌ NO puede crear cuentas
  - ❌ NO puede enviar directamente al cliente
- **Acceso a vistas:**
  - `/aprobaciones` - Cuentas en etapa `contratacion`
  - `/cuentas_cobro/{id}` - Ver y devolver para corrección
  - `/notificaciones` - Bandeja de notificaciones

---

### 5. **Tesorería** (Ejecutor de pagos)
- **Descripción:** Responsable de procesar y ejecutar los pagos
- **Acciones Principales:**
  - ✅ Recibe notificación cuando Contratación aprueba
  - ✅ Revisa cuentas completamente aprobadas
  - ✅ Valida información bancaria
  - ✅ Registra y procesa el pago
  - ✅ Descarga PDF de la cuenta
  - ✅ Accede a datos de la cuenta en modo **SOLO LECTURA**
  - ✅ Notifica al Contratista cuando pago se realiza
- **Restricciones:**
  - ❌ NO puede editar datos de la cuenta
  - ❌ NO puede rechazar cuentas (solo reportar si hay error)
  - ❌ NO puede crear cuentas
- **Acceso a vistas:**
  - `/aprobaciones` - Cuentas en etapa `tesoreria`
  - `/cuentas_cobro/{id}` - Ver en modo solo lectura con botón descargar PDF
  - `/cuentas_cobro/pagos` - Registrar y ver pagos realizados
  - `/notificaciones` - Bandeja de notificaciones

---

### 6. **Alcalde** (Aprobador final - OPCIONAL)
- **Descripción:** Aprobación final de cuentas de gran cuantía (puede estar deshabilitado)
- **Acciones Principales:**
  - ✅ Recibe notificación cuando Contratación aprueba
  - ✅ Revisa y da aprobación final
  - ✅ Aprueba para envío definitivo al cliente
  - ✅ Puede rechazar si ve inconsistencias graves
- **Acceso a vistas:**
  - `/aprobaciones` - Cuentas en etapa `alcalde`
  - `/notificaciones` - Bandeja de notificaciones

---

### 7. **Super Admin** (Administrador del sistema)
- **Descripción:** Control total del sistema, puede actuar como cualquier rol
- **Acciones Principales:**
  - ✅ Puede **actuar en CUALQUIER ETAPA** del flujo
  - ✅ Tiene **TODOS los permisos**
  - ✅ Crear, editar, aprobar, rechazar y enviar cuentas
  - ✅ Gestionar usuarios y roles
  - ✅ Ver todas las cuentas y reportes
  - ✅ Acceso completo a la administración
- **Acceso a vistas:**
  - Acceso total a todas las secciones
  - `/admin/users` - Gestionar usuarios
  - `/admin/roles` - Gestionar roles y permisos

---

## 🔄 Flujo Visual Resumido

```
┌─────────────────────────────────────────────────────────────────┐
│  CONTRATISTA: Crear Cuenta → Cargar Soportes → Esperar         │
└────────────────────────┬────────────────────────────────────────┘
                         │ Notificación: "Nueva cuenta para revisar"
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│  SUPERVISOR: Revisar Completitud → Aprobar o Rechazar          │
└────────────────────────┬────────────────────────────────────────┘
                         │ Si aprueba → Notificación Ordenador
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│  ORDENADOR DEL GASTO: Validar Presupuesto → Aprobar            │
└────────────────────────┬────────────────────────────────────────┘
                         │ Si aprueba → Notificación Contratación
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│  CONTRATACIÓN: Validar Contrato → Aprobar o Devolver           │
└────────────────────────┬────────────────────────────────────────┘
                         │ Si aprueba → Notificación Tesorería
                         │ Si devuelve → Contratista recibe aviso
                         ↓
                    [Si fue devuelta]
                         ↓
         ┌────────────────────────────────┐
         │  CONTRATISTA: Corregir datos   │
         │  → Reenviar a Contratación     │
         └────────────────────────────────┘
                         │
                         ↓
┌─────────────────────────────────────────────────────────────────┐
│  TESORERÍA: Validar Datos Bancarios → Procesar Pago            │
└────────────────────────┬────────────────────────────────────────┘
                         │ Notifica pago realizado al Contratista
                         ↓
                    [PAGADO]
```

---

## 📝 Estados de la Cuenta de Cobro

| Estado | Descripción | Color | Quién ve |
|--------|-------------|-------|----------|
| `pendiente` | Recién creada | 🟡 Amarillo | Contratista, Super Admin |
| `en_revision` | En proceso de aprobación | 🔵 Azul | Rol actual en etapa |
| `en_correccion` | Devuelta para corregir datos | 🟠 Naranja | Contratista, Contratación |
| `aprobado` | Aprobada por todas las etapas | 🟢 Verde | Todos (lectura) |
| `rechazado` | Rechazada en alguna etapa | 🔴 Rojo | Contratista, Super Admin |
| `enviado_cliente` | Enviada al cliente final | 🟣 Púrpura | Todos (lectura) |
| `pagado` | Pago confirmado por Tesorería | 💚 Verde claro | Todos |
| `archivado` | Archivada por Contratista | ⚫ Gris | Solo si busca activamente |

---

## 🎯 Etapas de Aprobación (Pipeline)

| Número | Etapa | Rol Responsable | Siguiente Etapa | Acciones |
|--------|-------|----------------|---|
| 1 | `supervisor` | Supervisor | `ordenador_gasto` | Aprobar / Rechazar |
| 2 | `ordenador_gasto` | Ordenador del Gasto | `contratacion` | Aprobar / Rechazar |
| 3 | `contratacion` | Contratación | `tesoreria` | Aprobar / Rechazar / **Devolver** |
| 4 | `tesoreria` | Tesorería | `pagado` | Procesar Pago |
| 5 | `final` | (Sistema) | — | Estado: `aprobado` |

---

## 📬 Sistema de Notificaciones por Rol

### Notificaciones Que Recibe Cada Rol

**Contratista recibe:**
- ✅ Cuenta **aprobada** por Supervisor (avanza en flujo)
- ✅ Cuenta **rechazada** con motivo
- ✅ Cuenta **devuelta** por Contratación para corregir
- ✅ **Pago realizado** por Tesorería

**Supervisor recibe:**
- ✅ **Nueva cuenta** creada para revisar (con ID y monto)

**Ordenador del Gasto recibe:**
- ✅ Cuenta **aprobada por Supervisor** para su validación

**Contratación recibe:**
- ✅ Cuenta **aprobada por Ordenador** para validar contrato

**Tesorería recibe:**
- ✅ Cuenta **aprobada por Contratación** para procesar pago

---

## � Paso a Paso: Guía Completa de Flujo

### **Paso 1: Crear Cuenta de Cobro (Contratista)**

1. Ingresar al sistema con rol **Contratista**
2. Ir a **"Cuentas de Cobro" → "Crear Nueva"**
3. Llenar formulario:
   - Número de cuenta
   - Fecha de emisión
   - Departamento y municipio
   - Beneficiario
   - Ítems (productos/servicios con cantidad y precio)
4. Guardar

**Resultado:**
- ✅ Cuenta creada con estado `en_revision`
- ✅ Etapa asignada: `supervisor`
- ✅ Notificación enviada a **todos los Supervisores**
- ✅ PDF generado automáticamente

---

### **Paso 2: Revisión por Supervisor**

1. **Supervisor** recibe notificación en su **Bandeja de Pendientes** (`/notificaciones`)
2. Hacer clic en **"Ver Cuenta"** desde la notificación
3. Ver detalles completos de la cuenta
4. **Opciones:**
   - **Aprobar:** Cuenta pasa a `ordenador_gasto`
   - **Rechazar:** Cuenta pasa a estado `rechazado` (debe ingresar motivo)

**Acceso rápido:**
- Ir a `/aprobaciones` para ver TODAS las cuentas pendientes asignadas a su rol

**Resultado al aprobar:**
- ✅ Cuenta avanza a etapa `ordenador_gasto`
- ✅ Notificación enviada a **Ordenadores del Gasto**
- ✅ Historial registrado

**Resultado al rechazar:**
- ❌ Cuenta cambia a estado `rechazado`
- ❌ Notificación enviada al **Contratista** con motivo
- ❌ Etapa se borra (ya no avanza)

---

### **Paso 3: Revisión por Ordenador del Gasto**

1. **Ordenador del Gasto** recibe notificación
2. Acceder a `/aprobaciones` o hacer clic en notificación
3. Ver detalles de la cuenta
4. **Opciones:**
   - **Aprobar:** Cuenta pasa a `alcalde`
   - **Rechazar:** Motivo obligatorio

**Resultado al aprobar:**
- ✅ Cuenta avanza a etapa `alcalde`
- ✅ Notificación enviada a **Alcalde**
- ✅ Historial actualizado

---

### **Paso 4: Aprobación Final (Alcalde)**

1. **Alcalde** recibe notificación
2. Acceder a `/aprobaciones`
3. Ver detalles completos
4. **Opciones:**
   - **Aprobar:** Cuenta pasa a estado **APROBADO**
   - **Rechazar:** Motivo obligatorio

**Resultado al aprobar:**
- ✅ Estado cambia a `aprobado`
- ✅ Etapa cambia a `final`
- ✅ Se registra quién aprobó y fecha
- ✅ Notificación enviada al **Contratista** (tu cuenta fue aprobada)
- ✅ Aparece botón **"Enviar al Cliente"** para Ordenador/Alcalde/Super Admin

---

### **Paso 5: Enviar al Cliente**

1. Una vez la cuenta está **APROBADA**, los roles autorizados ven el botón **"Enviar al Cliente"**
   - Roles autorizados: `ordenador_gasto`, `alcalde`, `super_admin`
2. Hacer clic en **"Enviar al Cliente"**

**Resultado:**
- ✅ Estado cambia a `enviado_cliente`
- ✅ Se registra fecha de envío
- ✅ Historial actualizado
- ✅ Ya NO se puede modificar ni rechazar

---

## 📬 Sistema de Notificaciones (Bandeja de Pendientes)

### ¿Dónde acceder?
- **Menú superior:** Icono de campana 🔔 con contador de notificaciones no leídas
- **Ruta directa:** `/notificaciones`

### ¿Qué se notifica?
- **Contratista recibe:**
  - Cuenta aprobada
  - Cuenta rechazada (con motivo)

- **Supervisor recibe:**
  - Nueva cuenta creada para revisión

- **Ordenador del Gasto recibe:**
  - Cuenta aprobada por Supervisor (para su revisión)

- **Alcalde recibe:**
  - Cuenta aprobada por Ordenador del Gasto (para aprobación final)

### Características de la Bandeja:
- ✅ Listado de notificaciones con indicador "Nueva"
- ✅ Botón **"Ver Cuenta"** para acceder directamente
- ✅ Botón **"Marcar como leída"** individual
- ✅ Botón **"Marcar todas como leídas"**
- ✅ Paginación (20 por página)
- ✅ Timestamp relativo (hace 2 horas, hace 1 día, etc.)

---

## 🕰️ Timeline / Historial de Cambios

Cada cuenta de cobro tiene una **sección de historial** que muestra:

- ✅ **Acción realizada** (creado, revisado, aprobado, rechazado, enviado)
- ✅ **Usuario que realizó la acción**
- ✅ **Fecha y hora** exacta
- ✅ **Estados anterior → nuevo**
- ✅ **Comentarios** (opcional al aprobar, obligatorio al rechazar)
- ✅ **Íconos y colores** según tipo de acción

### Ejemplo de Timeline:
```
🔵 CREADO (hace 2 horas)
   Usuario: Juan Pérez
   pendiente → en_revision
   Comentario: "Cuenta de cobro creada"

🔵 REVISADO (hace 1 hora)
   Usuario: María López (Supervisor)
   en_revision → en_revision
   Comentario: "Supervisor aprobó y avanzó la revisión"

🟢 APROBADO (hace 30 minutos)
   Usuario: Carlos Gómez (Alcalde)
   en_revision → aprobado
   Comentario: "Cuenta aprobada"

🟣 ENVIADO_CLIENTE (hace 5 minutos)
   Usuario: Ana Torres (Ordenador del Gasto)
   aprobado → enviado_cliente
   Comentario: "Enviado al cliente"
```

---

## 🎨 Vistas Especiales por Rol

### 1. **Vista: Mis Aprobaciones** (`/aprobaciones`)
- **Acceso:** Supervisor, Ordenador del Gasto, Alcalde, Super Admin
- **Muestra:** SOLO cuentas asignadas a la etapa del usuario logueado
- **Características:**
  - Filtro automático por etapa
  - Indicador de etapa actual asignada
  - Botones rápidos: "Aprobar etapa" y "Rechazar"
  - Enlace "Ver detalle" para análisis completo

### 2. **Vista: Detalle de Cuenta** (`/cuentas_cobro/{id}`)
- **Acceso:** Todos los roles (según permisos)
- **Muestra:**
  - 🎯 Badge de estado actual (color según estado)
  - 📍 Etapa de aprobación actual
  - 🕰️ Timeline completo de historial
  - ⚠️ Motivo de rechazo (si aplica)
  - � Quién aprobó finalmente (si aplica)
  - 🔘 Botones de acción condicionales según estado y rol

### 3. **Vista: Notificaciones** (`/notificaciones`)
- **Acceso:** Todos los usuarios autenticados
- **Muestra:**
  - Bandeja de entrada personalizada
  - Notificaciones ordenadas por fecha (más recientes primero)
  - Contador de no leídas
  - Acciones rápidas

---

## 🛠️ Casos Especiales

### **¿Qué pasa si se rechaza en alguna etapa?**
- ❌ La cuenta NO avanza más
- ❌ Estado cambia a `rechazado`
- ❌ Se elimina la etapa asignada (ya no hay siguiente paso)
- ❌ El contratista recibe notificación con el **motivo de rechazo**
- ❌ La cuenta NO se puede volver a procesar (debe crear una nueva)

### **¿Puede el Super Admin saltar etapas?**
- ✅ Sí, el Super Admin puede aprobar en **cualquier etapa**
- ✅ Si aprueba en etapa `supervisor`, avanza a `ordenador_gasto`
- ✅ Si aprueba en etapa `alcalde`, aprueba finalmente

### **¿Se puede editar una cuenta en revisión?**
- ⚠️ Actualmente NO (para mantener integridad)
- ⚠️ Si se necesita cambiar algo, se debe rechazar y crear nueva cuenta
- ⚠️ (Funcionalidad de "correcciones" puede agregarse en el futuro)

### **¿Quién ve todas las cuentas?**
- 👁️ **Super Admin:** Ve TODAS
- 👁️ **Ordenador del Gasto:** Ve TODAS (pueden supervisar pagos)
- 👁️ **Otros roles:** Solo ven las asignadas a su etapa o las que crearon

---

## 📊 Resumen de Rutas

| Ruta | Método | Descripción | Roles Autorizados |
|------|--------|-------------|-------------------|
| `/notificaciones` | GET | Bandeja de notificaciones | Todos |
| `/notificaciones/{id}/marcar-leida` | POST | Marcar como leída | Todos |
| `/notificaciones/marcar-todas-leidas` | POST | Marcar todas | Todos |
| `/aprobaciones` | GET | Cuentas pendientes por etapa | Supervisor, Ordenador, Alcalde, Super Admin |
| `/cuentas_cobro` | GET | Listado general | Ordenador, Supervisor |
| `/cuentas_cobro/create` | GET | Crear cuenta | Ordenador, Supervisor |
| `/cuentas_cobro/{id}` | GET | Detalle de cuenta | Todos (según permisos) |
| `/cuentas_cobro/{id}/aprobar` | POST | Aprobar etapa actual | Según rol y etapa |
| `/cuentas_cobro/{id}/rechazar` | POST | Rechazar cuenta | Según rol y etapa |
| `/cuentas_cobro/{id}/enviar-cliente` | POST | Enviar al cliente | Ordenador, Alcalde, Super Admin |
| `/cuentas_cobro/{id}/pdf` | GET | Descargar PDF | Todos |

---

## 🎯 Ejemplo Completo de Flujo

1. **Contratista** crea cuenta #CC-2025-001 por $5.000.000
   - Estado: `en_revision`, Etapa: `supervisor`
   - Notificación enviada a Supervisores

2. **Supervisor** revisa y aprueba
   - Etapa avanza a `ordenador_gasto`
   - Notificación enviada a Ordenadores del Gasto

3. **Ordenador del Gasto** revisa presupuesto y aprueba
   - Etapa avanza a `alcalde`
   - Notificación enviada a Alcalde

4. **Alcalde** da aprobación final
   - Estado: `aprobado`, Etapa: `final`
   - Notificación enviada al Contratista: "Tu cuenta fue aprobada"

5. **Ordenador del Gasto** envía al cliente
   - Estado: `enviado_cliente`
   - Ya NO se puede modificar

---

## ✅ Validaciones del Sistema

- ✅ No se puede aprobar si no es la etapa asignada al usuario
- ✅ No se puede rechazar sin motivo
- ✅ No se puede enviar al cliente si NO está aprobado
- ✅ Solo roles autorizados pueden enviar al cliente
- ✅ El historial registra TODAS las acciones (auditoría completa)
- ✅ Las notificaciones solo llegan al rol correspondiente de cada etapa

---

## 🔐 Seguridad

- 🔒 Middleware `check.role` valida permisos en cada ruta
- 🔒 Validaciones en controlador verifican estado y etapa antes de acciones
- 🔒 Historial inmutable (no se puede editar ni borrar)
- 🔒 Notificaciones filtradas por `user_id` (solo ves las tuyas)

---

## 📚 Tecnologías Utilizadas

- **Backend:** Laravel 11
- **Base de Datos:** MySQL
- **PDF:** Barryvdh\DomPDF
- **Frontend:** Blade Templates + CSS Apple-style
- **Notificaciones:** Sistema custom con base de datos

---

## 📞 Soporte

Para dudas o problemas:
1. Revisar historial de la cuenta en cuestión
2. Verificar rol del usuario logueado
3. Verificar estado y etapa actual de la cuenta
4. Consultar este documento de flujo

---

**Última actualización:** 30 de octubre de 2025
