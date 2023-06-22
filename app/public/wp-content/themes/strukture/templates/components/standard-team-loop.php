<?php
$block_grid = forge_var('block-grid');
?>

<section class="standard-team-loop">
  <div class="row row-center">
    <div class="block-grid-<?php echo $block_grid  ?>">


      <?php

      $team_query = (new ForgeQuery)->query('team_member', -1, $args);
      $team_query->loop('templates/loop/team');

      ?>

    </div>
  </div>
</section>
