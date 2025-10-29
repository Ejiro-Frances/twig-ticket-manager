# Ticket Management Web App

A full-featured **Ticket Management Web Application** with CRUD (Create, Read, Update, Delete) functionalities, built in **React**, **Vue**, and **Twig/PHP**. This app allows users to create, view, edit, and manage support tickets efficiently.

---

## Live Demo

- React [view here](https://ticket-zen.vercel.app/)

- Vue [view here](https://vue-ticket-management-app-phi.vercel.app/)

- Twig/PHP [view here](https://twig-ticket-manager.onrender.com/)

---

## Features

- **User Authentication**

  - Sign up, login, and logout
  - Session-based authentication (Twig/PHP) or in-memory token storage (React/Vue)

- **Ticket Management**

  - Create new tickets with title, description, status, and priority
  - Edit existing tickets
  - Delete tickets with confirmation
  - Statuses: `OPEN`, `IN_PROGRESS`, `CLOSED`
  - Priorities: `LOW`, `MEDIUM`, `HIGH`

- **Dashboard**

  - Overview of total tickets, open tickets, in-progress tickets, and closed tickets

- **Responsive Design**

  - Mobile-first UI using Tailwind CSS
  - Accessible forms and buttons

- **Local Data Storage**

  - React/Vue: LocalStorage for ticket persistence
  - Twig/PHP: JSON files for persistent storage

---

## Tech Stack

- **Frontend**

  - React 18 or Vue 3 with Composition API
  - Tailwind CSS for styling
  - Alpine.js for interactivity (Twig version)

- **Backend (for Twig/PHP version)**

  - PHP 8+
  - Twig templating engine
  - Session-based authentication

- **Data**

  - JSON-based storage (Twig/PHP)
  - LocalStorage (React/Vue)

- **Build & Tooling**

  - Node.js 18+ (React/Vue)
  - Composer (Twig/PHP)
  - Git for version control

---

## Installation

### React Version

1. Clone the repo:

```bash
git clone https://github.com/Ejiro-Frances/ticket-management-app.git
cd ticket-management-app
```

2. Install dependencies:

```bash
npm install
```

3. Run the development server:

```bash
npm run dev
```

4. Open in browser:

```
http://localhost:3000
```

---

### Vue Version

1. Clone the repo:

```bash
git clone https://github.com/Ejiro-Frances/vue-ticket-management-app.git
cd vue-ticket-management-app
```

2. Install dependencies:

```bash
npm install
```

3. Run the development server:

```bash
npm run dev
```

4. Open in browser:

```
http://localhost:5173
```

---

### Twig/PHP Version

1. Clone the repo:

```bash
git clone https://github.com/Ejiro-Frances/twig-ticket-manager.git
cd twig-ticket-manager
```

2. Install PHP dependencies via Composer - ensure you have vue and composer installed locaaly:

```bash
composer install
```

3. Run a local PHP server:

```bash
php -S localhost:8000
```

4. Open in browser:

```
http://localhost:8000
```

5. JSON files for ticket and user storage are located in:

```
data/tickets.json
data/users.json
```

> Make sure the `data` folder is writable by PHP.

---

## Usage

1. **Register / Login**
2. **Create Ticket**

   - Fill in title, description, status, and priority

3. **Edit Ticket**

   - Click "Edit" button on a ticket card

4. **Delete Ticket**

   - Click "Delete" button and confirm

5. **Dashboard**

   - Monitor ticket counts by status

---

## Contributing

1. Fork the repository

2. Create a feature branch:

```bash
git checkout -b feature/your-feature
```

3. Commit your changes:

```bash
git commit -m "Add feature"
```

4. Push to your branch:

```bash
git push origin feature/your-feature
```

5. Open a Pull Request

---

## Notes

- **LocalStorage (React/Vue)**: All tickets are stored in the browser. Clearing browser data will remove tickets.
- **PHP/Twig Version**: JSON files store tickets/users. Back up your data before clearing files.
- **Styling**: Tailwind CSS is used across all frameworks for consistency.
- **Authentication**: For demonstration only. Do not store passwords in plain text in production.

---

## License

MIT License © 2025
