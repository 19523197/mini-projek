#!/usr/bin/env bash

set -e
run=$1

export WEB_HOST_PORT=8012
export SERVICE_NAME="svc-admission-mini-projek-lumen"

export SERVICE_NAME_SEARCH="${SERVICE_NAME}-"
if [[ ! "$(docker ps --filter name=${SERVICE_NAME_SEARCH} | grep ${SERVICE_NAME_SEARCH})" ]]; then
    arguments=(compose -p "${SERVICE_NAME}" -f docker-compose.yml up -d)

    if [[ "$run" == "--rebuild" ]]; then
        arguments+=(--build)
    fi

    docker "${arguments[@]}"
fi

if [[ "$run" == "cmd" ]]; then
    docker exec -it "${SERVICE_NAME}-app-1" bash
elif [[ "$run" == "stop" ]]; then
    docker compose -p ${SERVICE_NAME} stop
fi
