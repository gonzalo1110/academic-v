# Academic V3 - Sistema de Gestión Académica

Sistema Laravel con Docker para gestión de usuarios, materias, notas y asistencia.

## Requisitos Windows 10

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (con WSL 2)
- Git
- Puerto 8081, 3308, 8082, 11434 disponibles

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/gonzalo1110/academic-v.git
cd academic-v
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
```

### 3. Iniciar contenedores Docker

```powershell
docker-compose up -d --build
```

### 4. Esperar a que MySQL esté listo (~15 segundos)

```powershell
# Verificar que los contenedores están corriendo
docker-compose ps
```

### 5. Instalar dependencias dentro del contenedor

```powershell
docker exec -it academic_app composer install
docker exec -it academic_app php artisan key:generate
```

### 6. Ejecutar migraciones

```powershell
docker exec -it academic_app php artisan migrate
```

### 7. Poblar datos de prueba (opcional)

```powershell
docker exec -it academic_app php artisan db:seed
```

## URLs de acceso

| Servicio | URL |
|----------|-----|
| Aplicación | http://localhost:8081 |
| PHPMyAdmin | http://localhost:8082 |
| Base de datos | localhost:3308 |

## Usuarios de prueba

| Rol | Usuario | Contraseña |
|-----|---------|------------|
| Admin | admin@correo.com | password |
| Docente | docente@correo.com | password |
| Estudiante | estudiante@correo.com | password |

## Comandos útiles

```powershell
# Ver logs
docker-compose logs -f app

# Reiniciar contenedores
docker-compose restart

# Detener todo
docker-compose down

# Acceder al contenedor
docker exec -it academic_app bash
```

## Roles disponibles

- **Admin**: Gestión completa (usuarios, materias, períodos, asignaciones, inscripciones, reportes)
- **Docente**: Mis materias, notas, asistencia, categorías
- **Estudiante**: Vista de calificaciones (en desarrollo)
