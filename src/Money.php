<?php

namespace Thienkimlove\NovaTestField;

use Brick\Math\RoundingMode;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money as MoneyMaker;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Symfony\Component\Intl\Currencies;

/**
 * Class Money
 * @package Everestmx\NovaMoneyField
 */
class Money extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-money-field';

    /**
     * The values are stored as minor units.
     *
     * @var boolean
     */
    public $minorUnits = false;

    /**
     * The locale the field will be displayed using.
     *
     * @var string
     */
    public $locale;

    /**
     * The currency to be used.
     *
     * @var string
     */
    public $currency;

    /**
     * Create a new field.
     *
     * @param string      $name
     * @param string|null $attribute
     * @param mixed|null  $resolveCallback
     *
     * @return void
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->loadDefaults();

        $this->displayUsing(function ($value) {
            return $this->getDisplay($value);
        });
    }

    /**
     * Load the default values for this package.
     *
     * @return void
     */
    protected function loadDefaults()
    {
        $this->locale   = config('app.locale');
        $this->currency = config('app.currency', 'USD');

        $this->withMeta([
            'minor_units' => $this->minorUnits,
            'currency'    => Currencies::getSymbol($this->currency)
        ]);
    }

    /**
     * Format the value and return it to be displayed.
     *
     * @param $value
     *
     * @return string
     * @throws UnknownCurrencyException
     */
    protected function getDisplay($value)
    {
        if ($this->minorUnits) {
            $money = MoneyMaker::ofMinor($value, $this->currency);
        } else {
            $money = MoneyMaker::of($value, $this->currency);
        }

        return $money->formatTo($this->locale);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param NovaRequest $request
     * @param string      $requestAttribute
     * @param object      $model
     * @param string      $attribute
     *
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = $this->minorUnits ? $request[$requestAttribute] * 100 : $request[$requestAttribute];
        }
    }

    /**
     * @param bool $value
     *
     * @return Money
     */
    public function minor(bool $value)
    {
        $this->minorUnits = $value;

        return $this->withMeta([
            'minor_units' => $value
        ]);
    }

    /**
     * Overwrite the currency to be used.
     *
     * @param string $currency
     *
     * @return $this
     */
    public function currency(string $currency)
    {
        $this->currency = $currency;

        return $this->withMeta([
            'currency' => Currencies::getSymbol($currency)
        ]);
    }

    /**
     * The monetary locale the field will be displayed in.
     *
     * @param string $locale
     *
     * @return $this
     */
    public function locale(string $locale)
    {
        $this->locale = $locale;

        return $this;
    }
}
