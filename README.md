# Twitter Bootstrap Forms for Laravel 5

Based on [LaravelCollective/html](https://github.com/LaravelCollective/html)

Tested with Twitter Bootstrap >= 3.3.0

## Install

Install package through composer

```bash
composer require rutorika/laravel-html
```

Add service provider and facades to your `config/app.php`

```php
'providers' => [
    // ... other providers

    Rutorika\Html\HtmlServiceProvider::class,
];

'aliases' => [
    // ... other facades

    'Form' => Rutorika\Html\FormFacade::class,
    'Html' => Rutorika\Html\HtmlFacade::class,
]
```

## Usage

This package provides Form::*Fields methods.
First argument for this methods is `$title` which wil be set as label of the field.
Next arguments are the same as arguments in original * method.
The last argument is `$help` which will be set as help text under the input.

For example:

```php
Form::textField($title,  $name, $value = null, $options = [], $help = '') // because Form::title($name, $value = null, $options = [])
```

so

```php
Form::textField('Field Title',  'title', 'Field Value')
```

will generate html:

```html
<div class="form-group">
    <label for="title" class="col-md-3 control-label">Filed Title</label>
    <div class="col-md-9">
        <input class="form-control" name="title" type="text" value="Field Value">
    </div>
</div>
```

Also all error messages and corresponding css-classes if errors exists will be appended to the field.

## Available Form Methods

### Wrappers for laravelcollective form inputs

 * `Form::textField($title, $name, $value = null, $options = [], $help = '')` text field
 * `Form::textareaField($title, $name, $value = null, $options = array(), $help = '')` textarea field
 * `Form::passwordField($title, $name, $options = array(), $help = '')`
 * `Form::checkboxField($title, $name, $value = 1, $checked = null, $options = [])`
 * `Form::hiddenField($title, $name, $value = null, $options = [], $help = '')` useless :)
 * `Form::numberField($title, $name, $value = null, $options = [], $help = '')`
 * `Form::selectField($title, $name, $list = [], $selected = null, $options = [], $help = '')`
 * `Form::staticField($title, $value, $help = '')` static text

### Custom Form fields

#### Code Field

