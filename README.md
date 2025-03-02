# Project Management

The Project Management System is a comprehensive platform designed to streamline project and user management. It enables users to efficiently track and manage their timesheets in relation to assigned projects, ensuring accurate time allocation and reporting.

A key feature of the system is its dynamic attribute module, which allows administrators to define custom attributes that can be assigned to projects upon creation. Each project can have multiple attributes, enabling better categorization, tracking, and reporting.

The system also includes a secure authentication and authorization mechanism, ensuring that only authorized users can access the platform.


## Installation

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/usama740/projectManagement.git
    cd project_management
    ```

2.  **Install Composer dependencies:**

    ```bash
    composer install
    ```

3.  **Copy the `.env.example` file to `.env`:**

    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

## Configuration

1.  **Edit the `.env` file:**

    * Configure your database credentials (DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD).
    * Set your application URL (APP\_URL).
    * Configure other environment variables as needed (e.g., mail settings, API keys).

## Database Setup

1.  **Create a database for your application.**

2.  **Run database migrations:**

    ```bash
    php artisan migrate
    ```

3.  **(Optional) Seed the database with initial data:**

    ```bash
    php artisan db:seed
    ```

## Running the Application

1.  **Start the development server:**

    ```bash
    php artisan serve
    ```

2.  **Open your browser and navigate to `http://localhost:8000`.**
  
## Testing credentials

*  Email: admin@example.com
*  Password: password123
