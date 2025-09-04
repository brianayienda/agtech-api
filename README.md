# Tech Stack Used Laravel and Vue.js

## Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or other supported database

## Backend: Laravel

1. **Install dependencies**
    ```bash
    composer install
    ```

2. **Copy `.env` and set up environment variables**
    ```bash
    cp .env.example .env
    # Edit .env with your database credentials
    ```

3. **Generate application key**
    ```bash
    php artisan key:generate
    ```

4. **Run migrations**
    ```bash
    php artisan migrate
    ```

5. **Start Laravel server**
    ```bash
    php artisan serve
    ```
    Access at `http://localhost:8000`

## Frontend: Vue.js

1. **Install dependencies**
    ```bash
    npm install
    ```

2. **Build assets**
    ```bash
    npm run dev
    ```
    For production:
    ```bash
    npm run build
    ```

## Notes
- Ensure both servers are running for full functionality.
- Update API endpoints in Vue.js to match Laravel backend if needed.
- For integrated projects, Laravel Mix may handle Vue.js compilation.
