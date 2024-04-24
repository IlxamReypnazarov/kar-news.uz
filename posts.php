<?php
include('database.php');
$sql="SELECT * FROM posts ORDER BY time DESC";
$stmt =$conn->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

$sql="SELECT * FROM address WHERE id=:id";
$stmt =$conn->prepare($sql);
$stmt->execute(['id'=>1]);
$address = $stmt->fetch();
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
                    <h2>All News</h2>
                </header>
                <div class="row">
                    <?php for($i=0;$i<count($posts);$i++): ?>
                    <div class="col-lg-4">
                        <div class="post-box">
                            <div class="post-img"><img src="img/<?php echo $posts[$i]['img']?>" class="" weight=300
                                    height=400 alt=""></div>
                            <span class="post-date"><?php echo $posts[$i]['time']?></span>
                            <h3 class="post-title"><?php echo $posts[$i]['title']?></h3>
                            <a href="news_single.php?id=<?php echo $posts[$i]['id']?>"
                                class="readmore stretched-link mt-auto"><span>Read More</span><i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

        </section>
        <!-- End Recent Blog Posts Section -->
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('footer.php') ?>
    <!-- End Footer -->
    <?php include('js.php') ?>
</body>

</html>