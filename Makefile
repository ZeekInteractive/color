PHPUNIT=./vendor/bin/phpunit
INFECTION=./vendor/bin/infection
 
.PHONY: all
# Default target when just running 'make'
all: analyze test

vendor: composer.json composer.lock
	composer install

build/logs:
	mkdir -p build/logs

$(PHPUNIT): vendor
$(INFECTION): vendor

#
#  T E S T S
#
.PHONY: test test-unit

test: test-unit test-infection

test-unit: $(PHPUNIT) vendor build/logs
	$(PHPUNIT) --coverage-text

test-infection: $(INFECTION) vendor build/logs
	$(INFECTION) --threads=4 --only-covered --min-msi=70

#
#  A N A L Y S I S
#

.PHONY: analyze validate

analyze: validate

validate:
	composer validate --strict
