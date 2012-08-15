
<div class="container">
	<div class="row">
		<div class="span12">
			This is the Example Controller! <br/>
			<?php //print_r($validation_errors); ?>
			<?php

			echo '<br/>';
			
			foreach($presenter->data as $key => $item)
			{
				echo $presenter->title($key);
				echo '<br/>';
				echo $presenter->body($key);
				echo '<br/>';
				echo '--'.$presenter->user_name($key);
				echo '<hr/>';
			}

			?>
		</div>
	</div>
</div>