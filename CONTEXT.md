ACADEMIC-V3 — Contexto del Sistema 
Actualizado: 07/05/2026 Título oficial: Implementación de un Sistema Web de Seguimiento Académico Asistido por un Agente Inteligente en el
Aula de Desarrollo de la Carrera de Informática Industrial 
Stack tecnológico 
Laravel 13.6 · PHP 8.3 · MySQL 8 · Docker
Tailwind v3 + DaisyUI v4 + Alpine.js + Livewire 4
PhpSpreadsheet (reportes Excel)
Ollama qwen2.5:3b (IA local, pendiente)
Build: Vite 8 + PostCSS + tailwind.config.js (module.exports) 
Reglas permanentes (NO violar) 
Sin Mary UI. Sin DaisyUI v5. Sin Tailwind v4.
La IA solo lee via funciones Laravel. NUNCA escribe en BD.
php artisan siempre dentro del contenedor: docker-compose exec app php artisan
Layout: #[Layout(‘components.layouts.app’)] en cada componente PHP
Blades NO envuelven en — solo 
raíz única
config/auth.php apunta a App\Models\Usuario::class (NO existe User.php)
Color topbar/sidebar-activo: #1a3a6b (nunca purple/violet)
Instrucciones para Windsurf/OpenCode: en inglés para ahorrar tokens 
Modelo académico 
2 parciales por semestre, mismas categorías aplican a ambos
Nota parcial = suma(valor * peso/100) por categoría del parcial
Nota final = (parcial1 + parcial2) / 2
Aprobado: nota_final >= 61
Recuperación: nota_final >= nota_minima_recuperacion (default 51) AND < 61
Asistencia mínima: 80% por parcial (solo si considera_asistencia=true)
Password inicial: INICIALES_MAYÚSCULAS(primer_nombre+primer_apellido+segundo_apellido) + CI Ejemplo: Betty Chura Choquehuanca
CI=1252503 → BCC1252503 
Credenciales de prueba 
Admin: ci=admin / pass=admin123
Docente: ci=8956231 / pass=NQC8956231 
Archivos clave 
app/Models/ — 11 modelos Eloquent app/Http/Controllers/AuthController.php app/Http/Middleware/VerificarRol.php app/Services
ReporteExcelService.php app/Http/Controllers/ReporteController.php resources/views/components/layouts/app.blade.php — layout DaisyUI
drawer resources/views/auth/login.blade.php resources/views/dashboard/{admin,docente,estudiante}.blade.php routes/web.php
tailwind.config.js — module.exports, DaisyUI v4, content scan activo postcss.config.js — module.exports, tailwindcss + autoprefixer resources
css/app.css — @tailwind base/components/utilities + override –p 
Componentes Livewire existentes 
app/Livewire/ ├── Asignaciones/Formulario.php + Index.php ├── Dashboard/Admin.php ├── Docente/Asistencia.php ├── Docente
Categorias.php ├── Docente/MisMaterias.php ├── Docente/Notas.php ├── Inscripciones/Formulario.php + Index.php ├── Materias
Formulario.php + Index.php ├── Notas/Index.php — admin solo lectura, docente editable ├── Periodos/Formulario.php + Index.php └──
Usuarios/Formulario.php + Index.php 
Rutas activas 
POST /login login.post POST /logout logout GET /admin/dashboard admin.dashboard GET /admin/usuarios admin.usuarios GET /admin/usuarios
crear admin.usuarios.crear GET /admin/usuarios/{id}/editar admin.usuarios.editar GET /admin/materias admin.materias GET /admin/materias
crear admin.materias.crear GET /admin/materias/{id}/editar admin.materias.editar GET /admin/periodos admin.periodos GET /admin
asignaciones admin.asignaciones GET /admin/inscripciones admin.inscripciones GET /admin/notas/{asignacion} admin.notas GET /admin
reportes/materia/{asignacion} admin.reportes.materia GET /docente/dashboard docente.dashboard GET /docente/mis-materias
docente.materias GET /docente/asignacion/{a}/notas docente.notas GET /docente/asignacion/{a}/asistencia docente.asistencia GET /docente
asignacion/{a}/categorias docente.categorias GET /estudiante/dashboard estudiante.dashboard 
BD — tablas y campos clave 
usuarios: id, ci, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, password, rol ENUM(admin,docente,estudiante), activo
docentes: id, usuario_id (SIN campo especialidad) estudiantes: id, usuario_id, semestre_actual (1-6) materias: id, nombre, codigo (ej: PRG-100),
semestre_curricular materia_prerequisitos: id, materia_id, prerequisito_id periodos: id, nombre, fecha_inicio, fecha_fin, activo asignaciones: id,materia_id, periodo_id, docente_id, aula, considera_asistencia, permite_recuperacion, nota_minima_recuperacion (default 51.0)
categorias_evaluacion: id, asignacion_id, nombre, peso_porcentual, parcial(1|2) inscripciones: id, estudiante_id, asignacion_id, inscrito_por
notas: id, inscripcion_id, categoria_id, valor, parcial(1|2), editado_por asistencias: id, inscripcion_id, fecha, estado
ENUM(Presente,Ausente,Justificado), editado_por nota_auditoria: id, nota_id, valor_anterior, valor_nuevo, editado_por 
Métodos clave en modelos 
// Usuario
Usuario::generarPasswordInicial($nombre, $apellido, $ci, $segundoApellido)
$usuario->iniciales // BCC (3 letras mayúsculas)
$usuario->nombre_completo // apellidos + nombres formateados
// Inscripcion
$inscripcion->calcularPromedioParcial(int $parcial): float
$inscripcion->calcularPromedioFinal(): float
$inscripcion->puedeRecuperar(): bool
$inscripcion->calcularPromedioActual(): float // alias de Final
// Nota — auditoría automática via booted()
// Al hacer updating si valor cambió → crea NotaAuditoria automáticamente

Agente IA — arquitectura 
Principio: Laravel calcula → Ollama interpreta → Docente decide
Modelo: qwen2.5:3b (2GB RAM, compatible i5 7ma gen)
4 funciones sensor (solo lectura): fn_5_peores_notas(asig_id) fn_desempeno_grupo(asig_id) fn_estudiantes_en_riesgo(asig_id)
fn_avance_global_estudiante(est_id)
Chat Livewire: historial temporal (se borra al cerrar sesión)
Comunicados automáticos diarios para estudiantes 
Próximos pasos (en orden) 
Docente/MisMaterias — cards con stats reales
Docente/Categorias — configurar por parcial
Docente/Notas — grilla editable por parcial
Docente/Asistencia — registro diario + % parcial
Vista Estudiante completa
Dashboard Admin con métricas reales
Reporte historial estudiante Excel
Importar Excel masivo
Agente IA Ollama
