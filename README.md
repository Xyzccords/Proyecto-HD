"# ProyectoHerramientasDesarrollo" 
Este proyecto tiene como objetivo poner en práctica el uso de **Git y GitHub** para la gestión de versiones, ramas, commits y fusiones entre entornos de desarrollo.  

## Funcionalidades
- Gestión de ramas con flujos de trabajo organizados.
- Desarrollo modular con las siguientes ramas:
  - `developer`: rama principal de desarrollo.
  - `feature-pagos`: implementación de funcionalidades relacionadas a pagos.
  - `feature-recibo`: implementación de funcionalidades relacionadas a recibos.
- Ejemplos de commits, merges y resolución de conflictos.

## Estructura del proyecto

Este proyecto está organizado en los siguientes directorios y archivos:

### 📁 Carpetas
- `css/` — Archivos de estilos CSS.
- `images/` — Imágenes utilizadas en el sitio.
- `js/` — Scripts JavaScript.

### 📄 Archivos
- `.gitignore` — Configuración para excluir archivos del control de versiones.
- `README.md` — Documentación del proyecto.
- `connection.php` — Conexión a la base de datos.
- `functions.php` — Funciones reutilizables del sistema.
- `index.php` — Página principal del proyecto.
- `presentation.html` — Página de presentación (HTML estático).
- `receipt.php` — Generación de comprobantes de pago.
- `register_payment.php` — Registro de pagos.
- `save_payment.php` — Guardado de pagos en la base de datos.
- `student.php` — Listado de estudiantes.
- `student_add.php` — Añadir nuevo estudiante.
- `student_delete.php` — Eliminar estudiante.
- `student_edit.php` — Editar información de estudiante.

---

Esta estructura refleja un sistema web que gestiona estudiantes y pagos, con una separación clara entre lógica de servidor (PHP), presentación (HTML/CSS/JS) y recursos multimedia.

## Flujo de ramas
1. Las nuevas características se crean en ramas `feature-*`.  
2. Una vez listas, se integran en `developer` mediante **merge**.  
3. Desde `developer`, se puede preparar la integración hacia `main` (producción).

Ejemplo:
```bash
# Estar en developer
git checkout developer

# Traer cambios de una rama feature
git merge feature-pagos
git merge feature-recibo

# Subir cambios
git push origin developer
