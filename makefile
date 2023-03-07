CC:=php

phpcsfixer:
	set PHP_CS_FIXER_IGNORE_ENV=1 && php ./vendor/bin/php-cs-fixer fix

phpstan:
	$(CC) ./vendor/bin/phpstan analyse -l 6 src

phpunit:
	$(CC) ./vendor/bin/phpunit