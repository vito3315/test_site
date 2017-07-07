<?
	$data['page_list'] = $site->get_query_list('SELECT p.is_show, p.id, p.name, c.name cat_name, p.alias, p.title, p.description, p.h1 FROM pages p LEFT JOIN category c ON p.query=c.id');
?>

<h1>Список страниц</h1>
<table class="ui celled table hover" id="page_list">
	<thead style="background-color: #ffffff;">
		<tr>
			<th>#</th>
			<th>Название страницы</th>
			<th>Категория</th>
			<th>Заголовок (H1)</th>
			<th>Заголовок (title)</th>
			<th>Описание (description)</th>
			<th><i class="fa fa-eye fa-2x" aria-hidden="true"></i></th>
		</tr>
	</thead>
	<tbody>
		<?foreach($data['page_list'] as $page){?>
			<tr>
				<td><?=$page['id']?></td>
				<td><a href="/admin/modules/page_edit/?/<?=$page['id']?>"><?=$page['name']?></a></td>
				<td><?=$page['cat_name']?></td>
				<td><?=$page['h1']?></td>
				<td><?=$page['title']?></td>
				<td style="width: 30%;"><?=$page['description']?></td>
				<td><i class="fa <?=$page['is_show']==1?'fa-eye':'fa-eye-slash'?> fa-2x" aria-hidden="true"></i></td>
			</tr>
		<?}?>	
			
	</tbody>
</table>

<script>
	$( document ).ready(function() {
		//$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		$('#page_list').DataTable( {
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
			}
		} );
	});
</script>