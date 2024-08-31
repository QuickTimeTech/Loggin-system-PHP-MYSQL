# Loggin-system-PHP-MYSQL

## Summary: 

This PHP script manages user logins by connecting to a MySQL database, logging attempts, and limiting retries to prevent brute-force attacks. It verifies user credentials and IP addresses, sets session variables upon successful login, and redirects users. Failed attempts are logged and displayed with remaining retries.

## Description: 

This PHP script is designed to manage user login attempts securely. It begins by starting or resuming a session and then establishes a connection to a MySQL database using specified credentials. If the connection fails, the script terminates and displays an error message.

The script includes a function to log login attempts, recording details such as the username, IP address, status (success or failure), and timestamp in a CSV file. Another function checks the number of login attempts from a specific IP address within the last five minutes by reading this CSV file and counting the attempts.
When a POST request is made, the script retrieves the username and password from the request and the user’s IP address. It then checks the number of recent login attempts from that IP address. If there have been five or more attempts, it displays an error message and stops further processing.

For user authentication, the script prepares a SQL statement to fetch user details (password, email, account type, IP) from the database based on the provided username. If the username exists, it fetches the stored details and checks if the user’s IP address matches the stored IP address. If the IP addresses do not match, it logs the attempt and displays an error message. If the IP addresses match, it verifies the password. If the password is correct, it sets session variables (username, email, account type), logs the successful attempt, and redirects the user to another page. If the password is incorrect, it logs the attempt and displays an error message with the number of remaining attempts.
Finally, the script closes the prepared statement and the database connection. This code provides a secure login system with IP address verification and limits on login attempts to prevent brute-force attacks.

