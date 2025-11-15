#!/bin/bash
# Pasos para desplegar TestLink en Render

# 1. Ir a https://render.com
# 2. Iniciar sesión o crear una cuenta
# 3. Hacer click en "New +"
# 4. Seleccionar "Web Service"
# 5. Conectar tu repositorio de GitHub (LuwuVelasco/GoCan-TestLink)
# 6. Llenar los siguientes campos:

# Name: testlink-gocan
# Runtime: Docker
# Region: Oregon (us-west)
# Plan: Free (o la que prefieras)

# 7. En Environment Variables, agregar:
# - No es necesario agregar manualmente si usas render.yaml
# - Render leerá automáticamente render.yaml y creará la BD

# 8. Crear la base de datos (se crea automáticamente desde render.yaml)

# 9. Deploy automático: Git conectado + render.yaml = Deploy automático

# 10. Una vez desplegado:
# - Accede a https://testlink-gocan.onrender.com
# - Completa el asistente de instalación de TestLink
# - Usuario: admin
# - Contraseña: (la que configures)

echo "TestLink será desplegado en: https://testlink-gocan.onrender.com"
