<?php 
include 'header.php';
require 'admin/dbconnect.php';

try {
    // Adjusted SQL query to only select courses with status = 1
    $sql = 'SELECT title, image, video_url, status FROM courses WHERE status = 1';
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}

$sql = "SELECT c.title AS course_name, c.duration, cat.name AS category_name 
        FROM courses c 
        JOIN categroies cat ON c.category_id = cat.id 
        WHERE c.status = 1 
        GROUP BY cat.id";

$stmt = $con->prepare($sql);
$stmt->execute();

// Fetch the results
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main>
    <h1 class="wel">Welcome!</h1>
    <h4 class="wel">This website contains courses for learning to be achieve in a lot of things... 
        <br> We wish you great learning experiences...</h4>

    <!-- Start WOWSlider.com BODY section -->
    <div id="wowslider-container1">
        <div class="ws_images"><ul>
            <li><img src="data1/images/informationtechnologycodingconnectionprogramming.jpg" alt="" title="" id="wows1_0"/></li>
            <li><a href="http://wowslider.net"><img src="data1/images/personfrontcomputerworkinghtml.jpg" alt="image carousel" title="" id="wows1_1"/></li>
            <li><img src="data1/images/programmingbackgroundcollage.jpg" alt="" title="" id="wows1_2"/></li>
        </ul></div>
        <div class="ws_bullets"><div>
            <a href="#" title=""><span><img src="data1/tooltips/informationtechnologycodingconnectionprogramming.jpg" alt=""/>1</span></a>
            <a href="#" title=""><span><img src="data1/tooltips/personfrontcomputerworkinghtml.jpg" alt=""/>2</span></a>
            <a href="#" title=""><span><img src="data1/tooltips/programmingbackgroundcollage.jpg" alt=""/>3</span></a>
        </div></div>
        <div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">bootstrap slider</a> by WOWSlider.com v9.0</div>
        <div class="ws_shadow"></div>
    </div>	
    <script type="text/javascript" src="engine1/wowslider.js"></script>
    <script type="text/javascript" src="engine1/script.js"></script>
    <!-- End WOWSlider.com BODY section -->

    <section class="courses-section">
        <div class="cards-container">
            <!-- Additional content can go here -->
        </div>
    </section>

    <table class="table">
        <tr>
            <th class="center">Course Name</th>
            <th class="center">Duration</th>
            <th class="center">Category Name</th>
        </tr>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                <td><?php echo htmlspecialchars($course['duration']) . ' days'; ?></td>
                <td><?php echo htmlspecialchars($course['category_name']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<?php 
include 'footer.php';
?>