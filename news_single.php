<?php 
include('database.php');
$id=$_GET['id'];
$sql="SELECT * FROM posts WHERE id=:id";
$stmt=$conn->prepare($sql);
$stmt->execute(['id'=>$id]);
$post=$stmt->fetch();

$sql="SELECT * FROM categories";
$stmt =$conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();

$sql="SELECT * FROM posts ORDER BY time DESC";
$stmt =$conn->prepare($sql);
$stmt->execute();
$posts_recent = $stmt->fetchAll();
// print_r($posts);
// exit;

if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $post_id=$id;
    if(empty($name))
    {
        array_push($err_msg,"Title bos bolmasin");
    }
    elseif(strlen($name)<2)
    {
        array_push($err_msg,"Name 2 belgiden ulken bolsın");
    }

    if(trim($comment)=="")
    {
        array_push($err_msg,"Comment bos bolmasin");
    }

    if(empty($err_msg))
    {
        $sql = "INSERT INTO comments (post_id,name,email,comment) VALUES (:post_id,:name,:email,:comment)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
         'post_id'=>$post_id,
         'name'=>$name,
         'email'=>$email,
         'comment'=>$comment
        ]);
        $err_msg['post']="Succesfuly";
        $_POST=[];
    }  
}

$sql="SELECT * FROM comments WHERE post_id=:post_id ORDER BY date DESC";
$stmt =$conn->prepare($sql);
$stmt->execute(['post_id'=>$id]);
$comments = $stmt->fetchAll();

if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['search'])){
    $search=$_POST['search_text'];
    header("Location: search_posts.php?search=$search");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('css.php') ?>
</head>

<body>
<?php include('header.php') ?>

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php#news">News</a></li>
                    <li>News Single</li>
                </ol>
                <h2>News Single</h2>

            </div>
        </section>
        <!-- End Breadcrumbs -->

        <!-- ======= Blog Single Section ======= -->
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">

                <div class="row">

                    <div class="col-lg-8 entries">

                        <article class="entry entry-single">

                            <div class="entry-img">
                                <img src="img/<?php echo $post['img'] ?>" alt="" class="img-fluid">
                            </div>

                            <h2 class="entry-title">
                                <a href="news_single.php"><?php echo $post['title'] ?></a>
                            </h2>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="news_singli.php">Autor</a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="news_singli.php"><time datetime="2020-01-01"><?php echo $post['time'] ?></time></a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="news_singli.php"><?php echo count($comments)?> Comments</a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                <p><?php echo $post['text'] ?></p>
                            </div>

                            <div class="entry-footer">
                                <i class="bi bi-folder"></i>
                                <ul class="cats">
                                <?php foreach($categories as $category):?>
                                    <li><a href="#">
                                    <?php
                                        if($category['id']==$post['category_id'])
                                        {
                                            echo $category['name'];
                                        } 
                                        ?></a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>

                        </article>
                        <!-- End blog entry -->

                        <div class="blog-comments">

                            <h4 class="comments-count"><?php echo count($comments)?> Comments</h4>
                            <?php foreach($comments as $comment):?>
                            <div id="comment-1" class="comment">
                                <div class="d-flex">
                                    <div>
                                        <h5><a href=""><?php echo $comment['name']?></a></h5>
                                        <time datetime="2020-01-01"><?php echo $comment['date']?></time>
                                        <p><?php echo $comment['comment']?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach?>
                            <!-- End comment #1 -->
                            <div class="reply-form">
                            <?php if(!empty($err_msg)):?>
                                            <?php foreach($err_msg as $err):?>
                                            <?php if(!empty($err_msg['post'])):?>
                                            <li class="text-success"><?php echo $err?></li>
                                            <?php else:?>
                                            <li class="text-danger"><?php echo $err?></li>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                            <?php endif;?>
                                <h4>Leave a Reply</h4>
                                <p>Your email address will not be published. Required fields are marked * </p>
                                <form action="" method='post'>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input name="name" type="text" class="form-control" placeholder="Your Name*">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input name="email" type="text" class="form-control" placeholder="Your Email*">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group">
                                            <textarea name="comment" class="form-control" placeholder="Your Comment*"></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" name='submit' class="btn btn-primary">Post Comment</button>
                                </form>

                            </div>

                        </div>
                        <!-- End blog comments -->

                    </div>
                    <!-- End blog entries list -->

                    <div class="col-lg-4">

                        <div class="sidebar">

                            <h3 class="sidebar-title">Search</h3>
                            <div class="sidebar-item search-form">
                                <form action="" method="post">
                                    <input type="text" name="search_text">
                                    <button type="submit" name="search"><i class="bi bi-search"></i></button>
                                </form>
                            </div>
                            <!-- End sidebar search formn-->

                            <h3 class="sidebar-title">Categories</h3>
                            <div class="sidebar-item categories">
                                <ul>
                                    <?php foreach($categories as $category): ?>
                                    <?php
                                    $sql="SELECT * FROM posts WHERE category_id=:id";
                                    $stmt =$conn->prepare($sql);
                                    $stmt->execute(['id'=>$category['id']]);
                                    $posts = $stmt->fetchAll();
                                    ?>
                                    <li><a href="category_news.php?category_id=<?php echo $category['id']?>"><?php echo $category['name'] ?> <span>(<?php echo count($posts) ?>)</span></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <!-- End sidebar categories-->

                            <h3 class="sidebar-title">Recent Posts</h3>
                            <div class="sidebar-item recent-posts">
                                <?php for($i=0;$i<3;$i++): ?>
                                <div class="post-item clearfix">
                                    <img src="img/<?php echo $posts_recent[$i]['img'] ?>" alt="">
                                    <h4><a href="news_single.php?id=<?php echo $posts_recent[$i]['id']?>"><?php echo $post_recent['title'] ?></a></h4>
                                    <time datetime="2020-01-01"><?php echo $posts_recent[$i]['time'] ?></time>
                                </div>
                                <?php endfor;?>

                            </div>
                            <!-- End sidebar recent posts-->
                            <!-- End sidebar tags-->

                        </div>
                        <!-- End sidebar -->

                    </div>
                    <!-- End blog sidebar -->

                </div>

            </div>
        </section>
        <!-- End Blog Single Section -->

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('footer.php')?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include('js.php') ?>

</body>

</html>