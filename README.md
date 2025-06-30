# Laravel Translatable: Multilingual Support for Eloquent Models 🌍

![Laravel Translatable](https://img.shields.io/badge/version-1.0.0-blue.svg) ![License](https://img.shields.io/badge/license-MIT-green.svg) ![GitHub Releases](https://img.shields.io/badge/releases-latest-orange.svg)

[![Download Latest Release](https://img.shields.io/badge/download-latest%20release-blue.svg)](https://github.com/DomosHalmi/laravel-translatable/releases)

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Contributing](#contributing)
- [License](#license)
- [Links](#links)

## Introduction

Laravel Translatable is a powerful package designed for Laravel applications. It adds JSON-based multilingual support to Eloquent models, enabling developers to manage translations easily. With locale-aware field localization and case-insensitive, multi-locale search, this package simplifies the process of building applications that cater to a global audience.

## Features

- **JSON-Based Multilingual Support**: Store translations in a single JSON column in your database.
- **Locale-Aware Field Localization**: Automatically switch between languages based on user preferences.
- **Case-Insensitive Search**: Perform searches that respect different locales without worrying about case sensitivity.
- **Eloquent Integration**: Seamlessly integrate with Eloquent models for easy data management.
- **Simple Configuration**: Get started quickly with minimal setup required.

## Installation

To install the Laravel Translatable package, follow these steps:

1. **Install via Composer**:

   Run the following command in your terminal:

   ```bash
   composer require domoshalmi/laravel-translatable
   ```

2. **Publish Configuration**:

   Publish the configuration file with the following command:

   ```bash
   php artisan vendor:publish --provider="DomosHalmi\LaravelTranslatable\TranslatableServiceProvider"
   ```

3. **Run Migrations**:

   If you need to create a new table for your translations, run:

   ```bash
   php artisan migrate
   ```

For detailed instructions, please visit the [Releases](https://github.com/DomosHalmi/laravel-translatable/releases) section.

## Usage

Using Laravel Translatable is straightforward. Here’s how to get started:

### Step 1: Define Your Model

In your Eloquent model, use the `Translatable` trait. For example:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DomosHalmi\LaravelTranslatable\Translatable;

class Post extends Model
{
    use Translatable;

    protected $translatable = ['title', 'content'];
}
```

### Step 2: Storing Translations

To store translations, simply use the following syntax:

```php
$post = new Post();
$post->title = [
    'en' => 'Hello World',
    'fr' => 'Bonjour le monde',
];
$post->content = [
    'en' => 'This is a multilingual post.',
    'fr' => 'Ceci est un post multilingue.',
];
$post->save();
```

### Step 3: Retrieving Translations

You can retrieve translations based on the current locale:

```php
echo $post->title; // Automatically uses the current locale
```

### Step 4: Searching

Perform searches that respect locale:

```php
$posts = Post::where('title->en', 'Hello World')->get();
```

## Configuration

Laravel Translatable comes with a configuration file that allows you to customize various settings. You can find this file in `config/translatable.php`.

### Available Settings

- **Default Locale**: Set the default locale for your application.
- **Fallback Locale**: Specify a fallback locale for missing translations.
- **Supported Locales**: Define the locales your application supports.

## Contributing

We welcome contributions! If you want to help improve Laravel Translatable, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes and commit them.
4. Push your changes to your forked repository.
5. Create a pull request.

For more detailed guidelines, check the `CONTRIBUTING.md` file in the repository.

## License

Laravel Translatable is licensed under the MIT License. See the `LICENSE` file for more details.

## Links

For more information, visit the [Releases](https://github.com/DomosHalmi/laravel-translatable/releases) page to download the latest version and explore the package's features.

![Laravel Logo](https://laravel.com/img/logomark.min.svg)

### Topics

- Eloquent ORM
- Laravel Development
- Laravel Framework
- Localization
- Laravel Models
- Laravel Package
- PHP 8
- Query Builder

Explore the repository and discover how Laravel Translatable can enhance your application’s multilingual capabilities!