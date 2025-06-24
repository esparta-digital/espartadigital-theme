# Esparta Digital Theme

Tema personalizado para WordPress desarrollado para Esparta Digital.

## Características

- Soporte para traducciones.
- Gestión del título del documento.
- Soporte para imágenes destacadas.
- Menú de navegación principal.
- Marcado HTML5 para formularios y comentarios.
- Personalización de fondo y logo.
- Widgets y barra lateral.
- Compatibilidad con WooCommerce.
- Limpieza de elementos innecesarios en el `<head>`.
- Desactivación completa de emojis.
- Integración de Bootstrap 5.3.7 (CSS y JS).
- Panel de administración para insertar scripts en `<head>`, `<body>` y `<footer>`.

## Instalación

1. Clona o descarga este repositorio en la carpeta `wp-content/themes/`.
2. Activa el tema desde el panel de administración de WordPress.
3. Personaliza desde Apariencia > Personalizar.

## Scripts personalizados

Desde el panel de administración, accede a **Inserción script** para añadir código personalizado en las secciones `<head>`, `<body>` o `<footer>` de tu sitio.

## Estructura recomendada

```
espartadigital-theme-main/
├── css/
│   └── bootstrap.min.css
├── js/
│   └── bootstrap.bundle.min.js
│   └── navigation.js
├── inc/
│   ├── custom-header.php
│   ├── template-tags.php
│   ├── template-functions.php
│   ├── customizer.php
│   └── woocommerce.php
├── languages/
├── functions.php
├── style.css
└── ...
```

## Créditos

Desarrollado por Esparta Digital.
