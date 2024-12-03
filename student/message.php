<?php
session_start();
require("config.php");

// Check if the student is logged in
if (!isset($_SESSION['sid'])) {
    header("location:index.php");
    exit;
}

// Function to get student's first and last name by sid
function getStudentName($con, $sid) {
    $query = "SELECT firstname, lastname FROM student WHERE sid = '$sid'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['firstname'] . ' ' . $row['lastname'];
    }
    return 'N/A';
}

// Fetch the student's details
$query = "SELECT firstname, lastname FROM student WHERE sid = '{$_SESSION['sid']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $studentName = $row['firstname'] . ' ' . $row['lastname'];
} else {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching student details');
}
// Fetch all unread messages for the student with sender's name
$unreadMessagesQuery = "SELECT m.*, CONCAT(l.firstname, ' ', l.lastname) as sender_name 
                        FROM messages m
                        JOIN lecturer l ON m.sender_id = l.lid
                        WHERE m.recipient_id = '{$_SESSION['sid']}' AND m.is_read = 0";

$unreadMessagesResult = mysqli_query($con, $unreadMessagesQuery);

if (!$unreadMessagesResult) {
    exit('Error fetching unread messages');
}

// Fetch all read messages for the student with sender's name
$readMessagesQuery = "SELECT m.*, CONCAT(l.firstname, ' ', l.lastname) as sender_name 
                      FROM messages m
                      JOIN lecturer l ON m.sender_id = l.lid
                      WHERE m.recipient_id = '{$_SESSION['sid']}' AND m.is_read = 1";

$readMessagesResult = mysqli_query($con, $readMessagesQuery);

if (!$readMessagesResult) {
    exit('Error fetching read messages');
}

// Handle composing and sending a new message
if (isset($_POST['recipient_id']) && isset($_POST['message'])) {
    $recipientId = mysqli_real_escape_string($con, $_POST['recipient_id']);
    $messageContent = mysqli_real_escape_string($con, $_POST['message']);

    // Insert the new message into the database
    $insertQuery = "INSERT INTO messages (sender_id, recipient_id, message) VALUES ('{$_SESSION['sid']}', '$recipientId', '$messageContent')";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        // Message sent successfully, redirect to the messages page
        header("Location: message.php");
        exit;
    } else {
        // Handle the case when the message insertion fails
        exit('Error sending the message');
    }
}

// Fetch all sent messages for the student
$sentMessagesQuery = "SELECT * FROM messages WHERE sender_id = '{$_SESSION['sid']}'";
$sentMessagesResult = mysqli_query($con, $sentMessagesQuery);

