// 1. Get user input
$username = $_POST['username'];
$password = $_POST['password'];

// 2. Query database for user
$result = pg_query_params($conn, "SELECT * FROM admins WHERE username = $1", [$username]);
if ($result && pg_num_rows($result) === 1) {
    $row = pg_fetch_assoc($result);

    // <<< ADD DEBUG LINE HERE
    var_dump($username, $password, $row['password'], password_verify($password, $row['password']));
    exit;

    if (password_verify($password, $row['password'])) {
        // success
    } else {
        // fail
    }
}
