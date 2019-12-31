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

### About Nova Packages and everything.

* To make `composer update` with nova package work immediately

we should get the latest commit first 6 characters.

and using `composer require thienkimlove/nova-test-field:dev-master#78ff77`

* To make Laravel Nova work directly after edit nova packages 

```textmate
cd ./vendor/laravel/nova
mv webpack.mix.js.dist webpack.mix.js
npm install
npm run dev
rm -rf node_modules
cd -
php artisan nova:publish
```

and go back `./vendor/laravel/nova` and run `npm run watch`

Go to packages and run 
```textmate
npm install 
npm run dev or npm run watch
```

* After that we can install vuedevtool from chrome.

*  Add packages to packagist `https://packagist.org/packages/submit`

* Link about example which not implement but learn alot

`https://github.com/avarixe/myfifa-vue/blob/9ccb0e00efbad03c163cef5c0aa8b446e370660e/helpers/VMoneyField.vue`

*  Not implement `https://vuejs-tips.github.io/vue-the-mask/`

* Nova doc about npm

```textmate
Your Nova field contains a webpack.mix.js file, which is generated when Nova creates your field. You may build your field using the NPM dev and prod commands:

// Compile your assets for local development...
npm run dev

// Compile and minify your assets...
npm run prod
In addition, you may run the NPM watch command to auto-compile your assets when they are changed:

npm run watch
```

*  input mask nova but simple

```textmate
https://github.com/wemersonrv/input-mask/blob/master/resources/js/components/FormField.vue
```

* All about input mask `https://github.com/RobinHerbots/Inputmask`

* Using from this

```textmate
https://github.com/gnatishen/ticketService/blob/fa92060c7ab38b8a278411ca3b7dea875c1d839e/resources/js/components/ClientFormComponent.vue
```

*  Not try 

```textmate
import Inputmask from "inputmask";

export default {
  mounted() {
    let parentSelector = this.$refs.ipInput
    let selector = parentSelector.$el.children[1];
    Inputmask({"mask": "999.999.999.999"}).mask(selector);
  },
}
```

* another

```textmate
https://github.com/wemersonrv/input-mask/blob/master/resources/js/components/FormField.vue
https://novapackages.com/packages/everestmx/nova-money-field

```

* **Important**

Please note that after edit nova packages github code,

we must run

```text
npm run dev 
npm run prod
```
to rebuild `field.js`

after that we commit to github and using commit-hash to update composer

```text
composer require thienkimlove/nova-test-field:dev-master#<commit-hash>
```