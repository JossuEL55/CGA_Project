# CGA OIL Industries - Sistema de Gestión de Órdenes Técnicas

Este proyecto es un sistema web desarrollado en **Laravel** para la empresa **CGA OIL Industries**, orientado a la gestión de órdenes técnicas de mantenimiento e instalación en plantas industriales.


---

## Arquitectura y Buenas Prácticas

Para garantizar un código **limpio, escalable y mantenible**, se aplicaron principios **SOLID** y patrones de diseño, logrando que la funcionalidad original se mantenga sin cambios.

---

### Principios SOLID aplicados

1. **Single Responsibility Principle (SRP):**
   - Cada clase tiene una única responsabilidad.
   - La lógica de negocio se separó en una capa de servicio (`OrdenTecnicaService`).

2. **Dependency Inversion Principle (DIP):**
   - Los controladores dependen de interfaces y no directamente de implementaciones concretas de acceso a datos.
   - Se inyecta el repositorio mediante una interfaz (`OrdenTecnicaRepositoryInterface`).

---

### Patrones de Diseño utilizados

- **Repository Pattern:**
  - Encapsula el acceso a datos de las órdenes técnicas.
  - Permite desacoplar la lógica de consulta y facilitar pruebas unitarias.

- **Service Layer Pattern:**
  - Contiene la lógica de negocio relacionada con la validación de órdenes.
  - Hace que los controladores queden limpios y centrados en coordinar flujos.

## Video Explicativo 
Enlace: https://youtu.be/UHMCQWKcEos?si=wY8k1Wjhl15MP6Wn
