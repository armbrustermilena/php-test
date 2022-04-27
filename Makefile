build:
	docker build . -t php-test
run:
	docker run -it --rm -v $(PWD):/project php-test sh
test:
	php vendor/bin/codecept run unit