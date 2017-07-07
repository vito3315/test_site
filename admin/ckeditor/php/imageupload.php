<?php
/*
	Внимание! Для безопасности надо вставить строки проверки авторизации.
	Они зависят от используемой CMS.
	В противном случае любой посетитель сайта может вам загрузить файлы.
*/
$full_path = ''; // src вставленной картинки для тега <img>
$upload_dir = '/img/other_mages/'; // папка куда сохраняются картинки, должна доступна на запись

// разрешенные форматы графических файлов (см. описание фукнции image_type_to_mime_type
$images_exts = array(
	IMAGETYPE_GIF => 'gif', 
	IMAGETYPE_JPEG => 'jpg',
	IMAGETYPE_PNG => 'png'
);

$dir = $_SERVER['DOCUMENT_ROOT'].$upload_dir;
if(!isset($_FILES['upload']) && !is_uploaded_file($_FILES['upload']['tmp_name'])){
	$message = 'Вы не указали файл для загрузки';
}
else{
	$is = @getimagesize($_FILES['upload']['tmp_name']);
	if(!isset($images_exts[$is[2]])) {
		$message = 'Необходимо указать файл формата '.implode(', ', $images_exts);
	}
	else {
		$name = Transliteration($_FILES['upload']['name']);
		$d = $dir.'/'.$name;
		if(!@move_uploaded_file($_FILES['upload']['tmp_name'], $d)){
			$message = 'Невозможно сохранить файл, проверьте настройки папки для файлов '.$_FILES['upload']['name'];
		}
		else{
			$full_path = $upload_dir.'/'.$name;
			$message = '';
		}
	}
}
?>
<script>
window.parent.CKEDITOR.tools.callFunction(<?=$_GET['CKEditorFuncNum']?>, "<?=$full_path?>", "<?=mysql_real_escape_string(iconv('UTF-8', 'Windows-1251//IGNORE', $message))?>" );
</script>
<?php
function Transliteration($str){
	$transl = array(
	 "А"=>"A", "Б"=>"B", "В"=>"V", "Г"=>"G", "Д"=>"D", "Е"=>"E", "Ё"=>"YO", "Ж"=>"ZH", "З"=>"Z", "И"=>"I", "Й"=>"J", "К"=>"K", "Л"=>"L", "М"=>"M", 
	 "Н"=>"N", "О"=>"O", "П"=>"P", "Р"=>"R", "С"=>"S", "Т"=>"T", "У"=>"U", "Ф"=>"F", "Х"=>"H", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH", "Щ"=>"SCH", "Ь"=>"", 
	 "Ъ"=>"", "Ы"=>"Y", "Э"=>"E", "Ю"=>"YU", "Я"=>"YA", "а"=>"a", "б"=>"b", "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo", "ж"=>"zh", "з"=>"z", 
	 "и"=>"i", "й"=>"j", "к"=>"k", "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p", "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", "х"=>"h",
	 "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch", "ь"=>"", "ъ"=>"", "ы"=>"y", "э"=>"e", "ю"=>"yu", "я"=>"ya"
	);
	return preg_replace("/_+/", "_", strtolower(str_replace(array_keys($transl), array_values($transl), $str)));
}
exit();
?>