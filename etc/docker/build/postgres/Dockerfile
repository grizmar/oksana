# tag: postgres local
# start postgres with database dev, user dev, password 123, locale UTF-8.ru
FROM postgres:latest
COPY /docker-entrypoint-initdb.d/init_db_dev.sh /docker-entrypoint-initdb.d/
ENV TZ="Europe/Moscow"
ENV PGTZ="GMT-3"
RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime
