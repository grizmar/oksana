#!/bin/bash -e

PROJECT_PATH="$( cd "$(dirname "$0")" ; pwd -P )"
cd "$PROJECT_PATH"

source etc/scripts/init.include.sh

while getopts ":ahp:cb" opt; do
  case $opt in
     a) alternative_ports ;;
     h) show_help ; exit 0 ;;
     b) SKIP_BUILD=true ;;
     c) SKIP_CRLF_CHECK=true ;;
     p) PROJECT_PATH="$OPTARG" ;;
    \?) echo "Invalid option: -$OPTARG" ; exit 1 ;;
     :) echo "Option -$OPTARG requires an argument" ; exit 1 ;;
  esac
done

if [ ! -z ${!OPTIND} ]; then
  CMD_ARG_IND=$((OPTIND+1))
  CMD_ARG=${!CMD_ARG_IND}
  CMD_ARG2_IND=$((OPTIND+2))
  CMD_ARG2=${!CMD_ARG2_IND}
fi

if [ "$machine" == "Linux" ] && [ ! -x /usr/local/bin/docker-compose ]; then
  set -x
  echo docker-compose not found. Downloading...
  install_docker-compose
  set +x
fi

case ${!OPTIND} in
          build) docker-compose build --force-rm; exit $? ;;
             up) docker_compose_up; exit $? ;;
           fast) fast_provision "${CMD_ARG:-main}"; exit $? ;;
          start) docker-compose start && fast_provision "${CMD_ARG:-main}"; exit $? ;;
           stop) docker-compose stop ; exit $? ;;
           down) docker-compose down ; exit $? ;;
             rm) docker-compose down -v; exit $? ;;
          clean) docker ps -qa | xargs docker rm -f; exit 0 ;;
       cleanvol) docker volume ls -q | xargs docker volume rm; exit 0 ;;
          shell) $WINPTY docker-compose exec "${CMD_ARG:-main}" bash; exit 0 ;;
       composer) $WINPTY docker-compose exec -T main bash -c "cd /var/www/oxana ; composer ${CMD_ARG:-install}"; exit 0 ;;
        artisan) $WINPTY docker-compose exec -T main bash -c "cd /var/www/oxana ; php artisan $CMD_ARG"; exit 0 ;;
       testdata) $WINPTY docker-compose exec -T main bash -c "cd /var/www/oxana ; php artisan testdata:insert"; exit 0 ;;
             '') ;;
              *) echo "Invalid command '${!OPTIND}'"; exit 1 ;;

esac

show_help
