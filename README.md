# cradle-mail
CSRF Handling for Cradle

## 1. Requirements

You should be using CradlePHP currently at `dev-master`. See
[https://cradlephp.github.io/](https://cradlephp.github.io/) for more information.

## 2. Install

```
composer require cblanquera/cradle-csrf
```

Then in `/bootstrap.php`, add

```
->register('cblanquera/cradle-csrf')
```

## 3. Recipes

Once the database is installed open up `/public/index.php` and add the following.

```
<?php

use Cradle\Framework\Flow;

return cradle()
    //add routes here
    ->get('/csrf/test', 'CSRF Page')
    ->post('/csrf/test', 'CSRF Process')

    //add flows here
    //renders a table display
    ->flow('CSRF Page',
        Flow::csrf()->load,
        Flow::csrf()->render,
        'TODO: form page'
    )
    ->flow('CSRF Process',
        Flow::csrf()->check,
        array(
            Flow::csrf()->yes,
            'TODO: process'
        ),
        array(
            Flow::csrf()->no,
            'TODO: deny'
        )
    );
```
