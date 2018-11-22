#!/bin/bash

sed -i -e 's/newrelic.license.*/newrelic.license = '"$NR_INSTALL_KEY"'/' /etc/php-7.0.d/newrelic.ini
sed -i -e 's/;newrelic.framework.*/newrelic.framework = '"no_framework"'/' /etc/php-7.0.d/newrelic.ini
