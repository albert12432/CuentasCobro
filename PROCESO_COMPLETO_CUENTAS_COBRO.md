![alt text](image.png)# 📋 Proceso Completo de Cuentas de Cobro

## 📖 Índice Rápido

- [🎯 Flujo Obligatorio de Aprobación](#-flujo-obligatorio-de-aprobación)
- [🔄 Flujos Alternos y Opciones de Intervención](#-flujos-alternos-y-opciones-de-intervención)
- [👥 Roles y Permisos Detallados](#-roles-y-permisos-detallados)
- [📊 Estados y Opciones de la Cuenta](#-estados-y-opciones-de-la-cuenta)
- [🚀 Paso a Paso: Desde la Creación hasta el Pago](#-paso-a-paso-desde-la-creación-hasta-el-pago)
- [🎯 Matriz de Decisiones por Rol](#-matriz-de-decisiones-por-rol)
- [📝 Consideraciones Importantes](#-consideraciones-importantes)
- [📞 Soporte y Documentación Adicional](#-soporte-y-documentación-adicional)

---

## 🌟 Resumen Ejecutivo

Este documento describe el **flujo obligatorio de aprobación de cuentas de cobro** implementado en el sistema municipal. El proceso garantiza que cada cuenta pase por **5 etapas secuenciales** de validación antes de ser pagada.

### Características Principales:
- ✅ **Flujo obligatorio** de 5 etapas (no se pueden saltar)
- 🔄 **Múltiples opciones** de intervención por rol (aprobar, rechazar, devolver, comentar)
- 📝 **Trazabilidad completa** de todas las acciones y decisiones
- 🔔 **Notificaciones automáticas** en cada cambio de estado
- 💰 **Proceso de pago robusto** con validaciones y comprobantes
- 🎯 **Permisos granulares** por rol y etapa

### Resumen del Flujo:
```
Contratista → Supervisor → Ordenador → Contratación → Alcalde → Tesorería → Pago
   (Crea)     (Valida)   (Presupuesto)  (Contrato)   (Aprueba)  (Ejecuta)  (Final)
```

---

## 🎯 Flujo Obligatorio de Aprobación

El sistema implementa un **flujo secuencial OBLIGATORIO** donde cada cuenta de cobro debe pasar por todas las áreas en orden estricto:

```
┌─────────────────────────────────────────────────────────┐
│  1. CONTRATISTA: Crear Cuenta                          │
│     ├─ Completa formulario con datos del beneficiario  │
│     ├─ Agrega ítems (descripción, cantidad, precio)    │
│     ├─ Adjunta soportes (facturas, comprobantes)       │
│     └─ Genera automáticamente el PDF                   │
└─────────────────────┬───────────────────────────────────┘
                      │ Estado: en_revision
                      │ Etapa: supervisor
                      ↓
┌─────────────────────────────────────────────────────────┐
│  2. SUPERVISOR: Primera Revisión                        │
│     ├─ Valida completitud de documentos                │
│     ├─ Verifica coherencia de montos                   │
│     ├─ Revisa datos del beneficiario                   │
│     ├─ Agregar comentarios y observaciones             │
│     └─ Opciones de decisión:                           │
│        ✅ ENVIAR AL SIGUIENTE NIVEL                     │
│           → Avanza a Ordenador del Gasto               │
│           → Agrega comentario de aprobación            │
│           → Notifica automáticamente al siguiente rol  │
│        ❌ RECHAZAR (No Aprobado)                        │
│           → Finaliza el proceso definitivamente        │
│           → Requiere motivo obligatorio                │
│           → Estado: rechazado                          │
│           → Notifica al contratista                    │
│        📝 AGREGAR INTERACCIÓN                          │
│           → Comentarios sin cambiar estado             │
│           → Solicitar aclaraciones                     │
│           → Visible en historial                       │
└─────────────────────┬───────────────────────────────────┘
                      │ Si envía al siguiente nivel
                      │ Estado: en_revision
                      │ Etapa: ordenador_gasto
                      ↓
┌─────────────────────────────────────────────────────────┐
│  3. ORDENADOR DEL GASTO: Validación Presupuestaria     │
│     ├─ Verifica disponibilidad presupuestal            │
│     ├─ Valida cumplimiento normativo                   │
│     ├─ Revisa orden de gasto y CDP                     │
│     ├─ Valida rubros presupuestales                    │
│     └─ Opciones de decisión:                           │
│        ✅ ENVIAR AL SIGUIENTE NIVEL                     │
│           → Avanza a Contratación                      │
│           → Confirma disponibilidad presupuestal       │
│        ❌ RECHAZAR (No Aprobado)                        │
│           → Finaliza por falta de presupuesto          │
│           → Motivo obligatorio (legal/presupuestal)    │
│           → Estado: rechazado                          │
│        🔄 DEVOLVER A SUPERVISOR                         │
│           → Regresa a etapa anterior con observaciones │
│           → Para ajustes antes de continuar            │
│        📝 AGREGAR INTERACCIÓN                          │
│           → Solicitar documentación adicional          │
│           → Aclaraciones presupuestales                │
└─────────────────────┬───────────────────────────────────┘
                      │ Si envía al siguiente nivel
                      │ Estado: en_revision
                      │ Etapa: contratacion
                      ↓
┌─────────────────────────────────────────────────────────┐
│  4. CONTRATACIÓN: Validación de Contrato                │
│     ├─ Verifica existencia del contrato                │
│     ├─ Valida vigencia y términos del contrato         │
│     ├─ Confirma obligaciones y cumplimientos           │
│     ├─ Valida que no existan sanciones                 │
│     └─ Opciones de decisión:                           │
│        ✅ ENVIAR AL SIGUIENTE NIVEL                     │
│           → Avanza a Alcalde                           │
│           → Confirma validación contractual            │
│        ❌ RECHAZAR (No Aprobado)                        │
│           → Finaliza por incumplimiento contractual    │
│           → Motivo obligatorio                         │
│           → Estado: rechazado                          │
│        🔄 DEVOLVER PARA CORRECCIÓN                      │
│           → Regresa al Contratista                     │
│           → Estado: en_correccion                      │
│           → Para ajustes menores (errores de forma)    │
│           → El contratista puede editar y reenviar     │
│        🔙 DEVOLVER A ETAPA ANTERIOR                     │
│           → Regresa a Ordenador del Gasto              │
│           → Para revisión presupuestal adicional       │
│        📝 AGREGAR INTERACCIÓN                          │
│           → Solicitar documentación del contrato       │
│           → Aclaraciones sobre obligaciones            │
└─────────────────────┬───────────────────────────────────┘
                      │ Si envía al siguiente nivel
                      │ Estado: en_revision
                      │ Etapa: alcalde
                      ↓
┌─────────────────────────────────────────────────────────┐
│  5. ALCALDE: Aprobación Final Ejecutiva                 │
│     ├─ Revisión ejecutiva integral de la cuenta        │
│     ├─ Validación política y administrativa            │
│     ├─ Verificación de coherencia del proceso          │
│     └─ Opciones de decisión:                           │
│        ✅ APROBAR Y ENVIAR A TESORERÍA                  │
│           → Marca como APROBADO definitivamente        │
│           → Estado: aprobado                           │
│           → Etapa: tesoreria                           │
│           → Genera autorización de pago                │
│           → Notifica a Tesorería y Contratista         │
│        ❌ RECHAZAR (No Aprobado)                        │
│           → Finaliza el proceso por decisión ejecutiva │
│           → Motivo obligatorio                         │
│           → Estado: rechazado                          │
│        🔙 DEVOLVER A CONTRATACIÓN                       │
│           → Para revisión contractual adicional        │
│           → Mantiene estado: en_revision               │
│        📝 AGREGAR INTERACCIÓN                          │
│           → Solicitar información adicional            │
│           → Observaciones ejecutivas                   │
└─────────────────────┬───────────────────────────────────┘
                      │ Si aprueba
                      │ Estado: aprobado
                      │ Etapa: tesoreria
                      ↓
┌─────────────────────────────────────────────────────────┐
│  6. TESORERÍA: Validación Pre-Pago                      │
│     ├─ Valida información bancaria del beneficiario    │
│     ├─ Verifica autorización de pago                   │
│     ├─ Revisa documentación tributaria                 │
│     ├─ Confirma datos para transferencia               │
│     └─ Opciones de decisión:                           │
│        💰 REGISTRAR PAGO                                │
│           → Ver opción 7 (Flujo de Pago)               │
│        📤 ENVIAR AL CLIENTE                             │
│           → Cambia estado a: enviado_cliente           │
│           → Mantiene etapa: tesoreria                  │
│           → PDF enviado a cliente externo              │
│        🔙 REPORTAR ERROR A ALCALDE                      │
│           → Devuelve a Alcalde con observaciones       │
│           → Para corrección de datos bancarios         │
│        📝 AGREGAR INTERACCIÓN                          │
│           → Solicitar certificado bancario             │
│           → Aclaraciones sobre datos de pago           │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ↓
┌─────────────────────────────────────────────────────────┐
│  7. PROCESO DE PAGO (Tesorería)                         │
│     ├─ PASO 1: Preparación del Pago                    │
│     │  ├─ Verifica disponibilidad de fondos            │
│     │  ├─ Prepara orden de pago                        │
│     │  └─ Valida plataforma de pagos (banco/PSE)       │
│     │                                                    │
│     ├─ PASO 2: Ejecución del Pago                      │
│     │  ├─ Realiza transferencia o consignación         │
│     │  ├─ Obtiene comprobante/recibo                   │
│     │  └─ Registra referencia bancaria                 │
│     │                                                    │
│     ├─ PASO 3: Registro en el Sistema                  │
│     │  ├─ Accede a: Cuentas de Cobro > Pagos           │
│     │  ├─ Selecciona la cuenta aprobada                │
│     │  ├─ Completa formulario:                         │
│     │  │  • Valor pagado (validación)                  │
│     │  │  • Medio de pago (dropdown)                   │
│     │  │    - Transferencia bancaria                   │
│     │  │    - Consignación                             │
│     │  │    - Cheque                                   │
│     │  │    - PSE                                      │
│     │  │    - Otro                                     │
│     │  │  • Referencia de transacción (obligatorio)    │
│     │  │  • Fecha de pago (automática o manual)        │
│     │  │  • Observaciones (opcional)                   │
│     │  └─ Adjunta comprobante de pago (PDF/imagen)     │
│     │                                                    │
│     ├─ PASO 4: Confirmación y Actualización            │
│     │  ├─ Sistema actualiza:                           │
│     │  │  • estado_pago → "approved"                   │
│     │  │  • fecha_pago → fecha registrada              │
│     │  │  • pagado_por_id → ID del tesorero            │
│     │  ├─ Genera registro en historial                 │
│     │  └─ Envía notificaciones automáticas:            │
│     │     • Contratista: "Pago realizado"              │
│     │     • Ordenador: Notificación informativa        │
│     │     • Alcalde: Notificación informativa          │
│     │                                                    │
│     └─ PASO 5: Seguimiento Post-Pago                   │
│        ├─ Contratista confirma recepción               │
│        ├─ Sistema marca como "pagado" (final)          │
│        ├─ Archivar documentación                       │
│        └─ Disponible en reportes de pagos              │
└─────────────────────────────────────────────────────────┘
```

---

## 🔄 Flujos Alternos y Opciones de Intervención

### 📤 Devolución para Corrección (desde Contratación)

Cuando **Contratación** detecta errores menores de forma (no de fondo):

```
┌─────────────────────────────────────────────────────────┐
│  CONTRATACIÓN: Devolver para Corrección                │
│     ├─ Detecta errores menores corregibles             │
│     ├─ Ejemplos:                                        │
│     │  • Error en datos del beneficiario               │
│     │  • Documentos faltantes o ilegibles              │
│     │  • Inconsistencia en montos                      │
│     │  • Información incompleta                        │
│     └─ Acción: "Devolver para corrección"              │
│        • Estado: en_correccion                          │
│        • Etapa: contratista                             │
│        • Comentario obligatorio con observaciones       │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ↓
┌─────────────────────────────────────────────────────────┐
│  CONTRATISTA: Realizar Correcciones                     │
│     ├─ Recibe notificación con observaciones           │
│     ├─ Accede al botón "Editar" (habilitado)           │
│     ├─ Corrige según indicaciones:                     │
│     │  • Actualiza datos incorrectos                   │
│     │  • Carga documentos faltantes                    │
│     │  • Ajusta montos o descripciones                 │
│     ├─ Puede agregar comentario de respuesta           │
│     └─ Acción: "Reenviar a revisión"                   │
│        • Estado: en_revision                            │
│        • Etapa: supervisor (reinicia el flujo)         │
│        • Notifica al Supervisor                        │
└─────────────────────────────────────────────────────────┘
```

---

### 🔙 Devolución a Etapa Anterior

Cualquier rol puede devolver a la etapa inmediatamente anterior:

```
┌─────────────────────────────────────────────────────────┐
│  ORDENADOR DEL GASTO → Devolver a SUPERVISOR            │
│     ├─ Motivo: Necesita revisión adicional de docs      │
│     ├─ Mantiene estado: en_revision                     │
│     └─ Notifica al Supervisor                          │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  CONTRATACIÓN → Devolver a ORDENADOR DEL GASTO          │
│     ├─ Motivo: Requiere validación presupuestal extra   │
│     ├─ Mantiene estado: en_revision                     │
│     └─ Notifica al Ordenador del Gasto                 │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  ALCALDE → Devolver a CONTRATACIÓN                      │
│     ├─ Motivo: Requiere verificación contractual extra  │
│     ├─ Mantiene estado: en_revision                     │
│     └─ Notifica a Contratación                         │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  TESORERÍA → Reportar Error a ALCALDE                   │
│     ├─ Motivo: Datos bancarios incorrectos/incompletos  │
│     ├─ Mantiene estado: aprobado                        │
│     ├─ Etapa: regresa a alcalde temporalmente           │
│     └─ Notifica al Alcalde para corrección             │
└─────────────────────────────────────────────────────────┘
```

---

### ❌ Rechazo Definitivo

Cualquier rol puede rechazar definitivamente (No Aprobado):

```
┌─────────────────────────────────────────────────────────┐
│  ROL (Supervisor/Ordenador/Contratación/Alcalde)        │
│     ├─ Detecta incumplimiento grave o error de fondo   │
│     ├─ Ejemplos de motivos de rechazo:                 │
│     │  • Incumplimiento contractual grave              │
│     │  • Falta de disponibilidad presupuestal          │
│     │  • Documentación fraudulenta                     │
│     │  • Contrato vencido o inexistente                │
│     │  • Servicios no prestados                        │
│     │  • Decisión administrativa/política              │
│     └─ Acción: "Rechazar"                              │
│        • Estado: rechazado                              │
│        • Motivo obligatorio (detallado)                 │
│        • Proceso FINALIZADO (no se puede reabrir)       │
│        • Notifica al Contratista                       │
│        • Registro permanente en historial              │
└─────────────────────────────────────────────────────────┘
```

---

### 📝 Agregar Interacción (Sin cambiar estado)

Todos los roles pueden agregar comentarios sin cambiar el estado:

```
┌─────────────────────────────────────────────────────────┐
│  CUALQUIER ROL: Agregar Interacción                     │
│     ├─ Opción: "Agregar comentario"                    │
│     ├─ Usos:                                            │
│     │  • Solicitar aclaraciones                        │
│     │  • Documentar observaciones                      │
│     │  • Comunicarse con el contratista                │
│     │  • Dejar notas para otros revisores              │
│     ├─ NO cambia estado ni etapa                       │
│     ├─ Visible en historial completo                   │
│     ├─ Puede incluir archivos adjuntos                 │
│     └─ Notifica al contratista (opcional)              │
└─────────────────────────────────────────────────────────┘
```

---

## 👥 Roles y Permisos Detallados

### 🔹 Contratista
**Responsabilidad:** Crear y gestionar sus propias cuentas de cobro.

**Acciones permitidas:**
- ✅ Crear nuevas cuentas de cobro
- ✅ Cargar soportes (archivos PDF, imágenes)
- ✅ Ver el estado de sus cuentas
- ✅ Editar cuentas en estado `en_correccion`
- ✅ Reenviar cuentas después de correcciones
- ✅ Archivar/Desarchivar sus cuentas finalizadas
- ✅ Descargar PDF de sus cuentas

**Restricciones:**
- ❌ NO puede aprobar, revisar ni rechazar cuentas
- ❌ NO puede ver cuentas de otros contratistas
- ❌ NO puede modificar cuentas en revisión o aprobadas

**Vistas principales:**
- `/cuentas_cobro` - Listado de sus propias cuentas
- `/cuentas_cobro/create` - Crear nueva cuenta
- `/cuentas_cobro/{id}` - Ver detalle de cuenta propia

---

### 🔹 Supervisor
**Responsabilidad:** Primera validación de completitud y coherencia de documentos.

**Acciones permitidas:**
- ✅ Recibe notificación cuando Contratista crea o reenvía una cuenta
- ✅ Revisa completitud de datos y documentos adjuntos
- ✅ Valida coherencia de información del beneficiario y montos
- ✅ **Enviar al siguiente nivel** → Avanza a Ordenador del Gasto
- ✅ **Rechazar (No Aprobado)** → Finaliza la cuenta con motivo obligatorio
- ✅ **Agregar interacción** → Comentarios y observaciones sin cambiar estado
- ✅ Solicitar aclaraciones al contratista
- ✅ Ver historial completo de la cuenta
- ✅ Descargar PDF de la cuenta

**Restricciones:**
- ❌ NO puede crear cuentas
- ❌ NO puede editar datos de la cuenta
- ❌ NO puede devolver a etapas anteriores (es el primero)
- ❌ Solo ve cuentas en etapa `supervisor`

**Vistas principales:**
- `/aprobaciones` - Cuentas pendientes en etapa Supervisor
- `/cuentas_cobro/{id}` - Ver detalle con botones de acción
- `/notificaciones` - Bandeja de notificaciones

---

### 🔹 Ordenador del Gasto
**Responsabilidad:** Validar legalidad, presupuesto y orden de gasto.

**Acciones permitidas:**
- ✅ Recibe notificación cuando Supervisor envía una cuenta
- ✅ Valida disponibilidad presupuestal y CDP
- ✅ Revisa aspectos legales y normativos
- ✅ Verifica rubros presupuestales
- ✅ **Enviar al siguiente nivel** → Avanza a Contratación
- ✅ **Rechazar (No Aprobado)** → Finaliza la cuenta con motivo
- ✅ **Devolver a Supervisor** → Regresa a etapa anterior con observaciones
- ✅ **Agregar interacción** → Comentarios sin cambiar estado
- ✅ Enviar cuentas al cliente (una vez aprobadas por todas las áreas)
- ✅ Accede a reportes de pagos
- ✅ Ve todas las cuentas del municipio (auditoría)

**Restricciones:**
- ❌ NO puede crear cuentas de cobro
- ❌ Solo aprueba cuando está en etapa `ordenador_gasto`

**Vistas principales:**
- `/aprobaciones` - Cuentas en etapa Ordenador del Gasto
- `/cuentas_cobro` - Listado completo de cuentas (auditoría)
- `/cuentas_cobro/pagos` - Resumen de pagos realizados
- `/reportes` - Dashboard de reportes y estadísticas

---

### 🔹 Contratación
**Responsabilidad:** Validar que la cuenta corresponda a un contrato vigente y existente.

**Acciones permitidas:**
- ✅ Recibe notificación cuando Ordenador del Gasto envía una cuenta
- ✅ Valida existencia del contrato relacionado
- ✅ Valida vigencia y términos del contrato
- ✅ Verifica cumplimiento de obligaciones contractuales
- ✅ **Enviar al siguiente nivel** → Avanza a Alcalde
- ✅ **Devolver para corrección** → Regresa al Contratista (estado: en_correccion)
- ✅ **Devolver a Ordenador** → Regresa a etapa anterior
- ✅ **Rechazar (No Aprobado)** → Finaliza la cuenta por incumplimiento contractual
- ✅ **Agregar interacción** → Solicitar documentación del contrato
- ✅ Accede a detalles del contrato desde la cuenta
- ✅ Ver historial de correcciones

**Restricciones:**
- ❌ NO puede crear cuentas
- ❌ NO puede enviar directamente al cliente
- ❌ Solo ve cuentas en etapa `contratacion`

**Vistas principales:**
- `/aprobaciones` - Cuentas en etapa Contratación
- `/cuentas_cobro/{id}` - Ver con opciones de devolver/rechazar/aprobar
- `/contratacion/contratos` - Gestión de contratos

---

### 🔹 Alcalde
**Responsabilidad:** Aprobación final ejecutiva de la cuenta de cobro.

**Acciones permitidas:**
- ✅ Recibe notificación cuando Contratación envía una cuenta
- ✅ Revisión ejecutiva integral y validación política/administrativa
- ✅ Verificación de coherencia de todo el proceso
- ✅ **Aprobar y enviar a Tesorería** → Marca como `aprobado` definitivo
- ✅ **Rechazar (No Aprobado)** → Finaliza la cuenta por decisión ejecutiva
- ✅ **Devolver a Contratación** → Regresa a etapa anterior
- ✅ **Agregar interacción** → Observaciones ejecutivas
- ✅ Enviar cuentas al cliente (una vez aprobadas)
- ✅ Ve todas las cuentas del municipio
- ✅ Acceso a reportes ejecutivos

**Restricciones:**
- ❌ NO puede crear cuentas
- ❌ Solo aprueba cuando está en etapa `alcalde`

**Vistas principales:**
- `/aprobaciones` - Cuentas en etapa Alcalde
- `/cuentas_cobro` - Listado completo de cuentas
- `/reportes` - Dashboard ejecutivo

---

### 🔹 Tesorería
**Responsabilidad:** Procesar y ejecutar los pagos de cuentas aprobadas.

**Acciones permitidas:**
- ✅ Recibe notificación cuando Alcalde aprueba
- ✅ Revisa cuentas en estado `aprobado` y etapa `tesoreria`
- ✅ Valida información bancaria del beneficiario
- ✅ Verifica documentación tributaria
- ✅ **Registrar pago** → Ejecuta el pago y registra en el sistema
  - Valor pagado
  - Medio de pago (transferencia, consignación, cheque, PSE)
  - Referencia de transacción (obligatoria)
  - Fecha de pago
  - Comprobante adjunto
  - Observaciones
- ✅ **Enviar al cliente** → Cambia estado a `enviado_cliente`
- ✅ **Reportar error a Alcalde** → Devuelve para corrección de datos bancarios
- ✅ **Agregar interacción** → Solicitar certificados bancarios
- ✅ Actualiza `estado_pago` a `approved`
- ✅ Descarga PDF de la cuenta
- ✅ Accede a módulo de pagos completo
- ✅ Genera reportes de pagos ejecutados

**Restricciones:**
- ❌ NO puede editar datos de la cuenta (excepto información de pago)
- ❌ NO puede rechazar cuentas (solo reportar errores)
- ❌ NO puede crear cuentas
- ❌ Solo ve cuentas en etapa `tesoreria` o estado `aprobado`

**Vistas principales:**
- `/aprobaciones` - Cuentas en etapa Tesorería
- `/cuentas_cobro/pagos` - Registrar y ver pagos realizados
- `/cuentas_cobro/{id}` - Ver detalle con opción de pago
- `/reportes/pagos` - Reportes financieros

---

### 🔹 Super Admin
**Responsabilidad:** Control total del sistema.

**Acciones permitidas:**
- ✅ Puede **actuar en CUALQUIER ETAPA** del flujo
- ✅ Tiene **TODOS los permisos** de todos los roles
- ✅ Crear, editar, aprobar, rechazar y enviar cuentas
- ✅ Gestionar usuarios y roles
- ✅ Ver todas las cuentas y reportes
- ✅ Acceso completo a la administración

**Vistas principales:**
- Acceso total a todas las secciones
- `/admin/users` - Gestionar usuarios
- `/admin/roles` - Gestionar roles y permisos

---

## 📊 Estados y Opciones de la Cuenta

### Estados Principales

| Estado | Descripción | Color | Icono | Acciones Disponibles |
|--------|-------------|-------|-------|---------------------|
| `en_revision` | En proceso de revisión por alguna área | 🔵 Azul | visibility | Enviar/Rechazar/Devolver/Comentar |
| `en_correccion` | Devuelta al Contratista para correcciones | 🟠 Naranja | edit | Editar y Reenviar |
| `aprobado` | Aprobada por todas las áreas, lista para pago | 🟢 Verde | check_circle | Registrar Pago/Enviar Cliente |
| `rechazado` | Rechazada con motivo en alguna etapa | 🔴 Rojo | cancel | Ver motivo (finalizado) |
| `enviado_cliente` | Enviada al cliente final | 🟣 Morado | send | Registrar Pago (si Tesorería) |
| `pagado` | Pago registrado por Tesorería | 🟢 Verde claro | payments | Ver comprobante (finalizado) |

### Estados de Pago

| Estado Pago | Descripción | Cuando se Activa |
|-------------|-------------|------------------|
| `pending` | Pendiente de pago | Estado inicial, mientras está en revisión |
| `approved` | Pago realizado y registrado | Tesorería registra el pago completo |
| `rejected` | Pago rechazado/cancelado | Si la cuenta es rechazada en alguna etapa |

---

## 🏢 Etapas del Flujo

| Etapa | Rol Responsable | Acción Principal |
|-------|----------------|------------------|
| `supervisor` | Supervisor | Validación inicial de documentos |
| `ordenador_gasto` | Ordenador del Gasto | Validación presupuestal y legal |
| `contratacion` | Contratación | Validación de contrato |
| `alcalde` | Alcalde | Aprobación final ejecutiva |
| `tesoreria` | Tesorería | Registro de pago |
| `contratista` | Contratista | Corrección (solo si fue devuelta) |

---

## 🔔 Sistema de Notificaciones

El sistema envía notificaciones automáticas en los siguientes eventos:

1. **Cuenta creada** → Notifica a Supervisor
2. **Supervisor aprueba** → Notifica a Ordenador del Gasto
3. **Ordenador aprueba** → Notifica a Contratación
4. **Contratación aprueba** → Notifica a Alcalde
5. **Alcalde aprueba** → Notifica a Tesorería y al Contratista (aprobación final)
6. **Cuenta rechazada** → Notifica al Contratista con motivo
7. **Cuenta devuelta** → Notifica al Contratista para correcciones
8. **Cuenta reenviada** → Notifica a Supervisor (reinicia flujo)
9. **Pago registrado** → Notifica al Contratista

---

## 🛠️ Helpers del Modelo CuentaCobro

El modelo `CuentaCobro` incluye los siguientes métodos auxiliares para simplificar las vistas:

### Verificación de Estado
- `isEnRevision()` - ¿Está en revisión?
- `canUserApprove($user)` - ¿Puede este usuario aprobar según su rol y la etapa actual?
- `isOwner($user)` - ¿Es el usuario el contratista dueño?
- `canSendToClient($user)` - ¿Puede este usuario enviar al cliente?
- `canRegisterPayment($user)` - ¿Puede este usuario registrar pago?

### Obtención de Información
- `getEstadoTexto()` - Obtiene el texto legible del estado (ej: "En Revisión")
- `getEtapaTexto()` - Obtiene el texto legible de la etapa (ej: "Ordenador del Gasto")
- `getEstadoColor()` - Obtiene el color hexadecimal del estado (ej: "#007AFF")
- `getEstadoIcono()` - Obtiene el nombre del icono Material Symbols (ej: "visibility")

**Ejemplo de uso en Blade:**
```blade
@if($cuenta->canUserApprove(auth()->user()))
    <button>Aprobar etapa</button>
@endif

<span style="color: {{ $cuenta->getEstadoColor() }};">
    {{ $cuenta->getEstadoTexto() }}
</span>
```

---

## 📝 Consideraciones Importantes

### ⚠️ Reglas del Flujo Obligatorio

1. **Flujo OBLIGATORIO secuencial:** Todas las cuentas DEBEN pasar por las 5 etapas en orden estricto:
   ```
   Supervisor → Ordenador del Gasto → Contratación → Alcalde → Tesorería
   ```

2. **No se puede saltar etapas:** Cada área debe procesar antes de que la siguiente pueda intervenir.

3. **Super Admin como excepción:** Solo Super Admin puede aprobar/actuar en cualquier etapa sin restricciones.

---

### 🔄 Opciones de Intervención por Tipo

#### ✅ Enviar al Siguiente Nivel
- **Quién:** Todos los roles aprobadores (Supervisor, Ordenador, Contratación, Alcalde)
- **Cuándo:** Cuando la validación de su área es satisfactoria
- **Efecto:** Avanza a la siguiente etapa del flujo
- **Comentario:** Opcional pero recomendado

#### ❌ Rechazar (No Aprobado)
- **Quién:** Todos los roles aprobadores
- **Cuándo:** Error grave, incumplimiento de fondo, imposibilidad de continuar
- **Efecto:** FINALIZA el proceso definitivamente (no reversible)
- **Comentario:** Obligatorio con motivo detallado
- **Ejemplos:**
  - Contrato inexistente o vencido
  - Falta de presupuesto
  - Documentación fraudulenta
  - Incumplimiento contractual grave
  - Servicios no prestados

#### 🔄 Devolver para Corrección (al Contratista)
- **Quién:** Solo Contratación
- **Cuándo:** Errores menores de forma que el contratista puede corregir
- **Efecto:** Cambia a `estado: en_correccion`, el contratista puede editar
- **Comentario:** Obligatorio con observaciones específicas
- **Al reenviar:** La cuenta vuelve a Supervisor (reinicia el flujo completo)
- **Ejemplos:**
  - Error en datos del beneficiario
  - Documento ilegible o faltante
  - Inconsistencia en montos corregible
  - Información incompleta

#### 🔙 Devolver a Etapa Anterior
- **Quién:** Ordenador, Contratación, Alcalde, Tesorería
- **Cuándo:** Se necesita revisión adicional de la etapa anterior
- **Efecto:** Regresa una etapa atrás, mantiene `estado: en_revision` (o `aprobado` si es Tesorería)
- **Comentario:** Obligatorio con observaciones
- **Ejemplos:**
  - Ordenador devuelve a Supervisor: necesita validación adicional de documentos
  - Contratación devuelve a Ordenador: requiere verificación presupuestal extra
  - Alcalde devuelve a Contratación: necesita validación contractual adicional
  - Tesorería reporta a Alcalde: datos bancarios incorrectos

#### 📝 Agregar Interacción
- **Quién:** Todos los roles
- **Cuándo:** En cualquier momento durante la revisión
- **Efecto:** NO cambia estado ni etapa
- **Comentario:** Libre, puede incluir archivos adjuntos
- **Usos:**
  - Solicitar aclaraciones
  - Documentar observaciones internas
  - Comunicación con el contratista
  - Notas para otros revisores

---

### 💰 Proceso de Pago: Características Especiales

#### Validaciones Pre-Pago
1. **Información bancaria completa:**
   - Tipo de cuenta (ahorros/corriente)
   - Número de cuenta
   - Banco
   - Titular (debe coincidir con beneficiario)

2. **Documentación tributaria:**
   - RUT del beneficiario
   - Certificación bancaria (si aplica)
   - Retenciones aplicables

#### Registro de Pago
- **Campos obligatorios:**
  - Valor pagado (debe coincidir con valor de la cuenta)
  - Medio de pago (selección de lista)
  - Referencia de transacción
  
- **Campos opcionales:**
  - Fecha de pago (automática si no se especifica)
  - Observaciones
  
- **Comprobante:**
  - Adjuntar PDF o imagen del comprobante
  - Obligatorio para transferencias y consignaciones

#### Estados de Pago
- **`pending`:** Inicial, mientras está en revisión o aprobación
- **`approved`:** Pago registrado y ejecutado por Tesorería
- **`rejected`:** Si la cuenta es rechazada (no se puede pagar)

#### Notificaciones de Pago
- **Al Contratista:** Notificación inmediata con detalles del pago
- **Al Ordenador y Alcalde:** Notificación informativa (auditoría)
- **Contenido:** Valor, medio, referencia, fecha

---

### 🔔 Sistema de Notificaciones Automáticas

Todas las notificaciones se envían automáticamente en estos eventos:

| Evento | Destinatario | Contenido |
|--------|--------------|-----------|
| Cuenta creada | Supervisor | "Nueva cuenta para revisión #[número]" |
| Supervisor envía | Ordenador del Gasto | "Cuenta para validación presupuestal #[número]" |
| Ordenador envía | Contratación | "Cuenta para validación contractual #[número]" |
| Contratación envía | Alcalde | "Cuenta para aprobación ejecutiva #[número]" |
| Alcalde aprueba | Tesorería + Contratista | "Cuenta aprobada, pendiente de pago #[número]" |
| Cuenta rechazada | Contratista | "Cuenta rechazada: [motivo]" |
| Devolver a corrección | Contratista | "Cuenta devuelta para corrección: [observaciones]" |
| Contratista reenvía | Supervisor | "Cuenta reenviada después de correcciones #[número]" |
| Devolver a etapa anterior | Rol anterior | "Cuenta devuelta para revisión adicional" |
| Pago registrado | Contratista | "Pago realizado: $[valor] - Ref: [referencia]" |
| Error reportado | Alcalde (desde Tesorería) | "Error en datos bancarios de cuenta #[número]" |

---

### 📊 Historial y Trazabilidad

Todo cambio queda registrado permanentemente:

- ✅ Cambios de estado
- ✅ Cambios de etapa
- ✅ Aprobaciones y rechazos
- ✅ Devoluciones y correcciones
- ✅ Comentarios e interacciones
- ✅ Registro de pagos
- ✅ Usuario que realizó cada acción
- ✅ Fecha y hora exacta
- ✅ Comentarios asociados

**Visualización:**
- Línea de tiempo cronológica
- Iconos por tipo de acción
- Colores por tipo de cambio
- Comentarios expandibles
- Archivos adjuntos en interacciones

---

### 🎯 Mejores Prácticas

1. **Siempre agregar comentarios al aprobar/rechazar:**
   - Documenta tu decisión
   - Facilita auditorías
   - Ayuda a otros revisores

2. **Usar "Devolver para corrección" para errores menores:**
   - Solo errores de forma (no de fondo)
   - Proporciona observaciones claras
   - El contratista puede corregir y reenviar

3. **Usar "Rechazar" para errores graves:**
   - Incumplimientos contractuales
   - Falta de presupuesto
   - Imposibilidad de continuar
   - Proporciona motivo detallado

4. **Agregar interacciones antes de decidir:**
   - Solicita aclaraciones si tienes dudas
   - Documenta observaciones
   - No cambies estado hasta tener claridad

5. **Validar información bancaria cuidadosamente:**
   - Verificar todos los datos antes de pagar
   - Solicitar certificación bancaria si hay dudas
   - Reportar errores a Alcalde antes de procesar

6. **Registrar pagos con toda la información:**
   - Adjuntar siempre el comprobante
   - Referencia completa y clara
   - Observaciones si hay retenciones o ajustes

---

## 🚀 Paso a Paso: Desde la Creación hasta el Pago

### Paso 1: Contratista crea la cuenta ✏️
1. Navega a **Cuentas de Cobro** > **Nueva Cuenta**
2. Completa todos los campos requeridos:
   - Datos del beneficiario
   - Número de cuenta
   - Fecha
   - Observaciones
3. Agrega ítems de la cuenta (descripción, cantidad, precio unitario)
4. Adjunta soportes obligatorios (facturas, comprobantes, etc.)
5. Clic en **Crear Cuenta de Cobro**
6. **Resultado:** 
   - `estado_aprobacion: en_revision` 
   - `etapa_aprobacion: supervisor`
   - Notificación enviada al Supervisor

---

### Paso 2: Supervisor revisa 🔍
1. Recibe notificación en bandeja
2. Navega a **Aprobaciones**
3. Revisa:
   - Completitud de documentos
   - Coherencia de datos y montos
   - Datos del beneficiario
4. **Opciones disponibles:**
   
   **A) ✅ Enviar al siguiente nivel**
   - Agrega comentario opcional
   - Sistema avanza a `etapa: ordenador_gasto`
   - Notifica al Ordenador del Gasto
   - Mantiene `estado: en_revision`
   
   **B) ❌ Rechazar (No Aprobado)**
   - Requiere motivo obligatorio
   - Cambia a `estado: rechazado`
   - Proceso FINALIZADO
   - Notifica al Contratista
   
   **C) 📝 Agregar interacción**
   - Comentario sin cambiar estado
   - Solicitar aclaraciones
   - Visible en historial

---

### Paso 3: Ordenador del Gasto valida 💰
1. Recibe notificación
2. Navega a **Aprobaciones**
3. Valida:
   - Disponibilidad presupuestal
   - CDP y rubros
   - Aspectos legales y normativos
4. **Opciones disponibles:**
   
   **A) ✅ Enviar al siguiente nivel**
   - Confirma disponibilidad presupuestal
   - Sistema avanza a `etapa: contratacion`
   - Notifica a Contratación
   
   **B) ❌ Rechazar (No Aprobado)**
   - Motivo obligatorio (ej: falta presupuesto)
   - Cambia a `estado: rechazado`
   - Proceso FINALIZADO
   
   **C) 🔙 Devolver a Supervisor**
   - Regresa a `etapa: supervisor`
   - Con observaciones para nueva revisión
   - Mantiene `estado: en_revision`
   
   **D) 📝 Agregar interacción**
   - Solicitar documentación adicional

---

### Paso 4: Contratación valida contrato 📄
1. Recibe notificación
2. Navega a **Aprobaciones**
3. Valida:
   - Existencia del contrato
   - Vigencia y términos
   - Obligaciones contractuales
   - Cumplimiento de requisitos
4. **Opciones disponibles:**
   
   **A) ✅ Enviar al siguiente nivel**
   - Confirma validación contractual
   - Sistema avanza a `etapa: alcalde`
   - Notifica al Alcalde
   
   **B) ❌ Rechazar (No Aprobado)**
   - Motivo obligatorio (ej: contrato vencido)
   - Cambia a `estado: rechazado`
   - Proceso FINALIZADO
   
   **C) 🔄 Devolver para corrección**
   - Cambia a `estado: en_correccion`
   - Cambia a `etapa: contratista`
   - Motivo obligatorio con observaciones
   - Contratista puede editar y reenviar
   - **Al reenviar:** Vuelve a `supervisor` (reinicia flujo)
   
   **D) 🔙 Devolver a Ordenador**
   - Regresa a `etapa: ordenador_gasto`
   - Para validación presupuestal extra
   - Mantiene `estado: en_revision`
   
   **E) 📝 Agregar interacción**
   - Solicitar documentación contractual

