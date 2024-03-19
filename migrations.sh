#!/bin/bash

# Roda as migrações do Laravel
php artisan migrate:fresh --seed --force --no-interaction

exec "$@"
