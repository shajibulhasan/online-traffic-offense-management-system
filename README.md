# Online Offense Management System (Developer guide)

&nbsp;

## **1. Prerequisites**

1. **Laravel**: 11.0
2. **PHP** : PHP 8.2.12
3. **Composer** : version 2.8.5
4. **Node.js** and **npm** : v22.13.0
5. **Database** : MySQL (phpmyadmin)
6. **Authentication Setup** : Laravel UI v4.x

&nbsp;

## **2. Project Setup**

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/shajibulhasan/online-traffic-offense-management-system.git
    ```
    ```bash
    cd online-traffic-offense-management-system
    ```

2. **Install Dependencies:**


```bash
    composer install
```
```bash
    npm install
```
```bash
    npm run dev
```

3. **Environment Configuration:**

    - Using Command Prompt (CMD):

    ```cmd
    copy .env.example .env
    ```

    - Using Git Bash:

    ```bash
    cp .env.example .env
    ```

4. **Generate Application Key:**

    ```bash
     php artisan key:generate
    ```

5. **Run Database Migrations:**

    ```bash
     php artisan migrate
    ```

6. **Start the Development Server:**

    ```bash
     php artisan serve
    ```

&nbsp;

## **3. Git Workflow and Collaboration Rules**

### 1. Branching Strategy

-   The `main` branch is for production-ready code.
-   **Make new branch** branch is for staging new features and testing. Name brach according to the roles.

### 2. Commit Messages

**Contact on chat group before commiting**

-   Follow this format:
    `[type]: <short description>`  
    Examples:
    -   `added : new file / folder added, created`
    -   `removed : removed file / deleted file that has been pushed into repo`
    -   `modified : existing file / folder modification`
    -   `fix: resolve fund calculation bug`
    -   `docs: update README with setup steps`

### 3. Pull Request Guidelines

-   Submit a PR to merge your branch into `main`
-   Add a clear description of your changes.

### 4. Merging to `main`

-   **First show code for code review untill review is done DONT merge into the main**
-   Only merge after check full code.

&nbsp;

## **5. Code Writing Rules**

To ensure code consistency, readability, and maintainability, all developers must adhere to the following coding standards:

### 1. **Spacing**

-   Before every section of code add new lines and a comment "Section_name START"
-   After every section of code add new lines and a comment "Section_name END"

### 2. **Controller Naming**

-   Use singular names for controllers, e.g., `UserController`, `FundController`.

### 3. **Naming Conventions**

-   **Variables:** Use descriptive names in `camelCase` (e.g., `$userEmail`, `$totalFunds`).
-   **Methods:** Name methods based on their functionality, using `camelCase` (e.g., `getUserDetails`, `calculateFundBalance`).
-   **Classes:** Use `PascalCase` for classes (e.g., `UserService`, `FundController`).

### 4. **Database**

-   Table names must be plural (`users`, `funds`, `transactions`).
-   Columns must use `snake_case` (e.g., `user_id`, `total_amount`).

