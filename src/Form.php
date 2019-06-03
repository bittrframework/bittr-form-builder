<?php

/**
 * Bittr
 *
 * @license
 *
 * New BSD License
 *
 * Copyright (c) 2017, bittrframework community
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *      1. Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *      2. Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the
 *      documentation and/or other materials provided with the distribution.
 *      3. All advertising materials mentioning features or use of this software
 *      must display the following acknowledgement:
 *      This product includes software developed by the bittrframework.
 *      4. Neither the name of the bittrframework nor the
 *      names of its contributors may be used to endorse or promote products
 *      derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY bittrframework ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL BITTRF COMMUNITY BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

declare(strict_types=1);

namespace Bittr;

class Form
{
    /** @var array */
    private $buffer = [];
    /** @var array */
    private $shorts = [];
    /** @var array */
    private $form = [];
    /** @var bool */
    private $val = false;
    /** @var array */
    private $post = [];

    /** @var array */
    const MONTH = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    /**
     * Form constructor.
     *
     * @param string|null $action
     * @param string|null $method
     * @param array       $attr
     */
    public function __construct(string $action = null, string $method = null, array $attr = [])
    {
        if ($action || $method || $attr)
        {
            $this->form = ['action' => $action, 'method' => $method] + $attr;
        }
        $this->post = $_POST;
    }

    /**
     * Set behaviour attributes.
     *
     * @param array $persist_value
     * @return \Form
     */
    public function persistWith(array $persist_value): Form
    {
        $this->post = $persist_value;

        return $this;
    }

    /**
     * Creates an input field of type checkbox.
     *
     * @param string $name
     * @param array  $attr
     * @param string $content
     * @return Form
     */
    public function checkbox(string $name, array $attr = [], string $content = null): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'checkbox'];

        if (! $content && isset($attr['value']))
        {
            $content = $attr['value'];
        }

        if ($content)
        {
            $this->buffer[] = ['content' => $content, 'tag' => 'label'];
        }

        return $this;
    }

    /**
     * Creates an input field of type hidden.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function hidden(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'hidden'];

        return $this;
    }

    /**
     * Creates an input field of type email.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function email(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'email', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type password.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function password(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'password', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type submit.
     *
     * @param string      $value
     * @param string|null $name
     * @param array       $attr
     * @return Form
     */
    public function submit(string $value, string $name = null, array $attr = []): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'submit', 'value' => $value];

        return $this;
    }

    /**
     * Creates an input field of type text.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function text(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'text', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type button.
     *
     * @param string      $value
     * @param string|null $name
     * @param array       $attr
     * @return Form
     */
    public function button(string $value, string $name = null, array $attr = []): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'button', 'value' => $value];

        return $this;
    }

    /**
     * Creates an input field of type color.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function color(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'color', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type date.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function date(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'date', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type datetime-local.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function datetimeLocal(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'datetime-local', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type file.
     *
     * @param string $name
     * @param array  $attr
     * @param int    $max_size
     * @param bool   $label
     * @return Form
     */
    public function file(string $name, array $attr = [], int $max_size = 0, bool $label = true): Form
    {
        if ($max_size > 0)
        {
            $this->buffer[] = "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"{$max_size}\">";
        }
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'file', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type file.
     *
     * @param string $name
     * @param string $source
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function image(string $name, string $source, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'src' => $source, 'type' => 'image', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type month.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function month(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'month', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type list.
     *
     * @param string $name
     * @param array  $options
     * @param array  $attr
     * @param bool   $label
     * @return \Form
     */
    public function datalist(string $name, array $options, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'list' => $name, 'l' => $label];
        $this->buffer[] = ['id' => $name, 'tag' => 'datalist', 'options' => [$options, null, [], false]];

        return $this;
    }

    /**
     * Creates an input field of type number.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function number(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'number', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type radio.
     *
     * @param string $name
     * @param string $content
     * @param array  $attr
     * @return Form
     */
    public function radio(string $name, array $attr = [], string $content = null): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'radio'];

        if (! $content && isset($attr['value']))
        {
            $content = $attr['value'];
        }

        if ($content)
        {
            $this->buffer[] = ['content' => $content, 'tag' => 'label'];
        }


        return $this;
    }

    /**
     * Creates an input field of type range.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function range(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'range', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type reset.
     *
     * @param array $attr
     * @return Form
     */
    public function reset(array $attr = []): Form
    {
        $this->buffer[] = $attr + ['type' => 'reset'];

        return $this;
    }

    /**
     * Creates an input field of type search.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function search(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'search', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type tel.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function tel(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'tel', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type time.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function time(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'time', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type url.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function url(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'url', 'l' => $label];

        return $this;
    }

    /**
     * Creates an input field of type week.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function week(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'week', 'l' => $label];

        return $this;
    }

    /**
     * Creates a form select.
     *
     * @param string $name
     * @param array  $options
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function select(
        string $name,
        array $options,
        array $attr = [],
        bool $label = true,
        bool $use_key_as_value = false
    ): Form
    {
        $selected = null;
        $disabled = [];
        if (isset($attr['selected']))
        {
            $selected = $attr['selected'];
            unset($attr['selected']);
        }

        if (isset($attr['disabled']))
        {
            $disabled = $attr['disabled'];
            unset($attr['disabled']);
        }

        $this->buffer[] = $attr + [
                'name'    => $name,
                'tag'     => 'select',
                'options' => [$options, $selected, $disabled, $use_key_as_value],
                'l'       => $label
            ];

        return $this;
    }

    /**
     * Creates a button field of type button
     *
     * @param string      $content
     * @param string|null $name
     * @param array       $attr
     * @return Form
     */
    public function bButton(string $content, string $name = null, array $attr = []): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'button', 'content' => $content, 'tag' => 'button'];

        return $this;
    }

    /**
     * Creates a button field of type reset
     *
     * @param string|null $content
     * @param array       $attr
     * @return Form
     */
    public function bReset(string $content, array $attr = []): Form
    {
        $this->buffer[] = $attr + ['content' => $content, 'tag' => 'button'];

        return $this;
    }

    /**
     * Creates a button field of type button.
     *
     * @param string      $content
     * @param string|null $name
     * @param array       $attr
     * @return Form
     */
    public function bSubmit(string $content, string $name = null, array $attr = []): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'type' => 'submit', 'content' => $content, 'tag' => 'button'];

        return $this;
    }


    /**
     * Creates a textarea field
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function textarea(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'tag' => 'textarea', 'content' => '', 'l' => $label];

        return $this;
    }

    /**
     * Creates a keygen field.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function keygen(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'tag' => 'keygen', 'l' => $label];

        return $this;
    }

    /**
     * Creates a output field.
     *
     * @param string $name
     * @param array  $attr
     * @param bool   $label
     * @return Form
     */
    public function output(string $name, array $attr = [], bool $label = true): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'tag' => 'output', 'l' => $label];

        return $this;
    }

    /**
     * Assigns or update an input value
     *
     * @param string $value
     * @return Form
     */
    public function val(string $value): Form
    {
        $last = array_pop($this->buffer);
        if (isset($last[0]))
        {
            if (preg_match('~\bvalue=".*?"~', $last[0], $matches))
            {
                $last[0] = str_replace($matches[0], "value=\"{$value}\"", $last[0]);
            }
        }
        else
        {
            $last['value'] = $value;
        }
        $this->buffer[] = $last;

        return $this;
    }

    /**
     * Creates a label field.
     *
     * @param string      $content
     * @param string|null $for
     * @param array       $attr
     * @return Form
     */
    public function label(string $content, string $for = null, array $attr = []): Form
    {
        $this->buffer[] = $attr + ['content' => $content, 'tag' => 'label', 'for' => $for];

        return $this;
    }

    /**
     * Add html progress tag
     *
     * @param int   $value
     * @param int   $max
     * @param array $attr
     * @return Form
     */
    public function progress(int $value, int $max = 100, array $attr = []): Form
    {
        $this->buffer[] = $attr + ['value' => $value, 'max' => $max, 'tag' => 'progress'];

        return $this;
    }

    /**
     * Adds any html element.
     *
     * @param string $element
     * @return Form
     */
    public function html(string $element): Form
    {
        $this->buffer[] = [$element, 'tag' => 'raw'];

        return $this;
    }

    /**
     * Adds short replacement for HTML attributes.
     *
     * @param array $array
     * @return \Form
     */
    public function shortTags(array $array): Form
    {
        $this->shorts = $array;

        return $this;
    }

    /**
     * Make defined selected option attribute from array.
     *
     * @param array $params
     * @return string
     */
    private function makeOpt(array $params): string
    {
        [$options, $selected, $disabled, $key_as_value] = $params;
        $attr = '';

        foreach ($options as $val => $cont)
        {
            if (is_int($val) && ! $key_as_value)
            {
                $val = $cont;
            }

            $attr .= "\n\t<option value=\"{$val}\"";
            if ($selected == $val)
            {
                $attr .= ' selected';
            }
            if (in_array($val, $disabled))
            {
                $attr .= ' disabled';
            }
            $attr .= ">{$cont}</option>";
        }

        return "{$attr}\n";
    }


    /**
     * Create element attributes from array.
     *
     * @param array $attributes
     * @param bool  $val
     * @return string
     */
    private function makeAttr(array $attributes, bool $val = true): string
    {
        $attr = '';
        if ($val && ! $this->val && isset($attributes['name']))
        {
            $name = $attributes['name'];
            if (isset($this->post[$name]))
            {
                $value = $this->post[$name];
                if ($attributes['type'] == 'radio')
                {
                    if ($value == $attributes['value'])
                    {
                        $attributes['checked'] = 'checked';
                    }
                }
                elseif ($attributes['type'] == 'checkbox')
                {
                    if (is_array($value))
                    {
                        // Process array
                    }
                    else
                    {
                        if ($value == $attributes['value'])
                        {
                            $attributes['checked'] = 'checked';
                        }
                    }
                }
                else
                {
                    $attributes['value'] = $value;
                }
            }
        }

        foreach ($attributes as $key => $val)
        {
            if (is_int($key))
            {
                $attr .= " {$val}";
            }
            else
            {
                $key = $this->shorts[$key] ?? $key;
                $attr .= " {$key}=\"{$val}\"";
            }
        }

        return $attr;
    }

    /**
     * Adds a hidden input token to form for csrf check
     *
     * @param array       $attr
     * @param string      $name
     * @param string|null $value
     * @return $this
     */
    public function token(array $attr, string $name, string $value): Form
    {
        $this->buffer[] = $attr + ['name' => $name, 'value' => $value, 'type' => 'hidden'];

        return $this;
    }

    /**
     * Moves last added element to befor specified element name.
     *
     * @param string $before
     * @return \Form
     */
    public function move(string $before): Form
    {
        foreach ($this->buffer as $index => $el)
        {
            if (isset($el['name']) && $el['name'] == $before)
            {
                $last = array_pop($this->buffer);
                array_splice($this->buffer, $index, 0, [$last]);
                break;
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $form = '';
        $this->val = empty($this->post);

        foreach ($this->buffer as $el)
        {
            if (! empty($el['l']))
            {
                unset($el['l']);
                $name = str_replace(['[', ']'], '', $el['name']);
                $label = implode(' ', array_map('ucfirst', explode('_', $name)));
                $form .= "<label>{$label}</label>";
            }

            if (! isset($el['tag']))
            {
                $form .= "<input{$this->makeAttr($el)}/>\n";
            }
            elseif ($el['tag'] == 'select' || $el['tag'] == 'datalist')
            {
                $opts = $el['options'];
                $tag = $el['tag'];
                unset($el['tag'], $el['options']);
                if (isset($el['name']) && ! $this->val && isset($this->post[$el['name']]))
                {
                    $opts[1] = $this->post[$el['name']];
                }

                $form .= "<{$tag}{$this->makeAttr($el, false)}>{$this->makeOpt($opts)}</{$tag}>\n";
            }
            elseif (isset($el['content']))
            {
                $tag = $el['tag'];
                $cont = $el['content'];
                unset($el['tag'], $el['content']);
                if (isset($el['name']) && ! $this->val && isset($this->post[$el['name']]))
                {
                    $cont = $this->post[$el['name']];
                }

                $form .= "<{$tag}{$this->makeAttr($el, false)}>{$cont}</{$tag}>\n";
            }
            elseif ($el['tag'] == 'raw')
            {
                $form .= "{$el[0]}\n";
            }
            else
            {
                $tag = $el['tag'];
                unset($el['tag']);
                $form .= "<{$tag}{$this->makeAttr($el)} />\n";
            }
        }

        if (isset($this->form))
        {
            $form = "<form{$this->makeAttr($this->form)}>{$form}</form>";
        }
        unset($this->buffer);

        return $form;
    }
}
