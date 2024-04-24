<?php 
session_start();
$role = $_SESSION['role'];
if($role!=='admin'){
  include('errors-404.php');
  exit;
}
$err_msg=[];
$pdo = require_once('../database.php');

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['edit_post']))
{
    $title = $_POST['title'];
    $text = $_POST['textarea'];
    $img = $_FILES['img'];
    $img_name = $img['name'];
    $img_path = $img['full_path'];
    $img_temp = $img['tmp_name'];
    $img_type = $img['type'];
    $img_error = $img['error'];
    $img_size = $img['size'];
    $allowed=['jpg','png','jpeg'];
    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    if(empty($title))
    {
        array_push($err_msg,"Title bos bolmasin");
    }
    elseif(strlen($title)<10)
    {
        array_push($err_msg,"Title 10 belgiden ulken bolsin");
    }
    if(trim($text)=="")
    {
        array_push($err_msg,"Text bos bolmasin");
    }

    if(!in_array($ext,$allowed))
    {
        array_push($err_msg,"Suwret tek jpg,jpeg,png formatta bolsin");
    }elseif($img_size>5000000)
    {
        array_push($err_msg,"Fayl 5 mb qa shekem bolsin");
    }

    if(empty($err_msg))
    {
        if(isset($img) && $img_error==0)
        {
         move_uploaded_file($img_temp,"../img/".$img_name);
        }
        $publisher = [
            'title'=>$title,
            'text'=>$text,
            'img'=>$img_name,
            'id'=>1
          ];
          $sql = 'UPDATE about_title SET category_id=:category_id,title = :title,text=:text,img=:img WHERE id = :id';
          $statement = $conn->prepare($sql);
          $statement->execute($publisher);
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
                                        <h4>Edit about title</h4>
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
                                                <label>Title</label>
                                                <input type="text" value="<?php echo $post['title'] ?>" name="title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" name="img" class="form-control" id="">
                                            </div>
                                            <div class="form-group">
                                                <label>Text Full</label>
                                                <textarea id="editor" name="textarea" class="form-control "><?php echo $post['text'] ?></textarea>
                                            </div>
                                            <div class="card-footer text-right">
                                                <input name="edit_post" class="btn btn-primary mr-1" type="submit"
                                                    value="Submit">
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