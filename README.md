1. copy "paystar_test" folder to the packages folder in root directory of project.
2. add "\Mkhodroo\PaystarTest\PaystarServiceProvider::class" to providers in config/app.php
3. add ""Mkhodroo\\PaystarTest\\": "packages/paystar_test/src/"" to autoload->psr-4 on main composer.json in root directory.

4.run "composer dumpautoload" command in terminal.
5. run "php artisan vendor:publish --tag=paystar_test" command in terminal 
6. run "php artisan migrate" command in terminal.



#HOW TO USE#

route: /paystar/chcekout is for checkout form 