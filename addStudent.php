<?php
/**
 * Created by PhpStorm.
 * User: nalin
 * Date: 7/10/2018
 * Time: 4:17 PM
 */

include('inc/header.php');

?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $addUser = $user->addUser($_POST);
}
?>
<?php
$teacher = Session::get('role');
if(strcmp($teacher,"Teacher")!=0){
    header("Location:404.php");
}
?>
<?php
    if(isset($_GET['page']) ){
        $pg = $_GET['page'];
    }else{
        $pg=1;
    }
?>
<body>
<?php include('inc/navbar.php')?>

<section id="users" class="">
    <div class="container">
        <div class="row">
            <div class="col col-md-3 col-lg-3 text-center">
                <div class="card">
                    <div class="card-body">
                        <img src="<?php echo Session::get('photo');?>" alt="" class="img-fluid rounded-circle w-50 mb-1">
                        <h4><?php echo Session::get('name');?></h4>
                        <h5 class="text-muted"><?php echo Session::get('role')?></h5>
                        <div class="list-group">
                            <a href="index.php" class="list-group-item list-group-item-action">Home</a>
                            <a href="addSubject.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Add Subjects</a>
                            <a href="addStudent.php" class="list-group-item list-group-item-action active" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Add User</a>
                            <a href="sendNotifications.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Teacher"){echo "display:none";}?>">Send Notices</a>
                            <a href="addLog.php" class="list-group-item list-group-item-action" style="<?php if(Session::get('role')!="Coordinator"){echo "display:none";}?>">Add Logs</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add a Student</div>
                        <form action="addStudent.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="studentName">Student Name</label>
                                    <input type="text" class="form-control" name="fullname" placeholder="Student Name">
                                </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="role">Role</label><br/>
                                <select class="form-control" name="role">
                                    <option>Select a role</option>
                                    <?php
                                        $roles = $role->getStudents();
                                        if($roles){
                                            while($result=$roles->fetch_assoc()){

                                    ?>
                                    <option value="<?php echo $result['user_type_id']?>"><?php echo $result['userType']?></option>
                                    <?php }}?>
                                </select>
                            </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="school" value="<?php echo Session::get('schoolid')?>" hidden>
                                </div>
                            </div>
                            <div class="form-group col-md-9">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" placeholder="Address" rows="2"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="nic">NIC</label>
                                    <input type="text" class="form-control" name="nic" placeholder="NIC">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="don">Email</label>
                                    <input type="date" class="form-control" name="dob">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="username">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="confirmpass">confirm password</label>
                                    <input type="password" class="form-control" name="cpassword" placeholder="Confirm password">
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-info" value="Add">
                            <?php if(isset($addUser)){echo $addUser;}?>
                        </form>
                    </div>
                </div>
                <br/>
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Current Students</div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $start_from = ($pg-1)*10;
                            $sid = Session::get('schoolid');
                                $users = $user->getStudents($sid,$start_from,10);
                                if($users){
                                    $i=0;
                                    while($result=$users->fetch_assoc()){
                                        $i++;
                            ?>

                            <tr>
                                <th scope="row"><?php echo $i;?></th>
                                <td><?php echo $result['name'];?></td>
                                <td><?php echo $result['userType'];?></td>
                                <td><a href="#" class="btn btn-danger btn-sm">Remove</a></td>
                            </tr>
                          <?php }}?>
                            </tbody>
                        </table>
                        </tbody>
                        </table>
                        <nav aria-label="User Pagination">
                            <ul class="pagination">
                                    <?php
                                        $pages = $page->addPagination(10,'users');
                                        if($pages){
                                            for($i=1;$i<=$pages;$i++){
                                                echo "<li class='page-item'><a class='page-link' href='page?=".$i."'>".$i."</a></li>";
                                            }
                                        }
                                    ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('inc/footer.php')?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>