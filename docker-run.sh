#!/usr/bin/env bash
docker run --name infra-toolkit --env-file ./.env -v "$PWD":/var/www/html -p 8081:80 infra-toolkit