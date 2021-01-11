#!/usr/bin/env bash

docker exec --user 1000:1000 -it transfers-app php artisan $@
