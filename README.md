# Requirements
* PHP 7.1 CLI
* or Docker

# Install

* `composer install`
* or `(sudo) docker run --rm -v $(pwd):/app composer install`

# Run tests
* `vendor/bin/phpunit`
* or `(sudo) docker run --rm -v $(pwd):/app -w /app php:7.1-cli vendor/bin/phpunit`

# Serve
* `php -S 0.0.0.0:8000 -t public`
* or `(sudo) docker run --rm -it -v $(pwd):/app -w /app -p 8000:8000 php:7.1-cli php -S 0.0.0.0:8000 -t public`
* then go to http://127.0.0.1:8000 

# Generate via command

## Usage
Command: `fm:generate-codes`

Parameters:
* `--numberOfCodes` / `-c`: how many codes to generate
* `--lengthOfCode` / `-l`: how long the codes should be
* `--file` / `-o` (optional): output file name

## Example invocation
* `php bin/console fm:generate-codes -c 100 -l 5 -o output.csv`
* or `(sudo) docker run --rm -v $(pwd):/app -w /app php:7.1-cli php bin/console fm:generate-codes -c 100 -l 5 -o output.csv`
