<?php
session_start();
include 'database_connection.php';

// Assuming the user is logged in and their user_id is stored in the session
$user_id = $_SESSION['user_id'];

// Get the logged-in user's company from the user_login table
$query = $connect->prepare("SELECT company, user_fullname FROM user_login WHERE user_id = :user_id");
$query->execute(['user_id' => $user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);
$company_name = $user['company'];
$username = $user['user_fullname'];

// Handle message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $reply_message_id = isset($_POST['reply_message_id']) ? $_POST['reply_message_id'] : null;

    // Prevent sending empty messages
    if (!empty(trim($message))) {
        // Insert the message into the messages table
        $insert = $connect->prepare("INSERT INTO messages (user_id, message, company, reply_message) VALUES (:user_id, :message, :company, :reply_message_id)");
        $insert->execute([
            'user_id' => $user_id,
            'message' => $message,
            'company' => $company_name,
            'reply_message_id' => $reply_message_id // Store the replied message's ID
        ]);
    }
}

// Fetch messages for the current company
$query = $connect->prepare("SELECT m.*, u.user_fullname FROM messages m JOIN user_login u ON m.user_id = u.user_id WHERE m.company = :company ORDER BY m.created_at ASC");
$query->execute(['company' => $company_name]);
$messages = $query->fetchAll(PDO::FETCH_OBJ);
?>
<dOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TERA</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/TERA.jpeg" />
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <link href="../dist/css/style.min.css" rel="stylesheet" />
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Chat</title>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Chat</title>
    <link href="../assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            max-height: 500px;
            overflow-y: scroll;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .message {
            padding: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f1f1f1;
        }
        .message.reply {
            text-align: right;
            background-color: #d1f1d1;
        }
        textarea {
            width: 100%;
            height: 60px;
            margin-top: 10px;
        }
        .reply-btn {
            cursor: pointer;
            color: blue;
        }
    </style>
    <script>
        // JavaScript to handle reply functionality
        function replyToMessage(messageId, messageContent) {
            document.getElementById('reply_message_id').value = messageId;
            document.getElementById('reply_message_text').value = "Replying to: " + messageContent;
        }

        // Prevent form submission with empty message
        function validateForm() {
            var message = document.getElementById('message').value.trim();
            if (message === "") {
                alert("Message cannot be empty.");
                return false;
            }
            return true;
        }
    </script>
</head>

  <body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
      <?php include('header.php'); ?>
      <?php include('sidebar.php'); ?>
      <div class="page-wrapper">
      <div class="container">
      <div class="container mt-5">
      <div class="container mt-5">
        <h1>Company Chat for <?php echo htmlspecialchars($company_name); ?></h1>
        <div class="chat-box">
            <?php foreach ($messages as $msg): ?>
                <div class="message<?php echo $msg->reply_message ? ' reply' : ''; ?>">
                    <p><strong><?php echo htmlspecialchars($msg->user_fullname); ?>:</strong> <?php echo htmlspecialchars($msg->message); ?></p>
                    <?php if ($msg->reply_message): ?>
                        <p class="reply"><strong>Reply:</strong> <?php echo htmlspecialchars($msg->reply_message); ?></p>
                    <?php endif; ?>
                    <span class="reply-btn" onclick="replyToMessage(<?php echo $msg->id; ?>, '<?php echo addslashes($msg->message); ?>')">Reply</span>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" onsubmit="return validateForm();">
            <textarea id="message" name="message" placeholder="Type your message here"></textarea>
            <input type="hidden" id="reply_message_id" name="reply_message_id">
            <textarea id="reply_message_text" placeholder="Reply message will appear here (optional)" readonly></textarea>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
    </div>
<script>
    // Function to handle reply to a specific user
    function replyTo(username) {
        const textarea = document.getElementById('message');
        textarea.value = '@' + username + ' '; // Pre-fill the textarea with @username format
        textarea.focus(); // Focus on the textarea for immediate typing
    }
</script>


      </div>
      </div>
    </div>
    
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="../dist/js/waves.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.min.js"></script>
  </body>
</html>
