Tuum/Form
======

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TuumPHP/Form/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/TuumPHP/Form/?branch=1.x)
[![Build Status](https://scrutinizer-ci.com/g/TuumPHP/Form/badges/build.png?b=1.x)](https://scrutinizer-ci.com/g/TuumPHP/Form/build-status/1.x)

Helper classes for escaping input values, generating HTML tags, and managing data. 

### Licence

MIT Licence

### PSR

PSR-1, PSR-2, and PSR-4. 

Getting Started
------

### Installation

```sh
composer require "tuum/form: ^1.0"
```

### Sample Code

Use `DataView` object to manage all other helpers. For instance, 

```php
use Tuum\Form\DataView;

$view = new DataView();
$view->setInputs([
    'name' => 'my-name',
    'bold' => '<b>bold</b>',
    'more' => [
        'key' => 'val'
    ]
]);
echo $view->inputs->get('name'); // 'my-name'
echo $view->inputs->get('more[key]'); // 'val'
echo $view->inputs->get('bold'); // escapes the value
echo $view->forms->text('name', 'default'); // <input type="text" value="my-name">
```

The `forms` helper generates an html tag for `input[type=text]` with the *"my-name"* which is set in `setInputs`, instead of given *"default"* value. 

```html
<input type="text" name="name" value="my-name" />
```


### List of Helpers

These helpers help to manage data to be viewed in a template. There are, 

*   `Escape` for escaping string,
*   `Data` for managing data,
*   `Inputs` for managing input-data,
*   `Errors` for managing input-errors,
*   `Message` for messages,
*   `Forms` for generating form elements, and
*   `Dates` for generating complex form elements.


Escape Helper
----

The `Escape` class manages the escaping string to securely display text in a certain content, such as HTML. 

### Escaping for Html

As a default, strings will be escaped using `Escape::htmlSafe($string)` method (which internally uses `htmlspecialchars` function for HTML files). 

```php
$esc = new Escape();
echo $esc('<danger>safe</danger>'); // or
echo $esc->escape('<danger>safe</danger>');
```

### Using Other Escape Method

You can specify another escape method at the construction or using `withEscape` method:

```php
$esc = new Escape('addslashes');
// or
$esc = $esc->setEscape('rawurlencode');
```

### Using Escape with DataView

The `DataView` object contains an `Escape` object to be shared with other helpers, such as `Data` and `Inputs`.  

Specify the escape at the construction. 

```php
$view = new DataView(new Escape('addslashes'));
$view->inputs->get('with-slash'); // escaped with addslashes.
// or change how to escape
$view->escape->setEscape('rawurlencode');
```


Data Helper
----

Use ```Data``` class to display strings and values to template while escaping the values. 


```php
// construct yourself. 
$data = Data::forge(['view'=>'<i>val</i>'], $escape);

// or use DataView class. 
$view = new DataView();
$view->setData(['some'=>'value']);
$data = $view->data;
```

to access data, any of the following works.

```php
echo $data['view'];      // escaped
echo $data->view;        // escaped
echo $data->get('view'); // escaped
echo $data->raw('view'); // raw value
echo $data->get('none', 'non\'s'); // show escaped default value
```

### Iterating Over Array

the `Data` object implements IteratorAggregate interface.

```php
$data1 = [
    'text' => 'testing',
    'more' => '<b>todo</b>',
];
$data2 = [
    'text' => 'tested',
    'more' => '<i>done</i>',
];
$data = Data::forge([$data1, $data2]);
foreach($data as $key => $val) {
    echo "$key: ", $val->text;
    echo "$key: ", $val->more; // escaped. 
}
```

> only works for an array. so do not do this...
>
> ```php
> $data = Data::forge([
>     'text' => 'tested',
>     'more' => '<i>done</i>',
> ]);
> foreach($data as $key => $val) {
>     echo "$key: ", $val->get(null); // won't work!
> }
> ```

### Extract by Key 

Use `extractKey` method to create a subset of ```Data``` object if the data is  an array of another array (or object).

```php
$data = Data::forge([
    'obj'=>new ArrayObject['type' => 'object']
]);
$obj = $data->extractKey('obj');
echo $obj->type;  // object
```

### Hidden Tag

There is a simple method to show a hidden tag:

```php
$data = Data::forge(['_method'=>'put']);
echo $data->hiddenTag('_method');  
// <input type="hidden" name="_method" value="put" />
```

Inputs Helper
----

Use `Inputs` class to convenient access array of data using HTML form element names. 

```php
<?php
$input = Inputs::forge([
    'name' => '<my> name',
    'gender' => 'male',
    'types' => [ 'a', 'c' ],
    'sns' => [
        'twitter' => 'example@twitter.com',
        'facebook' => 'example@facebook.com',
    ],
], $esc);

echo $input->get('name'); // escaped '<my> name'
echo $input->get('sns[twitter]'); // 'example@twitter.com'
vardump($input->get('types')); // ['a', 'c']
```

### `selected` and `checked` methods

There is `selected` and `checked` methods to simplify checking some form elements. 

```php
// supply name of elements and its value. 
echo $input->selected('gender', 'male');   // 'selected'
echo $input->selected('gender', 'female'); // empty
echo $input->checked('types', 'a'); // ' checked'
echo $input->checked('types', 'b'); // empty
```

Errors Helper
----

The `Errors` manages error messages associated with input values, which works just like `Inputs` class except that this class output the error message in a pre-defined format. 

```php
<?php
$errors = Errors::forge([
    'name' => 'message for name',
    'gender' => 'gender message',
    'types' => [ 2 => 'message for type:B' ],
    'sns' => [
        'facebook' => 'love messaging facebook?',
    ],
], $esc);
// default format is: <p class="text-danger">%s</p>
echo $errors->get('name'); // message for name
echo $errors->get('gender');   // gender message
echo $errors->get('types[2]'); // message for type:B
echo $errors->get('sns[facebook]'); // love messaging facebook?
```

Notice that the message for type:B has specific index number. In order for generic array input to work with error messages, you have to specify the index. 

### Message Format

To change the format of the error message, just do:

```php
$errors->format = '<div>(*_*) %s</div>';
```

Message Helper
----

This helper may not be that generic. Message class is for general message to be displayed in a main contents of a web page.

```php
$message = Message::forge();
$message->add('hello');
$message->add('whoops', Message::ERROR);

echo $message;
// shows two divs for hello and whoops. 

echo $message->onlyOne(); 
// <div class="alert alert-danger">Whoops</div>
```

The ```onlyOne``` method shows only one first message that is most severe. 

### Message Format

There are 3 formats for each severity of messages. Alter the format as necessary. 

```php
$message->formats = [
    self::MESSAGE => '<div>:) %s</div>',
    self::ALERT   => '<div>:| %s</div>',
    self::ERROR   => '<div>:( %s</div>',
];
```

Forms Helper
------

The `Forms` helper class generates various HTML form tags. 

```php
$form = new Form();

// or using DataView
$view = new DataView();
$form = $view->forms;
```

#### using with `Inputs` object

Inject `Inputs` object into `Forms` object to use it when generating HTML tags. 

```php
$forms = $forms->withInputs($inputs);
```

#### escaping for HTML

The `Forms` class **does not escape its property nor values**. It assumes that the values are given by the programmer. So, use `Data` helper when displaying user's input.

```php
$forms->text('safe', $data->get('safe'));
```

### Input Elements

Creates various form input element. The most generic method is `input`. 

```php
<?= $form->input('text', 'name', 'default value'); ?>
```

will generate 

```html
<input type="text" name="name" value="default value" />
```

Already various methods exists for html's input tags, such as: text, hidden, email, password, radio, and checkbox. 

The extra html attribute can be added by method as follows. 

```php
<?= $form->date('radio')->class('form')->placeholder('date')->checked; ?>
```

There are many shortcut methods defined in `Forms` object, such as `text`, `hidden`, `datetime`, etc. All these shortcuts has the same signature: 

```php
$form->$method(string $name, string $value = null);
``` 

### Open/Close Forms

To start and close a form; 

```php
<?= $form->open()->action('to')->method('post')->uploader(); ?>
<?= $form->close(); ?>
```

if a non-standard method is given, it will generate a hidden tag with the method in the `open()` method. The default name is `_method` which can be altered by the second argument to `method`, as;

```php
<?= $form->open()->action('to')->method('put', 'method_token'); ?>
```

```html
<form method="post" action="to" >
<input type="hidden" name="method_token" value="put" />
```

### Label

can output label as;

```php
$form->label('label string', 'for-id');
```

### Buttons

currently, two buttons are supported. 

```php
$form->submit('button name');
$form->reset('cancel me');
```

### TextArea

text-area is supported. 


```php
$form->textArea('area-name', 'default value');
```

### Select List

it's easy to create a select box. 

```php
$list = [
    '1' => 'selecting',
    '2' => 'made',
    '3' => 'easy',
];
echo $form->select('name', $list, '2');
```

The first argument being name of the element, second is the index of options, and 3rd is the selected item. 


### Checkbox and Radio List

Often you want to generate a list of checkbox or radio buttons. You can build it a bit like a select box. 

```php
$list = [
    '1' => 'checkbox',
    '2' => 'radio',
];
echo $form->checkList('checks', $list, '1');
```

will output the list of checkboxes inside `ul > li` surrounded with `label`;

```html
<ul>
  <li><label><input type="checkbox" name="checks" value="1" />checkbox</label></li>
  <li><label><input type="checkbox" name="radio" value="1" />radio</label></li>
</ul>
```

You can construct the HTML using own code.

```php
$list = $form->checkList('radio', $list, '2');
foreach($list as $key => $html) {
   echo $list->getLabel($key), ': ', $html, '<br/>';
}
```


Dates Helper
------

The `Dates` helper class aims to help reduce the pain of creating complex form elements, such as for date. For instance, 

```php
$form = new Dates();
echo $dates->useYear(
    YearList::forge(2014, 2016)
)->dateYMD('my-date', '2015-06-18');
```

will generate html for years between 2014 and 2016; 

```html
<select name="my-date_y">...</select>
<select name="my-date_m">...</select>
<select name="my-date_d">...</select>
```

### Using List for Year, Month, and Day

When using `Dates` class, it is always nice to specify the range of year using `useYear` method. 

There are `use*` methods for Year, Month, Day, Hour, Minute, and Second. Each method expects to get `ListInterface`, `Traversable` object, or an array. There are also `List` objects for each type with specific method to displayed in various format. 

```php
    
echo $date->useYear(
    YearList::forge(2014, 2016)->useJpnGenGou()
)->useMonth(
    MonthList::forge()->useFullText()
)->withClass('tested-class')
->resetWidth('123px')
->dateYM('test');
```

will generate some HTML like,

```html
<select name="test_y" class="tested-class" style="width: 123px" >
    <option value="2014">平成26年</option>
    <option value="2015">平成27年</option>
    <option value="2016">平成28年</option>
</select>/<select name="test_m" class="tested-class" style="width: 123px" >
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
</select>
```