---

### Paso 5: Alcalde aprueba ejecutivamente 👔
1. Recibe notificación
2. Navega a **Aprobaciones**
3. Realiza revisión ejecutiva:
   - Validación integral del proceso
   - Aspectos políticos y administrativos
   - Coherencia de todas las validaciones previas
4. **Opciones disponibles:**
   
   **A) ✅ Aprobar y enviar a Tesorería**
   - Cambia a `estado: aprobado` ⭐
   - Cambia a `etapa: tesoreria`
   - Registra fecha de aprobación
   - Registra aprobador
   - Notifica a Tesorería Y al Contratista
   - **Cuenta OFICIALMENTE APROBADA**
   
   **B) ❌ Rechazar (No Aprobado)**
   - Motivo obligatorio (decisión ejecutiva)
   - Cambia a `estado: rechazado`
   - Proceso FINALIZADO
   
   **C) 🔙 Devolver a Contratación**
   - Regresa a `etapa: contratacion`
   - Para revisión contractual adicional
   - Mantiene `estado: en_revision`
   
   **D) 📝 Agregar interacción**
   - Observaciones ejecutivas

---

### Paso 6: Tesorería procesa pago 💵
1. Recibe notificación de cuenta aprobada
2. Navega a **Aprobaciones** o **Pagos**
3. Valida:
   - Información bancaria del beneficiario
   - Documentación tributaria (RUT, certificación bancaria)
   - Datos completos para transferencia
