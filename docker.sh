#!/usr/bin/env bash

set -e
run=$1

export WEB_HOST_PORT=8012
export SERVICE_NAME="svc-academic-boilerplate-lumen"

export SERVICE_NAME_SEARCH="${SERVICE_NAME}_"
if [[ ! "$(docker ps --filter name=${SERVICE_NAME_SEARCH} | grep ${SERVICE_NAME_SEARCH})" ]]; then
  dockercompose="docker-compose -p '${SERVICE_NAME}' -f docker-compose.yml"

  dockercompose="${dockercompose} up -d"

  if [[ "$run" = "--rebuild" ]]; then
    dockercompose="${dockercompose} --build"
  fi

  $dockercompose
fi

if [[ "$run" = "cmd" ]]; then
  docker exec -it "${SERVICE_NAME}_app_1" bash
elif [[ "$run" = "stop" ]]; then
  docker-compose -p ${SERVICE_NAME} stop
fi
