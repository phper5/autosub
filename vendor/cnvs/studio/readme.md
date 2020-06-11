<p align="center">
<img src=".github/HEADER.png">
</p>

<p align="center">
<a href="https://packagist.org/packages/cnvs/studio"><img src="https://poser.pugx.org/cnvs/studio/downloads"></a>
<a href="https://packagist.org/packages/cnvs/studio"><img src="https://poser.pugx.org/cnvs/studio/v/stable"></a>
<a href="https://packagist.org/packages/cnvs/studio"><img src="https://poser.pugx.org/cnvs/studio/license"></a>
</p>

## Introduction

While Canvas does not dictate a specific design for your frontend, it does provide a basic starting point using [Bootstrap](https://getbootstrap.com) and [Vue](https://vuejs.org) that will be helpful for many applications.

## Installation

You may use composer to install Studio into your Laravel project:

```bash
composer require cnvs/studio
```

Once the `cnvs/studio` package has been installed, you may install the frontend scaffolding using the `studio:install` Artisan command:

```bash
php artisan studio:install
```

After installing the `cnvs/studio` Composer package and generating the frontend scaffolding, your `package.json` file will include the necessary dependencies to install and compile:

```bash
# Using NPM
npm install
npm run dev

# Using Yarn
yarn
yarn dev
```

## Configuration

After compiling Studio's assets, a primary configuration file will be located at `config/studio.php`. This file allows you to customize various aspects of how your application uses the package.

Studio exposes a simple UI at `/studio` by default. This can be changed by updating the `path` option:

```php
/*
|--------------------------------------------------------------------------
| Base Route
|--------------------------------------------------------------------------
|
| This is the URI path where Studio will be accessible from. You are free
| to change this path to anything you like. Note that the URI will not
| affect the paths of its internal API that aren't exposed to users.
|
*/

'path' => env('STUDIO_PATH_NAME', 'studio'),

/*
|--------------------------------------------------------------------------
| User Identifier
|--------------------------------------------------------------------------
|
| This is the publicly identifying attribute given in the URL to expose
| users. By default, the User ID will be used. Note that "username"
| requires a canvas_user_meta record to exist and be defined.
|
| Supported Identifiers: "id", "username"
|
*/

'identifier' => env('STUDIO_USER_IDENTIFIER', 'id'),
```

## License

Studio is open-sourced software licensed under the [MIT license](license).
