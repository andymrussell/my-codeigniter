
<div class="container">
	<div class="row">
		<div class="span12">
			This is the Example Controller! <br/>
			<?php print_r($validation_errors); ?>
			<?php

			echo '<br/>';

			foreach($data as $item)
			{
				echo $item->title;
				echo '<br/>';
				echo $item->body;
				echo '<br/>';
				echo $item->user->name;
				echo '<hr/>';

			}

			?>
		</div>
	</div>
</div>