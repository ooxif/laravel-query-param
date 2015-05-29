laravel-query-param
===================

Treats binary data in a correct way with Laravel's database system (Eloquent).

What laravel-query-param does
-----------------------------

Laravel uses PDO & PDOStatement, passes parameters to PDOStatement::execute().  
PDOStatement::execute() treats all parameters as PDO::PARAM_STR which breaks some binary data.

`laravel-query-param` overrides PDOStatement::execute() to treat binary data as PDO::PARAM_LOB.


Install
-------

`composer require "ooxif/laravel-query-param:1.0.*"`

then add `'Ooxif\LaravelQueryParam\QueryParamServiceProvider',` to `providers` in `config/app.php`.


Examples
--------
```php
// table contains a binary column
Schema::create('images', function ($table) {
    $table->increments();
    $table->timestamps();
    $table->binary('data');
});


// use ModelTrait, add '(column name)' => 'binary' to $casts
class Image extends Eloquent
{
    use Ooxif\LaravelQueryParam\ModelTrait;

    protected $table = 'images';
    
    protected $casts = [
        'data' => 'binary',
    ];
}


$lob = 'some binary data'; 
$image = new Image();

// setting/getting 
$image->data = $lob;
$image->data; // object(Ooxif\LaravelQueryParam\Param\ParamLob)
$image->data->value() === $lob; // true

// saving
$image->save();

// querying (model) - use param_lob()
$image = Image::where('data', param_lob($lob))->first();

// querying (db) - use param_lob()
$result = DB::table('images')->where('data', param_lob($lob))->first();
$result->data === $lob; // true
```
