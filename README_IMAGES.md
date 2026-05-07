# 📸 Guía de Imágenes para Dashboards

## 📁 Estructura de Directorios
```
public/images/dashboards/
├── admin-bg.jpg          # Fondo para dashboard de administrador
├── docente-bg.jpg        # Fondo para dashboard de docente
├── estudiante-bg.jpg     # Fondo para dashboard de estudiante
├── patterns/             # Patrones y texturas opcionales
│   ├── grid.png
│   └── dots.png
└── thumbnails/          # Miniaturas para vista previa
    ├── admin-thumb.jpg
    ├── docente-thumb.jpg
    └── estudiante-thumb.jpg
```

## 🎨 Especificaciones Técnicas

### Dimensiones Recomendadas
- **Resolución mínima**: 1920x1080px (Full HD)
- **Resolución óptima**: 2560x1440px (2K)
- **Relación de aspecto**: 16:9
- **Tamaño máximo**: 2MB por imagen

### Formatos Soportados
1. **JPEG** (Recomendado para fotografías)
   - Calidad: 85-90%
   - Compresión: Progressiva
   - Color: sRGB

2. **WebP** (Alternativa moderna)
   - Calidad: 80-85%
   - Soporte: Navegadores modernos
   - Tamaño: ~30% más pequeño que JPEG

3. **PNG** (Para gráficos y patrones)
   - Solo para elementos con transparencia
   - Compresión: Adam7

## 🎯 Características por Rol

### 🏢 Administrador
- **Tema**: Profesional, corporativo
- **Colores**: Azules profundos, grises
- **Elementos**: Edificios, tecnología, datos abstractos
- **Ejemplos**: 
  - Oficina moderna con vista panorámica
  - Centro de datos con luces LED
  - Gráficos de negocios abstractos

### 👨‍🏫 Docente
- **Tema**: Educativo, inspirador
- **Colores**: Verdes, azules claros
- **Elementos**: Aulas, bibliotecas, naturaleza
- **Ejemplos**:
  - Aula moderna con pizarra digital
  - Biblioteca con estanterías
  - Parque universitario al amanecer

### 👨‍🎓 Estudiante
- **Tema**: Juvenil, dinámico
- **Colores**: Púrpuras, naranjas, vibrantes
- **Elementos**: Campus, tecnología, deportes
- **Ejemplos**:
  - Campus universitario al atardecer
  - Estudiantes colaborando
  - Laboratorio tecnológico

## 🛠️ Herramientas Recomendadas

### Edición de Imágenes
- **Adobe Photoshop** (Profesional)
- **GIMP** (Gratis, código abierto)
- **Canva** (Online, plantillas)
- **Figma** (Diseño colaborativo)

### Optimización
- **TinyPNG/TinyJPG** (Compresión online)
- **Squoosh** (Herramienta Google)
- **ImageOptim** (Mac/Linux)

### Generación de IA
- **Midjourney** (Alta calidad)
- **DALL-E 3** (Integración OpenAI)
- **Stable Diffusion** (Código abierto)

## 📱 Responsividad y Adaptación

### Breakpoints
- **Mobile**: < 640px (Carga versión optimizada)
- **Tablet**: 640px - 1024px
- **Desktop**: > 1024px (Versión completa)

### Lazy Loading
Las imágenes se cargan con `loading="lazy"` para mejorar rendimiento:
```html
<img src="image.jpg" loading="lazy" alt="Description">
```

## 🎛️ Personalización CSS

Las imágenes se combinan con overlays programables:
```css
.dashboard-hero {
    background: linear-gradient(135deg, 
        rgba(30, 58, 138, 0.9) 0%, 
        rgba(30, 64, 175, 0.8) 50%, 
        rgba(67, 56, 202, 0.9) 100%
    );
}
```

## 🔄 Rotación Automática (Opcional)

Para implementar rotación de imágenes por temporada:
```php
// config/dashboard.php
'seasonal_images' => [
    'spring' => 'admin-spring.jpg',
    'summer' => 'admin-summer.jpg',
    'fall'   => 'admin-fall.jpg',
    'winter' => 'admin-winter.jpg'
],
```

## 📊 Rendimiento

### Métricas Objetivo
- **Tiempo de carga**: < 2 segundos
- **Tamaño total**: < 500KB
- **Lighthouse**: > 90 puntos

### Monitoreo
Usar Laravel Telescope para monitorear:
- Tiempos de carga
- Uso de memoria
- Peticiones de imágenes

## 🚀 Implementación

### 1. Colocar imágenes
```bash
cp admin-bg.jpg /var/www/html/public/images/dashboards/
cp docente-bg.jpg /var/www/html/public/images/dashboards/
cp estudiante-bg.jpg /var/www/html/public/images/dashboards/
```

### 2. Verificar permisos
```bash
chmod 644 /var/www/html/public/images/dashboards/*.jpg
chmod 755 /var/www/html/public/images/dashboards/
```

### 3. Probar en diferentes dispositivos
- Mobile: 375x667px
- Tablet: 768x1024px
- Desktop: 1920x1080px

## 🎨 Inspiración

### Bancos de Imágenes Gratuitas
- **Unsplash** (High quality, free)
- **Pexels** (Stock photos)
- **Pixabay** (Variety of images)

### Paletas de Colores
- **Admin**: #1a3a6b, #2563eb, #4f46e5
- **Docente**: #059669, #0d9488, #0891b2
- **Estudiante**: #7c3aed, #a855f7, #6366f1

---

**Nota**: Todas las imágenes deben tener licencia apropiada para uso comercial y educativo.
