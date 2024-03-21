#!/usr/bin/env bash

# Project names
NAME="bus_supplier"
NETWORK_NAME="network_bus_supplier"
CONTAINER_NAME="bus_supplier"
BASE_IMAGE="bus_supplier:1.0"
BASE_IMAGE_DOCKERFILE="bus_supplier.Dockerfile"
OVERRIDES=

# Set base working directory
SCRIPT_PATH="$( cd "$(dirname "$0")" >/dev/null 2>&1 || { echo "Failure: cd dirname \$0"; exit 1; } ; pwd -P )"
BASEDIR="$SCRIPT_PATH/../"
cd "$BASEDIR" || { echo "Failure: cd $BASEDIR"; exit 1; }
BASEDIR=$(pwd)
echo "Working directory: $BASEDIR"

# Load environment variables
ENV_FILE="./docker/env.dist"
if [ -f ./docker/.env ]; then
    ENV_FILE="./docker/.env"
fi

# Build base image
if [ "$(docker images -q "$BASE_IMAGE" 2>/dev/null)" = "" ]; then
  echo "Base image $BASE_IMAGE not found. Building..."
  docker build --tag "${BASE_IMAGE}" --no-cache . -f "docker/${BASE_IMAGE_DOCKERFILE}"
fi

# Create base network
if [ ! $(docker network ls --filter name="^$NETWORK_NAME$" --format="{{.ID}}") ]; then
    echo "creating network"
    docker network create "$NETWORK_NAME"
fi

docker-compose $OVERRIDES --env-file $ENV_FILE stop
docker-compose $OVERRIDES --env-file $ENV_FILE build
docker-compose $OVERRIDES --env-file $ENV_FILE up -d --remove-orphans

docker exec -it "${CONTAINER_NAME}" chown -R www-data:www-data /var/www/html/var
docker exec -it --user www-data "${CONTAINER_NAME}" composer install
#docker exec -it --user www-data "${CONTAINER_NAME}" yarn install
#docker exec -it -u www-data "${CONTAINER_NAME}" bin/console doc:sch:up --force --complete -n
#docker exec -it -u www-data "${CONTAINER_NAME}" bin/console --env=test doc:sch:up --force --complete -n
