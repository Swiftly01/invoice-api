
## Invoice API (Laravel) — Backend Engineer Task

## Quick setup
1. Clone repo.
2. Copy `.env.example` to `.env` and configure DB.
3. Run:

- **composer install
- **php artisan key:generate
- **php artisan migrate
- **php artisan test
- **php artisan serve

4. API base: `http://127.0.0.1:8000/api`

## Documentation
- `Postman collection` - https://documenter.getpostman.com/view/33328101/2sB3QCSDA2.

## Routes
- `GET /api/invoices` — list invoices (paginated). Query param: `per_page`.
- `POST /api/invoices` — create invoice.
- body (JSON):
 ```json
 {
   "customer_name": "John Doe",
   "customer_email": "john@example.com",
   "amount": 150.50,
   "due_date": "2025-10-01",
   "status": "issued"
 }
 ```
- `GET /api/invoices/{id}` — fetch single invoice.
- `PUT /api/invoices/{id}` — update invoice.
- `DELETE /api/invoices/{id}` — delete invoice.



