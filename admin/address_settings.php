<?php 
session_start();
$role = $_SESSION['role'];
if($role!=='admin'){
  include('errors-404.php');
  exit;
}
$error_name="";
$err_msg=[];
include('../database.php');
{
    $id=1;
    $sql="SELECT * FROM address WHERE id=:id";
    $stmt=$conn->prepare($sql);
    $stmt->execute(['id'=>$id]);
    $address=$stmt->fetch();
    // print_r($_POST);
    // exit;
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['Edit']))
{
    $street = $_POST['street'];
    $city = $_POST['city'];
    $post = $_POST['post'];
    $email = $_POST['email'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $open_days = $_POST['open_days'];
    $open_hours = $_POST['open_hours'];

    if(empty($street))
    {
        array_push($err_msg,"Street bos bolmasin");
    }
    elseif(strlen($street)<2)
    {
        array_push($err_msg,"Street 2 belgiden ulken bolsin");
    }

    if(empty($city))
    {
        array_push($err_msg,"City bos bolmasin");
    }
    elseif(strlen($city)<2)
    {
        array_push($err_msg,"City 2 belgiden ulken bolsin");
    }

    if(empty($post))
    {
        array_push($err_msg,"Post bos bolmasin");
    }
    elseif(strlen($post)<2)
    {
        array_push($err_msg,"Post 2 belgiden ulken bolsin");
    }

    if(empty($email))
    {
        array_push($err_msg,"Email bos bolmasin");
    }
    elseif(strlen($email)<2)
    {
        array_push($err_msg,"Email 2 belgiden ulken bolsin");
    }

    if(empty($phone))
    {
        array_push($err_msg,"Phone bos bolmasin");
    }
    elseif(strlen($phone)<2)
    {
        array_push($err_msg,"Phone 2 belgiden ulken bolsin");
    }

    if(empty($open_days))
    {
        array_push($err_msg,"Open days bos bolmasin");
    }
    elseif(strlen($open_days)<2)
    {
        array_push($err_msg,"Open days 2 belgiden ulken bolsin");
    }

    if(empty($open_hours))
    {
        array_push($err_msg,"Open time bos bolmasin");
    }
    elseif(strlen($open_hours)<2)
    {
        array_push($err_msg,"Open time 2 belgiden ulken bolsin");
    }

    if(empty($err_msg))
    {
        $sql = "UPDATE address SET street=:street,city=:city,post=:post,email=:email,phone=:phone,open_days=:open_days,open_hours=:open_hours WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
         'street'=>$street,
         'city'=>$city,
         'post'=>$post,
         'email'=>$email,
         'phone'=>$phone,
         'open_days'=>$open_days,
         'open_hours'=>$open_hours,
         'id'=>$id
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
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <?php include('navbar.php') ?>
            <div class="main-sidebar sidebar-style-2">
                <?php include('saidbar.php') ?>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit contacts</h4>
                                    </div>
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <?php if(!empty($err_msg)):?>
                                            <?php foreach($err_msg as $err):?>
                                            <?php if(!empty($err_msg['post'])):?>
                                            <li class="text-success"><?php echo $err?></li>
                                            <?php else:?>
                                            <li class="text-danger"><?php echo $err?></li>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                            <?php endif;?>
                                            <div class="form-group">
                                                <label>Street</label>
                                                <input type="text" name="street" class="form-control" value="<?php echo $address['street'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" name="city" class="form-control" value="<?php echo $address['city'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>post</label>
                                                <input type="number" name="post" class="form-control" value="<?php echo $address['post'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo $address['email'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" name="phone" class="form-control" value="<?php echo $address['phone'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Open days</label>
                                                <input type="text" name="open_days" class="form-control" value="<?php echo $address['open_days'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Open hours</label>
                                                <input type="text" name="open_hours" class="form-control" value="<?php echo $address['open_hours'] ?>">
                                            </div>
                                            <div class="card-footer text-right">
                                                <input name="Edit" class="btn btn-primary mr-1" type="submit"
                                                    value="Edit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                </section>
                <div class="settingSidebar">
                    <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
                    </a>
                    <div class="settingSidebar-body ps-container ps-theme-default">
                        <div class=" fade show active">
                            <div class="setting-panel-header">Setting Panel
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Select Layout</h6>
                                <div class="selectgroup layout-color w-50">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="1"
                                            class="selectgroup-input-radio select-layout" checked>
                                        <span class="selectgroup-button">Light</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="2"
                                            class="selectgroup-input-radio select-layout">
                                        <span class="selectgroup-button">Dark</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                                <div class="selectgroup selectgroup-pills sidebar-color">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="1"
                                            class="selectgroup-input select-sidebar">
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                            data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="2"
                                            class="selectgroup-input select-sidebar" checked>
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                            data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Color Theme</h6>
                                <div class="theme-setting-options">
                                    <ul class="choose-theme list-unstyled mb-0">
                                        <li title="white" class="active">
                                            <div class="white"></div>
                                        </li>
                                        <li title="cyan">
                                            <div class="cyan"></div>
                                        </li>
                                        <li title="black">
                                            <div class="black"></div>
                                        </li>
                                        <li title="purple">
                                            <div class="purple"></div>
                                        </li>
                                        <li title="orange">
                                            <div class="orange"></div>
                                        </li>
                                        <li title="green">
                                            <div class="green"></div>
                                        </li>
                                        <li title="red">
                                            <div class="red"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <div class="theme-setting-options">
                                    <label class="m-b-0">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                            id="mini_sidebar_setting">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="control-label p-l-10">Mini Sidebar</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <div class="theme-setting-options">
                                    <label class="m-b-0">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                            id="sticky_header_setting">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="control-label p-l-10">Sticky Header</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                                    <i class="fas fa-undo"></i> Restore Default
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.php') ?>
            <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
            <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
            </script>
        </div>
    </div>
    <?php include('js.php') ?>
</body>
</html>