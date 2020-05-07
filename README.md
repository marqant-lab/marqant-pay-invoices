# Marqant Pay Invoices

PDF invoices for [marqant-lab/marqant-pay](https://github.com/marqant-lab/marqant-pay).

## Installation

You can require the package through composer like so.

```shell script
composer require marqant-lab/marqant-pay-invoices
```

You will need to run the migrations after setting 

This package uses laravel-snappy and wkhtmltopdf. Please see the [installation instructions](https://github.com/KnpLabs/snappy#wkhtmltopdf-binary-as-composer-dependencies)
 on their github page to make sure you have set up everything correctly.
 
For development at du we typically require wkhtmltopdf through composer like so.

```shell script
composer require h4cc/wkhtmltopdf-amd64 0.12.x
composer require h4cc/wkhtmltoimage-amd64 0.12.x
```

