.PHONY: qa
qa: cs unit-tests phpstan yaml-lint changelog

# See: https://github.com/crossnox/m2r2
.PHONY: changelog
changelog:
	m2r2 CHANGELOG.md && \
	echo ".. _changelog:" | cat - CHANGELOG.rst > /tmp/CHANGELOG.rst && \
	mv /tmp/CHANGELOG.rst Documentation/changelog.rst && \
	rm CHANGELOG.rst

.PHONY: cs
cs: vendor
	.Build/bin/ecs check --fix

.PHONY: phpstan
phpstan: vendor
	.Build/bin/phpstan analyse

.PHONY: unit-tests
unit-tests: vendor
	.Build/bin/phpunit -c Tests/phpunit.xml.dist

vendor: composer.json composer.lock
	composer validate
	composer install

.PHONY: xlf-lint
xlf-lint:
	xmllint --schema Resources/Private/Language/xliff-core-1.2-strict.xsd --noout Resources/Private/Language/*.xlf

.PHONY: yaml-lint
yaml-lint: vendor
	find -regex '.*\.ya?ml' ! -path "./.Build/*" -exec .Build/bin/yaml-lint -v {} \;

.PHONY: zip
zip:
	grep -Po "(?<='version' => ')([0-9]+\.[0-9]+\.[0-9]+)" ext_emconf.php | xargs -I {version} sh -c 'mkdir -p ../zip; git archive -v -o "../zip/$(shell basename $(CURDIR))_{version}.zip" v{version}'
