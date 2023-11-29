Hello everyone::

//-----Run the following command in your project to get the latest version of the package:---//


                composer require yajra/laravel-datatables-oracle:"^10.3.1"


//------If you are using most of the DataTables plugins like Buttons & Html, you can alternatively use the all-in-one installer package.-----//

Laravel 9

                composer require yajra/laravel-datatables:"^9.0"

Laravel 10

                composer require yajra/laravel-datatables:^10.0

//--Configuration--//

This step is optional if you are using Laravel 5.5+

Open the file config/app.php and then add following service provider.

                'providers' => [
                    // ...
                    Yajra\DataTables\DataTablesServiceProvider::class,
                ],

After completing the step above, use the following command to publish configuration & assets:

                php artisan vendor:publish --Provider=Yajra\DataTables\DataTablesServiceProvider

                                (or)

                php artisan vendor:publish --tag=datatables



                        //---------Thankyou---------//