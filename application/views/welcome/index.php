<div class="container">
	<div class="row">
		<div class="span12">
			This is the welcome index

			<?php

			echo '<br/>';
			echo $temp->name();
			echo '<br/>';
			echo $temp->email();



			$data = array(
				'test1',
				'test2',
				'test3',
			);

			echo partial('test', $data, TRUE);

			?>
		</div>
	</div>
</div>