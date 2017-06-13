<?php 
//$detail = $_GET['detail'];

session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '120783235172145',
  'app_secret' => '2af58b7080bcb06278ad922a787f27a2',
  'default_graph_version' => 'v2.5',
  ]);

$helper = $fb->getRedirectLoginHelper();

$accessToken = $_SESSION['facebook_access_token'];

$permissions = ['email','publish_actions','user_photos']; // optional
 $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);



$id = $_GET['id'];
$name = $_GET['name'];

 $photos_original = $fb->get("/$id/photos?fields=images", $accessToken)->getGraphEdge()->asArray();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>rtCamp | Slide Show</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 80%;
      margin: auto;
      background:no-repeat center fixed; 
      background-size: cover; 
  }

  .carousel{
    height: 100%;
    width: 100%;
  }

  .carousel-control{
    background: none;
  }

  .title{
    width: 100%;
    height:45px;
    color: white;
    font-size: 18px;
    padding-left: 25px;
    padding-top: 10px;
    background-color: #3b5998; 
  }

  .carousel-indicators{
    margin-bottom: 100px;
  }
  </style>
</head>
<body>
<div class="title">
    <?php echo $name; ?>
  </div>
<div class="container">
  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <?php
      $len = count($photos_original);
      for($i=1;$i<$len-1;$i++)
      {
        echo "<li data-target='#myCarousel' data-slide-to=".$i."> </li> ";
      }
      ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      
<?php
for($i=0;$i<$len;$i++)
{
    echo "<div class='item' style='background-repeat: no-repeat; background-position:center; '>";
    echo "<img src='".$photos_original[$i]['images'][0]['source']."' class='img-responsive' alt='temp' width='460' height='345'/> ";
    echo "</div>";

}

?>

       
   </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
<script type="text/javascript">
  

  $('#myCarousel').carousel({
  interval: 3000,
  cycle: true
  });

  var $item = $('.carousel .item'); 
var $wHeight = $(window).height();
$item.eq(0).addClass('active');
$item.height($wHeight); 
$item.addClass('full-screen');

$('.carousel img').each(function() {
  var $src = $(this).attr('src');
  var $color = $(this).attr('data-color');
  $(this).parent().css({
    'background-image' : 'url(' + $src + ')',
    'background-color' : $color
  });
  $(this).remove();
});

$(window).on('resize', function (){
  $wHeight = $(window).height();
  $item.height($wHeight);
});
/*
$('.carousel').carousel({
  interval: 6000,
  pause: "false"
});*/
</script>
</body>
</html>