4. **Opciones disponibles:**
   
   **A) 💰 Registrar pago**
   - Accede al formulario de registro de pago
   - Completa información:
     * **Valor pagado:** Validación con valor de la cuenta
     * **Medio de pago:** Dropdown
       - Transferencia bancaria
       - Consignación
       - Cheque
       - PSE
       - Otro
     * **Referencia de transacción:** Obligatorio (número de transferencia)
     * **Fecha de pago:** Automática o manual
     * **Comprobante:** Adjuntar PDF/imagen del comprobante
     * **Observaciones:** Opcional
   - Sistema actualiza:
     * `estado_pago: approved`
     * `fecha_pago: [fecha registrada]`
     * `pagado_por_id: [ID del tesorero]`
   - Genera registro en historial
   - Notifica al Contratista: "Pago realizado"
   - **Cuenta marcada como PAGADA** ✅
   
   **B) 📤 Enviar al cliente**
   - Cambia a `estado: enviado_cliente`
   - Mantiene `etapa: tesoreria`
   - PDF disponible para cliente externo
   - Puede seguir registrando pago después
   
   **C) 🔙 Reportar error a Alcalde**
   - Detecta datos bancarios incorrectos/incompletos
   - Devuelve temporalmente a `etapa: alcalde`
   - Mantiene `estado: aprobado`
   - Alcalde coordina corrección con contratista
   - Una vez corregido, regresa a Tesorería
   
   **D) 📝 Agregar interacción**
   - Solicitar certificación bancaria
   - Aclaraciones sobre datos de pago

