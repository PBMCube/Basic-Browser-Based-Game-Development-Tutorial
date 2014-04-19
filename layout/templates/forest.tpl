{include file="global_header.tpl"}

<h3>{$map.name}</h3>
<p><img src="layout/images/maps/{$map.image}"/></p>

{if $monster}
  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object" src="layout/images/monsters/{$monster.image}">
    </a>
    <div class="media-body">
      <h4 class="media-heading">{$monster.name}</h4>
      <p>{$monster.strength} strength</p>
      <p>{$monster.defense} defense</p>
      {if $report}
        <div class="panel panel-default">
          <div class="panel-body">
            {$report}
          </div>
        </div>
      {else}
        <form method="post">
          <input type="submit" name="fight" value="Fight" class="btn btn-danger"/>
        </form>
      {/if}
    </div>
  </div>
  <br/><br/>
{/if}


<form method="post">
  <input type="submit" name="explore" value="Explore" class="btn btn-success"/>
</form>

{include file="global_footer.tpl"}