if (!$sentMessagesResult) {
    // Handle the case when the query doesn't return any rows or an error occurred
    exit('Error fetching sent messages');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, sid-scalable=0">
    <title>Student - Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
   
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo.jpg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php include("header.php"); ?>
    <div class="container my-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                
              <!-- Compose Message -->
<div class="card mb-3">
    <div class="card-header">
        Compose Message
    </div>
    <div class="card-body">
        <form action="" method="POST">
        <div class="mb-3">
    <label for="recipientId" class="form-label">Recipient ID:</label>
    <input type="text" class="form-control" id="recipientId" name="recipient_id" required>
</div>

            
            <div class="mb-3">
                <label for="messageContent" class="form-label">Message:</label>
                <textarea class="form-control" id="messageContent" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        Unread Messages
    </div>
    <div class="card-body">
        <?php if (mysqli_num_rows($unreadMessagesResult) > 0) { ?>
            <ul class="list-group">
                <?php while ($unreadMessageRow = mysqli_fetch_assoc($unreadMessagesResult)) { ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <!-- Make the name and subject clickable -->
                            <h5><?php echo 'Message From ' . $unreadMessageRow['sender_name']; ?></h5>
                            <p><?php echo $unreadMessageRow['subject']; ?></p>
                            <p><?php echo $unreadMessageRow['message']; ?></p>
                            
                            <p class="message-details" data-message-id="<?php echo $unreadMessageRow['message_id']; ?>"><?php echo $unreadMessageRow['subject']; ?></p>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-primary mark-read" data-message-id="<?php echo $unreadMessageRow['message_id']; ?>">Mark as Read</button>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No unread messages.</p>
        <?php } ?>
    </div>
</div>

<!-- Read Messages -->
<div class="card mb-3">
    <div class="card-header">
        Read Messages
    </div>
    <div class="card-body">
        <?php if (mysqli_num_rows($readMessagesResult) > 0) { ?>
            <ul class="list-group">
                <?php while ($readMessageRow = mysqli_fetch_assoc($readMessagesResult)) { ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                        <h5><?php echo 'Message From ' . $readMessageRow['sender_name']; ?></h5>

                            <p><?php echo $readMessageRow['subject']; ?></p>
                            <p><?php echo $readMessageRow['message']; ?></p>
                        </div>
                        <div>
                            <?php if ($readMessageRow['is_read'] == 1) { ?>
                                <button class="btn btn-sm btn-secondary mark-unread" data-message-id="<?php echo $readMessageRow['message_id']; ?>">Mark as Unread</button>
                            <?php } else { ?>
                                <button class="btn btn-sm btn-primary mark-read" data-message-id="<?php echo $readMessageRow['message_id']; ?>">Mark as Read</button>
                            <?php } ?>
                            <button class="btn btn-sm btn-danger delete-message" data-message-id="<?php echo $readMessageRow['message_id']; ?>">Delete</button>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No read messages.</p>
        <?php } ?>
    </div>
</div>
<!-- Sent Messages -->
<div class="card mb-3">
    <div class="card-header">
        Sent Messages
    </div>
    <div class="card-body">
        <?php if (mysqli_num_rows($sentMessagesResult) > 0) { ?>
            <ul class="list-group">
                <?php while ($sentMessageRow = mysqli_fetch_assoc($sentMessagesResult)) { ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <h5>Recipient ID:  <?php echo $sentMessageRow['recipient_id']; ?></h5>
                            
                            <p><h5>Message:</h5>  <?php echo $sentMessageRow['message']; ?></p>
                        </div>
                        <div>
                            <!-- No need for Mark as Read/Unread buttons for sent messages -->
                            <button class="btn btn-sm btn-danger delete-message" data-message-id="<?php echo $sentMessageRow['message_id']; ?>">Delete</button>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No sent messages.</p>
        <?php } ?>
    </div>
</div>

            </div>
        </div>
    </div>
<!-- Full Message Modal -->
<div class="modal fade" id="fullMessageModal" tabindex="-1" aria-labelledby="fullMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullMessageModalLabel">Full Message Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="senderDetails"></div>
                <div id="messageDetails"></div>
            </div>
            <div class="modal-footer">
                <!-- Add the "Mark as Read" button inside the modal footer -->
                <button type="button" class="btn btn-sm btn-primary mark-read-modal" data-message-id="">Mark as Read</button>
                <!-- Add a close button to dismiss the modal -->
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Message Deletion Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this message?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ... (Previous JavaScript code) ...

    // Function to display the full message when name or subject is clicked
    const messageDetailsElements = document.querySelectorAll('.message-details');

    messageDetailsElements.forEach(element => {
        element.addEventListener('click', function() {
            const messageId = this.dataset.messageId;

            // Perform AJAX request to fetch the full message and sender details
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);

                        // Display the full message and sender details in the modal
                        document.getElementById('messageDetails').textContent = response.message;
                        document.getElementById('senderDetails').innerHTML = `
                            <p><strong>Sender ID:</strong> ${response.senderId}</p>
                            <p><strong>Sender Name:</strong> ${response.senderName}</p>
                        `;

                        // Set the data-message-id attribute for the "Mark as Read" button
                        const markReadModalButton = document.querySelector('.mark-read-modal');
                        markReadModalButton.dataset.messageId = messageId;

                        // Show the modal
                        const fullMessageModal = new bootstrap.Modal(document.getElementById('fullMessageModal'));
                        fullMessageModal.show();
                    } else {
                        console.error('Error fetching the full message.');
                    }
                }
            };

            xhr.open('POST', 'fetch_full_message.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('message_id=' + messageId);
        });
    });

    // ... (Remaining JavaScript code) ...

    // Function to handle the "Mark as Read" button click inside the modal
    const markReadModalButton = document.querySelector('.mark-read-modal');
    markReadModalButton.addEventListener('click', function() {
        const messageId = this.dataset.messageId;

        // Perform AJAX request to mark the message as read
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Reload the page to update the message lists
                    location.reload();
                } else {
                    console.error('Error marking the message as read.');
                }
            }
        };

        xhr.open('POST', 'mark_message_as_read.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('message_id=' + messageId);
    });
});
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... (Previous JavaScript code) ...

        const markReadButtons = document.querySelectorAll('.mark-read');
    const markUnreadButtons = document.querySelectorAll('.mark-unread');

    markReadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const messageId = this.dataset.messageId;

            // Perform AJAX request to mark the message as read
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Remove the message from the Unread section and move it to the Read section
                        location.reload();
                        this.closest('.list-group-item').remove();
                        const readMessagesCard = document.querySelector('.card-body:contains("Read Messages")');
                        if (readMessagesCard) {
                            const messageElement = document.createElement('li');
                            messageElement.classList.add('list-group-item');
                            messageElement.innerHTML = xhr.responseText;
                            readMessagesCard.querySelector('.list-group').appendChild(messageElement);
                            // Reload the page to update the message lists
                            window.location.reload();
                        }
                    } else {
                        console.error('Error marking the message as read.');
                    }
                }
            };

            xhr.open('POST', 'mark_message_as_read.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('message_id=' + messageId);
        });
    });

    markUnreadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const messageId = this.dataset.messageId;

            // Perform AJAX request to mark the message as unread
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Remove the message from the Read section and move it to the Unread section
                        location.reload();
                        this.closest('.list-group-item').remove();
                        const unreadMessagesCard = document.querySelector('.card-body:contains("Unread Messages")');
                        if (unreadMessagesCard) {
                            const messageElement = document.createElement('li');
                            messageElement.classList.add('list-group-item');
                            messageElement.innerHTML = xhr.responseText;
                            unreadMessagesCard.querySelector('.list-group').appendChild(messageElement);
                            // Reload the page to update the message lists
                            window.location.reload();
                        }
                    } else {
                        console.error('Error marking the message as unread.');
                    }
                }
            };

            xhr.open('POST', 'mark_message_as_unread.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('message_id=' + messageId);
        });
    });
        const deleteMessageButtons = document.querySelectorAll('.delete-message');

    deleteMessageButtons.forEach(button => {
        button.addEventListener('click', function() {
            const messageId = this.dataset.messageId;

            // Show the confirmation modal
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();

            // Handle delete confirmation
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            confirmDeleteBtn.addEventListener('click', function() {
                // Perform AJAX request to delete the message
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Remove the message from the Read section
                            button.closest('.list-group-item').remove();
                            // Close the confirmation modal
                            deleteConfirmationModal.hide();
                        } else {
                            console.error('Error deleting the message.');
                        }
                    }
                };

                xhr.open('POST', 'delete_message.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('message_id=' + messageId);
            });
        });
    });

        // Function to attach event listeners to the buttons
        function attachEventListeners() {
            markReadButtons = document.querySelectorAll('.mark-read');
            markUnreadButtons = document.querySelectorAll('.mark-unread');
            deleteMessageButtons = document.querySelectorAll('.delete-message');

            // ... (Previous event listener code) ...

            // Attach event listeners to the newly added buttons
            markReadButtons.forEach(button => {
                button.addEventListener('click', function() {
                    window.location.reload();
                    // ... (Previous mark-read event listener code) ...
                });
            });

            markUnreadButtons.forEach(button => {
                button.addEventListener('click', function() {
                    window.location.reload();
                    // ... (Previous mark-unread event listener code) ...
                });
            });

            deleteMessageButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // ... (Previous delete-message event listener code) ...
                });
            });
        }

        // Attach event listeners to the buttons on initial page load
        attachEventListeners();

        // ... (Remaining JavaScript code) ...
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ... (Previous JavaScript code) ...

    // Function to display the full message when name or subject is clicked
    const messageDetailsElements = document.querySelectorAll('.message-details');

    messageDetailsElements.forEach(element => {
        element.addEventListener('click', function() {
            const messageId = this.dataset.messageId;
            
            // Perform AJAX request to fetch the full message
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Display the full message in an alert or modal
                        alert(xhr.responseText); // You can use a modal instead of an alert if you prefer.
                    } else {
                        console.error('Error fetching the full message.');
                    }
                }
            };

            xhr.open('POST', 'fetch_full_message.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('message_id=' + messageId);
        });
    });

    // ... (Remaining JavaScript code) ...
});
</script>
</body>
</html>


