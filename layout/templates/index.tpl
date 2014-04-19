{include file="global_header.tpl"}

<h4>Welcome, {$player.username}!</h4>
<div class="panel panel-default">
  <div class="panel-body">
    <span class="glyphicon glyphicon-tower"></span> Level {$player.level}
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <span class="glyphicon glyphicon-star-empty"></span> Experience {$player.exp}/{$player.expNext}
    <div class="progress progress-striped active">
      <div class="progress-bar progress-bar-info" role="progressbar" style="width: {$player.exp/($player.expNext/100)}%">
      </div>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
    <span class="glyphicon glyphicon-heart"></span> Health {$player.health}/{$player.maxHealth}
    <div class="progress progress-striped active">
      <div class="progress-bar progress-bar-danger" role="progressbar" style="width: {$player.health/($player.maxHealth/100)}%">
      </div>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
    <span class="glyphicon glyphicon-flash"></span> Energy {$player.energy}/{$player.maxEnergy}
    <div class="progress progress-striped active">
      <div class="progress-bar progress-bar-success" role="progressbar" style="width: {$player.energy/($player.maxEnergy/100)}%">
      </div>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
    <span class="glyphicon glyphicon-fire"></span> STR {$player.str}
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
   <span class="glyphicon glyphicon-eye-open"></span> DEX {$player.dex}
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <span class="glyphicon glyphicon-user"></span> INT {$player.int}
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
    <span class="glyphicon glyphicon-euro"></span> Money {$player.money|number_format} currency
  </div>
</div>

<div class="media">
  {if $player.pet}
    <a class="pull-left" href="#">
      <img class="media-object" src="layout/images/items/{$player.pet.image}">
    </a>
    <div class="media-body">
      <h4 class="media-heading">{$player.pet.name}</h4>
      {$player.pet.description}
    </div>
  {else}
    <div class="media-body">
      <h4 class="media-heading">No pet :(</h4>
    </div>
  {/if}  
</div>

{include file="global_footer.tpl"}