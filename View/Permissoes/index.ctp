<h2><?php echo __('Permissões de Acesso')?></h2>


<table class="table table-condensed table-bordered table-hover">
	<thead>
		<tr>
			<th></th>
			<?php foreach($grupos as $grupo){?>
				<th><?php echo ($grupo['Aro']['alias']);?></th>
			<?php }?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($reqs as $key=>$item){?>
			<tr>
				<td><?php
				echo $item;?></td>
				<?php foreach($grupos as $grupo){?>
					<td><?php if($permissions[$grupo['Aro']['id']][$item]){
						echo '<span class="glyphicons ok_2" style="color: green"></span>';
						echo $this->Html->link(
							'<span class="glyphicons refresh" style="color: blue"></span>',
							array('plugin'=>'acl_view', 'controller'=>'Permissoes', 'action'=>'alterar', $grupo['Aro']['alias'], $key),
							array('class'=>'btn btn-default btn-xs pull-right', 'escape'=>false, 'title'=>__('Alterar Permissão'))
						);
					}
					else{
						echo '<span class="glyphicons remove_2" style="color: red"></span>';
						echo $this->Html->link(
								'<span class="glyphicons refresh" style="color: blue"></span>',
								array('plugin'=>'acl_view', 'controller'=>'Permissoes', 'action'=>'alterar', $grupo['Aro']['alias'], $key),
								array('class'=>'btn btn-default btn-xs pull-right', 'escape'=>false, 'title'=>__('Alterar Permissão'))
						);
					}?></td>
				<?php }?>
			</tr>
		<?php }?>
	</tbody>
</table>