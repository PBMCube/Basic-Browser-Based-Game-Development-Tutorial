{include file="global_header.tpl"}

<h3>{$profile.username}</h3>
<h4>Level {$profile.level}</h4>

{if $profile.player_id != $player.player_id}

  {if $report}
    <div class="well">
      {$report}
    </div>
  {else}
    <p>
      <form method="post">
        <input type="submit" value="Attack" name="attack" class="btn btn-danger"/>
      </form>
    </p>
  {/if}
{/if}

{include file="global_footer.tpl"}