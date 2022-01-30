<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        $dbname = 'a3v2';

        try {
            $dbcon = new mysqli('localhost', 'root', '');
            if($dbcon -> connect_errno) {
                echo "could not connect... :-(";
                exit();
            }

            try {
                //if db not exists, then create one and select;
                $dbcon -> select_db($dbname);

            }
            catch(Exception $exsel) {
                //create db
                try {
                    $dbcon -> query('create database '.$dbname);
                    $dbcon -> select_db($dbname);
                    $dbcon -> query("create table info(name varchar(255), quiz int, mid int, asgn int, att int, final int)");
                }
                catch(Exception $excmn) {
                    echo "uh-oh... terrible! :-(";
                }
            }

        }
        catch(Exception $exdbcon) {

            echo "<br> uh-oh! sth went wrong while connecting..$#@^@$&#$#%@#$%&*&%*(&^%#$#";
            exit();
        }
        
    
    
    
    
    ?>
    
    <div class="entry">
        <span style="margin-right: auto; margin-top: 7px;">Data Entry: </span>
        <form action="index.php" method="post" style="display: flex; justify-content: flex-end;">

            <div class="">
                <input type="text" name="name" placeholder="name" required>
                <input type="number" name="quiz" placeholder="Quiz" required>
                <input type="number" name="mid" placeholder="mid" required>
                <input type="number" name="asgn" placeholder="assignment" required>
                <input type="number" name="att" placeholder="attendance" required>
                <input type="number" name="final" placeholder="final" required>
                <input type="submit" value="save" name="save" style="background-color: blue; color: white; font-family: 'VT323', monospace; font-size: 25px;">
            </div>

            <?php
            
                try {
                    if(isset($_POST['save'])) {
                        $name = $_POST['name'];
                        $quiz = $_POST['quiz'];
                        $mid = $_POST['mid'];
                        $asgn = $_POST['asgn'];
                        $att = $_POST['att'];
                        $final = $_POST['final'];

                        $qry = "insert into info values('".$name."', '".$quiz."', '".$mid."', '".$asgn."', '".$att."', '".$final."')";
                        
                        $datafetch = $dbcon -> query($qry);

                    

                    }
                }
                catch(Exception $exdataentry) {
                    echo "could not save, uh-oh ^$^%(*&)(&%^&$&*%*(& :: ".$exdataentry;
                }
            
            
            
            ?>

        </form>
    </div>

    <div class="datatbl" style="text-align: center;">
        <table align="center" width="100%">
            <tr>
                <th>name</th>
                <th>quiz</th>
                <th>mid</th>
                <th>assignment</th>
                <th>attendance</th>
                <th>final</th>
            </tr>


            <?php
            
                $qry_read = "select * from info";
                
                try {
                    $result = $dbcon -> query($qry_read);

                    if($result -> num_rows > 0) {
                        while($rows = $result -> fetch_assoc()) {
            ?>
                            <tr>
                                <td><?php echo $rows['name'] ?></td>
                                <td><?php echo $rows['quiz'] ?></td>
                                <td><?php echo $rows['mid'] ?></td>
                                <td><?php echo $rows['asgn'] ?></td>
                                <td><?php echo $rows['att'] ?></td>
                                <td><?php echo $rows['final'] ?></td>
                            </tr>

            <?php
                        }
                    }
                    else {
                        //no data
                        


            ?>
                            <tr>
                                <td colspan="6"> no data found </td>
                            </tr>
                    
            <?php
                    }
                }
                catch(Exception $exread) {
                    echo "uh-oh %^&#%^$%*%$#@^&*%";
                }
            
            
            
            ?>





        </table>
    </div>
    <div class="footer">
        <div class="">total entry</div>
        <div class="">
            <?php
                try {
                    echo (($dbcon -> query("select * from info")) -> num_rows);
                }
                catch(Exception $exl) {
                    echo "%#&^";
                }

            ?>
        </div>
    </div>


</body>
</html>