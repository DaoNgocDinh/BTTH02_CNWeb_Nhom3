<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../middleware/Auth_JWT.php';

class AdminController {

    private function checkAdmin()
    {
        $middleware = new Middleware();
        if (!$middleware->checkJWT()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        if (($_SESSION['user']['role'] ?? 0) != 2) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
    }

    public function profile()
    {
        // No profile view in this project — redirect to the admin dashboard.
        $this->checkAdmin();
        header('Location: ' . BASE_URL . '/admin/dashboard');
        exit;
    }

    // Admin dashboard
    public function dashboard()
    {
        $this->checkAdmin();

        // simple stats
        $db = Database::connect();
        $stats = [
            'total_users' => 0,
            'total_courses' => 0,
            'total_categories' => 0,
        ];

        try {
            $stats['total_users'] = (int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn();
        } catch (Exception $e) {}

        try {
            $stats['total_categories'] = (int)$db->query('SELECT COUNT(*) FROM categories')->fetchColumn();
        } catch (Exception $e) {}

        try {
            $stats['total_courses'] = (int)$db->query('SELECT COUNT(*) FROM courses')->fetchColumn();
        } catch (Exception $e) {}

        $title = 'Dashboard';
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function dashboard_1()
    {
        $title = 'Dashboard';
        require_once __DIR__ . '/../views/instructor/dashboard.php';
    }

    // Manage users
    public function manageUsers()
    {
        $this->checkAdmin();
        $db = Database::connect();
        try {
            $stmt = $db->query('SELECT id, username, email, fullname, role FROM users ORDER BY id DESC');
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $users = [];
        }

        $title = 'Manage Users';
        require_once __DIR__ . '/../views/admin/users/manage.php';
    }

    // List categories
    public function listCategories()
    {
        $this->checkAdmin();
        $db = Database::connect();
        try {
            $stmt = $db->query('SELECT id, name, description FROM categories ORDER BY id DESC');
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $categories = [];
        }

        $title = 'Manage Categories';
        require_once __DIR__ . '/../views/admin/categories/list.php';
    }

    // Show create form
    public function createCategory()
    {
        $this->checkAdmin();
        $title = 'Create Category';
        require_once __DIR__ . '/../views/admin/categories/create.php';
    }

    // Store category (POST)
    public function storeCategory()
    {
        $this->checkAdmin();
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (trim($name) === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Category name is required.'];
            header('Location: ' . BASE_URL . '/admin/categories/create');
            exit;
        }

        $db = Database::connect();
        try {
            $stmt = $db->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
            $ok = $stmt->execute([$name, $description]);
            if ($ok) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Category created successfully.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to create category.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ' . BASE_URL . '/admin/categories');
        exit;
    }

    // Edit category form
    public function editCategory($id = null)
    {
        $this->checkAdmin();
        if (!$id) {
            header('Location: ' . BASE_URL . '/admin/categories');
            exit;
        }

        $db = Database::connect();
        try {
            $stmt = $db->prepare('SELECT id, name, description FROM categories WHERE id = ?');
            $stmt->execute([$id]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $category = null;
        }

        $title = 'Edit Category';
        require_once __DIR__ . '/../views/admin/categories/edit.php';
    }

    // Update category (POST)
    public function updateCategory($id = null)
    {
        $this->checkAdmin();
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!$id || trim($name) === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid data.'];
            header('Location: ' . BASE_URL . '/admin/categories');
            exit;
        }

        $db = Database::connect();
        try {
            $stmt = $db->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
            $ok = $stmt->execute([$name, $description, $id]);
            if ($ok) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Category updated.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Update failed.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ' . BASE_URL . '/admin/categories');
        exit;
    }

    // Statistics
    public function statistics()
    {
        $this->checkAdmin();
        $db = Database::connect();
        $stats = [
            'total_users' => 0,
            'total_courses' => 0,
            'total_categories' => 0,
        ];

        try {
            $stats['total_users'] = (int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn();
        } catch (Exception $e) {}

        try {
            $stats['total_categories'] = (int)$db->query('SELECT COUNT(*) FROM categories')->fetchColumn();
        } catch (Exception $e) {}

        try {
            $stats['total_courses'] = (int)$db->query('SELECT COUNT(*) FROM courses')->fetchColumn();
        } catch (Exception $e) {}

        $title = 'Statistics';
        require_once __DIR__ . '/../views/admin/reports/statistics.php';
    }

    // Create user form
    public function createUser()
    {
        $this->checkAdmin();
        $title = 'Create User';
        require_once __DIR__ . '/../views/admin/users/create.php';
    }

    // Store user (POST)
    public function storeUser()
    {
        $this->checkAdmin();
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $fullname = $_POST['fullname'] ?? '';
        $role = $_POST['role'] ?? 1;

        if (trim($username) === '' || trim($email) === '' || trim($password) === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'All fields are required.'];
            header('Location: ' . BASE_URL . '/admin/users/create');
            exit;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        try {
            $ok = User::create($username, $email, $hashed, $fullname, $role);
            if ($ok) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'User created successfully.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to create user.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ' . BASE_URL . '/admin/users');
        exit;
    }

    // Edit user form
    public function editUser($id = null)
    {
        $this->checkAdmin();
        if (!$id) {
            header('Location: ' . BASE_URL . '/admin/users');
            exit;
        }

        $user = User::findById($id);
        if (!$user) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'User not found.'];
            header('Location: ' . BASE_URL . '/admin/users');
            exit;
        }

        $title = 'Edit User';
        require_once __DIR__ . '/../views/admin/users/edit.php';
    }

    // Update user (POST)
    public function updateUser($id = null)
    {
        $this->checkAdmin();
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $fullname = $_POST['fullname'] ?? '';
        $role = $_POST['role'] ?? 1;

        if (!$id || trim($username) === '' || trim($email) === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid data.'];
            header('Location: ' . BASE_URL . '/admin/users');
            exit;
        }

        $db = Database::connect();
        try {
            $stmt = $db->prepare('UPDATE users SET username = ?, email = ?, fullname = ?, role = ? WHERE id = ?');
            $ok = $stmt->execute([$username, $email, $fullname, $role, $id]);
            if ($ok) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'User updated.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Update failed.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ' . BASE_URL . '/admin/users');
        exit;
    }

    // Delete user
    public function deleteUser($id = null)
    {
        $this->checkAdmin();
        if (!$id) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid user.'];
            header('Location: ' . BASE_URL . '/admin/users');
            exit;
        }

        $db = Database::connect();
        try {
            $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
            $ok = $stmt->execute([$id]);
            if ($ok) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'User deleted.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Delete failed.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ' . BASE_URL . '/admin/users');
        exit;
    }
}
