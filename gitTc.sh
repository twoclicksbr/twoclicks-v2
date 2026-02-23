#!/usr/bin/env bash
set -e

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m'

# Mensagem do commit
MSG="$1"
if [ -z "$MSG" ]; then
  MSG="auto: $(date '+%Y-%m-%d %H:%M:%S')"
fi

echo -e "${CYAN}══════════════════════════════════════${NC}"
echo -e "${CYAN}  TwoClicks v2 — Git Push${NC}"
echo -e "${CYAN}══════════════════════════════════════${NC}"

echo -e "${CYAN}➜ git add .${NC}"
git add .

echo -e "${YELLOW}➜ Commit:${NC} $MSG"
git commit -m "$MSG" || echo -e "${RED}Nada para commitar.${NC}"

echo -e "${CYAN}➜ Push para origin/main${NC}"
git push origin main

echo -e "${GREEN}✔ Pronto! Código salvo no GitHub.${NC}"
