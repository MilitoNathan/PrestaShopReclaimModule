{extends file='page.tpl'}

{block name="page_content"}
    <div id="reclamation-form">
        <h1>
        Formulaire de réclamations
        </h1>

        <form method="post" action="{$link->getModuleLink('reclamations', 'display')}" enctype="multipart/form-data">
            <div class='form-container'>
                <input type='text' name="name" class='nomForm classCommune' id='nomForm' placeholder="Nom" required=required>
            </div>

            <div class='form-container'>
                <input type='text' name="firstname" class='prenomForm classCommune' id='prenomForm' placeholder="Prénom" required=required>
            </div>

            <div class='form-container'>
                <input type='email' name="email" class='mailForm' id='mailForm' placeholder="Email" required=required>
            </div>
            
            <div class='form-container'>
                <textarea name="message" class='messageForm' id='messageForm' placeholder="Votre message" required=required></textarea>
            </div>

            <div class="form-container">
                <label for="fileUpload">{l s='Attacher un fichier'}</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                <input type="file" name="document" id="document" />
            </div>

            <div class="form-container">
                <input type='submit' name="submitReclaim" class='envoyerForm' id='envoyerForm' value="Envoyer ma réclamation">
            </div>

        </form>
    </div>
{/block}