#!/bin/bash

# Voer PHPStan analyse uit
echo "Running PHPStan analysis..."
./vendor/bin/phpstan analyse

# Voer Laravel Pint uit
echo "Running Laravel Pint..."
./vendor/bin/pint

# Voer Rector process uit
echo "Running Rector process..."
./vendor/bin/rector process

echo "All tasks completed."