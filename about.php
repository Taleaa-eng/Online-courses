<?php include "header.php"; ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'admin/dbconnect.php'; 

    // Function to sanitize input
    function input($comment) {
        $comment = trim($comment);
        $comment = htmlspecialchars($comment);
        return $comment;
    }

    $comment = input($_POST['comment']); 

    // Validate the comment
    if (empty($comment)) {
        echo "<script>alert('Comment cannot be empty.');</script>";
    } elseif (strlen($comment) > 500) {
        echo "<script>alert('Comment must be less than 500 characters.');</script>";
    } else {
        // Insert the comment into the database
        $stmt = $con->prepare("INSERT INTO comments (user_id, comment_text) VALUES (?, ?)");
        
        // Use a default user_id if not available
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // or set a default value
        
        $stmt->execute([$user_id, $comment]);
        echo "<script>alert('Your comment has been successfully submitted.');</script>";
    }
}
?>
<main>
<h4 class="wel">About Us</h4>
    <p class="wel">We are trying to give you information as much as we can... <br>
        So we tried bringing the best courses we know to help you advance in the language.
    </p>
    <p class="wel">
        Computer programming or coding is the composition of sequences of instructions, called programs, that computers can follow to perform tasks. It involves designing and implementing algorithms, step-by-step specifications of procedures, by writing code in one or more programming languages. Programmers typically use high-level programming languages that are more easily intelligible to humans than machine code, which is directly executed by the central processing unit.
    </p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <textarea rows="4" cols="50" placeholder="Write your comment here..." class="comment" name="comment"></textarea>
        <br>
        <button class="butn2" type="submit">Send</button>
    </form>
</main>

<?php include "footer.php"; ?>