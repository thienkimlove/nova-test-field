# Money Field for Laravel Nova

A custom money field for a Laravel\Nova application I am working on. The default Currency field provided by Nova didn't quite cut the mustard for me so ended up creating this.

- Works with minor units (both updating and displaying)
- Displays the amount with the correct currency sign and in the proper locale format
- Adds the currency sign to the create/update field

## Installing

You can install the package into your Nova application via composer:

```
composer require everestmx/nova-money-field
```

## Using
In your nova resource file, add the following into your Fields method:

```
use Everestmx\NovaMoneyField\Money;

public function fields (Request $request)
{
	return [
		Money::make('Price'),
	];
}
```

## Options
You can optionally add the column name to be used if different from the display name as per any Nova field:
```
Money::make('Price', 'price_column');
```
The default currency is **GBP** but can be changed per field using currency()
```
Money::make('Price')->currency('USD');
```
The default locale is the one set as per the Laravel config('app.locale') file but can be changed per field using locale()
```
Money::make('Price')->locale('en_US');
```
By default we assume you are storing values not as minor units, but you can change this with minor(true)
```
Money::make('Price')->minor(true);
```
This will automatically format all entered values into minor units so remember to remove any laravel set/get attribute methods on your models!

## Advanced
The defaults loaded for this package (Currency, Locale, etc) are loaded within the 'loadDefaults' method within src\Money.php
