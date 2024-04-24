<?php
include('database.php');
$sql="SELECT * FROM posts ORDER BY time DESC";
$stmt =$conn->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();
// print_r($posts);
// exit;
if(count($posts)>=3)
{
    $a=3;
}else{
    $a=count($posts);
}
$sql="SELECT * FROM home_title WHERE id=:id";
$stmt =$conn->prepare($sql);
$stmt->execute(['id'=>1]);
$home_title = $stmt->fetch();

$sql="SELECT * FROM about_title WHERE id=:id";
$stmt =$conn->prepare($sql);
$stmt->execute(['id'=>1]);
$about_title = $stmt->fetch();

$sql="SELECT * FROM team";
$stmt =$conn->prepare($sql);
$stmt->execute();
$team = $stmt->fetchAll();

$sql="SELECT * FROM address WHERE id=:id";
$stmt =$conn->prepare($sql);
$stmt->execute(['id'=>1]);
$address = $stmt->fetch();
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['send']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];
    if(empty($name))
    {
        array_push($err_msg,"Name bos bolmasin");
    }
    elseif(strlen($name)<2)
    {
        array_push($err_msg,"Name 2 belgiden ulken bolsin");
    }

    if(empty($email))
    {
        array_push($err_msg,"Email bos bolmasin");
    }
    elseif(strlen($email)<2)
    {
        array_push($err_msg,"Email 2 belgiden ulken bolsin");
    }

    if(empty($subject))
    {
        array_push($err_msg,"Subject bos bolmasin");
    }
    elseif(strlen($subject)<2)
    {
        array_push($err_msg,"Subject 2 belgiden ulken bolsin");
    }

    if(trim($message)=="")
    {
        array_push($err_msg,"Message bos bolmasin");
    }
    
    if(empty($err_msg))
    {
    $sql = "INSERT INTO messages (name,email,subject,message) VALUES (:name,:email,:subject,:message)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
    'name'=>$name,
    'email'=>$email,
    'subject'=>$subject,
    'message'=>$message
    ]);
    $err_msg['post']="Succesfuly";
    }   
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('css.php') ?>
</head>
<body>
    <?php include('header.php') ?>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up"><?php echo $home_title['title'] ?></h1>
                    <h2 data-aos="fade-up" data-aos-delay="400"><?php echo $home_title['text'] ?></h2>
                </div>
                <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/img/hero-img.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section>
    <!-- End Hero -->

    <main id="main">
        <!-- ======= Recent Blog Posts Section ======= -->
        <section id="news" class="recent-blog-posts">
            <div class="container" data-aos="fade-up">
                <header class="section-header">
                    <h2>News</h2>
                    <p>Sońǵı jańalıqlar</p>
                </header>
                <div class="row">
                    <?php for($i=0;$i<$a;$i++): ?>
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
                <br>
                <center><a href="posts.php" class="readmore stretched-link mt-auto"><span>View All Posts</span><i
                                    class="bi bi-arrow-right"></i></a></center>
            </div>

        </section>
        <!-- End Recent Blog Posts Section -->

        <!-- ======= About Section ======= -->
        <section id="about" class="about">

            <div class="container" data-aos="fade-up">
                <div class="row gx-0">

                    <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="content">
                            <h3>Biz haqqımızda</h3>
                            <h2><?php echo $about_title['title'] ?></h2>
                            <p><?php echo $about_title['text'] ?></p>
                        </div>
                    </div>

                    <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                        <img src="img/<?php echo $about_title['img'] ?>" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Section -->

        <!-- ======= Team Section ======= -->
        <section id="team" class="team">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>Team</h2>
                    <p>Biziń komanda</p>
                </header>

                <div class="row gy-4">
                    <?php foreach($team as $user): ?>
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <div class="member-img">
                                <img src="img/<?php echo $user['img']?>" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4><?php echo $user['name']?> <?php echo $user['surname']?></h4>
                                <span><?php echo $user['role']?></span>
                                <p><?php echo $user['about']?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>
        <!-- End Team Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>Contact</h2>
                    <p>Contact Us</p>
                </header>

                <div class="row gy-4">

                    <div class="col-lg-6">

                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Address</h3>
                                    <p><?php echo $address['street'] ?>,<br><?php echo $address['city'] ?>, Post code :
                                        <?php echo $address['post'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-telephone"></i>
                                    <h3>Call Us</h3>
                                    <p><?php echo $address['phone'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email Us</h3>
                                    <p><?php echo $address['email'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-clock"></i>
                                    <h3>Open Hours</h3>
                                    <p><?php echo $address['open_days'] ?><br><?php echo $address['open_hours'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form action="" method="post">
                        <!-- <form action="" method="post" class="php-email-form"> -->
                            <?php if(!empty($err_msg)):?>
                            <?php foreach($err_msg as $err):?>
                            <?php if(!empty($err_msg['post'])):?>
                            <li class="text-success"><?php echo $err?></li>
                            <?php else:?>
                            <li class="text-danger"><?php echo $err?></li>
                            <?php endif;?>
                            <?php endforeach;?>
                            <?php endif;?>
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required>
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message"
                                        required></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary" name="send">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </section>
        <!-- End Contact Section -->

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('footer.php')?>
    <!-- End Footer -->
    <?php include('js.php') ?>
</body>

</html>