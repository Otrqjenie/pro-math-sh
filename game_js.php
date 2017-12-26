<?php
if (!defined('proverka')) {
	die();
};
// require_once "connect2.php";
// require_once "lib/request.php";
?>
<div id="tab">
	<div id="oge" class="tab" <? if ($_SESSION['razdel'] == "oge") {
		echo "style='background-color:red'";
	}; ?>>
		<p>ОГЭ</p>
	</div>

	<div id="ege" class="tab"<? if ($_SESSION['razdel'] == "ege") {
		echo "style='background-color:red'";
	}; ?>>
		<p>ЕГЭ</p>
	</div>
	<div id="sh_f" class="tab"<? if ($_SESSION['razdel'] == "sh_f") {
		echo "style='background-color:red'";
	}; ?>>
		<p>ШК_св</p>
	</div>
	<div id="U_f" class="tab"<? if ($_SESSION['razdel'] == "U_f") {
		echo "style='background-color:red'";
	}; ?>>
		<p>ВУЗ</p>
	</div>
</div>
<div align  = "center">

	<div id="imya">
		<p>
			<?=htmlspecialchars($_SESSION['imya'])?>
			&nbsp;
			<?=htmlspecialchars($_SESSION['familiya'])?>
			<a href="<?=$_SERVER['SCRIPT_NAME']?>?statist=1">(Статистика)</a>
		</p>
	</div>

	<div id="shield_cont">
		<div>
			<p>Щит</p>
		</div>
		<div id = "shield">
			<div id="sh1" <?php if ($_SESSION['razdel'] !== "oge"){echo "style = display:none";} else{echo "style = display:block";}; ?>>
			<?
			// переделать запрос
						$shield4 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z 
							ON s.id_zsh = z.id
							WHERE s.id_user = ? and z.razdel = ? ORDER BY id_zsh
							 ");
						$oge = "oge";
						$shield4->bind_param('is', $_SESSION['id'], $oge);
						$shield4->execute();
						$shield4->bind_result($id_rz, $nazvanie);
						$m = "";
						while ($shield4->fetch()) {
							$m = $m."
			<p>
				<span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie."</span>
				<span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span>
			</p>
			";
						};
						if ($m == "") {
							echo "Щит пуст!";
						}
						else{
							echo $m;
						};
						
						$shield4->close();
					?>
			</div>
			<div id="sh2" <?php if ($_SESSION['razdel'] !== "ege"){echo "style = display:none";} else{echo "style = display:block";}; ?> >
				<?
							$shield4 = $db->
				prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z 
							ON s.id_zsh = z.id
							WHERE s.id_user = ? and z.razdel = ? ORDER BY id_zsh
							");
							$ege = "ege";
							$shield4->bind_param('is', $_SESSION['id'], $ege);
							$shield4->execute();
							$shield4->bind_result($id_rz, $nazvanie);
							$m = "";
							while ($shield4->fetch()) {
								$m = $m."
				<p>
					<span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie."</span>
					<span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span>
				</p>
				";
							};
							if ($m == "") {
								echo "Щит пуст!";
							}
							else{
								echo $m;
							};
							$shield4->close();
						?>
			</div>
			<div id="sh3" <?php if ($_SESSION['razdel'] !== "sh_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>
				<?
							$shield4 = $db->
				prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z 
							ON s.id_zsh = z.id
							WHERE s.id_user = ? and z.razdel = ? ORDER BY id_zsh
							");
							$sh_f = "sh_f";
							$shield4->bind_param('is', $_SESSION['id'], $sh_f);
							$shield4->execute();
							$shield4->bind_result($id_rz, $nazvanie);
							$m = "";
							while ($shield4->fetch()) {
								$m = $m."
				<p>
					<span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie."</span>
					<span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span>
				</p>
				";
							};
							if ($m == "") {
								echo "Щит пуст!";
							}
							else{
								echo $m;
							};
							$shield4->close();
						?>
			</div>
			<div id="sh4" <?php if ($_SESSION['razdel'] !== "U_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>
				<?
							$shield4 = $db->
				prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z 
							ON s.id_zsh = z.id
							WHERE s.id_user = ? and z.razdel = ? ORDER BY id_zsh");
							$U_f = "U_f";
							$shield4->bind_param('is', $_SESSION['id'], $U_f);
							$shield4->execute();
							$shield4->bind_result($id_rz, $nazvanie);
							$m = "";
							while ($shield4->fetch()) {
								$m = $m."
				<p>
					<span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie."</span>
					<span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span>
				</p>
				";
							};
							if ($m == "") {
								echo "Щит пуст!";
							}
							else{
								echo $m;
							};
							$shield4->close();
						?>
			</div>
		</div>
	</div>
	<div id="arsenal">
		<p>Арсенал</p>
		<p id="go">
			Попап
		</p>
		<div id="ars1" <?php if ($_SESSION['razdel'] !== "oge"){echo "style = display:none";} else{echo "style = display:block";} ?>>
		
		<select name = "type2">
			<option>Выберите тип задачи</option>
			<option value = "Числа_и_вычисления">Числа_и_вычисления</option>
			<option value = "Алгебраические_выражения">Алгебраические_выражения</option>
			<option value = "Уравнения_и_неравенства">Уравнения_и_неравенства</option>
			<option value = "Числовые_последовательности">Числовые_последовательности</option>
			<option value = "Функции">Функции</option>
			<option value = "Координаты_на_прямой_и_плоскости">Координаты_на_прямой_и_плоскости</option>
			<option value = "Геометрия">Геометрия</option>
			<option value = "Статистика_и_теория_вероятности">Статистика_и_теория_вероятности</option>

		</select>
		<div id="list2" ></div>
		</div>
		<div id="ars2" class="ars" <?php if ($_SESSION['razdel'] !== "ege"){echo "style = display:none";} else{echo "style = display:block";}; ?>>1
			<div id="ars2_list"></div>
		</div>
		<div id="ars3" class="ars" <?php if ($_SESSION['razdel'] !== "sh_f"){echo "style = display:none";}  else{echo "style = display:block";};?>>2
			<div id="ars3_list"></div>
		</div>
		<div id="ars4" class="ars" <?php if ($_SESSION['razdel'] !== "U_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>3
			<div id="ars4_list"></div>
		</div>
	</div>
	<div id="text_z">
		
	</div>
	
	<div id="baza">
		
		<label>Тип задачи:</label>
		<br>
		<div id="baza1" <?php if ($_SESSION['razdel'] !== "oge"){echo "style = display:none";} else{echo "style = display:block";}; ?>>
		<select name = "type">
			<option>Выберите тип задачи</option>
			<option value = "Числа_и_вычисления">Числа_и_вычисления</option>
			<option value = "Алгебраические_выражения">Алгебраические_выражения</option>
			<option value = "Уравнения_и_неравенства">Уравнения_и_неравенства</option>
			<option value = "Числовые_последовательности">Числовые_последовательности</option>
			<option value = "Функции">Функции</option>
			<option value = "Координаты_на_прямой_и_плоскости">Координаты_на_прямой_и_плоскости</option>
			<option value = "Геометрия">Геометрия</option>
			<option value = "Статистика_и_теория_вероятности">Статистика_и_теория_вероятности</option>
		</select>
		<div id="list"></div>
		</div>
		<div id="baza2" class="baza" <?php if ($_SESSION['razdel'] !== "ege"){echo "style = display:none";} else{echo "style = display:block";}; ?>>2<div id="list2"></div></div>
		<div id="baza3" class="baza" <?php if ($_SESSION['razdel'] !== "sh_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>3<div id="list3"></div></div>
		<div id="baza4" class="baza" <?php if ($_SESSION['razdel'] !== "U_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>4<div id="list4"></div></div>
	</div>

</div>
<div class = "popup_fast">
	<div id="head_popup">
		
	</div>
	<div id="baza_popup">
		
	</div>
</div>
<div id="met"></div>