#!/bin/bash -e

unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux;;
    Darwin*)    machine=Mac;;
    CYGWIN*)    machine=Windows;;
    MINGW*)     machine=Windows;;
    *)          machine="UNKNOWN:${unameOut}"
esac

if [ "$machine" == "Windows" ] ; then
  WINPTY=winpty
fi

function alternative_ports {
  export PP_PORT_SSH=22222
  export PP_PORT_HTTP=20080
  export PP_PORT_HTTPS=20443
  export PP_PORT_REDIS_CACHE=26379
  export PP_PORT_RABBITMQ_ADMIN=25672
  export PP_PORT_MAILCATCHER_SMTP=21025
  export PP_PORT_MAILCATCHER_HTTP=21080
  export PP_PORT_POSTGRES=25432
  export PP_PORT_ETCD_BROWSER_8080=28080
  env | grep PP_PORT_
}

function show_help {
  echo ""
  echo "################### ELANTHA ###################"
  echo ""
  echo "Usage: $0 [<options>] [command [arg]]"
  echo ""
  echo "Options:"
  echo "  -p <path> : Папка с проектом"
  echo "  -a        : Запуск на альтернативных портах"
  [[ "$machine" == "Windows" ]] && \
  echo "  -c        : Пропустить CRLF check"
  echo "  -h        : Показать Help"
  echo ""
  echo "Commands:"
  echo "  build          : Пересобирает контейнеры. (docker-compose build)"
  echo "  up             : Запуск сборки и контейнеров. (docker-compose up -d)"
  echo "  fast           : Запуск композера и миграций."
  echo "  start          : Запуск контейнеров, композера, миграций и тд. (docker-compose start)"
  echo "  stop           : Остановка. (docker-compose stop)"
  echo "  down           : Удаление контейнеров. (docker-compose down)"
  echo "  rm             : Удаление контейнеров и volumes. (docker-compose down -v)"
  echo "  shell          : Зайти внутрь основного контейнера. (docker-compose exec php bash)"
  echo "  clean          : Удаление всех докер контейнеров"
  echo "  cleanvol       : Удаление всех докер volumes"
  echo ""
  echo "################### ELANTHA ###################"
  echo ""
  echo ""
  echo "Запускай:"
  echo "  $0 up"
  echo ""
}

function docker_compose_up {
  if [ "$SKIP_BUILD" != "true" ]; then
    echo "Building containers... (Use -b option to disable)"
    docker-compose build --force-rm
  fi
  docker-compose up -d
}

function install_docker-compose {
  URL=https://github.com/docker/compose/releases/download/1.22.0/docker-compose-$(uname -s)-$(uname -m)
  sudo curl -sS -L -o /usr/local/bin/docker-compose -C - $URL
  sudo chmod +x /usr/local/bin/docker-compose
}

function fast_provision {
    docker-compose exec -T $1 bash -c "cd /var/www/oxana ; composer install ; php artisan key:generate"
}
