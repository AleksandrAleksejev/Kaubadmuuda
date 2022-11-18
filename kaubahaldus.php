<?php
  require("abifunktsioonid.php");


  $sorttulp="nimetus";
  $otsisona="";
  if(isset($_REQUEST["sorttulp"])){
      $sorttulp=$_REQUEST["sorttulp"];
  }



  if(isSet($_REQUEST["grupilisamine"]) && ! empty($_REQUEST["uuegrupinimi"])){
    lisaGrupp($_REQUEST["uuegrupinimi"]);
    header("Location: kaubahaldus.php");
    exit();
  }
  if(isSet($_REQUEST["kaubalisamine"]) && ! empty($_REQUEST["nimetus"]) && ! empty($_REQUEST["hind"])){
    lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
    header("Location: kaubahaldus.php");
    exit();
  }
  if(isSet($_REQUEST["kustutusid"])){
     kustutaKaup($_REQUEST["kustutusid"]);
  }
  if(isSet($_REQUEST["muutmine"])){
     muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"],
                              $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
  }
  $kaubad=kysiKaupadeAndmed();
?>
<!DOCTYPE html >
<html >
  <head>
      <title>Kaupade leht</title>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <style>
          table{
              border: 3pt solid black;
              background-color: mediumpurple;
              border-collapse: separate;
          }
          th, td{
              border: 1pt solid black;
              padding:48px;



          }
          div#menu{
              padding:60px;
              float:left;
              border-radius: 0px;
              background-color: mediumpurple;
              border: 3pt solid black;
              text-decoration: none;

          }
          div#sisu{

              padding:20px;
              float:left;
              margin-left: 1%;
              background-color: mediumpurple;
              border: solid 3px black;

          }


      </style>
  </head>
  <body>
  <form action="kaubahaldus.php" >
      <h2>Kaupade loetelu</h2>
      <table >
          <tr>
              <th>Haldus</th>
              <th><a href="kaubahaldus.php?sorttulp=nimetus">Nimetus</a></th>
              <th><a href="kaubahaldus.php?sorttulp=gruppinimi">Kaubagrupp</a></th>
              <th><a href="kaubahaldus.php?sorttulp=hind">Hind</a></th>
          </tr>
          <?php foreach($kaubad as $kaup): ?>
              <tr>
                  <?php if(isSet($_REQUEST["muutmisid"]) &&
                      intval($_REQUEST["muutmisid"])==$kaup->id): ?>
                      <td>
                          <input type="submit" name="muutmine" value="Muuda" />
                          <input type="submit" name="katkestus" value="Katkesta" />
                          <input type="hidden" name="muudetudid" value="<?=$kaup->id ?>" />
                      </td>
                      <td><input type="text" name="nimetus" value="<?=$kaup->nimetus ?>" /></td>
                      <td><?php
                          echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid",
                              "kaubagrupi_id", $kaup->kaubagrupi_id);
                          ?></td>
                      <td><input type="text" name="hind" value="<?=$kaup->hind ?>" /></td>
                  <?php else: ?>
                      <td><a href="kaubahaldus.php?kustutusid=<?=$kaup->id ?>"
                             onclick="return confirm('Kas ikka soovid kustutada?')">x</a>
                          <a href="kaubahaldus.php?muutmisid=<?=$kaup->id ?>">m</a>
                      </td>
                      <td><?=$kaup->nimetus ?></td>
                      <td><?=$kaup->grupinimi ?></td>
                      <td><?=$kaup->hind ?></td>
                  <?php endif ?>
              </tr>
          <?php endforeach; ?>
      </table>
  </form>
   <form action="kaubahaldus.php">
       <div id="menu"
     <h2>Kauba lisamine</h2>

       <h2>Nimetus:</h2>
       <dd><input type="text" name="nimetus" /></dd>
       <h2>Kaubagrupp:</h2>
       <dd><?php
         echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", 
                           "kaubagrupi_id");
       ?>
       </dd>
       <h2>Hind:</h2>
       <input type="text" name="hind" />
       <input type="submit" name="kaubalisamine" value="Lisa kaup" />
     </div>
         <div id="sisu">
            <h2>Grupi lisamine</h2>
            <input type="text" name="uuegrupinimi" />
            <input type="submit" name="grupilisamine" value="Lisa grupp" />
   </form>
  </div>
  </body>
</html>
