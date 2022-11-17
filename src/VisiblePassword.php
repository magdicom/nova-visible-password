<?php

namespace Magdicom\NovaVisiblePassword;

use Closure;
use Laravel\Nova\Fields\Field;
use Illuminate\Support\Facades\Hash;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\SupportsDependentFields;

class VisiblePassword extends Field
{
    use SupportsDependentFields;

    /**
     * Display the field with value
     *
     * @var bool
     */
    public $initWithValue = false;

    /**
     * Hash the value on save
     *
     * @var bool
     */
    public $hashOnSave = true;

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
     * Indicates if the value can be displayed in forms
     *
     * @var bool
     */
    public $visibleOnForms = true;

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
     * Make it possible to display the hidden data on resource detail
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
     * Whether to hash the provided value before storing it or keep it plain.
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this
     */
    public function hashOnSave($callback = true)
    {
        if ($callback instanceof Closure && is_callable($callback)) {
            $this->hashOnSave = call_user_func($callback);
        }
        else {
            $this->hashOnSave = (bool) $callback;
        }

        // as the retrieved value is hashed, there is no point of displaying it
        // anyway you can bypass this behavior using `withValue(true)`
        if ($this->hashOnSave) {
            $this->initWithValue = false;
        }

        return $this;
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param NovaRequest $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return mixed
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if (! empty($request[$requestAttribute]) && $this->hashOnSave === true) {
            $model->{$attribute} = Hash::make($request[$requestAttribute]);
        }
        else {
            parent::fillAttributeFromRequest($request, $requestAttribute, $model, $attribute);
        }
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
            'valueIndex' => $this->visibleOnIndex ? $this->value : '',
            'valueDetail' => $this->visibleOnDetail ? $this->value : '',
            'visibleOnIndex' => $this->visibleOnIndex,
            'visibleOnDetail' => $this->visibleOnDetail,
            'visibleOnForms' => $this->visibleOnForms,
            'showMessage' => trans('visiblePassword::messages.show'),
            'hideMessage' => trans('visiblePassword::messages.hide'),
        ]);
    }
}
