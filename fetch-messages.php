<?php
require('dbconn.php');
// Assuming $lastMessageId is the last message ID displayed on the page or a timestamp comparison
$lastMessageId = $_GET['last_message_id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM chat_messages WHERE claim_id = ? AND message_id > ?");
$stmt->bind_param("ss", $claimId, $lastMessageId);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);

foreach ($messages as $message) {
    // Output HTML or JSON representation of each message
    echo '<div class="chat-content ' . ($message['sender_id'] == $userId ? 'user' : '') . '">
            <div class="message-item">
                ' . ($message['message_image'] ? '<div class="bubble"><img src="assets/uploads/messages/' . htmlspecialchars($message['message_image']) . '" alt="Image"></div>' : '') . '
                ' . ($message['message'] ? '<div class="bubble">' . htmlspecialchars($message['message']) . '</div>' : '') . '
                <div class="message-time">' . htmlspecialchars(date('h:i A', strtotime($message['timestamp']))) . '</div>
            </div>
        </div>';
}
