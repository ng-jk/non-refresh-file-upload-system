# non-refresh-file-upload-system

This project uses **Laravel**, **Sail**, **Redis**, **MySQL**, **Horizon**, **Reverb**, and the **Fetch API** to upload files **without refreshing the webpage**.  
The project runs on [Windows WSL](https://learn.microsoft.com/en-us/windows/wsl/install). I use Ubuntu.

> **Don't forget:** Run `sudo apt update` and `sudo apt upgrade` regularly. They are **two different commands** — please be alert.

[Oh My Zsh](https://ohmyz.sh/) is a useful terminal helper — install it if possible.

---

## Laravel v12.X

Laravel is installed using the [official documentation](https://laravel.com/docs/12.x/). It includes Composer, PHP, and the Laravel installer — no need to download them separately like other tutorials suggest.

---

### Sail

Laravel Sail is a lightweight CLI for Laravel’s default Docker setup.  
Install [Docker](https://www.docker.com/) separately, then install [Laravel Sail](https://laravel.com/docs/12.x/sail#main-content).  
Sail includes Docker images for Redis, MySQL, NPM, and Node.js.

> **So just follow Laravel's official documentation and you will get a well-configured setup with the correct versions of PHP, Composer, Laravel Installer, Redis, MySQL, NPM, and Node.js.**

---

### What's Included

- **PHP** – Included via the Laravel install command
- **Composer** – Included via the Laravel install command
- **Laravel Installer** – Included via the Laravel install command
- **NPM** – Included in Sail
- **Node.js** – Included in Sail
- **Redis** – Included in Sail
- **MySQL** – Included in Sail

---

### Horizon

Horizon is a UI and monitor for Redis queues.  
Install it via the [official Horizon documentation](https://laravel.com/docs/12.x/horizon#main-content).

---

### Reverb

Reverb is Laravel’s WebSocket server (used for broadcasting).  
Install and configure it using the [Broadcasting documentation](https://laravel.com/docs/12.x/broadcasting#main-content) and the [Reverb setup guide](https://laravel.com/docs/12.x/reverb).

---

### Fetch API

Use any easy-to-follow tutorials or blogs found online — they're often easier to understand than the [official Fetch API documentation](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API).

---

## Run the Server

> **Note:** i use `sail` instead of `vendor/bin/sail` for simplicity.

1. Everything required is already installed in this repository — just clone or download it  
   *(except Docker, WSL, and Oh My Zsh)*.
2. In the folder where the project is located, open **four terminal windows** and run this command in each:
   ```wal -d ubuntu```
3. Open Docker Desktop.
4. In the first terminal, run:
    ```sail up```
5. In the second terminal, run:
    ```
    sail npm run build
    sail npm run dev
    ```
6. In the third terminal, run:
    ```sail artisan horizon```
7. In the fourth terminal, run:
    ```sail artisan reverb:start```
8. Open your browser and go to: http://localhost

9. Open Horizon in a new tab: http://localhost/horizon
