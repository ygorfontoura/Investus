# Php interactions with mysql database and fetch from api

## Installation
    ## Default
    - Copy Investus folder to your root server. eg:(c:/xampp/htcdos)
    ## Custom
    - Change $url_parts values at index.php to match your current url parts
        eg: http://SERVER_URL/Investus/{$controller}/{$action}/{$detail}
        => run instructions.php for detailed information

## Requirements
    - PHP >=  7.4.1
    - PHPMailer
    - Make sure the user Apache runs as has full write access to the folder you're trying to move the files to ({ROOT}/public/users_avatar)*
    * Without write access user won't be able to update personal settings nor update a profile pic.

## Usage
    - Every url request is handled by its controller, and then calls a model.
    eg: http://SERVER_URL/Investus/{$controller}/{$action}/{$detail}
        controller filters the avaible actions(model) and if detail is set, uses it.
        ..Investus/auth/login -> will load the auth controller, search for an avaible action and execute it, in this scenario it will load the Users model and execute the User::login(); // which set $_SESSION variables and return $user.

## DB update
    - All transactions are automatically converted from user currency to EUR before inserted to database.
    - All dates are saved as timestamp.
    - Stocks fetched by API Request are saved as JSON.
    ## DUMMY defaults
    - Passowrds:
        12345678
    - Forgoot Keys: 
        {ROOT}/auth/forgot?forgot_key=cb4d553b57d30027ce3465bc67c8052f7f908e7eaa60821647761bd0909657a5

## Debugs
    - To debug a function the main controller must be used to show results.
    Note -> project has been divided in 2 segments: Main and Children controller
         -> main controllers are those that follows directly from ROOT. (Dashboard, Home, Auth, Stocks, Ajax)
         -> children are all the controllers inside the Dashboard main controller.
    In order to debbug a children function, a debug command (echo, var_dump, print_r) has to be called in its parent.

## Contributing
    - Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.