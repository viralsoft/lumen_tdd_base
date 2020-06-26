1. Create new module
- `php artisan module:make <module-name>`
- (php artisan module:make Blog User Auth)

2. Access each modules and remove below files / folders
- `Providers/RouteServiceProvider.php`
- `Resources/assets`
- `Resources/views`
- Create folder `Repositories` in each Module
- Create folder `Repositories/Contracts` in each Module
- Create folder `Entities/Traits/Filterable` in each Module
- Create folder `Entities/Traits/Scope` in each Module
- Create folder `Entities/Traits/Relationship` in each Module
- Create folder `Entities/Traits/Attribute` in each Module
