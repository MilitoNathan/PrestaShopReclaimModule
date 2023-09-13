<div id='reclamations_block_home' class='block'>
    <h4>{l s='Réclamations' d='Modules.Reclamations'}</h4>
    <div class="block_content">
        <a href="{$page_link}">
            {if isset($page_name) && $page_name}
                {$page_name}
            {else}
                Votre lien
            {/if}
        </a>
    </div>
</div>