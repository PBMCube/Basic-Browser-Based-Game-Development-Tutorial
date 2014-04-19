{include file="global_header.tpl"}

<h4>Item shop</h4>

{foreach from = $items key = item_id item = item}
  {if $item.price}
    <div class="media">
      <a class="pull-left" href="#">
        <img class="media-object" src="layout/images/items/{$item.image}">
      </a>
      <div class="media-body">
        <h4 class="media-heading">{$item.name}</h4>
        {$item.description}
        <form method="post">
          <input type="hidden" name="buy" value="{$item_id}"/>
          <input type="submit" value="Buy" class="btn btn-success"/>
        </form>
      </div> 
    </div>
  {/if}
{/foreach}

{include file="global_footer.tpl"}