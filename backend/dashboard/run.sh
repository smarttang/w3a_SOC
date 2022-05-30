#!/bin/bash

tag=$1

docker build -t registry.cn-beijing.aliyuncs.com/aidolphins_com/w3a-dashboard:${tag} .
docker push registry.cn-beijing.aliyuncs.com/aidolphins_com/w3a-dashboard:${tag}
