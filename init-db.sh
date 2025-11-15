#!/bin/bash
# Script para inicializar la base de datos de TestLink en Render

set -e

echo "Esperando disponibilidad de la base de datos..."
sleep 10

DB_HOST=${DB_HOST:-localhost}
DB_PORT=${DB_PORT:-5432}
DB_USER=${DB_USER:-testlink_user}
DB_PASSWORD=${DB_PASSWORD}
DB_NAME=${DB_NAME:-testlink}

# Esperar a que PostgreSQL esté listo
for i in {1..30}; do
    if PGPASSWORD=$DB_PASSWORD psql -h $DB_HOST -p $DB_PORT -U $DB_USER -d $DB_NAME -c "SELECT 1" &>/dev/null; then
        echo "Base de datos disponible"
        break
    fi
    echo "Intento $i: Esperando base de datos..."
    sleep 2
done

echo "Base de datos lista. TestLink puede iniciar."
