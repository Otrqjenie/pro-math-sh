<?php 
if (!defined('proverka')) {
	die();
};
// echo "hello";
// echo "Привет!";

 ?>
<div id="tab">
	<div id="oge" class="tab" <? if ($_SESSION['razdel'] == "oge") {
		echo "style='background-color:red'";
	}; ?>
		>
		<p>ОГЭ</p>
	</div>

	<div id="ege" class="tab" <? if ($_SESSION['razdel'] == "ege") {
		echo "style='background-color:red'";
	}; ?>
		>
		<p>ЕГЭ</p>
	</div>
	<div id="sh_f" class="tab" <? if ($_SESSION['razdel'] == "sh_f") {
		echo "style='background-color:red'";
	}; ?>
		>
		<p>ШК_св</p>
	</div>
	<div id="U_f" class="tab" <? if ($_SESSION['razdel'] == "U_f") {
		echo "style='background-color:red'";
	}; ?>
		>
		<p>ВУЗ</p>
	</div>
</div>
<div id="cont">
	<div id="panel">
		<div class="panel_in" id="panel_in1">
			<p> <b>Создать игру</b>
			</p>
		</div>
		<div class="panel_in" id="panel_in2">
			<p> <b>Пригласить друга</b>
			</p>
		</div>
		<div class="panel_in2" id="panel_in3">
			<p>
				<b>Параметры</p></b> 
		</div>

	</div>
	<div id="box">
		<table id="players">
			<thead id="thead">
				<tr>
					<th width="230">Игрок</th>
					<th>Опыт</th>
					<th>Время</th>

				</tr>
			</thead>
			<tbody id="t_body">

				<?
				$r = $db->prepare('SELECT user_param.id, user_param.nik, user_param.count, fight.duration FROM user_param, fight WHERE fight.status = ? and fight.id_priglos = user_param.id ');
				$i = 0;
				$r->bind_param('i', $i);
				$r->execute();
				$r->bind_result($id, $nik, $count, $duration);
				while ($r->fetch()) {
								
							
				 ?>
				<tr class="pr_f" onmousedown="go_f(<?=$id;?>)">

					<th >
						<?=$nik; ?></th>
					<th>
						<?=$count; ?></th>
					<th >
						<?=$duration;  ?></th>

				</tr>
				<?
				};
				 $r->close();
				 ?>
			</tbody>
		</table>
	</div>
	<div id="create">
		<div id="polosa">
			<div id="zaglavie">
				<div id="v_boy">
					<p>
						<b>В бой!</b>
					</p>
				</div>
			</div>
			<div id="backward"></div>
		</div>
		<div id="forma">

			<form action="" class="arena-form">

				<div class="vvod" id="vvod1">
					<div id="pp">Время на бой:</div>
					<div id="minuti_val"></div>
					<div id="input_m">
						<input id="minuti" type="range" min="5" max="180" step="5" value="30"></div>
				</div>

				<div id="go">
					<input type="button" name="go" value="Готов!"  id="new_f"></div>

				<!-- <div class="vvod" id="vvod2">
				<p>Максималь опыт противника</p>
				<input type="range" min="0" max="2000" step="100" value="100" ></div>
			-->
			<!-- <input type="text" name="" id="">--></form>

	</div>
</div>
<div id="panel2">
	<div class="panel_in2" id="panel_in4">
		<p>
			<b>Приняли игру</b>
		</p>
	</div>
	<div id="panel_in2_box">
		
	</div>
	
</div>

</div>