---

### Paso 7: Seguimiento post-pago 📊
1. **Contratista:**
   - Recibe notificación de pago realizado
   - Puede ver detalle del pago
   - Confirma recepción del dinero
   - Descarga PDF y comprobante

2. **Sistema:**
   - Marca cuenta como finalizada (pagada)
   - Archiva documentación
   - Disponible en reportes de pagos
   - Historial completo preservado

3. **Auditoría:**
   - Ordenador y Alcalde pueden ver registro
   - Reportes de pagos ejecutados
   - Trazabilidad completa del proceso

---

## 🎯 Matriz de Decisiones por Rol

Esta tabla resume qué puede hacer cada rol en cada etapa:

| Rol | Etapa Actual | ✅ Enviar | ❌ Rechazar | 🔄 Devolver Corrección | 🔙 Devolver Anterior | 📝 Interacción | 💰 Pago | 📤 Enviar Cliente |
|-----|--------------|-----------|-------------|----------------------|---------------------|---------------|---------|------------------|
| **Supervisor** | supervisor | ✅ A Ordenador | ✅ Finalizar | ❌ | ❌ | ✅ | ❌ | ❌ |
| **Ordenador** | ordenador_gasto | ✅ A Contratación | ✅ Finalizar | ❌ | ✅ A Supervisor | ✅ | ❌ | ✅ (si aprobada) |
| **Contratación** | contratacion | ✅ A Alcalde | ✅ Finalizar | ✅ A Contratista | ✅ A Ordenador | ✅ | ❌ | ❌ |
| **Alcalde** | alcalde | ✅ A Tesorería | ✅ Finalizar | ❌ | ✅ A Contratación | ✅ | ❌ | ✅ (si aprobada) |
| **Tesorería** | tesoreria | ❌ | ❌ | ❌ | ✅ Reportar a Alcalde | ✅ | ✅ Registrar | ✅ |
| **Contratista** | contratista | ✅ Reenviar* | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| **Super Admin** | cualquiera | ✅ Todas | ✅ Todas | ✅ Todas | ✅ Todas | ✅ | ✅ | ✅ |

