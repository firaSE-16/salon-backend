#!/usr/bin/env bash
set -euo pipefail

cd /app

# Laravel runtime directories (must exist + be writable)
mkdir -p bootstrap/cache \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs

# Best-effort permissions (Railway user varies by runtime)
chmod -R ug+rwX storage bootstrap/cache || true

# Start PHP built-in server with Laravel front controller as router script.
# Without the router script, paths like /api/... won't reach Laravel and will 404.
exec php -S 0.0.0.0:${PORT:-8000} -t public public/index.php


