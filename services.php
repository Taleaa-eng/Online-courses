<?php
include "header.php";
require "admin/dbconnect.php";

try {
    $sql = 'SELECT id, name FROM categroies';  
    $categoriesStmt = $con->prepare($sql);
    $categoriesStmt->execute();
    
    while ($category = $categoriesStmt->fetch()) {
        $sql2 = 'SELECT title, video_url, image, description, status FROM courses WHERE category_id = :category_id';
        $coursesStmt = $con->prepare($sql2);
        $coursesStmt->execute(['category_id' => $category['id']]);
        
        if ($coursesStmt->rowCount() > 0) {
            echo '<h5 class="wel">' . htmlspecialchars($category["name"]) . '</h5>';
            echo '<div class="coursesContainer" style="display: flex; flex-wrap: wrap; justify-content: center;">'; 
            
            while ($course = $coursesStmt->fetch()) {
                if ($course['status'] == 1) {
                    echo '<div class="Card">';
                    echo '<img src="admin/' . htmlspecialchars($course['image']) . '" alt="' . htmlspecialchars($course['title']) . '" class="card-image">';
                    echo '<h5 class="card-title">' . htmlspecialchars($course["title"]) . '</h5>';
                    echo '<div class="card-decoration">';
                    echo '<p class="card-description">This is a ' . htmlspecialchars($course["title"]) . ' course.<br>';
                    echo htmlspecialchars($course["description"]) . '</p>';
                    echo '<p><a href="' . htmlspecialchars($course["video_url"]) . '" target="_blank">Watch Now</a></p>';
                    echo '</div>'; 
                    echo '</div>'; 
                }
            }
            echo '</div>'; 
        }
    }
    
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>
<main>
    <h4 class="wel">Let`s get start learning</h4>
</main>
<?php include "footer.php"; ?>