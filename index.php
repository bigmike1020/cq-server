<html>
<head>
<title>Mike Senn</title>
<style type="text/css">
img
{
  max-width:200px;
}
</style>
</head>
<body>
<h2>Crowd Questions!</h2>
<p>See our public <a href="https://github.com/bigmike1020/crowdquestions">github repository.</a></p>
<ul id="list">
</ul>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript">

$.getJSON("pictures.php", function(data) {
  var questions = [];
  $.each(data.result, function(key,val) {
    
    questions.push('<li>'+
      '<img src="images/'+val.path+'">'+
      val.user+' asked "'+
      val.question+'"'+
    '</li>');
    
  });
  $('#list').append(questions);
});
</script>
</body>
</html>
