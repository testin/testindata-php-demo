#!/usr/bin/env bash

if [ ! -f "testin-ab-v1.2.1.war" ]; then
    wget https://ab.testin.cn/sdk/java/testin-ab-v1.2.1.war
fi

java -jar testin-ab-v1.2.1.war -Dspring.config.location ./application.properties