<?php 
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My To-do List</title>
    <link rel="stylesheet" href="css/styl.css">
</head>
<body>
    <div class="main-section">
        <div class="add-section">
           <h1>
               Selamat Datang di To-do List sederhana!
           </h1>
          <form action="app/add.php" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" 
                     name="title" 
                     style="border-color: #ff6666"
                     placeholder="Heyy disini masih kosong!!" />
                <input type="text" onfocus="(this.type='date')" name="deadline" placeholder="Deadline">
                <button name="submit" type="submit">Masukkan +</span></button>
                
                <?php }else{ ?>
                    <input type="text" 
                    name="title" 
                    placeholder="Apa yang akan kamu lakukan?" />
                <input type="text" onfocus="(this.type='date')" name="deadline" placeholder="Deadline">
              <button name="submit" type="submit">Masukkan +</span></button>
             <?php } ?>
          </form>
       </div>
       <?php 
          $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
       ?>
       <div class="show-todo-section">
            <?php if($todos->rowCount() <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/tdlist.jpg" width="100%" />
                        <img src="img/Ellipsis.gif" width="80px">
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>"
                          class="remove-to-do">x</span>
                    <?php if($todo['checked']){ ?> 
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               class="check-box" />
                        <h2><?php echo $todo['title'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>created: <?php echo $todo['date_time'] ?></small>
                    <small>deadline: <?php echo $todo['deadline'] ?></small>  
                </div>
            <?php } ?>
       </div>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>

<?php

$query = "SELECT * FROM todos";
$statement = $conn->query($query);
// $result = mysqli_query($conn, $query);

$data = array();
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// $data = array();
// while ($row = mysqli_fetch_assoc($result)) {
//     $data[] = $row;
// }
$json_data = json_encode($data, JSON_PRETTY_PRINT);
$file_path = 'data/data.json';
file_put_contents($file_path, $json_data);





?>

<?php
    /*
    Fungsi untuk ,enghitung total item
    total item didapat dengan cara menjumlahkan item1, item2, item3.
    fungsi ini mengembalikan value total item.
    */
    // function totalitem($a,$b,$c) {
    //     $total = $a + $b + $c;
    //     return $total;
    // }

    // $berkas = "data/data.json"; //variabel berisi nama berkas dimana data dibaca dan ditulis

    // $toDo = array(); //variabel array kosong untuk menampung data customer dari beraks

    // $datajson = file_get_contents($berkas);
    // $toDo = json_decode($datajson, true);

    // if(isset($_POST['submit'])) {
    //     $item = array();

    //     $databaru = array(
    //         'title' => $_POST['title'],
    //         'deadline' => $_POST['deadline']
    //     );
        
    //     array_push($toDo, $databaru); //menambahkan data baru

    //     $datajson = json_encode($toDo, JSON_PRETTY_PRINT);
    //     file_put_contents($berkas, $datajson);
    // }       
?>
</body>
</html>