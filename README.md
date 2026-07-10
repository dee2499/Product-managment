# Ekahal Product Catalog

This is a small product-management application built as part of a PHP developer assignment. It provides an authenticated product catalogue with separate admin and standard-user access.

Admins can add, edit, and remove products. Standard users can search the catalogue and view product details, but cannot change anything.

## What is included

- Laravel 13, PHP 8.3 and MySQL 8
- Login, registration, password reset and profile management via Laravel Breeze
- Role-based access: `admin` and `standard`
- Product CRUD with title, rich-text description, price and availability date
- Server-side validation and authorization
- Server-side DataTables search, sorting and pagination
- Docker Compose setup and a deployment script
- Feature tests for authentication, roles, validation and product CRUD

## Running the project

The simplest way to run the project is with Docker.

```bash
docker compose up --build -d
./deploy.sh
```

The application will then be available at [http://localhost:8000](http://localhost:8000).

`deploy.sh` creates `.env` from `.env.example` when needed, installs Composer and npm dependencies, generates the application key, runs migrations and seeders, builds assets, and caches the Laravel configuration.

### Demo accounts

| Account | Email | Password |
| --- | --- | --- |
| Admin | `admin@example.com` | `password` |
| Standard user | `user@example.com` | `password` |

The database seeder also adds a small set of sample products so the catalogue is usable straight away.

## Tests

Run the test suite with:

```bash
php artisan test
```

The tests cover login-related flows, product validation, the CRUD workflow, catalogue search, and the difference between admin and standard-user permissions.

## A note on the structure

I kept the controllers focused on HTTP concerns: accepting requests, choosing a response, and delegating work. Product-specific work lives below that layer:

```text
Request
  -> ProductController
  -> Store/Update Product Request (validation and authorization)
  -> ProductService
  -> ProductRepository
  -> Product model / database
```

The repository is accessed through `ProductRepositoryInterface`, which keeps the service independent of the storage implementation. For a project of this size, Eloquent directly in a controller would also work, but this separation makes the business flow easier to test and extend without making the controller grow.

The HTML description is passed through `HtmlSanitizer` before it is stored. This lets the detail page retain basic rich-text formatting while removing scripts, event-handler attributes, and unsafe URL protocols.

## Access control and security

- Laravel's authentication middleware protects the catalogue.
- Product creation, editing and deletion are admin-only. This is enforced in both route middleware and `ProductPolicy`; hiding buttons in the UI is not relied on for security.
- Validation is handled by dedicated Form Request classes on the server. Prices, dates, required fields, and maximum title length are checked before data reaches the service layer.
- Database access uses Eloquent/query-builder parameter binding rather than concatenated SQL.
- Blade escapes ordinary output by default. Rich-text product descriptions are sanitized before being stored.
- Laravel's CSRF middleware protects form submissions.

## Search and catalogue behaviour

The catalogue uses DataTables in server-side mode, so a browser only receives the page it is currently showing. The search box checks title and description, and also supports useful date and price searches. For example, `July`, `07`, `22`, `2026`, and `99.95` can match the available month, day, year, or exact price respectively.

The `title`, `price`, and `date_available` columns are indexed because they are common sort/filter fields.

## Things I had to account for

- Laravel routes are ordered so static paths such as `/products/create` are registered before `/products/{product}`. Otherwise Laravel would try to resolve `create` as a product.
- The tests call `withoutVite()` so they do not depend on a prebuilt Vite manifest.
- TinyMCE replaces the description textarea, so validation styling is applied to the editor frame as well as the underlying field.
- The DataTables response formats product values on the server and escapes user-provided title/description text before returning table markup.

## If this grew beyond an assignment

For a larger application, I would make a few changes first:

- replace simple `LIKE` search with full-text search or a search service once product volume justifies it;
- add caching for frequently viewed catalogue pages;
- move long-running work, such as imports and image processing, onto queues;
- store uploads in object storage rather than on the application server;
- add audit logs and more granular permissions; and
- introduce tenant scoping if the product catalogue was shared by multiple organisations.

## Project layout

```text
app/
├── Http/Controllers/       Request handling
├── Http/Requests/          Product validation rules
├── Models/                 Eloquent models
├── Policies/               Product permissions
├── Repositories/           Product data access and search queries
└── Services/               Product workflow and HTML sanitization
database/
├── migrations/             Schema definitions
└── seeders/                Demo users and products
resources/views/            Blade templates
tests/                      Feature and unit tests
```
