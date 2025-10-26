#!/bin/bash

# === CONFIGURACIÓN ===
INICIO="2025-08-31"
FIN="2025-10-26"

# === RECREAR COMMITS DIARIOS ===
echo "Creando commits diarios desde $INICIO hasta $FIN..."

git checkout --orphan temporal
git add .
git commit -m "Inicio del proyecto - $INICIO"

FECHA="$INICIO"
while [ "$(date -d "$FECHA" +%Y-%m-%d)" != "$(date -d "$FIN + 1 day" +%Y-%m-%d)" ]; do
    GIT_COMMITTER_DATE="$FECHA 12:00:00" \
    GIT_AUTHOR_DATE="$FECHA 12:00:00" \
    git commit --allow-empty -m "Actualización del proyecto - $FECHA"
    FECHA=$(date -d "$FECHA + 1 day" +%Y-%m-%d)
done

git branch -M main
git push -u origin main --force

echo "✅ Commits diarios creados desde $INICIO hasta $FIN"
