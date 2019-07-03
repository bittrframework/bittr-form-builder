<?php

use Bittr\Form;

require 'src/Form.php';

$name = 'rand';
$attributes_arr = [
    'class' => 'form-class',
    'id'    => 'form-id',
    'pl'    => 'Placeholder'
];
$options = [
    'Volvo',
    'Saab',
    'Audi'
];

$selected = 'Saab';
$disabled = ['Audi'];
$max_size = 0;
$source   = 'source';
$content  = 'Content';
$value    = 10;
$max_val  = 100;
$label    = true; // show label.

echo (new Form('index.php'))
    ->persistWith($_POST) // data to repopulate
    ->shortTags(['pl' => 'placeholder']) // replace all pl in element attribute as placeholder
    ->checkbox($name, $attributes_arr, 'Check')
    ->hidden($name, $attributes_arr)
    ->email('email_address', $attributes_arr, $label)->val('foo@bar.com')
    ->password($name, $attributes_arr, $label)
    ->text($name, $attributes_arr, $label)
    ->color($name, $attributes_arr, $label)
    ->date($name, $attributes_arr, $label)
    ->datetimeLocal($name, $attributes_arr, $label)
    ->file($name, $attributes_arr, $max_size)
    ->image($name, $source, $attributes_arr, $label)
    ->month($name, $attributes_arr, $label)
    ->number($name, $attributes_arr, $label)
    ->radio($name, $attributes_arr, 'Click')
    ->range($name, $attributes_arr, $label)
    ->reset($attributes_arr)
    ->search($name, $attributes_arr, $label)
    ->tel($name, $attributes_arr, $label)
    ->time($name, $attributes_arr, $label)
    ->url($name, $attributes_arr, $label)
    ->week($name, $attributes_arr, $label)
    ->select($name, Form::MONTH, $attributes_arr, $label)
    ->datalist($name, range(1, 10), $attributes_arr)
    ->textarea($name, $attributes_arr, $label)
    ->output($name, $attributes_arr, $label)
    ->repeatable(2, function (Form $form) {
        $form->html('<div class="sdsd">')
            ->text('name[]')
            ->select('range[]', range(1, 3), [], true, true)
            ->html('</div>');
    })
    ->label('custom', 'your custom input')
    ->text('remove')
    ->progress($value, $max_val)->move('email_address')
    ->remove('remove')
    ->bSubmit("Submit");
