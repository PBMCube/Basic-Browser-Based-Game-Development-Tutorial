{include file="global_header.tpl"}

<h3>Equipment</h3>

<h4>First weapon</h4>
{if $player.firstWeapon}
  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object" src="layout/images/items/{$player.firstWeapon.image}">
    </a>
    <div class="media-body">
      <h4 class="media-heading">{$player.firstWeapon.name}</h4>
      {$player.firstWeapon.description}
    </div>
  </div>
{else}Nothing{/if}

<h4>Second weapon</h4>
{if $player.secondWeapon}
  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object" src="layout/images/items/{$player.secondWeapon.image}">
    </a>
    <div class="media-body">
      <h4 class="media-heading">{$player.secondWeapon.name}</h4>
      {$player.secondWeapon.description}
    </div>
  </div>
{else}Nothing{/if}

<h4>Helmet</h4>
{if $player.helmet}
  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object" src="layout/images/items/{$player.helmet.image}">
    </a>
    <div class="media-body">
      <h4 class="media-heading">{$player.helmet.name}</h4>
      {$player.helmet.description}
    </div>
  </div>
{else}Nothing{/if}

<h4>Armour</h4>
{if $player.armour}
  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object" src="layout/images/items/{$player.armour.image}">
    </a>
    <div class="media-body">
      <h4 class="media-heading">{$player.armour.name}</h4>
      {$player.armour.description}
    </div>
  </div>
{else}Nothing{/if}

<h4>Gloves</h4>
{if $player.gloves}
  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object" src="layout/images/items/{$player.gloves.image}">
    </a>
    <div class="media-body">
      <h4 class="media-heading">{$player.gloves.name}</h4>
      {$player.gloves.description}
    </div>
  </div>
{else}Nothing{/if}

<h4>Boots</h4>
{if $player.boots}
  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object" src="layout/images/items/{$player.boots.image}">
    </a>
    <div class="media-body">
      <h4 class="media-heading">{$player.boots.name}</h4>
      {$player.boots.description}
    </div>
  </div>
{else}Nothing{/if}

<hr/>
<h3>Items</h3>

<ul class="media-list">
  {foreach from = $warehouse item = item}
    <li class="media">
      <a class="pull-left" href="#">
        <img class="media-object" src="layout/images/items/{$items[$item.item_id].image}">
      </a>
      <div class="media-body">
        <h4 class="media-heading">{$items[$item.item_id].name} X {$item.quantity}</h4>
        <p>{$items[$item.item_id].description}</p>
        <form method="post">
          {if $items[$item.item_id]["wearable"]}
            <input type="hidden" name="wear" value="{$item.item_id}"/>
            <input type="submit" value="Equip" class="btn btn-primary"/>
          {elseif $items[$item.item_id]["usable"]}
            <input type="hidden" name="use" value="{$item.item_id}"/>
            <input type="submit" value="Use" class="btn btn-primary"/>
          {/if}
        </form>
      </div>
    </li>
    
  {foreachelse}
    <li class="media">
      <div class="media-body">
        <h4 class="media-heading">You don't have any items</h4>
      </div>
    </li>
  {/foreach}
</ul>

{include file="global_footer.tpl"}