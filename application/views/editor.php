<!DOCTYPE html>
<html>
<head>
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<form action='<?=base_url("backend/guardar_editor");?>' method="post">
  <textarea name='txt_editor'>Easy! You should check out MoxieManager!</textarea>
  <input type='submit' value='test' />
  </form>
</body>
</html>