# Guía de Habilitación DIAN

Esta guía documenta el proceso de habilitación ante la DIAN para la emisión de documentos electrónicos (factura electrónica, documento soporte, etc.).

## Requisitos Previos

- [ ] Inscripción en el RUT como obligado a facturar electrónicamente
- [ ] Certificado digital de firma electrónica emitido por una autoridad certificadora autorizada
- [ ] Registro en el portal de la DIAN
- [ ] Software de facturación certificado o en proceso de certificación

## Proceso de Habilitación

### 1. Obtención del Certificado Digital

El certificado digital debe ser emitido por una autoridad certificadora autorizada por la DIAN:
- Certicámara
- GSE
- Andes SCD
- Otras entidades autorizadas

**Pasos:**
1. Solicitar el certificado digital a la entidad certificadora
2. Validar los datos del solicitante
3. Descargar el certificado en formato .p12 o .pfx
4. Almacenar de manera segura la contraseña del certificado

### 2. Registro en el Portal de la DIAN

**URL:** https://www.dian.gov.co/

**Pasos:**
1. Acceder al portal de facturación electrónica
2. Registrar la empresa como facturador electrónico
3. Configurar los puntos de venta y sucursales
4. Solicitar autorización de numeración

### 3. Habilitación en Ambiente de Pruebas (SET)

El ambiente de pruebas (SET - Software de Evidencia Transaccional) permite validar la correcta implementación antes de pasar a producción.

**URL SET:** https://catalogo-vpfe-hab.dian.gov.co/

**Pasos:**
1. Configurar el software con las credenciales del SET
2. Realizar pruebas de emisión de documentos
3. Validar la respuesta de la DIAN
4. Corregir errores identificados
5. Obtener al menos 5 documentos exitosos

**Tipos de documentos a probar:**
- Factura de venta
- Nota crédito
- Nota débito
- Documento soporte de nómina (si aplica)
- Documento equivalente (si aplica)

### 4. Habilitación en Ambiente de Producción

Una vez completadas las pruebas exitosamente en el SET, se debe solicitar la habilitación en producción.

**URL Producción:** https://catalogo-vpfe.dian.gov.co/

**Pasos:**
1. Solicitar habilitación ante la DIAN
2. Presentar evidencias de las pruebas realizadas
3. Esperar la autorización de la DIAN (puede tomar varios días)
4. Configurar el software con las credenciales de producción
5. Realizar pruebas de emisión real
6. Verificar la publicación de documentos en el portal de la DIAN

### 5. Solicitud de Numeración

**Pasos:**
1. Ingresar al portal de la DIAN
2. Solicitar autorización de numeración para cada tipo de documento
3. Especificar:
   - Tipo de documento
   - Prefijo (opcional)
   - Rango de numeración (desde - hasta)
   - Vigencia (fecha inicio - fecha fin)
4. Descargar la resolución de autorización
5. Configurar los rangos en el sistema

## Configuración en el Sistema

### Variables de Entorno

```
DIAN_ENVIRONMENT=set|production
DIAN_CERTIFICATE_PATH=/path/to/certificate.p12
DIAN_CERTIFICATE_PASSWORD=your_password
DIAN_TEST_SET_ID=your_test_set_id
DIAN_SOFTWARE_ID=your_software_id
DIAN_PIN=your_pin
```

### Base de Datos

El sistema incluye dos tablas para la gestión de la integración con la DIAN:

#### Tabla: dian_configurations

Almacena la configuración de acceso a los servicios de la DIAN:
- Ambiente (SET o Producción)
- Credenciales de acceso
- URLs de los servicios
- Identificadores del software

#### Tabla: dian_numerations

Almacena las numeraciones autorizadas por la DIAN:
- Tipo de documento
- Prefijo
- Rango de numeración (desde - hasta)
- Número actual
- Vigencia
- Resolución de autorización

## Checklist de Implementación

- [ ] Obtener certificado digital
- [ ] Registrar en portal DIAN
- [ ] Crear configuración en `dian_configurations`
- [ ] Solicitar numeración autorizada
- [ ] Registrar numeración en `dian_numerations`
- [ ] Configurar ambiente SET
- [ ] Realizar pruebas en SET (mínimo 5 documentos exitosos)
- [ ] Solicitar habilitación en producción
- [ ] Configurar ambiente de producción
- [ ] Realizar pruebas en producción
- [ ] Documentar procedimientos operativos
- [ ] Capacitar usuarios

## Documentación Técnica

### Servicios Web DIAN

La DIAN proporciona servicios web SOAP para la emisión de documentos electrónicos:

- **Emisión de documentos:** Permite enviar documentos electrónicos a la DIAN
- **Consulta de estados:** Permite consultar el estado de procesamiento de un documento
- **Consulta de numeración:** Permite consultar los rangos de numeración autorizados

### Drivers Implementados

El sistema implementa un patrón de drivers para facilitar el cambio entre ambientes:

- **SetDriver:** Para interactuar con el ambiente de pruebas (SET)
- **ProductionDriver:** Para interactuar con el ambiente de producción

Ambos drivers implementan la interfaz `DianDriverInterface` que define los métodos comunes.

## Troubleshooting

### Problemas Comunes

1. **Certificado inválido o expirado:**
   - Verificar la fecha de vigencia del certificado
   - Validar que la contraseña sea correcta
   - Confirmar que el certificado esté en formato correcto

2. **Error de autenticación:**
   - Verificar las credenciales (TestSetId, SoftwareId, PIN)
   - Confirmar que el ambiente esté correctamente configurado

3. **Numeración no autorizada:**
   - Verificar que la numeración esté vigente
   - Confirmar que no se haya agotado el rango
   - Validar que el prefijo y tipo de documento sean correctos

4. **Documento rechazado:**
   - Revisar los logs de errores devueltos por la DIAN
   - Validar que todos los campos obligatorios estén presentes
   - Confirmar que los cálculos matemáticos sean correctos

## Referencias

- [Portal de Facturación Electrónica DIAN](https://www.dian.gov.co/fizcalizacioncontrol/herramienconsulta/FacturaElectronica/Paginas/default.aspx)
- [Documentación Técnica DIAN](https://www.dian.gov.co/fizcalizacioncontrol/herramienconsulta/FacturaElectronica/Documentos-Tecnicos/Paginas/default.aspx)
- [Preguntas Frecuentes](https://www.dian.gov.co/fizcalizacioncontrol/herramienconsulta/FacturaElectronica/Preguntas-frecuentes/Paginas/default.aspx)

## Contacto y Soporte

Para soporte técnico, contactar a:
- Mesa de ayuda DIAN: contacto@dian.gov.co
- Línea de atención: 057 (601) 307 8064
