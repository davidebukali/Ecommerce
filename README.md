

## Instacart Clone

This is an ecommerce clone of the popular shopping store. It's built with Laravel 12x and includes the following features.
- Product listing and details
- Add and remove products from cart 
- Checkout orders.
- View history of orders
- Authentication
- Redis queues to process order placed emails
- Real time notifications with pusher websockets for order status updates. Follow Laravel docs to setup.
- PHPUnit for feature tests


## Packages
- [Filament admin](https://filamentphp.com/) backend to create products with multiple images. Access from ```localhost:8000/admin
- [Livewire framework](https://livewire.laravel.com/) components to update cart item counts and order status notifications
- Laravel Horizon to monitor Redis queues.  Start with ```php artisan horizon 
- Laravel Fortify authentication with socialite (Google login)
- Laravel Sanctum APIs

## Backlog

- Payments API integration
- Product Categories
- Recommendations using AI
- Make delivery fee configurable
- Add maps for customer address
- Add email settings
- Improve UI/UX

## Contributing

Create a PR and lets create the best ecommerce store in Uganda :)


## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
