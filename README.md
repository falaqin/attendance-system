# Installation
> [!NOTE]
> This project uses Node Hydrogen LTS and PHP 8.2, please install them accordingly.

## Backend setup
In order to use the API, there are some certain commands that you have to run before you have access to the backend of this project.

After running `composer install`, run these commands appropriately.

### Run database migrations
```bash
php artisan migrate
```

### Run admin generation
The username and password is optional. You will be prompted to enter username and password if you left those empty.
```bash
php artisan admin:generate {username} {password}
```

### Run setting script
You can also leave the `add_late_time_setting` empty. You will be prompted to enter a method name from [patch console](/api/app/Console/Commands/PatchScript.php).
```bash
php artisan patch add_late_time_setting
```

### Run the backend server locally
```
php artisan serve
```

## Front end setup
Please run the following commands appropriately.
```bash
npm install --save
npm run dev
```