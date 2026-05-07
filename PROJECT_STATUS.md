# 📊 PROJECT STATUS — Academic v3
**Última actualización:** 07/05/2026
**Estado:** 🟢 Sprint 3 activo

---

## ✅ COMPLETADO

### Infraestructura
- Docker 4 contenedores (app:8081, db, pma:8082, ollama:11434)
- Laravel 13.6 + PHP 8.3 + MySQL 8
- Tailwind v3 + DaisyUI v4 + Alpine.js + Livewire 4
- PostCSS configurado (tailwind.config.js con module.exports)
- PhpSpreadsheet instalado (vendor/phpoffice/phpspreadsheet)
- Auth por CI con middleware VerificarRol (admin/docente/estudiante)
- Layout DaisyUI drawer responsivo, topbar #1a3a6b, sidebar dinámico por rol
- Botón Salir funcionando en topbar y sidebar
- Password inicial: INICIALES_MAYÚSCULAS + CI (ej: BCC1252503)

### Módulos Admin — CRUD completo
| Módulo | Estado | Notas |
|--------|--------|-------|
| Usuarios | ✅ | Sin campo especialidad, password 3 iniciales+CI mayúsculas |
| Materias | ✅ | Formato sigla-número (PRG-100), prerrequisitos con checkboxes, semestre auto |
| Períodos | ✅ | Activación única, fechas inicio/fin |
| Asignaciones | ✅ | materia+docente+período+aula, considera_asistencia, permite_recuperacion, nota_minima_recuperacion |
| Categorías evaluación | ✅ | Por asignación y parcial (1 o 2), pesos suman 100% |
| Inscripciones | ✅ | Validación prerrequisitos histórica (≥61), sin filtro semestre, inscrito_por |
| Notas admin | ✅ | Solo lectura para admin, editable solo docente |
| Reportes Excel | ✅ | Por asignación, categorías dinámicas, colores APROBADO/REPROBADO |

### Panel Docente — rutas y componentes creados
| Componente | Ruta | Estado |
|------------|------|--------|
| Docente/MisMaterias | /docente/mis-materias | ✅ vista en construcción |
| Docente/Notas | /docente/asignacion/{a}/notas | ✅ componente creado |
| Docente/Asistencia | /docente/asignacion/{a}/asistencia | ✅ componente creado |
| Docente/Categorias | /docente/asignacion/{a}/categorias | ✅ componente creado |

### Modelos y BD — 13 tablas
- usuarios, docentes, estudiantes, materias, materia_prerequisitos
- periodos, asignaciones, categorias_evaluacion, inscripciones
- notas, asistencias, nota_auditoria
- Campos añadidos: activo, parcial, permite_recuperacion, nota_minima_recuperacion
- Métodos: calcularPromedioParcial(1|2), calcularPromedioFinal(), puedeRecuperar()

---

## 🚧 EN PROGRESO

- Docente/MisMaterias: cards con stats reales (inscritos, promedio aula, en riesgo)
- Colores DaisyUI override a #1a3a6b en CSS (--p: 221 68% 26%)
- Nav sidebar docente: Dashboard ✅ Mis materias ✅ — Agente IA pendiente

---

## 📋 PENDIENTE (en orden de prioridad)

### 🔴 Alta
- [ ] Docente/MisMaterias — cards con botones a notas, asistencia, categorías
- [ ] Docente/Categorias — configurar categorías por parcial (1 y 2)
- [ ] Docente/Notas — grilla editable por parcial, promedio parcial y final
- [ ] Docente/Asistencia — registro diario Presente/Ausente/Justificado, % por parcial (mínimo 80%)
- [ ] Vista Estudiante — mi rendimiento, notas por parcial, asistencia, comunicados IA

### 🟡 Media
- [ ] Dashboard Admin — métricas reales (total usuarios, inscritos, en riesgo)
- [ ] Dashboard Docente — stats de materias activas
- [ ] Reporte historial por estudiante (Excel vertical, como historial físico del instituto)
- [ ] Importar estudiantes masivo desde Excel

### 🟢 Baja (Sprint siguiente)
- [ ] Agente IA Ollama qwen2.5:3b — chat docente, comunicados estudiante
- [ ] Dashboard métricas Chart.js
- [ ] Exportar reportes consolidados

---

## 🔧 Configuración técnica

### Accesos
- App: http://localhost:8081
- phpMyAdmin: http://localhost:8082
- Ollama: http://localhost:11434

### Credenciales de prueba
- Admin: ci=admin / pass=admin123
- Docente: ci=8956231 / pass=NQC8956231

### Reglas de negocio implementadas
- Nota mínima aprobación: 61
- Nota final = (parcial1 + parcial2) / 2
- Recuperación: nota_final >= nota_minima_recuperacion (default 51) AND < 61
- Asistencia mínima: 80% por parcial
- Prerrequisitos: verificación histórica en cualquier período anterior
- Password: INICIALES_MAYÚSCULAS(3) + CI

### Color institucional
- Topbar/activo: #1a3a6b
- DaisyUI override en app.css: --p: 221 68% 26%
