# Sistema de Gestión de Hombre - PILATOS

## Descripción
Sistema web para gestionar productos de la categoría "Hombre" en la tienda PILATOS. Permite crear, editar, eliminar y visualizar productos con imágenes múltiples.

## Características
- ✅ Registro de productos con código único
- ✅ Subida de hasta 4 imágenes por producto
- ✅ Edición de productos existentes
- ✅ Eliminación de productos
- ✅ Búsqueda por código
- ✅ Validación de formularios
- ✅ Interfaz responsive con Bootstrap 5

## Campos de la Base de Datos
- `id_hombre` - ID único autoincremental
- `cod_hombre` - Código del producto (único)
- `img_hombre_1` - Ruta de la primera imagen
- `img_hombre_2` - Ruta de la segunda imagen
- `img_hombre_3` - Ruta de la tercera imagen
- `img_hombre_4` - Ruta de la cuarta imagen
- `nom_produc_hombre` - Nombre del producto
- `descripcion_hombre` - Descripción del producto
- `precio_hombre` - Precio del producto
- `fecha_creacion` - Fecha de creación automática

## Instalación

### 1. Base de Datos
```sql
-- Ejecutar en phpMyAdmin o MySQL
USE pilatos;

-- Crear tabla hombre
CREATE TABLE IF NOT EXISTS `hombre` (
  `id_hombre` int(11) NOT NULL AUTO_INCREMENT,
  `cod_hombre` int(11) NOT NULL,
  `img_hombre_1` varchar(150) DEFAULT NULL,
  `img_hombre_2` varchar(150) DEFAULT NULL,
  `img_hombre_3` varchar(150) DEFAULT NULL,
  `img_hombre_4` varchar(150) DEFAULT NULL,
  `nom_produc_hombre` varchar(100) NOT NULL,
  `descripcion_hombre` text NOT NULL,
  `precio_hombre` varchar(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_hombre`),
  UNIQUE KEY `cod_hombre` (`cod_hombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 2. Configuración
- Asegúrate de que XAMPP esté ejecutándose
- Verifica que la base de datos `pilatos` exista
- Las credenciales están en `config.php` (por defecto: localhost, root, sin contraseña)

### 3. Estructura de Directorios
```
hombre/
├── config.php              # Configuración de BD
├── registro_hombre.php     # Página principal
├── acciones_hombre.php     # Lógica de CRUD
├── js/
│   └── app_hombre.js      # JavaScript del frontend
├── css/
│   └── app_hombre.css     # Estilos personalizados
├── img/
│   └── fotos/             # Directorio para imágenes
├── test_hombre.php         # Archivo de prueba
└── test_insert.php         # Prueba de inserción
```

## Uso

### 1. Acceso Principal
- Navega a `hombre/registro_hombre.php`
- Esta es la página principal del sistema

### 2. Crear Producto
- Llena el formulario en el lado izquierdo
- Sube las imágenes (opcional)
- Haz clic en "Registrar"

### 3. Editar Producto
- Haz clic en "Editar" en la tabla
- Modifica los campos en el modal
- Haz clic en "Actualizar"

### 4. Eliminar Producto
- Haz clic en "Eliminar" en la tabla
- Confirma la eliminación

### 5. Buscar Producto
- Usa el campo de búsqueda por código
- Haz clic en "Buscar"

## Pruebas

### 1. Verificar Tabla
- Accede a `hombre/test_hombre.php`
- Verifica que la tabla existe y tiene la estructura correcta

### 2. Probar Inserción
- Usa el formulario en `test_hombre.php`
- Inserta un registro de prueba
- Verifica que se guarde correctamente

### 3. Probar Funcionalidades
- Crea un producto real
- Edítalo usando el modal
- Elimínalo
- Verifica la búsqueda

## Solución de Problemas

### Error de Conexión
- Verifica que XAMPP esté ejecutándose
- Confirma que la base de datos `pilatos` existe
- Revisa las credenciales en `config.php`

### Error de Tabla
- Ejecuta el SQL de creación de tabla
- Verifica que no haya conflictos de nombres

### Error de Imágenes
- Asegúrate de que el directorio `img/fotos/` tenga permisos de escritura
- Verifica que las imágenes sean del formato correcto (jpg, jpeg, png, webp, gif)

### Error de Validación
- Revisa que todos los campos requeridos estén llenos
- Verifica que el código sea numérico y único

## Archivos Principales

### `registro_hombre.php`
- Página principal con formulario y tabla
- Modal de edición
- Navegación y estructura HTML

### `acciones_hombre.php`
- Lógica de creación, edición y eliminación
- Manejo de archivos de imagen
- Validaciones de datos

### `app_hombre.js`
- Validación de formularios
- Manejo del modal de edición
- Envío de formularios por AJAX

### `config.php`
- Configuración de base de datos
- Funciones de conexión y utilidades

## Notas Técnicas

- **Imágenes**: Se guardan en `img/fotos/` con nombres únicos
- **Validación**: Frontend con Bootstrap y JavaScript, backend con PHP
- **Seguridad**: Uso de prepared statements para prevenir SQL injection
- **Responsive**: Diseño adaptativo con Bootstrap 5
- **Cache**: Headers para evitar problemas de caché en edición

## Soporte
Para problemas técnicos, revisa:
1. Logs de error de PHP
2. Consola del navegador
3. Archivo `test_hombre.php` para diagnóstico
4. Configuración de la base de datos
