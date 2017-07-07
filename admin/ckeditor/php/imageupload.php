<?php
/*
	��������! ��� ������������ ���� �������� ������ �������� �����������.
	��� ������� �� ������������ CMS.
	� ��������� ������ ����� ���������� ����� ����� ��� ��������� �����.
*/
$full_path = ''; // src ����������� �������� ��� ���� <img>
$upload_dir = '/img/other_mages/'; // ����� ���� ����������� ��������, ������ �������� �� ������

// ����������� ������� ����������� ������ (��. �������� ������� image_type_to_mime_type
$images_exts = array(
	IMAGETYPE_GIF => 'gif', 
	IMAGETYPE_JPEG => 'jpg',
	IMAGETYPE_PNG => 'png'
);

$dir = $_SERVER['DOCUMENT_ROOT'].$upload_dir;
if(!isset($_FILES['upload']) && !is_uploaded_file($_FILES['upload']['tmp_name'])){
	$message = '�� �� ������� ���� ��� ��������';
}
else{
	$is = @getimagesize($_FILES['upload']['tmp_name']);
	if(!isset($images_exts[$is[2]])) {
		$message = '���������� ������� ���� ������� '.implode(', ', $images_exts);
	}
	else {
		$name = Transliteration($_FILES['upload']['name']);
		$d = $dir.'/'.$name;
		if(!@move_uploaded_file($_FILES['upload']['tmp_name'], $d)){
			$message = '���������� ��������� ����, ��������� ��������� ����� ��� ������ '.$_FILES['upload']['name'];
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
	 "�"=>"A", "�"=>"B", "�"=>"V", "�"=>"G", "�"=>"D", "�"=>"E", "�"=>"YO", "�"=>"ZH", "�"=>"Z", "�"=>"I", "�"=>"J", "�"=>"K", "�"=>"L", "�"=>"M", 
	 "�"=>"N", "�"=>"O", "�"=>"P", "�"=>"R", "�"=>"S", "�"=>"T", "�"=>"U", "�"=>"F", "�"=>"H", "�"=>"TS", "�"=>"CH", "�"=>"SH", "�"=>"SCH", "�"=>"", 
	 "�"=>"", "�"=>"Y", "�"=>"E", "�"=>"YU", "�"=>"YA", "�"=>"a", "�"=>"b", "�"=>"v", "�"=>"g", "�"=>"d", "�"=>"e", "�"=>"yo", "�"=>"zh", "�"=>"z", 
	 "�"=>"i", "�"=>"j", "�"=>"k", "�"=>"l", "�"=>"m", "�"=>"n", "�"=>"o", "�"=>"p", "�"=>"r", "�"=>"s", "�"=>"t", "�"=>"u", "�"=>"f", "�"=>"h",
	 "�"=>"ts", "�"=>"ch", "�"=>"sh", "�"=>"sch", "�"=>"", "�"=>"", "�"=>"y", "�"=>"e", "�"=>"yu", "�"=>"ya"
	);
	return preg_replace("/_+/", "_", strtolower(str_replace(array_keys($transl), array_values($transl), $str)));
}
exit();
?>