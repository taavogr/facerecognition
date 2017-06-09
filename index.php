<?php
function miniAPIPost($foto){
  $url ="https://gateway-a.watsonplatform.net/visual-recognition/api/v3/detect_faces?api_key=ac57d8e24ea830f5f2af0b1074d9670e323842b6&version=2016-05-20";

  $tmpfile = $foto['tmp_name'];
  $filename = basename($foto['name']);
  $data = array(
	'images_file' => '@'.$tmpfile.';filename='.$filename,
  );

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $result = curl_exec($ch);
  curl_close($ch);

  return json_decode($result, true);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Detector de Rostros v1.0</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="style.css" />
	<!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<?php
if( isset($_POST["submit"]) ){
    $asd = miniAPIPost($_FILES["foto"]);
    $asdf = miniAPIPost($_FILES["foto"]);
    $resultado = $asd['images'][0]["image"][0];
    $resultados = $asdf['images']["faces"];
?>
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
    <h1 class="header center red-text text-darken-2"> Resultados de los rostros detectados</h1>
    <br><br>
        
    <table class="center striped">
    <tr>
      <th>Edad</th>
      <th>Género</th>
      <th>Identidad</th>
    </tr>

    <?php for($i = 0; $i < count($asdf['images'][0]["faces"]); $i++){ ?>
    <tr>

        <?php $result = $asdf['images'][0]["faces"][$i]; ?>
        <td><?php echo $result['age']["min"]; ?>-<?php echo $result['age']["max"]; ?> (score: <?php echo $result['age']["score"]; ?>)</td>
        <td><?php echo $result['gender']["gender"]; ?> (score: <?php echo $result['gender']["score"]; ?>)</td>
        <td><?php echo $result['identity']["name"]; ?> (score: <?php echo $result['identity']["score"]; ?>)</td>



    </tr>
    <?php } ?>
    
 </table>
 </div>
 
     <div class="section">

    </div>
 </div>

<?php }else{ ?>
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
    <h1 class="header center red-text text-darken-2"> Selecciona o arrastra tu imagen</h1>
    <br><br>
    <form class="center" action="" method="post" enctype="multipart/form-data">
    <div id="filediv"><input name="foto" type="file" id="file"/></div>
    <br><br>
    <button class="btn waves-effect waves-light red" type="submit" name="submit">Analizar</button>
    </form>
    </div>
<?php } ?>
    <div class="section">

    </div>
</div>

<footer class="page-footer red">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Detector de Rostros</h5>
          <p class="grey-text text-lighten-4">Applicación que detecta los rostros de una imagen usando el API Visual Recognition IBM</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="https://www.ibm.com/cloud-computing/bluemix/">BLUEMIX</a></li>
            <li><a class="white-text" href="https://www.ibm.com/watson/developercloud/doc/visual-recognition/index.html">Visual Recognition Watson</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="red-text text-lighten-3" href="https://www.linkedin.com/in/gustavo-retamozo-falcon-411583112/">Gustavo Retamozo</a>
      </div>
    </div>
  </footer>
</body>
</html>