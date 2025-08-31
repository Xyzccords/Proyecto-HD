#!/bin/bash
# ============================
# Simulación de historial Git
# ============================

# 📌 Configuración
REPO_URL="https://github.com/Xyzccords/Proyecto-HD.git"   # <-- cambia esto
START_DATE="2025-08-31"   # Fecha inicial (21 días antes de 20/09/2025)
TOTAL_DIAS=21

# ============================
# Preparación del entorno
# ============================

# 1. Crear carpeta temporal con lotes
mkdir -p lotes
i=1
# Repartir todos los archivos en 21 carpetas
find . -maxdepth 1 ! -name "lotes" ! -name ".git" ! -name "simular_historia.sh" -type f -print0 | \
  xargs -0 -n $(($(ls -1 | wc -l)/TOTAL_DIAS + 1)) -I{} sh -c '
    carpeta="lotes/lote'$i'"
    mkdir -p "$carpeta"
    mv "$@" "$carpeta"
  ' sh {}

# 2. Inicializar Git
rm -rf .git
git init
git branch -M main
git remote add origin "$REPO_URL"

# ============================
# Commits retroactivos
# ============================

for ((dia=0; dia<TOTAL_DIAS; dia++)); do
  fecha=$(date -d "$START_DATE +$dia days" +"%Y-%m-%d 12:00:00")
  lote="lotes/lote$((dia+1))"

  # mover archivos del lote al proyecto
  if [ -d "$lote" ]; then
    mv "$lote"/* .
  fi

  # crear un archivo historial.txt acumulativo
  echo "Commit del día $((dia+1)) - $fecha" >> historial.txt

  # commit retroactivo
  git add .
  GIT_COMMITTER_DATE="$fecha" git commit --date="$fecha" -m "Trabajo del día $((dia+1))"
done

# ============================
# Subida a GitHub
# ============================
git push -u origin main
