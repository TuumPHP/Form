Tuum/Form
======

Various helper classes for generating Html tags and managing data. 

*   Status: Alpha release.
*   Psr-1, Psr-2, and Psr-4. 

### Licence

MIT Licence

Getting Started
------

### Installation

```sh
composer require "tuum/form: 0.2.*"
```

### code

The ```DataView``` object is the master of all other services. For instance, 

```php
use Tuum\Form\DataView;

$view = new DataView();
$view->setInputs([
    'name' => 'value',
    'more' => [
        'key' => 'val'
    ]
]);
echo $view->inputs->get('name'); // 'value'
echo $view->inputs->get('more[key]'); // 'val'
echo $view->forms->text('name', 'default'); // text input form
```

The ```forms``` helper generates an html tag for input[type=text] with the value attribute (not 'default' but) 'value' which is set in the $inputs, like;

```html
<input type="text" name="name" value="value" />
```


### Helpers

These helpers help to manage data to be viewed in a template. There are, 

*   Escape,
*   Data,
*   Inputs,
*   Errors,
*   Message,
*   Forms, and
*   Dates,

helpers. 

Escape Helper
----

Use ```Escape``` class to manage escape method when redering a string inside a template. As a default, strings will be escaped using ```htmlspecialchars``` function for HTML files. 

```php
$esc = new Escape();
echo $esc('<danger>safe</danger>'); // or
echo $esc->escape('<danger>safe</danger>');
```

You can specify another escape method at the construction or using ```withEscape``` method:

```php
$esc = new Escape('addslashes');
// or
$esc = $esc->withEscape('rawurlencode');
```

The helpers registered in ```DataView``` will use the escape object; 

```php
$view = new DataView(new Escape('addslashes'));
$view->inputs->get('with-slash'); // escaped with addslashes.
```

Data Helper
----

Use ```Data``` class to display strings and values to template while escaping the values. 


```php
$data = Data::forge(['view'=>'<i>val</i>'], $esc);
// or 
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

#### iteration

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

> caution when using the iteration...
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


#### hidden tag

a simple method to show a hidden tag:

```php
$data = Data::forge(['_method'=>'put']);
echo $data->hiddenTag('_method');  
// <input type="hidden" name="_method" value="put" />
```

#### extract by key 

use ```extractKey``` method to create a subset of ```Data``` object if the data is  an array of another array (or object).

```php
$data = Data::forge(['obj'=>new ArrayObject['type' => 'object']);
$obj = $data->extractKey('obj');
echo $obj->type;  // object
```

Inputs Helper
----

The ```Inputs``` class introduces a convenient way to access array of data using names of HTML form elements. (think Laravel's Input::old values are populated in Form class). 

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
echo $input->checked('gender', 'male');   // ' checked'
echo $input->checked('gender', 'female'); // empty
vardump($input->get('types')); // ['a', 'c']
echo $input->checked('types', 'a'); // ' checked'
echo $input->checked('types', 'b'); // empty
echo $input->get('sns[twitter]'); // 'example@twitter.com'
```

Errors Helper
----

The ```Errors``` maybe used as conjunction with ```Inputs```, where as ```Errors``` for invalidated message for input data. 

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

To change the format of the error message, just do:

```php
$errors->format = '<div>(*_*) %s</div>';
```

Message Helper
----

This helper may not be that generic. Message class is for general message to be displayed in a main contents of a web page.

```php
$message = new Message;
$message->add('hello');
$message->add('whoops', Message::ERROR);
echo $message->onlyOne(); 
// <div class="alert alert-danger">Whoops</div>
```

The ```onlyOne``` method shows only one first message that is most severe. 

Forms Helper
------

generates html form tags. 

```php
$form = new Form();

// or using DataView
$view = new DataView();
$form = $view->forms;
```

### input elements

Creates various form input element. The most generic method is ```input```. 

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
<?= $form->date('date')->class('form')->placeholder('date'); ?>
```


#### open/close forms

To start a form; 

```php
<?= $form->open()->action('to')->method('post')->uploader(); ?>
<?= $form->close(); ?>
```

if a non-standard method is given, it will generate a hidden tag with the method in the ```open()``` method, as;

```html
<input type="hidden" name="_method" value="some-method" />
```

### label

can output label as;

```php
$form->label('label string', 'for-id');
```

### buttons

currently, two buttons are supported. 

```php
$form->submit('button name');
$form->reset('cancel me');
```

### textArea

text-area is supported. 


```php
$form->textArea('area-name', 'default value');
```

### select list

it's easy to create a select box. 

```php
$list = [
    '1' => 'selecting',
    '2' => 'is',
    '3' => 'easy',
];
$form->select('name', $list, '2');
```

### checkbox and radio list

Often you want to generate a list of checkbox or radio buttons. You can build it a bit like a select box. 

```php
$list = [
    '1' => 'checkbox',
    '2' => 'radio',
];
echo $form->checkList('checks', $list, '1');
```

will output;

```html
<ul>
  <li><label><input type="checkbox" name="checks" value="1" />checkbox</label></li>
  <li><label><input type="checkbox" name="radio" value="1" /> radio </label></li>
</ul>
```

but you might not like the output above. then,

```php
$list = $form->checkList('radio', $list, '2');
foreach(array_keys($list->getList()) as $key) {
   echo $key, ': ', $list->getInput($key), '<br/>';
}
```

will show how to construct html.

> ugly usage. need method like getKeys() method here. 

Dates Helper
------

a helper to create select box list style date fields. For instance, 

```php
echo $form->dates->dateYMD('day', '2015-06-18');
```

will generate html like (options are omitted);

```html
<select name="day_y"></select>
<select name="day_m"></select>
<select name="day_d"></select>
```

to-be-written....
