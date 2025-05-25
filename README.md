<p align="center">
  <a href="https://github.com/lstordev/pt-flat/actions/workflows/run-tests.yml"><img src="https://github.com/lstordev/pt-flat/actions/workflows/run-tests.yml/badge.svg" alt="Tests"></a>
  <a href="https://github.com/lstordev/pt-flat/actions/workflows/code-quality.yml"><img src="https://github.com/lstordev/pt-flat/actions/workflows/code-quality.yml/badge.svg" alt="Lint"></a>
</p>


### Comentarios
- Se puede ver ejecución de test y análisis de código en https://github.com/lstordev/pt-flat/actions/
- Se usa serializer para entradas y salidas -> ProductRequest
- ProductRequest se usa como validación de la entrada de datos y DTO
- Mi idea era usar arquitectura hexagonal, DDD y CQRS. Desacoplar Symfony en la medida de lo posible.
- El comando `make` facilita arrancar o probar el repo


## Arrancar el proyecto
Se ha creado un Makefile para facilitar el desarrollo. Puedes usar los siguientes comandos:

```bash
# Instalar dependencias y configurar el proyecto
make setup

# Iniciar el servidor de desarrollo
make start

# Detener el servidor de desarrollo
make stop

# Actualizar la base de datos
make db-migrate

# Limpiar la caché
make cache-clear

# Verificar estándares de código
make cs-check

# Ver todos los comandos disponibles
make help
```

## Ejecutar tests 
```make test```
