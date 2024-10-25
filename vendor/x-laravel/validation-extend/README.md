# X-Laravel - Validation Extend Package

<p align="center">
<a href="https://packagist.org/packages/X-Laravel/validation-extend" rel="nofollow"><img src="https://img.shields.io/packagist/v/X-Laravel/validation-extend" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/X-Laravel/validation-extend" rel="nofollow"><img src="https://img.shields.io/packagist/dt/X-Laravel/validation-extend" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/X-Laravel/validation-extend" rel="nofollow"><img src="https://poser.pugx.org/X-Laravel/validation-extend/dependents.svg" alt="Dependents"></a>
<a href="https://packagist.org/packages/X-Laravel/validation-extend" rel="nofollow"><img src="https://img.shields.io/packagist/l/X-Laravel/validation-extend" alt="License"></a>
</p>

<p align="center">
<a href="https://scrutinizer-ci.com/g/X-Laravel/validation-extend/build-status/master" rel="nofollow"><img src="https://scrutinizer-ci.com/g/X-Laravel/validation-extend/badges/quality-score.png?b=master" title="Scrutinizer Code Quality"></a>
<a href="https://styleci.io/repos/322273682" rel="nofollow"><img src="https://styleci.io/repos/322273682/shield?branch=master" alt="StyleCI"></a>
</p>

## Introduction

Adds rules that may be required that are not in the Laravel validation class.

## Requirements

Laravel >=5.5. Other than that, this library has no requirements.

## Install

```bash
$ composer require x-laravel/validation-extend
```

## Example Usage

```php
use Illuminate\Support\Facades\Validator;

$validator = Validator::make($request->all(), [
    'staff_name' => 'required|human_name',
]);
```

## License

This package is open source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
