#!/bin/bash

if [ -n "$IS_DOCKER" ]; then
    echo "Script should not be executed in container."
fi

docker exec -it -u docker iteo-www composer "$@"