Add database trigger to laravel migrations
==========================================

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/NtimYeboah/laravel-database-trigger.svg?style=flat-square)](https://travis-ci.org/NtimYeboah/laravel-database-trigger)
[![StyleCI](https://github.styleci.io/repos/7548986/shield)](https://styleci.io/repos/7548986)

Laravel Database Trigger provides a way to add database trigger to laravel migrations just like you would with database table. 
A trigger is a named database object that is associated with a table, and that activates when a particular event occurs for the table. Read more about triggers [here](https://dev.mysql.com/doc/refman/8.0/en/triggers.html).


## Installation

Laravel Database Trigger requires at least [PHP](https://php.net) 7.2. This particular version supports laravel at least v6.0
The package currently supports MySQL only.

To get the latest version, simply require the package using [Composer](https://getcomposer.org):

```bash
$ composer require sweetmancc/mysql-trigger-for-laravel-migration
```

Once installed, if you are not using automatic package discovery, then you need to register the `Sweetmancc\DatabaseTrigger\TriggerServiceProvider` service provider in your `config/app.php`.


## Usage
Create a trigger migration file using the `make:trigger` artisan command. 
The command requires the name of the trigger, name of the event object table, action timing and the event that activates the trigger.

```bash
$ php artisan make:trigger after_users_posts_insert
```

### Event object table
The event object table is the name of the table the trigger is associated with.

### Action timing
The activation time for the trigger. Possible values are `after` and `before`. 

`after` - Process action after the change is made on the event object table. 

`before` - Process action prior to the change is made on the event object table.

### Event
The event to activate trigger. A trigger event can be `insert`, `update` and `delete`.

`insert` - Activate trigger when an insert operation is performed on the event object table.

`update` - Activate trigger when an update operation is performed on the event object table.

`delete` - Activate trigger when a delete operation is performed on the event object table.


The following trigger migration file will be generated for a trigger that uses `after_users_posts_insert` as a name, `user_posts` as event object table name, `after` as action timing and `insert` as event.

```php

use Illuminate\Database\Migrations\Migration;
use Sweetmancc\DatabaseTrigger\TriggerFacade as Schema;

class CreateAfterUsersUpdateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_users_update')
            ->on('user_posts')
            ->statement(function() {
                return '//You logic, Don't forget ";" ';
            })
            ->after()
            ->update();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users.after_users_update');
    }
}

```

Return the trigger statement from the closure of the `statement` method. 

The following is an example trigger migration to insert into the `users_audit` table after updating a user row.

```php

...

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_user_posts_insert')
            ->on('user_posts')
            ->statement(function() {
                return 'UPDATE user_profiles SET postCount = postCount + 1 WHERE id = NEW.user_id;';
            })
            ->after()
            ->update();
    }

...

```

### Update your database migration

```php
php artisan migrate
```

## Testing

Run the tests with:

```php
$ composer test
```

## Changelog

Please see [CHANGELOG](https://github.com/sweetmans/mysql-trigger-for-laravel-migration/blob/master/CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/sweetmans/mysql-trigger-for-laravel-migration/blob/master/CONTRIBUTING.md) for details.


## Security

If you discover a security vulnerability within this package, please send an e-mail to Andy Q at sweetmancc@gmail.com. All security vulnerabilities will be promptly addressed.


## License

Laravel Database Trigger is licensed under [The MIT License (MIT)](LICENSE).