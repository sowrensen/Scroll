# Scroll

> Write blog posts using markdown formatting.

Scroll is a _sample_ laravel package built on test purpose. It can be used to write articles using markdown formatting. 

### Acknowledgement

This package is built following _vicgonvt_'s [Press](https://github.com/vicgonvt/Press) package. 

**Changes and Updates**

Scroll is updated to Laravel 7 along with proper replacement of all `str_` and `array_` helper methods using `Str` and `Array` class. Also,
`assertContains()` methods for testing updated with `assertStringContainsString()` method. The structure of Scroll slightly defers with the structure of Press.

### Installation

Add the following lines to your `composer.json` file.

```json
{
    "require": {
        "sowrensen/scroll": "dev-master"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/sowrensen/Scroll.git"
        }
    ]
}
```

Hence run `composer update` in the terminal.

### Publish Configs

You have to publish the configuration file to use the package. Run the following command and a `scroll.php` file will be placed at the `config` folder of your app.

```bash
php artisan vendor:publish --tag=scroll-config
```

### Writing markdown files

Before you start writing your own markdown posts, you've to define a place to store them in the `scroll.php` config file. By default it is set to `scrolls` which will be placed on your project's root directory. You can change the directory name.

Once you created desired directory, you can write your posts using following format.

### Sample markdown file

```markdown
---
title: A beautiful post title
date: June 13, 2020
---

## Heading of my post

Content of my post
```

You can add custom field in header section. Try adding a `mood` field.


### Processing custom fields

Now, if you want, you can customize how your custom field appear while it is getting parsed. Also you can overwrite any of the field parsing style provided by default. For that you have to publish the Service Provider.

```bash
php artisan vendor:publish --tag=scroll-provider
```

Then, create a new directory `Fields` in your app directory and create a new PHP class there. For example, I'm creating a `Mood.php` file. This class will extend `Sowren\Scroll\Fields\FieldContract` class and define `process()` static method which receives three arguments `$fieldType`, `$fieldValue`, and `$data`.

```php
// Mood.php

namespace App\Fields;

use Sowren\Scroll\Fields\FieldContract;

class Mood extends FieldContract
{
    public static function process($fieldType, $fieldValue, $data)
    {
        return [
            'mood' => 'Do something with your mood',
        ];
    }
}
```

As a last step, add this class to the `registerFields()` method of recently published `Providers\ScrollServiceProviders` class.

```php
// ScrollServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Sowren\Scroll\Facades\Scroll;

class ScrollServiceProvider extends ServiceProvider
{
    //...
    protected function registerFields()
    {
        return [
            \App\Fields\Mood::class,
        ];
    }
}
```

Repeat the same procedure for overwriting any other predefined fields.