*Solo cuando la cuenta está en `estado: en_correccion`

---

## 🔐 Matriz de Permisos de Visualización

| Rol | Ver Propias | Ver Todas | Ver Historial | Editar | Eliminar | Descargar PDF |
|-----|------------|-----------|---------------|--------|----------|---------------|
| **Contratista** | ✅ | ❌ | ✅ (propias) | ✅ (en_correccion) | ❌ | ✅ |
| **Supervisor** | ❌ | ✅ (su etapa) | ✅ | ❌ | ❌ | ✅ |
| **Ordenador** | ❌ | ✅ (todas)* | ✅ | ❌ | ❌ | ✅ |
| **Contratación** | ❌ | ✅ (su etapa) | ✅ | ❌ | ❌ | ✅ |
| **Alcalde** | ❌ | ✅ (todas)* | ✅ | ❌ | ❌ | ✅ |
| **Tesorería** | ❌ | ✅ (aprobadas) | ✅ | ❌ | ❌ | ✅ |
| **Super Admin** | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |

*Auditoría completa del municipio

---

## 📞 Soporte y Documentación Adicional

### 📚 Documentos Relacionados
Para más información sobre el sistema, consulta los siguientes archivos:

- **`FLUJO_DOCUMENTOS.md`** - Documentación detallada del flujo original
- **`ARQUITECTURA_PROCESO.md`** - Arquitectura técnica del proyecto
- **`VERIFICACION_ROL_CONTRATACION.md`** - Guía de verificación de roles

