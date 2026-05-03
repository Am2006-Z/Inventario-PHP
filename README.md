# 🖥️ Sistema de Inventario de Computadores

## Descripción

Sistema web completo de gestión de inventario de computadores desarrollado con **PHP MVC**, diseñado para XAMPP. Permite gestionar computadores, asignaciones y usuarios con control de acceso basado en roles (Admin, Empleado, Usuario).

## ✨ Características Principales

### 🔐 Sistema de Autenticación
- Tres roles diferentes: **Admin**, **Empleado**, **Usuario**
- Contraseñas encriptadas con bcrypt
- Sesiones seguras

### 💻 Gestión de Computadores
- Crear, leer, actualizar y eliminar computadores
- Información técnica completa (procesador, RAM, almacenamiento, S.O.)
- Estados: Disponible, Asignado, Mantenimiento, Fuera de Uso
- Búsqueda y filtrado
- Gestión de marcas y categorías

### 📦 Gestión de Asignaciones
- Asignar computadores a empleados
- Devolver computadores con registro de observaciones
- Historial completo de asignaciones
- Seguimiento de tiempo de asignación

### 👥 Gestión de Usuarios (Admin)
- Crear usuarios con diferentes roles
- Gestionar rol y estado de usuarios
- Asignación directa de sistemas a usuarios

### 📊 Dashboard
- Estadísticas en tiempo real
- Visualización de asignaciones activas
- Acceso rápido a funciones principales

## 🚀 Instalación

### Requisitos
- **XAMPP** (Apache + PHP 7.4+)
- **SQLite** (incluido en PHP)
- Navegador web moderno

### Pasos

1. **Mover proyecto a XAMPP**
   ```bash
   # En Windows
   xcopy /E /I . C:\xampp\htdocs\inventario
   ```

2. **Iniciar XAMPP**
   - Abre el panel de control de XAMPP
   - Inicia Apache

3. **Acceder a la aplicación**
   ```
   http://localhost/inventario/web/
   ```

## 🔑 Usuarios de Prueba

| Usuario    | Contraseña    | Rol      |
|-----------|--------------|----------|
| admin     | admin123     | Admin    |
| empleado  | empleado123  | Empleado |
| usuario   | usuario123   | Usuario  |

## 📁 Estructura del Proyecto

```
MVC-2/
├── controller/        # Controladores
├── model/            # Modelos de datos
├── view/             # Vistas
├── lib/              # Librerías
├── web/              # Archivos web (CSS, JS)
└── data/             # Base de datos SQLite
```

## 🔑 Funcionalidades por Rol

- **Admin**: Acceso total, gestiona usuarios
- **Empleado**: Gestiona inventario y asignaciones
- **Usuario**: Solo puede ver inventario

## 🛠️ Tecnologías

- PHP 7.4+
- SQLite
- Bootstrap 4.5
- Font Awesome 5
