# Oneytrust_test
Test calculate distance 

### Requirement server environement , composer ####

To run this application :

1- set the .env (28th line with database name, port, passWord )

2-run consecutively(After getting to the project root)
 php bin/console doctrine:database:create
 php bin/console make:migration
 php bin/console doctrine:migrations:migrate

 Go to :
 .../Oneytrust_test/public/index.php/calculate/distance


