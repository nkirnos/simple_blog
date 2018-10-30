
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/blog.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/js/trumbowyg/ui/trumbowyg.min.css">
  </head>

  <body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="/">На главную</a>
          
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">The Bootstrap Blog</h1>
        <p class="lead blog-description">Тестовое задание мини-блог</p>
      </div>

      <div class="row">

        <div class="col-sm-12">
        <form id='new_post'>
          <input type='hidden' id='id' value="<?=$post->id?>">
          <div class="form-group">
            <label for="inputTitle">Заголовок</label>
            <input type="text" class="form-control" id="inputTitle" placeholder="Заголовок поста" value="<?=$post->title?>">
          </div>
          <div class="form-group">
            <label for="inputUrl">Ссылка на картинку</label>
            <input type="text" class="form-control" id="inputUrl" placeholder="Ссылка на картинку" value="<?=$post->img_path?>">
          </div>
          
          <div class="form-group">
            <label for="exampleInputFile">Загрузить картинку</label>
            <input type="file" id="InputFile">
            <p class="help-block">Загруженное изображение перезапишет поле с ссылкой на картинку</p>
          </div>
          <div class="form-group">
            <textarea class="form-control" id='html' rows="10" placeholder="Текст поста"><?=$post->html?></textarea>
          </div>
          
          <button type="button" class="btn btn-default" id='submit'>Сохранить</button>
        </form>
        </div>

      </div><!-- /.row -->

    </div><!-- /.container -->

    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
    <script src="/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
    <script src="/js/trumbowyg/trumbowyg.min.js"></script>
    <script>
      $(function() {
        $('#html').trumbowyg();
        $('form#new_post button#submit').click(function(){
          var file_data = $('#InputFile').prop('files')[0];   
          var form_data = new FormData(); 
          if(typeof file_data != 'undefined'){
            form_data.append('file', file_data);
          }
          form_data.append('id', $('#id').val());
          form_data.append('title', $('#inputTitle').val());
          form_data.append('url', $('#inputUrl').val());
          form_data.append('html', $('#html').val());
          $.ajax({
            url: '/posts',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(data){
                if(data.id !== undefined) {
                  $('#id').val(data.id);
                } 
                alert('Сохранено');
            }
          });
        });
      });
    </script>
  </body>
</html>
