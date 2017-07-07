<html>
<head>
<title>Выбор файла</title>
<style>
.img_list {
}
.img_list a {
	display:inline-block;
	position:relative;
	text-align:center;
	width:200px;
	height:200px;
	border:1px solid #ccc;
	vertical-align:middle;
	margin:0 5px 5px 0;
}
.img_list a img{
	max-width:200px;
	max-height:200px;
}
.img_list a div{
	position:absolute;
	background:rgba(255,255,255,0.5);
	color:#000;
	bottom:0;
	width:100%;
}

</style>
</head>
<body>
<div class="img_list">
<?php


$srcdir = '/img/other_mages/'; // папка c картинкам
$full_path = '';

$dir = $_SERVER['DOCUMENT_ROOT'].$srcdir;

$files = array();
if($DP = opendir($dir)){
	while($file = readdir($DP)){
		if(is_file($dir.'/'.$file)/* && ($is = @getimagesize($f)) && isset($images_exts[$is[2]])*/){
			$f = $dir.'/'.$file;
			$is = @getimagesize($f);
			$src = htmlspecialchars($srcdir.'/'.$file, ENT_QUOTES);
			printf('<a href="%s" onclick="selectFile(this)" title="%s"><img src="%s"><div>%ux%u</div></a>', $src, htmlspecialchars($file, ENT_QUOTES), $src, $is[0], $is[1]);
		
		}
	}
	closedir($DP);
}

?>
</div>
<script>
function selectFile(a){
	window.opener.CKEDITOR.tools.callFunction(<?=$_GET['CKEditorFuncNum']?>, a.href, "" );
	self.close();
}
</script>
</body>
</html>