### 🔧 Recursos Técnicos

#### Helpers del Modelo CuentaCobro
El modelo incluye métodos auxiliares para simplificar las vistas:

**Verificación de Estado:**
```php
$cuenta->isEnRevision()                    // ¿Está en revisión?
$cuenta->canUserApprove($user)             // ¿Puede este usuario aprobar?
$cuenta->isOwner($user)                    // ¿Es el dueño?
$cuenta->canSendToClient($user)            // ¿Puede enviar al cliente?
$cuenta->canRegisterPayment($user)         // ¿Puede registrar pago?
```

**Obtención de Información:**
```php
$cuenta->getEstadoTexto()                  // "En Revisión", "Aprobado", etc.
$cuenta->getEtapaTexto()                   // "Supervisor", "Ordenador del Gasto", etc.
$cuenta->getEstadoColor()                  // "#007AFF", "#34C759", etc.
$cuenta->getEstadoIcono()                  // "visibility", "check_circle", etc.
```

**Ejemplo de uso en Blade:**
```blade
@if($cuenta->canUserApprove(auth()->user()))
    <button class="btn-approve">Enviar al siguiente nivel</button>
@endif

<span style="color: {{ $cuenta->getEstadoColor() }};">
    <span class="material-symbols-rounded">{{ $cuenta->getEstadoIcono() }}</span>
    {{ $cuenta->getEstadoTexto() }}
</span>
```

