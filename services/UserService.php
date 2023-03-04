<?php
    require "configs/DBConnection.php";
    require "models/User.php";
    class UserService{
        // Chứa các hàm tương tác và xử lý dữ liệu

        public function getAllUser(){
            // Bước 01: Kết nối DB Server
            //require db
            $conn = new DBConnection();
            // Bước 02: Truy vấn DL
            $showAllUserSql = "SELECT * FROM user order by ten_dnhap";
            $stmt = $conn->getConnection()->prepare($showAllUserSql);
            $stmt->execute();
            $users = [];
            while($row = $stmt->fetch()){
                $user = new User($row['ten_dnhap'], $row['mat_khau'], $row['email'], $row['ngay_dki'], $row['admin']);
                array_push($users,$user);
            }
        
            
            return $users;
        }

        public function processAddUser(){
 
            $conn = new DBConnection();
            $txtUserName= $_POST['txtUserName'];
            $txtUserPass= $_POST['txtUserPass'];
            $txtUserEmail= $_POST['txtUserEmail'];
            $txtUserAdmin= $_POST['txtUserAdmin'];           
            $addUserSql = "INSERT INTO user(ten_dnhap,mat_khau,email,ngay_dki,admin) VALUES ('$txtUserName','$txtUserPass','$txtUserEmail',current_timestamp(), '$txtUserAdmin')";
            $stmt = $conn->getConnection()->prepare($addUserSql);
            if($stmt->execute()){
                header("Location: index.php?controller=user&action=index");
    
              echo "OK";
            }
          //Thực thi câu lệnh
          
              if(mysqli_query($conn,$addUserSql)){ 
                  header("Location: user.php");
                  // echo mysqli_query($conn,$addUserSql);
                  echo "OK";
              }
         }

        public function selectEditUser(){
            // Bước 01: Kết nối DB Server
            //require db
            $conn = new DBConnection();
            // Bước 02: Truy vấn DL
            $getId = $_GET['id'];            
            $showUserWithId = "SELECT * FROM user WHERE ten_dnhap = '$getId'";
            
            $stmt = $conn->getConnection()->prepare($showUserWithId);
            $stmt->execute();
            $userWithId = $stmt->fetch();
            $user = new User($userWithId['ten_dnhap'], $userWithId['mat_khau'], $userWithId['email'], $userWithId['ngay_dki'], $userWithId['admin']);
            return $user;

        }

        public function processEditUser(){
 
            $conn = new DBConnection();
            $userName = $_POST['txtUserName'];
            $password = $_POST['txtPasword'];
            $email = $_POST['txtEmail'];
            $admin = $_POST['txtAdmin'];           
            $updateUserSql = "UPDATE user SET mat_khau = '$password', email = '$email', admin = '$admin' WHERE ten_dnhap =  '$userName'";
            $stmt = $conn->getConnection()->prepare($updateUserSql);
            $stmt->execute();
            if($stmt->execute()){
                header("Location: index.php?controller=user&action=index");
            }

            
            
         }

        public function deleteUser(){
            // Bước 01: Kết nối DB Server
            //require db
            $conn = new DBConnection();
            // Bước 02: Truy vấn DL
            $getId = $_GET['id'];
            $deleteCategorySql = "DELETE FROM user WHERE ten_dnhap = '$getId'  ";
            $stmt = $conn->getConnection()->prepare( $deleteCategorySql);
            $stmt->execute();
            // Bước 03: Trả về dữ liệu
            if($stmt->execute()){
                header("Location: index.php?controller=user&action=index");
            }
            
            
        }
    }

?>