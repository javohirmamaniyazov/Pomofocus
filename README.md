# Welcome to the Pomofocus creating by GHOST TEAM

## Task
Pomofocus is a productivity app designed to help you manage tasks efficiently using the Pomodoro Technique. The app features user authentication, Google login, task management, customizable timers, and theme options.

## Features

- **User Authentication**: Register and log in with email or Google.
- **Task Management**: Create, edit, delete tasks, change their finished and active status.
- **Pomodoro Timers**: Includes 'Pomodoro Time', 'Short Break', and 'Long Break' timers.
  - When the Pomodoro timer ends, the first task is marked as finished.
  - Timers can be customized.
- **Notifications**: Receive sound notifications when timers end.
  - Customize notification time and type (last minute or every minute).
- **Theme Customization**: Change the project theme with different colors.

## Tech Stack
- **Backend**: Laravel for the API
- **Frontend**: ReactJS with Vite.js

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/javohirmamaniyazov/Pomofocus.git
   ```
2. Navigate to the project directory:
   ```sh
   cd pomofocus
   ```
3. Install backend dependencies:
   ```sh
   composer install
   ```
4. Install frontend dependencies:
   ```sh
   npm install
   ```
5. Configure the environment variables:
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with your configuration.

6. Run the migrations:
   ```sh
   php artisan migrate
   ```

## Usage

1. Start the backend server:
   ```sh
   php artisan serve
   ```
2. Start the frontend development server:
   ```sh
   npm run dev
   ```
3. Access the application at `http://localhost:5173`.

## Core Team
- **TEAM Lead/Frontend Developer**: `Hasanboy Turdijonov`
- **Backend Developer**: `Mamaniyazov Javohir`
- **Backend Developer**: `Jeniz Bo'zdaxov`

***Extra Data***

### Mail Configuration
```
MAIL MAILER=smtp
MAIL HOST=smtp.gmail.com
MAIL PORT=587
MAIL USERNAME=javohirmamaniyazov@gmail.com
MAIL PASSWORD=xltmwffuhkmzkmbz
MAIL ENCRYPTION=tls
MAIL FROM_ADDRESS="javohirmamaniyazov@gmail.com"
MAIL FROM_NAME="${APP_NAME}"
```
### Google OAuth Configuration
```
google clinet id = 602333515570-1nh4lsvfeutuus5fn3c2s2j8aaum38h3
google client secret = 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
google callback = http://refotib6.beget.tech/api/auth/google/callback
```