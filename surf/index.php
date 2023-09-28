<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/article.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="foto/logo.png" alt="">
        </div>
    </header>

    <hr>
    <br>

    <article>
        <form action="add_order.php" method="post" onsubmit="disableButton()" enctype="multipart/form-data">
            <?php 

                if(isset($_GET['error'])){
                    $box_id = $_GET['box_id'];
                    echo"<h1>Something goes wrong. Try again</h1><br>";
                    echo'<a href="index.php?box_id='.$box_id.'" style="padding: 15px; border: 3px red solid;text-decoration: none; color: white; background-color: red">BACK HOME</a>';
                }else if(isset($_GET['box_id'])){
                    $box_id = $_GET['box_id'];
                    echo"<h1>Box: $box_id </h1>";
                      
            ?>

                <div class="form-row">
                    <input type="text" name="box_id" value="<?php echo $box_id; ?>" style="display: none;">
                    <input class="form-input" type="text" name="name" required placeholder="NOMBRE *">
                    <input class="form-input" type="email" name="email" required placeholder="EMAIL *">
                    <input class="form-input" type="text" pattern="[0-9]{9}" name="tel" placeholder="TELÉFONO">
                </div>

                <div class="form-row">
                    <div class="foto-input input-70">
                        <label for="file-input" class="custom-file-input">
                            <input type="file" name="photo" id="file-input" accept=".jpg, .jpeg, .png" onchange="updateFileName(this)">
                            <span id="file-name">Upload picture</span>
                        </label>
                        
                    </div>

                    <select name="service" id="service" class="form-input input-25" type="text" name="service" placeholder="SERVICIOS">
                        <option value="Kite">Kite</option>
                        <option value="Wing">Wing</option>
                    </select>   
                </div>

                <div class="form-row">
                    <textarea class="form-textarea" name="message" rows="6" required placeholder="MENSAJE *"></textarea>
                </div>

                <div class="form-row form-submit">
                    <input id="myButton" type="submit" value="SUBMIT">
                </div>
            </form>
        <?php 
            }else{
                echo"<h1><center>There is no box selected. <br> Scan qr code form box. :)</center></h1>";
            }
        ?>
    </article>

    <script>
        function disableButton() {
            var button = document.getElementById("myButton");
            button.disabled = true;
            button.value = "Sending...";
        }

        function updateFileName(input) {
            const fileNameField = document.getElementById('file-name');
            const fileName = input.files[0].name;

            if (fileName) {
                fileNameField.classList.add("selected");
                fileNameField.textContent = fileName;
                
            } else {
                fileNameField.classList.add("selected");
                fileNameField.textContent = 'Upload photo';
            }
        }
    </script>
</body>
</html>