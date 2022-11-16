<?php

namespace Magdicom\NovaVisiblePassword;

use Closure;
use Laravel\Nova\Fields\Field;

class VisiblePassword extends Field
{
    /**
     * Display the field with value
     *
     * @var bool
     */
    public $initWithValue = true;

    /**
     * Indicates if the value can be displayed in forms
     *
     * @var bool
     */
    public $visibleOnForms = true;

    /**
     * Indicates if the value can be displayed in resource index page
     *
     * @var bool
     */
    public $visibleOnIndex = false;

    /**
     * Indicates if the value can be displayed in resource detail page
     *
     * @var bool
     */
    public $visibleOnDetail = false;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-visible-password';

    /**
     * Fill the input field with its resource value
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this|mixed
     */
    public function withValue($callback = true)
    {
        if ($callback instanceof Closure && is_callable($callback)) {
            $this->initWithValue = call_user_func($callback);
        }
        else {
            $this->initWithValue = (bool) $callback;
        }

        return $this;
    }

    /**
     * Display the input field empty
     * @param  (callable():bool)|bool  $callback
     * @return $this|mixed
     */
    public function withoutValue($callback = true)
    {
        $this->initWithValue = ! $this->withValue($callback);

        return $this;
    }

    /**
     * Make it possible to display the hidden data on forms
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this|mixed
     */
    public function visibleOnForms($callback = true)
    {
        if ($callback instanceof Closure && is_callable($callback)) {
            $this->visibleOnForms = call_user_func($callback);
        }
        else {
            $this->visibleOnForms = (bool) $callback;
        }

        return $this;
    }

    /**
     * Make it possible to display the hidden data on resource index
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this|mixed
     */
    public function visibleOnIndex($callback = true)
    {
        if ($callback instanceof Closure && is_callable($callback)) {
            $this->visibleOnIndex = call_user_func($callback);
        }
        else {
            $this->visibleOnIndex = (bool) $callback;
        }

        return $this;
    }

    /**
     * Make it possible to display the hidden data on resource index
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this|mixed
     */
    public function visibleOnDetail($callback = true)
    {
        if ($callback instanceof Closure && is_callable($callback)) {
            $this->visibleOnDetail = call_user_func($callback);
        }
        else {
            $this->visibleOnDetail = (bool) $callback;
        }

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'value' => $this->initWithValue ? $this->value : '',
            'visibleOnIndex' => $this->visibleOnIndex,
            'visibleOnDetail' => $this->visibleOnDetail,
            'visibleOnForms' => $this->visibleOnForms,
            'showMessage' => trans('visiblePassword::messages.show'),
            'hideMessage' => trans('visiblePassword::messages.hide'),
        ]);
    }
}
