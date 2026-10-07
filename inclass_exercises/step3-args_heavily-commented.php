<?php

// step3_array_constructor.php

// Turn on PHP's strict type checking.
// This helps PHP enforce the data types that we declare in our code.
// For example, the $price property below is declared as ?float.
declare(strict_types=1);


/*
|--------------------------------------------------------------------------
| Guitar Class
|--------------------------------------------------------------------------
|
| A class is a blueprint for creating objects.
|
| Each Guitar object created from this class can store:
|   - a brand
|   - a model
|   - a price
|
| The class also contains:
|   - a constructor that receives data when the object is created
|   - a summary() method that formats the guitar information for display
|
*/
class Guitar
{
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    |
    | These properties store information about ONE Guitar object.
    |
    | The question mark (?) before the data type means that the property
    | is nullable.
    |
    | ?string means:
    |     the value may be a string OR null
    |
    | ?float means:
    |     the value may be a float OR null
    |
    | This is useful because a Guitar object may be created without all
    | of its information being known yet.
    |
    */

    // Stores the manufacturer/brand of the guitar.
    // Examples: "Fender", "Gibson", "Epiphone"
    public ?string $brand;

    // Stores the guitar model.
    // Examples: "Jazzmaster", "SG Special"
    public ?string $model;

    // Stores the price of the guitar.
    // The value may be a float such as 1199.00 or it may be null.
    public ?float $price;


    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    |
    | __construct() is a special PHP method.
    |
    | PHP automatically calls this method whenever we create a new object
    | using the "new" keyword.
    |
    | Example:
    |
    |     $g1 = new Guitar([...]);
    |
    | The array passed to Guitar(...) becomes the $args parameter below.
    |
    | The default value of [] means that the constructor can also be called
    | without providing any data:
    |
    |     $guitar = new Guitar();
    |
    | In that case, $args will simply be an empty array.
    |
    */
    public function __construct($args = [])
    {
        /*
        |----------------------------------------------------------------------
        | Set the brand
        |----------------------------------------------------------------------
        |
        | Look for a value stored under the "brand" key in the $args array.
        |
        | The ?? operator is called the NULL COALESCING OPERATOR.
        |
        | It means:
        |
        |     Use $args['brand'] if it exists and is not null.
        |     Otherwise, use null.
        |
        | Example:
        |
        |     ["brand" => "Fender"]
        |
        | makes:
        |
        |     $this->brand = "Fender";
        |
        | $this refers to the CURRENT Guitar object being created.
        |
        */
        $this->brand = $args['brand'] ?? null;

        // Do the same thing for the model.
        // If "model" was not supplied, the property becomes null.
        $this->model = $args['model'] ?? null;

        // Do the same thing for the price.
        // If "price" was not supplied, the property becomes null.
        $this->price = $args['price'] ?? null;
    }


    /*
    |--------------------------------------------------------------------------
    | summary()
    |--------------------------------------------------------------------------
    |
    | This method creates a readable description of the Guitar object.
    |
    | The ": string" after the parentheses is a RETURN TYPE DECLARATION.
    | It tells PHP that this method must return a string.
    |
    | Example return value:
    |
    |     Fender Jazzmaster - $1,199.00
    |
    */
    public function summary(): string
    {
        /*
        |----------------------------------------------------------------------
        | Prepare the brand for display
        |----------------------------------------------------------------------
        |
        | If $this->brand contains a value, use it.
        |
        | If $this->brand is null, use "Unknown Brand" instead.
        |
        */
        $brand = $this->brand ?? "Unknown Brand";

        // Use the stored model when available.
        // Otherwise display a helpful replacement message.
        $model = $this->model ?? "Unknown Model";


        /*
        |----------------------------------------------------------------------
        | Prepare the price for display
        |----------------------------------------------------------------------
        |
        | This code uses the TERNARY OPERATOR.
        |
        | General form:
        |
        |     condition ? value_if_true : value_if_false;
        |
        | Here the condition is:
        |
        |     $this->price !== null
        |
        | If the price is NOT null:
        |
        |     number_format($this->price, 2)
        |
        | formats the number with two decimal places.
        |
        | Example:
        |
        |     1199.00
        |
        | becomes:
        |
        |     1,199.00
        |
        | The "$" is then added to the front.
        |
        | If the price IS null, the text
        | "Price not available" is used instead.
        |
        */
        $price = $this->price !== null
            ? "$" . number_format($this->price, 2)
            : "Price not available";


        /*
        |--------------------------------------------------------------------------
        | Build and return the final string
        |--------------------------------------------------------------------------
        |
        | PHP variable interpolation allows variables to be placed directly
        | inside a double-quoted string.
        |
        | For example:
        |
        |     "{$brand} {$model}"
        |
        | inserts the values stored in $brand and $model.
        |
        */
        return "{$brand} {$model} - {$price}";
    }
}


/*
|--------------------------------------------------------------------------
| Create Guitar Objects
|--------------------------------------------------------------------------
|
| Each "new Guitar(...)" creates a separate Guitar object.
|
| The associative array passed to the constructor contains the starting
| values for that particular object.
|
*/


// -------------------------------------------------------------------------
// Guitar #1
// -------------------------------------------------------------------------

// Create a new Guitar object and store it in $g1.
//
// PHP automatically sends this array to the __construct() method:
//
//     $args['brand'] = "Fender"
//     $args['model'] = "Jazzmaster"
//     $args['price'] = 1199.00
//
$g1 = new Guitar([
    "brand" => "Fender",
    "model" => "Jazzmaster",
    "price" => 1199.00
]);


// -------------------------------------------------------------------------
// Guitar #2
// -------------------------------------------------------------------------

// Create another Guitar object.
//
// Even though $g1 and $g2 were created from the same Guitar class,
// they are two separate objects with their own property values.
$g2 = new Guitar([
    "brand" => "Epiphone",
    "model" => "SG Special",
    "price" => 1199.00
]);


// -------------------------------------------------------------------------
// Guitar #3
// -------------------------------------------------------------------------

// Create a Guitar object using an empty array.
//
// Because the array contains no "brand", "model", or "price" keys,
// the constructor assigns null to all three properties.
//
// Therefore:
//
//     $g3->brand === null
//     $g3->model === null
//     $g3->price === null
//
$g3 = new Guitar([]);


/*
|--------------------------------------------------------------------------
| Display the Guitar Summaries
|--------------------------------------------------------------------------
|
| The -> operator is used to access an object's properties and methods.
|
| Example:
|
|     $g1->summary()
|
| means:
|
|     "Call the summary() method belonging to the object stored in $g1."
|
| summary() returns a string.
|
| We concatenate "<br>" so each result appears on a separate line
| when viewed in a web browser.
|
*/

echo $g1->summary() . "<br>";
echo $g2->summary() . "<br>";
echo $g3->summary() . "<br>";


/*
|--------------------------------------------------------------------------
| Expected Browser Output
|--------------------------------------------------------------------------
|
| Fender Jazzmaster - $1,199.00
| Epiphone SG Special - $1,199.00
| Unknown Brand Unknown Model - Price not available
|
*/