### 📊 Reportes Disponibles

1. **Dashboard General:**
   - Total de cuentas por estado
   - Total de cuentas por etapa
   - Valor total pendiente de pago
   - Valor total pagado

2. **Reportes de Pagos:**
   - Pagos realizados por período
   - Pagos por medio de pago
   - Pagos por contratista
   - Exportación a Excel/PDF

3. **Auditoría:**
   - Historial completo de movimientos
   - Tiempo promedio por etapa
   - Cuentas rechazadas por motivo
   - Cuentas devueltas para corrección

### ⚡ Actualizaciones Recientes

**Versión 2.0 - Noviembre 2025**
- ✅ Flujo obligatorio de 5 etapas implementado
- ✅ Opciones de devolución a etapa anterior
- ✅ Opciones de devolver para corrección (Contratación)
- ✅ Sistema de interacciones sin cambiar estado
- ✅ Mejora en el proceso de registro de pagos
- ✅ Notificaciones automáticas en todos los puntos del flujo
- ✅ Helpers del modelo para simplificar vistas
- ✅ Matriz de decisiones por rol
- ✅ Cambio de botón "Aprobar etapa" a "Enviar al siguiente nivel"
- ✅ Mejora en mensajes de éxito con terminología consistente

### 🐛 Problemas Comunes y Soluciones

