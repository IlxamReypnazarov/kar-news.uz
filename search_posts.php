<?php
include('database.php');
$search=$_GET['search'];
$sql="SELECT * FROM posts WHERE title LIKE '%$search%' OR text LIKE '%$search%' ORDER BY time DESC";
$stmt =$conn->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('css.php') ?>
</head>
<body>
    <?php include('header.php') ?>
    <br>
    <main id="main">
        <!-- ======= Recent Blog Posts Section ======= -->
        <section id="news" class="recent-blog-posts">
            <div class="container" data-aos="fade-up">
                <header class="section-header">
                    <h2>Search ...<?php echo $search ?>...</h2>
                </header>
                <div class="row">
                    <?php foreach($posts as $post):?>
                    <div class="col-lg-4">
                        <div class="post-box">
                            <div class="post-img"><img src="img/<?php echo $post['img']?>" class="" weight=300
                                    height=400 alt=""></div>
                            <span class="post-date"><?php echo $post['time']?></span>
                            <h3 class="post-title"><?php echo $post['title']?></h3>
                            <a href="news_single.php?id=<?php echo $post['id']?>"
                                class="readmore stretched-link mt-auto"><span>Read More</span><i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </section>
        <!-- End Recent Blog Posts Section -->
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('footer.php')?>
    <!-- End Footer -->
    <?php include('js.php') ?>
</body>

</html>