# 🚀 Guía Rápida - Sistema de Inventario

## Inicio Rápido

### 1️⃣ Instalación (5 minutos)

```bash
# Copiar la carpeta MVC-2 a la carpeta htdocs de XAMPP
C:\xampp\htdocs\inventario\

# Iniciar Apache desde el panel de XAMPP
# Abrir navegador:
http://localhost/inventario/web/
```

### 2️⃣ Primer Acceso

**URL**: `http://localhost/inventario/web/`

**Cuenta de prueba** (Admin):
- Usuario: `admin`
- Contraseña: `admin123`

## 📋 Flujo de Trabajo

### Para Gerentes (Admin)

```
1. Login con admin/admin123
   ↓
2. Dashboard → Ver estadísticas
   ↓
3. Ir a "Computadores" → Crear nuevo
   ↓
4. Ir a "Asignaciones" → Nueva asignación
   ↓
5. Ir a "Usuarios" → Crear usuarios adicionales
```

### Para Empleados (Empleado)

```
1. Login con empleado/empleado123
   ↓
2. Dashboard → Ver estado del inventario
   ↓
3. "Computadores" → Ver disponibles
   ↓
4. "Asignaciones" → Asignar a empleado
   ↓
5. "Historial" → Ver devoluciones
```

### Para Usuarios Finales (Usuario)

```
1. Login con usuario/usuario123
   ↓
2. Dashboard → Información general
   ↓
3. "Computadores" → Ver detalles técnicos
```

## 🎯 Tareas Comunes

### ➕ Crear un Computador

1. Hacer login como **Admin** o **Empleado**
2. Click en **Computadores** → **+ Nuevo Computador**
3. Llenar formulario:
   - Serial (obligatorio, único)
   - Marca y Categoría
   - Especificaciones técnicas
   - Costo (opcional)
4. Click en **Guardar**

### 📌 Asignar un Computador

1. Ir a **Asignaciones** → **+ Nueva Asignación**
2. Seleccionar computador disponible
3. Ingresar datos del empleado:
   - Nombre
   - Departamento
   - Usuario del sistema (opcional)
4. Click **Confirmar Asignación**
5. Computador cambia a estado "Asignado"

### 🔄 Devolver un Computador

1. Ir a **Asignaciones** (estarán las activas)
2. Click en **Devolver** en el computador a devolver
3. Registrar observaciones (estado del equipo)
4. Click **Confirmar Devolución**
5. Computador vuelve a "Disponible"

### 👤 Crear Nuevo Usuario

1. Login como **Admin**
2. Ir a **Usuarios** → **+ Nuevo Usuario**
3. Llenar datos:
   - Usuario (sin espacios)
   - Nombre completo
   - Email
   - Rol (Admin, Empleado, Usuario)
   - Contraseña
4. Click **Crear Usuario**

## 📊 Estados de Computador

| Estado | Descripción |
|--------|------------|
| 🟢 Disponible | Listo para asignar |
| 🟡 Asignado | En uso por empleado |
| 🔴 Mantenimiento | En reparación |
| ⚫ Fuera de Uso | No operativo |

## 🔐 Roles y Permisos

### Admin
- ✅ Ver/Crear/Editar/Eliminar computadores
- ✅ Gestionar asignaciones
- ✅ Crear y gestionar usuarios
- ✅ Ver estadísticas completas

### Empleado
- ✅ Ver todos los computadores
- ✅ Crear/Editar computadores
- ✅ Gestionar asignaciones
- ✅ Ver historial

### Usuario
- ✅ Ver computadores disponibles
- ❌ No puede crear/editar
- ❌ No puede gestionar asignaciones

## 🐛 Problemas Comunes

### "Error: Página no encontrada"
- Verifica que XAMPP esté iniciado
- Verifica que Apache está corriendo
- Revisa la URL: debe ser `http://localhost/inventario/web/`

### "No puedo iniciar sesión"
- Verifica usuario y contraseña (sensibles a mayúsculas)
- Limpia cookies del navegador
- Intenta con `admin / admin123`

### "La base de datos no se crea"
- Verifica que la carpeta `data/` exista
- Comprueba permisos de escritura de Apache
- Reinicia Apache

### "No veo el CSS"
- Limpia caché del navegador (Ctrl+Shift+R)
- Verifica que los archivos en `/web/css/` existan

## 📞 Teclas de Ayuda

- **Ctrl + Shift + R**: Limpiar caché
- **F12**: Abrir herramientas del navegador
- **Ctrl + K**: Búsqueda en tabla

## 📚 Comandos Útiles

### Ver logs de Apache
```bash
C:\xampp\apache\logs\error.log
```

### Reiniciar PHP
```bash
# En XAMPP, detener y reiniciar Apache
```

### Acceder a la base de datos
```bash
# SQLite (opcional)
sqlite3 data/database.sqlite
```

## 📈 Próximos Pasos

Después de instalado, puedes:

1. **Crear tu inventario**: Agregar todos los computadores
2. **Crear usuarios**: Dar acceso a empleados
3. **Empezar asignaciones**: Registrar quién tiene qué equipo
4. **Monitorear**: Usar dashboard para estadísticas

## 💡 Tips

- Usa seriales únicos y fáciles de identificar
- Registra costo y fecha de adquisición para auditoría
- Revisa historial de asignaciones regularmente
- Backup de `data/database.sqlite` periódicamente

---

**¿Necesitas más ayuda?** Consulta el README.md completo

**Versión**: 1.0 | **Actualizado**: Abril 2026