#### Problema: No puedo ver el botón "Enviar al siguiente nivel"
**Solución:** Verifica que:
- Tu usuario tenga el rol correcto
- La cuenta esté en la etapa que corresponde a tu rol
- La cuenta no esté rechazada o pagada

#### Problema: No puedo editar una cuenta
**Solución:** 
- Solo el contratista puede editar
- Solo cuando la cuenta está en `estado: en_correccion`
- Verifica que seas el dueño de la cuenta

#### Problema: No recibo notificaciones
**Solución:** 
- Verifica tu perfil de usuario
- Revisa la sección `/notificaciones`
- Consulta con el administrador

#### Problema: Error al registrar pago
**Solución:**
- Verifica que todos los campos obligatorios estén completos
- La referencia de transacción es obligatoria
- El valor debe coincidir con el valor de la cuenta
- Adjunta el comprobante de pago

### 📧 Contacto

Para asistencia técnica o reportar problemas:
- **Email:** soporte@municipio.gov.co
- **Teléfono:** (000) 000-0000
- **Horario:** Lunes a Viernes, 8:00 AM - 5:00 PM

---

**Última actualización:** Noviembre 5, 2025  
**Versión del sistema:** 2.1 - Flujo Obligatorio con Opciones Mejoradas  
**Documento:** PROCESO_COMPLETO_CUENTAS_COBRO.md
