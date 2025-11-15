#!/bin/bash
set -e

# Detectar configuración desde RENDER_POSTGRES_INTERNAL_URL o variables normales
if [ ! -z "$RENDER_POSTGRES_INTERNAL_URL" ]; then
    # Estamos en Render con PostgreSQL
    echo "ADVERTENCIA: PostgreSQL detectado pero TestLink 1.9 requiere MySQL"
    exit 1
elif [ ! -z "$RENDER_DATABASE_INTERNAL_URL" ]; then
    # Estamos en Render con base de datos (podría ser MySQL)
    echo "Base de datos Render detectada"
fi

# Variables por defecto si no están seteadas
export DB_HOST="${DB_HOST:-localhost}"
export DB_PORT="${DB_PORT:-3306}"
export DB_USER="${DB_USER:-testlink}"
export DB_PASSWORD="${DB_PASSWORD:-testlink}"
export DB_NAME="${DB_NAME:-testlink}"

echo "Configuración de base de datos:"
echo "  Host: $DB_HOST"
echo "  Port: $DB_PORT"
echo "  User: $DB_USER"
echo "  Database: $DB_NAME"

# Esperar a que la base de datos esté lista (máximo 60 segundos)
echo "Esperando disponibilidad de la base de datos..."
for i in {1..60}; do
    if mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASSWORD" -e "SELECT 1" &>/dev/null; then
        echo "✓ Base de datos disponible"
        break
    fi
    if [ $i -eq 60 ]; then
        echo "✗ No se pudo conectar a la base de datos después de 60 segundos"
        exit 1
    fi
    echo "  Intento $i/60..."
    sleep 1
done

# Iniciar Apache
echo "Iniciando Apache..."
exec apache2-foreground
