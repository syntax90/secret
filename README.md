## Technologies Used
- Laravel Lumen (To build HTTP API)
- GitHub (GitHub Actions for CI/CD)
- Heroku (Hosting & Webhook to deploy to hosting server if no errors)

## Files & Folders of Interest
- app\DataObject.php
- app\DataObjectHistory.php
- app\Http\Controllers\DataObjectController.php
- routes\web.php
- tests\DataObjectTest.php
- database\migrations
- .github/workflows/laravel.yml (CI/CD. Includes PHPUnit Tests)

## Demo
Access URL https://protected-shore-03084.herokuapp.com/

To manually run PHPUnit tests, run command `vendor/bin/phpunit`
