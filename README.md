# The solution

To deploy the project please 

configure your database in parameters.yml

and run:

>composer update

>php bin/console doctrine:database:create

>php bin/console doctrine:migrations:migrate

For run functional tests run:

>php phpunit