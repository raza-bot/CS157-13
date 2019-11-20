<?php
    require_once 'db_connection.php';
    require_once 'index.php';

    $today = date('Y-m-d');
    $max = date('Y-m-d', strtotime("+6 Months"));

    echo <<<_END
    <head>
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="homepage.css">
        
        <style>
            div[value='content'] {
                margin: 20;
                opacity: 90%;
                word-wrap: break-word;
                background-color: #ffffff;
                border-radius: 20px;
                box-shadow: 0px 0px 3px 1px #000000;
                padding-top: 20px;
                padding-bottom: 20px;
                padding-right:10px;
                padding-left:8px;
            }
            img[value='roomimg']{
                width: 300px;
                height: 200px;
                object-fit: cover;
                border-radius: 8%;
            }
        </style>   
    </head>
    <div class="slogan-text-box">
        <h1>A home away from home</h1>
    </div>
    _END;

    $query = "SELECT * FROM room JOIN hotel ON room.hotelID=hotel.id;"; // Select 'all' from 'hotel' table

    $result = $conn->query($query);

    if (!$result) {
        echo "Something went wrong!";  // Statement so we know something didn't go as planned
    }
    else{

        $rows = $result->num_rows;
        for ($j = 0; $j < $rows; $j++)  // Go through each row
        {
            $result->data_seek($j);     // Get data from row
            $row = $result->fetch_array(MYSQLI_NUM);    // Put row data into array

            echo <<<_END
            <div value='content' class="row">
                <img value='roomimg' class="col-sm-2" src="img/$row[2].jpg">
                <div class="col-sm-6" style="margin: auto;">
                    <h2><b>$row[6]</b></h2>
                    <h5>Address: <b>$row[7]</b></h5>
                    <h4>Type: <b>$row[2]</b></h4> 
                    <h4>Room Number: <b>$row[1]</b></h4>
                    <h3 style="color:Green;"><b>$$row[4]</b> <small>PER NIGHT</small></h3>
                </div>
                <div class="col-sm-3" align="center" style="margin-top:65;">
                    <button type="submit" class="btn btn-info btn-lg" data-toggle="modal" data-target="#bookModal$j">Book For <b>$$row[4]</b></button>
                </div>
            </div>
            <div id="bookModal$j" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Book Hotel</h4>
                    </div>
                    <form action="index.php" method="post">
                            <div class="modal-body">
                                Start Date: <input type="date" min=$today max=$max value=$today>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-default" name="addpayment"><b>Book</b></button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
            _END;
        }
    }
?>