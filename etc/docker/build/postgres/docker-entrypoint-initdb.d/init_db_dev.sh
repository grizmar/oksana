#!/bin/bash

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
   CREATE USER dev password '123' superuser;
   CREATE DATABASE postgres owner dev LC_COLLATE='ru_RU.UTF-8' LC_CTYPE='ru_RU.UTF-8' TEMPLATE template0;
EOSQL
export PGDATA=/var/lib/postgresql/data
