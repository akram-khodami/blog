# Akram Khodami's Personal Blog

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## 📝 About The Project

This project is a personal blog built with the Laravel framework. The goal is to create a complete platform for content management and sharing articles.

## ✨ Features

- **Authentication System**
  - User registration and login
  - Profile management
  - Password recovery system

- **Content Management**
  - Create, edit, and delete posts
  - Category management
  - Tagging system
  - Multimedia content support

- **Comment System**
  - Comment functionality for posts
  - Comment management
  - Reply to comments

- **Search and Filter**
  - Advanced content search(soon)
  - Filter by categories and tags(soon)

- **User Interface**
  - Responsive design
  - user-friendly interface
  

## 🚀 Prerequisites

- PHP >= 8.0.2
- Composer

## 📦 Installation and Setup

1. **Clone the repository**
```bash
git clone https://github.com/akram-khodami/blog.git
cd blog
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**
- Edit the `.env` file and enter your database credentials
```bash
php artisan migrate
php artisan db:seed
```

5. **Run the project**
```bash
php artisan serve
npm run dev
```

## 🛠️ Technologies Used

- Laravel 9.x
- MySQL
- Factory, Seeder, Eloquent, Policy, Gate, Trait, service


## 📄 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE.md) file for more details.

## 👥 Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

## 📞 Contact

- Email: akram.khodami@gmail.com
- Website: akramkhodami.ir
- LinkedIn: https://www.linkedin.com/in/akram-khodami-768465165