[Ace](http://ace.c9.io/) code editor field

```php
Form::codeField($title, $name, $value = null, $options = array('mode' => 'html', 'theme' => 'monokai'), $help = '')
```

##### Options
* `theme` -- code editor theme, default -- `textmate`. [See all themes](https://github.com/ajaxorg/ace/tree/master/lib/ace/theme)
* `mode` -- code language, default -- `html`. [See all modes](https://github.com/ajaxorg/ace/tree/master/lib/ace/mode)

##### Installation

You should [embed Ace to your site](http://ace.c9.io/#nav=embedding) and apply it to textareas with `ace-editor` css class. For example:

```js
$('.js-code-field').each(function () {

    var $field = $(this);
    var editor = ace.edit($field.siblings('.js-code').get(0));

    var mode = 'ace/mode/' + $field.data('mode');
    var theme = $field.data('theme');

    editor.getSession().setMode(mode);

    if (theme) {
        editor.setTheme('ace/theme/' + theme);
    }

    editor.getSession().setValue($field.val());

    editor.getSession().on('change', function () {
        $field.val(editor.getSession().getValue());
    });
});
```

#### Color Field

[Jquery Minicolors](http://labs.abeautifulsite.net/jquery-minicolors/) colorpicker field

```php
// as input
Form::color($name, $value = null, $options = ['minicolors' => ['control' => 'hue']])
// as field
Form::colorField($title, $name, $value = null, $options = ['minicolors' => ['control' => 'hue']], $help = '')
```

##### Options

* `'minicolors' => ['control' => 'hue', 'defaultValue' => '', /* ... */]`. All this settings will be passed to minicolors settings. [See all available settings](http://labs.abeautifulsite.net/jquery-minicolors/#settings).

##### Installation

You should [embed Jquery Minicolors to your site](http://labs.abeautifulsite.net/jquery-minicolors/#download) and apply it to fields:

```js
$('.js-color-field').each(function () {
    var $field = $(this);
    var settings = $field.data('minicolors');

    settings = $.extend({theme: 'bootstrap'}, settings);

    $field.minicolors(settings);
});
```


#### Geopoint Field

Allows you to select a point on the map. OSM, Google, Bing and Yandex maps (and all their types) are supported (via [Leaflet](http://leafletjs.com/) and [leaflet-plugins](https://github.com/shramov/leaflet-plugins)).

```php
// as input
Form::geopoint($name, $value = null, $options = ['map' => ['center' => [10, 10], 'zoom' => 11], 'layer' => 'yandex', 'type' => 'publicMapHybrid'])
// as field
Form::geopointField($title, $name, $value = null, $options = ['map' => ['center' => [10, 10], 'zoom' => 11], 'layer' => 'yandex', 'type' => 'publicMapHybrid'], $help = '')
```

Field generates string value `latitude:longitude`, e.g. `45.060184073445356:38.96455764770508`

##### Options

- `map` *array* map options passed to Leaflet map constructor. In general you need set center (will be default center of map if no value) and zoom only. [See all available options](http://leafletjs.com/reference.html#map-options)
- `layer` *string* one of `yandex`, `osm`, `bing`, `google`. default `osm`. Which map provider will be used.
- `type` *string* type of map. Each provider has his own available map types
  - `osm`: default `http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`. [Find more](http://leaflet-extras.github.io/leaflet-providers/preview/)
  - `google`: default `ROADMAP`, available: `ROADMAP`, `SATELLITE`, `HYBRID`, `TERRAIN`. [More info](https://developers.google.com/maps/documentation/javascript/maptypes)
  - `bing`: default `Road`, available: `Road`, `Aerial`, `AerialWithLabels`, `Birdseye`, `BirdseyeWithLabels`. [More info](https://msdn.microsoft.com/en-us/library/ff701716.aspx)
  - `yandex`: default `map`, available: `map`, `satellite`, `hybrid`, `publicMap`, `publicMapHybrid`

##### Installation

You should [embed Leaflet](http://leafletjs.com/examples/quick-start.html) (both css and js). If you use provider different from `osm`, you should embed required plugins from [leaflet-plugins](https://github.com/shramov/leaflet-plugins), e.g. `/leaflet-plugins/layer/tile/Google.js`, `/leaflet-plugins/layer/tile/Bing.js` or `/leaflet-plugins/layer/tile/Yandex.js`.
If you use `google` or `yandex` add their api, e.g. `//maps.google.com/maps/api/js?v=3.2&sensor=false` or `//api-maps.yandex.ru/2.1/?lang=ru_RU`

And apply map to field

#### Image Field
*@TODO move from rutorika/dashboard*
#### Image Multiple Field
*@TODO move from rutorika/dashboard*
#### File Field
*@TODO move from rutorika/dashboard*
#### File Multiple Field
*@TODO move from rutorika/dashboard*
#### Select2 Field
*@TODO move from rutorika/dashboard*
#### Date Field
*@TODO move from rutorika/dashboard*
#### Datetime Field
*@TODO move from rutorika/dashboard*
#### Time Field
*@TODO move from rutorika/dashboard*

### Helper methods

#### Submit button

```php
Form::submitField($title = 'Submit')
```

Generates submit button with proper offset:

```html
<div class="form-group">
    <div class="col-sm-offset-3 col-md-9">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
```

#### Field wrapper

```php
Form::field($title, $name, $control = '', $help = '')
```

Wraps `$control` html string with form group. It's helpful when you write your own field input and need to proper wrap it with form group (errors will be automatically appends to the field).

```html
<div class="form-group ">
    <label for="title" class="col-md-3 control-label">Filed Title</label>
    <div class="col-md-9">
        Control HTML
    </div>
</div>
```

## Helpers

#### delete_form

Returns form which will send pseudo DELETE request to `$url` url after submit (icon clicked). Styled as icon link. Useful in grids

```php
delete_form($url, $label = '<i class="glyphicon glyphicon-remove"></i>')
```

Generates:

```html
<form method="POST" action="/some/url" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    <input name="_token" type="hidden" value="SomeCSRFToken">
    <button type="submit" class="btn btn-link"><i class="glyphicon glyphicon-remove"></i></button>
</form>
```

Example:

![Grid with delete forms example](https://habrastorage.org/files/b2a/380/96b/b2a38096b6e648978a464430e1537673.png)

## Contributing

```bash
xu@calipso$ php-cs-fixer fix ./src/ --dry-run --diff --config-file=".php_cs" # show code style fixes fixes
xu@calipso$ php-cs-fixer fix ./src/ --config-file=".php_cs" # fix code style
xu@calipso$ ./vendor/phpunit/phpunit/phpunit tests/ # run tests
```