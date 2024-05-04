<?php


$host = 'sql.endora.cz';
$db = 'crudaplikacia';    
$user = 'adamkurek';
$pass = 'adam123456S';
$port = 3313;

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




// Retrieve action type from POST request
$action = isset($_POST['action']) ? $_POST['action'] : '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Retrieve form data
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
$salary = isset($_POST['salary']) ? floatval($_POST['salary']) : 0.0;
$registration_date = isset($_POST['registration_date']) ? $_POST['registration_date'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
$notes = isset($_POST['notes']) ? $_POST['notes'] : '';

// Handle form submission for CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add a new record
    if ($action === 'Add') {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO records (name, email, birthdate, salary, registration_date, address, phone_number, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdsiss", $name, $email, $birthdate, $salary, $registration_date, $address, $phone_number, $notes);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    // Update an existing record
    elseif ($action === 'Update' && $id > 0) {
        $stmt = $conn->prepare("UPDATE records SET name = ?, email = ?, birthdate = ?, salary = ?, registration_date = ?, address = ?, phone_number = ?, notes = ? WHERE id = ?");
        $stmt->bind_param("sssdsissi", $name, $email, $birthdate, $salary, $registration_date, $address, $phone_number, $notes, $id);
        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    // Delete a record
    elseif ($action === 'Delete' && $id > 0) {
        $stmt = $conn->prepare("DELETE FROM records WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (isset($_GET['reset'])) {
    $search = '';
}
$query = "SELECT * FROM records";
if (!empty($search)) {
    $search = "%$search%";
    $query .= " WHERE name LIKE ? OR email LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $search, $search);
} else {
    $stmt = $conn->prepare($query);
}
$stmt->execute();
$result = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Operations</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold text-center text-gray-700 my-6">CRUD App</h1>
     <div class="flex justify-center mb-6">
            <form method="get" action="" class="flex">
                <input type="text" name="search" value="<?php echo htmlspecialchars(str_replace('%', '', $_SESSION['last_search'])); ?>" placeholder="Search by name or email" class="border border-gray-300 p-2 rounded-l">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-r">Search</button>
                <a href="?reset" class="text-blue-500 hover:underline ml-4">Reset</a>
            </form>
        </div>
        <table class="min-w-full leading-normal shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Birthdate</th>
                    <th class="px-6 py-3 text-left">Salary</th>
                    <th class="px-6 py-3 text-left">Registration Date</th>
                    <th class="px-6 py-3 text-left">Address(Number)</th>
                    <th class="px-6 py-3 text-left">Phone Number</th>
                    <th class="px-6 py-3 text-left">Notes</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="px-6 py-4 text-left"><?php echo $row['id']; ?></td>
                    <td class="px-6 py-4 text-left"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td class="px-6 py-4 text-left"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td class="px-6 py-4 text-left"><?php echo $row['birthdate']; ?></td>
                    <td class="px-6 py-4 text-left"><?php echo $row['salary']; ?></td>
                    <td class="px-6 py-4 text-left"><?php echo $row['registration_date']; ?></td>
                    <td class="px-6 py-4 text-left"><?php echo htmlspecialchars($row['address']); ?></td>
                    <td class="px-6 py-4 text-left"><?php echo htmlspecialchars($row['phone_number']); ?></td>
                    <td class="px-6 py-4 text-left"><?php echo htmlspecialchars($row['notes']); ?></td>
                    <td class="px-6 py-4 text-left">
                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                            <input type="hidden" name="birthdate" value="<?php echo $row['birthdate']; ?>">
                            <input type="hidden" name="salary" value="<?php echo $row['salary']; ?>">
                            <input type="hidden" name="registration_date" value="<?php echo $row['registration_date']; ?>">
                            <input type="hidden" name="address" value="<?php echo htmlspecialchars($row['address']); ?>">
                            <input type="hidden" name="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>">
                            <input type="hidden" name="notes" value="<?php echo htmlspecialchars($row['notes']); ?>">
                            <input type="submit" name="action" value="Edit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                            <input type="submit" name="action" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <form method="post" action="" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Birthdate:</label>
                <input type="date" name="birthdate" value="<?php echo $birthdate; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Salary:</label>
                <input type="number" name="salary" value="<?php echo $salary; ?>" placeholder="Salary" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Registration Date:</label>
                <input type="date" name="registration_date" value="<?php echo $registration_date; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Address(Number)</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" placeholder="Address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" placeholder="Phone Number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Notes:</label>
                <textarea name="notes" placeholder="Notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"><?php echo htmlspecialchars($notes); ?></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" name="action" value="<?php echo $id > 0 ? 'Update' : 'Add'; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <?php echo $id > 0 ? 'Update' : 'Add'; ?>
                </button>
                <a href="?reset" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>


