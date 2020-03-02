<div class="crm-block">

  {* identifier id *}
  {if $identifier}
    <div class="crm-section">
      <p>Unomi identifier: <strong>{$identifier}</strong></p>
    </div>
  {/if}

  {* data *}
  {foreach from=$data item=elementName}
    <div class="crm-section">
      <pre>{$elementName}</pre>
    </div>
  {/foreach}

</div>
