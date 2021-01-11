#!/usr/bin/env bash

docker exec -e XDEBUG_MODE=coverage -it transfers-app vendor/bin/phpunit $@
